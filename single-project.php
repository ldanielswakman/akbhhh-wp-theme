<?php
/*
 * Template name: Project Page
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
	// getting project intro data
	$project_hero_data = simple_fields_fieldgroup("project_hero_data", get_the_id());
	if ($project_hero_data['banner_image']) :
		$image_class = 'banner';
		$image_src = wp_get_attachment_image_src($project_hero_data['banner_image'], 'full');
		$image_styles = 'height:' . $project_hero_data['banner_height'] . 'px; background-size: cover;';
	else :
		$image_class = 'no-banner';
		$image_src = array('../../wp-content/themes/akbhhh/images/texture.png', 0);
		$image_styles = 'height:' . $project_hero_data['banner_height'] . 'px;';
	endif;
	$project_banner_image =
		' class="' .
		$image_class .
		'" style="background-image: url(\'' .
		$image_src[0] .
		'\');' .
		$image_styles .
		'" ';

	// getting project story data
	$story_data = simple_fields_fieldgroup("project_story_data", get_the_id());

	// getting ambassador data
	$ambassador_data = simple_fields_fieldgroup("ambassador_data", get_the_id());
	?>

	<section id="intro"<?php echo $project_banner_image; ?>>
		<div class="intro-ambassador">
			<div class="row container-fluid">
				<div class="col-md-8 col-md-offset-1">
					<?php if($project_hero_data['quote']) : ?>
						<div class="quote"><?php echo $project_hero_data['quote']; ?></div>
					<?php endif; ?>
					<?php if($project_hero_data['ambassador_intro']) : ?>
						<?php if($story_data && $ambassador_data['text']) : // same-page anchor only present if story is in between and ambassador story present ?>
							<a href="#vaandeldrager" class="action action-light action-readmore" style="float: right; margin-top: -3px;">lees meer</a>
						<?php endif; ?>
						<p>
							<?php if($ambassador_data['name']) : ?>
								<strong><?php echo $ambassador_data['name']; ?></strong> -
							<?php endif; ?>
							<em><?php echo $project_hero_data['ambassador_intro']; ?></em>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php
	if(get_post_status() == 'pending') :
	?>
	<section id="archived_message">
		<div class="row container-fluid">
			<div class="col-md-12 box">
				<?php
				$archivemessage_data = simple_fields_fieldgroup("front_page_data", get_page_by_title('projecten')->ID);
				?>
				<p><?php echo $archivemessage_data["archive_descr"]; ?></p>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php
	if ($story_data) :
	?>
	<section id="story">
		<?php
		foreach($story_data as $key => $section):
		?>
		<div class="row container-fluid box-main">
			<?php
			// setting necessary parameters
			$textcol = ($section['section_image']) ? 7 : 12;
			$image_is_logo = (get_post($section['section_image'])->post_excerpt == 'logo') ? true : false;
			$image_aligned_right = ($section['section_image'] && $section['section_alignment']['selected_value'] == 'right') ? true : false;
			$image_descr = get_post_meta($section['section_image'], '_wp_attachment_image_alt', true);
			?>
			<div title="<?php echo $image_descr; ?>" class="col-md-5 box-image<?php echo ($image_is_logo) ? ' logo' : ''; echo ($image_aligned_right) ? ' col-md-push-7' : ''; ?>">
				<?php $image_src = wp_get_attachment_image_src($section['section_image'], 'large'); ?>
				<img src="<?php echo $image_src[0]; ?>" alt="" />
			</div>
			<div class="col-md-<?php echo $textcol; echo ($image_aligned_right) ? ' col-md-pull-5' : ''; ?> box">
				<?php if($key == 0) : ?>
					<h4>Project</h4>
					<h2><?php the_title(); ?></h2>
				<?php endif; ?>
				<?php echo $section['section_text']; ?>
			</div>
		</div>
		<?php endforeach ?>
	</section>
	<?php endif; ?>

	<?php
	if ($ambassador_data['text']) :
	?>
	<section id="vaandeldrager">
		<div class="row container-fluid box-side">
			<div class="col-md-12 box">
				<?php if($ambassador_data['profile_image']) : ?>
					<?php $image_src = wp_get_attachment_image_src($ambassador_data['profile_image'], 'medium'); ?>
					<div class="ambassador-image" style="background-image: url('<?php echo $image_src[0]; ?>');"></div>
				<?php endif; ?>
				<h4>Vaandeldrager</h4>
				<h2><?php echo $ambassador_data['name']; ?></h2>
				<p><?php echo $ambassador_data['text']; ?></p>
			</div>
		</div>
	</section>
	<?php endif ?>

	<?php
	$project_links_data = simple_fields_fieldgroup("project_links", get_the_id());
	if ($project_links_data) :
	$colsize = 12/count($project_links_data);
	?>
	<section id="links">
		<div class="row container-fluid">
			<?php foreach($project_links_data as $link) : ?>
			<a href="<?php echo $link['url']; ?>" target="_blank" class="<?php echo "col-xs-12 col-sm-6 col-md-" . $colsize . " link-" . $link['type']['selected_value']; ?>">
				<span class="text"><?php echo $link['text']; ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif ?>

	<?php if (!$ambassador_valid && !$story_data) : ?>
	<section>
		<div class="row container-fluid">
			<div class="col-md-8 col-md-offset-2">
				<p><i>Deze pagina bevat geen inhoud.</i></p>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<script>
		$(document).ready(function() {
			$('header #menu li a').each(function() {
				if ($(this).html().indexOf('Projecten') >= 0) {
						$(this).closest('li').addClass('current-menu-item');
				}
			});
		});
	</script>


</div><!--/content -->
<?php endwhile; ?>

<?php get_footer(); ?>
