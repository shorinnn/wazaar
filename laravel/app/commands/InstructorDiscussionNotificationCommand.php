<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstructorDiscussionNotificationCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:instructor-discussion-notification';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that emails the instructor if new discussions that day';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->hours( 6 );
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $this->info('Fixing discussions with missing courses');
            $count = 1;
            $updated = 0;
            $maxLoops = 50;
            $i = 0;
            while($count != 0){
                $result = $discussions = LessonDiscussion::where('course_id',0)->limit(500)->get();
                $count = $result->count();
                foreach($result as $row){
                    DB::table('lesson_discussions')->where('id', $row->id)->update([ 'course_id' => $row->lesson->module->course_id ] );
                }
                $updated += $count;
                $this->comment("$updated rows updated. Sleep 1 second");
                ++$i;
                sleep(1);
                $this->comment('Resuming...');
                if($i > $maxLoops) dd('MAX LOOPS REACHED');
            }
            $this->info('Done.');
            
            $cutoff = date('Y-m-d H:i:s' , strtotime('- 1 day') );
            $courses = LessonDiscussion::where('created_at', '>', $cutoff)->lists('course_id');
            if( count($courses)==0) $courses = [0];
            $instructors = Course::whereIn('id', $courses)->lists('instructor_id');
            if( count($instructors)==0) $instructors = [0];
            $instructors = Instructor::whereIn('id', $instructors)->get();
            $sent = 0;
            foreach($instructors as $instructor){
                $courses = $instructor->courses()->lists('id');
                if( count($courses)==0) $courses = [0];
                $discussions = LessonDiscussion::whereIn('course_id', $courses)->where('created_at', '>', $cutoff)->get();
                Mail::send(
                        'emails.new_discussions_update',
                        compact('instructor' , 'discussions' ),
                        function ($message) use ($instructor) {
                            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                            $message
                                ->to($instructor->email, $instructor->email)
                                ->subject( 'New Discussions' );
                        }
                    );
                    ++$sent;
            }
            $this->info("$sent emails sent" );
	}

	

}
