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
        $validator = Validator::make(Input::all(), $this->paymentHelper->paymentValidationRules(),$this->paymentHelper->paymentValidationMessages());

        if ($validator->fails()) {
            dd($validator->messages()->all());
        }

        $productType          = Input::get('productType');
        $productID            = Input::get('productID');
        $finalCost            = Input::get('finalCost');
        $originalCost         = Input::get('originalCost');
        $discount             = Input::get('discount');
        $balanceTransactionID = Input::get('balanceTransactionID');
        $balanceUsed          = Input::get('balanceUsed');
        $paymentType          = Input::get('paymentType');

        $renderForm = true;
        //thought Tax Value should also be passed here
        $tax           = .08;
        $taxValue      = $finalCost * $tax;
        $costWithNoTax = $finalCost - $taxValue;

        $checkoutData = compact('productType', 'productID', 'finalCost', 'originalCost', 'discount', 'costWithNoTax',
            'taxValue', 'balanceTransactionID', 'balanceUsed', 'paymentType');
        //Put the values into a session for use during submission to payment center
        Session::put($checkoutData);

        $product                                = $this->_getProductDetailsByTypeAndID($productType, $productID);
        $checkoutData[Str::lower($productType)] = $product;
        $productPartial                         = View::make('payment.' . Str::lower($productType),$checkoutData)->render();

        $student = Student::find(Auth::id());

        // sorin: see if student can purchase this
        if( !$student->canPurchase($product) ) {
            $renderForm = false;
        }
        // sorin: some students might not have a profile (ie, they register, but never go to the profileController)
        // temp solution until you do your validations: return a new profile object
        //albert: i think we should address the profile issue before they reach the payment part like reminding
        // them somewhere to fill-up their profile info before they can do a purchase
        if($student->profile == null) {
            $student->profile = new Profile;
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
                $product = $this->_getProductDetailsByTypeAndID(Session::get('productType'),
                    Session::get('productID'));

                if( !$student->canPurchase($product) ) { //for some reason, it happened that student can no longer purchase it during transit
                    return Redirect::back()->with('errors',[trans('payment.cannotPurchase')]);
                }
                $creditCard = [
                    'cardNumber' => Input::get('cardNumber'),
                    'cardExpiry' => Input::get('expiryDate'),
                    'finalCost'  => Session::get('finalCost'),
                ];
                $payment    = $this->paymentHelper->processCreditCardPayment($creditCard, $student);

                if ($payment['success']) {
                    $paymentRef = $payment['successData']['REF'];
                    //Store Purchase
                    $purchase = $student->purchase($product, Cookie::get( "aid-$product->id" ),$paymentRef);
                    if (!$purchase){
                        return Redirect::back()->with('errors',[trans('payment.cannotPurchase')]);
                    }
                    return Redirect::to('courses/purchase-successful')->with('purchaseId', $purchase->id);
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