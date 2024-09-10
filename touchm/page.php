<?php /* Template Name: Regular page */ ?>

<?php get_header();
$custom =  get_post_custom($post->ID);

$layout = isset ($custom['_page_layout']) ? $custom['_page_layout'][0] : '1';
$promo = get_post_meta($post->ID, "_promo", $single = false);
$slider = get_post_meta($post->ID, "_chosen_slider", $single = false);
$al_options = get_option('al_general_settings');
$breadcrumbs = $al_options['al_show_breadcrumbs'];
$titles = $al_options['al_show_page_titles'];
?>

<div class="container region3wrap">
    <?php if(!empty($slider[0]) ):?>
    <div class="mainslider-container responsive">
        <?php if(function_exists('putRevSlider'))putRevSlider($slider[0]); ?>
    </div>
    <?php endif?>
    <?php if(!empty($promo[0]) ):?>
    <div class="row content_top promo-block">
        <div class="twelve columns">
            <h2><?php echo do_shortcode($promo[0]);?></h2>
        </div>
    </div>
    <?php endif ?>
    <?php if($breadcrumbs):?>
    <div class="row content_top">
        <div class="nine columns">
            <?php if(class_exists('the_breadcrumb')){ $albc = new the_breadcrumb; } ?>
        </div>
        <div class="three columns">
            <div class="row">
                <div class="twelve columns">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>

<div class="container region4wrap">
    <div class="row maincontent">
        <?php if ($titles):?>
        <div class="twelve columns">
            <div class="page_title">
                <div class="row">
                    <div class="twelve columns">
                        <h1>
                            <?php 
									$headline = get_post_meta($post->ID, "_headline", $single = false);
									if(!empty($headline[0]) ){echo $headline[0];}
									else{echo get_the_title();} 
								?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <?php endif?>

        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <?php if ($layout == '3'):?>
        <div class="four columns sidebar-left"><?php generated_dynamic_sidebar() ?></div>
        <?php endif?>
        <div class="<?php echo $layout == '1' ? 'twelve' : 'eight'?> columns">
            <?php the_content(); ?>
        </div>
        <?php if ($layout == '2'):?>
        <div class="four columns sidebar-right"><?php generated_dynamic_sidebar() ?></div>
        <?php endif?>
        <?php endwhile; ?>
        <div class="clear"></div>

    </div>
</div>

<?php get_footer(); ?>