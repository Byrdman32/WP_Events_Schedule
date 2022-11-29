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


function delete_event_to_db(): void {


	if (!empty($_POST)) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'my_schedule';

        $where = array('id'=>$_POST['id']);

        if (strtolower($_POST['confirm']) == 'confirm') {
            $success=$wpdb->delete( $table_name, $where );
            if($success){
                echo 'data has been deleted' ;
            }
        } else {
            echo 'data has not been deleted' ;
        }
	} else {
		?>
		<form method="post">
            <label>ID: </label><input type="number" name="id" /><br />
			<label>Type Confirm: </label><input type="text" name="confirm" /><br />
			<input type="submit">
		</form>
		<?php
	}
}

echo "<h1>Edit Event</h1>";
echo "<hr size='1'>";
delete_event_to_db();