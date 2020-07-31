<?php get_header(); ?>

<?php if (have_posts()) : ?>
    
	<?php while ( have_posts() ) : the_post(); ?>
        
        <div id="post-<?php echo $post->ID;?>" class="post single-post">
        
			<h3 class="post-title"><?php the_title(); ?></h3>
            <h4 class="post-date"><?php the_time('d/m/Y'); ?></h4>
            <div class="post-content"><?php the_content(); ?></div>
            <div class="post-meta">
				<div class="post-cats">Categories: <?php the_category(', '); ?></div>
                <?php if(has_tag()) : ?>
                    <div class="post-tags"><?php the_tags('Tags: ',', ',''); ?></div>
                <?php endif; ?>
            </div>
            <div class="post-comments">
            	<?php comments_template(); ?> 
            </div>
            
		</div><!--POST-->
    
    <?php endwhile; ?>
    
<?php endif; ?>

<?php get_footer(); ?>
