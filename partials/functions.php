<?php

################################################################
/////////Clean Date 
function cleanData($input)
{
    return trim(strip_tags(stripslashes($input)));
}

##################################################################
////////////////Validate Data
function validate($input, $flag, $len = 6)
{

    $status = true;

    switch ($flag) {
        case 'require':
            # code...
            if (empty($input)) {
                $status = false;
            }
            break;

        case 'email':
            # code...
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;

        case 'int':
            # code...
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;

        case 'min':
            # code...
            if (strlen($input) < $len) {
                $status = false;
            }
            break;
        }
            return $status;
    
}




function Messages($text)
{
    if (isset($_SESSION['Message'])) {
        foreach ($_SESSION['Message'] as $key => $value) {
            echo ' _ ' . $key . ' : ' . $value . '<br>';
        }

        unset($_SESSION['Message']);
    }else{
        echo '  <li class="breadcrumb-item active">'.$text.'</li>';  
    }
}

?>