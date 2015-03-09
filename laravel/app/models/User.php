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
        'profiles' => [ self::HAS_MANY, 'Profile', 'foreignKey' => 'owner_id' ],
     );
    
    /**
     * Make Ardent and Confide save methods compatible
     */
    public function save(array $rules = Array(), array $customMessages = Array(), array $options = Array(), Closure $beforeSave = NULL, Closure $afterSave = NULL){
        return $this->confideSave();
    }
    
    /**
     * Can the current user purchase the supplied course/lesson
     * @param mixed $product Course/Lesson
     * @return boolean
     */
    public function canPurchase($product){
        $student = Student::find($this->id);
        if( strtolower( get_class($product) ) == 'course' ){
            if($this->id == $product->instructor->id) return false;
            if($product->payment_type=='subscription') return true;
        }
        else{
             if($this->id == $product->module->course->instructor->id) return false;
             if( $student->purchased( $product->module->course ) ) return false;
        }
        if( $student->purchased($product) ) return false;
        return true;
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
    
    public function firstName(){
        
        if( isset( $this->profiles) && $this->profiles->first() !=null ){
            return $this->profiles->first()->first_name;
        }
        else return $this->first_name;
    }
    
    public function lastName(){
        if(  isset( $this->profiles) && $this->profiles->first() !=null){
            return $this->profiles->first()->last_name;
        }
        else return $this->last_name;
    }
    
    public function commentName($user_type){
        if($user_type=='student') $user = Student::find($this->id);
        else $user = Instructor::find($this->id);
        if( $user->profile ){
            return $user->profile->first_name.' '.$user->profile->last_name;
        }
        else{
            if($user->first_name=='') return $user->email;
            else return $user->first_name.' '.$user->last_name;
        }
    }

}