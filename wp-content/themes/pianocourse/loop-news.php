
<?php get_header ?>
<li>

<?php $news_query = new WP_Query(array('post_type'=>'post','post_id'=>2));

while ($news_query->have_posts()) : $news_query->the_post(); ?> 
<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2><span class="st-arrow">open or close</span></h2></a>
 
<div class="st-content">
   <?php the_content(); ?>
</div>
</li>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer ?>