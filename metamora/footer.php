		
 <div style="background-color:#C7c7c7">   
    <div class="metamora-footer">
    <footer class="container-metamora">
    <div class="col-sm-12 alert alert-info idtheft">
    <p><h5>Identity Theft Protection </h5>

The Metamora State Bank understands the seriousness of being a victim of Identity theft. That is why the bank is providing your household, free of charge, Identity Theft Protection. Please click on the following link to get more information.</p>
<p><a href="https://w2-msp.assurant.com/as/idfsredflagcompliance/welcome.jsp?accountId=CBA" onClick="webmsg()">www.mybankredflag.com</a>  </p>
    </div>
    <div class="col-sm-2 ">  <h4>24-Hour ATM & <br>Internet Banking</h4><img src="<?php bloginfo('template_url'); ?>/images/telebanc.png"  width="160" height="198" alt="Telebanc" class="img-responsive">
    </div>
    <div class="col-sm-2">
    <p>Metamora Banking Center<br/>
120 East Main Street,<br/> P.O. Box F<br/>
Metamora, OH 43540<br/>
Phone: (419) 644-2361 <br/>
Fax: (419) 644-5774</p>
</div>
    <div class="col-sm-2">
  <p>  Sylvania Banking Center<br/>
8282 Erie Street<br/>
Sylvania, OH 43560<br/>
Phone: (419) 885-1996<br/>
Fax: (419) 885-5151
</p>
    </div>
    
    <?php
            wp_nav_menu( array(
                'menu'              => 'Footer-menu',
                'theme_location'    => 'Footer Menu',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'col-sm-2',
                'menu_class'        => '',
				'items_wrap'      => '<ul><li id="item-id">LINKS </li>%3$s</ul>',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			  
        ?>
    
    
    <div class="col-sm-2">
    <img src="<?php bloginfo('template_url'); ?>/images/go-local.png" width="144" height="67" alt="Go Local">
    </div>
    <div class="col-sm-2"> 
    <a href="http://www.fdic.gov/deposit/" target="_blank" onClick="webmsg()"><img src="<?php bloginfo('template_url'); ?>/images/fdic.png" width="68" height="67" alt="FDIC"></a>
    <img src="<?php bloginfo('template_url'); ?>/images/equal-housing-lenders.png" width="48" height="67" alt="Equal Housing Lenders">
    </div>
    
    </footer>
<div class="container-metamora" style="clear:both">
<div style="padding-left:25px;padding-top:25px">

    <?php
            wp_nav_menu( array(
                'menu'              => 'Legal-menu',
                'theme_location'    => 'Legal-menu',
                'depth'             => 2,
                'container'         => '',
                'container_class'   => '',
                'menu_class'        => '',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			  
        ?>
        
    <p>&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?>. All Rights Reserved.</p>
    </div>
    </div>
  </div>
	<?php wp_footer(); ?>    
    
</div>

	
	<!-- Don't forget analytics -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/banners.js"></script>
	
</body>

</html>
