<ul>


<?php $my_query = new WP_Query(array(
'post_parent'=>7,
'post__not_in'=>array('2'),
'post_type'=>'page'
)
	);?>
<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>  

<li id="page-<?php the_ID(); ?>" class="page" >
<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?><span class="st-arrow">open or close</span></h2></a>
<div class="st-content">
<p><?php the_content(); ?></p>
</div>
</li>
<?php endwhile; ?>
</ul>
 
<?php wp_reset_postdata(); ?>