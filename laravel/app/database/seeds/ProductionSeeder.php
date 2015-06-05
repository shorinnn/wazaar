<?php
namespace ProductionSeeding{
    
    class ProductionSeeder extends \Seeder {

            /**
             * Run the database seeds.
             *
             * @return void
             */
            public function run()
            {
                    \Eloquent::unguard();

                     $this->call('RoleTableSeeder');
                     $this->call('UserTableSeeder');
                     $this->call('AssignedRoleTableSeeder');
                     $this->call('CourseCategorySeeder');
                     $this->call('CourseSubcategorySeeder');
                     $this->call('CourseDifficultySeeder');
                     $this->call('ProfileSeeder');
            }

    }

    class RoleTableSeeder extends \Seeder {

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

    class UserTableSeeder extends \Seeder {

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
            $user->email = 'wazaarAffiliate@wazaar.jp';
            $user->password = 'random';
            $user->password_confirmation = 'random';
            $user->confirmation_code = md5(uniqid(mt_rand(), true));
            $user->confirmed = 1;
            $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
            $user->save();

            $user = new User;
            $user->ltc_affiliate_id = 5;
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
            $user->ltc_affiliate_id = 5;
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
        }
    }

    class AssignedRoleTableSeeder extends \Seeder {

        public function run()
        {
            DB::table('assigned_roles')->delete();
            $user = User::where('username', '=', 'superadmin')->first();
            $adminRole = Role::where('name','=','Admin')->first();
            $user->attachRole( $adminRole );
            $user = User::where('username', '=', 'student')->first();
            $studentRole = Role::where('name','=','Student')->first();
            $user->attachRole( $studentRole );

            $user = User::where('username', '=', 'instructor')->first();
            $instructorRole = Role::where('name','=','Instructor')->first();
            $user->attachRole( $studentRole );
            $user->attachRole( $instructorRole );

            $affiliateRole = Role::where('name','=','Affiliate')->first();
            $user = User::where('username', '=', 'wazaarAffiliate')->first();
            $user->attachRole( $studentRole );
            $user->attachRole( $affiliateRole );

        }

    }


    class CourseCategorySeeder extends \Seeder {

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

    class CourseSubcategorySeeder extends \Seeder {

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

    class CourseDifficultySeeder extends \Seeder {

        public function run()
        {
            DB::table('course_difficulties')->delete();
            CourseDifficulty::unguard();
            CourseDifficulty::create( ['name' => 'Beginner'] );
            CourseDifficulty::create( ['name' => 'Intermediate'] );
            CourseDifficulty::create( ['name' => 'Expert'] );       

        }
    }


    class ProfileSeeder extends \Seeder {

        public function run()
        {
            DB::table('user_profiles')->delete();
            Profile::unguard();

            Profile::create( ['owner_id' => 2, 'owner_type' => 'Affiliate','first_name' => 'Wazaar', 'last_name' => 'Affiliate', 'email' => 'wazaarAffiliate@wazaar.jp', 'bio' => 'hi', 'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg', 'created_at' => \Carbon\Carbon::now()]);

            Profile::create( ['owner_id' => 5, 'owner_type' => 'Instructor','first_name' => 'Wazaar', 'last_name' => 'Instructor', 
                                'email' => 'wazaarInstructor@wazaar.jp', 'bio' => 'hi', 'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg', 
                                'bank_code' => 'BNK5', 'bank_name'=>'Bank5', 'branch_code'=>'B5', 'branch_name' => 'BRANCH5', 
                                'account_type' => 1, 'account_number' => 'ACC5', 'beneficiary_name' => 'Beneficiary Instructor5', 'created_at' => \Carbon\Carbon::now()]);

            Profile::create( ['owner_id' => 4, 'owner_type' => 'Instructor','first_name' => 'Wazaar', 'last_name' => 'Instructor', 
                                'email' => 'wazaarInstructor@wazaar.jp', 'bio' => 'hi', 'photo'  => 'https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg', 
                                'bank_code' => 'BNK4', 'bank_name'=>'Bank4', 'branch_code'=>'B4', 'branch_name' => 'BRANCH4', 
                                'account_type' => 1, 'account_number' => 'ACC4', 'beneficiary_name' => 'Beneficiary Instructor4', 'created_at' => \Carbon\Carbon::now()]);
        }
    }

}