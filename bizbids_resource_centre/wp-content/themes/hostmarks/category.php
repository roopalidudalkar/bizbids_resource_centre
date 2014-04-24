<?

?>
<?php get_header(); ?>

<?php $current_category = single_cat_title("", false); ?>
    <div id="content" class="clearfix">
		<div class="article_banner">
			<div class="banner_image">
				<?php if (function_exists('z_taxonomy_image_url'))?><img src="<? echo z_taxonomy_image_url(); ?>">
			 
			<div class="banner_content">
				<p>Find an <?php echo $current_category?> the easy way</p>
				<ul>
					<li>Tell us what you need</li>
					<li><?php echo $current_category?> contact you</li>
					<li>You choose the best <?php echo $current_category?></li>
				</ul>
			</div>
			
			<div class="get_quotes">
				 <a class="btn btn-success" target="_blank" href="../bizbids/web/app_dev.php/search?category=<?php echo $current_category?>">GET QUOTES</a>
			</div>
			</div> 
        </div>
        <div id="main" class="col620 clearfix" role="main">
			<!--<aside id="search" class="widget widget_search">
					<?php //get_search_form(); ?>
			</aside>-->
			<?php if ( have_posts() ) : ?>
			
				<header class="page-header">
					<h1 class="page-title"><?php
						printf( __( '%s', 'hostmarks' ), '<span class="colortxt">' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>
				
				<?php /* Adds Odd/Even Classes */
				$ip = $_SERVER['SERVER_NAME'];
				$i=0;
				$class=array('odd','even'); ?>
				<?php /* Start the Loop */ ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				
				
                  <div class="<?php echo $class[$i++%2]; ?>">
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 ?>
	
						 <?
						$cur_cat_id = get_cat_id( single_cat_title("",false) );
						
						echo do_shortcode('[gallery id=$cur_cat_id]');
						get_template_part( 'content', get_post_format() );
						
						 ?>
						
                  </div>
				<?php endwhile; ?>
				<aside id="archives" class="widget">
					<div class="widget-title1"><?php _e( 'Use our directory to find local '. $current_category, 'hostmarks' ); ?></div>
					<ul>
						<?php while ( have_posts() ) : the_post(); ?>
						<?php 
							$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
							if ($children) { ?>
								<ul id="mainNav">
										<li>
											<?php echo $children; ?>
										</li>
								</ul>
						<?php } ?>
						<?php endwhile; // end of the loop. ?>
					</ul>
				</aside>
				<?php if (function_exists("hostmarks_pagination")) {
							hostmarks_pagination(); 
				} elseif (function_exists("hostmarks_content_nav")) { 
							hostmarks_content_nav( 'nav-below' );
				}?>

			<?php else : ?>
				
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'hostmarks' ); ?></h1>
					</header><!-- .entry-header -->

				<div class="entry-content post-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hostmarks' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			
			<?php endif; ?>
			
        </div> <!-- end #main -->
		
        <?php get_sidebar();?>

    </div> <!-- end #content -->
    
    <?php if ( get_theme_mod('hostmarks_footer_widget') ) {
		
		get_sidebar('footer');
	} ?>
        
<?php get_footer(); ?>
