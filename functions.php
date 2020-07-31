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


?>