<?php 

##############################################################
////////////// Function To Clean Input
function cleanData($input){
    return trim(strip_tags(stripslashes($input)));
}
?>