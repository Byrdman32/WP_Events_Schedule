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


function edit_event_to_db(): void {


	if (!empty($_POST)) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'my_schedule';

        $data = array(
	        $_POST['field'] => $_POST['updateValue']
        );

//		$data = array(
//			'start_dnt' => $_POST['start_dnt'],
//			'end_dnt'   => $_POST['end_dnt'],
//            'event'     => $_POST['event'],
//			'loc'       => $_POST['loc'],
//			'show_pre'  => $_POST['show_pre'],
//			'show_mid'  => $_POST['show_mid'],
//			'show_post' => $_POST['show_post'],
//			'show_end'  => $_POST['show_end'],
//			'title'     => $_POST['title']
//		);

        $where = array('id'=>$_POST['id']);
		$success=$wpdb->update( $table_name, $data, $where);
		if($success){
			echo 'data has been saved' ;
		} else {
			echo 'data has not been saved' ;
		}
	} else {
		?>
		<form method="post">
            <label>ID: </label><input type="number" name="id" /><br />
            <label>Field: </label>
            <select id="field" name="field">
                <option value="start_dnt">Start Date and Time (Y-m-d H:i)</option>
                <option value="end_dnt">End Date and Time (Y-m-d H:i)</option>
                <option value="event">Lodge Event Name</option>
                <option value="title">Event Name</option>
                <option value="loc">Event Location</option>
                <option value="show_pre">Show Pre (0 = false, 1 = true)</option>
                <option value="show_mid">Show Mid (0 = false, 1 = true)</option>
                <option value="show_post">Show Post (0 = false, 1 = true)</option>
                <option value="show_end">Show End (0 = false, 1 = true)</option>
            </select>
			<label>Value: </label><input type="text" name="updateValue" /><br />
			<input type="submit">
		</form>
		<?php
	}
}

echo "<h1>Edit Event</h1>";
echo "<hr size='1'>";
edit_event_to_db();