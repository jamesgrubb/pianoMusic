
<?php while ( have_posts() ) : the_post() ?>
<li id="post-<?php the_ID(); ?>" class="post" >
    <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?><span class="st-arrow">open or close</span></h2></a>
  <div class="st-content">
  <?php the_content(); ?>
  </div>  
</li>
<?php wp_reset_postdata(); ?>
