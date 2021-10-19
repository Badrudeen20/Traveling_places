<?php include('top.php') ?>
  <?php
   if(isset($_GET['place']) && $_GET['place']){
     $place = $_GET['place'];
     $res = mysqli_query($conn,"select * from contents where title='$place'");
     $row = mysqli_fetch_assoc($res);
   }
  ?>

<header class="banner">
    <div class="wrapper">
      <div class="ratio ratio-4x3" >
        <img src="./images/place/<?php echo $row['image'] ?>"/>
      </div>
    </div>
</header>
   
<main>      
<section class="detail-section">
  <div class="detail">
        <h3><?php echo $place ?></h3>
        <p><?php echo $row['detail'] ?></p>
        <br/>
           
    <div class="comments">

        <div class="flex">
            <div class="item">
                <h4>Comments</h4>
            </div>
            <div class="item">
              <button>Subscribe</button>
            </div>
        </div>
        <div class="form">
              <div class="avator">
                <i class="bi bi-person-fill"></i>
              </div>
              <div class="box">
                  <form id="FormIDmain">
                      <textarea placeholder="Leave a comments" name="comment"></textarea>
                      <?php 
                       if($name){
                         echo '<input type="hidden" name="user" value="'.$_SESSION['username'].'" />';
                       }
                      ?>
                      <input type="hidden" name="responseTo" value="0" /> 
                      <input type="hidden" name="place" value="<?php echo $row['id'] ?>" /> 
                      <br/>
                      <button type="button" onclick="submitForm('main')">Send</button>
                  </form>
              </div>
        </div>

    </div>



    <div class="feedback">
          <div class="title">
            <?php 
            $id =  $row['id'];
             $comment = mysqli_query($conn,"SELECT count(responseTo) As no from comments WHERE responseTo = 0 AND content = $id");
             $no = mysqli_fetch_assoc($comment);
            ?>
             <strong id="numberofcomment">Feedback(<?php echo $no['no'] ?>)</strong>
          </div>
              <ul id="comment">
                <?php 
                   $content = $row['id'];
                   $comment = "select * from comments where content = $content";
                   $res  = mysqli_query($conn,$comment);
                   while($row = mysqli_fetch_assoc($res)){
                     
                    $time_input = strtotime($row['added_on']); 
                    $dateArr =  date('d/M/Y h:i:s', $time_input);   
                    $post = explode('/',$dateArr);

                    if($row['responseTo'] < 1){ ?>
                       <li class="parentNode">
                          <div class="avator">
                            <i class="bi bi-person-fill"></i>
                          </div>
                          <div class="msg">
                            <h6><?php echo $row['name'] ?></h6>
                            <p><?php echo $row['message'] ?></p>
                            <div class="btn">
                              <div class="date"><?php echo $post[0]." ".$post[1] ?></div>
                              <button onclick="formToggle(<?php echo $row['id'] ?>)">reply</button>
                            </div>
                            <?php  replyTo($conn,$content,$row['id'],$name) ?>
                            <form  id="FormID<?php echo $row['id']?>">
                                <textarea placeholder="Leave a comments" name="comment"></textarea>
                                <?php 
                                  if($name){
                                    echo '<input type="hidden" name="user" value="'.$name.'" />';
                                  }
                                ?>
                                <input type="hidden" name="responseTo" value="<?php echo $row['id'] ?>" /> 
                                <input type="hidden" name="place" value="<?php echo $content ?>" /> 
                                <br/>
                                <button type="button"  onclick="submitForm('<?php echo $row['id']?>')">Send</button>
                            </form>
                          </div>
                      
                    </li>
                 <?php 
                   }
                 } 
                ?>
              </ul>
      </div>
  </div>

  <div class="sidebar">
    <h3>Recent Post</h3>
    <?php
     $res = mysqli_query($conn,"select * from contents order by id DESC LIMIT 3");
     while($row = mysqli_fetch_assoc($res)){
      $time_input = strtotime($row['date']); 
      $dateArr =  date('d/M/Y', $time_input);   
      $post = explode('/',$dateArr);
       echo '
       <div class="recent">
            <div class="img" style="cursor:pointer;">
              <a href="detail.php?place='.$row['title'].'"><img src="./images/place/'.$row['image'].'" /></a>
            </div>
            <div class="rec-detail">
                <h5>'.$row['title'].'</h5>
                <p>Posted at '.$post[0]." ".$post[1]." ".$post[2].'</p>
            </div>
       </div>';
     }

    ?>
    
  </div>

</section>
</main>
        <?php
           function replyTo($conn,$id,$user,$name){ 
            $sql = "select * from comments where content = $id";
            $res  = mysqli_query($conn,$sql);
              echo '<ul>';
               while($rep = mysqli_fetch_assoc($res)){
                 
                $time_input = strtotime($rep['added_on']); 
                $dateArr =  date('d/M/Y h:i:s', $time_input);   
                $post = explode('/',$dateArr);
                 
                if($rep['responseTo']==$user){
                  echo '<li>
                    <div class="avator">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="msg">
                      <h6>'.$rep['name'].'</h6>
                      <p>'.$rep['message'].'</p>
                      <div class="btn">
                        <div class="date">'.$post[0]." ".$post[1].'</div>
                        <button onclick="formToggle('.$rep['id'].')">reply</button>
                      </div>
                   ';
                  replyTo($conn,$id,$rep['id'],$name);
                  echo '
                  <form  id="FormID'.$rep['id'].'">
                          <textarea placeholder="Leave a comments" name="comment"></textarea>
                          <input type="hidden" name="user" value="'.$name.'" /> 
                          <input type="hidden" name="responseTo" value="'.$rep['id'].'" /> 
                          <input type="hidden" name="place" value="'.$id.'" /> 
                          <br/>
                          <button type="button" onclick="submitForm('.$rep['id'].')">Send</button>
                      </form>
                    </div>
                  
                  </li>';
                }
              } 
              echo '</ul>';
           }
      
        ?>

      <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
function submitForm(id){
        var form = $(`#FormID${id}`)[0]
        var mes =  form.querySelector('textarea').value
        var user  = form.querySelector('[name="user"]').value
        var resTo  = form.querySelector('[name="responseTo"]').value
        var place  = form.querySelector('[name="place"]').value
        if(!user){
          alert('Please sign up')
          return
        }
        $.ajax({
            type: 'post',
            url: 'comment.php',
            data: {comment:mes,user:user,resTo:resTo,place:place},
            success: function (data) {
              form.querySelector('textarea').value = ''
              $('#comment').html(data)
              let count = []
              $('.parentNode').each(function(ind){
                 count.push(ind)
              })
             $('#numberofcomment').text(`Feedback(${count.length})`)
            } 
        });
      
  }



  function formToggle(index) {      
    const form =   $(`#FormID${index}`)[0]
    form.classList.toggle('active')
  } 

  function hamburger(){
    $('.link_list').toggleClass('active')
  }
   
</script>
<?php include('bottom.php') ?>



</body>
</html>
