<?php 
require('connection.php');

$limit = 5;
$page = 1;
if(isset($_POST['page']) && $_POST['page'] > 1){
     $start = ($_POST['page'] - 1) * $limit;
     $page = $_POST['page'];
}else{
  $start = 0;
}

$query = "select * from contents";

if(isset($_POST['query']) && $_POST['query'] !=''){
    $category = $_POST['query'];
    $query .= " where category = $category";
}

if(isset($_POST['search']) && $_POST['search'] !=''){
    $search = $_POST['search'];
    $query .= " where title OR place LIKE '%$search%'";
}
$filter_query = $query . ' limit '.$start.', '.$limit.'';

$statement = mysqli_query($conn,$filter_query);
$total_data = mysqli_num_rows(mysqli_query($conn,$query));
$output = '<div class="row">';
while($row = mysqli_fetch_assoc($statement)){
   $str = $row['detail'];
     
   $time_input = strtotime($row['date']); 
   $dateArr =  date('d/M/Y h:i:s', $time_input);   
   $post = explode('/',$dateArr);
     
   $short =  str_word_count($str, 1, '0..3');
   $slice_arr = array_slice($short, 0, 30);
   $detail  = implode(" ",$slice_arr);
   $output .= '
   <div class="col-lg-6">
   <div class="card mb-3">
       <a href="detail.php?place='.$row['title'].'"><img src="./images/place/'.$row['image'].'" class="card-img-top" alt="..."></a>
       <div class="card-body">
         <h5 class="card-title">'.$row['title'].'</h5>
         <p class="card-text">'.$detail.'...</p>
         <p class="card-text"><small class="text-muted">Posted '.$post[0]." ".$post[1].'</small></p>
       </div>
   </div>

 </div>
   ';
}

$output .='
<div class="pagination_container">
<div class="pagination">';
$total_link = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_link > 4){
     if($page < 5){
        for($count = 1; $count<5;$count++){
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_link;
     }else{
            $end_limit = $total_link - 3;
            if($page > $end_limit){
               $page_array[] = 1;
               $page_array[] = '...';
               for($count=$end_limit;$count<=$total_link;$count++){
                    $page_array[] = $count;
               }
            }else{
                $page_array = 1;
                $page_array = '...';
                for($count=$page-1;$count<=$page+1;$count++){
                    $page_array[] = $count;
               }
               $page_array = '...';
               $page_array = $total_link;
            }


     }


}else if($total_link > 0){
    for($count = 1; $count<= $total_link;$count++){
         $page_array[] = $count;
    }
}else{
    echo "No Data";
}

if($total_link > 0){
    for($count = 0;$count< count($page_array); $count++){
        if($page == $page_array[$count]){
               $page_link .='<a href="javascript:void(0)" class="active" data-page_no="'.$page_array[$count].'">'.$page_array[$count].'</a>';
               $previous_id = $page_array[$count] - 1;
               if($previous_id > 0){
                   $previous_link = '<a href="javascript:void(0)" data-page_no="'.$previous_id.'" >Prev</a>';
               }else{
                   $previous_link = '<a href="javascript:void(0)" disabled style="pointer-events:none;">Prev</a>';
               }
               $next_id = $page_array[$count] + 1;
               if($next_id == $total_link+1){
                   $next_link = '<a href="javascript:void(0)" disabled style="pointer-events:none;">Next</a>';
               }else{
                   $next_link = '<a href="javascript:void(0)" data-page_no="'.$next_id.'">Next</a>';
               }
           
        }else{
          if($page_array[$count] == '...'){
               $page_link .='<a href="javascript:void(0)" disabled style="pointer-events:none;">...</a>';
          }else{
               $page_link .='<a href="javascript:void(0)" data-page_no="'.$page_array[$count].'">'.$page_array[$count].'</a>';
          }
        }
   }
   
   $output .=$previous_link . $page_link . $next_link;
   $output .='
   </div>
   </div>
   </div>';
   echo $output;
}

?>
