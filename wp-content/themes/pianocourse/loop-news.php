<ul>
<?php while ( have_posts() ) : the_post() ?>
<li id="post-<?php the_ID(); ?>" class="post" >
    <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?><span class="st-arrow">open or close</span></h2></a>
  <div class="st-content">
  <p><?php the_content(); ?></p>
  </div>  
</li>
<?php endwhile; ?>
</ul>