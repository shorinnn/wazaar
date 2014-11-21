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
	}

}

class RoleTableSeeder extends Seeder {

    public function run()
    {
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
