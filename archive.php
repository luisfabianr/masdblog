<?php
//* Add support for Genesis Grid Loop
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'child_grid_loop_helper' );
function child_grid_loop_helper() {
  if ( function_exists( 'genesis_grid_loop' ) ) {
		genesis_grid_loop( array(
			'features' => 1,
			'feature_image_size' => 'img-future-cat',
			'feature_image_class' => 'alignleft post-image',
			'feature_content_limit' => 200,
			'grid_image_size' => 'img-secundaria-relacionada',
			'grid_image_class' => 'alignleft post-image',
			'grid_content_limit' => 100,
			'more' => __( '[Continuar Leyendo...]', 'genesis' ),
			'posts_per_page' => 10,
		) );
	} else {
		genesis_standard_loop();
	}
}
//* Remove the post meta function for front page only
remove_action( 'genesis_entry_footer', 'genesis_post_meta', 10 );
genesis();




