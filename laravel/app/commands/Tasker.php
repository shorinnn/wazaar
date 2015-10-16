<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TaskerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:tasker';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Runs misc tasks';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
        
        /**
        * Get the console command options.
        *
        * @return array
        */
       protected function getOptions()
       {
           return array(
               array('run', null, InputOption::VALUE_REQUIRED, 'What to run: fix_70_30, precalculate_ltc_stats, yozawa_fix, fix_ltc_stpub, 
                   missing_delivered_fix, fix_botched_900, recalculateDiscountSaleMoney, fix_student_count, cloud_search_index_all',
                   'strip_affs_of_other_roles'),
               array('sale', null, InputOption::VALUE_OPTIONAL, ' recalculateDiscountSaleMoney sale ID'),
               array('price', null, InputOption::VALUE_OPTIONAL, ' recalculateDiscountSaleMoney new price value'),
           );
       }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            
            $run = $this->option('run');
            $this->$run();
	}
        
        public  function precalculate_ltc_stats(){
            $this->info( '***************************************************' );
            $this->info( '*********** PRECALCULATING LTC STATS ************' );
            DB::table('users')->update( ['ltc_count' => -1] );
            $count = 1;
            $updated = 0;
            $maxLoops = 50;
            $i = 0;
            while($count != 0){
                $result = DB::select("SELECT `id` as `theID`,
                (SELECT COUNT(id) FROM `users` WHERE `ltc_affiliate_id` = theID) AS `ref_count` FROM `users` WHERE `has_ltc` = 'yes'
                AND ltc_count = -1 LIMIT 500");
                $count = count($result);
                foreach($result as $user){
                    DB::table('users')->where('id', $user->theID)->update([ 'ltc_count' => $user->ref_count] );
                }
                $updated += $count;
                $this->comment("$updated rows updated. Sleep 1 second");
                ++$i;
                sleep(1);
                $this->comment('Resuming...');
                if($i > $maxLoops) dd('MAX LOOPS REACHED');
            }
            $this->info("DONE. $updated rows updated");
            
            
        }
        
        public  function __fix_70_30(){
            DB::table('purchases')->where('instructor_earnings','<',0)->update( ['instructor_earnings' => 0 ] );
            $this->info( '***************************************************' );
            $this->info( '*********** FIX 70% 30% EARNINGS ISSUE ************' );
            $this->info( 'Fetching sales with no Second Tier Affiliates' );
            $fixed = DB::table('misc_tasks')->where('key', 'fix-70-30')->lists('val');
            if( count($fixed)==0 ) $fixed = [0];
            $sales = Purchase::whereNotIn('id', $fixed)->where('free_product', 'no')->where('second_tier_affiliate_id', '<', 1)->get();
            $this->info( $sales->count().' sales found');
            foreach($sales as $sale){
                $percentage = $sale->instructor_earnings * 100 / $sale->purchase_price;
                $site_percentage = $sale->site_earnings * 100 / $sale->purchase_price;
                $this->info("Sale #$sale->id.");
                $this->comment("Instructor Percentage: $percentage% ($sale->instructor_earnings YEN). Site percentage:  $site_percentage% ($sale->site_earnings YEN)");
                $two = $sale->purchase_price * 0.02;
//                $instructor_earnings = $sale->instructor_earnings += $two;
//                $site_earnings = $sale->site_earnings -= $two;
                $sale->instructor_earnings = $instructor_earnings = $sale->purchase_price * 0.7;
                $sale->site_earnings = $site_earnings = $sale->purchase_price * 0.3;
                
                $course = Course::find( $sale->product_id);
                if( $sale->second_tier_instructor_earnings > 0 ){
                    $sale->second_tier_instructor_earnings =
                            $sale->site_earnings * (Config::get('custom.earnings.second_tier_instructor_percentage') / 100);
                    $site_earnings -= $sale->second_tier_instructor_earnings;
                    
                }
                
                if( $sale->affiliate_earnings > 0 ){
//                    $s = $sale->affiliate_earnings;
                    $sale->affiliate_earnings = $sale->purchase_price * ($course->affiliate_percentage / 100);
                    $instructor_earnings -= $sale->affiliate_earnings;
                }
                
        
                if( $sale->ltc_affiliate_earnings > 0 ){
                    $affiliate = User::find( $sale->ltc_affiliate_id );
                    $percentage = min( Config::get('custom.earnings.ltc_percentage') );
                    if( $affiliate->is_super_vip == 'yes' || $affiliate->is_vip=='yes' ) $percentage = max( Config::get('custom.earnings.ltc_percentage') );
                    $sale->ltc_affiliate_earnings = $sale->site_earnings *( $percentage / 100 );
                    $site_earnings -= $sale->ltc_affiliate_earnings;
                }
                
                
                $sale->instructor_earnings = $instructor_earnings;
                $sale->site_earnings = $site_earnings;
                
                $percentage = $sale->instructor_earnings * 100 / $sale->purchase_price;
                $site_percentage = $sale->site_earnings * 100 / $sale->purchase_price;
                
                
                $this->comment("FIXED: Sale $sale->id. Instructor Percentage: $percentage% ($sale->instructor_earnings YEN). Site percentage:  $site_percentage% ($sale->site_earnings YEN)");
                $total = $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings;  
                
                if($total != $sale->purchase_price){
                    $this->error("Earnings mismatch. Earned: $sale->purchase_price - Adjusted: $total");
                }
                
                // update purchase object
                if( $sale->updateUniques() ){
                    // update transactions
                    $instructor_earnings_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'instructor_credit')->first();
                    $instructor_earnings_transaction->amount = $sale->instructor_earnings;
                    if( !$instructor_earnings_transaction->updateUniques() ){
                            dd("FAILED UPDATING INSTRUCTOR  $instructor_earnings_transaction->id");
                    }
                    
                    if( $sale->second_tier_instructor_earnings > 0 ){
                        $sti_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'second_tier_instructor_credit')->first();
                        $sti_transaction->amount = $sale->second_tier_instructor_earnings;
                        if ( !$sti_transaction->updateUniques() ){
                            dd("FAILED UPDATING STI_TRANSACTION $sti_transaction->id");
                        }
                    }
                    
                    if( $sale->affiliate_earnings ){
                        $aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','no')
                                ->where('is_second_tier','no')->first();
                        $aff_transaction->amount = $sale->affiliate_earnings;
                        if( !$aff_transaction->save() ){
                            dd("FAILED UPDATING AFF_TRANSACTION $aff_transaction->id");
                        }
                    }
                    
                    if( $sale->ltc_affiliate_earnings > 0){
                        $ltc_aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','yes')
                                ->where('is_second_tier','no')->first();
                        $ltc_aff_transaction->amount = $sale->ltc_affiliate_earnings;
                        if( !$ltc_aff_transaction->save() ){
                            dd("FAILED UPDATING LTC_TRANSACTION $ltc_aff_transaction->id");
                        }
                    }
                    
                    $site_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'site_credit')->first();
                    $site_transaction->amount = $sale->site_earnings;
                    if( !$site_transaction->updateUniques() ){
                            dd("FAILED UPDATING SITE_TRANSACTION $site_transaction->id");
                    }
                    $insert = DB::table('misc_tasks')->insert( [ 'key' => 'fix-70-30', 'val' => $sale->id] );
                    if( !$insert ){
                        dd("COULDNT SAVE CONFIRMATION");
                    }
                }
                else{
                    dd("FAILED UPDATING SALE $sale->id");
                }
            }
        }
        

        public function yozawa_fix(){
            $st = User::where('email','yozawa@exraise-venture.asia')->first();
            $ltc = User::where('email','#waa#-yozawa@exraise-venture.asia')->first();
            
            $ltc_users = User::where('ltc_affiliate_id', $ltc->id)->count();
            $this->info("Yozawa LTC referrals: $ltc_users");
            
            $current_st_fk = User::where('second_tier_instructor_id',$st->id)->count();
            $this->info("Initial Instructors with Yozawa ST: $current_st_fk");
            
            DB::table('users')->where('ltc_affiliate_id', $ltc->id)->update( [ 'second_tier_instructor_id' => $st->id] );
            
            $current_st_fk = User::where('second_tier_instructor_id',$st->id)->count();
            $this->info("Instructors with Yozawa ST AFTER FIX: $current_st_fk");
        }
        
        public  function fix_ltc_stpub(){
            $this->info( '***************************************************' );
            $this->info( '*********** FIX LTC/ST PUB EARNINGS ISSUE ************' );
            $this->info( 'Fetching sales with LTC / STPUB' );
            $fixed = DB::table('misc_tasks')->where('key', 'fix-ltc-stpub')->lists('val');
            if( count($fixed)==0 ) $fixed = [0];
            $sales = Purchase::whereNotIn('id', $fixed)->where('free_product', 'no')->where(function($q){
                $q->where('ltc_affiliate_id', '>', 0)
                ->orWhere('second_tier_instructor_id', '>', 0);
            })->get();
            $this->info( $sales->count().' sales found');
            foreach($sales as $sale){
                $percentage = $sale->instructor_earnings * 100 / $sale->purchase_price;
                $site_percentage = $sale->site_earnings * 100 / $sale->purchase_price;
                $this->info("Sale #$sale->id.");
                $this->comment("Instructor Percentage: $percentage% ($sale->instructor_earnings YEN). Site percentage:  $site_percentage% ($sale->site_earnings YEN). Aff: $sale->affiliate_earnings. STA:$sale->second_tier_affiliate_earnings. LTC: $sale->ltc_affiliate_earnings. STPUB: $sale->second_tier_instructor_earnings");
                $sale->instructor_earnings = $instructor_earnings = $sale->purchase_price * 0.7;
                $sale->site_earnings = $site_earnings = $sale->purchase_price * 0.3;
                
                $course = Course::find( $sale->product_id);
                if( $sale->second_tier_instructor_earnings > 0 ){
                    $sale->second_tier_instructor_earnings =
                            $sale->purchase_price * (Config::get('custom.earnings.second_tier_instructor_percentage') / 100);
                    $site_earnings -= $sale->second_tier_instructor_earnings;
                    
                }
                
                if( $sale->affiliate_earnings > 0 ){
//                    $s = $sale->affiliate_earnings;
                    $sale->affiliate_earnings = $sale->purchase_price * ($course->affiliate_percentage / 100);
                    $instructor_earnings -= $sale->affiliate_earnings;
                }
                
        
                if( $sale->ltc_affiliate_earnings > 0 ){
                    $affiliate = User::find( $sale->ltc_affiliate_id );
                    $percentage = min( Config::get('custom.earnings.ltc_percentage') );
                    if($affiliate!=null &&(  $affiliate->is_super_vip == 'yes' || $affiliate->is_vip=='yes' ) ) $percentage = max( Config::get('custom.earnings.ltc_percentage') );
                    $sale->ltc_affiliate_earnings = $sale->purchase_price *( $percentage / 100 );
                    $site_earnings -= $sale->ltc_affiliate_earnings;
                }
                
                $sale->instructor_earnings = round($instructor_earnings, 3) - round($sale->second_tier_affiliate_earnings, 3);
                $sale->site_earnings = $site_earnings;
                
                $percentage = $sale->instructor_earnings * 100 / $sale->purchase_price;
                $site_percentage = $sale->site_earnings * 100 / $sale->purchase_price;
                
                
                $this->comment("FIXED: Sale $sale->id. 
Instructor Percentage: $percentage% ($sale->instructor_earnings YEN). Site percentage:  $site_percentage% ($sale->site_earnings YEN). Aff: $sale->affiliate_earnings. STA:$sale->second_tier_affiliate_earnings.  LTC: $sale->ltc_affiliate_earnings. STPUB: $sale->second_tier_instructor_earnings");
                $total = $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings;  
                
                if($total != $sale->purchase_price){
                    $this->error("Earnings mismatch. Earned: $sale->purchase_price - Adjusted: $total");
                }
                
                // update purchase object
                if( $sale->updateUniques() ){
                    // update transactions
                    $instructor_earnings_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'instructor_credit')->first();
                    if($instructor_earnings_transaction !=null) {
                        $instructor_earnings_transaction->amount = $sale->instructor_earnings;
                        if( !$instructor_earnings_transaction->updateUniques() ){
                                dd("FAILED UPDATING INSTRUCTOR  $instructor_earnings_transaction->id");
                        }
                    }
                    
                    if( $sale->second_tier_instructor_earnings > 0 ){
                        $sti_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'second_tier_instructor_credit')->first();
                        $sti_transaction->amount = $sale->second_tier_instructor_earnings;
                        if ( !$sti_transaction->updateUniques() ){
                            dd("FAILED UPDATING STI_TRANSACTION $sti_transaction->id");
                        }
                    }
                    
                    if( $sale->affiliate_earnings ){
                        $aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','no')
                                ->where('is_second_tier','no')->first();
                        $aff_transaction->amount = $sale->affiliate_earnings;
                        if( !$aff_transaction->save() ){
                            dd("FAILED UPDATING AFF_TRANSACTION $aff_transaction->id");
                        }
                    }
                    
                    if( $sale->ltc_affiliate_earnings > 0){
                        $ltc_aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','yes')
                                ->where('is_second_tier','no')->first();
                        $ltc_aff_transaction->amount = $sale->ltc_affiliate_earnings;
                        if( !$ltc_aff_transaction->save() ){
                            dd("FAILED UPDATING LTC_TRANSACTION $ltc_aff_transaction->id");
                        }
                    }
                    
                    $site_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'site_credit')->first();
                    if($site_transaction != null){
                        $site_transaction->amount = $sale->site_earnings;
                        if( !$site_transaction->updateUniques() ){
                                dd("FAILED UPDATING SITE_TRANSACTION $site_transaction->id");
                        }
                    }
                    $insert = DB::table('misc_tasks')->insert( [ 'key' => 'fix-ltc-stpub', 'val' => $sale->id] );
                    if( !$insert ){
                        dd("COULDNT SAVE CONFIRMATION");
                    }
                }
                else{
                    $str = $sale->errors()->all();
                    $str = print_r($str, true);
                    dd("FAILED UPDATING SALE $sale->id - ".$str);
                }
            }
        }
        
        public function missing_delivered_fix(){
            $this->info( "************ IMPORTING EMAILS TO DELIVERED *****************" );
            $start = time();

            $delivered = new DeliveredHelper();
            $users = User::whereNull( 'delivered_user_id' )->get();
            $total = $users->count();
            $this->info( $total . " emails with no Delivered ID. " );
            $counter = 0;
            $addedFromAff = $addedFromStudent = $addedFromDB = $addedToDelivered = $failedDelivered = 0;
            $failedUpdates = $notOnDelivered = [];
            foreach( $users as $user ){
                // see if this email already exists as another account
                $affiliate =  User::where('email', '#waa#-'.$user->email)->whereNotNull('delivered_user_id' )->first();
                $studentEmail = str_replace('#waa#-', '', $user->email);
                $student = User::where('email', $studentEmail)->whereNotNull('delivered_user_id')->first();
                
                if( $affiliate != null ){// get delivered ID from affiliate account
                    $user->delivered_user_id = $affiliate->delivered_user_id;
                    if( !$user->updateUniques() ){
                        $failedUpdates[] = $user->id;
                    } 
                    
                    if( $user->hasRole('Student') ) $delivered->addTag('user-type-student', 'integer', 1, $user->delivered_user_id );
                    if( $user->hasRole('Instructor') ) $delivered->addTag('user-type-instructor', 'integer', 1, $user->delivered_user_id );
                    if( $user->hasRole('Affiliate') ) $delivered->addTag('user-type-affiliate', 'integer', 1, $user->delivered_user_id );
                    $delivered->addTag('email-confirmed', 'integer', $user->confirmed, $user->delivered_user_id );
                    
                    $addedFromAff++;
                    $addedFromDB++;
                    
                    
                }
                elseif( $student != null ){// get delivered ID from student account
                    $user->delivered_user_id = $student->delivered_user_id;
                    if( !$user->updateUniques() ){
                        $failedUpdates[] = $user->id;
                    } 
                    
                    if( $user->hasRole('Student') ) $delivered->addTag('user-type-student', 'integer', 1, $user->delivered_user_id );
                    if( $user->hasRole('Instructor') ) $delivered->addTag('user-type-instructor', 'integer', 1, $user->delivered_user_id );
                    if( $user->hasRole('Affiliate') ) $delivered->addTag('user-type-affiliate', 'integer', 1, $user->delivered_user_id );
                    $delivered->addTag('email-confirmed', 'integer', $user->confirmed, $user->delivered_user_id );
                    
                    $addedFromStudent++;
                    $addedFromDB++;
                }
                else{// add the guy to delivered
                    $email = str_replace('#waa#-', '', $user->email);
                    $first_name = trim($user->first_name) == ''? $user->email : $user->first_name;
                    $last_name = trim($user->last_name) == ''? $user->email : $user->last_name;
                    $response = $delivered->addUser($first_name, $last_name, $email);
                    if( is_array($response) && $response['success'] == true ){
                        $addedToDelivered++;
                        $userData = $response['data'];
                        if( is_array($userData) ) $userData = json_decode(json_encode($userData), FALSE);
                        $user->delivered_user_id = $userData->id;
                        
                        if( ! $user->updateUniques() ) $failedUpdates[] = $user->id; 
                        // associate tags with the user
                        if( $user->hasRole('Student') ) $delivered->addTag('user-type-student', 'integer', 1, $userData->id);
                        if( $user->hasRole('Instructor') ) $delivered->addTag('user-type-instructor', 'integer', 1, $userData->id);
                        if( $user->hasRole('Affiliate') ) $delivered->addTag('user-type-affiliate', 'integer', 1, $userData->id);
                        $delivered->addTag('email-confirmed', 'integer', $user->confirmed, $userData->id);
                    }
                    else{
                        $failedDelivered++;
                        $notOnDelivered[] = $user->id;
                    }
                }
                
                ++$counter;
                if( $counter % 300 == 0){
                    $this->comment(date("Y-m-d H:i:s")." - $counter / $total users processed. Sleep 1 second");
                    sleep(1);
                }
            }
            $time = gmdate("H:i:s", time() - $start);
            $this->info( "Done. Time elapsed: $time");
            $this->info("IDs fetched from existing students: $addedFromStudent");
            $this->info("IDs fetched from existing affiliates: $addedFromAff");
            $this->info("Total IDs fetched from existing Users: $addedFromDB");
            $this->info("Total IDs added to Delivered: $addedToDelivered");
            $this->error("$failedDelivered users not added to Delivered");
            $notOnDelivered = implode(', ', $notOnDelivered);
            $this->error( $notOnDelivered ); 
            $this->error( "Failed local updates:"); 
            $failedUpdates = implode(', ', $failedUpdates);
            $this->error( $failedUpdates ); 
            return true;
        }
        
        public function fix_botched_900(){
            $this->info( "************ FIX BOTCHED 900 *****************" );
            $start = time();

            $delivered = new DeliveredHelper();
            $users = User::orderBy('updated_at','desc')->skip(9000)->limit(2000)->get();
            $total = $users->count();
            $this->info( $total . " botched emails. " );
            $counter = 0;
            
            $fixed = 0;
            foreach( $users as $user ){
                
                if( $user->hasRole('Student') ) $delivered->addTag('user-type-student', 'integer', 1, $user->delivered_user_id );
                if( $user->hasRole('Instructor') ) $delivered->addTag('user-type-instructor', 'integer', 1, $user->delivered_user_id );
                if( $user->hasRole('Affiliate') ) $delivered->addTag('user-type-affiliate', 'integer', 1, $user->delivered_user_id );
                $delivered->addTag('email-confirmed', 'integer', $user->confirmed, $user->delivered_user_id );
                
                ++$fixed;
                ++$counter;
                if( $counter % 300 == 0){
                    $this->comment(date("Y-m-d H:i:s")." - $counter / $total users processed. Sleep 1 second");
                    sleep(1);
                }
            }
            $time = gmdate("H:i:s", time() - $start);
            $this->info( "Done. Time elapsed: $time");
            $this->info("Fixed users: $fixed");
            return true;
        }
        
        public function recalculateDiscountSaleMoney(){
            
            $this->info( '***************************************************' );
            $this->info( '*********** RECALCULATE SALE MONEY ************' );
//            $sales = [ 5578 ];
            $sales = $this->option('sale');
            $sales = [ $sales ];
            $sales = Purchase::whereIn('id', $sales)->get();
//            $newPurchasePrice = 9800;
            $newPurchasePrice = $this->option('price');
            $this->info( $sales->count().' sales found');
            foreach($sales as $sale){
                $sale->purchase_price = $newPurchasePrice;
                $sale->instructor_earnings = $instructor_earnings = $sale->purchase_price * 0.7;
                $sale->site_earnings = $site_earnings = $sale->purchase_price * 0.3;
//                $sale->discount_value = 0;
//                $sale->discount = null;
                
                $course = Course::find( $sale->product_id);
                if( $sale->second_tier_instructor_earnings > 0 ){
                    $sale->second_tier_instructor_earnings =
                            $sale->site_earnings * (Config::get('custom.earnings.second_tier_instructor_percentage') / 100);
                    $site_earnings -= $sale->second_tier_instructor_earnings;
                    
                }
                
                if( $sale->affiliate_earnings > 0 ){
//                    $s = $sale->affiliate_earnings;
                    $sale->affiliate_earnings = $sale->purchase_price * ($course->affiliate_percentage / 100);
                    $instructor_earnings -= $sale->affiliate_earnings;
                }
                
                if( $sale->second_tier_affiliate_earnings > 0 ){
                    $sale->second_tier_affiliate_earnings = $sale->purchase_price * ( Config::get('custom.earnings.second_tier_percentage') / 100);
                    $instructor_earnings -= $sale->second_tier_affiliate_earnings;
                }
                
        
                if( $sale->ltc_affiliate_earnings > 0 ){
                    $affiliate = User::find( $sale->ltc_affiliate_id );
                    $percentage = min( Config::get('custom.earnings.ltc_percentage') );
                    if( $affiliate->is_super_vip == 'yes' || $affiliate->is_vip=='yes' ) $percentage = max( Config::get('custom.earnings.ltc_percentage') );
                    $sale->ltc_affiliate_earnings = $sale->purchase_price *( $percentage / 100 );
                    $site_earnings -= $sale->ltc_affiliate_earnings;
                }
                
                
                $sale->instructor_earnings = $instructor_earnings;
                $sale->site_earnings = $site_earnings;
                
                $percentage = $sale->instructor_earnings * 100 / $sale->purchase_price;
                $site_percentage = $sale->site_earnings * 100 / $sale->purchase_price;
                
                
                $this->comment("FIXED: Sale $sale->id. Purchase price: $sale->purchase_price. Instructor Percentage: $percentage% ($sale->instructor_earnings YEN). Site percentage:  $site_percentage% ($sale->site_earnings YEN)");
                $total = $sale->instructor_earnings + $sale->second_tier_instructor_earnings + $sale->affiliate_earnings + $sale->second_tier_affiliate_earnings
                        + $sale->ltc_affiliate_earnings + $sale->instructor_agency_earnings + $sale->site_earnings;  
                
                if($total != $sale->purchase_price){
                    $this->error("Earnings mismatch. Earned: $sale->purchase_price - Adjusted: $total");
                }
                
                // update purchase object
                if( $sale->updateUniques() ){
                    // update transactions
                    if($instructor_earnings > 0){
                        $instructor_earnings_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'instructor_credit')->first();
                        $instructor_earnings_transaction->amount = $sale->instructor_earnings;
                        if( !$instructor_earnings_transaction->updateUniques() ){
                                dd("FAILED UPDATING INSTRUCTOR  $instructor_earnings_transaction->id");
                        }
                    }
                    
                    if( $sale->second_tier_instructor_earnings > 0 ){
                        $stia_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')
                                ->where('is_second_tier', 'yes')->first();
                        $stia_transaction->amount = $sale->second_tier_affiliate_earnings;
                        if ( !$stia_transaction->updateUniques() ){
                            dd("FAILED UPDATING STIA_TRANSACTION $stia_transaction->id");
                        }
                    }
                    
                    if( $sale->affiliate_earnings ){
                        $aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','no')
                                ->where('is_second_tier','no')->first();
                        $aff_transaction->amount = $sale->affiliate_earnings;
                        if( !$aff_transaction->save() ){
                            dd("FAILED UPDATING AFF_TRANSACTION $aff_transaction->id");
                        }
                    }
                    
                    if( $sale->affiliate_earnings ){
                        $aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','no')
                                ->where('is_second_tier','no')->first();
                        $aff_transaction->amount = $sale->affiliate_earnings;
                        if( !$aff_transaction->save() ){
                            dd("FAILED UPDATING AFF_TRANSACTION $aff_transaction->id");
                        }
                    }
                    
                    if( $sale->ltc_affiliate_earnings > 0){
                        $ltc_aff_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'affiliate_credit')->where('is_ltc','yes')
                                ->where('is_second_tier','no')->first();
                        $ltc_aff_transaction->amount = $sale->ltc_affiliate_earnings;
                        if( !$ltc_aff_transaction->save() ){
                            dd("FAILED UPDATING LTC_TRANSACTION $ltc_aff_transaction->id");
                        }
                    }
                    
                    $site_transaction = Transaction::where('purchase_id', $sale->id)->where('transaction_type', 'site_credit')->first();
                    $site_transaction->amount = $sale->site_earnings;
                    if( !$site_transaction->updateUniques() ){
                            dd("FAILED UPDATING SITE_TRANSACTION $site_transaction->id");
                    }
                    $insert = DB::table('misc_tasks')->insert( [ 'key' => 'fix-70-30', 'val' => $sale->id] );
                    if( !$insert ){
                        dd("COULDNT SAVE CONFIRMATION");
                    }
                }
                else{
                    dd("FAILED UPDATING SALE $sale->id");
                }
            }
        }
        
        public function fix_student_count(){
            $this->info( '***************************************************' );
            $this->info( '*********** FIX COURSE STUDENT COUNT **************' );
            $statuses = ['pending', 'approved'];
            $courses = Course::whereIn('publish_status', $statuses)->get();
            $this->info($courses->count().' courses found');
            foreach($courses as $course){
                $updated = $course->enrolledStudents();
                $this->info("Course $course->id. Student count: $course->student_count Updated count: $updated");
                $course->student_count = $updated;
                $course->updateUniques();
            }
        }
        
        public function cloud_search_index_all(){
            $client = AWS::get('cloudsearchdomain', [ 'endpoint' => Config::get('custom.cloudsearch-document-endpoint') ] );
            $total = Course::where('publish_status', 'approved')
                        ->where('privacy_status','public')
                        ->orWhere(function($query2){
                            $query2->where('privacy_status','public')
                                    ->where('publish_status', 'pending')
                                    ->where('approved_data', '!=', "");
                        })->count();
            $this->info("$total courses to index");
            $count = 1;
            $updated = 0;
            $i = 0;
            while($count != 0){
                $result = Course::where('publish_status', 'approved')
                    ->where('privacy_status','public')
                    ->orWhere(function($query2){
                        $query2->where('privacy_status','public')
                                ->where('publish_status', 'pending')
                                ->where('approved_data', '!=', "");
                    })->limit(500)->skip($updated)->get();
                        
                $count = $result->count();
                if( $count == 0 ) break;
                $batch = [];
                foreach($result as $course){
                    $author = $course->instructor->commentName();
                    $company = '';
                    if( isset($course->instructor->profile) && trim($course->instructor->profile->corporation_name) != ''){
                        $company = $course->instructor->profile->corporation_name;
                    }
                    $batch[] = [
                        'type'      => 'add',
                        'id'        => $course->id,
                        'fields'    => ['author' => $author, 
                                        'company' => $company, 
                                        'id' => $course->id, 
                                        'short_description' => $course->short_description, 
                                        'title' => $course->name ]
                    ];
                }
                $indexResult = $client->uploadDocuments(array(
                    'documents'     => json_encode($batch),
                    'contentType'     =>'application/json'
                ));
                
                $updated += $count;
                $this->comment("$updated rows updated. Sleep 1 second");
                ++$i;
                sleep(1);
                $this->comment('Resuming...');
            }
            
            $this->info('INDEXING COMPLETE');
        }
        
        public function strip_affs_of_other_roles(){
            $affs = User::whereHas(
                        'roles', function($q){
                        $q->where('name', 'Affiliate');
                    })->whereHas(
                        'roles', function($q){
                        $q->where('name', 'Instructor');
                    })->get();
            $this->info($affs->count().' affiliates with Instructor roles found');
            foreach($affs as $aff){
                $aff->detachRoles([1,2,3,5]);
            }
            $this->info('Roles detached');
            $affs = User::whereHas(
                        'roles', function($q){
                        $q->where('name', 'Affiliate');
                    })->whereHas(
                        'roles', function($q){
                        $q->where('name', 'Student');
                    })->get();
            $this->info($affs->count().' affiliates with Student roles found');
            foreach($affs as $aff){
                $aff->detachRoles([1,2,3,5]);
            }
            $this->info('Roles detached');
        }

}
