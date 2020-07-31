<?php get_header(); ?>

<?php if (have_posts()) : ?>	
	
    <div class="index">
    
		<?php while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php echo $post->ID;?>" class="post">
        
			<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <h4 class="post-date"><?php the_time('d/m/Y'); ?></h4>
        	<div class="post-thumb">
            	<a href="<?php the_permalink(); ?>">
					<?php if(has_post_thumbnail( $post->ID )){
						$thumb_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					}else{
						$thumb_url = get_bloginfo('template_url').'/images/default-thumb.png';
					} ?>
                    <img src="<?php echo $thumb_url; ?>" />
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
