<?php get_header(); ?>

<?php if (have_posts()) : ?>
	
    <?php 
		$query = get_queried_object();
    	$post = $posts[0]; // Hack. Set $post so that the_date() works. 
	?>
	
    <div class="archive index">
    
    	<h2 class="page-title"><?php echo $query->name; ?></h2>	
    
		<?php while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php echo $post->ID;?>" class="post">
        
			<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <h4 class="post-date"><?php the_time('d/m/Y'); ?></h4>
        	<div class="post-thumb">
            	<a href="<?php the_permalink(); ?>">
					<?php if(has_post_thumbnail( $post->ID )) : ?> 
                        <?php the_post_thumbnail(array( 200,200 )) ?>
                    <?php else : ?>
                        <img src="<?php bloginfo('template_url'); ?>/images/default-thumb.png" />
                    <?php endif; ?>
				</a>
			</div>
            <div class="post-content"><?php the_excerpt(); ?></div>
            
		</div><!--POST-->
    
    	<?php endwhile; ?>
    
        <div class="post-navigation">
        	<?php if(function_exists('wp_pagenavi')) : ?>
            	<?php wp_pagenavi(); ?> 
			<?php else : ?>
                <div class="next left"><?php previous_posts_link( 'Entradas más recientes' ); ?></div>
                <div class="prev right"><?php next_posts_link( 'Entradas más antiguas' ); ?></div>
			<?php endif; ?>
        </div>
    
    </div><!--POSTS-->

<?php endif; ?>

<?php get_footer(); ?>
