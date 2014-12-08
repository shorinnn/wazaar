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
        $user->username = 'affiliate';
        $user->email = 'affiliate@mailinator.com';
        $user->first_name = 'Affiliate';
        $user->last_name = 'McAffiliate';
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
        $user = User::where('username', '=', 'teacher')->first();
        $teacherRole = Role::where('name','=','Teacher')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $teacherRole );
        $user = User::where('username', '=', 'affiliate')->first();
        $affiliateRole = Role::where('name','=','Affiliate')->first();
        $user->attachRole( $studentRole );
        $user->attachRole( $affiliateRole );

    }

}
