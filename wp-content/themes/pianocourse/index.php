<?php
/**
 * Template Name: Home
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>

<?php get_header(); ?>
<div id="st-accordion" class="st-accordion">
<ul>

<?php $my_query = new WP_Query('post_type=page&post_parent='.$parent);  ?>
<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>  
    <?php query_posts('post_parent ='.$parent); ?>
<li>
<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?><span class="st-arrow">open or close</span></h2></a>
<div class="st-content">
<p><?php the_content(); ?></p>
</div>
</li>
<?php endwhile; ?>


</ul>
</div>

	 
</div><!-- #container -->
 
<div id="primary" class="widget-area">
</div><!-- #primary .widget-area -->
 
<div id="secondary" class="widget-area">
</div><!-- #secondary -->


<?php get_footer(); ?>