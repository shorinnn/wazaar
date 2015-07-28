<?php

 
 
class DeliveredImporter {

    public static function import(){
        echo "\n\n************ IMPORTING EMAILS TO DELIVERED ***************** \n\n";
        
        $start = time();

        $delivered = new DeliveredHelper();
        echo "Fetching DELIVERED users...";
        $deliveredUsers = $delivered->getUsers();
        $deliveredUsers = $deliveredUsers['data'];
        
        echo "DONE.\n";
        $total = count($deliveredUsers);
        echo " --- $total DELIVERED users fetched.\n";
        
        echo "Fetching Wazaar users...";
        $users = User::all();
        $total = $users->count();
        echo "DONE\n";
        echo " --- $total Wazaar users fetched.\n";
        
        $unimported = [];
        foreach($users as $user){
            if($user->email == 'nagisa_la_mer@hotmail.com') continue;
            if($user->email == 'freestyle_innovation@yahoo.co.jp') continue;
            if($user->email == 'superadmin@wazaar.jp') continue;
            if($user->email == 'wazaarAffiliate@wazaar.jp') continue;
            $exists = false;
            foreach($deliveredUsers as $dUser){
                if( strtolower($dUser['email']) == strtolower($user->email) ) $exists = true;
            }
            if( !$exists ) $unimported[] = $user;
        }
        $total = count($unimported);
        echo "$total emails require importing\n";
        echo "\nIMPORTING EMAILS TO DELIVERED...";
        $batch = [];
        foreach($unimported as $user){
            $firstName = $user->first_name;
            if($firstName=='') $firstName = 'F';
            $lastName = $user->last_name;
            if($lastName=='') $lastName = 'L';
            $b = [ 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $user->email];
            $batch[] = $b;
        }
        $batch = json_encode($batch);
        $response = $delivered->addBatchUsers( $batch );
        
        if( is_array($response) && $response['success'] == false ){
            dd($response);
        }
        
        $time = time() - $start;
        
        echo "DONE\n\nTIME ELAPSED: $time seconds\n";
    }
    
    public static function updateTags(){
        echo "\n\n************ UPDATING TAGS FOR DELIVERED USERS ***************** \n\n";
        
        $start = time();

        $delivered = new DeliveredHelper();
        echo "Fetching DELIVERED users...";
        $deliveredUsers = $delivered->getUsers();
        $deliveredUsers = $deliveredUsers['data'];
        
        echo "DONE.\n";
        $total = count($deliveredUsers);
        echo "$total DELIVERED users fetched.\n";
        
        echo "Fetching Wazaar users...";
        $users = User::all();
        $total = $users->count();
        echo "DONE\n";
        echo "$total Wazaar users fetched.\n";
        
        echo "Updating Tags On Delivered...";
        $userCount = 0;
        $tagCount = 0;
        $sleepCount = 0;
        foreach( $users as $user ){
            
            
            $requiredTags = [];
            $requiredTags['student'] = ['student'];
            if( $user->hasRole('Instructor') ) $requiredTags['instructor'] = 'instructor';
            if( $user->is_second_tier_instructor ) $requiredTags['stinstructor']= 'stinstructor';
            if( $user->hasRole('Affiliate') ) $requiredTags['affiliate']= 'affiliate';
            
            foreach($deliveredUsers as $dUser){
                if( $dUser['email'] == $user->email ){
                    $deliveredID = $dUser['id'];
                    $user->delivered_user_id = $deliveredID;
                    $user->updateUniques();
                    
                    foreach( $dUser['tags'] as $tag ){
                        if( $tag['tagName'] == 'user-type-student' ){
                            if(isset($requiredTags['student'])) unset( $requiredTags['student'] );
                        }
                        if( $tag['tagName'] == 'user-type-instructor' ){
                            if(isset($requiredTags['instructor'])) unset( $requiredTags['instructor'] );
                        }
                        if( $tag['tagName'] == 'user-type-stinstructor' ){
                            if(isset($requiredTags['stinstructor'])) unset( $requiredTags['stinstructor'] );
                        }
                        if( $tag['tagName'] == 'user-type-affiliate' ){
                            if(isset($requiredTags['affiliate'])) unset( $requiredTags['affiliate'] );
                        }
                    }
                    if( array($requiredTags) && count($requiredTags) > 0){
                        $userCount++;
                    }
                    foreach($requiredTags as $tag => $val){
                        $delivered->addTag('user-type-'.$tag, 'String', 1, $deliveredID);
                        $tagCount++;
                    }
                    // sleep every 25 users
                    if( $sleepCount % 25 == 0 ){
                        echo "\n 1 second sleep ($sleepCount users updated) ";
                        sleep(1);
                    }
                    $sleepCount++;
                }
                
            }
        }
        
        echo "\nDONE\n";
        

        
        $time = time() - $start;
        
         echo "
             $tagCount tags added for $userCount DELIVERED users.
            \n\nTIME ELAPSED: $time seconds\n";
    }
    
    public static function updateConfirmedTag(){
        echo "\n\n************ UPDATING EMAIL CONFIRMED TAGS FOR DELIVERED USERS ***************** \n\n";
        
        $start = time();

        $delivered = new DeliveredHelper();
        echo "Fetching DELIVERED users...";
        $deliveredUsers = $delivered->getUsers();
        $deliveredUsers = $deliveredUsers['data'];
        
        echo "DONE.\n";
        $total = count($deliveredUsers);
        echo "$total DELIVERED users fetched.\n";
        
        echo "Fetching Wazaar users...";
        $users = User::all();
        $total = $users->count();
        echo "DONE\n";
        echo "$total Wazaar users fetched.\n";
        
        echo "Updating CONFIRMED Tags On Delivered...";
        $userCount = 0;
        $tagCount = 0;
        $sleepCount = 0;
        foreach( $users as $user ){
            
            $confirmed = $user->confirmed;
            foreach($deliveredUsers as $dUser){
                if( $dUser['email'] == $user->email ){
                    $deliveredID = $dUser['id'];
                    $user->delivered_user_id = $deliveredID;
                    $user->updateUniques();
                    
                    $added = false;
                    foreach( $dUser['tags'] as $tag ){
                        if( $tag['tagName'] == 'email-confirmed' ){
                            $delivered->updateTag( $tag['id'], $deliveredID, 'email-confirmed', 'tagIntegerValue', $confirmed);
                            $added = true;
                            $userCount++;
                        }
                    }
                    if( !$added ){
                        $delivered->addTag('email-confirmed', 'Integer', $confirmed, $deliveredID);
                        $userCount++;
                    }
                    
                    // sleep every 25 users
                    if( $sleepCount % 25 == 0 ){
                        echo "\n 1 second sleep ($sleepCount users updated) ";
                        sleep(1);
                    }
                    $sleepCount++;
                }
            }
            
            
            
        }
        
        echo "\nDONE\n";
        

        
        $time = time() - $start;
        
         echo "
             Updated $userCount DELIVERED users.
            \n\nTIME ELAPSED: $time seconds\n";
    }
    
    public static function extract_email_address ($string) {
        foreach(preg_split('/\s/', $string) as $token) {
            $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if ($email !== false) {
                $emails[] = $email;
            }
        }
        return $emails;
    }
    
}