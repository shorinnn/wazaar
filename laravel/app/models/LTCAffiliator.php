<?php

class LTCAffiliator extends User{
    protected $table = 'users';
    public static $relationsData = array(
        'ltcAffiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
  );
}