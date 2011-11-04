=== Plugin Name ===
Contributors: dgourley
Tags: ordering, pages, page order
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

Allows for the ordering of pages through a simple drag-and-drop interface

== Description ==

Order Up!

A series of plugins for WordPress which allow for the ordering of pages, posts, and taxonomies through a simple 
drag-and-drop interface using the available WordPress scripts and styles. The plugins are extremely lightweight,
without a bunch of unnecessary scripts to load into the admin. They also fall in line gracefully with the look 
and feel of the WordPress interface.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Order posts from the Page Order menu in the admin
4. Optionally set whether or not to have queries of the selected post type be sorted by this order automatically.
5. Optionally set `'orderby' => 'menu_order', 'order => 'ASC'` to manually sort queries by this order.
6. Visit drewgourley.com/order-up-custom-ordering-for-wordpress for more in-depth instructions
7. Enjoy!

== Frequently Asked Questions ==

= No questions have been asked yet. =

Email any questions to DrewGourley at gmail dot com

== Changelog ==

= 1.0 =
* First Version

= 2.0 =
* Complete code overhaul using WordPress query functions instead of custom SQL
* Pagination of posts in ordering interface
* Updated for WordPress 3.2 Admin Design
* Added auto-sort query option
* Various small bugfixes and optimizations

= 2.1 =
* Added pagination overlap so you may order beyond the restrictions of the page.
* Added entries per page option

= 2.2 =
* Several text fixes for overall consistency and clarity.
* Fixed a bug where the subpage dropdown would show duplicate entries.
* Various small optimizations