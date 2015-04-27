<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		 $this->call('RoleTableSeeder');
		 $this->call('UserTableSeeder');
		 $this->call('AssignedRoleTableSeeder');
		 $this->call('CourseCategorySeeder');
		 $this->call('CourseSubcategorySeeder');
		 $this->call('CourseDifficultySeeder');
		 $this->call('CoursesSeeder');
		 $this->call('PurchasesSeeder');
		 $this->call('CoursePreviewImagesSeeder');
		 $this->call('ModulesSeeder');
		 $this->call('LessonsSeeder');
                 $this->call('VideosSeeder');
		 $this->call('BlocksSeeder');
                 $this->call('AnalyticsSeeder');
                 $this->call('ProfileSeeder');
                 $this->call('TestimonialsSeeder');
                 $this->call('InstructorAgenciesSeeder');
                 $this->call('PMSeeder');
                 $this->call('TransactionsSeeder');
                 $this->call('FrontpageVideosSeeder');
                 $this->call('GiftSeeder');
                 $this->call('AffiliateUsersSeeder');
	}

}

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();
        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();
        
        $student = new Role;
        $student->name = 'Student';
        $student->save();
        
        $instructor = new Role;
        $instructor->name = 'Instructor';
        $instructor->save();
        
        $affiliate = new Role;
        $affiliate->name = 'Affiliate';
        $affiliate->save();
        
        $agency = new Role;
        $agency->name = 'InstructorAgency';
        $agency->save();
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {


        DB::table('users')->delete();
        $user = new User;
        $user->username = 'superadmin';
        $user->email = 'superadmin@wazaar.jp';
        $user->password = 'superadmin';
        $user->password_confirmation = 'superadmin';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;

        $user->username = 'WazaarAffiliate';
        $user->affiliate_id = '2';
        $user->email = 'wazaarAffiliate@wazaar.jp';
        $user->password = 'random';
        $user->password_confirmation = 'random';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();




        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'student';
        $user->email = 'student@mailinator.com';
        $user->first_name = 'Student';
        $user->last_name = 'McStudent';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();

        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'instructor';
        $user->email = 'instructor@mailinator.com';
        $user->first_name = 'Instructor';
        $user->last_name = 'McInstructor';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->instructor_balance = 60;
        $user->save();
        Profile::create( ['owner_id' => $user->id, 'owner_type' => 'Affiliate','first_name' => 'Instructor', 'last_name' => 'McInstructor', 'email' => 'instructor@mailinator.com']);

        $user = new User;
        $user->affiliate_id = '5';
        $user->ltc_affiliate_id = 2;
        $user->username = 'affiliate';
        $user->email = 'affiliate@mailinator.com';
        $user->first_name = 'Affiliate';
        $user->last_name = 'McAffiliate';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->affiliate_balance = 70;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'mac';
        $user->email = 'mac@mailinator.com';
        $user->first_name = 'Mac';
        $user->last_name = 'Max';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'jeremy';
        $user->email = 'jeremy@mailinator.com';
        $user->first_name = 'Jeremy';
        $user->last_name = 'Jerome';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'martin';
        $user->email = 'martin@mailinator.com';
        $user->first_name = 'Martin';
        $user->last_name = 'Matthew';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'sorin';
        $user->email = 'sorin@mailinator.com';
        $user->first_name = 'Sorin';
        $user->last_name = 'Ryan';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'second_instructor';
        $user->email = 'second_instructor@mailinator.com';
        $user->first_name = 'SInstructor';
        $user->last_name = 'McSInstructor';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->instructor_balance = 80;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'Keiji_Tani';
        $user->email = 'Keiji_Tani@mailinator.com';
        $user->first_name = 'Keiji';
        $user->last_name = 'Tani';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = '甘党大王';
        $user->email = '1@mailinator.com';
        $user->first_name = '甘党大王';
        $user->last_name = '';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'チョコリング';
        $user->email = '2@mailinator.com';
        $user->first_name = 'チョコリング';
        $user->last_name = '';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = '未公開	';
        $user->email = '3@mailinator.com';
        $user->first_name = '未公開';
        $user->last_name = '';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();
        
        //albert: added this for my testing
        $user = new User;
        $user->ltc_affiliate_id = 2;
        $user->username = 'albert';
        $user->email = 'albert@mailinator.com';
        $user->first_name = 'Albert';
        $user->last_name = 'Maranian';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
        $user->save();

        //albert

    }
}
    
class AssignedRoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('assigned_roles')->delete();
        $user = User::where('username', '=', 'superadmin')->first();
        $adminRole = Role::where('name','=','Admin')->first();
        $user->attachRole( $adminRole );
        $user = User::where('username', '=', 'student')->first();
        $studentRole = Role::where('name','=','Student')->first();
        $user->attachRole( $studentRole );
        $user = User::where('username', '=', 'albert')->first();
        $studentRole = Role::where('name','=','Student')->first();
        $user->attachRole( $studentRole );
        $user = User::where('username', '=', 'mac')->first();
        $user->attachRole( $studentRole );
        $user = User::where('username', '=', 'jeremy')->first();
        $user->attachRole( $studentRole );
        $user = User::where('username', '=', 'martin')->first();
        $user->attachRole( $studentRole );
        $user = User::where('username', '=', 'sorin')->first();
        $user->attachRole( $studentRole );
        
        $user = User::where('username', '=', 'instructor')->first();
        $instructorRole = Role::where('name','=','Instructor')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $instructorRole );
        $user = User::where('username', '=', 'second_instructor')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $instructorRole );
        $user = User::where('username', '=', 'affiliate')->first();
        $affiliateRole = Role::where('name','=','Affiliate')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $affiliateRole );
        $user = User::where('username', '=', 'wazaarAffiliate')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $affiliateRole );
        
        $user = User::where('username', '=', 'Keiji_Tani')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $instructorRole );

    }

}


class CourseCategorySeeder extends Seeder {

    public function run()
    {
        DB::table('course_categories')->delete();
        CourseCategory::unguard();
        CourseCategory::create( ['name' => 'IT & Technology', 'slug' => 'it-technology', 'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-7.png',
                                 'description' => 'Programming, Javascript, C++, etc...', 'courses_count' => 0, 'color_scheme' => 1 ]);
        CourseCategory::create( ['name' => 'Business', 'slug' => 'business',  'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-14.png',
                                 'description' => 'Beez Kneez', 'courses_count' => 0, 'color_scheme' => 8 ]);
        CourseCategory::create( ['name' => 'Investments', 'slug' => 'investments',  'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-12.png',
                                 'description' => 'Mo money', 'courses_count' => 0, 'color_scheme' => 6 ]);
        CourseCategory::create( ['name' => 'Music', 'slug' => 'music',  'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-8.png',
                                 'description' => 'Tokyo Square, nom sayin', 'courses_count' => 0, 'color_scheme' => 2 ]);
        CourseCategory::create( ['name' => 'Beauty', 'slug' => 'beauty',  'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-9.png',
                                 'description' => 'Stop being ugly', 'courses_count' => 0, 'color_scheme' => 3 ]);
        CourseCategory::create( ['name' => 'Health', 'slug' => 'health',  'graphics_url' => 'https://wazaar.s3.amazonaws.com/assets/images/misc-images/misc-icons-13.png',
                                 'description' => 'Fat it up bro!', 'courses_count' => 0, 'color_scheme' => 7]);
       
    }

}

class CourseSubcategorySeeder extends Seeder {

    public function run()
    {
        DB::table('course_subcategories')->delete();
        CourseSubcategory::unguard();
        CourseSubcategory::create( ['name' => 'javascript', 'slug' => 'javascript', 
                                 'description' => 'JS Programing', 'courses_count' => 0, 'course_category_id' => 1 ]);
        CourseSubcategory::create( ['name' => 'Business Subcat', 'slug' => 'business-subcat', 
                                 'description' => 'Beez Kneez subcat', 'courses_count' => 0, 'course_category_id' => 2 ]);
        CourseSubcategory::create( ['name' => 'Investments subcat', 'slug' => 'investments-subcat', 
                                 'description' => 'Mo money', 'courses_count' => 0, 'course_category_id' => 3  ]);
        CourseSubcategory::create( ['name' => 'Music subcat', 'slug' => 'music-subcat', 
                                 'description' => 'Tokyo Square, nom sayin', 'courses_count' => 0, 'course_category_id' => 4  ]);
        CourseSubcategory::create( ['name' => 'Beauty subcat', 'slug' => 'beauty-subcat', 
                                 'description' => 'Stop being ugly', 'courses_count' => 0, 'course_category_id' => 5  ]);
        CourseSubcategory::create( ['name' => 'Health subcat', 'slug' => 'health-subcat', 
                                 'description' => 'Fat it up bro!', 'courses_count' => 0, 'course_category_id' => 6  ]);
        CourseSubcategory::create( ['name' => 'php', 'slug' => 'php', 
                                 'description' => 'PHP Programing', 'courses_count' => 0, 'course_category_id' => 1 ]);

       
    }

}

class CourseDifficultySeeder extends Seeder {

    public function run()
    {
        DB::table('course_difficulties')->delete();
        CourseDifficulty::unguard();
        CourseDifficulty::create( ['name' => 'Beginner'] );
        CourseDifficulty::create( ['name' => 'Intermediate'] );
        CourseDifficulty::create( ['name' => 'Expert'] );       
       
    }
}

class CoursesSeeder extends Seeder {

    public function run()
    {
        DB::table('courses')->delete();
        Course::unguard();
        // IT Courses
        Course::create( ['name' => 'App Development', 'slug' => 'app-development', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 1
                        , 'price' => rand(1,100), 'course_difficulty_id' => 1, 'course_preview_image_id' => 1,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'short_description' => 'Short:  You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0, 'requirements' => '[]',
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Javascript Primer', 'slug' => 'javascript-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 1,
                        'price' => rand(1,100), 'course_difficulty_id' => '2',
                        'description' => 'JS - the best language around.',
                        'short_description' => 'Short: JS - the.',
                        'student_count' => 0,  'requirements' => '[]',
                        'course_preview_image_id' => 2, 'featured' => 1, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]'
                        ]);
        Course::create( ['name' => 'PHP Primer', 'slug' => 'php-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,
                        'price' => rand(1,100), 'course_difficulty_id' => 3,
                        'description' => 'PHP - the best language around.', 
                        'short_description' => 'Short: PHP - the best language around.', 
                        'student_count' => 0,   'requirements' => '[]',
                        'course_preview_image_id' => 3, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'PHP Primer Revisited', 'slug' => 'php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,   
                        'price' => rand(1,100), 'course_difficulty_id' => 3,
                        'description' => 'PHP - the best language around. REVISITED.', 
                        'short_description' => 'Short: REVISITED.',  'requirements' => '[]',
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Business Courses
        Course::create( ['name' => 'Business App Development', 'slug' => 'business-app-development', 'instructor_id' => 4, 'course_category_id' => 2, 'course_subcategory_id' => 2, 
                        'price' => rand(1,100), 'course_difficulty_id' => 1,  'course_preview_image_id' => 4,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'short_description' => 'Short Create your very first.',  'requirements' => '[]',
                        'student_count' => 1, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Investments Courses
        Course::create( ['name' => 'Investments App Development', 'slug' => 'investments-app-development', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
                        'price' => rand(1,100), 'course_difficulty_id' => 1, 'course_preview_image_id' => 5, 'requirements' => '[]',
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 2, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Investments Javascript Primer', 'slug' => 'investments-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
                        'price' => 185000.99, 'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0, 'requirements' => '[]',
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Music Courses
        Course::create( ['name' => 'Music App Development', 'slug' => 'music-app-development',  'instructor_id' => 4,'course_category_id' => 4, 'course_subcategory_id' => 4,  'price' => rand(1,100),
                        'course_difficulty_id' => 1, 'course_preview_image_id' => 6, 'affiliate_percentage' => 0,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'requirements' => '[]',
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Beauty Courses
        Course::create( ['name' => 'Beauty App Development', 'slug' => 'beauty-app-development', 'instructor_id' => 4, 'course_category_id' => 5, 'course_subcategory_id' => 5,  'price' => rand(1,100),
                        'course_difficulty_id' => 1, 'requirements' => '[]',
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty Javascript Primer', 'slug' => 'beauty-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 'price' => rand(1,100),
                        'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 'student_count' => 0, 
                        'privacy_status' => 'public', 'affiliate_percentage' => 0, 'requirements' => '[]',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty PHP Primer', 'slug' => 'beauty-php-primer', 'instructor_id' => 4, 'course_category_id' => 5,   'course_subcategory_id' => 5, 
                        'price' => rand(1,100), 'course_difficulty_id' => 3, 'affiliate_percentage' => 0,
                                 'description' => 'PHP - the best language around.', 'student_count' => 0,  'course_preview_image_id' => 7,
                        'privacy_status' => 'public', 'requirements' => '[]',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty PHP Primer Revisited', 'slug' => 'beauty-php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 
                        'price' => rand(1,100), 'course_difficulty_id' => 3, 'affiliate_percentage' => 0, 'requirements' => '[]',
                                 'description' => 'PHP - the best language around. REVISITED.', 'student_count' => 0, 'privacy_status' => 'public',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Health Courses
        Course::create( ['name' => 'Health App Development', 'slug' => 'health-app-development', 'instructor_id' => 4, 'course_category_id' => 6,  'course_subcategory_id' => 6, 
                        'price' => rand(1,100),  'course_difficulty_id' => 1,  'course_preview_image_id' => 8,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0, 'requirements' => '[]',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        
        CourseBannerImage::$skip_upload = true;
        CourseBannerImage::create( ['instructor_id' => 11, 'url' => 'https://wazaar.s3.amazonaws.com/course_preview/banner-55031453941e2.jpg'] );
        
        Course::create( ['name' => '３ヶ月で10キロ痩せてハイパフォーマーになる『体』やり直し講座', 'instructor_id' => 11, 'course_category_id' => 6,  
                        'course_subcategory_id' => 6, 'course_banner_image_id' => 1, 'requirements' => '[]',
                        'price' => rand(1,100),  'course_difficulty_id' => 1,  'course_preview_image_id' => 9,
                        'description' => '
                            正直に告白します。
<br /><br />
率直に言って、本講座は、すべての人のためのものでありません。
<br /><br />
ご購入いただいても、全ての人のお役に立つことはできませんので、
もし、間違って購入してしまった場合は、30日以内であれば、全額返金させていただきます。
<br /><br />
しかし、あなたが30〜40代の男性会社員でかつ、
【このコースの対象者】に記載されているような
健康上の問題があって、それをなんとか解決して、
最高のコンディションで仕事をしたい！と考えるなら
本講座は必ずあなたのお役に立てると確信しています。
<br /><br />
【体は資本】というのは、ビジネスの世界ではよく使われます。
<br /><br />
体が良いコンディションでなければ、
ここ一番の商談や重要なミーティングで
いい結果を残すことは難しいですから。
<br /><br />
『20代の頃は朝まで飲んでも寝ずに仕事なんてザラだった。』
こんな武勇伝の１つや２つはあなたも持っているでしょう。
<br /><br />
しかし、30代に入って、朝まで飲んで寝ずに仕事！なんて生活をしていると、
疲れが全く抜けず、体はひどく重く感じ、仕事中に息切れに立ち眩みなんてことが
日常茶飯事になります。
<br /><br />
体が完全に悲鳴を上げており、
気がつけばお腹はぽっこりと膨らんでいます。
<br /><br />
健康管理は二の次、
とにかく目の前の仕事をがむしゃらに頑張って、
気合と根性で乗り切るという
ラグビー部や、アメリカンフットボール部のような
超体育会系ののりが許されるのは、20代までです。
<br /><br />
30代になると、20代と比較しても基礎代謝が落ちているので、
毎日規則正しく「同じ生活」「同じ食事量」を保っていたとしても
気がつけば確実に太っていきます。
<br /><br />
さらに、過度な飲酒や、運動不足、不適切な食生活、喫煙を続けると、
内蔵脂肪はどんどんたまり、もっとも怖い病気、つまり、動脈硬化、
高脂血症、血栓症、高血圧、糖尿病などの生活習慣病をひき起こします。
<br /><br />
この状態が悪化すると、
仕事どころか日常生活は完全に支障を来たしますし
残りの人生をベットの上で要介護状態になります。
<br /><br />
周りの知人や親戚で生活習慣病を
引き起こしている人の話を、
一人や二人は聞いたことありませんか？
<br /><br />
今は他人の話ですが、あなたも
このまま健康問題を放っておくと、
あなた自身の問題として、
いつかブーメランのように戻ってきます。
<br /><br />
お金を持っていると、
すぐに散財してしまう人は家計簿をつけて、
お金の管理をできるようになることは非常に大切なことです。
<br /><br />
それと同じように、
不健康な生活をしていて、
将来的に【生活習慣病】を引き起こすリスクがある人も、
バランスの取れた食事や適度な有酸素運動や筋肉トレーニングによって、
健康な生活習慣を身につけて、体をコントロールする術を学ぶことも
とても大切になっています。
<br /><br />
冒頭から長々と話してしまいましたが、
<br /><br />
自己紹介が遅れて申し訳ございません。
<br /><br />
はじめまして。
<br /><br />
私は谷けいじと申します。
<br /><br />
東京都内でパーソナルジムの運営をしながら、
実際におなかが出始めた会社員を
3ヶ月で10ｋｇ痩せさせて、ビジネスパーソンとして
最高の体のコンディションを維持するための
トレーニングを指導しています。
<br /><br />
私は大学を卒業した後は、
スポーツトレーナーとしての道を選択し、
イチロー選手、三浦知良選手、 青木功選手、
杉山愛選手を指導する小山裕史先生に師事し、
筋肉の柔軟性を意識した初動負荷理論を利用した
トレーニング法で、香川県のトレーニングジムや
介護施設、複合型健康増進施設などで、
2歳から105歳のプロスポーツ選手からモデルまで
約2000名以上の方を実際に指導して、
健康問題を解決するお手伝いをしてきました。
<br /><br />
ですので、誰よりも健康についての理論を学び、
その理論でたくさんの人の健康問題を解決してきたことに
揺るぎない自信を持っています。
<br /><br />
みなさんの中には、
ありとあらゆるダイエットも
試されたことがある人もいるでしょう。
<br /><br />
朝バナナダイエット、断食ダイエット、
低炭水化物ダイエット、プロテインダイエット、
リンゴダイエットなどなど、世の中にはたくさんの
ダイエット方法があります。
<br /><br />
しかし、特定の食品に依存するダイエット法は、
肉体的にも精神的にもストレスがたまりやすく、
ちょっとしたことがきっかけで、
堤防が決壊したかのように、
ドカ食いしてしまい、
結局はリバウンドしてしまいがちです。
<br /><br />
また、同一人物とは全く思えない、
駅前の看板に掲載されている衝撃的な写真、
お腹がぽっこり出た写真と、お腹がシックスパックに割れた
ビフォー・アフターの写真を見て、高額な費用を払い
、特定のプライベートジムに行かれたことがある人もいるでしょう。
<br /><br />
2ヶ月間、ご飯などの炭水化物は一切取らない。
食べていいいのは鶏肉、サラダ、プロテインにサプリのみ。
<br /><br />
これで筋肉トレーニングを
2ヶ月間ガンガンすれば体重は確実に減り、
シックパックにはなることは私も保証します。
<br /><br />
ただし、
ここに大きな落とし穴がありますし、
多くの人はそれに気づいていません。
<br /><br />
このトレーニング方法では、
将来的な健康は全く考慮されていない上に、
過度に偏った食生活のため、
2ヶ月間のストイックなトレーニングを過ごした後は
今まで制限されていた食べ物を急激に食べてしまい、
リバンドしてしまう人がたくさんいるのです。
<br /><br />
事実、私のトレーニングジムでは
大手のプライベートジムで高額なお金を払い、
2ヶ月の厳しいトレーニングにも耐えて、
見事なシックスパックの体を手に入れたにも関わらず、
結局、また元のぽっこりお腹が出たビジネスパーソンからの
入会が後を絶たないという状況です。
<br /><br />
では、どうすれば
苦々しいぽっこりと出たお腹をひっこめ、
イチロー選手のように、24時間/365日、
最高の体のコンディションを維持できる
一流ビジネスパーソンのボディを手に入れる
ことができるのでしょうか？
<br /><br />
ご存知のように、
世の中にはダイエットに
関する情報が散乱しています。
<br /><br />
健康に関する情報も散乱していますが、
厚生労働省の調査によると、30〜40代男性の
30％は肥満ですし、別の言い方をすれば、
生活習慣病予備軍になります。
<br /><br />
多くの人は情報社会の中で、
日々たくさんの情報に接しているので、
どの情報が良いのかどうが迷ってしまい、
結局は行動できないか、もしくは、
熟考に熟考を重ねた結果、残念なことに
明らかに誤った方法を選択するケースが
よくあります。
<br /><br />
しかし、初動負荷理論を徹底的に学び、
2,000以上のクライアントを健康に導いた私は
あるときに気づきました。
<br /><br />
お腹がぽっこり出た、
不健康極まりない会社員でも、
私のトレーニング法に従えば、
お腹はすぐに引込み、顔色は良くなり、
生活習慣病におびえていた日々は嘘のように
最高の体のコンディションを24時間/365日
維持できる一流ビジネスパーソンのボディを
手に入れる秘訣を発見したのです。
<br /><br />
私のトレーニングでは、
あなたが健康な体を取り戻すために、
・特定の食品だけを食べ続けたり、
・筋トレだけをがむしゃらにやり続けたり
ということは実施しません。
<br /><br />
私のトレーニングで、
筋力トレーニング、脂肪を落とすトレーニング、食事改善以上に
重視しているものがあります。
<br /><br />
それは、
イチロー選手、三浦知良選手、 青木功選手、杉山愛選手も
実施している、初動負荷理論を応用した体の柔軟性を極限まで
高めるトレーニングです。
<br /><br />
体の柔軟性を高める
トレーニングを実施すると、
体の新陳代謝が一気に上がります。
<br /><br />
その結果、
疲れを感じづらくなりますし、
肩こりがなくなり、腰痛も緩和します。
<br /><br />
さらに、ストレスの度合いが大幅に減少し、
重かった体もすっかり軽く感じます。
<br /><br />
体の体調がよくなり、
仕事の集中力が上がりますので、
ミスが減り、残業時間が減って、
仕事の業績も上がります。
<br /><br />
おまけに、体はキレッキレッに
なりますから、スーツが似合い
モテるようになります。
<br /><br />
本講座では、3ヶ月間を
１プラス3つのフェーズに分けて、
各フェーズごとに、トレーニングの効果を
最大限に高めるために、
<br /><br />
・体の柔軟性を高めるトレーニング
・脂肪を落とすトレーニング
・筋力トレーニング下記のトレーニング
の内容と配分を変えていきます。
<br /><br />
さらに10項目に及ぶ門外不出の成功の鍵を
私、谷けいじからあなたにお伝えします。
<br /><br />
想像してみてください。
<br /><br />
3ヶ月後、
あなたは悪夢のような日々にようやくピリオドを打ち、
ぽっこり出たお腹は完全に引込め、肩こりも腰痛もなく、
体は鳥のように軽く、最高のコンディションで仕事ができているのです。
<br /><br />
あなたはわずかな投資を惜しんで、
生活習慣病に怯えながら、生活する道を選びますか？
<br /><br />
それとも、私のもとで仕事ができる
一流ビジネスパーソンの健康ボディを手に入れますか？
<br /><br />
今すぐ、お申込みください。
最後までお読みいただき本当にありがとうございました。
<br /><br />
パーソナルトレーナー　
谷けいじ
<br /><br />
P.S 
<br /><br />
私には悪夢のような思い出があります。
<br /><br />
将来的に、
体操のオリンピック代表選手を目指し
厳しいながらも夢のある生活を送っていた
高校二年生のある日、
重度の腰椎椎間板ヘルニアを発症し 
体を全く曲げることもできず、
授業も立って受けることしかできないという
ドン底の状況に陥ったのです。
<br /><br />
鍼灸、カイロプラクティック、整体、そして飲み薬など
ありとあらゆる方法を試しましたが完全に駄目でした。
<br /><br />
「もう一生大好きな体操をすることができないのか？」
そう思うと悔しくて悔しくて涙が止まりませんでした。
<br />
そんな絶望の淵にいた私を救ってくれたのが、
私の自宅の近所で、初動負荷理論を応用した
トレーニングを指導していた先生だったのです。
<br /><br />
その先生の指導によるリハビリの結果、
ヘルニアは完治し、高校三年生の国体では
香川県チームとして、史上初の決勝に進出し
私はキャプテンとして大活躍することができました。
<br /><br />
その時の経験から、
私は一人でも多くの人々の健康問題を解決する、
昔、私を救ってくれた先生のような
素晴らしいトレーナーになろうと決意したのです。
<br /><br />
本動画を通して一人でも
多くの方の健康問題を解決できることを
心から楽しみにしております。
', 
                        'short_description' => '「モテボディ養成講座（仮）」（フロント）',
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '[
                             "どんなに眠っても疲れが取れないと感じる人",
                             "体がものすごく重いと感じる人",
                             "仕事中によく目眩がする人",
                             "肩こりがひどいと感じる人",
                             "ぽっこり出たお腹が気になる人",
                             "肥満で股擦れを起こしている人",
                             "会社の健康診断で生活習慣病と診断された人",
                             "運動や食事で生活習慣を変えたいが、具体的にどうすればよいのかわからない人",
                             "最高のコンディションを常に維持したいと思う人",
                             "ダイエットをしてリバウンドをしない方法を知りたい人",
                             "とにかくダイエットと名のつくものに全て手を出して失敗した人",
                             "高額プライベートジムに行きたいがお金がない人"
                            ]',
                        'what_will_you_achieve' => '[
                            "一日16時間働いても疲れを感じないコンディション",
                            "健康問題に不安を感じない最高の安心感",
                            "肩こり、腰痛を感じない元気な体",
                            "20代のようなキレッキレッの体",
                            "ぽっこりお腹解消、割れた腹筋",
                            "リバウンドしない体とその理論",
                            "20代のような若々しい体の張り、潤い。",
                            "かっこ良くスーツを着こなすモテボディ",
                            "女性社員からの羨望の眼差し",
                            "150%アップの集中力",
                            "残業時間が減り、プライベート時間が増える。",
                            "会社からの赤丸急上昇の評価、昇給"
                            ]']);
        
        $phpPrimer = Course::find(3);
        $phpPrimer->student_count = 242;
        $d = date('Y-m-d H:i:s', strtotime('6 month ago') );
        $phpPrimer->created_at = $d;
        $phpPrimer->updateUniques();
        $js = Course::find(2);
        $js->sale = '33';
        $js->sale_kind = 'percentage';
        $js->sale_ends_on = date('Y-m-d H:i:s', strtotime('+ 4 day 2 hour'));
        $js->updateUniques();
        $js = Course::find(14);
        $js->sale = '20';
        $js->sale_kind = 'percentage';
        $js->sale_ends_on = date('Y-m-d H:i:s', strtotime('+ 4 day 2 hour'));
        $js->updateUniques();
        
        DB::table('courses')->update( [ 'publish_status' => 'approved' ] );
    }
}
    
class PurchasesSeeder extends Seeder {

    public function run()
    {
        DB::table('purchases')->delete();
        Purchase::unguard();
        Purchase::create( ['product_id' => 6, 'product_type' => 'Course', 'student_id' => 3, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5] );
        Purchase::create( ['product_id' => 5, 'product_type' => 'Course', 'student_id' => 3, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 2] );
        Purchase::create( ['product_id' => 6, 'product_type' => 'Course', 'student_id' => 9, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5] );
        Purchase::create( ['product_id' => 5, 'product_type' => 'Course', 'student_id' => 9, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5,
            'purchase_price' => 50] );
        Purchase::create( ['product_id' => 10, 'product_type' => 'Lesson', 'student_id' => 8, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5,
            'purchase_price' => 20] );
       
    }
}
    
class CoursePreviewImagesSeeder extends Seeder {

    public function run()
    {
        DB::table('course_preview_images')->delete();
        CoursePreviewImage::unguard();
        CoursePreviewImage::$skip_upload = true;
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905cbf4783a.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905cf824c1c.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905d56385ce.png'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905dd23aa96.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905e2a26130.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905e55b4886.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/54905e838a388.jpg'] );
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://wazaardev.s3.amazonaws.com/course_preview/demo-course.jpg'] );
       
    }
}


class ModulesSeeder extends Seeder {

    public function run()
    {
        DB::table('modules')->delete();
        Module::unguard();
        Module::create( ['course_id' => 1, 'name' => 'First Module', 'order' => 1] );
        Module::create( ['course_id' => 1, 'name' => 'Second Module', 'order' => 2] );
        Module::create( ['course_id' => 1, 'name' => 'Last Module', 'order' => 3] );
       
        Module::create( ['course_id' => 5, 'name' => 'First Module', 'order' => 1] );
        Module::create( ['course_id' => 5, 'name' => 'Second Module', 'order' => 2] );
        Module::create( ['course_id' => 5, 'name' => 'Last Module', 'order' => 3] );
        
        Module::create( ['course_id' => 14, 'name' => 'The Right Diet', 'order' => 1] );
        Module::create( ['course_id' => 14, 'name' => 'Workouts', 'order' => 2] );
       
    }
}


class LessonsSeeder extends Seeder {

    public function run()
    {
        DB::table('lessons')->delete();
        Lesson::unguard();
        Lesson::create( ['module_id' => 1, 'name' => 'Welcome', 'order' => 1, 'description' => '1A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 1, 'name' => 'Advanced Stuff', 'order' => 2, 'description' => '2A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 2, 'name' => 'More Advanced Stuff', 'order' => 1, 'description' => '3A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 2, 'name' => 'Second Module Review', 'order' => 2, 'description' => '4A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 2, 'name' => 'Second Module Conclusion', 'order' => 3, 'description' => '5A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 3, 'name' => 'Let\'s recap', 'order' => 1, 'description' => '6A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 3, 'name' => 'Now that you know', 'order' => 2, 'description' => '7A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 3, 'name' => 'We\'re almost done', 'order' => 3, 'description' => '8A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 3, 'name' => 'Thank you, come again', 'order' => 4, 'description' => '9A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes', 'price'=>2] );
        
        Lesson::create( ['module_id' => 4, 'name' => 'Welcome', 'order' => 1, 'description' => '1A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 4, 'name' => 'Advanced Stuff', 'order' => 2, 'description' => '2A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'More Advanced Stuff', 'order' => 1, 'description' => '3A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'Second Module Review', 'order' => 2, 'description' => '4A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'Second Module Conclusion', 'order' => 3, 'description' => '5A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Let\'s recap', 'order' => 1, 'description' => '6A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Now that you know', 'order' => 2, 'description' => '7A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'We\'re almost done', 'order' => 3, 'description' => '8A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Thank you, come again', 'order' => 4, 'description' => '9A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes', 'price'=>2] );
        
        Lesson::create( ['module_id' => 7, 'name' => 'Vegetables', 'order' => 1, 'description' => 'Vegetables', "published" => 'yes'] );
        Lesson::create( ['module_id' => 7, 'name' => 'Macro Nutrients', 'order' => 2, 'description' => 'Macro Nutrients', "published" => 'yes'] );
        Lesson::create( ['module_id' => 7, 'name' => 'Tubers', 'order' => 3, 'description' => 'Tubers', "published" => 'yes'] );
        
        Lesson::create( ['module_id' => 8, 'name' => 'Arms', 'order' => 1, 'description' => 'Arms', "published" => 'yes'] );
        Lesson::create( ['module_id' => 8, 'name' => 'Shoulders', 'order' => 2, 'description' => 'Shoulders', "published" => 'yes'] );
        Lesson::create( ['module_id' => 8, 'name' => 'Legs', 'order' => 3, 'description' => 'Legs', "published" => 'yes'] );
    }
}


class VideosSeeder extends Seeder {

    public function run()
    {
        /*DB::table('videos')->delete();
        Video::unguard();
        Video::create( [ 'original_filename' => '9LoQlTLkj6DCaDdo1421660966371o9l23s.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                                'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        DB::table('video_formats')->delete();
        VideoFormat::unguard();
        VideoFormat::insert( [ 'video_id' => 1, 'output_key' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s.mp4', 'preset_id' => '1421660966371-o9l23s',
            'resolution' => 'Custom Preset for Mobile Devices', 'duration' => 9, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s-00001.png',
            'video_url' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s.mp4' ] );
        
        VideoFormat::insert( [ 'video_id' => 1, 'output_key' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4', 'preset_id' => '1421661161826-cx6nmz',
            'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 9, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
            'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );     */

        DB::table('videos')->delete();
        Video::unguard();
        Video::create( [ 'original_filename' => '9LoQlTLkj6DCaDdo1421660966371o9l23s.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );

        Video::create( [ 'original_filename' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );

        Video::create( [ 'original_filename' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video1.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video2.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video3.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'vidoe4.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video5.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video6.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );
        Video::create( [ 'original_filename' => 'video7.mp4', 'transcode_status' => 'Complete', 'created_by_id' => 4,
                         'input_key' => 'MRSIjNWfPAw1uqHl', 'transcode_job_id' => '1423833200559-5oxoy9' ] );

        DB::table('video_formats')->delete();
        VideoFormat::unguard();
        VideoFormat::insert( [ 'video_id' => 1, 'output_key' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s.mp4', 'preset_id' => '1421660966371-o9l23s',
                               'resolution' => 'Custom Preset for Mobile Devices', 'duration' => 66, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421660966371o9l23s.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 1, 'output_key' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 66, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 2, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 80, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 2, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 80, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 3, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 155, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 3, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 155, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 4, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 122, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 4, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 122, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 5, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 155, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 5, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 155, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 6, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 200, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 6, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 200, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 7, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 30, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 7, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 30, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 8, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 67, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 8, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 67, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 9, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 45, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 9, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 45, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );

        VideoFormat::insert( [ 'video_id' => 10, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 12, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
        VideoFormat::insert( [ 'video_id' => 10, 'output_key' => '0DS3K8sSnZdXObUd1421660966371o9l23s.mp4', 'preset_id' => '1421661161826-cx6nmz',
                               'resolution' => 'Custom Preset for Desktop Devices', 'duration' => 12, 'thumbnail' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz-00001.png',
                               'video_url' => 'MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4' ] );
    }
}

class BlocksSeeder extends Seeder {

    public function run()
    {
        DB::table('blocks')->delete();
        Block::unguard();
        Block::create( ['lesson_id' => 10, 'name' => 'Test Block','type' => 'text', 
            'content' => '"The service was excellent. Dude, your stuff is the bomb! I am really satisfied with my cocorium. 
                Without cocorium, we would have gone bankrupt by now." - Truda V.'] );
        Block::create( ['lesson_id' => 10, 'name' => 'Test Block','type' => 'text', 
            'content' => 'Second text block right here m8'] );
        Block::create( ['lesson_id' => 10, 'name' => 'First File','type' => 'file', 'mime' => 'image/jpeg', 'key' => 'course_uploads/file-5526bab93ea21.jpg',
            'content' => 'https://wazaardev.s3.amazonaws.com/course_uploads/file-5526bab93ea21.jpg'] );
        Block::create( ['lesson_id' => 10, 'name' => 'Second File','type' => 'file', 'mime' => 'image/jpeg', 'key' => 'course_uploads/file-5526bab93ea21.jpg',
            'content' => 'https://wazaardev.s3.amazonaws.com/course_uploads/file-5526bab93ea21.jpg'] );
        Block::create( ['lesson_id' => 10, 'name' => 'Third File','type' => 'file', 'mime' => 'image/jpeg', 'key' => 'course_uploads/file-5526bab93ea21.jpg',
            'content' => 'https://wazaardev.s3.amazonaws.com/course_uploads/file-5526bab93ea21.jpg'] );
        Block::create( ['lesson_id' => 10, 'name' => 'First Video Ever','type' => 'video', 
            'content' => '1'] );
       
    }
}

class ProfileSeeder extends Seeder {

    public function run()
    {
        DB::table('user_profiles')->delete();
        Profile::unguard();

        Profile::create( ['owner_id' => User::where('username','albert')->first()->id , 'owner_type' => 'Student','first_name' => 'Albert', 'last_name' => 'Maranian', 'email' => 'albert@mailinator.com']);
        Profile::create( ['owner_id' => 2, 'owner_type' => 'Affiliate','first_name' => 'Wazaar', 'last_name' => 'Affiliate', 'email' => 'wazaarAffiliate@wazaar.jp', 'bio' => 'hi', 'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg', 'created_at' => \Carbon\Carbon::now()]);
        Profile::create( ['owner_id' => 5, 'owner_type' => 'Instructor','first_name' => 'Wazaar', 'last_name' => 'Instructor', 'email' => 'wazaarInstructor@wazaar.jp', 'bio' => 'hi', 'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg', 'created_at' => \Carbon\Carbon::now()]);
        Profile::create( ['owner_id' => 11, 'owner_type' => 'Instructor','first_name' => 'Keiji', 'last_name' => 'Tani', 'email' => 'Tani@mailinator.com',
            'bio' => '谷啓嗣（たにけいじ） <br />
1986年2月15日生まれ　香川県出身<br />
<br />
初動負荷理論の専門家かつ、<br />
30代・軽肥満の男性会社員を<br />
たったの３ヶ月で、24時間/365日<br />
最高のコンディションで仕事ができる<br />
ハイパフォーマーに変えるスペシャリスト、<br />
<br />
高校時代は体操競技で数多くの全国大会に出場。<br />
<br />
高校三年のインターハイでは準決勝、その後の<br />
国体では香川県チームとして史上初の決勝に進出した。<br />
<br />
福岡大学スポーツ科学部を卒業後は<br />
スポーツトレーナーとしての道を選択し、<br />
イチロー選手、三浦知良選手、 青木功選手、<br />
杉山愛選手を指導する小山裕史先生に師事。<br />
<br />
鳥取での180日間無休の超過酷な研修生活<br />
を見事乗り越えて、初動負荷理論の正式な<br />
トレーナーとして認定を受ける。<br />
<br />
その後、香川県のトレーニングジムや<br />
介護施設、複合型健康増進施設などで、<br />
2歳から105歳のプロスポーツ選手から<br />
モデルまで幅広いクライアント、<br />
2000名以上に指導した実績を持つ。<br />
<br />
2014年から、生活拠点を香川から東京に変えて、<br />
現在は都内でパーソナルトレーナーとして指導を実施中。<br />
健康に関するセミナーを多数開催している。<br />
<br />
初動負荷理論に裏付けられた確たる理論と<br />
幅広いクライアントに接した経験に基づく指導力は<br />
すぐに評判になり、2015年６月現在、<br />
谷の指導を求めるパーソナルトレーニングは<br />
半年先まで予約が埋まっている。',
            'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg'] );

    }
}

class TestimonialsSeeder extends Seeder {

    public function run()
    {
        DB::table('testimonials')->delete();
        Testimonial::unguard();
        Testimonial::create( ['course_id' => 5, 'student_id' => '3', 'rating'=>'positive', 'thumbs_up' => 3, 'thumbs_down' => 1,
            'content' => 'Dude, your stuff is the bomb! Business App Development is awesome! Really good.'] );
        Testimonial::create( ['course_id' => 5, 'student_id' => '9', 'rating'=>'positive', 'thumbs_up' => 0, 'thumbs_down' => 0,
            'content' => 'I have gotten at least 50 times the value from Business App Development. We\'re loving it.'] );
        Testimonial::create( ['course_id' => 5, 'student_id' => '4', 'rating'=>'positive', 'thumbs_up' => 1, 'thumbs_down' => 1,
            'content' => 'Testimonial 3'] );
        Testimonial::create( ['course_id' => 5, 'student_id' => '5', 'rating'=>'positive', 'thumbs_up' => 9, 'thumbs_down' => 9,
            'content' => 'Testimonial 4'] );
        Testimonial::create( ['course_id' => 5, 'student_id' => '6', 'rating'=>'positive', 'thumbs_up' => 15, 'thumbs_down' => 251,
            'content' => 'Some bad spam over here'] );
        Testimonial::create( ['course_id' => 5, 'student_id' => '7', 'rating'=>'positive', 'thumbs_up' => 100, 'thumbs_down' => 12,
            'content' => 'Testimonial 6'] );
        
        
        Testimonial::create( ['course_id' => 14, 'student_id' => '12', 'rating'=>'positive', 'thumbs_up' => 100, 'thumbs_down' => 12,
            'content' => '先生が御自分のエピソードを話のですが、この話が笑ってしまうほど自分とソックリ！悩んでいる人は同じ行動を取るんだな～と間違って遠回りしてしまった自分を恥じることなく、今からでも間に合うんだ！と勇気づけられました。正しいブラジャーの選び方から始まり、基本は大胸筋の鍛え方が重要という事で簡単で毎日続けられそうな体操を伝授してくれます。チャプター２での質問コーナーでも、まさに自分が知りたかった事が幾つも出てきて参考に成ります。チャプター３の実践では胸の問題なのに体全体が関わっていることを再確認しながら各部位のマッサージが丁寧に解説してもらえるのはトテモ参考に成ります。'] );
        Testimonial::create( ['course_id' => 14, 'student_id' => '13', 'rating'=>'positive', 'thumbs_up' => 100, 'thumbs_down' => 12,
            'content' => '
                歳をとっても、若い頃のようなバストをキープする事はパートナーへのアピール以上に自分の自信にもつながりますから、バストアップだけでなく、きちんとキープする方法、下着の正しい選び方、マッサージや、美肌、食生活、女性ホルモン分泌アップなど、多岐に渡る内容は、バストアップだけじゃなく、よりオールマイティな女性力アップ＆キープにつながってるところがすごいっ！
                <br />
                あいてる時間に簡単に観る事ができて、忙しい私には本当に便利でした！
                '] );
        Testimonial::create( ['course_id' => 14, 'student_id' => '14', 'rating'=>'positive', 'thumbs_up' => 100, 'thumbs_down' => 12,
            'content' => '下半身太りでむくみが気になる体質なのでバストアップだけでなくその解決方法もしれて良かったです！'] );
       
    }
}

class InstructorAgenciesSeeder extends Seeder {

    public function run()
    {
        $agencyRole = Role::where('name','=','InstructorAgency')->first();
        $agency1 = new User( [ 'username' => 'InstructorAgency1', 'email'=>'agency@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ] );
        $agency1->password = 'pass';
        $agency1->password_confirmation = 'pass';
        $agency1->agency_balance = 200;
        $agency1->save();
        $agency1->attachRole( $agencyRole );

        $agency2 = new User(['username' => 'InstructorAgency2', 'email'=>'agency2@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ]);
        $agency2->password = 'pass';
        $agency2->password_confirmation = 'pass';
        $agency2->save();
        $agency2->attachRole( $agencyRole );
        
        $agency3 = new User(['username' => 'InstructorAgency3', 'email'=>'agency3@mailinator.com','password' => 'pass', 
            'confirmation_code' =>  md5(uniqid(mt_rand(), true)), 'confirmed' => 1, 'ltc_affiliate_id' => 2 ]);
        $agency3->password = 'pass';
        $agency3->password_confirmation = 'pass';
        $agency3->save();
        $agency3->attachRole( $agencyRole );      
        
        DB::table('users')->where('username','instructor')->update(['instructor_agency_id' => $agency1->id]);

    }
}

class PMSeeder extends Seeder {

    public function run()
    {
        DB::table('private_messages')->delete();
        PrivateMessage::unguard();
        
        PrivateMessage::create( ['sender_id' => '9', 'recipient_id' => 4, 'thread_id' => 0, 'type' => 'ask_teacher', 'course_id' => '5',
            'lesson_id' => 10, 'content' => 'Ask Thy Teachereth'] );
        PrivateMessage::create( ['sender_id' => '4', 'recipient_id' => 9, 'thread_id' => 1, 'type' => 'ask_teacher', 'course_id' => '5',
            'lesson_id' => 10, 'content' => 'teacher answereth'] );
        PrivateMessage::create( ['sender_id' => '9', 'recipient_id' => 4, 'thread_id' => 1, 'type' => 'ask_teacher', 'course_id' => '5',
            'lesson_id' => 10, 'content' => '1'] );
        PrivateMessage::create( ['sender_id' => '9', 'recipient_id' => 4, 'thread_id' => 1, 'type' => 'ask_teacher', 'course_id' => '5',
            'lesson_id' => 10, 'content' => 'thank you men'] );
        PrivateMessage::create( ['sender_id' => '4', 'recipient_id' => NULL, 'thread_id' => 0, 'type' => 'mass_message', 'course_id' => '5',
            'lesson_id' => 10, 'content' => '2'] );
        PrivateMessage::create( ['sender_id' => '4', 'recipient_id' => NULL, 'thread_id' => 0, 'type' => 'mass_message', 'course_id' => '5',
            'lesson_id' => 10, 'content' => 'mass message yall'] );
        PrivateMessage::create( ['sender_id' => '7', 'recipient_id' => 9, 'thread_id' => 0, 'type' => 'student_conversation', 'course_id' => '0',
            'lesson_id' => 10, 'content' => 'sup m8?'] );
        PrivateMessage::create( ['sender_id' => '8', 'recipient_id' => 9, 'thread_id' => 0, 'type' => 'student_conversation', 'course_id' => '0',
            'lesson_id' => 10, 'content' => 'sup m7+1?'] );
        
    }
       
}


class TransactionsSeeder extends Seeder {

    public function run()
    {
        Transaction::unguard();
        Transaction::create( ['user_id' => 9, 'transaction_type' => 'student_balance_debit', 'amount' => 500,
            'product_type' => 'Course', 'product_id' => 1, 'status' => 'complete' ] );
        Transaction::create( ['user_id' => 9, 'transaction_type' => 'student_debit', 'amount' => 1500,
            'product_type' => 'Course', 'product_id' => 1, 'status' => 'complete' ] );
        Transaction::create( ['user_id' => 9, 'transaction_type' => 'student_credit', 'amount' => 100, 'status' => 'complete' ] );
        $transaction = Transaction::create( ['user_id' => 9, 'transaction_type' => 'student_balance_debit', 'amount' => 100,
            'product_type' => 'Lesson', 'product_id' => 2, 'status' => 'pending' ] );
        $student = Student::find(9);
        $student->refundBalanceDebit( $transaction ); 
    }
}

class FrontpageVideosSeeder extends Seeder {

    public function run()
    {
        FrontpageVideo::unguard();
        for($i = 0; $i<4; ++$i){
            for($j = 0; $j < 6; ++$j){
                $type = ($j == 0) ? 'big' : 'small';
                $id = 0;
                if($i==0 && $j == 0 ) $id = 1;
                if($i==1 && $j == 0 ) $id = 2;
                FrontpageVideo::create( ['course_id' => $id, 'type' => $type] );
            }
        }
    }
}

class GiftSeeder extends Seeder {

    public function run()
    {
        $affiliate = User::where('username','affiliate')->first();
        $course = Course::where('name','Business App Development')->first();
        for($i = 0; $i<4; ++$i){
            $g = new Gift();
            $g->affiliate_id = $affiliate->id;
            $g->course_id = $course->id;
            $g->text = "Buy this and get gift # $i";
            $g->save();
        }
    }
}