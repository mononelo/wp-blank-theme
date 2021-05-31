<?php


// FUNCTION TO RESOLVE ASSETS

function getPath($file, $ext){
	if ($_SERVER['HTTP_HOST'] == 'mononelo') {
		if ($ext == 'css') $folder = 'css/'; else $folder = '';
		$root = 'http://localhost:8080/assets/';
		return $root . $folder . $file . '.' . $ext;
	} else {
		$root = get_bloginfo('template_url');
		$assets = json_decode(file_get_contents(str_replace(get_bloginfo('url'),'.',get_bloginfo('template_url')).'/assets/assets.json'));

		return $root . $assets->$file->$ext;
	}
}

if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

// REMOVE SPANS OF WPCF7
add_filter( 'wpcf7_autop_or_not', '__return_false' );
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
 
// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );
 
// Don't filter oEmbed results.
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
 
// Remove oEmbed discovery links.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
 
// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

//Disable emojis in WordPress
add_action( 'init', 'smartwp_disable_emojis' );

function smartwp_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

// PREVENT SCALNG IMAGES

add_filter( 'big_image_size_threshold', '__return_false' );

// REGISTER SIDEBAR

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Default Sidebar',
		'id' => 'default',
		'description' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
	));
}

// REMOVE ADMIN BAR

function remove_admin_bar() { show_admin_bar(false); }
add_action('after_setup_theme', 'remove_admin_bar');

// REMOVE CONTENT BOX

function remove_editor() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
		$templates = array(
			'template-home.php',
		);

        if(in_array($template,$templates)){ 
            remove_post_type_support( 'page', 'editor' );
        }
    }
}
add_action('init', 'remove_editor');

// CUSTOM POST TYPE

function post_type_proyecto() {
 
	$supports =  array( 
		'title', 
		'editor', 
		'thumbnail', 
		'custom-fields', 
		'revisions' ,
		'excerpt',
	);
 
	$args =  array( 
		'labels' => the_labels('Proyectos','Proyecto','proyectos','proyecto',true),
		'public' => true, 
		'show_ui' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'supports' => $supports,
		'has_archive' => true
	);
 
	register_post_type( 'proyecto', $args );
	flush_rewrite_rules();
}
add_action('init', 'post_type_proyecto');

function the_labels($capplural,$capsingular,$plural,$singular,$male){
	if($male) $sex = 'o'; else $sex = 'a';
	
	return array(
		'name' => __( $capplural ),
		'singular_name' => __( $capplural ),
		'add_new' => __( 'Añadir nuev'.$sex ),
		'add_new_item' => __( 'Añadir nuev'.$sex.' '.$singular ),
		'edit' => __( 'Editar' ),
		'edit_item' => __( 'Editar '.$singular ),
		'new_item' => __( 'Nuev'.$sex.' '.$singular ),
		'view' => __( 'Ver '.$singular ),
		'view_item' => __( 'Ver '.$singular ),
		'search_items' => __( 'Buscar '.$singular ),
		'not_found' => __( 'No se han encontrado '.$plural ),
		'not_found_in_trash' => __( 'No se han encontrado '.$singular.' en la papelera' ),
		'parent' => __( $capsingular.' predecesor' )
	);
}

function add_menu_icons_styles(){
    ?>
    <style>
    	#adminmenu #menu-posts-question div.wp-menu-image:before { content: '\f209'; }
    </style>
	<?php 
} 
	
add_action( 'admin_head', 'add_menu_icons_styles' );

// GET SVG INLINE

function get_image($attachment_id){
	
	if(is_array($attachment_id)) $attachment_id = $attachment_id[0];
	
	if($attachment_id){
		if(getFileExt($attachment_id)=='svg'){
			$num = md5(round(rand()));
			$image_url = wp_get_attachment_url($attachment_id);
			$image_content = file_get_contents($image_url);
			if($image_content !== false AND !empty($image_content)) {
				$image_size = get_SVG_size($image_content);
				$width  = $image_size['w'];
				$height = $image_size['h'];
				$image_content = str_replace('<svg','<svg width="'.$width.'" height="'.$height.'"',$image_content);

				$image_content = str_replace('class="st','class="'.$num.'-st',$image_content);
				$image_content = str_replace('.st','.'.$num.'-st',$image_content);

				$image_content = str_replace('id="Capa_1" ','',$image_content);

				return $image_content;
			}else{
				return '<img src="'.get_bloginfo('template_url').'/images/blank.gif" data-img="'.$image_url.'">';
			}
		}else{
			$image = wp_get_attachment_image_src($attachment_id,'full');
			$image_width  = round($image[1]/2);
			$image_height = round($image[2]/2);
			return '<img src="'.get_bloginfo('template_url').'/images/blank.gif" data-img="'.$image[0].'" width="'.$image_width.'" height="'.$image_height.'">';
		}
	}else{
		return NULL;
	}
}
function the_image($attachment_id){
	echo get_image($attachment_id);
}
function getFileExt($attachment_id){
	$image_url = wp_get_attachment_url($attachment_id);
	$image = explode('.',$image_url);
	return end($image);
}
function get_SVG_size($image_content){
	$viewbox = get_string_between($image_content,'viewBox="','"');
	$viewbox = str_replace('0 0 ','',$viewbox);
	list($width,$height) = explode(' ', $viewbox);
	
	return array(
		'w' => round($width),
		'h' => round($height),
	);
}
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


?>
