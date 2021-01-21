<?php get_header(); ?>

	
<div class="metamora-login">
	<h3>Online Banking</h3>
		<div class="input-group input-group-sm metamora-input">
  			<input type="text" class="form-control" placeholder="Access ID" size="50" >
		</div>
 			<p><a class="btn btn-lg btn-primary metamora-btn metamora-button" href="#" role="button">Log-in</a></p>
 					<a href="#" class="atext">forgot password?</a>
 						<a href="#" class="atext">first time user</a>
    </div>
    
</div>
            <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
      
      <?php 
   			$the_query = new WP_Query(array(
    			'category_name' => 'main-slider', 
    				'posts_per_page' => 1 
    			)); 
   			while ( $the_query->have_posts() ) : 
   		$the_query->the_post();
  	 ?>
     
      <div class="item slider active">
           <?php the_post_thumbnail('singlepost-thumb');?>
          		<div class="container">
            		<div class="carousel-caption caption-text">
              			<h1><?php the_title();?></h1>
							<p><a class="btn btn-lg btn-primary metamora-button" href="metamora-business-loans.html" role="button">See details</a></p>
            		</div>
          		</div>
        </div><!-- item active -->
        
  <?php endwhile; wp_reset_postdata();?>
  
  <?php 
 		$the_query = new WP_Query(array(
  			'category_name' => 'main-slider', 
  				'posts_per_page' => 5, 
  					'offset' => 1 
  					)); 
 			while ( $the_query->have_posts() ) : 
 		$the_query->the_post();
	?>

<div class="item slider">
       <?php the_post_thumbnail('singlepost-thumb');?>
          <div class="container">
            <div class="carousel-caption caption-text">
              <h1><?php the_title();?></h1>
              <p><a class="btn btn-lg btn-primary metamora-button" href="metamora-banking-loans.html" role="button">See details</a></p>
            </div>
          </div>
        </div>
           
  <?php endwhile; wp_reset_postdata();?>        
</div>
     
      <a class="left carousel-control slider-btn" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control slider-btn" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
  
 <div class="container tab-container">   <!-- BLUE TABS BKG -->
    <div class="container container-metamora ">
             <div class="container metamora-tabs col-lg-9">
    <!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" >
  <li><a href="#personal" data-toggle="tab">Personal Banking</a></li>
  <li><a href="#business" data-toggle="tab">Business Accounts</a></li>
  <li><a href="#cards" data-toggle="tab">Card Services</a></li>
  <li><a href="#insurance" data-toggle="tab">Insurance</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content ">
	<div class="tab-pane tab-text metamora-tabpane active" id="main">
		<div class="col-sm-3">
			<img src="images/family.jpg" width="177" height="234" alt="70 Years" class="mobile">
			</div>

		<div class="col-sm-7">
			 <?php query_posts( 'p=82' );
while (have_posts()) : the_post();
	the_content( '' );
endwhile; 
?>
	</div>
</div>
<!-- PERSONAL TAB-->
<div class="tab-pane tab-text metamora-tabpane" id="personal">
   <img src="images/mother-child.jpg" width="178" height="234" alt="Personal Banking" align="left" class="mobile"> 
  		<div class="col-sm-6"> 
<?php query_posts( 'p=112' );
while (have_posts()) : the_post();
	the_content( '' );
endwhile; 
?> 
  			</div>
  		<div class="col-sm-3 rule">
			POST
	</div>
</div>
<!-- BUSINESS TAB -->
<div class="tab-pane tab-text metamora-tabpane" id="business">
   <img src="images/business.jpg" width="177" height="234" alt="Business" align="left" class="mobile">
   		<div class="col-sm-6">
 			POST
   			</div>
   		<div class="col-sm-3 rule">
 			POST
 	</div>
</div>
<!-- CARDS TAB-->   
<div class="tab-pane tab-text metamora-tabpane" id="cards">
   <img src="images/cards.jpg" width="177" height="234" alt="Card Services" align="left" class="mobile"> 
   		<div class="col-sm-6">
			POST
			</div>
 		<div class="col-sm-3 rule">
 			POST
  	</div>
</div>
<!--INSURANCE TAB-->
<div class="tab-pane tab-text metamora-tabpane" id="insurance">
	<!--img src="images/insurance.png" width="370" height="139" alt="Insurance" class="img-responsive" style="display:block;float:left"-->
 		<div class="col-sm-4">
			POST
  		</div>
  	</div>
</div>

 </div> <!--END COL-LG-9-->

<div class="message-board col-md-3" style="height:340px">
    <h3>Message Board</h3>
   			<?php query_posts( 'p=90' );
while (have_posts()) : the_post();
	the_excerpt( 'Read the full post »' );
endwhile; 
?>
    		<p style="text-align:center"><a class="btn btn-lg btn-primary metamora-button property-btn" href="metamora-property.html" role="button">For Sale<br/> Bank-owned<br/> Property</a></p>
    	</div>
   </div> <!-- END TABS -->
</div><!-- END BLUE TABS BKG -->

    <!-- /.container -->
    
    
    
    
    
    
    
    


<?php get_footer(); ?>