<?php

class LpController extends \BaseController {
        public function __construct(){
            $this->template = new StdClass();
            $this->template->subject = 'ワザール販売者登録ありがとうございました！';
            $this->template->content = '
                HELLO @FIRST_NAME@<br />
                このたびはワザールの販売者登録、誠にありがとうございました。<br />
                <br />
                最新の情報を随時ご連絡させていただきます。<br />
                <br />
                その他、何かご不明な点等ございましたらお手数ではございますが、下記連絡先までご連絡ください。<br />
                <br />
                株式会社　みんカレ<br />
                Wazaar (ワザール）の日本国内で運営法人<br />
                <br />
                住所：東京都千代田区神田須田町１丁目８番３号<br />
                ハイツモントレ神田２０５号<br />
                TEL  03-6206-8396<br />
                MOB  080-9263-0375<br />
                <br />
                担当：友永恵輔';
            $this->template->name = 'Wazaar';
            $this->template->email = 'no-reply@wazaar.jp';
            $this->template->templateName = 'LP-Signup';
            $this->list = new StdClass();
            $this->list->name = 'lp-pub-list';
            $this->list->description = '2-tier publisher landing pages list';
            $this->delivered = new DeliveredHelper();
        }
        
        private function _getTemplate(){
            $templates = $this->delivered->getTemplates();
            foreach($templates['data'] as $template){
                if( $template['templateName'] == $this->template->templateName ) return json_decode(json_encode($template), FALSE);
            }
            // template not there yet, create it
            $data = $this->delivered->addTemplate( $this->template->templateName, $this->template->subject, $this->template->name,
                    $this->template->email, $this->template->content);
            return json_decode(json_encode($data['data']), FALSE);
//            return $data['data'];
        }
        
        private function _getList(){
//            $lists = $this->delivered->getLists();
//            foreach($lists['data'] as $list){
//                if( $lists['groupName'] == $this->list->name ) return json_decode(json_encode($list), FALSE);
//            }
//            $data = $this->delivered->addList($this->list->name, $this->list->description);
//            return json_decode(json_encode($data['data']), FALSE);
            $list = new stdClass();
            $list->id = 1;
            return $list;
        }
    
        public function index(){
            $list = $this->_getList();
            dd($list);
//            $users = $this->delivered->getUsers();
//            $user = $users['data'][0];
//            if(is_array($user) ) $user = json_decode(json_encode($user), FALSE);
//            dd($user);
//            $this->delivered->deleteTemplate(3);
//            $templates = $this->delivered->getTemplates();
//            dd($templates);
            
//            $template = $this->_getTemplate();
//            dd($template);
            
//            $template = $this->_getTemplate();
//            // send email
//            $variables = json_encode( ['FIRST_NAME' => $user->firstName ] );
//            $result = $this->delivered->executeEmailRequest('immediate', $template->id, $user->id, $variables );
//            dd($result);

            return View::make('lp.index');
        }

	public function store()
	{
            $referer = explode( '?', $_SERVER['HTTP_REFERER'] );
            $referer = $referer[0];
            $error_flag = '?error=1';
            $stpi = 0;
            if( Input::has('stpi') ){
                $stpi = Input::get('stpi');
                Cookie::queue('stpi', Input::get('stpi'), 60*24*30);
                $error_flag .= '&stpi='.Input::get('stpi');
            }
            
            //add user to DELIVERED
            $name = explode(' ', Input::get('name'), 2);
            $firstName = (isset($name[1])) ? $name[1] : $name[0];
            $lastName = (isset($name[0])) ? $name[0] : 'lastname';
            
            $response = $this->delivered->addUser( $firstName, $lastName, Input::get('email') );
            if( is_array($response) && $response['success'] == true ){
                $user = $response['data'];
                if( is_array($user) ) $user = json_decode(json_encode($user), FALSE);
                
                // add user to list
                $list = $this->_getList();
                $response = $this->delivered->addUsersToList( $list->id, [$user->id] );
                
                if( is_array($response) && $response['success'] == true ){
                    // add tags
                    $tag1 = $this->delivered->addTag('second-tier-publisher-id', 'Integer', $stpi, $user->id);
                    $tag2 = $this->delivered->addTag('lp-page', 'String', Input::get('lp-val'), $user->id);
                    if( is_array($tag1) && $tag1['success'] == true && is_array($tag2) && $tag2['success'] == true  ){
                        // send email
                        $template = $this->_getTemplate();
                        $variables = json_encode( ['FIRST_NAME' => $user->firstName ] );
                        $result = $this->delivered->executeEmailRequest('immediate', $template->id, $user->id, $variables );
                        if( is_array($response) && $response['success'] == true ){
                            return Redirect::to('lp1/success.php?name='.$firstName);
                        }
                        else{
                             $errors = urlencode( json_encode($result['errors']) );
                        }
                    }
                    else{
                        $errors = [];
                        if( $tag1['success'] != true) $errors += $tag1['errors'];
                        if( $tag2['success'] != true) $errors += $tag2['errors'];
                        $errors = urlencode( json_encode($errors) );
                    }
                }
                else{
                    $errors = urlencode( json_encode($response['errors']) );
                }
                
            }
            else{
                $errors = urlencode( json_encode($response['errors']) );
            }
            
            $name = urlencode(Input::get('name'));
            $email = urlencode(Input::get('email'));
            $error_flag.= "&errors=$errors&name=$name&email=$email#form";
            return Redirect::to( $referer.$error_flag  );
	}

}