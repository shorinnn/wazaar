<?php

class PurchaseHelper{
    
    public static function instructorEarnings($product, $processor_fee, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() - $processor_fee;
        if( $affiliate == null || $course->affiliate_percentage==0 ){// no affiliate share, instructor gets full 70%
            return $amount * (Config::get('custom.earnings.instructor_percentage') / 100);
        }
        else{// affiliate fee, instructor gets 70% - affiliate cut - second tier affiliate cut
            $prodAffiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            
            if($prodAffiliate->ltcAffiliate == null) {
                return $amount *  (Config::get('custom.earnings.instructor_percentage') / 100) - self::affiliateEarnings($product, $processor_fee, $affiliate);
            }
            else{
                return $amount * (Config::get('custom.earnings.instructor_percentage') / 100) 
                    - self::affiliateEarnings($product, $processor_fee, $affiliate)
                    - self::secondTierAffiliateEarnings($product, $processor_fee, $affiliate);
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
            // custom percentage
            $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
            $customPercentage = $affiliate->customPercentages()->where('course_id', $course->id)->first();
            if( $customPercentage != null ){
                return $amount * ($customPercentage->percentage / 100);
            }
            // regular percentage
            return $amount * ($course->affiliate_percentage / 100);
        }
    }
    
    public static function secondTierAffiliateEarnings($product, $processor_fee, $affiliate){
        $affiliate_id = $affiliate;
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() - $processor_fee;
        $affiliate = ProductAffiliate::where('affiliate_id', $affiliate)->first();
        if($course->affiliate_percentage == 0 || $affiliate == null || $affiliate->secondTierAffiliate==null){
            return 0;
        }
        return $amount * ( Config::get('custom.earnings.second_tier_percentage') / 100);
    }
    
    public static function siteEarnings($product, $ltcAffiliateId, $processor_fee){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = ( $product->cost() - $processor_fee ) * (Config::get('custom.earnings.site_percentage') / 100);
//        $ltcAmount = $amount  * (Config::get('custom.earnings.ltc_percentage') / 100);
        $ltcAmount = self::ltcAffiliateEarnings($product, $ltcAffiliateId, $processor_fee);
        $agencyAmount = ($course->instructor->agency==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        $secondTierInstructor = ($course->instructor->secondTierInstructor==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        return $amount - $ltcAmount - $agencyAmount - $secondTierInstructor - $processor_fee;
    }
    
    public static function ltcAffiliateEarnings($product, $ltcAffiliateId,  $processor_fee){
        // if null, no LTC earnings
        if( $ltcAffiliateId==null ) return 0;
        // if affiliate not LTC, no LTC earnings
        $affiliate = User::find($ltcAffiliateId);
        if( $affiliate->has_ltc=='no' ) return 0;
        // valid LTC affilaite, sreturn ltc value
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
        $amount =  ($course->instructor->secondTierInstructor==null || $course->instructor->secondTierInstructor->sti_approved == 'no') ? 0 : $amount * (Config::get('custom.earnings.second_tier_instructor_percentage') / 100);
        return $amount;
    }
}