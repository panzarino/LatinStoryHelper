<?php

if (isset($_GET['story'])){
    require_once('home.php');
}
else {
    require_once('home.html');
}

?>