<?php /** Functions file for TouchM theme. **/
//error_reporting (-1);
/********************* DEFINE MAIN PATHS ********************/
ob_start();
define('TouchM_PLUGINS',  get_template_directory() . '/plugins' ); // Shortcut to the /plugins/ directory

$adminPath 	=  get_template_directory() . '/library/admin/';
$funcPath 	=  get_template_directory() . '/library/functions/';
$incPath 	=  get_template_directory() . '/library/includes/';

global $al_options;
$al_options = isset($_POST['options']) ? $_POST['options'] : get_option('al_general_settings');
/************************************************************/


/*********** LOAD ALL REQUIRED SCRIPTS AND STYLES ***********/
function loadScripts()
{
	if( $GLOBALS['pagenow'] != 'wp-login.php' && !is_admin())
	{    
		wp_enqueue_style('foundation-styles',  get_template_directory_uri().'/css/foundation.min.css');
		wp_enqueue_style('foundation-app',  get_template_directory_uri().'/css/app.css');
		wp_enqueue_style('ui-styles', get_stylesheet_directory_uri().'/css/jquery-ui-1.9.2.css');
		wp_enqueue_style('main-styles', get_stylesheet_directory_uri().'/style.css');
		wp_enqueue_style('dynamic-styles',  get_template_directory_uri().'/css/dynamic-styles.php');
		wp_enqueue_style('jplayer-styles',  get_template_directory_uri().'/js/jplayer/skin/pink.flag/jplayer.pink.flag.css',false,'3.0.1','all');
		wp_enqueue_style('titan-styles',  get_template_directory_uri().'/plugins/titan/css/jquery.titanlighbox.css');
		
		wp_register_style('camera-styles',  get_template_directory_uri().'/sliders/camera/css/camera.css');
		wp_register_style('mirror-styles',  get_template_directory_uri().'/sliders/mirror/css/style.css');
		
		// Register or enqueue scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr', get_template_directory_uri() .'/js/modernizr.foundation.js', array('jquery'), '3.2', true);	
		wp_enqueue_script('foundation',  get_template_directory_uri(). '/js/foundation.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('titan-lightbox',  get_template_directory_uri(). '/plugins/titan/js/jquery.titanlighbox.js', array('jquery'), '3.2', true);
		wp_enqueue_script('titan-prettify',  get_template_directory_uri(). '/plugins/titan/js/prettify.js', array('jquery'), '3.2', true);
		wp_enqueue_script('isotope',  get_template_directory_uri(). '/js/jquery.isotope.min.js', array('jquery'), '3.2', true);
		
		wp_enqueue_script('tipsy',  get_template_directory_uri(). '/js/jquery.tipsy.js', array('jquery'), '3.2', true);
	  	wp_enqueue_script('carouFredSel',  get_template_directory_uri(). '/js/jquery.carouFredSel-6.1.0-packed.js', array('jquery'), '3.2', true);
		wp_enqueue_script('fitvid', get_template_directory_uri() .'/sliders/flex/js/jquery.fitvid.js', array('jquery'), '3.2', true);	
		wp_enqueue_script('flex-slider', get_template_directory_uri() .'/sliders/flex/js/jquery.flexslider-min.js', array('jquery'), '3.2', true);	
		wp_enqueue_script('froogaloop', get_template_directory_uri() .'/sliders/flex/js/froogaloop.js', array('jquery'), '3.2', true);	
		wp_enqueue_script('jplayer-audio',  get_template_directory_uri().'/js/jplayer/jquery.jplayer.min.js',array('jquery'));
		wp_enqueue_script('touchSwipe',  get_template_directory_uri(). '/js/jquery.touchSwipe.min.js', array('jquery'), '3.2', true);
		wp_enqueue_script('apphead',  get_template_directory_uri(). '/js/app-head.js', array('jquery'), '3.2', true);
		wp_enqueue_script('app',  get_template_directory_uri(). '/js/app.js', array('jquery'), '3.2', true);
		
		$al_options = get_option('al_general_settings'); 
		$slider = $al_options['al_active_slider'] !='' ? $al_options['al_active_slider'] : 'revolution';
		//$slider = isset($_GET['slider_type']) ? $_GET['slider_type'] : 'revolution';
		
		if($slider == 'revolution')
		{
			wp_enqueue_style('revolution-styles');
			//wp_enqueue_style('revolution-settings');
			wp_enqueue_script('revolution-slider', get_template_directory_uri() .'/sliders/revolution/js/jquery.themepunch.plugins.min.js', array('jquery'), '3.2', true);	
			wp_enqueue_script('revolution-misc', get_template_directory_uri() .'/sliders/revolution/js/jquery.themepunch.revolution.min.js', array('jquery'), '3.2', true);	
		}
		
		elseif($slider == 'camera')
		{
			wp_enqueue_script('camera-slider', get_template_directory_uri() .'/sliders/camera/js/camera.min.js');	
			wp_enqueue_script('camera-mobile', get_template_directory_uri() .'/sliders/camera/js/jquery.mobile.customized.min.js');
			wp_enqueue_style('camera-styles');			
		}
		
		elseif($slider == 'mirror')
		{
			wp_enqueue_script('mirror-slider', get_template_directory_uri() .'/sliders/mirror/js/jquery.eislideshow.js');	
			wp_enqueue_style('mirror-styles');			
		}

		if (is_page_template('contact-template.php')){
			$al_options = get_option('al_general_settings'); 
			if (!empty($al_options['al_contact_address']))
			{
				wp_enqueue_script('Google-map-api',  'http://maps.google.com/maps/api/js?sensor=false');
				wp_enqueue_script('Google-map',  get_template_directory_uri().'/js/gmap3.min.js');
			}
			
			wp_enqueue_script('Validate',  get_template_directory_uri().'/js/validate.js',array('jquery'));
		}		
		if (is_page_template('under-construction.php'))
		{
			wp_enqueue_script('Under-construction',  get_template_directory_uri().'/js/jquery.countdown.js');
		}
	}
}
add_action( 'wp_enqueue_scripts', 'loadScripts' ); //Load All Scripts

function touchm_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'pt-sans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext" );
}
add_action( 'wp_enqueue_scripts', 'touchm_fonts' );

/************************************************************/


/********************* DEFINE MAIN PATHS ********************/

require_once ($incPath . 'the_breadcrumb.php');
require_once ($incPath . 'OAuth.php');
require_once ($incPath . 'twitteroauth.php');
require_once ($incPath . 'portfolio_walker.php');
require_once ($funcPath . 'sidebar-generator.php');
require_once ($funcPath . 'options.php');
require_once ($funcPath . 'post-types.php');
require_once ($funcPath . 'widgets.php');
//require_once ($funcPath . 'shortcodes.php');
require_once ($funcPath . '/shortcodes/shortcode.php');


require_once ($adminPath . 'custom-fields.php');
require_once ($adminPath . 'scripts.php');
require_once ($adminPath . 'admin-panel/admin-panel.php');

// Redirect To Theme Options Page on Activation
if (is_admin() && isset($_GET['activated'])){
	wp_redirect(admin_url('admin.php?page=adminpanel'));
}

/************** ADD SUPPORT FOR LOCALIZATION ***************/

load_theme_textdomain( 'TouchM',  get_template_directory() . '/languages' );

	$locale = get_locale();

	$locale_file =  get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

/************************************************************/


/**************** ADD SUPPORT FOR POST THUMBS ***************/

add_theme_support( 'post-thumbnails');
add_theme_support( 'woocommerce' );
// Define various thumbnail sizes
//add_image_size('portfolio-thumb-3cols', 200, 176, true); 

add_image_size('portfolio-4-col', 210, 150, true);
add_image_size('portfolio-3-col', 290, 207, true); 
add_image_size('portfolio-2-col', 450, 321, true); 


add_image_size('blog-list1', 600, 320, true); 
add_image_size('blog-list2', 171, 171, true); 
add_image_size('blog-thumb', 100, 50, true);

/************************************************************/

$option_posts_per_page = get_option( 'posts_per_page' );
add_action( 'init', 'my_modify_posts_per_page', 0);
function my_modify_posts_per_page() {
    add_filter( 'option_posts_per_page', 'my_option_posts_per_page' );
}
function my_option_posts_per_page( $value ) {
    global $option_posts_per_page;
    if ( is_tax( 'portfolio_category') ) {
		$pageId = get_page_ID_by_page_template('portfolio-template.php');
		$custom =  get_post_custom($pageId);
		$items_per_page = isset ($custom['_page_portfolio_num_items_page']) ? $custom['_page_portfolio_num_items_page'][0] : '777';
        return $items_per_page;
    } else {
        return $option_posts_per_page;
    }
}

/************* ADD SUPPORT FOR WORDPRESS 3 MENUS ************/

add_theme_support( 'menus' );

//Register Navigations
add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
        array(
            'primary_nav' => __( 'Primary Navigation', 'TouchM'),
            'top_nav' => __( 'Top Navigation', 'TouchM'),
			'footer_nav' => __( 'Footer Navigation', 'TouchM')
        )
    );
}

// Custom menu walker for main navigation

class My_Walker extends Walker_Nav_Menu {
 
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $element->has_children = !empty($children_elements[$element->ID]);
        @$element->classes[] = ($element->current || $element->current_item_ancestor) ? 'active' : '';
        @$element->classes[] = ($element->has_children) ? 'has-dropdown' : '';
		@parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }	
	
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "\n<ul class=\"dropdown\">\n";
    }
    
}


/************************************************************/


/************* COMMENTS HOOK *************/

function TouchM_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class="avatar">
				<?php echo get_avatar($comment, $size='50', $default= "" ); ?>                 
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
            <p><em><?php _e('Your comment is awaiting moderation.', 'TouchM') ?></em></p>
            <?php endif; ?>
			<div class="comment-meta">
				<h5 class="author">
					<a href="<?php echo get_comment_author_link()?>" rel="external nofollow"><?php echo get_comment_author()?></a>
					<?php if($args['max_depth']!=$depth): ?>
						<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>                                
					<?php endif ?>
				</h5>
				<p class="date"><?php printf(__('%1$s at %2$s', 'TouchM'), get_comment_date(),get_comment_time()) ?></p>
				<?php edit_comment_link(__('(Edit)', 'TouchM'),'  ','') ?>
            </div>
            <div class="comment-body"><?php comment_text() ?></div>
		  </div>	
	<?php	
}

/*****************************************/


/************** FOOTER WIDGETS ************/

$al_options = get_option('al_general_settings'); 
$footer_widget_count = isset($al_options['al_footer_widgets_count']) ? $al_options['al_footer_widgets_count']:4;

for($i = 1; $i<= $footer_widget_count; $i++)
{
	unregister_sidebar('Footer Widget '.$i);
  	if ( function_exists('register_sidebar') )
	register_sidebar(array(
	  	'name' => 'Footer Widget '.$i,
		'id'	=> 'footer-sidebar-'.$i,
		'before_widget' => '<div class="four columns footer-block">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}

/*******************************************/


/********** GET PAGES BY PARAMS ************/

/*-- Get root parent of a page --*/
function get_root_page($page_id) 
{
	global $wpdb;
	
	$parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE post_type='page' AND ID = '$page_id'");
	
	if ($parent == 0) 
		return $page_id;
	else 
		return get_root_page($parent);
}


/*-- Get page name by ID --*/
function get_page_name_by_ID($page_id)
{
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = '$page_id'");
	return $page_name;
}


/*-- Get page ID by Page Template --*/
function get_page_ID_by_page_template($template_name)
{
	global $wpdb;
	$page_ID = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$template_name' AND meta_key = '_wp_page_template'");
	return $page_ID;
}

/*-- Get page content (Used for pages with custom post types) --*/
if(!function_exists('getPageContent'))
{
	function getPageContent($pageId)
	{
		if(!is_numeric($pageId))
		{
			return;
		}
		global $wpdb;
		$sql_query = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
		' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
		$posts = $wpdb->get_results($sql_query);
		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				return nl2br($post->post_content);
			}
		}
	}
}


/* -- Get page ID by Custom Field Value -- */
function get_page_ID_by_custom_field_value($custom_field, $value)
{
	global $wpdb;
	$page_ID = $wpdb->get_var("
	    SELECT wposts.ID
    	FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
	    WHERE wposts.ID = wpostmeta.post_id 
    	AND wpostmeta.meta_key = '$custom_field' 
	    AND (wpostmeta.meta_value like '$value,%' OR wpostmeta.meta_value like '%,$value,%' OR wpostmeta.meta_value like '%,$value' OR wpostmeta.meta_value = '$value')		
    	AND wposts.post_status = 'publish' 
	    AND wposts.post_type = 'page'
		LIMIT 0, 1");

	return $page_ID;
}
/*******************************************/


/********* PRE-GENERATED SIDEBARS **********/

if ( function_exists('register_sidebar') )
{	
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id'	=> 'global-sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-widget blog-sidebar %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
		'name' => 'Shop sidebar',
		'id'	=> 'shop-sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-widget shop-sidebar %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
	register_sidebar(array(
		'name' => 'Portfolio Sidebar',
		'id'	=> 'global-portfolio-sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-widget portfolio_sidebar %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="uppercase">',
        'after_title' => '</h4>',
    ));
	
	register_sidebar(array(
		'name' => 'Footer Top Sidebar',
		'id'   => 'footer-top-sidebar-1',
        'before_widget' => '<div id="%1$s" class="row content_bottom">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));
}

/*******************************************/


/********* STRING MANIPULATIONS ************/

function al_trim($text, $length, $end = '[...]') {
	$text = preg_replace('`\[[^\]]*\]`', '', $text);
	$text = strip_tags($text);
	$text = substr($text, 0, $length);
	$text = substr($text, 0, last_pos($text, " "));
	$text = $text . $end;
	return $text;
}

function last_pos($string, $needle){
   $len=strlen($string);
   for ($i=$len-1; $i>-1;$i--){
       if (substr($string, $i, 1)==$needle) return ($i);
   }
   return FALSE;
}

function limit_words($string, $word_limit) {
 
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character
 
	$words = explode(' ', $string);
 
	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
 
	return implode(' ', array_slice($words, 0, $word_limit)).'...';
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');

function shortcode_empty_paragraph_fix($content)
{   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	$content = str_replace( array( '<p></p>' ), '', $content );
    $content = str_replace( array( '<p>  </p>' ), '', $content );
	
	return $content;
}

function custom_tag_cloud_widget($args) {
	$args['number'] = 0; //adding a 0 will display all tags
	$args['largest'] = 18; //largest tag
	$args['smallest'] = 10; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/*******************************************/


/******* POSTS RELATED BY TAXONOMY *********/

function get_taxonomy_related_posts($post_id, $taxonomy, $limit, $args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id, $taxonomy);
  if (count($terms)) {
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, 
      'post__in' => $post_ids,
	  'exclude' => $post_id,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug,
	  'posts_per_page' => $limit
    ));
    $query = new WP_Query($args);
  }
  return $query;
}

/********************************************/

/*************  ENABLE SESSIONS *************/

function cp_admin_init() {
	if (!session_id())
	session_start();
}

add_action('init', 'cp_admin_init');

/********************************************/


/**************  GOOGLE FONTS ***************/

function font_name($string){
		
	$check = strpos($string, ':');
	if($check == false){
		return $string;
	} else { 
		preg_match("/([\w].*):/i", $string, $matches);
		return $matches[1];
	} 
} 

/********************************************/

add_theme_support( 'automatic-feed-links' );
if ( ! isset( $content_width ) ) $content_width = 960;
add_filter('the_excerpt', 'do_shortcode');


/************** LIST TAXONOMY ***************/

function list_taxonomy($taxonomy, $id='')
{
	$args = array ('hide_empty' => false);
	$tax_terms = get_terms($taxonomy, $args); 
	$active = '';
	$output = '<ul id="'.$id.'">';

	foreach ($tax_terms as $tax_term) {
		if ($taxonomy  == $tax_term)
		{
			$active  = ' class="active"';
		}
		$output.='<li><a href="'.esc_attr(get_term_link($tax_term, $taxonomy)) . '"'.$active.'>'.$tax_term->name.'</a></li>';
	}
	$output.='</ul>';
	
	return $output;
}

/********************************************/


/************* WOOCommerce HOOKS ************/

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
// Display 24 products per page. 

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 20 );
// Disable WooCommerce styles 
define('WOOCOMMERCE_USE_CSS', false);

/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 



add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'Re-enter Password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}
function wc_custom_lost_password_form( $atts ) {

    return wc_get_template( 'myaccount/form-lost-password.php', array( 'form' => 'lost_password' ) );

}
add_shortcode( 'lost_password_form', 'wc_custom_lost_password_form' );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

global $woocommerce;
function add_custom_prices($woocommerce){
	 // This will be your custome price  
    foreach ( $woocommerce->get_cart() as $key => $value ) {
    	$productId = $value['product_id'];
		$variation = $value['variation'];
		$variationId = $value['data']->variation_id;		
	 	 $price =  get_post_meta($variationId, '_price', true);	
		if((isset($variation['Length']) && isset($variation['Width'])) && (intval($variation['Length'])>0 &&  intval($variation['Width'])>0)){
		     
	 	    $nep= $price*intval($variation['Length'])*intval($variation['Width']);
	 	  
		 $value['data']->set_price($nep);
		    
		}
		//print_r($value);
		if( $value['cut-price'] ){
			$value['data']->set_price($value['cut-price']);
		}
	
    }
}

add_action( 'woocommerce_before_calculate_totals', 'add_custom_prices', 20, 1 );

?>