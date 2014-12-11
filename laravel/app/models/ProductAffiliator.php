<?php

class ProductAffiliator extends User{
    protected $table = 'users';
    public static $relationsData = array(
//        'affiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
  );
}