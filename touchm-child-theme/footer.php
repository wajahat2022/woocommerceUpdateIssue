	<?php $al_options = isset($_POST['options']) ? $_POST['options'] : get_option('al_general_settings');?>
	<footer class="container region9wrap">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Sidebar") ) :endif; ?>
		
		 <!-- Bottom Content -->
		<?php 
			$footer_widget_count = isset($al_options['al_footer_widgets_count']) ? $al_options['al_footer_widgets_count']:0;
			if($footer_widget_count > 0):
		?>
		<div class="row footer">
			<?php
				for($i = 1; $i<= $footer_widget_count; $i++){
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Widget ".$i) ) :endif;
				}			
			?>
		</div>
		<?php endif?>
		<div class="container region10wrap"> 
			<div class="row footer_bottom">       
				<div class="six columns">
					<p class="copyright"><?php echo $al_options['al_copyright']?></p>
				</div>
				<div class="six columns">
					<?php 
						wp_nav_menu( 
						array( 
							'theme_location' => 'footer_nav',
							'menu' =>'footer_nav', 
							'container'=>'', 
							'depth' => 1, 
							'menu_class' => 'link-list'
							)  
						); 
					?>
				</div>
			</div>
		</div>
	</footer>     
	<a href="#" class="scrollup"><?php _e('Scroll', 'TouchM')?></a>  
</div> 
<?php //include ('optionspanel.php') ?>
<?php if (isset($al_options['al_custom_js'])) echo $al_options['al_custom_js']; ?>
<?php wp_footer()?>
<script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jquery.formvalidate.js" ></script>
</body>
</html>