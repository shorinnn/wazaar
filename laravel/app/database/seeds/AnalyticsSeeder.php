<?php

class AnalyticsSeeder extends DatabaseSeeder
{
    public function run()
    {
        $coursePurchases = [];


        $faker = Faker\Factory::create();
        for ($i = 1; $i< 50; $i++){
            $trackingCode = $faker->word();
            $date = $faker->dateTimeBetween('-1 week');
            $courseId = $faker->numberBetween(1,10);
            $coursePurchases[] = [
                'product_id' => $courseId,
                'product_type' => 'Course',
                'student_id' => $faker->randomElement([3,7]),
                'ltc_affiliate_id' => 2,
                'product_affiliate_id' => 5,
                'purchase_price' => $faker->randomFloat(0,50,800),
                'tracking_code' => $trackingCode,
                'created_at' => $date,
                'updated_at' => $date
            ];
            $this->_createFakeHits( [
                'affiliate_id' => 2,
                'course_id' => $courseId,
                'tracking_code' => $trackingCode,
                'created_at' => $date,
                'updated_at' => $date
            ]);

        }

        Purchase::insert($coursePurchases);
        //TrackingCodeHits::insert($trackingCodeHits);
    }

    private function _createFakeHits($hits)
    {
        for ($i = 1; $i < rand(2,10); $i++){
            TrackingCodeHits::create($hits);
        }
    }
}