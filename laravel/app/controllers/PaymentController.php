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

        if ($validator->fails()){
            dd($validator->messages()->all());
        }

        $productType = Input::get('productType');
        $productID = Input::get('productID');
        $finalCost = Input::get('finalCost');
        $originalCost = Input::get('originalCost');
        $discount = Input::get('discount');
        //thought Tax Value should also be passed here
        $tax = .08;
        $taxValue = $finalCost * $tax;
        $costWithNoTax = $finalCost - $taxValue;

        $checkoutData = compact('productType','productID','finalCost','originalCost','discount','costWithNoTax','taxValue');
        //Put the values into a session for use during submission to payment center
        Session::put($checkoutData);

        if ($productType == 'Course'){
            $course = Course::find($productID);
            $checkoutData['course'] = $course;
            $productPartial = View::make('payment.course',$checkoutData)->render();
        }
        elseif ($productType == 'Lesson'){
            $lesson = Lesson::find($productID);
            $checkoutData['lesson'] = $lesson;
            $productPartial = View::make('payment.lesson', $checkoutData)->render();
        }

        return View::make('payment.index',compact('productPartial'));
    }

    public function process()
    {
        if (Session::has('productType') AND Session::has('productID')){
            $validator = Validator::make(Input::all(),$this->paymentHelper->creditCardValidationRules());

            if ($validator->fails()){
                dd($validator->messages()->all());
                return Redirect::back()->with('errors',$validator->messages()->all());
            }
            else{
                $user = Student::with('profile')->find(Auth::id());
                $creditCard = [
                    'cardNumber' => Input::get('cardNumber'),
                    'cardExpiry' => Input::get('expiryMonth') . Input::get('expiryYear'),
                    'finalCost' => Session::get('finalCost'),
                ];
                $this->paymentHelper->processCreditCardPayment($creditCard, $user);
            }
        }
        else{
            //TODO: Payment session has expired, what to do?
        }
    }
}