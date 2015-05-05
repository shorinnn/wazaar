<?php

class PurchaseHelper{
    
    public static function instructorEarnings($product, $processor_fee, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() - $processor_fee;
        if( $affiliate == null || $course->affiliate_percentage==0 ){// no affiliate share, instructor gets full 70%
            return $amount * (Config::get('custom.earnings.instructor_percentage') / 100);
        }
        else{// affiliate fee, instructor gets 70% - affiliate cut - second tier affiliate cut
            $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            
            if($affiliate->ltcAffiliate == null) {
                return $amount * ( (Config::get('custom.earnings.instructor_percentage') / 100) - ($course->affiliate_percentage / 100) );
            }
            else{
                return $amount * ( (Config::get('custom.earnings.instructor_percentage') / 100) 
                    - ($course->affiliate_percentage / 100)
                    - Config::get('custom.earnings.second_tier_percentage') / 100 );
            }
        }
    }
    
    
    public static function affiliateEarnings($product, $processor_fee, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() - $processor_fee;
        if($affiliate == null){// no affiliate, nobody to share with
            return 0;
        }
        else{// affiliate get his percentage
            return $amount * ($course->affiliate_percentage / 100);
        }
    }
    
    public static function secondTierAffiliateEarnings($product, $processor_fee, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() - $processor_fee;
        $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
        if($course->affiliate_percentage == 0 || $affiliate == null || $affiliate->ltcAffiliate==null){
            return 0;
        }

        return $amount * ( Config::get('custom.earnings.second_tier_percentage') / 100);
    }
    
    public static function siteEarnings($product, $processor_fee){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = ( $product->cost() - $processor_fee ) * (Config::get('custom.earnings.site_percentage') / 100);
        $ltcAmount = $amount  * (Config::get('custom.earnings.ltc_percentage') / 100);
        $agencyAmount = ($course->instructor->agency==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        $secondTierInstructor = ($course->instructor->secondTierInstructor==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        return $amount - $ltcAmount - $agencyAmount - $secondTierInstructor - $processor_fee;
    }
    
    public static function ltcAffiliateEarnings($product, $processor_fee){
        $course = ( get_class($product)=='Course' ) ? $product : $product->module->course;
        $amount = ( $product->cost() - $processor_fee ) * (Config::get('custom.earnings.site_percentage') / 100);
        return $amount * (Config::get('custom.earnings.ltc_percentage') / 100);
    }
    
    public static function agencyEarnings( $product, $processor_fee ){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = ( $product->cost() - $processor_fee ) * (Config::get('custom.earnings.site_percentage') / 100);
        $agencyAmount = ($course->instructor->agency==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        return $agencyAmount;
    }
    
    public static function secondTierInstructorEarnings($product, $processor_fee){
        $course = ( get_class($product)=='Course' ) ? $product : $product->module->course;
        $amount = ( $product->cost() - $processor_fee ) * (Config::get('custom.earnings.site_percentage') / 100);
        $amount =  ($course->instructor->secondTierInstructor==null) ? 0 : $amount * (Config::get('custom.earnings.second_tier_instructor_percentage') / 100);
        return $amount;
    }
}