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
               array('run', null, InputOption::VALUE_REQUIRED, 'What to run: fix_70_30')
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
        
        public  function fix_70_30(){
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
        

	

}
