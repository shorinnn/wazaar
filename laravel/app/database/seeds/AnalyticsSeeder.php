<?php

class AnalyticsSeeder extends DatabaseSeeder
{
    public function run()
    {
        $coursePurchases = [];
        $faker = Faker\Factory::create();
        for ($i = 1; $i< 50; $i++){
            $coursePurchases[] = [
                'course_id' => $faker->numberBetween(1,10),
                'student_id' => $faker->randomElement([3,7]),
                'ltc_affiliate_id' => 2,
                'product_affiliate_id' => 5,
                'purchase_price' => $faker->randomFloat(2,50,1000),
                'tracking_code' => $faker->word(),
                'created_at' => $faker->dateTimeBetween('-1 week'),
                'updated_at' => $faker->dateTimeBetween('-1 week')
            ];
        }

        CoursePurchase::insert($coursePurchases);
    }
}