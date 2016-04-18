<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Node FaDIC' );
define( 'CHILD_THEME_URL', 'http://www.fadic.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add new featured image sizes
add_image_size( 'img-principal-relacionada-left', 380, 400, TRUE );
add_image_size( 'img-secundaria', 380, 500, TRUE );
add_image_size( 'img-secundaria-relacionada', 380, 200, TRUE );
add_image_size( 'img-relacionada-masd', 380, 450, TRUE );
add_image_size( 'img-future-cat', 643, 485, TRUE );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,300', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'waypoints', get_stylesheet_directory_uri() . '/assets/js/jquery.waypoints.min.js', array( 'jquery' ), '3.1.1', true );
	wp_enqueue_script( 'classie', get_stylesheet_directory_uri() . '/assets/js/classie.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'gnmenu', get_stylesheet_directory_uri() . '/assets/js/gnmenu.js', array( 'jquery' ), '1', true );
	wp_enqueue_script( 'effect', get_stylesheet_directory_uri() . '/assets/js/effect.js', array( 'jquery' ), '1', true );
}

add_filter( 'stylesheet_uri', 'custom_replace_default_style_sheet', 10, 2 );
function custom_replace_default_style_sheet() {
	return CHILD_URL . '/assets/css/custom.css';
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Force content-sidebar layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Force full width layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove Genesis Header 
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );  
remove_action( 'genesis_header', 'genesis_do_header' );  
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );



// Remove the post info function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_filter( 'genesis_post_meta', 'sp_post_meta_category', 12 );
function sp_post_meta_category($post_info) {
	if(is_singular()){
		$post_info = '[post_categories before=" "]';
		return $post_info;
	}
}
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_post_meta', 14 );


add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	if ( is_singular() ) {
		$post_info = '[post_date] [post_comments zero="Deja un comentario" one="1 comentario" more="% Comentarios"] ';
		return $post_info;
	}
}



function node_home_layout() {
	if ( is_home() )
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
		
}  
//* Add two sidebars to the main sidebar area **************************************************************************************************************************************
add_action('genesis_before_footer', 'node_include_bottom_sidebars', 15); 
function node_include_bottom_sidebars() {
    require(CHILD_DIR.'/sidebar-bottom.php');
}

//* Add the slider on the homepage above the content area **************************************************************************************************************************************
add_action('genesis_after_header', 'node_include_slider'); 
function node_include_slider() {
    if(is_home())
    dynamic_sidebar( 'historia-principal' );
}
//* Add the slider on the homepage above the content area **************************************************************************************************************************************
add_action('genesis_before_footer', 'node_include_dialogos', 10); 
function node_include_dialogos() {
    if(is_home()){
    echo '<div id="front-page-dialogos-d" class="front-page-dialogos-d section"><div class="wrap project add-animation animation-1 ">';
		dynamic_sidebar( 'dialogos' );
	echo '</div></div>';
	}
}
add_filter( 'genesis_attr_site-inner', 'be_site_inner_attr' );
function be_site_inner_attr( $attributes ) {
	if(is_home())
	// Add a class of 'full' for styling this .site-inner differently
	$attributes['class'] .= ' full';
	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
	return $attributes;
}


// Register menus personalizado **************************************************************************************************************************************
add_action( 'init', 'node_register_menus' );
function node_register_menus() {
    register_nav_menus(
        array(
            'cat-menu' => __( 'Categorias Menu', 'text-domain' )
        )
    );
}

//* Register menu categories **************************************************************************************************************************************
add_action( 'genesis_after_header', 'add_extra_nav', 1 ); 
function add_extra_nav() {
	echo '<ul id="gn-menu" class="gn-menu-main"><li class="gn-trigger"><a class="gn-icon gn-icon-menu"><span>Menu</span></a><nav class="gn-menu-wrapper">';
		wp_nav_menu( array( 
			'theme_location' => 'cat-menu', 
			'container_class' => 'gn-scroller',
			'menu_class'     => 'gn-menu'
		));
    echo '</nav></li><li class="logo-masd"><a href="http://localhost:8888/wordpress441/"><img src="/wordpress441/wp-content/themes/genesis-sample/images/logo_nodo.svg" alt=""></a></li><li><a href="http://"><img src="/wordpress441/wp-content/themes/genesis-sample/images/logo_ueb.svg" alt=""></a></li></ul>';
}
function add_menuclass($ulclass) {
	return preg_replace('/<a /', '<a class="gn-icon"', $ulclass, -1);
}

// FULL IMAGE POST PAGE **************************************************************************************************************************************

/** Add the featured image section */
add_action( 'genesis_after_header', 'full_featured_image', 2 );
function full_featured_image() {

    if ( is_singular() && has_post_thumbnail() ){
        echo '<div id="entry-background">';
        echo get_the_post_thumbnail($thumbnail->ID, 'slider');
        echo '</div>';
    }
}

//* Add body class for single Posts and static Pages having Featured images
add_filter( 'body_class', 'ambiance_featured_img_body_class' );
function ambiance_featured_img_body_class( $classes ) {
    if ( is_singular() && has_post_thumbnail() ) {
        $classes[] = 'has-featured-image';
    }
    return $classes;
}
add_filter('wp_nav_menu','add_menuclass');


add_filter( 'genesis_post_title_output', 'ac_post_title_output', 15 );
function ac_post_title_output( $title ) {
	if ( is_singular() && has_post_thumbnail() )
		$title = sprintf( '<h1 class="entry-title post-space-left">%s</h1>', apply_filters( 'genesis_post_title_text', get_the_title() ) );

	return $title;

}

//* Register widget areas **************************************************************************************************************************************
genesis_register_sidebar(array(
	'name'=>'Historia Principal',
	'id' => 'historia-principal',
	'description' => 'Historia Principal del node',
));
genesis_register_sidebar(array(
	'name'=>'Principal Relacionada Left',
	'id' => 'principal-relacionada-left',
	'description' => 'Historia relacionada con la principal ubicada en la parte Izquierda.',
));
genesis_register_sidebar(array(
	'name'=>'Principal Relacionada Center',
	'id' => 'principal-relacionada-center',
	'description' => 'Historia relacionada con la principal ubicada en la parte Central.',
));
genesis_register_sidebar(array(
	'name'=>'Principal Relacionada Right',
	'id' => 'principal-relacionada-bottom',
	'description' => 'Historia relacionada con la principal ubicada en la parte Derecha',
));
genesis_register_sidebar(array(
	'name'=>'Historia Secundaria',
	'id' => 'historia-secundaria',
	'description' => 'Historia Secundaria del node.',
));
genesis_register_sidebar(array(
	'name'=>'Secundaria Relacionada Left',
	'id' => 'historia-secundaria-relacionada-left',
	'description' => 'Historia relacionada con la secundaria ubicada en la parte Izquierda.',
));
genesis_register_sidebar(array(
	'name'=>'Secundaria Relacionada Right',
	'id' => 'historia-secundaria-relacionada-right',
	'description' => 'Historia relacionada con la secundaria ubicada en la parte Derecha.',
));
genesis_register_sidebar(array(
	'name'=>'Principal masD ',
	'id' => 'historia-principal-masd',
	'description' => 'Historia destacada revista académica masD.',
));
genesis_register_sidebar(array(
	'name'=>'Dialogos',
	'id' => 'dialogos',
	'description' => 'Acceso a dialogos en diseño',
));
genesis_register_sidebar(array(
	'name'=>'Sidebar Bottom Left',
	'id' => 'sidebar-bottom-left',
	'description' => 'Esta es la columuna izquierda en el footer.',
));
genesis_register_sidebar(array(
	'name'=>'Sidebar Bottom Right',
	'id' => 'sidebar-bottom-right',
	'description' => 'Esta es la columuna derecha en el footer.',
));


/** Remove footer widgets */
remove_theme_support( 'genesis-footer-widgets', 3 );
/** Remove Genesis widgets */
unregister_sidebar( 'header-right', 1);
unregister_sidebar( 'sidebar',2 );
unregister_sidebar( 'sidebar-alt' ,3);




//loop  **************************************************************************************************
add_action( 'genesis_before_footer', 'sk_display_featured_posts', 5 );
function sk_display_featured_posts() {
          
	echo '<div id="front-page-historias-relacionadas-d" class="front-page-relacionadas-d section">';
	echo ' <div id="content-sidebar-wrap" class="full first">';
	// WP_Query arguments
	$args = array (
		'orderby'               => 'rand',
		'order'                 => 'ASC',
		'posts_per_page'        => '3',
	);
	// The Query
	$featured_query = new WP_Query( $args );
	$i = 0;
	// The Loop
	if ( is_home() or is_single() && $featured_query->have_posts() ) {
		while ( $featured_query->have_posts() ) {
			$featured_query->the_post();
			if ( ! has_post_thumbnail() ) {
				return;
			}
			$image_args = array(
				'size' => 'img-secundaria',
			);

			$categories = get_the_category();
			$output = '';
			if ( ! empty( $categories ) ) {
    			foreach( $categories as $category ) {
        		$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
    			}
			}
			// Get the featured image
			$image = genesis_get_image( $image_args );	
			printf( '<div class="one-third"><article class="post">', genesis_attr( '' ) );
			echo '	<div class="post-thumb">'. $image .'</div>
					<div class="wrap-entry-content">
						<header class="entry-header">
							<div class="post-cat">' . $output . '</div>
							<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</h2></a>
						</header>
						<div class="entry-content">'. get_the_excerpt() .'</div>
					<div>
				    <div class="more-single-post"><a href="' . get_permalink() . '">Leer Nodo</a>  
				    	<div class="comments-link"><a href="' . get_permalink() . '#respond' . '">' . get_comments_number() . '</a></div>
				    </div>
				</article></div>

				';
			$i++;
		}
	} else {
		// no posts found
	} 
	// Restore original Post Data
	wp_reset_postdata();
 
	echo '</div></div>';
}

//Tags  **************************************************************************************************
add_action('genesis_before_footer', 'node_include_tags', 11); 
function node_include_tags() {
	if(is_home() or is_archive()){
		echo '<div id="front-page-tags-d" class="front-page-tags-d section"><div class="wrap">';
		echo '<div class="tittle section"><h2>Keywords</h2></div>';
  			wp_tag_cloud( 'format=list&number=0&smallest=80&largest=120&unit=%' );
  		echo '</div></div>';
  	}
}
//Script Menu  **************************************************************************************************
add_action('wp_footer','add_js_functions', 20);
function add_js_functions(){
?>
	<script>
		new gnMenu( document.getElementById( 'gn-menu' ) );
	</script>
<?php
}

/*function be_archive_post_class( $classes ) {
	global $wp_query;
	if( ! $wp_query->is_main_query() )
		return $classes;
		
	$classes[] = 'one-third';
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
		$classes[] = 'first';
	return $classes;
}
add_filter( 'post_class', 'be_archive_post_class' );*/


//* Display Autor  **************************************************************************************************
add_action( 'genesis_entry_content', 'node_autor_display', 1 );
function node_autor_display() {
	/*if(is_singular()){
	    $autor= get_field( 'autor_articulo' );
	    $perfil= get_field( 'perfil' ); 
	    echo '<div class="detalle-autor">'; 
	    if ( $autor || $perfil ) {
	            if ( $autor ) {
	                echo '<div class="wrap-info-autor"><span>Por:</span> '. $autor . '</div>';
	            } 
	            if ( $perfil ) {
	                echo '<div class="wrap-info-perfil"> '. $perfil . '</div>';
	            } 
	    }
	    echo '</div>';
	}*/
	coauthors_get_avatar();
	echo '<div class="detalle-autor">'; 
	echo '<div class="wrap-info-autor"><span>Por:</span> ';
	if ( function_exists( 'coauthors_posts_links' ) ) {
    coauthors_posts_links();
    echo '<br>';
    coauthors_about();
    echo '<div><a href="'  . 'mailto:'  . '">';
    coauthors_emails();
    echo ' </a></div>'; 
	} else {
	    the_author_posts_link();
	}
	echo '</div></div>';
}


//* Display Bibliografia  **************************************************************************************************
add_action( 'genesis_entry_content', 'node_biblio_display' );
function node_biblio_display() {
	if(is_singular()){
	    $bibliografias= get_field( 'bibliografia' );
	    echo '<div class="detalle-bibliografia post-space-left">'; 
	    if ( $bibliografias ) {
	    	echo '<h5>Referencias Bibliográficas</h5>'; 
	        echo  '<div class="wrap-info-bibliografia"> ' . $bibliografias . '  </div>';
	    }
	    echo '</div>';
	}
}

//* Display tags  **************************************************************************************************
add_action( 'genesis_post_meta', 'node_tags_display_header', 5 );
function node_tags_display_header(){
	if(is_singular()){
		echo '<div class="detalle-tags-header">'; 
		echo '<div class="wrap-info-tags-header"> ';
		global $post;
			foreach(get_the_tags($post->ID) as $tag) {
				echo '<span class="info-tags"><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>, </span>';
			}

		echo '</div></div>';
	}
}
add_action( 'genesis_entry_content', 'node_tags_display', 10 );
function node_tags_display(){
	if(is_singular()){
		echo '<div class="detalle-tags post-space-left">'; 
		echo '<div class="wrap-info-tags"> Etiquetas: ';
		global $post;
			foreach(get_the_tags($post->ID) as $tag) {
				echo '<span class="info-tags"><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>, </span>';
			}

		echo '</div></div>';
	}
}


//* Display share  **************************************************************************************************
add_action( 'genesis_entry_content', 'node_sharing_display', 12 );
	function node_sharing_display(){
		echo '<div class="wrap-recommend post-space-left"><span id="recommed-this" class="recommed-this">';
        echo do_shortcode('[dot_recommends]');
        echo '<div class="label-recommend">Recomendado</div></span>';
		echo '<span id="sharing">';
		echo '</span></div>';
}
//* Display Rating  **************************************************************************************************
add_action( 'genesis_entry_content', 'node_rating_display', 2 );
	function node_rating_display(){
				if(is_singular() && function_exists('the_ratings')) { 
					the_ratings();
				}
}

//* Display comments && form  **************************************************************************************************
add_action('genesis_after_entry', 'node_include_buttons', 0); 
function node_include_buttons() {
	if( is_singular()){
		echo '<div id="page-show-forms" class="page-show-forms post-space-left section">';
		echo '<div class="tittle section"><h2>Te gustó la lectura? Opina, participa o cuéntanos si te sirvió!</h2></div>';
  		echo '<a  class="show active" target="1">Unirme a la discusión</a> ';
		echo '<a  class="show" target="2">Fué de ayuda para...</a>';
  		echo '</div>';
  	}
}

//* Display form  **************************************************************************************************
add_action('genesis_after_entry', 'sk_display_form', 1);
function sk_display_form() {
    if ( is_singular() ){    
        echo '<div id="discussion2" class="form-user-d targetDiv post-space-left" style="display:none;"><div class="wrap">';
        echo do_shortcode('[contact-form-7 id="47"]');
        echo '</div></div>';
    }
}

add_action( 'genesis_after_entry', 'yourcustomelement_before', 1 );
	function yourcustomelement_before(){
		echo '<div id="discussion1" class="comments-wrap section targetDiv post-space-left" style="display:block;">';
}

add_action( 'genesis_after_entry', 'yourcustomelement_after', 20 );
	function yourcustomelement_after(){
		echo '</div>';
}

add_filter( 'comment_author_says_text', 'sp_comment_author_says_text' );
function sp_comment_author_says_text() {
	return 'dice';
}

//* Display Next post  **************************************************************************************************

add_action( 'genesis_before_footer', 'ac_next_prev_post_nav', 1 );
function ac_next_prev_post_nav() {	
	if ( is_singular() && $prev = get_next_post() ) {
		$prev_title = $prev->post_title;
	    $prev_ex_con = ( $prev->post_excerpt ) ? $prev->post_excerpt : strip_shortcodes( $prev->post_content );
	    $prev_text = wp_trim_words( apply_filters( 'the_excerpt', $prev_ex_con ), 15 );
	    $prev_time_author = sprintf( __( '%s atras - por %s', 'byline' ), human_time_diff( get_the_time( 'U', $prev->ID ), current_time( 'timestamp' ) ), coauthors_posts_links() );

		echo '<div id="single-page-next-post" class="single-page-next-post section">';
		echo '<div id="content-sidebar-wrap" class="full first">';
		echo '<h4>Siguiente nodo</h4>';
		echo '<h2><a href="' . esc_url( get_permalink( $prev->ID ) ) . '">' . $prev_title . '</a></h2>';
		echo '<p>' . $prev_text . '</p>';
		echo '<em>' . $prev_time_author . '</em>';
		echo '</div></div>';

	}
}

//* Display text before tittle archive  **************************************************************************************************
add_action('genesis_before_loop', 'sk_display_text_archive', 0);
function sk_display_text_archive() {
    if ( is_archive() ){    
        echo '<div class="wrap-tittle-tags-header"> Nodos encontrados con la etiqueta: </div>';
    }
}


//* Move Post Title and Post Info from inside Entry Header to Entry Content on Posts page
add_action( 'genesis_before_entry', 'reposition_entry_header' );
function reposition_entry_header() {

	if ( is_archive() ) {

		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_do_post_expert' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		add_action( 'genesis_entry_content', 'genesis_do_post_title', 8 );
		add_action( 'genesis_entry_content', 'genesis_do_post_expert', 14);
		add_action( 'genesis_entry_content', 'genesis_post_info', 9 );

	}

}
