<?php
function add_query_vars_filter( $vars ){
  $vars[] = "id";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

// registering site menu to theme
function register_my_menus() {
  register_nav_menus(
    array( 'header-menu' => __( 'Header' ) )
  );
}
add_action( 'init', 'register_my_menus' );



function custom_post_status(){
	register_post_status( 'archive', array(
		'label'                     => _x( 'Archive', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'custom_post_status' );

?>
