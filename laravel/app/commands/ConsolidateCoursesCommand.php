<?php
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ConsolidateCoursesCommand extends ScheduledCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wazaar:consolidate-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collects all purchases and place in a flat table.';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        CourseConsolidatedPurchases::truncate();

        CourseConsolidatedPurchases::unguard();
        $courses = Course::all();

        $consolidatedPurchases = [];
        foreach ($courses as $course) {
            $consolidatedPurchase = [
                'course_id'                        => $course->id,
                'course_name'                      => $course->name,
                'course_slug'                      => $course->slug,
                'course_description'               => $course->description,
                'course_short_description'         => $course->short_description,
                'course_price'                     => $course->price,
                'course_free'                      => $course->free,
                'course_affiliate_percentage'      => $course->affiliate_percentage,
                'course_featured'                  => $course->featured,
                'course_difficulty_id'             => $course->course_difficulty_id,
                'course_student_count'             => $course->student_count,
                'course_sale'                      => $course->sale,
                'course_sale_kind'                 => $course->sale_kind,
                'course_sale_starts_on'            => $course->sale_starts_on,
                'course_sale_ends_on'              => $course->sales_ends_on,
                'course_privacy_status'            => $course->privacy_status,
                'course_publish_status'            => $course->publish_status,
                'course_ask_teacher'               => $course->ask_teacher,
                'course_discussions'               => $course->course_discussions,
                'course_show_bio'                  => $course->show_bio,
                'course_total_reviews'             => $course->total_reviews,
                'course_reviews_positive_score'    => $course->reviews_positive_score,
                'instructor_id'                    => $course->instructor_id,
                'instructor_first_name'            => @$course->instructor->profile->first_name,
                'instructor_last_name'             => @$course->instructor->profile->last_name,
                'instructor_email'                 => @$course->instructor->email,
                'course_category_id'               => $course->course_category_id,
                'course_category_name'             => @$course->courseCategory->name,
                'course_category_slug'             => @$course->courseCategory->slug,
                'course_category_description'      => @$course->courseCategory->description,
                'course_category_courses_count'    => @$course->courseCategory->courses_count,
                'course_category_graphics_url'     => @$course->courseCategory->graphics_url,
                'course_category_color_scheme'     => @$course->courseCategory->color_scheme,
                'course_subcategory_id'            => $course->course_subcategory_id,
                'course_subcategory_name'          => @$course->courseSubcategory->name,
                'course_subcategory_slug'          => @$course->courseSubcategory->slug,
                'course_subcategory_description'   => @$course->courseSubcategory->description,
                'course_subcategory_courses_count' => @$course->courseSubcategory->courses_count
            ];

            $purchases = Purchase::where('product_type', 'Course')->where('product_id', $course->id)->get();

            if ($purchases->count() > 0) {
                foreach ($purchases as $purchase) {
                    $consolidatedPurchase['purchase_id']             = $purchase->id;
                    $consolidatedPurchase['purchase_price']          = $purchase->purchase_price;
                    $consolidatedPurchase['purchase_original_price'] = $purchase->original_price;
                    $consolidatedPurchase['purchase_discount_value'] = $purchase->discount_value;
                    $consolidatedPurchase['purchase_discount']       = $purchase->discount;
                    $consolidatedPurchase['purchase_date']           = $purchase->created_at;
                    $consolidatedPurchases[]                         = $consolidatedPurchase;
                }
            } else {
                $consolidatedPurchase['purchase_id']             = 0;
                $consolidatedPurchase['purchase_price']          = 0;
                $consolidatedPurchase['purchase_original_price'] = 0;
                $consolidatedPurchase['purchase_discount_value'] = 0;
                $consolidatedPurchase['purchase_discount']       = 0;
                $consolidatedPurchase['purchase_date']           = null;
                $consolidatedPurchases[]                         = $consolidatedPurchase;
            }

            CourseConsolidatedPurchases::create($consolidatedPurchase);

        }

        /*echo '<pre>';
        print_r($consolidatedPurchases);
        echo '</pre>';
        die;*/
        //unset($consolidatedPurchases[65]);



    }


    /**
     * When a command should run
     * @param \Indatus\Dispatcher\Scheduler $scheduler
     * @return \Indatus\Dispatcher\Scheduling\Schedulable|\Indatus\Dispatcher\Scheduling\Schedulable[]
     */
    public function schedule(\Indatus\Dispatcher\Scheduling\Schedulable $scheduler)
    {
        return $scheduler->hourly();
    }
}
