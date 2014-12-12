<?php

class ProductAffiliate extends User{
    protected $table = 'users';
    public static $relationsData = array(
        'sales' => array(self::HAS_MANY, 'CoursePurchase'),
  );
}