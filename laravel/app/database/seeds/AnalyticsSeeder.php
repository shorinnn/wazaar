<?php

class AnalyticsSeeder extends DatabaseSeeder
{
    public function run()
    {
        $coursePurchases = [];
        $trackingCodeHits = [];

        $faker = Faker\Factory::create();
        for ($i = 1; $i< 50; $i++){
            $trackingCode = $faker->word();
            $date = $faker->dateTimeBetween('-1 week');
            $coursePurchases[] = [
                'course_id' => $faker->numberBetween(1,10),
                'student_id' => $faker->randomElement([3,7]),
                'ltc_affiliate_id' => 2,
                'product_affiliate_id' => 5,
                'purchase_price' => $faker->randomFloat(0,50,1000),
                'tracking_code' => $trackingCode,
                'created_at' => $date,
                'updated_at' => $date
            ];
            $trackingCodeHits[] = [
                'affiliate_id' => 2,
                'tracking_code' => $trackingCode,
                'created_at' => $date,
                'updated_at' => $date
            ];

        }

        CoursePurchase::insert($coursePurchases);
        TrackingCodeHits::insert($trackingCodeHits);
    }
}