<?php

 class AffiliateUsersSeeder extends DatabaseSeeder
 {

     public function run()
     {
         User::unguard();
         Profile::unguard();

         $faker = Faker\Factory::create();


         for ($i = 20; $i < rand(50,100); $i++)
         {
             $email = $faker->email;

             $user = new User;
             $user->username = $faker->userName;
             $user->email = $email;
             $user->password = 'pass';
             $user->password_confirmation = 'pass';
             $user->confirmation_code = md5(uniqid(mt_rand(), true));
             $user->confirmed = 1;
             $user->created_at = date('Y-m-d', strtotime('-' . rand(0,50) . ' day'));
             $user->save();

             if (isset($user->id)) {
                 Profile::create(['owner_id'   => $user->id,
                                  'owner_type' => 'Affiliate',
                                  'first_name' => $faker->firstName,
                                  'last_name'  => $faker->lastName,
                                  'email'      => $email
                 ]);
             }
         }

         $this->_createPurchase();



     }

     /**
      * Creates purchases affiliated to each affiliate. Could generate between 2 - 10 purchases per affiliate
      */
     private function _createPurchase()
     {
         Purchase::unguard();

         $affiliateIds = Profile::select('owner_id')->where('owner_type', 'Affiliate')->get()->toArray();
         $freeProductOptions = ['yes','no'];
         foreach($affiliateIds as $aff){
             for($i = 1; $i < rand(2,100); $i++) {
                 Purchase::create(['product_id'           => rand(1,14),
                                   'product_type'         => 'Course',
                                   'student_id'           => 3,
                                   'ltc_affiliate_id'     => 2,
                                   'product_affiliate_id' => $aff['owner_id'],
                                   'purchase_price'       => rand(5,100),
                                   'created_at'           => date('Y-m-d', strtotime('-' . rand(0,50) . ' day')),
                                   'free_product'         => $freeProductOptions[rand(0,1)]
                 ]);
             }
         }
     }
 }