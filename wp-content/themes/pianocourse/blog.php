<?php
/**
 * Template Name: News
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>




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