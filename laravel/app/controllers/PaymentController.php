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
        if (!Session::has('data')){
            //return Redirect::to('/');
        }

        $student = Student::find(Auth::id());
        $paymentData = json_decode( Session::pull('data') , true);

        $validator = Validator::make( $paymentData, $this->paymentHelper->paymentValidationRules(),$this->paymentHelper->paymentValidationMessages());

        if ($validator->fails()) {
            $transaction = Transaction::find( $paymentData['balanceTransactionID'] );
            if( $transaction != null ){
                $student->refundBalanceDebit( $transaction );// refund the balance amount used
            }
            return Redirect::back()->withErrors($validator->messages())->withInput(Input::all());
        }

        Session::put('data', json_encode($paymentData));//had to store it back to session just in case an error happens along the way


        $productType          = $paymentData['productType'];
        $productID            = $paymentData['productID'];
        $finalCost            = $paymentData['finalCost'];
        $originalCost         = $paymentData['originalCost'];
        $discount             = $paymentData['discount'];
        $balanceTransactionID = $paymentData['balanceTransactionID'];
        $balanceUsed          = $paymentData['balanceUsed'];
        $paymentType          = $paymentData['paymentType'];

        $renderForm = true;
        $tax           = Config::get('wazaar.TAX');
        $taxValue      = ceil($finalCost * $tax);


        $amountToPay = ceil($finalCost + $taxValue);

        $checkoutData = compact('productType', 'productID', 'finalCost', 'originalCost', 'discount', 'costWithNoTax',
                                'taxValue', 'balanceTransactionID', 'balanceUsed', 'paymentType','amountToPay', 'tax');
        //Put the values into a session for use during submission to payment center
        Session::put($checkoutData);
        $product                                = $this->_getProductDetailsByTypeAndID($productType, $productID);
        $checkoutData[Str::lower($productType)] = $product;
        $productPartial                         = View::make('payment.' . Str::lower($productType),$checkoutData)->render();



        // sorin: see if student can purchase this
        if( !$student->canPurchase($product) ) {
            $renderForm = false;
        }
        // sorin: some students might not have a profile (ie, they register, but never go to the profileController)
        // temp solution until you do your validations: return a new profile object
        //albert: i think we should address the profile issue before they reach the payment part like reminding
        // them somewhere to fill-up their profile info before they can do a purchase
        if($student->profile == null) {
            $transaction = Transaction::find( $paymentData['balanceTransactionID'] );
            if( $transaction != null ){
                $student->refundBalanceDebit( $transaction );// refund the balance amount used
            }
           return Redirect::to('profile');
        }

        return View::make('payment.index', compact('productPartial', 'student','renderForm'));
    }

    public function process()
    {
        if (Session::has('productType') AND Session::has('productID')) {
            $validator = Validator::make(Input::all(), $this->paymentHelper->creditCardValidationRules());

            if ($validator->fails()) {
                return Redirect::back()->with('errors', $validator->messages()->all());
            } else {
                $student = Student::current(Auth::user());
                $product = $this->_getProductDetailsByTypeAndID(Session::get('productType'),Session::get('productID'));

                if( !$student->canPurchase($product) ) { //for some reason, it happened that student can no longer purchase it during transit
                    return Redirect::back()->with('errors',[trans('payment.cannotPurchase')]);
                }
                $creditCard = [
                    'cardNumber' => Input::get('cardNumber'),
                    'cardExpiry' => Input::get('expiryDate'),
                    'finalCost'  => Session::get('amountToPay')
                ];


                $payee = Input::only('firstName', 'lastName', 'email','city','zip');

                $payment    = $this->paymentHelper->processCreditCardPayment($creditCard, $payee, $student);

                if ($payment['success']) {
                    //dd($payment);
                    $orderId = $payment['successData']['ORERID'];
                    $createProfile = $this->paymentHelper->processCreateProfileFromOrderId($orderId);
                    echo '<pre>';
                    print_r($createProfile);
                    echo '</pre>';
                    die;
                    //Store Purchase

                    $payment['successData']['processor_fee'] = 0;
                    $payment['successData']['tax'] = Session::get('taxValue');
                    $payment['successData']['amount_sent_to_processor'] = Session::get('amountToPay');
                    $payment['successData']['balance_transaction_id'] = Session::get('balanceTransactionID');
                    $payment['successData']['balance_used'] = Session::get('balanceUsed');

                    $purchase = $student->purchase($product, Cookie::get( "aid-$product->id" ),$payment);
                    if (!$purchase){
                        return Redirect::back()->with('errors',[trans('payment.cannotPurchase')]);
                    }
                    Session::forget('productType');
                    Session::forget('productID');
                    $redirectUrl = 'courses/' . $product->slug . '/purchased';
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
        if ($type == 'Course') {
            $obj = Course::find($id);
        } elseif ($type == 'Lesson') {
            $obj = Lesson::find($id);
        }
        return $obj;
    }
}