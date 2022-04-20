<?php 

if(!($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'reception') ){
    
    header('Location:'.url(''));
 
}

?>