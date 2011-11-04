<?php
/**
 * @package Order Up!
 */
/*
Plugin Name: Custom Page Order
Plugin URI: http://drewgourley.com/order-up-custom-ordering-for-wordpress/
Description: Allows for the ordering of posts and custom post types through a simple drag-and-drop interface.
Version: 2.2
Author: Drew Gourley
Author URI: http://drewgourley.com/
License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

$custompageorder_defaults = array('page' => 1, 'per_page' => 5);
$custompageorder_defaults = apply_filters('custompageorder_defaults', $custompageorder_defaults);
$custompageorder_settings = get_option('custompageorder_settings');
$custompageorder_settings = wp_parse_args($custompageorder_settings, $custompageorder_defaults);
add_action('admin_init', 'custompageorder_register_settings');
function custompageorder_register_settings() {
	register_setting('custompageorder_settings', 'custompageorder_settings', 'custompageorder_settings_validate');
}
function custompageorder_update_settings() {
	global $custompageorder_settings, $custompageorder_defaults;
	if ( isset($custompageorder_settings['update']) ) {
		if ( !is_numeric($custompageorder_settings['per_page'] ) || $custompageorder_settings['per_page'] < 1 ) {
			echo '<div class="error fade" id="message"><p>The Entries Per Page setting must be a positive integer, value reset to default.</p></div>';
			$custompageorder_settings['per_page'] = $custompageorder_defaults['per_page'];
		}
		$custompageorder_settings['per_page'] = min( 80, $custompageorder_settings['per_page'] );
		echo '<div class="updated fade" id="message"><p>Custom Post Order settings '.$custompageorder_settings['update'].'.</p></div>';
		unset($custompageorder_settings['update']);
		update_option('custompageorder_settings', $custompageorder_settings);
	}
}
function custompageorder_settings_validate($input) {
	$input['page'] = ($input['page'] == 1 ? 1 : 0);
	$input['per_page'] = wp_filter_nohtml_kses($input['per_page']);
	return $input;
}

function custompageorder_menu() {    
	add_menu_page(__('Page Order'),  __('Page Order'), 'edit_pages', 'custompageorder', 'custompageorder', plugins_url('images/page_order.png', __FILE__), 121); 
	add_submenu_page('custompageorder', __('Order Pages'), __('Order Pages'), 'edit_pages', 'custompageorder', 'custompageorder'); 
	add_pages_page(__('Order Pages', 'custompageorder'), __('Order Pages', 'custompageorder'), 'edit_pages', 'custompageorder', 'custompageorder');
}
function custompageorder_css() {
	if ( isset($_GET['page']) && $_GET['page'] == "custompageorder" ) {
		wp_enqueue_style('custompageorder', plugins_url('css/custompageorder.css', __FILE__), 'screen');
	}
}
function custompageorder_js_libs() {
	if ( isset($_GET['page']) && $_GET['page'] == "custompageorder" ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}
}
add_action('admin_menu', 'custompageorder_menu');
add_action('admin_print_styles', 'custompageorder_css');
add_action('admin_print_scripts', 'custompageorder_js_libs');

function custompageorder() {
	global $custompageorder_settings;
	custompageorder_update_settings();
	$options = $custompageorder_settings;
	if ( isset( $_GET['paged'] ) ) {
		$page = max( 1, $_GET['paged'] );
	} else { 
		$page = 1;
	}
	$settings = '<input name="custompageorder_settings[page]" type="checkbox" value="1" ' . checked('1', $options['page'], false) . ' /> <label for="custompageorder_settings[page]">Check this box if you want to enable Automatic Sorting of all queries from this post type.</label>';
	$parent_ID = 0;
	if (isset($_POST['go-sub-pages'])) { 
		$parent_ID = $_POST['sub-pages'];
	}
	elseif (isset($_POST['hidden-parent-id'])) { 
		$parent_ID = $_POST['hidden-parent-id'];
	}
	if (isset($_POST['return-sub-pages'])) { 
		$parent_post = get_post($_POST['hidden-parent-id']);
		$parent_ID = $parent_post->post_parent;
	}
	if (isset($_POST['order-submit'])) { 
		custompageorder_update_order();
	}
?>
<div class='wrap'>
	<?php screen_icon('custompageorder'); ?>
	<h2><?php _e('Order Pages', 'custompageorder'); ?></h2>
	<form name="custom-order-form" method="post" action="">
		<?php $args = array( 
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_parent' => $parent_ID,
			'post_type' => 'page',
			'posts_per_page' => $options['per_page'],
			'paged' => $page
			);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			if ( $page !== 1 ) {
				$prev_page = $page-1;
				$args['paged'] = $prev_page;
				$prev_query = new WP_Query( $args );
			}
			if ( $page !== $query->max_num_pages ) {
				$next_page = $page+1;
				$args['paged'] = $next_page;
				$next_query = new WP_Query( $args );
			}
		?>
		<div id="poststuff" class="metabox-holder">
			<div class="widget order-widget">
				<h3 class="widget-top"><?php _e('Pages', 'custompageorder') ?> | <small><?php _e('Order the pages by dragging and dropping them into the desired order.', 'custompageorder') ?></small></h3>
				<div class="misc-pub-section">
					<ul id="custom-order-list">
						<?php if ( isset( $prev_query ) ) { if ( $prev_query->have_posts() ) { while ( $prev_query->have_posts() ) : $prev_query->the_post(); ?>
						<li id="id_<?php the_ID(); ?>" class="lineitem outer"><?php the_title(); ?></li>
						<?php endwhile; } } ?>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<li id="id_<?php the_ID(); ?>" class="lineitem"><?php the_title(); ?></li>
						<?php endwhile; ?>
						<?php if ( isset( $next_query ) ) { if ( $next_query->have_posts() ) { while ( $next_query->have_posts() ) : $next_query->the_post(); ?>
						<li id="id_<?php the_ID(); ?>" class="lineitem outer"><?php the_title(); ?></li>
						<?php endwhile; } } ?>
					</ul>
				</div>
				<?php $big = 2097152;
				$args = array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'prev_next' => false,
					'current' => $page,
					'total' => $query->max_num_pages
					); 
				$pagination = paginate_links($args); 
				if ( !empty($pagination) ) { ?>
				<div class="misc-pub-section">
					<div class="tablenav" style="margin:0">
						<div class="tablenav-pages">
							<span class="pagination-links"><?php echo $pagination; ?></span>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="misc-pub-section misc-pub-section-last">
					<?php if ($parent_ID != 0) { ?>
						<input type="submit" class="button" style="float:left" id="return-sub-pages" name="return-sub-pages" value="<?php _e('Return to Parent', 'custompageorder'); ?>" />
					<?php } ?>
					<div id="publishing-action">
						<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" id="custom-loading" style="display:none" alt="" />
						<input type="submit" name="order-submit" id="order-submit" class="button-primary" value="<?php _e('Update Order', 'custompageorder') ?>" />
					</div>
					<div class="clear"></div>
					</div>
				<input type="hidden" id="hidden-custom-order" name="hidden-custom-order" />
				<input type="hidden" id="hidden-parent-id" name="hidden-parent-id" value="<?php echo $parent_ID; ?>" />
			</div>
			<?php $dropdown = custompageorder_sub_query($query); if( !empty($dropdown) ) { ?>
			<div class="widget order-widget">
				<h3 class="widget-top"><?php _e('Subpages', 'custompageorder'); ?> | <small><?php _e('Choose a page from the drop down to order its subpages.', 'custompageorder'); ?></small></h3>
				<div class="misc-pub-section misc-pub-section-last">
					<select id="sub-pages" name="sub-pages">
						<?php echo $dropdown; ?>
					</select>
					<input type="submit" name="go-sub-pages" class="button" id="go-sub-pages" value="<?php _e('Order Subpages', 'custompageorder') ?>" />
				</div>
			</div>		
			<?php } ?>
		</div>
		<?php } else { ?>
		<p><?php _e('No pages found', 'customtaxorder'); ?></p>
		<?php } ?>
	</form>
	<form method="post" action="options.php">
		<?php settings_fields('custompageorder_settings'); ?>
		<table class="form-table">
			<tr valign="top"><th scope="row">Auto-Sort Queries</th>
			<td><?php echo $settings; ?></td>
			</tr>
			<tr valign="top"><th scope="row">Entries Per Page</th>
			<td><input name="custompageorder_settings[per_page]" type="text" value="<?php echo $options['per_page']; ?>" style="width:48px" /></td>
			</tr>
		</table>
		<input type="hidden" name="custompageorder_settings[update]" value="Updated" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
		</p>
	</form>
</div>
<?php if ( $query->have_posts() ) { ?>
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function($) {
		$("#custom-loading").hide();
		$("#order-submit").click(function() {
			orderSubmit();
		});
	});
	function custompageorderAddLoadEvent(){
		jQuery("#custom-order-list").sortable({ 
			placeholder: "sortable-placeholder", 
			revert: false,
			tolerance: "pointer" 
		});
	};
	addLoadEvent(custompageorderAddLoadEvent);
	function orderSubmit() {
		var newOrder = jQuery("#custom-order-list").sortable("toArray");
		jQuery("#custom-loading").show();
		jQuery("#hidden-custom-order").val(newOrder);
		return true;
	}
// ]]>
</script>
<?php }
}
function custompageorder_update_order( $page = 1 ) {
	global $custompageorder_settings;
	$options = $custompageorder_settings;
	if (isset($_POST['hidden-custom-order']) && $_POST['hidden-custom-order'] != "") { 
		if ( $page > 2 ) {
			$offset = ( $page - 1 ) * $options['per-page'];
		} else {
			$offset = 0;
		}
		global $wpdb;
		$offset = ( max( 1, $_GET['paged'] ) - 1 ) * get_option('posts_per_page');
		$new_order = $_POST['hidden-custom-order'];
		$IDs = explode(",", $new_order);
		$result = count($IDs);
		for($i = 0; $i < $result; $i++)	{
			$str = str_replace("id_", "", $IDs[$i]);
			$order = $i + $offset;
			$update = array('ID' => $str, 'menu_order' => $order);
			wp_update_post( $update );
		}
		echo '<div id="message" class="updated fade"><p>'. __('Order updated successfully.', 'custompageorder').'</p></div>';
	} else {
		echo '<div id="message" class="error fade"><p>'. __('An error occured, order has not been saved.', 'custompageorder').'</p></div>';
	}
}
function custompageorder_sub_query( $query ) {
	$options = '';
	while ( $query->have_posts() ) : $query->the_post(); 
		$page_ID = get_the_ID();
		$args = array( 'post_parent' => $page_ID, 'post_type' => 'page' );
		$subpages = new WP_Query( $args );
		if ( $subpages->have_posts() ) { 
			$options .= '<option value="' . $page_ID . '">' . get_the_title($page_ID) . '</option>'; 
		} 
	endwhile;
	return $options;
}
function custompageorder_order_posts($orderby) {
	global $wpdb;
	$orderby = "$wpdb->posts.menu_order ASC";
	return $orderby;
}
function custompageorder_sort( $query ) {
	global $custompageorder_settings;
	$options = $custompageorder_settings;
	if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'page' ) {
		$post_type = $query->query_vars['post_type'];
	}
	if ( $options[$post_type] == 1 && !isset($_GET['orderby']) ) {
		add_filter('posts_orderby', 'custompageorder_order_posts');
	}
}
add_action('pre_get_posts', 'custompageorder_sort');
?>