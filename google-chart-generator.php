<?php
/*
Plugin Name: Google Chart Generator
Plugin URI: http://brockangelo.com/wordpress/plugins/google-chart-generator/
Description: Allows the user to create and insert a Google Chart in posts and pages.
Version: 1.0
Author: Brock Angelo
Author URI: http://brockangelo.com

Copyright 2009  Brock Angelo  (email : email@brockangelo.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


# add_action('google_chart_generator', 'delete_spam_now');

# function gcg_start_schedule() {
# 	wp_schedule_event(time(), 'daily', 'google_chart_generator');
# }

function delete_spam_now() {
	global $wpdb;
	$wpdb->query("delete from $wpdb->comments where comment_approved='spam';");
	$wpdb->query("OPTIMIZE TABLE $wpdb->comments;");
}

function get_spam_count() {
	global $wpdb;
	$gcg_spam_count = $wpdb->get_var("SELECT COUNT(*) from $wpdb->comments where comment_approved='spam';");
	
	echo $gcg_spam_count;
}

function reschedule_delete_spam() {
	wp_reschedule_event( (time()+60), 'daily', 'google_chart_generator'); 
}

add_action('admin_menu', 'gcg_menu');

function gcg_menu() {
  add_options_page('Google Chart Generator Options', 'Google Chart Generator', 8, __FILE__, 'gcg_options');
}

function gcg_options() {
	$valid_nonce = wp_verify_nonce($_REQUEST['_wpnonce'],'google_chart_generator');
	if ( $valid_nonce ) {
		if(isset($_REQUEST['delete_spam_now_button'])) {
			delete_spam_now();
		}
		if(isset($_REQUEST['google_chart_generator_button'])) {
			gcg_start_schedule();
		}
		if(isset($_REQUEST['stop_deleting_spam_button'])) {
			gcg_stop_schedule();
		}
		if(isset($_REQUEST['reschedule_delete_spam_button'])) {
			reschedule_delete_spam();
		}
	}
  
	if ( !empty($_POST ) ) : ?>
	<div id="message" class="updated fade">
	<strong>Chart updated</strong>
	</div>
	<?php endif; ?>

	<div class="wrap">
	<h2>Google Chart Generator Options</h2>

	<?php 
	echo '<form name="delete_spam_now_button" action="" method="post">';
	if ( function_exists('wp_nonce_field') )
	wp_nonce_field('google_chart_generator');

	echo '<input type="hidden" name="delete_spam_now_button" value="update" />';
	echo '<div><input id="delete_spam_now_button" type="submit" value="Delete spam now &raquo;" /></div>';
	echo "</form>\n<br />";
	
	if (wp_next_scheduled('google_chart_generator') == NULL)
	{
		echo '<form name="google_chart_generator_button" action="" method="post">';
		if ( function_exists('wp_nonce_field') )
		wp_nonce_field('google_chart_generator');
	
		echo '<input type="hidden" name="google_chart_generator_button" value="update" />';
		echo '<div><input id="google_chart_generator_button" type="submit" value="Delete spam daily &raquo;" /></div>';
		echo "</form>\n";
	} 
	else 
	{
		echo '<form name="stop_deleting_spam_button" action="" method="post">';
		if ( function_exists('wp_nonce_field') )
		wp_nonce_field('google_chart_generator');
	
		echo '<input type="hidden" name="stop_deleting_spam_button" value="update" />';
		echo '<div><input id="stop_deleting_spam_button" type="submit" value="Stop Deleting Spam &raquo;" /></div>';
		echo "</form>\n";
	
	
		echo '<form name="reschedule_delete_spam_button" action="" method="post">';
		if ( function_exists('wp_nonce_field') )
		wp_nonce_field('google_chart_generator');

		echo '<input type="hidden" name="reschedule_delete_spam_button" value="update" />';
		echo '<div><input id="reschedule_delete_spam_button" type="submit" value="Reschedule to start in 1 minute &raquo;" /> <i>Helpful for testing cron</i></div>';
		echo "</form>\n<br />"; 
		
	}
	?>
	<br />
	<br />
	Deactivating this plugin will stop the schedule. <br />
	</div>

	<?php
	}

register_deactivation_hook(__FILE__, 'gcg_stop_schedule');

function gcg_stop_schedule() {
	wp_clear_scheduled_hook('google_chart_generator');
}

?>