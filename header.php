<!DOCTYPE html>

<html lang="en">

  <head>
		<title>
			<?php
			// Print the <title> tag based on what is being viewed
			global $page, $paged;
			wp_title( '|', true, 'right' );
			// Add the blog name.
			bloginfo( 'name' );
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
			?>
		</title>

		<meta name="description" content="Stichting AKBHHH is in 2006 opgericht vanuit het idee in bescheidenheid bij te dragen aan het grotere geheel. Vandaar de naam 'Alle Kleine Beetjes Helpen'." />
		<meta name="keywords" content="" />
		<meta name="author" content="L Daniel Swakman, www.ldaniel.eu" />
		<meta charset="utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<?php
		// checks if not on localhost, then serves assets from CDN
		$local = strpos($_SERVER['SERVER_NAME'], 'localhost');
		if($local === false) : ?>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic" />
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic" />
		<link rel="stylesheet" href="//weloveiconfonts.com/api/?family=entypo" />
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.2/fastclick.min.js"></script>
		<?php
		// if localhost then load local assets
		else : ?>
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/fonts/entypo.css" />
		<script src="<?php bloginfo( 'template_directory' ); ?>/js/jquery.min.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/js/fastclick.min.js"></script>
		<?php endif; ?>

		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<script src="<?php bloginfo( 'template_directory' ); ?>/js/jquery.anchor.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/js/scripts.js"></script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-9833982-22', 'auto');
		  ga('send', 'pageview');

		</script>

    </head>

    <body <?php body_class(); ?>>

    <div id="top" class="wrapper">

			<header>
				<div class="row container-fluid">
					<div class="col-sm-7 logo-title-container">
						<a href="<?php echo home_url('/'); ?>" id="logo"></a>
						<div class="header-title">
							<h1><span class="project-title">project</span><?php the_title(); ?></h1>
						</div>
					</div>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'header-menu',
						'menu_id' => 'menu',
						'container' => false
						)
					);
					?>
				</div>
      </header>
