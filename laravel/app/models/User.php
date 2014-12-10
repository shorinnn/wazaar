<?php
use LaravelBook\Ardent\Ardent;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Ardent implements ConfideUserInterface
{
    use ConfideUser{
        save as confideSave;
    }

    use HasRole;
    protected $fillable = ['first_name', 'last_name', 'email', 'username', 'affiliate_id'];
    
    public static $relationsData = array(
        'ltcAffiliator' => array(self::BELONGS_TO, 'LTCAffiliator', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
  );
    
    
    public function save(array $rules = Array(), array $customMessages = Array(), array $options = Array(), Closure $beforeSave = NULL, Closure $afterSave = NULL){
        return $this->confideSave();
    }
    
    /**
     * Admin cannot delete self
     * @return boolean
     */
    public function beforeDelete(){
        if(Auth::user()->id == $this->id){
            $this->errors()->add(0, trans('validation.cannot_self_delete') );
            return false;
        }
    }
    
    /**
     * Ardent updateUniques does not work with confide user
     * @return boolean
     */
    public function beforeSave(){
        if(trim($this->affiliate_id)!='' &&  User::where('affiliate_id', $this->affiliate_id)->first() != null 
                && User::where('affiliate_id', $this->affiliate_id)->first()->id != $this->id ){
            $this->errors()->add(0, trans('crud/errors.attr_taken', ['attr' => 'Affiliate ID']) );
            return false;
        }
    }
}