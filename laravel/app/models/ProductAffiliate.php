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


}