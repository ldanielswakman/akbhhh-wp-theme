<?php
/*
 * Template name: Normal Page
 *
 * @package WordPress
 * @subpackage AKBHHH
 */
?>
<?php get_header(); ?>
<?php
// Start the Loop.
while ( have_posts() ) : the_post(); ?>

<div id="content">

	<?php
	// retrieve page sections if existing
	$page_sections_data = simple_fields_fieldgroup("page_section_data", get_the_id());
	?>

	<section id="text">
		<div class="row container-fluid padded-50">
			<div class="col-md-9 col-md-offset-1 col-sm-10 col-sm-offset-1">
				<?php
				if(get_the_content()) :
					the_content();
				elseif(!$page_sections_data) :
					echo "<br /><p><i>Deze pagina bevat geen inhoud.</i></p>";
				endif;
				?>
			</div>
		</div>
	</section>

	<?php
	// content format for 'about' page
	if ($page_sections_data) :
	foreach($page_sections_data as $key => $section) :
	?>
	<section id="about<?php echo $key+1; ?>" class="page-section">
		<div class="row container-fluid">
			<div class="col-md-9 col-md-offset-3 col-sm-10 col-sm-offset-1 line-below">
				<?php
				if($section['illustration']) :
				$image_src = wp_get_attachment_image_src($section['illustration'], 'medium');
				$image_descr = get_post_meta($section['illustration'], '_wp_attachment_image_alt', true);
				?>
				<div class="section-illustration" style="background-image: url('<?php echo $image_src[0]; ?>');"<?php echo ($image_descr) ? 'title="' . $image_descr. '"' : ''; ?>></div>
				<?php endif; ?>
				<hr />
			</div>
		</div>
		<div class="row container-fluid">
			<div class="col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1">
				<h4><?php echo $section['title']; ?></h4>
			</div>
			<div class="col-md-4 col-md-offset-0 col-sm-10 col-sm-offset-1">
				<p class="intro"><?php echo $section['text_intro']; ?></p>
			</div>
			<div class="col-md-5 col-md-offset-0 col-sm-10 col-sm-offset-1">
				<p><?php echo $section['text_body']; ?></p>
			</div>
		</div>
	</section>
	<?php
	endforeach;
	endif;
	?>

	<?php
	// retrieving subpgaes
	$args = array(
		'post_type' => 'page',
		'post_parent' => $post->ID
	);
	$subpage_query = new WP_Query($args);
	if($subpage_query->have_posts()) :
	?>
	<section id="subpages">
		<div class="row container-fluid padded-50">
			<div class="col-md-10 col-md-offset-1">
				<?php
				while ($subpage_query->have_posts()) : $subpage_query->the_post();
				echo '<a href="';
				the_permalink();
				echo '" class="action">';
				echo strtolower(get_the_title());
				echo '</a>';
				endwhile;
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</div><!--/content -->
<?php endwhile; ?>

<?php get_footer(); ?>
