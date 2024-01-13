<?php
    $_URL = "http://127.0.0.1:8000";
    if(strpos($_SERVER["REQUEST_URI"], "___ROOT/")){
        if(isset($_SESSION[""])){
            header("Location: dashboard.php");
        } else{
            header("Location: $_URL");
        }
    } else{
        $_DC = new mysqli("localhost","root","","campusministry");
    }
?>