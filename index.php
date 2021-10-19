<?php include('top.php');
?>
<!--header-->
<header class="banner">
    <div class="wrapper">
        <div class="ratio ratio-4x3" >
        <img src="https://gizmodiva.com/wp-content/uploads/2017/10/SCOTT-A-WOODWARD_1SW1943.jpg"/>
        </div>
        
    </div>
    <div class="heading">
        <h4>Tours & Travels</h4>
        <h3>Amazing Places in india</h3>
        <h5>December 12, 2021</h5>
    </div>
</header>

<!--Category-->
<section>
    <div class="content">
        <div class="category">
            <ul>
            <li class="btn border filter">
              <a href="index.php" style="text-decoration:none; color:#000;">All</a>
            </li>
            <?php 
            $res = mysqli_query($conn,"select * from categories");
            while($row = mysqli_fetch_assoc($res)){
                echo '<li class="btn border filter" data-category_id="'.$row['id'].'">'.$row['category'].'</li>';
            }
            ?>
            </ul>
        </div> 
        <div id="data"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    var selected = null
    //data load
     function load_data(page,query,search){
        $.ajax({
          url:'pagination.php',
          method:'POST',
          data:{page:page,query:query,search:search},
          success:function(data){ $('#data').html(data) }
        })
     }
     load_data(1,'','<?php echo $search ?>')

    //category
    $(document).on('click','.filter',function(){
      $('.filter').each(function(ind,ele){
        if(ele.classList.contains('active')){
           ele.classList.remove('active')
        }
      })
      $(this)[0].classList.add('active')
       var category = $(this).data('category_id')
           selected = category
           load_data(1,selected)
    })
    
    //pagination
    $(document).on('click','.pagination a',function(){
       var page = $(this).data('page_no')
       if(selected){
        load_data(page,selected)
       }else{ 
        load_data(page,'',<?php echo  $search ?>)
       }
       
    })
  })

  function hamburger(){
    $('.link_list').toggleClass('active')
  }
</script>



<?php include('bottom.php') ?>
