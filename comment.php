<?php
include('connection.php');

if(isset($_POST["comment"]) && isset($_POST["user"])) {
$comment= $_POST['comment'];
$user=$_POST['user'];
$responseTo = $_POST['resTo'];
$place = $_POST['place'];
$date = date("Y-m-d H:i:s");  
$insert = "insert into comments (responseTo,name,message,content,added_on)
values('$responseTo','$user','$comment','$place','$date')";
mysqli_query($conn,$insert);
$comment = "select * from comments where content = $place";
$res  = mysqli_query($conn,$comment);
$output = '';
while($row = mysqli_fetch_assoc($res)){
    
  $time_input = strtotime($row['added_on']); 
  $dateArr =  date('d/M/Y h:i:s', $time_input);   
  $post = explode('/',$dateArr);
    
    if($row['responseTo'] < 1){ 
        echo '
                <li class="parentNode">
                    <div class="avator">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="msg">
                        <h6>'.$row['name'].'</h6>
                        <p>'.$row['message'].'</p>
                        <div class="btn">
                        <div class="date">'.$post[0]." ".$post[1].'</div>
                        <button onclick="formToggle('.$row['id'].')">reply</button>
                        </div>';
                    replyTo($conn,$place,$row['id'],$user);
         echo '<form  id="FormID'.$row['id'].'">
                          <textarea placeholder="Leave a comments" name="comment"></textarea>
                          <input type="hidden" name="user" value="'.$user.'" /> 
                          <input type="hidden" name="responseTo" value="'.$row['id'].'" /> 
                          <input type="hidden" name="place" value="'.$place.'" /> 
                          <br/>
                          <button type="button" onclick="submitForm('.$row['id'].')">Send</button>
                      </form>
                    </div>
                </li>
        ';

      
        
   }
 } 


 
}else{
   echo "please login first";
}


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
            </div>';
            replyTo($conn,$id,$rep['id'],$name);
           echo  '<form id="FormID'.$rep['id'].'">
                <textarea placeholder="Leave a comments" name="comment"></textarea>
                <input type="hidden" name="user" value="'.$name.'" /> 
                <input type="hidden" name="responseTo" value="'.$rep['id'].'" /> 
                <input type="hidden" name="place" value="'.$id.'" /> 
                <br/>
                <button type="button" onclick="submitForm('.$rep["id"].')">Send</button>
            </form>
          </div>
        </li>';
          
        }
       
    }
    echo '</ul>';   
   
}


?>
