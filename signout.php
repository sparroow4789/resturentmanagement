<?php

  session_start();
  
  if(isset($_SESSION['Logged'])){
      unset($_SESSION['Logged']);
  }
  
  if(isset($_SESSION['email'])){
      unset($_SESSION['email']);
  }
  
  if(isset($_SESSION['password'])){
      unset($_SESSION['password']);
  }
  
  
   if(isset($_COOKIE['zxadfggh'])){
      setcookie("zxadfggh",$email, time() - 3600, "/");
  }
  
  if(isset($_COOKIE['jyuongga'])){
      setcookie("jyuongga",$email, time() - 3600, "/");
  }
  


  header("Location:login");


?>