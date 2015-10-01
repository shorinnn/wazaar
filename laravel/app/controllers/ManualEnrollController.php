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
        $rules = ['studentId' => 'required|exists:users,id','price' => 'required|numeric','courseId' => 'required|exists:courses,id'];

        $validation = Validator::make(Input::all(),$rules);

        if ($validation->fails()){
            return Redirect::back()->with('errors',$validation->messages()->all());
        }

        $student = Student::find(Input::get('studentId'));
        $course = Course::find(Input::get('courseId'));
        $priceInput = Input::get('price');// including tax

        //Calculate sale
        $sale = $course->price - $priceInput;
        
        //Set sale amount
        $course->sale = $sale;

        $course->approved_data = null;
        if($sale > 0){
            $course->sale_starts_on = date('Y-m-d H:i:s', time()- 24 * 60 *60);
            $course->sale_ends_on = date('Y-m-d H:i:s', time()+ 24 * 60 *60);
        }


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



        if ($purchase){
            return Redirect::to('administration/members')->withSuccess('User enrolled successfully');
        }

        return Redirect::to('administration/members')->withError('User enrollment failed');


    }

}