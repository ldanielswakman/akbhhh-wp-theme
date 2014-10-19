<?php
/*
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage AKBHHH
 */
$post->post_title = '';
?>
<?php get_header(); ?>

<div id="content">

	<section id="text">
		<div class="row container-fluid padded-50 align-center">
			<div class="col-md-6 col-md-offset-3">
				<h6>404</h6>
				<p>Je probeerde <em><?php echo $_SERVER['REQUEST_URI']; ?></em> te bereiken. Deze pagina bestaat helaas niet (meer).</p>
			</div>
		</div>
		<div class="row container-fluid align-center">
			<div class="col-md-10 col-md-offset-1">
				<br />
				<a href="<?php echo home_url('/'); ?>" class="action">terug naar home</a>
			</div>
		</div>
	</section>

</div><!--/content -->

<?php get_footer(); ?>
