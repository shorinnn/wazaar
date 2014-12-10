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
    
    protected $fillable = ['first_name', 'last_name', 'email', 'username'];
    
    public static $relationsData = array(
        'ltcAffiliator' => array(self::BELONGS_TO, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
        'ltcAffiliated' => array(self::HAS_MANY, 'User', 'table' => 'users', 'foreignKey' => 'ltc_affiliator_id'),
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
}