<?php 

if(($_SESSION['user']['role'] != 'member' ) && ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'reception')){
    
    header('Location:'.url(''));

}elseif ($_SESSION['user']['role'] != 'member' && $_SESSION['user']['role'] == 'coach'){
    header('Location:'.url('Coach_Show'));
}

?>