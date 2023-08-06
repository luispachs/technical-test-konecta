<?php

namespace App\Handlers;

class Utils
{
public static function generatedReference(){
    $text ='1234567890';
    $reference ='';
    for($i =1;$i<=4;$i++){
        $chain = str_shuffle($text);
        if($i!=4){
            $reference.= substr($chain,0,4).'-';
        }
        else{
            $reference.= substr($chain,0,4);
        }

    }
    return $reference;
}
}
