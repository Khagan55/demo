<?php

//$db = mysqli_connect("localhost", "khagan", "password","online_shop");
 //$db = mysqli_connect("productshop.zzz.com.ua", "khagan", "0504246353Xaqan","khagan");
 $db = mysqli_connect("localhost", "khagan", "0504246353Xaqan","khagan");
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>