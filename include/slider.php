 <div class="container">
    <div class="grid_12">
      <div style="overflow: hidden; height: 480px; margin-top:0px;" class="oneByOne1">
       
        <div style="left: 0px;" id="banner">
        <!--<div style="left: 0px; height: 480px; display: block;" class="oneByOne_item"> <img style="display: block;" src="images/x-mas.png" alt="" class="slide animate0 bounceIn" data-animate="bounceIn">
            
            <p style="display: block;line-height: 30px; font-size:19px" class="excerpt animate2 rotateInDownLeft"></p>
            
          
            
          </div>-->
          <?php
          $sql=mysql_query("select * from tbl_banner WHERE 1=1 AND show_on_home=1 order by id desc");
          while($get_data=mysql_fetch_assoc($sql))
          {
          ?>
          <div style="left: 0px; height: 480px; display: block;" class="oneByOne_item"> 
          <img style="display: block;" src="<?php echo SITE_URL; ?>upload_images/banner/<?php echo $get_data['photo']; ?>" alt="" class="slide animate0 bounceIn" data-animate="bounceIn">
            <h2 style="display: block;font-size:34px; line-height:40px" class="animate1 rotateInDownLeft"><?php echo $get_data['title']; ?></h2>
            <p style="display: block;line-height: 30px; font-size:19px" class="excerpt animate2 rotateInDownLeft"><?php echo $get_data['description']; ?></p>
 
           <div style="display: block;" class="btn-holder animate3 rotateInDownLeft"> <a href="Online-Voice-to-Your-Business.html" class="btn large"> <span class="btn-inner">More Info<em>click here</em><i class="marker"></i></span> </a> </div>
          </div>
          <?php
          }
          ?>
       
         
         
        </div>


        <div style="cursor: pointer; display: block; opacity: 0.984375;" class="arrowButton">
          <div style="top: 200px;" class="prevArrow"></div>
          <div style="top: 200px;" class="nextArrow"></div>
        </div>
      </div>
    </div>