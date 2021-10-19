<?php include('top.php') ?>
<?php 
  $msg = "";
  if(isset($_SESSION['username'])){
    header('location:index.php');
  }
  if(isset($_POST['submit'])){
      $name = $_POST['username'];
      $password = $_POST['password'];
      $sql =  "select * from subscriber where username='$name' and password='$password'";
    
      $result =  mysqli_query($conn,$sql);
      if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header('location:index.php');
      }else{
          $msg = "Please enter correct password";
      }
     
   
  }
?>
<section class="sign">
            <div class="grid">
                <div class="item">
                    <img src="./images/login/travel.jpg" />
                </div>
                <div class="item">
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <label>username</label>
                            <input class="form-control" name="username" type="text" placeholder="username" />
                        </div>
                        
                        <div class="form-group">
                            <label>password</label>
                            <input class="form-control" name="password" type="password" placeholder="password" />
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <p class="text-center mt-4"><strong><?php echo $msg ?></strong></p>
                        <div class="form-group border"> 
                          <a href="register.php"  class="btn btn-primary w-100">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
<?php include('bottom.php') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function hamburger(){
      $('.link_list').toggleClass('active')
    }
</script>
