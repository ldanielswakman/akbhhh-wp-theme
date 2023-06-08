<?php get_header(); ?>

<div id="scrollhelper">
	<div class="arrow arrow-1">&#59236;</div>
	<div class="arrow arrow-2">&#59236;</div>
</div>


<div id="content">

	<?php
	// looping through projects and outputting overview data into $tile_data
	$args = array(
		'post_type' => 'project',
		'post_status' => 'publish',
		'order' => 'DESC',
		'posts_per_page' => -1,
	);
	$project_query = new WP_Query($args);

	// forming an array of post data
	$projects = [];
	while ($project_query->have_posts()) : $project_query->the_post();
		$i = $project_query->current_post;
		$projects[$i] = simple_fields_fieldgroup("project_on_homepage", get_the_id());
		$projects[$i]['id'] = get_the_id();
		$projects[$i]['url'] = get_the_permalink();
		if(empty($projects[$i]['tile_title'])) {
			$projects[$i]['tile_title'] = get_the_title();
		}
	endwhile;
	wp_reset_postdata();

	// tile map: storing non-archived projects in tile array
	$tile_data = [];
	foreach ($projects as $key => $project) :
		if ($project['archived'] != '1') :
			$tile_data[]["a"] = '
			<a href="' .
			$project["url"] .
			'" id="project' .
			($key+1) .
			'" class="tile" style="background-image: url(' .
			wp_get_attachment_image_src($project["tile_image"], 'medium_large')[0] .
			');"><span class="title">' .
			$project["tile_title"] .
			'</span></a>';
		endif;
	endforeach;
	?>

	<section class="tile-mosaic-section">
		<div class="
			tile-mosaic
			<?= (count($tile_data) < 7) ? 'tile-mosaic--compact' : '' ?>
			<?= (count($tile_data) === 7) ? 'tile-mosaic--medium' : '' ?>
			">

			<div class="title" id="intro">
				<?php $frontpage_data = simple_fields_fieldgroup("front_page_data", get_the_id()) ?>
				<div class="tagline"><?= $frontpage_data['tilemap_tagline'] ?></div>
				<div class="descr"><?= $frontpage_data['tilemap_descr'] ?></div>
			</div>

			<?php foreach($tile_data as $key => $tile) : ?>
				<?= $tile['a'] ?>
			<?php endforeach ?>

		</div>
	</section>

	<?php
	// only show section if archived projects exist
	$has_archived = false;
	foreach ($projects as $project) :
		if ($project['archived'] == '1') { $has_archived = true; }
	endforeach;
	if ($has_archived == true) :
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

			<?php
			// outputting archived projects (if any)
			foreach ($projects as $key => $project) :
				if ($project['archived'] == '1') :
				?>

					<div class="col-md-3 col-sm-4 col-xs-6 archived-project">
						<?php
						echo '<a href="';
						echo $project['url'];
						echo '" id="project1" class="tile"';
						if (!empty($project["tile_image"])) :
							echo ' style="background-image: url(\'';
							echo wp_get_attachment_image_src($project["tile_image"], 'medium')[0];
							echo '\');"';
						endif;
						echo '><span class="title">';
						echo $project['tile_title'];
						echo '</span>';
						echo '</a>';
						?>
					</div>

				<?php
				endif;
			endforeach;
			?>

		</div>
	</section>
	<?php 
	endif;
	?>

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
		foreach($projects as $key => $project):
			if($project['archived'] != '1' && !empty($project['coord_x']) && !empty($project['coord_y'])):
				$marker = "";
				$marker .= '<a href="' . $project['url'] . '"';
				$marker .= ' class="marker';
				if(intval($project['coord_x']) < 10) {
					$marker .= ' marker-left';
				}
				if(intval($project['coord_x']) > 90) {
					$marker .= ' marker-right';
				}
				$marker .= '" id="marker' . ($key+1) . '"';
				$marker .= 'style="bottom: ' . (100-$project['coord_y']) . '%; left: ' . $project['coord_x'] . '%;">';
				$marker .= '<span class="text">' . $project['tile_title'] . '</span>';
				$marker .= '</a>';
				echo $marker;
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
