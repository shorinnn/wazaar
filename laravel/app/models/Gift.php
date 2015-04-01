<?php
use LaravelBook\Ardent\Ardent;

class Gift extends Ardent {
    protected $fillable = [];
    public static $rules = [];
    public static $relationsData = [
        'course' => [ self::BELONGS_TO, 'Course' ],
        'affiliate' => [ self::BELONGS_TO, 'ProductAffiliate' ],
        'files' => [ self::HAS_MANY, 'GiftFile' ],
    ];

    public function encryptedID(){
        return PseudoCrypt::hash( $this->id );
    }

    public function beforeDelete(){
        foreach($this->files as $file){
            $file->delete();   
        }
    }
}