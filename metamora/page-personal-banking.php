<?php
/*
Template Name: Personal Banking
*/
?>


<?php get_header(); ?>

<!-- SITE HEADERS -->


<div class="container metamora-banners"> </div>



<!-- SITE HEADERS -->

 <div class="container-fluid" style="background-color:#092768;height:49px;"></div> 
<div class="container-fluid main-bkg">
  
 <div class="container">   
    <div class="container container-metamora ">
             <div class="container metamora-page col-lg-12">
    <!-- Nav tabs -->
    <?php
            wp_nav_menu( array(
                'menu'              => 'Banking-menu',
                'theme_location'    => 'Banking-menu',
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
  <div class="col-md-8 page">
  
  <ul  class="nav nav-pills">
  <li class="active"><a href="#checking" data-toggle="tab">Checking</a></li>
  <li><a href="#savings" data-toggle="tab">Savings</a></li>
  <li><a href="#cds" data-toggle="tab">CDs/IRAs</a></li>
   <li><a href="#rates" data-toggle="tab">Rates</a></li>
   <li><a href="#loans" data-toggle="tab">Loans</a></li>
    <li><a href="#services" data-toggle="tab">Other Services</a></li>
</ul>
<div  class="tab-content">
<div class="tab-pane tab-text metamora-tabpane active" id="checking">
<p>Checking</p>
  </div><!--END CHECKING TAB-->
 <div class="tab-pane tab-text metamora-tabpane" id="savings">
<p>Savings</p>
  </div> <!-- END PERSONAL SAVINGS TAB-->
  
 <div class="tab-pane tab-text metamora-tabpane" id="cds">
<p>CDS</p>
  </div> <!-- END CD RATES TAB -->
<div class="tab-pane tab-text metamora-tabpane" id="rates">
<p>Rates</p>
  </div>    <!-- END RATES-->

<div class="tab-pane tab-text metamora-tabpane" id="loans">
<p>Loans</p>
  </div><!-- END LOANS-->
  
 <div class="tab-pane tab-text metamora-tabpane" id="services">
<p>Services</p>
  </div> <!--END SERVICES TAB -->
</div><!--END PERSONAL SUB TABS-->
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