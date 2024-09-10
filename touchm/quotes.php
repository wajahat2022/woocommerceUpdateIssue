<?php 
/*
	Template Name: Quotes
*/


get_header(); 
$al_options = get_option('al_general_settings');
$breadcrumbs = $al_options['al_show_breadcrumbs'];
$titles = $al_options['al_show_page_titles'];

?>

<?php if((is_page() || is_single()) && !is_front_page()): ?>
       
<?php /*?><div class="row">
	<div class="sixteen columns">
	    <?php boc_breadcrumbs(); ?>
		<div class="page_heading"><h1><?php the_title(); ?></h1></div>
	</div>
</div><?php */?>
<?php endif; ?>



<div class="container region3wrap">  
	<div class="row content_top">        
			<div class="nine columns">
				<?php if(class_exists('the_breadcrumb')){ $albc = new the_breadcrumb; } ?>
			</div>
			
		</div>	
</div>

<!-- Side bar starts -->
<div class="row maincontent">
<div class="twelve columns">
				<div class="page_title">
					<div class="row">
						<div class="twelve columns">
							<h1>Quotation</h1>
						</div>
					</div>
				</div>
			</div>
<!-- Side bar ends --> 	

<div class="four columns sidebar-left"><?php dynamic_sidebar('shop-sidebar-1') ?></div>

<!-- main content section-->
<section class="eight columns">	
<div class="woocommerce">

	<div class="inner">

        <div class="dd">

<form method="post" action="" name="quote" id="quote">
            <input type="hidden" name="action" id="action" value="quote">
                <h2>Product Selection</h2>
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                <label>Product Category</label>
                 <ul class="pro-cat">
                 <?php 
				 	$product_id='';
				 	if(isset($_GET['product_id'])){
						$product_id=$_GET['product_id'];
					}
					else{
					    $product_id="2516";
					}
                    $args = array('post_type'=>'product','orderby'=>'name','order'=>'ASC','hide_empty'=>0,'taxonomy'=>'product_cat','child_of'=>0,'parent'=>0);
                    $cats = get_categories($args);
					$_SESSION['cat_slug']='whole-sheets';
                    foreach($cats as $catsone){
                   
                 ?>
                 <li><input type="radio" <?php if($catsone->slug=='whole-sheets') echo 'checked'; ?> name="productcat_ID" id="productcat_ID" onclick="onchange_category();" value="<?=$catsone->term_id ?>" /><?=$catsone->name ?></li>
                 <?php  } ?>
                 </ul>
                </div>
                    <div id="product_div_id" class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                    <?php
						$args=array('post_type' => 'product' ,'orderby'=>'name','order'=>'ASC','product_cat' => 'whole-sheets');
						global $woocommerce, $product, $post;
						query_posts($args);
					?>
                    <label>Product Type</label>
                    <select class="form-control input-sm form-drop-back" id="product_ID" name="product_ID" onChange="onchange_productCutsheet();">
						<?php 
						if (have_posts()) : while (have_posts()) : the_post(); 
							global $product,$post; 
							if($product_id==''){$product_id=387;}
						?>
                        <option value="<?php echo $post->ID; ?>" <?php if($post->ID==$product_id) echo 'selected'; ?>><?php echo the_title(); ?></option>
                        <?php endwhile; endif; ?>
                    </select>
                    <?php wp_reset_query(); ?>
                    </div>
                    <?php 
							//$colorfeatures = get_post_meta($product_id, '_product_attributes', true);
							//$colorfeatures = $colorfeatures['color-and-features']['value'] ;
							$args = array(
							'post_type'		=> 'product_variation',
							'post_status' 	=> array( 'private', 'publish' ),
							'numberposts' 	=> -1,
							'orderby' 		=> 'menu_order',
							'order' 		=> 'asc',
							'post_parent' 	=> $product_id
							);
							$variations = get_posts( $args );
							$colorarray = $thicknessarray = $sizesheetarray = array();
							foreach ( $variations as $variation ) {
								
								$variation_id 			= absint( $variation->ID );
								$variation_post_status 	= esc_attr( $variation->post_status );
								$variation_data 		= get_post_meta( $variation_id );
								$variation_data['variation_post_id'] = $variation_id;
								$colr_features			= $variation_data['attribute_color-and-features'];
								$thickness_features		= $variation_data['attribute_thickness'];
								$sizesheet_features		= $variation_data['attribute_size-sheet'];
								if($colr_features){
								foreach ($colr_features as $colr_feature) {
									if(!in_array($colr_feature, $colorarray)) {
										$colorarray[$variation_id]=$colr_feature;
									}
								}
								}
								if($thickness_features){
								foreach ($thickness_features as $thickness_feature) {
									if(!in_array($thickness_feature, $thicknessarray)) {
										$thicknessarray[$variation_id]=$thickness_feature;
									}
								}
								}
								if($sizesheet_features){
								foreach ($sizesheet_features as $sizesheet_feature) {
									if(!in_array($sizesheet_feature, $sizesheetarray)) {
										$sizesheetarray[$variation_id]=$sizesheet_feature;
									}
								}
								}
							}

			

                        ?>
 			<?php 
				foreach ($sizesheetarray as $sizesheet_one) {
				  if ($sizesheet_one != '')
				  {
					$_SESSION['cutsheetmaximum'] = $sizesheet_one;
				  } ?>
			<?php } ?> 
                    <div class="clearfix"></div>
                        <legend>Sheet Specifications</legend>
                        
                        <div id="color_div_id" class="col-lg-6 col-md-6 col-xs-12 col-sm-6 bar-head">
                       <label>Colour and Features</label>
                        <select name="color" id="color" class="form-control input-sm form-drop-back" onChange="onchange_colorcutsheet();">
                       <?php
                            foreach ($colorarray as $color_one) {
                        ?>
                        <option value="<?php echo $color_one; ?>"><?php echo $color_one; ?></option>
                        <?php }?> 
                        </select>
                        </div>
                        <div id="thickness_div_id" class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <label>Thickness </label>
                        <select name="thickness" id="thickness" onchange="onchange_thickness()" class="form-control input-sm form-drop-back">
                        <?php foreach ($thicknessarray as $ke => $thickness_one) {?>
                        <option value="<?php echo $thickness_one; ?>"><?php echo $thickness_one; ?></option>
                        <?php }  ?>  
                        </select>
                        </div>
                        
                        <div id="cut_sheets" >
                        <div id="sheet_size_div_id" class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <label>Sheet Size</label>
                        <select name="sheet_size" id="sheet_size"  class="form-control input-sm form-drop-back">
                            <?php 
							foreach ($sizesheetarray as $sizesheet_one) {
							?>
							<option value="<?php echo $sizesheet_one; ?>"><?php echo $sizesheet_one; ?></option>
							<?php } ?> 
                        </select>
                        </div>
                        </div>
                        
                        <div  class="col-lg-6 col-md-6 col-xs-12 col-sm-6 bar-head">
                       <label>Quantity</label>
                        <select name="qty" id="qty" onchange="onchange_quantity()" class="form-control input-sm form-drop-back">
                        	<?php for($j=1;$j<=20;$j++){?>
                            <option value="<?php echo $j ;?>"><?php echo $j ;?></option>
                            <?php } ?>
                            <option value="more">Higher quantity</option>
                        </select>
                        </div>
                        <div id="QtyDiv" class="col-lg-6 col-md-6 col-xs-12 col-sm-6 bar-head" style="display:none;">
                       <label>Specify Quantity</label>
                       <input type="text" name="quanTyty" id="quanTyty" value="" class="form-control input-sm form-drop-back"/>
                       
                        </div>
                        <hr>
                        <button style="margin-top:15px; margin-left:15px;" type="submit" class="add_to_cart_button small button product_type_variable">Update Quote</button>
            </form>
        		 	

                    <br />
                    <div id="success"></div>
                    
                </div>
       <div style="clear:both;"></div>
     </div>
</div>
<!-- main content section end-->
</section>
</div>
<?php get_footer(); ?>	