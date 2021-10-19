<?php 
include('connection.php');
session_start();
$name = null;
if(isset($_SESSION['username'])){
  $name = $_SESSION['username'];
}
$search = '';
if(isset($_POST['submit'])){
   $search = $_POST['search'];
}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link rel="stylesheet" href="./css/style.css" />
<link rel="stylesheet" href="./login/style.css" />
</head>
<body>
    <nav>
      <div class="flex-container">
        <div class="logo">Travel</div>
        <ul class="link_list">
          <li>
            <a href="index.php">Home</a>
          </li>
          <li>
           <a href="index.php">About</a>
         </li>
         <li>
           <a href="index.php">Contact</a>
         </li>
        </ul>
      </div>
      <div class="login">
        <form class="search" action="index.php" method="post">
          <input type="text" placeholder="search" name="search">
          <button type="submit" name="submit"><i class="bi bi-search"></i></button>
        </form>
        <?php 
         if($name){
          echo '<a href="logout.php">Sign out</a>';
         }else{
          echo '<a href="login.php">Sign in</a>';
         }
        ?>
        <button onclick="hamburger()" class="burger"><i class="bi bi-list"></i></button>
      </div>
      
       
    </nav>
