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
        }
        
        private function _getTemplate(){
            $delivered = new DeliveredHelper();
            $templates = $delivered->getTemplates();
            foreach($templates['data'] as $template){
                if( $template['templateName'] == $this->template->templateName ) return json_decode(json_encode($template), FALSE);
            }
            // template not there yet, create it
            $data = $delivered->addTemplate( $this->template->templateName, $this->template->subject, $this->template->name,
                    $this->template->email, $this->template->content);
            return $data['data'];
        }
    
        public function index(){
            $delivered = new DeliveredHelper();
            $users = $delivered->getUsers();
            $user = $users['data'][0];
            if(is_array($user) ) $user = json_decode(json_encode($user), FALSE);
//            dd($user);
//            $delivered->deleteTemplate(3);
//            $templates = $delivered->getTemplates();
//            dd($templates);
            
//            $template = $this->_getTemplate();
//            dd($template);
            
            $template = $this->_getTemplate();
            // send email
            $variables = json_encode( ['FIRST_NAME' => $user->firstName ] );
            $result = $delivered->executeEmailRequest('immediate', $template->id, $user->id, $variables );
            dd($result);

            return View::make('lp.index');
        }

	public function store()
	{
            $error_flag = '?error=1';
            if( Input::has('stpi') ){
                Cookie::queue('stpi', Input::get('stpi'), 60*24*30);
                $error_flag = '&error=1';
            }
            
            //add user to DELIVERED
            $delivered = new DeliveredHelper();
            $name = explode(' ', Input::get('name'), 2);
            $firstName = (isset($name[1])) ? $name[1] : 'firstname';
            $lastName = (isset($name[0])) ? $name[0] : 'lastname';
            $response = $delivered->addUser( $firstName, $lastName, Input::get('email') );
            if( is_array($response) && $response['success'] == true ){
                $user = $response['data'];
                if( is_array($user) ) $user = json_decode(json_encode($user), FALSE);
                        
                $template = $this->_getTemplate();
                $variables = json_encode( ['FIRST_NAME' => $user->firstName ] );
                $result = $delivered->executeEmailRequest('immediate', $template->id, $user->id, $variables );
                return Redirect::to('lp1/success.php');
            }
            return Redirect::to( $_SERVER['HTTP_REFERER'].$error_flag );
	}

}