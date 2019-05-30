<?php 

namespace App\Helpers;

class MyHelpers {

    public static function pasrePhone($phone) {

        return preg_replace("/^(|\+)(0|84)/", "0", $phone);
    }
    
    public static function isValidPhoneNumber($phone) {
        $regs = self::getMobilePartterns();
        foreach ($regs as $parttern) {
            if (preg_match($parttern, $phone))
                return true;
        }
        return false;
    }

    public static function getMobilePartterns() {

        $gpcPattern = '/^((\+|)84|0|)(9(1|4)|8(3|4|5|1|2)|88)\d{7}$/';
        $vmsPattern = '/^((\+|)84|0|)(9(0|3)|7(0|7|9|6|8)|89)\d{7}$/';
        $viettelPattern = '/^((\+|)84|0|)(9(6|7|8)|3(8|9|6|7|3|4|5|2)|8(6|8))\d{7}$/';
        $sfone = '/^((\+|)84|0|)(95|155)\d{7}$/';
        $vnm = '/^((\+|)84|0|)(92|56|58)\d{7}$/';
        $beeline = '/^((\+|)84|0|)((9|5)9)\d{7}$/';
        $regs = array(
            'GPC' => $gpcPattern,
            'VMS' => $vmsPattern,
            'VTL' => $viettelPattern,
            'SFONE' => $sfone,
            'VNM' => $vnm,
            'BEELINE' => $beeline);
        return $regs;
    }

}