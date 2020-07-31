<?php get_header(); ?>

<?php if (have_posts()) : ?>	

	<?php while ( have_posts() ) : the_post(); ?>
	
        <div id="page-<?php echo $post->ID;?>" class="page">
        
			<h3 class="page-title"><?php the_title(); ?></h3>
            <div class="page-content"><?php the_content(); ?></div>
            <div class="page-comments">
            	<?php comments_template(); ?> 
            </div>
        
        </div><!--PAGE-->
        
    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>
