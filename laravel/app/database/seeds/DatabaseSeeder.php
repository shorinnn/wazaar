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
		 $this->call('CoursePurchasesSeeder');
		 $this->call('CoursePreviewImagesSeeder');
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
        $user->save();
        $user = new User;
        $user->username = 'WazaarAffiliate';
        $user->affiliate_id = '2';
        $user->email = 'wazaarAffiliate@wazaar.jp';
        $user->password = 'random';
        $user->password_confirmation = 'random';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
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
        $user->save();
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
        $user->save();
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

    }

}


class CourseCategorySeeder extends Seeder {

    public function run()
    {
        DB::table('course_categories')->delete();
        CourseCategory::unguard();
        CourseCategory::create( ['name' => 'IT & Technology', 'slug' => 'it-and-technology', 
                                 'description' => 'Programming, Javascript, C++, etc...', 'courses_count' => 0 ]);
        CourseCategory::create( ['name' => 'Business', 'slug' => 'business', 
                                 'description' => 'Beez Kneez', 'courses_count' => 0 ]);
        CourseCategory::create( ['name' => 'Investments', 'slug' => 'investments', 
                                 'description' => 'Mo money', 'courses_count' => 0 ]);
        CourseCategory::create( ['name' => 'Music', 'slug' => 'music', 
                                 'description' => 'Tokyo Square, nom sayin', 'courses_count' => 0 ]);
        CourseCategory::create( ['name' => 'Beauty', 'slug' => 'beauty', 
                                 'description' => 'Stop being ugly', 'courses_count' => 0 ]);
        CourseCategory::create( ['name' => 'Health', 'slug' => 'health', 
                                 'description' => 'Fat it up bro!', 'courses_count' => 0 ]);
       
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
                        , 'price' => 300000, 'course_difficulty_id' => 1, 'course_preview_image_id' => 1, 
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'Javascript Primer', 'slug' => 'javascript-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 1,
                        'price' => 185000.99, 'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 'student_count' => 0, 
                        'course_preview_image_id' => 2, 'featured' => 1, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'PHP Primer', 'slug' => 'php-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,
                        'price' => 99.99, 'course_difficulty_id' => 3, 'description' => 'PHP - the best language around.', 'student_count' => 0,  
                        'course_preview_image_id' => 3, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'PHP Primer Revisited', 'slug' => 'php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,   
                        'price' => 99.99, 'course_difficulty_id' => 3, 'description' => 'PHP - the best language around. REVISITED.', 
                        'student_count' => 0, 'privacy_status' => 'public' ]);
        // Business Courses
        Course::create( ['name' => 'Business App Development', 'slug' => 'business-app-development', 'instructor_id' => 4, 'course_category_id' => 2, 'course_subcategory_id' => 2, 
                        'price' => 300000, 'course_difficulty_id' => 1,  'course_preview_image_id' => 4,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 1, 'privacy_status' => 'public' ]);
        // Investments Courses
        Course::create( ['name' => 'Investments App Development', 'slug' => 'investments-app-development', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
                        'price' => 300000, 'course_difficulty_id' => 1, 'course_preview_image_id' => 5,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 2, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'Investments Javascript Primer', 'slug' => 'investments-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
            'price' => 185000.99, 
                        'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 'student_count' => 0, 'privacy_status' => 'public' ]);
        // Music Courses
        Course::create( ['name' => 'Music App Development', 'slug' => 'music-app-development',  'instructor_id' => 4,'course_category_id' => 4, 'course_subcategory_id' => 4,  'price' => 300000, 
                        'course_difficulty_id' => 1, 'course_preview_image_id' => 6,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public' ]);
        // Beauty Courses
        Course::create( ['name' => 'Beauty App Development', 'slug' => 'beauty-app-development', 'instructor_id' => 4, 'course_category_id' => 5, 'course_subcategory_id' => 5,  'price' => 300000, 
                        'course_difficulty_id' => 1,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'Beauty Javascript Primer', 'slug' => 'beauty-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 'price' => 185000.99, 
                        'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 'student_count' => 0, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'Beauty PHP Primer', 'slug' => 'beauty-php-primer', 'instructor_id' => 4, 'course_category_id' => 5,   'course_subcategory_id' => 5, 
            'price' => 99.99, 'course_difficulty_id' => 3,
                                 'description' => 'PHP - the best language around.', 'student_count' => 0,  'course_preview_image_id' => 7, 'privacy_status' => 'public' ]);
        Course::create( ['name' => 'Beauty PHP Primer Revisited', 'slug' => 'beauty-php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 
            'price' => 99.99, 'course_difficulty_id' => 3,
                                 'description' => 'PHP - the best language around. REVISITED.', 'student_count' => 0, 'privacy_status' => 'public' ]);
        // Health Courses
        Course::create( ['name' => 'Health App Development', 'slug' => 'health-app-development', 'instructor_id' => 4, 'course_category_id' => 6,  'course_subcategory_id' => 6, 
            'price' => 300000, 
                        'course_difficulty_id' => 1,  'course_preview_image_id' => 8,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public' ]);
  
       
    }
}
    
class CoursePurchasesSeeder extends Seeder {

    public function run()
    {
        DB::table('course_purchases')->delete();
        CoursePurchase::unguard();
        CoursePurchase::create( ['course_id' => 6, 'student_id' => 3, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5] );
        CoursePurchase::create( ['course_id' => 5, 'student_id' => 3, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 2] );
        CoursePurchase::create( ['course_id' => 6, 'student_id' => 9, 'ltc_affiliate_id' => 2, 'product_affiliate_id' => 5] );
       
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
       
    }
}
