<?php
define ( 'JS_PATH' , get_template_directory_uri().'/library/functions/shortcodes/customcodes.js');


add_action('admin_head','html_quicktags');
function html_quicktags() {

	$output = "<script type='text/javascript'>\n
	/* <![CDATA[ */ \n";
	wp_print_scripts( 'quicktags' );

	$buttons = array();
	
	/*$buttons[] = array(
		'name' => 'raw',
		'options' => array(
			'display_name' => 'raw',
			'open_tag' => '\n[raw]',
			'close_tag' => '[/raw]\n',
			'key' => ''
	));*/
	
	$buttons[] = array(
		'name' => 'one_whole',
		'options' => array(
			'display_name' => 'Full width',
			'open_tag' => '\n[one_whole]',
			'close_tag' => '[/one_whole]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'one_third',
		'options' => array(
			'display_name' => 'one third',
			'open_tag' => '\n[one_third]',
			'close_tag' => '[/one_third]\n',
			'key' => ''
	));
		
	$buttons[] = array(
		'name' => 'two_third',
		'options' => array(
			'display_name' => 'two third',
			'open_tag' => '\n[two_third]',
			'close_tag' => '[/two_third]\n',
			'key' => ''
	));	
	
	$buttons[] = array(
		'name' => 'one_half',
		'options' => array(
			'display_name' => 'one half',
			'open_tag' => '\n[one_half]',
			'close_tag' => '[/one_half]\n',
			'key' => ''
	));	
	
	$buttons[] = array(
		'name' => 'one_fourth',
		'options' => array(
			'display_name' => 'one fourth',
			'open_tag' => '\n[one_fourth]',
			'close_tag' => '[/one_fourth]\n',
			'key' => ''
	));	
	
	$buttons[] = array(
		'name' => 'three_fourth',
		'options' => array(
			'display_name' => 'three fourth',
			'open_tag' => '\n[three_fourth]',
			'close_tag' => '[/three_fourth]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'one_sixth',
		'options' => array(
			'display_name' => 'one sixth',
			'open_tag' => '\n[one_sixth]',
			'close_tag' => '[/one_sixth]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'five_twelveth',
		'options' => array(
			'display_name' => 'five twelveth',
			'open_tag' => '\n[five_twelveth]',
			'close_tag' => '[/five_twelveth]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'seven_twelveth',
		'options' => array(
			'display_name' => 'seven twelveth',
			'open_tag' => '\n[seven_twelveth]',
			'close_tag' => '[/seven_twelveth]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'row',
		'options' => array(
			'display_name' => 'Insert Row',
			'open_tag' => '\n[row]',
			'close_tag' => '[/row]\n',
			'key' => ''
	));
	
	$buttons[] = array(
		'name' => 'clear',
		'options' => array(
			'display_name' => 'Clear Float',
			'open_tag' => '[clear /]',
			'close_tag' => '',
			'key' => ''
	));
			
	for ($i=0; $i <= (count($buttons)-1); $i++) {
		$output .= "edButtons[edButtons.length] = new edButton('ed_{$buttons[$i]['name']}'
			,'{$buttons[$i]['options']['display_name']}'
			,'{$buttons[$i]['options']['open_tag']}'
			,'{$buttons[$i]['options']['close_tag']}'
			,'{$buttons[$i]['options']['key']}'
		); \n";
	}
	
	$output .= "\n /* ]]> */ \n
	</script>";
	echo $output;
}

function touchm_custom_addbuttons() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_tcustom_tinymce_plugin");
		add_filter('mce_buttons_3', 'register_tcustom_button');
	}
}
function register_tcustom_button($buttons) {
	array_push(
		$buttons,
		"AddPanel",
		"AddButtons",
		"DropdownButtons",
		"Tabs",
		"Toggle",
		"Accordion",
		"Testimonial",
		"Blockquote",
		"|",		
		"highlight",
		"dropcap",
		"progress",
		"alert", 
		"|",
		"olist",
		"list",
		"|",
		"TPVideo",
		"Audio",
		"Video",
		"|",
		"Tooltip",
		"Slider",
		"Carousel",
		"Lightbox",
		"Team",
		"Contact",
		"Block",
		"divider",
		"|",
		"Portfoliolisting",
		"Bloglisting"
		); 
	return $buttons;
} 
function add_tcustom_tinymce_plugin($plugin_array) {
	$plugin_array['touchmShortCodes'] = JS_PATH;
	return $plugin_array;
}
add_action('init', 'touchm_custom_addbuttons');


/*************** SOCIAL BUTTONS *****************/

add_shortcode( 'social', 'al_social' );
function al_social( $atts, $content ){
	$GLOBALS['sb_count'] = 0;
	do_shortcode( $content );
	if( is_array( $GLOBALS['buttons'] ) ){
		foreach( $GLOBALS['buttons'] as $sb ){
			$panes[] = '<li><a class="has-tipsy" href="'.$sb['url'].'" title="'.$sb['title'].'" target="'.$sb['target'].'"><img src="'.$sb['icon'].'" alt="Twitter"></a></li>';
		}
		
		$return = '<ul class="top_social">'.implode( "\n", $panes ).'</ul><div class="clear"></div>';	
	}
	return $return; //do_shortcode('[raw]'.$return.'[/raw]');
}

add_shortcode('social_button', 'al_socialbutton');

function al_socialbutton( $atts, $content ){
	extract(shortcode_atts(array(
		"name"	=> '',
		"url" 	=> '#', 
		"title"	=> '',
		"target" => '_blank',
		"icon" => ''
	), $atts));
	
	$title = isset($title) && $title != '' ? $title : $name;
	$predefined = array('facebook', 'twitter', 'dribble', 'flickr', 'vimeo', 'rss', 'linkedin', 'google');
	$icon = in_array($name, $predefined) ? get_template_directory_uri().'/images/social/'.$name.'.png' : $icon.'' ;
	
	$x = $GLOBALS['sb_count'];
	$GLOBALS['buttons'][$x] = array('title' => $title, 'content' =>  $content, 'name' => $name, 'url'=> $url, 'target'=>$target, 'icon' => $icon);	
	$GLOBALS['sb_count']++;

}
	
/**************************************************/


/********************* PANEL **********************/

function al_panel( $atts, $content = null ) {
    extract(shortcode_atts(array(
		"title" => '',
		"type" => '' 
	), $atts));	
	$out = '<div class="panel '.$type.'">
		<h5>'.$title.'</h5>
		<p>' .do_shortcode($content). '</p>
	</div>';
    return $out;
}
add_shortcode('panel', 'al_panel');

/**************************************************/


/***************** PROGRESS BAR *******************/

function al_progressbar( $atts, $content = null ) {
    extract(shortcode_atts(array(
		"type" => '',
		"meter" => '',
		"shape" => '',
		"class" => '',
	), $atts));	
	$out = '<div class="'.$shape.' progress '.$type.' '.$class.'"><span class="meter progress'.$meter.'"></span></div>';
    return $out;
}
add_shortcode('progressbar', 'al_progressbar');

/************************************************/


/*************** TESTIMONIALS ********************/
function al_testimonial( $atts, $content = null ) {
    extract(shortcode_atts(array(
		"authorname"	=> '',
		"authorurl" 	=> '#', 
		"authorposition"	=> ''
	), $atts));

	$out = '<div class="testimonial-item"><div class="testimonial-content"><p>'.do_shortcode($content).'</p></div><p><a href="'.$authorurl.'">'.$authorname.'</a> - '.$authorposition.'</p></div>';
    return $out;
}
add_shortcode('testimonial', 'al_testimonial');

/************************************************/


/*************** CHECK LOGGED IN ****************/

function touchm_is_logged_in( $atts, $content = null ) {
	global $user_ID ;
	if( $user_ID )
		return do_shortcode($content) ;
}
add_shortcode('is_logged_in', 'touchm_is_logged_in');

/************************************************/


/************** PORTFOLIO WORKS *****************/

function al_list_portfolio($atts, $content = null) {
    extract(shortcode_atts(array(
            "title" => 'Recent Work',
			"limit" => 6,
			"featured" => 0
    ), $atts));
 	global $post;
	$return = '';
    $counter = 1; 
	$args = array('post_type' => 'portfolio', 'taxonomy'=> 'portfolio_category', 'showposts' => $limit, 'posts_per_page' => $limit, 'orderby' => 'date','order' => 'DESC');
	
	if ($featured)
	{
		$args['meta_key'] = '_portfolio_featured'; 
		$args['meta_value'] = '1';
	}
	
   	$query = new WP_Query($args);
	
	$return.='
	<div class="row">
        <div class="twelve columns">
			<h3>'.$title.'</h3>
			<div class="list_carousel">
				<div class="carousel_nav">
					<a class="prev" id="car_prev" href="#"><span>prev</span></a><a class="next" id="car_next" href="#"><span>next</span></a>
				</div>
				<div class="clearfix"></div>
				<ul id="carousel-works">';
					while ($query->have_posts())  : $query->the_post(); 
					$custom = get_post_custom($post->ID);  					
					$return.='
					<li>
						<div class="work-item contentHover">                                                            
							<div class="content"> 
								<div class="work-item-image">'.get_the_post_thumbnail($post->ID, 'portfolio-4-col', array('class' => 'cover')).'</div>	
								<div class="work-item-content"><h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4><p>'.limit_words(get_the_excerpt(), 10).'</p></div>            
							</div>
							<div class="hover-content">
								<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>                                    
								<p>'.limit_words(get_the_excerpt(), 12).'</p>
								<div class="hover-links">';
								    if( !empty ( $custom['_portfolio_video'][0] ) ) :
										$return.= '<a href="'.$custom['_portfolio_video'][0].'" title="'.get_the_title().'" class="titan-lb view-image" data-titan-group="gallery"></a>';
									elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : 
										$return.= '<a href="'.$custom['_portfolio_link'][0].'" class="view-item" title="'.get_the_title().'"></a>';
									elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) :
										$return.= '<a href="'.get_permalink().'" title="'.get_the_title().'" class="view-item"></a>';
									else : 
										$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
										$return.= '<a href="'.$full_image[0].'" class="titan-lb view-image" title="'.get_the_title().'"  data-titan-group="gallery"></a>';
									endif;                            
							$return.='</div></div></div>';
					$return.='</li>';
					endwhile; wp_reset_query();
					$return.='</ul><div class="clearfix"></div></div></div></div>';
	return $return;
	
}
add_shortcode("list_portfolio", "al_list_portfolio");
 
/************************************************/


/*********** THIRD PARTY VIDEOS  ****************/

function al_tpvideo($atts, $content=null) {
	extract(
		shortcode_atts(array(
			'site' => 'youtube',
			'id' => '',
			'width' => '580',
			'height' => '315',
			'autoplay' => '0'
		), $atts)
	);
	if ( $site == "youtube" ) { $src = 'http://www.youtube.com/embed/'.$id.'?autoplay='.$autoplay; }
	else if ( $site == "vimeo" ) { $src = 'http://player.vimeo.com/video/'.$id.'?autoplay='.$autoplay; }
	else if ( $site == "dailymotion" ) { $src = 'http://www.dailymotion.com/embed/video/'.$id.'?autoplay='.$autoplay; }
	else if ( $site == "veoh" ) { $src = 'http://www.veoh.com/static/swf/veoh/SPL.swf?videoAutoPlay='.$autoplay.'&permalinkId='.$id; }
	else if ( $site == "bliptv" ) { $src = 'http://a.blip.tv/scripts/shoggplayer.html#file=http://blip.tv/rss/flash/'.$id; }
	else if ( $site == "viddler" ) { $src = 'http://www.viddler.com/embed/'.$id.'e/?f=1&offset=0&autoplay='.$autoplay; }
	
	if ( $id != '' ) {
		return '<div class="flex-video widescreen"><iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" class="vid iframe-'.$site.'"></iframe></div>';
	}
}
add_shortcode('tpvideo','al_tpvideo');

/************************************************/


/************ LOCAL AUDIO (HTML 5) **************/

function al_audio($atts, $content = null) {
    extract(shortcode_atts(array(
            "title" => '',
			"poster" => '',
			"m4a"  => '',
			"mp3"  => '',
			"ogg"	=> ''			
    ), $atts));
 	
	$poster = ($poster == '') ? get_template_directory_uri().'/images/music.jpg' : $poster;
	$randomId = mt_rand(0, 100000);  
	$return = '	<script type="text/javascript">jQuery(document).ready(function($){
		$("#jquery_jplayer_'.$randomId.'").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					m4a: "'.$m4a.'",
					mp3: "'. $mp3 .'",
					oga: "'.$ogg.'",
					poster: "'.$poster.'"
				});
			},
			play: function() { // To avoid both jPlayers playing together.
				$(this).jPlayer("pauseOthers");
			},
			repeat: function(event) { // Override the default jPlayer repeat event handler
				if(event.jPlayer.options.loop) {
					$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
					$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
						$(this).jPlayer("play");
					});
				} else {
					$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
					$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
						$("#jquery_jplayer_'.$randomId.'").jPlayer("play", 0);
					});
				}
			},
			swfPath: "'.get_template_directory_uri().'/js/jplayer",
			supplied: "m4a, oga",
			wmode: "window",
			size: {width: "100%",height: "auto",cssClass: "jp-audio-standard"},
			cssSelectorAncestor: "#jp_container_'.$randomId.'"
		});
			});
		</script>';
		
		$return.= '	
		<div class="singlesong six columns">     
			<div id="jquery_jplayer_'.$randomId.'" class="jp-jplayer"></div>           
			<div id="jp_container_'.$randomId.'" class="jp-audio">
				<div class="jp-type-single">
					<div class="jp-gui jp-interface">
						<ul class="jp-controls">
							<li><a href="javascript:;" class="jp-play" tabindex="1">play></a></li>
							<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
							<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
							<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
							<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
							<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
						</ul>
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
						<div class="jp-time-holder">
							<div class="jp-current-time"></div>
							<div class="jp-duration"></div>
	
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
					</div>
					<div class="jp-title">
						<ul>
							<li>'.$title.'</li>
						</ul>
					</div>
					<div class="jp-no-solution">
						<span>Update Required</span>
						To play the media you will need to either update your browser to a recent version or update your Flash plugin.
					</div>
				</div>
			</div>
		</div>';
	return $return;
	
}
add_shortcode("audio", "al_audio"); 

/************************************************/


/************ LOCAL VIDEO (HTML 5) **************/

function al_video($atts, $content = null) {
    extract(shortcode_atts(array(
            "title" => '',
			"poster" => '',
			"m4v"  => '',
			"mp4"  => '',
			"ogv"	=> ''			
    ), $atts));
 	
	$poster = ($poster == '') ? get_template_directory_uri().'/images/video.jpg' : $poster;
	$randomId = mt_rand(0, 100000);  
	$return = '<script type="text/javascript">jQuery(document).ready(function($){
			$("#jquery_jplayer_'.$randomId.'").jPlayer({
				option: {"fullscreen": true},
				ready: function () {
					$(this).jPlayer("setMedia", {
						m4v: "'.$m4v.'",
						mp4: "'.$mp4.'",
						ogv: "'.$ogv.'",
						poster: "'.$poster.'"
					});
				},
				play: function() { // To avoid both jPlayers playing together.
					$(this).jPlayer("pauseOthers");
				},
				repeat: function(event) { // Override the default jPlayer repeat event handler
					if(event.jPlayer.options.loop) {
						$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
						$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
							$(this).jPlayer("play");
						});
					} else {
						$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
						$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
							$("#jquery_jplayer_'.$randomId.'").jPlayer("play", 0);
						});
					}
				},
				swfPath: "'.get_template_directory_uri().'/js/jplayer",
				supplied: "ogv, m4v",
				size: {width: "100%",height: "auto",cssClass: "jp-video-standard"},
				cssSelectorAncestor: "#jp_container_'.$randomId.'"
			});
		});
	</script>';
	
	$return.= '	
	<div class="singlesong featured-image">
		<div id="jp_container_'.$randomId.'" class="jp-video jp-video-standard filterable-2col-videowrap">
			<div class="jp-type-single">
				<div id="jquery_jplayer_'.$randomId.'" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
					</div>
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
								<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-title">
							<ul>
								<li>'.$title.'</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your Flash plugin.
				</div>
			</div>
		</div>
	</div>';
	return $return;	
}
add_shortcode("video", "al_video"); 

/************************************************/


/******************** Tooltips *******************/

function al_tooltip( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"text" => '',
		"position" => '' 
	), $atts));	
	$out = '<span class="has-tip '.$position.'" data-width="90" title="'.$content.'">'.do_shortcode($text).'</span>';
   return $out;
}
add_shortcode('tooltip', 'al_tooltip');

/************************************************/


/******************* Alertbox *******************/

function al_alert( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"type" => ''
	), $atts));	
	$out = '<div class="alert-box '.$type.'">'.do_shortcode($content).'<a href="" class="close">&times;</a></div>';
   return $out;
}
add_shortcode('alert', 'al_alert');

/************************************************/


/*************** Contact details ****************/

function al_contact( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"address" => '',
		"tel" => '',
		"email" => '',
		"skype" => ''
	), $atts));	
	$out = '<p>'.do_shortcode($content).'</p>
	<ul class="vcard">';
		if ($address) $out.='<li class="address">'.$address.'</li>';
		if ($tel) $out.='<li class="tel">'.$tel.'</li>';
		if ($email) $out.='<li class="email"><a href="mailto:'.$email.'">'.$email.'</a></li>';
		if ($skype) $out.='<li class="skype">'.$skype.'</li>';
	$out.='</ul>';
   return $out;
}
add_shortcode('contact', 'al_contact');

/************************************************/


/************* IMAGE IN LIGHTBOX ****************/

function al_lightbox( $atts, $content = null)
{
   extract(shortcode_atts(array(
		'thumb'	=> '',
		'full'	=> '',
		'title' => '',
		'group' => ''
	), $atts));	
	
	$return='
	<div class="portfolio-item">
		<div class="image-overlay"> 
			<a href="'.$full.'" class="titan-lb" title="'.$title.'"  data-titan-group="'.$group.'"><img src="'.$thumb.'" alt="'.$title.'" /><span class="overlay-icon item-zoom"></span></a>
		</div>
		<div class="portfolio-item-content"><p>'.do_shortcode($content).'</p></div>
	</div>';
	
   return $return;
}
add_shortcode('lightbox', 'al_lightbox');

/************************************************/


/***************** HIGHLIGHT ********************/

function touchm_highlight_shortcode( $atts, $content = null ) {  
    return '<span class="highlight">'.$content.'</span>';  
}  
add_shortcode("highlight", "touchm_highlight_shortcode");  

/************************************************/


/******************* DROPCAP ********************/

function al_dropcap( $atts, $content = null ) {  
    return '<span class="dropcap">'.$content.'</span>';  
}  
add_shortcode("dropcap", "al_dropcap");  

/************************************************/


/********* STANDARD UNORDERED LISTS *************/

function al_list($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' 	=> 'disc'
	), $atts));
	
	return '<ul class="'.$type.'">'.do_shortcode($content).'</ul>';
}
add_shortcode('list', 'al_list');

/************************************************/


/********* STANDARD ORDERED LISTS *************/

function al_olist($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' 	=> '1',	
	), $atts));

	return '<ol class="ol-type'.$type.'">'.$content.'</ol>';
}
add_shortcode('olist', 'al_olist');

/************************************************/


/**************** BLOCKQUOTES *******************/

function al_blockquote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'author' => '',
	), $atts));


	$out = '<blockquote>'.do_shortcode($content).'<cite>'.$author.'</cite></blockquote>';
	return $out;
}
add_shortcode('blockquote', 'al_blockquote');

/************************************************/


/******************** TABS **********************/

add_shortcode( 'tabgroup', 'al_tab_group' );
function al_tab_group( $atts, $content ){
	extract(shortcode_atts(array(
		'size' => ''
	), $atts));
	$GLOBALS['tab_count'] = 0;
	$randomId = mt_rand(0, 100000);
	$class='';
	do_shortcode( $content );
	$counter = 1;
	if( is_array( $GLOBALS['tabs'] ) ){
		foreach( $GLOBALS['tabs'] as $tab ){
			$finalCounter = $randomId+$counter;
			$class = ($counter == 1) ? 'class="active"' : '';
				
			$tabs[] = '<dd '.$class.'><a href="#tab'.$finalCounter.'">'.$tab['title'].'</a></dd>';
			$panes[] = '<li '.$class.' id="tab'.$finalCounter.'Tab">'.do_shortcode($tab['content']).'</li>';
			$counter ++;
		}
		$return = "\n".'<dl class="tabs '.$size.'">'.implode( "\n", $tabs ).'</dl>'."\n".'<ul class="tabs-content">'.implode( "\n", $panes ).'</ul><div class="clear"></div>'."\n";
	}
	return $return;
}

add_shortcode( 'tab', 'al_tab' );

function al_tab( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'Tab %d',
	), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );
	
	$GLOBALS['tab_count']++;
}
/************************************************/


/******************  BLOCKS *********************/

function al_block( $atts, $content = null)
{
	extract(shortcode_atts(array(
		'type' => '1',
		'icon' => 'service-responsive',
		'title' => '',
		'url'	=> '#'
	), $atts));	
	
	$out='';	
	
	if ($type == 1)
	{
		$out='<div class="service"><div class="service-icon"><a href="'.$url.'"><i class="'.$icon.' icon-4x"></i></a></div><h2 class="service-main">'.$title.'</h2><p class="service-sub">'.do_shortcode($content).'</p></div>';
	}
	
	if ($type == 2)
	{
		$out='<div class="service-block"><div class="service-block-icon"><a href="'.$url.'"><i class="'.$icon.'"></i></a></div><div class="service-block-content"><h4>'.$title.'</h4><p>'.do_shortcode($content).'</p></div></div>';
	}

	return $out;
}
add_shortcode('block', 'al_block');

/************************************************/


/*************** Dropdown buttons ***************/

add_shortcode( 'dropbuttongroup', 'al_dropbutton_group' );
function al_dropbutton_group( $atts, $content ){
	extract(shortcode_atts(array(
		'title' => '',
		'type'	=> ''
	), $atts));
	$GLOBALS['dropbutton_count'] = 0;
	$randomId = mt_rand(0, 100000);
	
	do_shortcode( $content );
	$counter = 1;
	if( is_array( $GLOBALS['dropbuttons'] ) ){
		foreach( $GLOBALS['dropbuttons'] as $dropbutton ){
			$dropbuttons[] = '<li><a href="'.$dropbutton['url'].'">'.do_shortcode($dropbutton['content']).'</a></li>';
			if ($dropbutton['divider'] == 1)
			{
				$dropbuttons[] = '<li class="divider"></li>';
			}
		}
		$return = "\n".'<div class="button '.$type.' dropdown">';
		if ($type == 'split')
		{
			$return.='<a href="#">'.$title.'</a><span></span>';
		}
		else
		{	
			$return.= $title;
		}
		$return.= '<ul class="no-hover" style="top: 38px;">'.implode( "\n", $dropbuttons ).'</ul>';
		$return.= '</div>';
	}
	return $return;
}

add_shortcode( 'dropbutton', 'al_dropbutton' );

function al_dropbutton( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => '',
	'url' => '',
	'divider' => '',
	), $atts));
	
	$x = $GLOBALS['dropbutton_count'];
	$GLOBALS['dropbuttons'][$x] = array( 'title' => $title, 'url' => $url, 'divider' => $divider, 'content' =>  $content );
	
	$GLOBALS['dropbutton_count']++;
}
/************************************************/


/****************** TOGGLES *********************/

add_shortcode( 'togglegroup', 'al_toggle_group' );
function al_toggle_group( $atts, $content ){
	
	$GLOBALS['toggle_count'] = 0;
	
	do_shortcode( $content );
	if( is_array( $GLOBALS['toggles'] ) ){
		foreach( $GLOBALS['toggles'] as $toggle ){
			$toggles[] = '<li>
				<h2>'.$toggle['title'].'</h2><span><i class="icon-plus"></i></span>                  
				<div class="toggle-content">
					'.do_shortcode($toggle['content']).'
				</div>                  
			</li>';	
		}
		$return = '<ul class="toggle-view">'.implode( "\n", $toggles ).'</ul>';
	}
	return $return;
}

add_shortcode( 'toggle', 'al_toggle' );

function al_toggle( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'toggle %d',
	), $atts));
	
	$x = $GLOBALS['toggle_count'];
	$GLOBALS['toggles'][$x] = array( 'title' => sprintf( $title, $GLOBALS['toggle_count'] ), 'content' =>  $content );
	
	$GLOBALS['toggle_count']++;
}
/************************************************/


/***************** ACCORDION ********************/

add_shortcode( 'accordiongroup', 'al_accordion_group' );
function al_accordion_group( $atts, $content ){
	
	$GLOBALS['accordion_count'] = 0;
	
	do_shortcode( $content );
	if( is_array( $GLOBALS['accordions'] ) ){
		foreach( $GLOBALS['accordions'] as $accordion ){
			$accordions[] = '<li>
				<h5 class="accordion-title">'.$accordion['title'].'<span class="accordion-icon"></span></h5>                 
				<div class="accordion-content" style="display: none;">
					'.do_shortcode($accordion['content']).'
				</div>                  
			</li>';	
		}
		$return = '<ul class="accordion">'.implode( "\n", $accordions ).'</ul>';
	}
	return $return;
}

add_shortcode( 'accordion', 'al_accordion' );

function al_accordion( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'accordion %d',
	), $atts));
	
	$x = $GLOBALS['accordion_count'];
	$GLOBALS['accordions'][$x] = array( 'title' => sprintf( $title, $GLOBALS['accordion_count'] ), 'content' =>  $content );
	
	$GLOBALS['accordion_count']++;
}
/************************************************/


/****************** SLIDER ********************/

add_shortcode('slider', 'al_slider' );
function al_slider( $atts, $content ){
	$GLOBALS['slideritem_count'] = 0;
	extract(shortcode_atts(array(
		'interval' => '4000'
	), $atts));
	do_shortcode( $content );
		
	if( is_array( $GLOBALS['sitems'] ) ){
		$icount = 0;
		foreach( $GLOBALS['sitems'] as $item ){
			$panes[] = '<li data-thumb="'.$item['image'].'"><img src="'.$item['image'].'" alt="'.$item['title'].'"/></li>';   		
			$icount ++ ;
		}
		$randomId = mt_rand(0, 100000);
		$return ='<div class="article_media"><div class="simple-slider flexslider" id="flex-'.$randomId.'"><ul class="slides">'.implode( "\n", $panes ).'</ul></div></div>
		<script type="text/javascript">
			jQuery(window).load(function() {
				jQuery("#flex-'.$randomId.'").fitVids().flexslider({
					slideshowSpeed: '.$interval.',  
					animation: "slide",controlNav: "thumbnails",
					start: function(slider){ jQuery("body").removeClass("loading");}
				});
			});
		</script>';	
	}
	return $return;
}


add_shortcode( 'slideritem', 'al_slideritem' );

function al_slideritem( $atts, $content ){
	extract(shortcode_atts(array(
		'image' => '',
		'title' => '',
	), $atts));
	
	$x = $GLOBALS['slideritem_count'];
	$GLOBALS['sitems'][$x] = array( 'image' => $image, 'title' => $title, 'content' =>  $content );
	
	$GLOBALS['slideritem_count']++;
	
}
/************************************************/


/******************* BUTTONS ********************/

function al_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'size' => 'medium',
		'type' => 'square',
		'color' => '',
		'link' => '#',
		'target' => '',
	), $atts));

	$target = ($target) ? ' target="_blank"' : '';

	$out = '<a href="'.$link.'"'.$target.' class="button '.$size.' '.$color.' '.$type.'">' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('button', 'al_button');

/************************************************/


/*************** TEAM MEMBERS ******************/

function al_teammember( $atts, $content = null)
{
   extract(shortcode_atts(array(
		'photo'	=> '',
		'name'	=> '#',
		'position' => '',
		'twitterurl' => '',
		'facebookurl' => '',
		'linkedinurl' => '',
	), $atts));	
	
	$out='<div class="member-info">                                                
		<div class="img_default"><img src="'.$photo.'" alt="'.$name.'"></div>
		<h2 class="member-name">'.$name.'</h2>
		<p class="member-possition">'.$position.'</p>
		<p class="member-description">'.do_shortcode($content).'</p>
		<ul class="member-social">';
		
			if($twitterurl) $out.='<li><a href="'.$twitterurl.'"><i class="icon-twitter icon20"></i></a></li>';
			if($facebookurl) $out.='<li><a href="'.$facebookurl.'"><i class="icon-facebook icon20"></i></a></li>';
			if($linkedinurl) $out.='<li><a href="'.$linkedinurl.'"><i class="icon-linkedin icon20"></i></a></li>';
		$out.='</ul>
	</div>';
	
   return $out;
}
add_shortcode('teammember', 'al_teammember');

/************************************************/


/******************* DIVIDER ********************/

function al_divider( $atts, $content = null ) {
	$out ='<div class="row"><div class="twelve columns"><hr/></div></div>';
   return $out;
}
add_shortcode('divider', 'al_divider');

/************************************************/


/******************* COLUMNS ********************/

function touchm_one_whole( $atts, $content = null ) {
   return '<div class="twelve columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_whole', 'touchm_one_whole');

function touchm_one_third( $atts, $content = null ) {
   return '<div class="four columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'touchm_one_third');

function touchm_two_third( $atts, $content = null ) {
   return '<div class="eight columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'touchm_two_third');

function touchm_one_half( $atts, $content = null ) {
   return '<div class="six columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'touchm_one_half');

function touchm_one_fourth( $atts, $content = null ) {
   return '<div class="three columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'touchm_one_fourth');

function touchm_three_fourth( $atts, $content = null ) {
   return '<div class="nine columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'touchm_three_fourth');

function touchm_one_sixth( $atts, $content = null ) {
   return '<div class="two columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'touchm_one_sixth');

function touchm_five_twelveth( $atts, $content = null ) {
   return '<div class="five columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_twelveth', 'touchm_five_twelveth');

function touchm_seven_twelveth( $atts, $content = null ) {
   return '<div class="seven columns">' . do_shortcode($content) . '</div>';
}
add_shortcode('seven_twelveth', 'touchm_seven_twelveth');

function touchm_row( $atts, $content = null ) {
   return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode('row', 'touchm_row');

/************************************************/


/***************** LIST PAGES *******************/

function al_list_pages($atts, $content, $tag) {
	global $post;
		
	// set defaults
	$defaults = array(
	    'class'       => $tag,
	    'depth'       => 0,
	    'show_date'   => '',
	    'date_format' => get_option('date_format'),
	    'exclude'     => '',
	    'child_of'    => 0,
	    'title_li'    => '',
	    'authors'     => '',
	    'sort_column' => 'menu_order',
	    'link_before' => '',
	    'link_after'  => '',
	    'exclude_tree'=> ''
	);
	
	
	$atts = shortcode_atts($defaults, $atts);
	
	
	$atts['echo'] = 0;
	if($tag == 'child-pages')
		$atts['child_of'] = $post->ID;	

	// create output
	$out = wp_list_pages($atts);
	if(!empty($out))
		$out = '<ul class="'.$atts['class'].'">' . $out . '</ul>';
	
  return $out;
}

add_shortcode('child-pages', 'al_list_pages');
add_shortcode('list-pages', 'al_list_pages');

/************************************************/


/****** SHOW POSTS BY CATEGORY AND COUNT ********/

function al_list_posts( $atts )
{
	extract( shortcode_atts( array(
		'title' => 'Latest from the blog',
		'type' => '1',
		'category' => '',
		'limit' => '5',
		'order' => 'DESC',
		'orderby' => 'date',
	), $atts) );

	$return = '';

	$query = array();

	if ( $category != '' )
		$query[] = 'category=' . $category;

	if ( $limit )
		$query[] = 'numberposts=' . $limit;

	if ( $order )
		$query[] = 'order=' . $order;

	if ( $orderby )
		$query[] = 'orderby=' . $orderby;

	$posts_to_show = get_posts( implode( '&', $query ) );

	$return = '';
	
	if ($type == 1)
	{
		$counter = 1;
		$return.='
		<h3>'.$title.'</h3>
		<div class="list_carousel bottom0">
			<div class="carousel_nav">
			<a class="prev" id="car_prev2" href="#"><span>'.__('prev', 'TouchM').'</span></a>
			<a class="next" id="car_next2" href="#"><span>'.__('next', 'TouchM').'</span></a>
			</div>
			<div class="clearfix"></div>
			<ul class="carousel-type2 bloglist-carousel">';
				foreach ($posts_to_show as $ps) 
				{
					$day = get_the_time('d', $ps->ID);
					$month = get_the_time('M', $ps->ID);
					if ($counter ==1) $return.='<li>';
					$return.='<div class="carousel-content recent-post"><div class="three mobile-one columns post-date-type1"><div class="post-date-day">'.$day.'</div><div class="post-date-month">'.$month.'</div></div><div class="nine mobile-three columns columns"><h4>'.$ps->post_title.'</h4>                                                                 <p>'.limit_words($ps->post_excerpt, 15).'</p><a href="'.get_permalink( $ps->ID ).'">'.__('Read More', 'TouchM').' <i class="icon-circle-arrow-right"></i></a></div></div>'; 
					if ($counter >1 && $counter % 2 == 0) $return.='</li><li>';
					$counter ++;
				}
			$return.='</li></ul></div>';                
	}
	else
	{
		$return.='
		<h3>'.$title.'</h3>
        <div class="row">';
			foreach ($posts_to_show as $ps) 
			{
				$thumbnail = has_post_thumbnail ($ps->ID) ? get_the_post_thumbnail( $ps->ID, 'portfolio-4-col') : '<img src="'.get_template_directory_uri().'/images/picture.jpg" alt="'.__('No Image', 'TouchM').'" style="width:171px; height:122px !Important" />';
				$return.='<div class="four columns">
					<div class="recent-post">
						<div class="img_default"><a href="'.get_permalink( $ps->ID ).'">'.$thumbnail.'</a></div>
						<h4><a href="'.get_permalink( $ps->ID ).'">'.$ps->post_title.'</a></h4>
						<div class="article_meta"><ul class="link-list"><li class="post-date "><span class="icon-calendar"></span><a href="'.get_permalink( $ps->ID ).'">'.get_the_time('F d, Y', $ps->ID).'</a></li></ul></div> 
						<p>'.limit_words($ps->post_excerpt, 10).'</p><a href="'.get_permalink( $ps->ID ).'">'.__('Read More ', 'TouchM').'<i class="icon-circle-arrow-right"></i></a></div></div>';
			}
		$return.='</div>';
	}
	return $return;
}

add_shortcode('list_posts', 'al_list_posts');

/************************************************/


/*************** Carousel Slider ****************/

/*************** Carousel Slider ****************/


function alc_carousel( $atts, $content ){
	$GLOBALS['caritem_count'] = 0;
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '',
		'automatic' => 'false',
		'min' => '1',
		'max' => '6'
	), $atts));
	$randomId = mt_rand(0, 100000);
	$panes = array();	
	$return = '';
	do_shortcode ($content);
	if(isset( $GLOBALS['caritems']) && is_array( $GLOBALS['caritems'] ) ){
		$return.='	
		<h3>'.$title.'</h3>
		<div class="list_carousel">
			<div class="carousel_nav">
				<a class="prev" id="car_prev'.$randomId.'" href="#"><span>'.__('prev', 'TouchM').'</span></a>
				<a class="next" id="car_next'.$randomId.'" href="#"><span>'.__('next', 'TouchM').'</span></a>
			</div>
			<div class="clearfix"></div>
			<ul class="work_slide'.$randomId.'" id="'.$type.'">';
				foreach( $GLOBALS['caritems'] as $item ){
					$panes[] = '<li>'.$item['content'].'</li>';   		
				}		
				$return.=implode( "\n", $panes ).'
			</ul>
		 </div>';
		$return.="
		<script type=\"text/javascript\">
			jQuery(window).load(function(){
				jQuery('.work_slide".$randomId."').carouFredSel({
					responsive: true,
					width: '100%',
					auto: {play: ".$automatic."},
					circular	: false,
					infinite	: true,
					prev : {button: \"#car_prev".$randomId."\", key	: \"left\"},
					next : {button	: \"#car_next".$randomId."\", key : \"right\"},
					swipe: {onMouse: true, onTouch: true},
					items: {visible: {min: ".$min.",max: ".$max."}
					}
				});
			});
		</script>";
	}
	return $return;
}

add_shortcode('carousel', 'alc_carousel' );

add_shortcode( 'caritem', 'al_caritem' );

function al_caritem( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => '',
	), $atts));
	$x = $GLOBALS['caritem_count'];
	$GLOBALS['caritems'][$x] = array('title' => $title, 'content' =>  do_shortcode ($content) );
	$GLOBALS['caritem_count']++;	
}

/************************************************/


/***************** CLEAR ************************/

function al_clear($atts, $content = null) {	
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'al_clear');

/************************************************/


/************* SITEMAP GENERATOR ****************/

function al_sitemap($atts, $content = null) {
	extract(shortcode_atts(array(  
		'menu'            => 'primary_nav', 
		'container'       => 'div', 
		'container_class' => 'sitemap', 
		'container_id'    => '', 
		'menu_class'      => 'primary-navigation', 
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => '',
		'theme_location'  => ''), 
		$atts));
 
 
	return wp_nav_menu( array( 
		'menu'            => $menu, 
		'container'       => $container, 
		'container_class' => $container_class, 
		'container_id'    => $container_id, 
		'menu_class'      => $menu_class, 
		'menu_id'         => $menu_id,
		'echo'            => false,
		'fallback_cb'     => $fallback_cb,
		'before'          => $before,
		'after'           => $after,
		'link_before'     => $link_before,
		'link_after'      => $link_after,
		'depth'           => $depth,
		'walker'          => $walker,
		'theme_location'  => $theme_location));
}
add_shortcode('sitemap', 'al_sitemap');

/************************************************/


/******** SHORTCODE SUPPORT FOR WIDGETS *********/

if (function_exists ('shortcode_unautop')) {
	add_filter ('widget_text', 'shortcode_unautop');
}
add_filter ('widget_text', 'do_shortcode');

/************************************************/
?>