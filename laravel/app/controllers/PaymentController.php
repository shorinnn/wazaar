<?php

class PaymentController extends BaseController
{

    protected $paymentHelper;


    public function __construct(PaymentHelper $paymentHelper)
    {
        $this->beforeFilter('auth');
        $this->paymentHelper = $paymentHelper;

    }

    public function index()
    {
        if (!Session::has('data')) {
            //return Redirect::to('/');
        }

        $student     = Student::find(Auth::id());
        $paymentData = json_decode(Session::pull('data'), true);

        $validator = Validator::make($paymentData, $this->paymentHelper->paymentValidationRules(),
            $this->paymentHelper->paymentValidationMessages());

        if ($validator->fails()) {
            $transaction = Transaction::find($paymentData['balanceTransactionID']);
            if ($transaction != null) {
                $student->refundBalanceDebit($transaction);// refund the balance amount used
            }

            return Redirect::back()->withErrors($validator->messages())->withInput(Input::all());
        }

        Session::put('data',
            json_encode($paymentData));//had to store it back to session just in case an error happens along the way


        $productType          = $paymentData['productType'];
        $productID            = $paymentData['productID'];
        $finalCost            = $paymentData['finalCost'];
        $originalCost         = $paymentData['originalCost'];
        $discount             = $paymentData['discount'];
        $balanceTransactionID = $paymentData['balanceTransactionID'];
        $balanceUsed          = $paymentData['balanceUsed'];
        $paymentType          = $paymentData['paymentType'];
        // sorin: gift id 
        $giftID = isset($paymentData['giftID']) ? $paymentData['giftID'] : null;

        $renderForm = true;
        $tax        = Config::get('wazaar.TAX');
        $taxValue   = ceil($finalCost * $tax);


        $amountToPay = ceil($finalCost + $taxValue);

        $checkoutData = compact('productType', 'productID', 'finalCost', 'originalCost', 'discount', 'costWithNoTax',
            'taxValue', 'balanceTransactionID', 'balanceUsed', 'paymentType', 'amountToPay', 'tax', 'giftID');
        //Put the values into a session for use during submission to payment center
        Session::put($checkoutData);
        $product                                = $this->_getProductDetailsByTypeAndID($productType, $productID);
        $checkoutData[Str::lower($productType)] = $product;
        $productPartial                         = View::make('payment.' . Str::lower($productType),
            $checkoutData)->render();


        // sorin: see if student can purchase this
        if (!$student->canPurchase($product)) {
            $renderForm = false;
        }
        // sorin: some students might not have a profile (ie, they register, but never go to the profileController)
        // temp solution until you do your validations: return a new profile object
        //albert: i think we should address the profile issue before they reach the payment part like reminding
        // them somewhere to fill-up their profile info before they can do a purchase
        if ($student->profile == null) {
            $transaction = Transaction::find($paymentData['balanceTransactionID']);
            if ($transaction != null) {
                $student->refundBalanceDebit($transaction);// refund the balance amount used
            }

            return Redirect::to('profile');
        }

        return View::make('payment.index',
            compact('productPartial', 'student', 'renderForm', 'product', 'finalCost', 'amountToPay'));
    }

    //Stripe related payment methods
    public function postProcessStripe()
    {
        if (Input::has('token')) {
            $stripeHelper = new StripeHelper(Input::get('token'));
            $user         = Auth::user();

            $stripeCustomerId = $user->stripe_customer_id;
            $card = null;

            if (empty($stripeCustomerId)){ // If this is the FIRST purchase, we will set-up the customer
                //Create Stripe Customer
                $stripeCustomer = $stripeHelper->createCustomer($user->email);
                if ($stripeCustomer){
                    $stripeCustomerId = $stripeCustomer->id;
                    $user->stripe_customer_id = $stripeCustomerId;
                    $user->updateUniques();
                }
                else{
                    //adding of customer error
                    //TODO: Error dispatch
                }
            }
            else{ //Customer is adding an EXTRA card
                $card = $stripeHelper->createCard($stripeCustomerId);
            }


            if (!empty($stripeCustomerId)){
                $chargeResponse = $stripeHelper->charge($stripeCustomerId,Input::get('amount'));

                if (empty($card)){
                    $card = $chargeResponse->source;
                }
                //Store Payment Reference
                $responseObj = [
                    'card_id'   => $card->id,
                    'last4'     => $card->last4,
                    'card'      => $card->brand,
                    'exp_month' => $card->exp_month,
                    'exp_year'  => $card->exp_year
                ];

                PaymentLog::create([
                    'user_id'   => Auth::id(),
                    'success'   => 1,
                    'reference' => $chargeResponse->id,
                    'response'  => json_encode($responseObj)
                ]);

                //Payment Successfull
                return Response::json(['success' => 1]);
            }
        }
        return Response::josn(['success' => 0, 'error' => 'Payment Error. Please try again']);
    }

    public function postProcessExistingStripePayment()
    {
        $stripeHelper = new StripeHelper('');

        if (!empty(Auth::user()->stripe_customer_id)){
            $cardId = Input::get('cardId');
            $chargeResponse = $stripeHelper->charge(Auth::user()->stripe_customer_id,Input::get('amount'),$cardId);

            if ($chargeResponse){
                return Response::json(['success' => 1]);
            }
        }

        return Response::json(['success' => 0]);
    }

    //Max Connect payment methods

    public function postProcessMaxRequest()
    {
        $request = Input::all();

        $request['giftID'] = 0;
        $request['balancedUsed'] = 0;
        $request['balanceTransactionID'] = 0;

        $reference = Str::random();
        $giftId = Input::get('giftId');

        $course = Course::find(Input::get('productId'));
        $course = courseApprovedVersion( $course );

        $student = Student::current(Auth::user());

        $gift = Gift::find( PseudoCrypt::unhash($giftId) );

        if($gift && $gift->affiliate_id == $giftId){
            $request['giftID'] = $gift->id;
        }

        if( $student->student_balance > 0 ){
            $transaction = $student->balanceDebit( $student->student_balance, $course);
            if ( !$transaction ){
                ;
            }
            $request['balanceUsed'] = $student->student_balance;
            $request['balanceTransactionID'] = $transaction;
        }




        $paymentLog = PaymentLog::create(['user_id' => Auth::id(),'reference' => $reference,'request' => json_encode($request)]);
        return Response::json(['transactionId' => $reference]);
    }

    //Max Connect Canceled payment callback
    public function postCanceled()
    {
        if (Input::has('TransactionId') && Input::has('URL')){
            $paymentLog = PaymentLog::where('reference', Input::get('TransactionId'))->first();

            if ($paymentLog){
                return Redirect::to(Input::get('URL'));
            }
        }

    }

    //Max Connect Completed payment callback
    public function postCompleted()
    {
        try{
            if (Input::has('Result')){
                if (Input::get('Result') == 'OK'){
                    $paymentLog = PaymentLog::where('reference', Input::get('TransactionId'))->first();

                    if ($paymentLog){
                        return $this->_successfulPayment($paymentLog,Input::get('TransactionId'));
                    }

                }
            }

            return Redirect::home();
        }
        catch(Exception $ex){
            echo $ex->getMessage();
            echo $ex->getLine();
        }

    }

    //Max Connect Success payment callback
    public function postSuccess()
    {
        echo '<pre>';
        print_r(Input::all());
        echo '</pre>';
        die;
    }

    //Max Connect Failed payment callback
    public function postFailed()
    {
        echo '<pre>';
        print_r(Input::all());
        echo '</pre>';
        die;
    }

    public function postRemovePaymentLog()
    {
        $id = Input::get('id');

        $paymentLog = PaymentLog::where('user_id',Auth::id())->where('id',$id)->first();
        if ($paymentLog){
            //Tell stripe to remove card
            $stripeHelper = new StripeHelper('');
            $deleteResponse = $stripeHelper->deleteCard(Auth::user()->stripe_customer_id, $paymentLog->response['card_id']);

            if ($deleteResponse) {
                $paymentLog->delete();
                return Response::json(['success' => 1]);
            }
        }
        return Response::json(['success' => 0]);
    }

    public function process()
    {
        if (Session::has('productType') AND Session::has('productID')) {

            $validator = Validator::make(Input::only('firstName', 'lastName', 'email', 'zip', 'city'),
                $this->paymentHelper->creditCardValidationRules(),
                $this->paymentHelper->creditCardValidationMessages());

            if ($validator->fails()) {

                return Redirect::back()->with('errors', $validator->messages()->all());
            } else {
                $paymentProductId = Input::get('paymentProductId');
                $reference        = Str::random(8);

                $student = Student::current(Auth::user());
                $product = $this->_getProductDetailsByTypeAndID(Session::get('productType'), Session::get('productID'));

                if (!$student->canPurchase($product)) { //for some reason, it happened that student can no longer purchase it during transit
                    return Redirect::back()->with('errors',
                        [trans('payment.cannotPurchase')]);//return Redirect::back()->with('errors', [trans('payment.cannotPurchase')]);
                }
                $paymentDetails = [
                    'reference'        => $reference,
                    'paymentProductId' => $paymentProductId,
                    'finalCost'        => Session::get('amountToPay')
                ];

                $payee             = Input::only('firstName', 'lastName', 'email', 'city', 'zip');
                $expiry            = explode('/', Input::get('cardExpiry'));
                $data              = Input::all();
                $data['cardYear']  = @$expiry[1];
                $data['cardMonth'] = @$expiry[0];
                $payment           = $this->paymentHelper->processCreditCardPayment($paymentDetails['finalCost'],
                    $data);//$paymentDetails, $payee, $student);

                if ($payment[0]) {
                    //Success!
                    $cookie_id   = get_class($product) == 'Course' ? $product->id : $product->module->course->id;
                    $paymentData = [
                        'successData' => [
                            'balance_transaction_id' => Session::get('balanceTransactionID'),
                            'processor_fee'          => 0,
                            'tax'                    => Session::get('taxValue'),
                            'giftID'                 => Session::get('giftID'),
                            'balance_used'           => Session::get('balanceUsed'),
                            'REF'                    => $payment[1],
                            'ORDERID'                => $payment[1]
                        ]
                    ];
//                    $purchase  = $student->purchase($product, Cookie::get("aid-$cookie_id"), $paymentData);
                    $purchase = $student->purchase($product, Cookie::get("aid"), $paymentData);
                    if (!$purchase) {
                        $redirectUrl = url('payment', ['errors' => [trans('payment.cannotPurchase')]]);
                    }
                    Session::forget('productType');
                    Session::forget('productID');
                    Session::forget('giftID');
                    $redirectUrl = url('courses/' . $product->slug . '/purchased?purchaseId=' . $purchase->id);
                    if (strtolower(get_class($product)) == 'lesson') {
                        // if lesson was purchased, use the course slug
                        $redirectUrl = url('courses/' . $product->module->course->slug . '/purchased?purchaseId=' . $purchase->id);
                    }

                    return Redirect::to($redirectUrl);
                }

                return Redirect::back()->with('errors', $payment[1]);
                /*if (isset($payment['successData'])) {

                    $paymentRequest = [
                        'wazaar_reference' => $reference,
                        'gc_order_id'      => $payment['successData']['ORDERID'],
                        'gc_form_action'   => $payment['successData']['FORMACTION'],
                        'gc_form_method'   => $payment['successData']['FORMMETHOD'],
                        'gc_reference'     => $payment['successData']['REF'],
                        'gc_mac'           => $payment['successData']['MAC'],
                        'gc_return_mac'    => $payment['successData']['RETURNMAC'],
                        'gc_status_id'     => $payment['successData']['STATUSID'],
                        'variables'        => json_encode(Session::all())
                    ];

                    GCPaymentRequests::create($paymentRequest);
                    return Response::json(['success' => true, 'redirectUrl' => $payment['successData']['FORMACTION']]);
                }*/

            }
        }
    }

    public function renderGCForm($reference)
    {
        $paymentRequest = GCPaymentRequests::where('wazaar_reference', $reference)->first();

        if ($paymentRequest) {
            return View::make('payment.gcForm', compact('paymentRequest'));
        }

    }

    /*
     * DEPRECATED METHOD INTENDED FOR GLOBAL COLLECT
     */
    public function paymentReturn($reference)
    {
        $paymentRequest = GCPaymentRequests::where('wazaar_reference', $reference)->first();

        if ($paymentRequest) {

            $orderStatus = $this->paymentHelper->getOrderStatus($paymentRequest->gc_order_id);

            $statusId    = 0;
            $productId   = 0;
            $redirectUrl = '';

            if (isset($orderStatus['successData']['STATUSID'])) {
                $statusId  = (int) $orderStatus['successData']['STATUSID'];
                $productId = (int) $orderStatus['successData']['PAYMENTPRODUCTID'];
            }

            if ($statusId >= 800 && $productId <> 11) {
                //successful payment

                $payment   = [];
                $variables = json_decode($paymentRequest->variables, true);

                $student = Student::current(Auth::user());
                $product = $this->_getProductDetailsByTypeAndID($variables['productType'], $variables['productID']);

                if (!$student->canPurchase($product)) { //for some reason, it happened that student can no longer purchase it during transit
                    //return Redirect::back()->with('errors', [trans('payment.cannotPurchase')]);
                    $redirectUrl = url('payment', ['errors' => [trans('payment.cannotPurchase')]]);
                }

                $payment['successData']['ORDERID']                  = $paymentRequest->gc_order_id;
                $payment['successData']['REF']                      = $paymentRequest->gc_reference;
                $payment['successData']['processor_fee']            = 0;
                $payment['successData']['tax']                      = $variables['taxValue'];
                $payment['successData']['amount_sent_to_processor'] = $variables['amountToPay'];
                $payment['successData']['balance_transaction_id']   = $variables['balanceTransactionID'];
                $payment['successData']['balance_used']             = $variables['balanceUsed'];
                $payment['successData']['giftID']                   = $variables['giftID'];

                $cookie_id = get_class($product) == 'Course' ? $product->id : $product->module->course->id;
//                $purchase  = $student->purchase($product, Cookie::get("aid-$cookie_id"), $payment);
                $purchase = $student->purchase($product, Cookie::get("aid"), $payment);
                if (!$purchase) {
                    $redirectUrl = url('payment', ['errors' => [trans('payment.cannotPurchase')]]);
                }
                Session::forget('productType');
                Session::forget('productID');
                Session::forget('giftID');
                $redirectUrl = url('courses/' . $product->slug . '/purchased?purchaseId=' . $purchase->id);
                if (strtolower(get_class($product)) == 'lesson') {
                    // if lesson was purchased, use the course slug
                    $redirectUrl = url('courses/' . $product->module->course->slug . '/purchased?purchaseId=' . $purchase->id);
                }


            } else {
                //payment did not work as planned, failed
                $redirectUrl = url('payment/?canceled=true');
            }

            return View::make('payment.callback', compact('redirectUrl'));
            //return View::make('payment.gcForm',compact('paymentRequest'));
        }
    }

    public function process__()
    {
        if (Session::has('productType') AND Session::has('productID')) {
            $validator = Validator::make(Input::all(), $this->paymentHelper->creditCardValidationRules());

            if ($validator->fails()) {

                return Redirect::back()->with('errors', $validator->messages()->all());
            } else {
                $student = Student::current(Auth::user());
                $product = $this->_getProductDetailsByTypeAndID(Session::get('productType'), Session::get('productID'));

                if (!$student->canPurchase($product)) { //for some reason, it happened that student can no longer purchase it during transit
                    return Redirect::back()->with('errors', [trans('payment.cannotPurchase')]);
                }
                $creditCard = [
                    'cardNumber' => Input::get('cardNumber'),
                    'cardExpiry' => Input::get('expiryDate'),
                    'finalCost'  => Session::get('amountToPay')
                ];


                $payee = Input::only('firstName', 'lastName', 'email', 'city', 'zip');

                $payment = $this->paymentHelper->processCreditCardPayment($creditCard, $payee, $student);

                if ($payment['success']) {
                    $orderId       = $payment['successData']['ORDERID'];
                    $createProfile = $this->paymentHelper->processCreateProfileFromOrderId($orderId);

                    $payment['successData']['processor_fee']            = 0;
                    $payment['successData']['tax']                      = Session::get('taxValue');
                    $payment['successData']['amount_sent_to_processor'] = Session::get('amountToPay');
                    $payment['successData']['balance_transaction_id']   = Session::get('balanceTransactionID');
                    $payment['successData']['balance_used']             = Session::get('balanceUsed');
                    $payment['successData']['giftID']                   = Session::get('giftID');

                    // cookie name contains only the course id, so if this is a lesson, fetch the course id
                    $cookie_id = get_class($product) == 'Course' ? $product->id : $product->module->course->id;
//                    $purchase  = $student->purchase($product, Cookie::get("aid-$cookie_id"), $payment);
                    $purchase = $student->purchase($product, Cookie::get("aid"), $payment);
                    if (!$purchase) {
                        return Redirect::back()->with('errors', [trans('payment.cannotPurchase')]);
                    }
                    Session::forget('productType');
                    Session::forget('productID');
                    Session::forget('giftID');
                    $redirectUrl = 'courses/' . $product->slug . '/purchased';
                    if (strtolower(get_class($product)) == 'lesson') {
                        // if lesson was purchased, use the course slug
                        $redirectUrl = 'courses/' . $product->module->course->slug . '/purchased';
                    }

                    return Redirect::to($redirectUrl)->with('purchaseId', $purchase->id);
                } else {
                    return Redirect::back()->with('errors', $payment['errors'][0]);
                }
            }
        } else {
            //TODO: Payment session has expired, what to do?
            //Redirect to home for now
            return Redirect::home();
        }
    }

    private function _getProductDetailsByTypeAndID($type, $id)
    {

        $obj = null;
        if (strtolower($type) == 'course') {
            $obj = Course::find($id);
        } elseif ($type == 'Lesson') {
            $obj = Lesson::find($id);
        }

        return $obj;
    }

    private function _successfulPayment($paymentLog,$transactionId){
        $student = Student::current(Auth::user());

        $product = $this->_getProductDetailsByTypeAndID($paymentLog->request['productType'],$paymentLog->request['productId']);//   Session::get('productType'), Session::get('productID'));

        $cookie_id   = get_class($product) == 'Course' ? $product->id : $product->module->course->id;
        $paymentData = [
            'successData' => [
                'balance_transaction_id' => $paymentLog->request['balanceTransactionID'],
                'processor_fee'          => 0,
                'tax'                    => 0,
                'giftID'                 => $paymentLog->request['giftID'],
                'balance_used'           => $paymentLog->request['balancedUsed'],
                'REF'                    => $paymentLog->reference,
                'ORDERID'                => $transactionId
            ]
        ];
//                    $purchase  = $student->purchase($product, Cookie::get("aid-$cookie_id"), $paymentData);
        $purchase = $student->purchase($product, Cookie::get("aid"), $paymentData);
        if (!$purchase) {
            $redirectUrl = url('payment', ['errors' => [trans('payment.cannotPurchase')]]);
        }
        Session::forget('productType');
        Session::forget('productID');
        Session::forget('giftID');
        $redirectUrl = url('courses/' . $product->slug . '/purchased?purchaseId=' . $purchase->id);
        if (strtolower(get_class($product)) == 'lesson') {
            // if lesson was purchased, use the course slug
            $redirectUrl = url('courses/' . $product->module->course->slug . '/purchased?purchaseId=' . $purchase->id);
        }

        return Redirect::to($redirectUrl);
    }
}