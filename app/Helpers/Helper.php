<?php

namespace App\Helpers;


class Helper {

    public static function formatDate($date){
        return date('d/m/Y', strtotime($date));
    }

}
