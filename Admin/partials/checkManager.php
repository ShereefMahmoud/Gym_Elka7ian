<?php

if($_SESSION['user']['role'] != 'manager'){
        
    header('Location:'.url(''));
}

?>