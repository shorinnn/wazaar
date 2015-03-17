<?php

class PurchaseHelper{
    
    public static function instructorEarnings($product, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost();
        if($affiliate == null){// no affiliate share, instructor gets full 70%
            return $amount * (Config::get('custom.earnings.instructor_percentage') / 100);
        }
        else{// affiliate fee, instructor gets 70% - affiliate cut
            return $amount * ( (Config::get('custom.earnings.instructor_percentage') / 100) - ($course->affiliate_percentage / 100) );
        }
    }
    
    
    public static function affiliateEarnings($product, $affiliate){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost();
        if($affiliate == null){// no affiliate, nobody to share with
            return 0;
        }
        else{// affiliate get his percentage
            return $amount * ($course->affiliate_percentage / 100);
        }
    }
    
    public static function siteEarnings($product, $processor_fee){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() * (Config::get('custom.earnings.site_percentage') / 100);
        $ltcAmount = $amount  * (Config::get('custom.earnings.ltc_percentage') / 100);
        $agencyAmount = ($course->instructor->agency==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        return $amount - $ltcAmount - $agencyAmount - $processor_fee;
    }
    
    public static function ltcAffiliateEarnings($product){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() * (Config::get('custom.earnings.site_percentage') / 100);
        return $amount * (Config::get('custom.earnings.ltc_percentage') / 100);
    }
    
    public static function agencyEarnings($product){
        $course = (get_class($product)=='Course') ? $product : $product->module->course;
        $amount = $product->cost() * (Config::get('custom.earnings.site_percentage') / 100);
        $agencyAmount = ($course->instructor->agency==null) ? 0 : $amount * (Config::get('custom.earnings.agency_percentage') / 100);
        return $agencyAmount;
    }
}