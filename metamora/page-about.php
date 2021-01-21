<?php
/*
Template Name: About Us
*/
?>


<?php get_header(); ?>

<!-- SITE HEADERS -->


<div class="container metamora-msb"> </div>


<!-- SITE HEADERS -->

 <div class="container-fluid" style="background-color:#092768;height:49px;"></div> 
<div class="container-fluid main-bkg">
  
 <div class="container">   
    <div class="container container-metamora ">
             <div class="container metamora-page col-lg-12">
    <!-- Nav tabs -->
    <?php
            wp_nav_menu( array(
                'menu'              => 'About-menu',
                'theme_location'    => 'About-menu',
                'depth'             => 2,
                'container'         => '',
                'container_class'   => '',
                'menu_class'        => 'nav nav-tabs',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			  
        ?>
    

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane tab-text metamora-tabpane active" id="aboutus">
  <div class="col-md-8 page" id="post-<?php the_ID(); ?>">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
  <?php the_content(); ?>
  <?php endwhile; endif; ?>

   </div>
   
   </div>

</div><!--END TABS-->

<div class="col-md-3">   

<p><a class="btn btn-lg btn-primary metamora-button" href="metamora-account.html" role="button">Open An Account</a></p>

<p>Metamora Banking Center<br/>
120 East Main Street, P.O. Box F<br/>
Metamora, OH 43540<br/>
Phone: (419) 644-2361 <br/>
Fax: (419) 644-5774</p>

<p>Sylvania Banking Center<br/>
8282 Erie Street<br/>
Sylvania, OH 43560<br/>
Phone: (419) 885-1996<br/>
Fax: (419) 885-5151</p>
<p>Hours</p>
<p>Drive-Up:</p>
<p>8:30 am - 4:30 pm (M-TH)<br/>
8:30 am - 5:00 pm (Fri)<br/>
8:30 am - 12:00 pm (Sat)</p>

<p>Lobby:</p>
<p>
9:00 am - 4:00 pm (M-TH)<br/>
9:00 am - 5:00 pm (Fri)<br/>
9:00 am - 12:00 pm (Sat)</p>

  </div>
    </div> 
  
    
    </div> <!-- END MAIN TABS -->
     </div><!-- END BLUE TABS BKG -->
</div>
    <!-- /.container -->

<?php get_footer(); ?>