<?php
/**
 * Template Name: Home
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>

<?php get_header(); ?>
<div id="container">
 

 <?php
query_posts('post_type=page&post_parent='.$parent);
?>
	<ul>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li>	
		<div class="post" id="post-<?php the_ID(); ?>">
		<?php $parent = $post->ID; ?>
		
	
		<a href="<?php the_permalink(); ?>" class="consertina"> <h2><?php the_title(); ?></h2></a>
		<div class="entry">
		<?php the_content(); ?>
		</div>
	</li>


<?php endwhile; endif; 
wp_reset_query(); // reset the query ?>
</ul>
<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

<?php
query_posts('post_parent ='.$parent);
?>
<ul>
<?php while (have_posts()) : the_post(); ?>
<li>
<span class="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
<?php the_excerpt(); ?>
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