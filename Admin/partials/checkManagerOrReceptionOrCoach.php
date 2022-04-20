<?php 

if(!($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'reception' || $_SESSION['user']['role'] == 'coach' )){
    
    header('Location:'.url(''));

}

?>