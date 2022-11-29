<?php
/**
 * id           - Required Incrementer
 * start_dnt    - Start Date and Time of Event
 * end_dnt      - End Date and Time of Event
 * title        - Title of Event
 * event        - Lodge Event Name
 * loc          - Location of Event
 * show_pre     - Show "Event Starting Soon" Banner (0 = false, 1 = true)
 * show_mid     - Show "Event Happening Now" Banner (0 = false, 1 = true)
 * show_post    - Show "Event Ending Soon" Banner   (0 = false, 1 = true)
 * show_end     - Show End Time of Event            (0 = false, 1 = true)
 */


function add_event_to_db(): void {


	if (!empty($_POST)) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'my_schedule';

		$data = array(
			'start_dnt' => $_POST['start_dnt'],
			'end_dnt'   => $_POST['end_dnt'],
            'event'     => $_POST['event'],
			'loc'       => $_POST['loc'],
			'show_pre'  => $_POST['show_pre'],
			'show_mid'  => $_POST['show_mid'],
			'show_post' => $_POST['show_post'],
			'show_end'  => $_POST['show_end'],
			'title'     => $_POST['title']
		);
		$success=$wpdb->insert( $table_name, $data );
		if($success){
			echo 'data has been save' ;
		}
	} else {
		?>
		<form method="post">
			<label>Start Date and Time (Y-m-d H:i): </label><input type="text" name="start_dnt" /><br />
			<label>End Date and Time (Y-m-d H:i):</label><input type="text" name="end_dnt" /><br />
            <label>Lodge Event Name: </label><input type="text" name="event" /><br />
			<label>Event Name: </label><input type="text" name="title" /><br />
			<label>Event Location: </label><input type="text" name="loc" /><br />
			<label>Show Pre (0 = false, 1 = true): </label><input type="text" name="show_pre" /><br />
			<label>Show Mid (0 = false, 1 = true): </label><input type="text" name="show_mid" /><br />
			<label>Show Post (0 = false, 1 = true): </label><input type="text" name="show_post" /><br />
			<label>Show End (0 = false, 1 = true): </label><input type="text" name="show_end" /><br />
			<input type="submit">
		</form>
		<?php
	}
}

echo "<h1>Add Event</h1>";
echo "<hr size='1'>";
add_event_to_db();