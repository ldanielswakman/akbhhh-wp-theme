<?php get_header(); ?>

<div id="scrollhelper">
	<div class="arrow arrow-1">&#59236;</div>
	<div class="arrow arrow-2">&#59236;</div>
</div>


<div id="content">

	<?php
	// creating an 'empty' array for predefined amount of tiles
	$n_tiles = 6;
	$tile_data = array_fill(0, $n_tiles, array('tile_title' => '', 'tile_image' => '', 'tile_url' => '#'));

	// looping through projects and outputting overview data into $tile_data
	$args = array(
		'post_type' => 'project',
		'post_status' => 'publish',
		'order' => 'DESC'
	);
	$project_query = new WP_Query($args);
	while ($project_query->have_posts()) : $project_query->the_post();
		$i = $project_query->current_post;

		// storing 'project on homepage' from simple fields into tile array
		$tile_data[$i] = simple_fields_fieldgroup("project_on_homepage", get_the_id());

		// set the page default title if none is entered specifically
		if(!$tile_data[$i]["tile_title"]) {
			$tile_data[$i]["tile_title"] = get_the_title();
		}

		// set cover image if present
		if($tile_data[$i]["tile_image"]) {
			$image_src = wp_get_attachment_image_src($tile_data[$i]["tile_image"], 'medium');
			$tile_data[$i]["tile_image"] = $image_src[0];
		}

		// set url
		$tile_data[$i]["tile_url"] = get_permalink();
	endwhile;
	wp_reset_postdata();

	//looping through tile array and creating link tag from data
	foreach($tile_data as $key => $tile) :

		$tile_data[$key]["a"] = '
		<a href="' .
		$tile_data[$key]["tile_url"] .
		'" id="project' .
		($key+1) .
		'" class="tile" style="background-image: url(' .
		$tile_data[$key]["tile_image"] .
		');"><span class="title">' .
		$tile_data[$key]["tile_title"] .
		'</span></a>';

	endforeach;
	?>

	<section id="intro">
		<div class="row container-fluid">
			<div class="col-md-10 col-md-offset-1">
				<div id="tilemap" class="tilemap">
					<div class="section1">
						<div class="section1-1 tile-container">
							<?php echo $tile_data[0]['a']; ?>
						</div>
						<div class="section1-2 tile-container">
							<?php echo $tile_data[1]['a']; ?>
							<div id="intro" class="tile">
								<?php
								$frontpage_data = simple_fields_fieldgroup("front_page_data", get_the_id());
								?>
								<div class="tagline">
									<?php echo $frontpage_data['tilemap_tagline']; ?>
								</div>
								<div class="descr">
									<?php echo $frontpage_data['tilemap_descr']; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="section2">
						<div class="section2-1 tile-container">
							<?php echo $tile_data[3]['a']; ?>
						</div>
						<div class="section2-2 tile-container">
							<?php echo $tile_data[2]['a']; ?>
							<?php echo $tile_data[4]['a']; ?>
						</div>
						<div class="section2-3 tile-container">
							<?php echo $tile_data[5]['a']; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="span2">
			</div>
		</div>
	</section>

	<?php
	// Archived: list projects that have been archived
	$args = array(
		'post_type' => 'project',
		'post_status' => 'pending',
		'order' => 'DESC'
	);
	$archive_query = new WP_Query($args);
	if($archive_query->have_posts()) :
	?>
	<section id="archive">
		<?php if($frontpage_data['archive_title']) : ?>
		<div class="row container-fluid">
			<div class="col-md-10 col-md-offset-1 align-center">
				<h6><?php echo $frontpage_data['archive_title']; ?></h6>
			</div>
		</div>
		<?php endif; ?>
		<div class="row container-fluid">
			<?php while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
				<?php
				$i = $project_query->current_post;
				$tile_data[$i] = simple_fields_fieldgroup("project_on_homepage", get_the_id());
				if($tile_data[$i]["tile_image"]) { $image_src = wp_get_attachment_image_src($tile_data[$i]["tile_image"], 'medium'); $tile_data[$i]["tile_image"] = $image_src[0]; }
				if(!$tile_data[$i]["tile_title"]) { $tile_data[$i]["tile_title"] = get_the_title(); }
				?>

				<div class="col-md-3 col-sm-4 col-xs-6 archived-project">
					<?php
					// element to be standardized: outputs anchor tile with background image if present
					echo '<a href="';
					echo get_post_permalink(get_the_id(), false, true);
					echo '" id="project1" class="tile"';
					if (!empty($tile_data[$i]["tile_image"])) :
						echo ' style="background-image: url(\'';
						echo $tile_data[$i]["tile_image"];
						echo '\');"';
					endif;
					echo '><span class="title">';
					echo $tile_data[$i]["tile_title"];
					echo '</span></a>';
					?>

				</div>
			<?php endwhile; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php
	// retrieving posts and outputting news_preview section if there are posts to display
	global $more;
	$args = array(
		'post_type' => 'post',
		'order' => 'DESC',
		'posts_per_page' => '3'
	);
	$post_query = new WP_Query($args);
	if($post_query->have_posts()) :
	?>
	<section id="news_preview">
		<div class="row container-fluid">
			<div class="col-md-10 col-md-offset-1 align-center">
				<h6><?php echo get_the_title(get_page_by_path('nieuws')->ID); ?></h6>
			</div>
		</div>
		<div class="row container-fluid">
			<?php while ($post_query->have_posts()) : $post_query->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="col-sm-4 col-xs-12 news-item">
					<h4><?php the_title(); ?></h4>
					<div class="date"><?php the_date('d F Y'); ?></div>
					<?php
					$more = 0;
					echo wpautop(substr(get_the_excerpt(''), 0, 400)); // quotes necessary to deliver empty string to 'more' link option
					?>
				</a>
			<?php endwhile; ?>
		</div>
		<div class="row container-fluid">
			<div class="col-md-8 col-md-offset-2 padded-20 align-center">
				<a href="<?php echo 'nieuws'; ?>" class="action action-grey">meer nieuws</a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section id="map">
		<img src="<?php bloginfo( 'template_directory' ); ?>/images/map.jpg" alt="" />
		<?php
		// displaying a map marker if the project data has coordinates
		foreach($tile_data as $key => $project):
			if(!empty($project['coord_x']) && !empty($project['coord_y'])):
				echo '<a href="' . $project['tile_url'] . '" class="marker" id="marker' . ($key+1) . '" style="bottom: ' . (100-$project['coord_y']) . '%; left: ' . $project['coord_x'] . '%;"><label>' . $project['tile_title'] . '</label></a>';
			endif;
		endforeach;
		?>
	</section>

	<?php
	// retrieving about page and outputting first intro
	$about = $frontpage_data['summary_page'];
	$about_data = simple_fields_fieldgroup("page_section_data", $about);
	if(!empty($about_data)) :
	?>
	<section id="about">
		<div class="row container-fluid">
			<div class="col-md-10 col-md-offset-1 align-center">
				<h6><?php echo get_the_title($about); ?></h6>
			</div>
		</div>
		<div class="row container-fluid">
			<div class="col-md-8 col-md-offset-2">
				<?php
				$first_text = $about_data[0];
				echo wpautop(substr($first_text['text_intro'], 0, 400));
				?>
			</div>
		</div>
		<div class="row container-fluid">
			<div class="col-md-8 col-md-offset-2 padded-20 align-center">
				<a href="<?php echo get_the_permalink($about); ?>" class="action action-grey">lees meer over ons</a>
			</div>
		</div>
	</section>
	<?php endif; ?>

</div><!--/content -->

<?php get_footer(); ?>
