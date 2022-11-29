<?php

/*
Plugin Name: Event Scheduler
Plugin URI: https://github.com/Byrdman32/WP_Events_Schedule
Description: Custom WordPress Plugin that generates a schedule for your event.
Version: 0.2
Author: Eli Byrd
Author URI: https://github.com/Byrdman32
License: GPL2 or later
*/

register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db(): void {

	global $wpdb;
	$version         = get_option( 'my_plugin_version', '0.1' );
	$charset_collate = $wpdb->get_charset_collate();
	$table_name      = $wpdb->prefix . 'my_schedule';


	/**
	 * id           - Required Incrementer
	 * start_dnt    - Start Date and Time of Event
	 * end_dnt      - End Date and Time of Event
	 * title        - Title of Event
	 * loc          - Location of Event
	 * show_pre     - Show "Event Starting Soon" Banner (0 = false, 1 = true)
	 * show_mid     - Show "Event Happening Now" Banner (0 = false, 1 = true)
	 * show_post    - Show "Event Ending Soon" Banner   (0 = false, 1 = true)
	 * show_end     - Show End Time of Event            (0 = false, 1 = true)
	 */

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		start_dnt datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		end_dnt datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		title text NOT NULL,
		loc longtext NOT NULL,
	  	show_pre smallint(5) DEFAULT 0 NOT NULL,
	  	show_mid smallint(5) DEFAULT 0 NOT NULL,
	  	show_post smallint(5) DEFAULT 0 NOT NULL,
	  	show_end smallint(5) DEFAULT 0 NOT NULL,
		event text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

function event_schedule_setup_menu(): void {
	add_menu_page( 'Custom Plugin', 'Event Schedule', 'manage_options', 'event_schedule', 'about');
	add_submenu_page('event_schedule', 'Add Event', 'Add Event', 'manage_options', 'add_event', 'add_event');
	add_submenu_page('event_schedule', 'Edit Event', 'Edit Event', 'manage_options', 'edit_event', 'edit_event');
	add_submenu_page('event_schedule', 'Delete Event', 'Delete Event', 'manage_options', 'delete_event', 'delete_event');
	add_submenu_page('event_schedule', 'View Events', 'View Events', 'manage_options', 'view_events', 'view_events');
	add_submenu_page('event_schedule', 'View Shortcode', 'View Shortcode', 'manage_options', 'view_shortcode', 'view_shortcode');
}

add_action('admin_menu', 'event_schedule_setup_menu');

function about(): void {
	echo "<h1>Custom Event Schedule</h1>";
	echo "<p> Add/Edit/Remove Events from the Event Schedule Database</p>";
}

function add_event(): void {
	include "add_event.php";
}

function edit_event(): void {
	include "edit_event.php";
}

function delete_event(): void {
	include "delete_event.php";
}

function view_events(): void {
	include "view_events.php";
}

function view_shortcode(): void {
	include "shortcode.php";
}

//add_shortcode('build-page', 'build_page');