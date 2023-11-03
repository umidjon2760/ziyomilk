<?php
function debug($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";die;
}

function numberFormat($number,$length){
    return number_format($number, $length, ',', ' ');
}
?>