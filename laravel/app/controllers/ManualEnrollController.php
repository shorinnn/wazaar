<?php 
class ManualEnrollController extends BaseController {

    public function getIndex()
    {
        if (Input::has('studentId')){
            $studentId = Input::get('studentId');
            $student = Student::find($studentId);

            if ($student){
                $courses = Course::where('publish_status','approved')->get();
                $coursesJson = json_encode($courses);
                return View::make('administration.manual_enrollment.index',compact('student','courses','coursesJson'));
            }

        }
    }

    public function postIndex()
    {
        //Backend Validation
        $rules = ['studentId' => 'required','price' => 'required|numeric','courseId' => 'required|exists:courses,id'];

        $validation = Validator::make(Input::all(),$rules);

        if ($validation->fails()){
            return Redirect::back()->with('errors',$validation->messages()->all());
        }

        $student = Student::find(Input::get('studentId'));
        $course = Course::find(Input::get('courseId'));
        $priceInput = Input::get('price');

        //Calculate sale
        $sale = $course->price - $priceInput;

        //Set sale amount
        $course->sale = $sale;

        //Dummy payment data
        $paymentData = [
            'successData' => [
                'balance_transaction_id' => 0,
                'processor_fee'          => 0,
                'tax'                    => 0,
                'giftID'                 => 0,
                'balance_used'           => 0,
                'REF'                    => Str::random(),
                'ORDERID'                => Str::random()
            ]
        ];

        //Do Purchase
        $purchase = $student->purchase($course,null,$paymentData);

        dd($purchase);
    }

}