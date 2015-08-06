<?php

class AnalyticsSeeder extends DatabaseSeeder
{

    public function run()
    {
        $coursePurchases = [];

        Purchase::truncate();
        $faker = Faker\Factory::create();
        for ($i = 1; $i < 50; $i ++) {
            $trackingCode  = $faker->word();
            $date          = $faker->dateTimeBetween('-1 week');
            $courseId      = $faker->numberBetween(1, 10);
            $purchasePrice = $faker->randomFloat(0, 50, 800);
            $firstTier     = rand(0, 1);

            $firstTierEarning  = 0;
            $secondTierEarning = 0;

            if ($firstTier) {
                $firstTierEarning = $purchasePrice * .05;
            } else {
                $secondTierEarning = $purchasePrice * .01;
            }

            $coursePurchases[] = [
                'product_id'                     => $courseId,
                'product_type'                   => 'Course',
                'student_id'                     => $faker->randomElement([4, 7]),
                'affiliate_earnings'             => $firstTierEarning,
                'second_tier_affiliate_earnings' => $secondTierEarning,
                'ltc_affiliate_id'               => 5,
                'ltc_affiliate_earnings'         => $purchasePrice * .02,
                'product_affiliate_id'           => 5,
                'second_tier_affiliate_id'       => 5,
                'purchase_price'                 => $purchasePrice,
                'tracking_code'                  => $trackingCode,
                'created_at'                     => $date,
                'updated_at'                     => $date
            ];
            $this->_createFakeHits([
                'affiliate_id'  => 5,
                'course_id'     => $courseId,
                'tracking_code' => $trackingCode,
                'created_at'    => $date,
                'updated_at'    => $date
            ]);

        }

        Purchase::insert($coursePurchases);
        //TrackingCodeHits::insert($trackingCodeHits); TODO: uncomment this
    }

    private function _createFakeHits($hits)
    {
        for ($i = 1; $i < rand(2, 10); $i ++) {
            TrackingCodeHits::create($hits);
        }
    }
}