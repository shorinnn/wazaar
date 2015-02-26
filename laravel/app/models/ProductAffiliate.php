<?php

class ProductAffiliate extends User{

    use ProfileTrait;

    protected $table = 'users';
    protected $roleId = 4;
    public static $relationsData = array(
        'sales' => array(self::HAS_MANY, 'Purchase'),
        'courseReferrals' => array(self::HAS_MANY, 'CourseReferral'),
        'affiliateAgency' => array(self::BELONGS_TO, 'AffiliateAgency')
    );


    public static function courses($affiliateId)
    {
        if ($affiliateId){
            $sql = "SELECT DISTINCT courses.id, courses.name, courses.short_description
                    FROM purchases
                    JOIN courses ON purchases.product_id = courses.id
                    WHERE purchases.product_affiliate_id = {$affiliateId}
                    AND purchases.product_type = 'Course'
                   ";

            return DB::select($sql);
        }

        return null;
    }


}