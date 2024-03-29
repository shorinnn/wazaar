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
    protected $fillable = ['first_name', 'last_name', 'email', 'username', 'affiliate_id', 'sti_approved', 'has_ltc', 'is_vip']; 
    
     public static $relationsData = array(
        'profiles' => [ self::HAS_MANY, 'Profile', 'foreignKey' => 'owner_id' ],
     );
     
     private $_realEmail = false;
     
     public function getEmailAttribute(){
        $email = $this['attributes']['email'];
        if($this->_realEmail) return $email;
        if( $this->isAffiliate() ) return str_replace ('#waa#-', '', $email);
        return $email;
     }
    
    /**
     * Make Ardent and Confide save methods compatible
     */
    public function save(array $rules = Array(), array $customMessages = Array(), array $options = Array(), Closure $beforeSave = NULL, Closure $afterSave = NULL){
        if( $this->isAffiliate() ) $this->_realEmail = true;
        return $this->confideSave();
    }
    
    /**
     * Can the current user purchase the supplied course/lesson
     * @param mixed $product Course/Lesson
     * @return boolean
     */
    public function canPurchase($product){
        $student = Student::find($this->id);
        if( $student->hasRole('Affiliate') ) return false;
        if( strtolower( get_class($product) ) == 'course' ){
            if( $this->id == $product->instructor->id ) return false;
            if( $this->id == $product->assigned_instructor_id ) return false;
            if( $product->payment_type=='subscription' ) return true;
        }
        else{
             if( $this->id == $product->module->course->instructor->id ) return false;
             if( $this->id == $product->module->course->assigned_instructor_id ) return false;
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
        // delete profiles
        DB::table('user_profiles')->where('owner_id', $this->id)->delete();
        DB::table('assigned_roles')->where('user_id', $this->id)->delete();
        
        // remove from delivered
        $delivered = new DeliveredHelper();
        $delivered->deleteUser( $this->delivered_user_id );
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
        $profile = $this->_defaultProfile();
        if( $profile !=null){
            return $profile->first_name;
        }
        else return $this->first_name;
    }
    
    public function lastName(){
        $profile = $this->_defaultProfile();
        if( $profile !=null){
            return $profile->last_name;
        }
        else return $this->last_name;
    }
    
    private function _affiliateDefaultProfile(){
        return $this->profile;
        foreach($this->profiles as $profile){
            if( $profile->type=='Affiliate') return $profile;
        }
        return null;
//        if( $profile && $profile !=null){
//            return $profile;
//        }
//        else return null;
//        $profile = Profile::where('owner_type','Affiliate')->where('owner_id', $this->id)->first();
    }
    
    private function _defaultProfile( ){
        if( is_a($this,'ProductAffiliate') || is_a($this,'LTCAffiliate') ) return $this->_affiliateDefaultProfile();
        if( $this->profiles && $this->profiles !=null){
            $types = [ 'Instructor', 'Affiliate', 'Student' ];
            foreach($types as $type){
                foreach($this->profiles as $profile){
                    if( $profile->owner_type == $type) return $profile;
                }
            }
            return null;
//            if( $this->profiles()->where('owner_type','Instructor')->first() != null ) 
//                    return $this->profiles()->where('owner_type','Instructor')->first();
//            if( $this->profiles()->where('owner_type','Affiliate')->first() != null ) 
//                    return $this->profiles()->where('owner_type','Affiliate')->first();
//            if( $this->profiles()->where('owner_type','Student')->first() != null ) 
//                    return $this->profiles()->where('owner_type','Student')->first();
//            return null;
        }
        else if( $this->profile && $this->profile !=null) return $this->profile;
        else return null;
    }
    
    public function fullName(){
        if( Config::get('first_name_first') == true ) return $this->firstName().' '.$this->lastName();
        return $this->lastName().' '.$this->firstName();
    }
    
    public function email($profile){
        if( $this->profiles && $this->profiles()->where('owner_type', $profile)->first() !=null){
            return $this->profiles()->where('owner_type', $profile)->first()->email;
        }
        else return $this->email;
    }
    
    public function commentName($user_type){
        $user_type = strtolower($user_type);
        if($user_type=='student') $user_type='Student';
        else if($user_type=='instructor') $user_type='Instructor';
        else  $user_type='Affiliate';
        $profile = $this->_profile( $user_type );
        if( $profile != null){
            if( Config::get('custom.first_name_first') == true ) return $profile->first_name.' '.$profile->last_name;
            return $profile->last_name.' '.$profile->first_name;
        }
        else{
            return '';// $this->email;
        }
//        if($user_type=='student') $user = Student::find($this->id);
//        else if($user_type=='instructor') $user = Instructor::find($this->id);
//        else if($user_type=='instructor_agency') $user = InstructorAgency::find($this->id);
//        else $user = LTCAffiliate::find($this->id);
//        if( $user->profile ){
//            return $user->profile->first_name.' '.$user->profile->last_name;
//        }
//        else{
//            if($user->first_name=='') return $user->email;
//            else return $user->first_name.' '.$user->last_name;
//        }
    }
    
    public function commentPicture($user_type){
        $user_type = strtolower($user_type);
        if($user_type=='student') $user_type='Student';
        else if($user_type=='instructor') $user_type='Instructor';
        else  $user_type='Affiliate';
        $profile = $this->_profile( $user_type );
        if( $profile != null){
            if( trim($profile->photo)=='' ) return '//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg';
            return $profile->photo;
        }
        else{
            return '//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg';
        }
//        if($user_type=='student') $user = Student::find($this->id);
//        else if($user_type=='instructor') $user = Instructor::find($this->id);
//        else if($user_type=='instructor_agency') $user = InstructorAgency::find($this->id);
//        else $user = LTCAffiliate::find($this->id);
//        if( $user->profile ){
//            return $user->profile->photo;
//        }
//        else{
//            return '//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg';
//        }
    }
    
    public function commentTitle($user_type){
        $user_type == strtolower($user_type);
        $user_type = strtolower($user_type);
        if($user_type=='student') $user_type='Student';
        else if($user_type=='instructor') $user_type='Instructor';
        else  $user_type='Affiliate';
        $profile = $this->_profile( $user_type );
        if( $profile != null){
            return $profile->title;
        }
    }
    
    public function isAffiliate(){
        if($this->hasRole('Affiliate')) return true;
        return false;
    }
    public function getReminderEmail() {
        return $this['attributes']['email'];
//        parent::getReminderEmail();
    }
    
    public function _profile( $type='Student' ){
        if( !$this->hasRole( $type ) ) return null;
        if($this->profiles != null ){
            foreach( $this->profiles as $profile ){
                if( $profile->owner_type == $type ){
                    return $profile;
                }
            }
        }
        if($this->profile !=null) return $this->profile;
        return null;
    }
    
    public function getCustom($key=null){
        $custom = ( trim($this->custom) == '') ? '{}' : $this->custom;
        $custom = json_decode($custom);
        if($key==null) return $custom;
        else{
            if( isset($custom->$key)) return $custom->$key;
            return null;
        }
    }
    
    public function setCustom($key, $val){
        $custom = $this->getCustom();
        $custom->$key = $val;
        $this->custom = json_encode($custom);
        return true;
    }
    
    public function instructorNameOrCompany(){
        $this->profile = $this->_profile('Instructor');
        if( $this->profile != null ){
            if( trim($this->profile->corporation_name) == '') return $this->profile->last_name.' '.$this->profile->first_name;
            return $this->profile->corporation_name;
        }
        else{
            return $this->last_name.' '.$this->first_name;
        }
    }
    
    public function noFill($type='Student'){
        $profile = $this->_profile($type);
        if( trim($profile->bank_code)=='' ||
            trim($profile->bank_name)=='' ||
            trim($profile->branch_code)=='' ||
            trim($profile->branch_name)=='' ||
            trim($profile->account_type)=='' ||
            trim($profile->account_number)=='' ||
            trim($profile->beneficiary_name)==''){
            return true;
        }
        return false;
    }

}