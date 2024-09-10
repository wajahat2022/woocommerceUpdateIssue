<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"  <?php language_attributes( ) ?>> <!--<![endif]-->
<head>
    <meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    
	<link rel="alternate" type="application/rss+xml" title="RSS2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php  $al_options = get_option('al_general_settings'); ?>
	
   	<?php if(!empty($al_options['al_favicon'])):?>
		<link rel="shortcut icon" href="<?php echo $al_options['al_favicon'] ?>" /> 
 	<?php endif?>
	
   <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
   <!--[if lt IE 9]><script src="<?php echo get_template_directory_uri() ?>/js/html5.js"></script><![endif]-->
	
	
    <?php 
   		$bodyFont = isset($al_options['al_body_font']) ? $al_options['al_body_font'] : 'off';
		$headingsFont =(isset($al_options['al_headings_font']) && $al_options['al_headings_font'] !== 'off') ? $al_options['al_headings_font'] : 'off';
		$menuFont = (isset($al_options['al_menu_font']) && $al_options['al_menu_font'] !== 'off') ? $al_options['al_menu_font'] : 'off';
	
		$fonts['body, p, a, ol, li, label, #copyright'] = $bodyFont;
		$fonts['h1, h2, h3, h4'] = $headingsFont;
		$fonts['#menu-primary-navigation a'] = $menuFont;
		
		foreach ($fonts as $value => $key)
		{
			if($key != 'off' && $key != ''){ 
				$api_font = str_replace(" ", '+', $key);
				$font_name = font_name($key);
				
				echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$api_font.'" />';
				echo "<style type=\"text/css\">".$value."{ font-family: '".$key."' !important; }</style>";			
			}
		}
	
	?>
	<!-- JS

  ================================================== -->	

	

	<?php wp_enqueue_script('jquery'); ?>

	<?php wp_enqueue_script('jquery.easing', get_template_directory_uri().'/js/jquery.easing.1.3.js'); ?>

	<?php wp_enqueue_script('aqua.common', get_template_directory_uri().'/js/aqua.common.js'); ?>

	<?php wp_enqueue_script('jquery.quicksand', get_template_directory_uri().'/js/jquery.quicksand.js'); ?>

	<?php wp_enqueue_script('jquery.flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js'); ?>

	<?php wp_enqueue_script('jquery.prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js'); ?>	

	<?php wp_enqueue_script('jquery.jcarousel', get_template_directory_uri().'/js/jquery.jcarousel.min.js'); ?>

	<?php wp_enqueue_script('jquery.tipsy', get_template_directory_uri().'/js/jquery.tipsy.js'); ?>

    <?php wp_enqueue_script('jquery.ender', get_template_directory_uri().'/js/ender.min.js'); ?>

    <?php wp_enqueue_script('jquery.prettify', get_template_directory_uri().'/js/prettify.js'); ?>

    <?php wp_enqueue_script('jquery.selectnav', get_template_directory_uri().'/js/selectnav.min.js'); ?>	

    <?php wp_enqueue_script('jquery.validate', get_template_directory_uri().'/js/jquery.validate.js'); ?>

    <?php wp_enqueue_script('jquery.sendata', get_template_directory_uri().'/js/jquery.sendata.js'); ?>	


	<!--[if lt IE 9]>

		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->



	<!-- Favicons

	================================================== -->
	<script type="text/javascript">
function onchange_category(){
	show_load();
	var action = 'changecategory';
	var productcat_ID = jQuery('#productcat_ID:checked').val();
	var sheet_size = jQuery('#sheet_size').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,productcat_ID:productcat_ID,sheet_size:sheet_size},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('product_div_id').innerHTML=data;
			onchange_productCutsheet();
		},
		error: function(jqXHR, textStatus, errorThrown){
                        alert(textStatus);
                        alert(errorThrown);
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}
function onchange_productCutsheet(){
	show_load();
	var action = 'changeproductsutsheet';
	var product_ID = jQuery('#product_ID').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,product_ID:product_ID},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('color_div_id').innerHTML=data;
			onchange_colorcutsheet();
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}
function onchange_colorcutsheet(){
	show_load();
	var action = 'changecolor';
	var product_ID = jQuery('#product_ID').val();
	var color = jQuery('#color').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,color:color,product_ID:product_ID},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('thickness_div_id').innerHTML=data;
			onchange_thickness();
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}
function onchange_thickness(){
	show_load();
	var action = 'changethickness';
	var product_ID = jQuery('#product_ID').val();
	var color = jQuery('#color').val();
	var thickness = jQuery('#thickness').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,color:color,product_ID:product_ID,thickness:thickness},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('cut_sheets').innerHTML=data;
			//onchange_sheet_size();
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}
function onchange_sheet_size(){
	show_load();
	var action = 'change_sheet_size';
	var product_ID = jQuery('#product_ID').val();
	var color = jQuery('#color').val();
	var thickness = jQuery('#thickness').val();
	var sheet_size = jQuery('#sheet_size').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,color:color,product_ID:product_ID,thickness:thickness,sheet_size:sheet_size},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('cut_sheets').innerHTML=data;
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}
function onchange_quantity(){
	var tqty = jQuery('#qty').val();
	if(tqty=='more'){
		//alert(tqty)
		document.getElementById("QtyDiv").style.display="block";
	} else {
		document.getElementById("QtyDiv").style.display="none";
	}
	
}

function onchangeproduct(){
	show_load();
	var action = 'changeproduct';
	var productname = jQuery('#productname').val();
	var productcat = jQuery('#productcat').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data.php',
		data: {action:action,productname:productname,productcat:productcat},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('sheetshow').innerHTML=data;
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}

function onchangestylesheet(){
	show_load();
	var action = 'changestylesheet';
	var stylesheet = jQuery('#stylesheet').val();
	var stylsheetId = document.getElementById('stylsheetId').value;
	var productcat = jQuery('#productcat').val();
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data.php',
		data: {action:action,stylesheet:stylesheet,stylsheetId:stylsheetId,productcat:productcat},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('thicknesshow').innerHTML=data;
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}

function addTocart(){
	show_load();
	var action = 'addtocart';
	var productcat_ID = jQuery('#productcat_ID:checked').val();
	var product_ID = jQuery('#product_ID').val();
	var color = jQuery('#color').val();
	var thickness = jQuery('#thickness').val();
	var sheet_size = jQuery('#sheet_size').val();
	var qty = jQuery('#qty').val();

	if(qty=='more'){
		qty=jQuery('#quanTyty').val();
	}
		

	var total = jQuery('#total').val();
	var final_variation_id = jQuery('#final_variation_id').val();
	
 	jQuery.ajax({
				
		url : '../wp-content/themes/touchm/includes/data_new.php',
		data: {action:action,color:color,product_ID:product_ID,thickness:thickness,sheet_size:sheet_size,productcat_ID:productcat_ID,qty:qty,total:total,final_variation_id:final_variation_id},
		timeout: 10000,
		success : function(data) {
			hide_load();
			document.getElementById('addtocartshow').innerHTML=data;
		},
		error: function(){
			hide_load();
			showMessage('#04A2D7', '#000000', 'Thanking them for their order and a representative will be in contact shortly to confirm the order.');
		}
	});
}

</script>
	<?php wp_head(); ?>
<style type="text/css">
#fancybox-loading{position:fixed; top:50% ;left:50%; width:40px; height:40px; margin-top:-20px; margin-left:-20px; cursor:pointer; overflow:hidden; z-index:9999;display:none;}
#fancybox-loading div{position:absolute; top:0; left:0;}
#fancybox-overlay{position:absolute; top:0; left:0; width:100%; z-index:1100; display:none; background-color:#FFF; opacity:0.7; cursor:pointer; height:1695px;}
.displaynormal{display:block;}
</style>
</head>

<body  <?php body_class(); ?>>
 <div id="fancybox-loading"><div><img src="<?php bloginfo('template_directory'); ?>/images/svwloader.gif" alt="Loading" /></div></div>
						<div id="fancybox-overlay"></div>
<div class="main-wrapper">
	<!-- BEGIN Topbar -->
	<div class="container region1wrap">  
		<div class="row top_header">
			<div class="six columns">
			   <?php 
					wp_nav_menu( 
					array( 
						'theme_location' => 'top_nav',
						'menu' =>'top_nav', 
						'container'=>'', 
						'depth' => 1, 
						'menu_class' => 'link-list',
						)  
					); 
				?>
			</div>
			
			<div class="six columns">
				<?php if (isset ($al_options['al_header_social']) && $al_options['al_header_social'] !=''):?>
					<?php echo do_shortcode ($al_options['al_header_social']) ?>
				<?php endif?> 
			</div>
		
		</div>
	</div>
	<!-- END Topbar -->


	<!-- BEGIN Header -->
	<header class="container region2wrap">
		<div class="row">
			<!-- Logo -->
			<div class="three columns">
				<a href="<?php echo home_url() ?>" id="logo">
					<?php if(!empty($al_options['al_logo'])):?>
						<img src="<?php echo $al_options['al_logo'] ?>" alt="<?php echo $al_options['al_logotext']?>" id="logo-image" />
					<?php else:?>
						<?php echo isset($al_options['al_logotext']) ? $al_options['al_logotext'] : 'TouchM' ?>
					<?php endif?>
				</a>
			</div>
			<!-- Main Navigation -->
			<?php if (!is_page_template('under-construction.php')):?>
			<div class="nine columns">
				<nav class="top-bar">
					<ul>
						<!-- Toggle Button Mobile -->
						<li class="name"><h1><a href="#"><?php _e('Please select your page', 'TouchM')?></a></h1></li>
						<li class="toggle-topbar"><a href="#"></a></li>
						<!-- End Toggle Button Mobile -->
					</ul>
					<section><!-- Nav Section -->
						<?php 
							$walker = new My_Walker;
							if(function_exists('wp_nav_menu')):
								wp_nav_menu( 
								array( 
									'theme_location' => 'primary_nav',
									'menu' =>'primary_nav', 
									'container'=>'', 
									'depth' => 4, 
									'menu_class' => 'right',
									'walker' => $walker
									)  
								); 
							else:
								?><ul class="sf-menu top-level-menu"><?php wp_list_pages('title_li=&depth=4'); ?></ul><?php
							endif; 
						?>
					</section><!-- End Nav Section -->
				</nav>            
			</div>
			<?php endif?>
			<!-- End Main Navigation -->         
		</div>   
	</header>
