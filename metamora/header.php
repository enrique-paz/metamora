<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=.9">
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico">
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-theme.min.css">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>
</head>

 <body> 
<div <?php post_class(); ?> >

<?php if (is_front_page()) {?>

<?php query_posts( 'p=86' );
while (have_posts()) : the_post();
	the_excerpt( 'Read the full post »' );
endwhile; 
?>

<?php } ?>
</div>

    <div class="navbar navbar-default nav-metamora" role="navigation">
    
      <div class="container">
     
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        
         <?php
            wp_nav_menu( array(
                'menu'              => 'Top-nav',
                'theme_location'    => 'Primary-menu',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'menu_class'        => 'nav navbar-nav top-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			  
        ?>
        
        
        
        <!--/.nav-collapse -->
      </div>
    </div>

<div class="container-metamora">
 <!-- Metamora State Bank BRAND -->
    <div class="container logo-block">
    <div class="metamora-brand">
   <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/metamora-bank-logo.gif" width="282" height="66" alt="Metamora State Bank"  class="img-responsive"></a>
    <img src="<?php bloginfo('template_url'); ?>/images/metamora-tagline.gif" width="281" height="44" alt="Your Good Neighbor Bank" class="img-responsive">
    
    
    <?php
            wp_nav_menu( array(
                'menu'              => 'Main-menu',
                'theme_location'    => 'Secondary-menu',
                'depth'             => 2,
                'container'         => '',
                'container_class'   => '',
                'menu_class'        => 'nav logo-block-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			  
        ?>
    
 
    
    </div>
    </div>
    </div>