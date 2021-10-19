<?php include('top.php') ?>
<?php 
  $msg = "";
  if(isset($_POST['submit'])){
      $name = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $sql =  "select * from subscriber where username='$name' or email='$email'";
   
      $result =  mysqli_query($conn,$sql);
      if(mysqli_num_rows($result) > 0){
       $msg = "Email is already registered";
      }else{
         mysqli_query($conn,"insert into subscriber (username,email,password) values('$name','$email','$password')");
         header('location:login.php');
      }
     
   
  }
?>
<section class="sign">
            <div class="grid">
                <div class="item">
                    <img src="./images/login/travel.jpg" />
                </div>
                <div class="item">
                    <form method="post" action="register.php">
                        <div class="form-group">
                            <label>username</label>
                            <input class="form-control" name="username" type="text" placeholder="username" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" type="email" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <label>password</label>
                            <input class="form-control" name="password" type="password" placeholder="password" />
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <p class="text-center mt-4"><strong><?php echo $msg ?></strong></p>
                        <div class="form-group border"> 
                          <a href="login.php"  class="btn btn-primary w-100">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
<?php include('bottom.php') ?>
