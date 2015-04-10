<?php

class SiteController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'only' => ['dashboard'] ] );
        }

	public function index()
	{
//            $client = AWS::get('s3');
//            // Get a command object from the client and pass in any options
//            // available in the GetObject command (e.g. ResponseContentDisposition)
//            $command = $client->getCommand('GetObject', array(
//                'Bucket' => $_ENV['AWS_BUCKET'],
//                'Key' => 'course_uploads/file-5526bab93ea21.jpg'
//            ));
//            // Create a signed URL from the command object that will last for
//            // 10 minutes from the current time
//            $link =  $command->createPresignedUrl('+10 minutes');
//            echo "Denied : https://wazaardev.s3.amazonaws.com/course_uploads/file-5526bab93ea21.jpg"; 
//            echo "<br />Approved: $link"; 
//            echo "<br />Denied: http://d3hkpu7v8z21q.cloudfront.net/course_uploads/file-5526bab93ea21.jpg"; 
//            $approved = str_replace('https://wazaardev.s3.amazonaws.com', 'http://d3hkpu7v8z21q.cloudfront.net', $link);
//            echo "<br />Approved: $approved"; 
//            exit();
//            dd($link);
            $frontpageVideos  = FrontpageVideo::grid();
            $categories = CourseCategory::with('featuredCourse')->get();
            if(Auth::user()) Return View::make('site.homepage_authenticated')->with(compact('categories'));
            else Return View::make('site.homepage_unauthenticated')->with( compact('categories', 'frontpageVideos') );
	}
        
	public function dashboard()
	{                 
            $student = Student::find( Auth::user()->id );
            $transactions = $student->transactions->orderBy('id','desc')->paginate(2);
            return View::make('site.dashboard')->with( compact('student', 'transactions') );
	}
        
	public function classroom()
	{            
            Return View::make('site.classroom');
	}
        
        public function crud(){
             Return View::make('TEMPORARYVIEWS.crud');
        }
        
        public function admindash(){
             Return View::make('TEMPORARYVIEWS.questions');
             	//Return View::make('confide.account_details');
            	 //Return View::make('TEMPORARYVIEWS.admin_dashboard');
        }
        
        public function affiliatedash(){
             Return View::make('TEMPORARYVIEWS.affiliate_dashboard');
        }
        
        public function classroomdash(){
             Return View::make('TEMPORARYVIEWS.classroom_dashboard');
        }
        
        public function enroll(){
             Return View::make('TEMPORARYVIEWS.enroll');
        }
        
        public function shop(){
             Return View::make('TEMPORARYVIEWS.shop');
        }

        public function courseditor(){
             Return View::make('TEMPORARYVIEWS.course_editor');
        }



}
