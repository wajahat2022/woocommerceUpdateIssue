<div class="row collapse top_search">
	<form action="<?php echo site_url() ?>" method="get" id="search-global-form">   
		<div class="ten mobile-three columns">
			<input type="text" placeholder="Enter search terms" name="s" id="search" title="<?php _e('Search terms', 'TouchM');?>" value="<?php the_search_query(); ?>" />
		</div>
		<div class="two mobile-one columns">
			<button type="submit" value="" name="search" class="button"><i class="icon-search"></i></button> 
		</div>
	</form>
</div>