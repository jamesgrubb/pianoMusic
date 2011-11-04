<?php
/**
 * Template Name: News
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>
<?php get_header(); ?>
<ul>
<?php while ( have_posts() ) : the_post() ?>
<li>
    <?php the_excerpt(); ?>
</li>
<?php endwhile; ?>
</ul>
<?php get_header(); ?>