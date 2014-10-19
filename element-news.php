<?php
// Start the Loop.
while ( have_posts() ) : the_post(); ?>
<script>
	// checks url for item slug and converts into hashed
	if (!window.location.hash) {
		path = window.location.href;
		if(path.substr(-1) == "/") { path = path.substr(0, path.length-1); } // removes trailing slash if present
		item = path.substring(path.lastIndexOf("/") +1, path.length); // extracts item slug
		host_path = path.substring(0, path.lastIndexOf("/") +1);
		if (item != 'nieuws') {
			window.location.replace(host_path + "nieuws#" + item); // creates new url with item slug as hash
		}
	}

	$(document).ready(function() {
		activateNewsItem();

		// determine click event
		var touch = ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
		var touchEvent = touch ? 'touchstart' : 'click';

		$('article a').not('article .item-text a').bind(touchEvent, (function(e) {
			e.preventDefault();
			$article = $(this).closest('article');
			$('article').attr('style', '');
			if ($article.hasClass('active')) {
				window.location.hash = "0";
			} else {
				$article.animateAuto("height", 200);
			}
			hasScrolled();
			$article.toggleClass('active');
			$('article').not($article).removeClass('active');
		}));
	});

	function activateNewsItem() {
		$newsID = window.location.hash;
		if ($newsID) {
			$($newsID).addClass('active');
			$($newsID).click();
			$('header').removeClass('nav-down').addClass('nav-up');
		}
	}
</script>

<div id="content">

	<section id="news" class="padded-50">

		<?php
		// retrieving posts and outputting news_preview section if there are posts to display
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
		);
		$post_query = new WP_Query($args);
		if($post_query->have_posts()) :
		?>
		<?php
		while ($post_query->have_posts()):
		$post_query->the_post();
		$i = $post_query->current_post+1;
		$news_id = preg_replace('/\?.*\=/', '', basename(get_permalink()));
		?>
		<article id="<?php echo $news_id; ?>">
			<div class="row container-fluid padded-20">
				<div class="col-md-1">
					<a href="#<?php echo $news_id; ?>" data-href="#0" class="toggle"></a>
				</div>
				<div class="col-md-8 clearfix">
					<a href="#<?php echo $news_id; ?>" data-href="#0"  class="collapsed-link"></a>
					<a href="#<?php echo $news_id; ?>" data-href="#0" ><h2><?php the_title(); ?></h2></a>
					<div class="date"><?php the_date('d F Y'); ?></div>
					<div class="item-text">
						<?php the_content(); ?>
					</div>
					<a href="#0" class="action action-grey action-close">sluiten</a>
				</div>
			</div>
		</article>
		<?php endwhile; endif; ?>

	</section>

</div><!--/content -->
<?php endwhile; ?>
