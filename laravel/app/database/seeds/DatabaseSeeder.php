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
		 $this->call('CoursesSeeder');
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
        
        $teacher = new Role;
        $teacher->name = 'Teacher';
        $teacher->save();
        
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
        $user->username = 'WazaarAffiliator';
        $user->affiliate_id = '2';
        $user->email = 'wazaarAffiliator@wazaar.jp';
        $user->password = 'random';
        $user->password_confirmation = 'random';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->save();
        $user = new User;
        $user->ltc_affiliator_id = 2;
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
        $user->ltc_affiliator_id = 2;
        $user->username = 'teacher';
        $user->email = 'teacher@mailinator.com';
        $user->first_name = 'Teacher';
        $user->last_name = 'McTeacher';
        $user->password = 'pass';
        $user->password_confirmation = 'pass';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;
        $user->save();
        $user = new User;
        $user->affiliate_id = '5';
        $user->ltc_affiliator_id = 2;
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
        $user->ltc_affiliator_id = 2;
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
        $user->ltc_affiliator_id = 2;
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
        $user->ltc_affiliator_id = 2;
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
        $user->ltc_affiliator_id = 2;
        $user->username = 'sorin';
        $user->email = 'sorin@mailinator.com';
        $user->first_name = 'Sorin';
        $user->last_name = 'Ryan';
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
        
        $user = User::where('username', '=', 'teacher')->first();
        $teacherRole = Role::where('name','=','Teacher')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $teacherRole );
        $user = User::where('username', '=', 'affiliate')->first();
        $affiliateRole = Role::where('name','=','Affiliate')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $affiliateRole );
        $user = User::where('username', '=', 'wazaarAffiliator')->first();
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

class CoursesSeeder extends Seeder {

    public function run()
    {
        DB::table('courses')->delete();
        Course::unguard();
        Course::create( ['name' => 'App Development', 'slug' => 'app-development', 'course_category_id' => 1, 'price' => 300000, 'difficulty_level' => 'Beginner',
                                 'description' => 'Create your very first application in 2 weeks! You get a beginner award after completing the course.', 
                                 'student_count' => 0 ]);
        Course::create( ['name' => 'Javascript Primer', 'slug' => 'javascript-primer', 'course_category_id' => 1, 'price' => 185000.99, 
                        'difficulty_level' => 'Intermmediate', 'description' => 'JS - the best language around.', 'student_count' => 0 ]);
        Course::create( ['name' => 'PHP Primer', 'slug' => 'php-primer', 'course_category_id' => 1,  'price' => 99.99, 'difficulty_level' => 'Expert',
                                 'description' => 'PHP - the best language around.', 'student_count' => 0 ]);
  
       
    }

}