<?php

class ManualEnrollmentCest{
    
    public function manualStudentCourseEnrollment(FunctionalTester $I)
    {
        $student = Student::where('username','student')->first();
        $course = Course::first();
        
        Purchase::where('student_id', $student->id)->delete();// delete purchases for this buyer
        
        $I->dontSeeRecord('purchases',[ 'student_id' => $student->id, 'product_id' => $course->id]);
        
        $priceInput = 100;
        
        $I->sendAjaxPostRequest( action('ManualEnrollController@postIndex'), [
            'studentId' => $student->id,
            'courseId' => $course->id,
            'price' => $priceInput
        ]);
        
        sleep(1);
        //Calculate sale
        $sale = $course->price - $priceInput;
        //Set sale amount
        $course->sale = $sale;

        $I->assertGreaterThan(0, $course->price);
        $I->assertGreaterThan(0, $course->sale);

        $purchase = Purchase::where('student_id', $student->id)->first();
        
        $I->assertNotEquals( null, $purchase );
        $I->assertEquals( $sale, $purchase->discount_value );
        $I->assertEquals( $purchase->purchase_price, $priceInput );
        $I->assertEquals( $purchase->original_price, $course->price );
        
        $I->seeRecord('purchases',[ 'student_id' => $student->id, 'product_id' => $course->id]);
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => $course->instructor->id, 'transaction_type' => 'instructor_credit', 
            'amount' => $purchase->instructor_earnings]);
        $I->assertNull( $student->ltc_affiliate );
        
        $I->seeRecord('transactions',['purchase_id' => $purchase->id, 'user_id' => 2, 'transaction_type' => 'site_credit', 
            'amount' => $purchase->site_earnings]);

    }
    
    public function manualStudentCourseEnrollmentFailsBadStudent(FunctionalTester $I)
    {
        $studentId = 999999;
        Purchase::where('student_id', $studentId)->delete();// delete purchases for this buyer
        $course = Course::first();
        
        $I->dontSeeRecord('purchases',[ 'student_id' => $studentId, 'product_id' => $course->id]);
        
        $priceInput = 100;
        try{
            $I->sendAjaxPostRequest( action('ManualEnrollController@postIndex'), [
                'studentId' => $studentId,
                'courseId' => $course->id,
                'price' => $priceInput
            ]);
        }
        catch(Exception $e){}
        
        sleep(1);

        $purchase = Purchase::where('student_id', $studentId)->first();
        
        $I->assertNull( $purchase );        
        $I->dontSeeRecord('purchases',[ 'student_id' => $studentId, 'product_id' => $course->id]);
    }
    
    public function manualStudentCourseEnrollmentFailsBadCourse(FunctionalTester $I)
    {
        $student = Student::first();
         Purchase::where('student_id', $student->id)->delete();// delete purchases for this buyer
        $courseID = 999999;
        
        $I->dontSeeRecord('purchases',[ 'student_id' => $student->id, 'product_id' => $courseID]);
        
        $priceInput = 100;
        try{
            $I->sendAjaxPostRequest( action('ManualEnrollController@postIndex'), [
                'studentId' =>$student->id,
                'courseId' => $courseID,
                'price' => $priceInput
            ]);
        }
        catch(Exception $e){}
        
        sleep(1);
     
        $purchase = Purchase::where('student_id', $student->id)->first();
        
        $I->assertNull( $purchase );        
        $I->dontSeeRecord('purchases',[ 'student_id' => $student->id, 'product_id' => $courseID]);
    }
    
    public function manualStudentCourseEnrollmentFailsBadStudentAndCourse(FunctionalTester $I)
    {
        $studentId = 999999;
        $courseId = 999999;
        Purchase::where('student_id', $studentId)->delete();// delete purchases for this buyer
        
        $I->dontSeeRecord('purchases',[ 'student_id' => $studentId, 'product_id' => $courseId]);
        
        $priceInput = 100;
        try{
            $I->sendAjaxPostRequest( action('ManualEnrollController@postIndex'), [
                'studentId' => $studentId,
                'courseId' => $courseId,
                'price' => $priceInput
            ]);
        }
        catch(Exception $e){}
        
        sleep(1);

        $purchase = Purchase::where('student_id', $studentId)->first();
        
        $I->assertNull($purchase );        
        $I->dontSeeRecord('purchases',[ 'student_id' => $studentId, 'product_id' => $courseId]);
    }
 
}