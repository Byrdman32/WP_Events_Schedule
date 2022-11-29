<?php
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

function add_event_to_db(): void {
	global $wpdb;
	$table_name = $wpdb->prefix . 'my_schedule';

	echo '<form method="POST">
             <label>Start Date and Time (Y-m-d H:i): </label><input type="text" name="start_dnt" /><br />
             <label>End Date and Time (Y-m-d H:i):</label><input type="text" name="end_dnt" /><br />
             <label>Event Name: </label><input type="text" name="title" /><br />
             <label>Event Location: </label><input type="text" name="loc" /><br />
             <label>Show Pre (0 = false, 1 = true): </label><input type="text" name="show_pre" /><br />
             <label>Show Mid (0 = false, 1 = true): </label><input type="text" name="show_mid" /><br />
             <label>Show Post (0 = false, 1 = true): </label><input type="text" name="show_post" /><br />
             <label>Show End (0 = false, 1 = true): </label><input type="text" name="show_end" /><br />
            <input type="submit" value="submit" />
        </form>';

//	$default_row = $wpdb->get_row( "SELECT * FROM $table_name ORDER BY title DESC LIMIT 1" );
//	if ( $default_row != null ) {
//		$id = $default_row->team_id + 1;
//	} else {
//		$id = 1;
//	}
	$default = array(
		'id'        => null,
		'start_dnt' => '',
		'end_dnt'   => '',
		'title'     => '',
		'loc'       => '',
		'show_pre'  => '',
		'show_mid'  => '',
		'show_post' => '',
		'show_end'  => ''
	);
	$item = shortcode_atts( $default, $_REQUEST );

	$wpdb->insert( $table_name, $item );
}

add_event_to_db();