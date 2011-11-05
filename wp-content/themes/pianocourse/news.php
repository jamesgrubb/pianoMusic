<?php 

/**
 * Template Name: News
 *
 * A custom page template for showing posts.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 
 * */

?>

<?php get_header(); ?>

<div id="st-accordion" class="st-accordion">

<?php get_template_part ('loop','news'); ?>

</div>

	 
</div><!-- #container -->
 
<div id="primary" class="widget-area">
</div><!-- #primary .widget-area -->
 
<div id="secondary" class="widget-area">
</div><!-- #secondary -->


<?php get_footer(); ?>

