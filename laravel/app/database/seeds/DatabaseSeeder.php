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
                 $this->call('AffiliateAgenciesSeeder');
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
        CourseCategory::create( ['name' => 'IT & Technology', 'slug' => 'it-technology', 'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-7.png',
                                 'description' => 'Programming, Javascript, C++, etc...', 'courses_count' => 0, 'color_scheme' => 1 ]);
        CourseCategory::create( ['name' => 'Business', 'slug' => 'business',  'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-14.png',
                                 'description' => 'Beez Kneez', 'courses_count' => 0, 'color_scheme' => 8 ]);
        CourseCategory::create( ['name' => 'Investments', 'slug' => 'investments',  'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-12.png',
                                 'description' => 'Mo money', 'courses_count' => 0, 'color_scheme' => 6 ]);
        CourseCategory::create( ['name' => 'Music', 'slug' => 'music',  'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-8.png',
                                 'description' => 'Tokyo Square, nom sayin', 'courses_count' => 0, 'color_scheme' => 2 ]);
        CourseCategory::create( ['name' => 'Beauty', 'slug' => 'beauty',  'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-9.png',
                                 'description' => 'Stop being ugly', 'courses_count' => 0, 'color_scheme' => 3 ]);
        CourseCategory::create( ['name' => 'Health', 'slug' => 'health',  'graphics_url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-13.png',
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
                        , 'price' => 300000, 'course_difficulty_id' => 1, 'course_preview_image_id' => 1, 
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'short_description' => 'Short:  You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Javascript Primer', 'slug' => 'javascript-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 1,
                        'price' => 185000.99, 'course_difficulty_id' => '2', 
                        'description' => 'JS - the best language around.',
                        'short_description' => 'Short: JS - the.',
                        'student_count' => 0, 
                        'course_preview_image_id' => 2, 'featured' => 1, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]'
                        ]);
        Course::create( ['name' => 'PHP Primer', 'slug' => 'php-primer', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,
                        'price' => 99.99, 'course_difficulty_id' => 3, 
                        'description' => 'PHP - the best language around.', 
                        'short_description' => 'Short: PHP - the best language around.', 
                        'student_count' => 0,  
                        'course_preview_image_id' => 3, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'PHP Primer Revisited', 'slug' => 'php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 1, 'course_subcategory_id' => 7,   
                        'price' => 99.99, 'course_difficulty_id' => 3,
                        'description' => 'PHP - the best language around. REVISITED.', 
                        'short_description' => 'Short: REVISITED.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Business Courses
        Course::create( ['name' => 'Business App Development', 'slug' => 'business-app-development', 'instructor_id' => 4, 'course_category_id' => 2, 'course_subcategory_id' => 2, 
                        'price' => 300000, 'course_difficulty_id' => 1,  'course_preview_image_id' => 4,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'short_description' => 'Short Create your very first.', 
                        'student_count' => 1, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Investments Courses
        Course::create( ['name' => 'Investments App Development', 'slug' => 'investments-app-development', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
                        'price' => 300000, 'course_difficulty_id' => 1, 'course_preview_image_id' => 5,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 2, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Investments Javascript Primer', 'slug' => 'investments-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 3,  'course_subcategory_id' => 3, 
                        'price' => 185000.99, 'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Music Courses
        Course::create( ['name' => 'Music App Development', 'slug' => 'music-app-development',  'instructor_id' => 4,'course_category_id' => 4, 'course_subcategory_id' => 4,  'price' => 300000, 
                        'course_difficulty_id' => 1, 'course_preview_image_id' => 6, 'affiliate_percentage' => 0,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public',
                        'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Beauty Courses
        Course::create( ['name' => 'Beauty App Development', 'slug' => 'beauty-app-development', 'instructor_id' => 4, 'course_category_id' => 5, 'course_subcategory_id' => 5,  'price' => 300000, 
                        'course_difficulty_id' => 1,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty Javascript Primer', 'slug' => 'beauty-javascript-primer', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 'price' => 185000.99, 
                        'course_difficulty_id' => '2', 'description' => 'JS - the best language around.', 'student_count' => 0, 
                        'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty PHP Primer', 'slug' => 'beauty-php-primer', 'instructor_id' => 4, 'course_category_id' => 5,   'course_subcategory_id' => 5, 
                        'price' => 99.99, 'course_difficulty_id' => 3, 'affiliate_percentage' => 0,
                                 'description' => 'PHP - the best language around.', 'student_count' => 0,  'course_preview_image_id' => 7,
                        'privacy_status' => 'public',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        Course::create( ['name' => 'Beauty PHP Primer Revisited', 'slug' => 'beauty-php-primer-revisited', 'instructor_id' => 4, 'course_category_id' => 5,  'course_subcategory_id' => 5, 
                        'price' => 99.99, 'course_difficulty_id' => 3, 'affiliate_percentage' => 0,
                                 'description' => 'PHP - the best language around. REVISITED.', 'student_count' => 0, 'privacy_status' => 'public',
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        // Health Courses
        Course::create( ['name' => 'Health App Development', 'slug' => 'health-app-development', 'instructor_id' => 4, 'course_category_id' => 6,  'course_subcategory_id' => 6, 
                        'price' => 300000,  'course_difficulty_id' => 1,  'course_preview_image_id' => 8,
                        'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["Beginners that don’t know anything about C++ ","Existing who want to pick up javascript."]',
                        'what_will_you_achieve' => '["Something", "Something Else!"]']);
        
        Course::create( ['name' => '女性を一秒で魅了するモテボディの作り方', 'instructor_id' => 11, 'course_category_id' => 6,  'course_subcategory_id' => 6, 
                        'price' => 300000,  'course_difficulty_id' => 1,  'course_preview_image_id' => 9,
                        'description' => '「モテボディ養成講座（仮）」（フロント）
                            ・モテボディを手に入れるために必要な理論と実践を、男女別にお届けします。
                            ・このプログラムは谷が実際にクライアントに指導している、効果が実証済みの内容です。・プログラムは「モテボディ理論編」「モテボディ実践編」の２本立てです。
                            ・インタビュー、Q&Aも用意しております。', 
                        'short_description' => '「モテボディ養成講座（仮）」（フロント）',
                        'student_count' => 0, 'privacy_status' => 'public', 'affiliate_percentage' => 0,
                         'who_is_this_for' => '["モテたい人","最近体型が気になりはじめて、何とかしたいと思っている人","変わりたい希望はあるけど、何をすれば良いのか分からない方"
                             ,"自己流でトレーニングをやっているけど、本当に効果があるのか分からない人","忙しくてジムに通えない人","ジム通いに挫折したことがある人",
                             "最速最短で結果を出したい人","無駄な出費をしたくない人","一生ものの知識とスキルを身につけたい人","本気で変わりたい人",
                             "他人に教えられるくらいの知識を身につけたい人","アツくなりたい人"]',
                        'what_will_you_achieve' => '["モテボディが手に入る！", "スーツの似合う男性らしいカラダ", "メリハリのある女性らいしいカラダ", 
                            "割れた腹筋、くびれたお腹", "盛り上がった胸筋、リフトアップしたバスト", "逞しい背中、スラッと美しい背中", "引き締まったお尻、つり上がったヒップ", 
                            "モテボディを維持する方法", "リバウンドしないカラダと知識", "リバウンドしないダイエットマインド", "若々しさと美しさ", "肌の張り", 
                            "印象が良くなる。", "行動力がつき、収入が上がる", "エネルギーレベルが高まり、前向きになる。", "体力が上がるので色々なことに挑戦出来る。", 
                            "他人に教えられる知識と実践方法。"]']);
        
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
        CoursePreviewImage::create( ['instructor_id' => 4, 'url' => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/course_preview/demo-course.jpg'] );
       
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
        Lesson::create( ['module_id' => 3, 'name' => 'Thank you, come again', 'order' => 4, 'description' => '9A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        
        Lesson::create( ['module_id' => 4, 'name' => 'Welcome', 'order' => 1, 'description' => '1A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 4, 'name' => 'Advanced Stuff', 'order' => 2, 'description' => '2A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'More Advanced Stuff', 'order' => 1, 'description' => '3A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'Second Module Review', 'order' => 2, 'description' => '4A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 5, 'name' => 'Second Module Conclusion', 'order' => 3, 'description' => '5A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Let\'s recap', 'order' => 1, 'description' => '6A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Now that you know', 'order' => 2, 'description' => '7A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'We\'re almost done', 'order' => 3, 'description' => '8A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
        Lesson::create( ['module_id' => 6, 'name' => 'Thank you, come again', 'order' => 4, 'description' => '9A lil bit of this, a lil bit of that, cool stuff mostly', "published" => 'yes'] );
    }
}


class VideosSeeder extends Seeder {

    public function run()
    {
        DB::table('videos')->delete();
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
        Block::create( ['lesson_id' => 10, 'name' => 'First File','type' => 'file', 
            'content' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png'] );
        Block::create( ['lesson_id' => 10, 'name' => 'Second File','type' => 'file', 
            'content' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png'] );
        Block::create( ['lesson_id' => 10, 'name' => 'Third File','type' => 'file', 
            'content' => 'https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png'] );
        Block::create( ['lesson_id' => 10, 'name' => 'First Video Ever','type' => 'video', 
            'content' => '1'] );
       
    }
}

class ProfileSeeder extends Seeder {

    public function run()
    {
        DB::table('user_profiles')->delete();
        Profile::unguard();
        Profile::create( ['owner_id' => 11, 'owner_type' => 'Instructor','first_name' => 'Keiji', 'last_name' => 'Tani', 'email' => 'Tani@mailinator.com',
            'bio' => '谷啓嗣（たにけいじ） 
1986年2月15日生まれ　香川県出身

初動負荷理論の専門家かつ、
30代・軽肥満の男性会社員を
たったの３ヶ月で、24時間/365日
最高のコンディションで仕事ができる
ハイパフォーマーに変えるスペシャリスト、

高校時代は体操競技で数多くの全国大会に出場。

高校三年のインターハイでは準決勝、その後の
国体では香川県チームとして史上初の決勝に進出した。

福岡大学スポーツ科学部を卒業後は
スポーツトレーナーとしての道を選択し、
イチロー選手、三浦知良選手、 青木功選手、
杉山愛選手を指導する小山裕史先生に師事。

鳥取での180日間無休の超過酷な研修生活
を見事乗り越えて、初動負荷理論の正式な
トレーナーとして認定を受ける。

その後、香川県のトレーニングジムや
介護施設、複合型健康増進施設などで、
2歳から105歳のプロスポーツ選手から
モデルまで幅広いクライアント、
2000名以上に指導した実績を持つ。

2014年から、生活拠点を香川から東京に変えて、
現在は都内でパーソナルトレーナーとして指導を実施中。
健康に関するセミナーを多数開催している。

初動負荷理論に裏付けられた確たる理論と
幅広いクライアントに接した経験に基づく指導力は
すぐに評判になり、2015年６月現在、
谷の指導を求めるパーソナルトレーニングは
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
       
    }
}

class AffiliateAgenciesSeeder extends Seeder {

    public function run()
    {
        DB::table('affiliate_agencies')->delete();
        AffiliateAgency::unguard();
        
        AffiliateAgency::create( ['name' => 'Affiliate Agency 1'] );
        AffiliateAgency::create( ['name' => 'Affiliate Agency 2'] );
        AffiliateAgency::create( ['name' => 'Affiliate Agency 3'] );
        
        $affiliate = User::find(5);
        $affiliate->affiliate_agency_id = 1;
        $affiliate->save();
    }
}
