<?php
/**
 * Template Name: News
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>



<?php

// The Query
query_posts( $args );

// The Loop
while ( have_posts() ) : the_post();
	echo '<li>';
	the_title();
	echo '</li>';
endwhile;

// Reset Query
wp_reset_query();

?>