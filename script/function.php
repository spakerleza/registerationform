<?php

function clean_input($data) {
    $datakey   = [];
    $datavalue = [];

    foreach($data as $key => $value) {
        $value = trim($value);
        $value = htmlentities($value);
        $value = strip_tags($value);
        $value = stripslashes($value);

        array_push($datakey, $key);
        array_push($datavalue, $value);        
    }
    
    $data = array_combine($datakey, $datavalue);
    return $data;
}



?>