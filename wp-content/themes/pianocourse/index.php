<?php
/**
 * Template Name: Home
 *
 * Selectable from a dropdown menu on the edit page screen.
 */
?>

<?php get_header(); ?>
<div id="st-accordion" class="st-accordion">

<?php get_template_part ('loop','index'); wp_reset_postdata();?>



</div>

	 
</div><!-- #container -->
 
<div id="primary" class="widget-area">
</div><!-- #primary .widget-area -->
 
<div id="secondary" class="widget-area">
</div><!-- #secondary -->


<?php get_footer(); ?>