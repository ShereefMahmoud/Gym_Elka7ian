<?php 

if(($_SESSION['user']['role'] != 'coach' ) && ($_SESSION['user']['role'] == 'manager' || $_SESSION['user']['role'] == 'reception')){
    
    header('Location:'.url(''));

}elseif ($_SESSION['user']['role'] != 'coach' && $_SESSION['user']['role'] == 'member'){
    header('Location:'.url('Member_Show'));
}

?>