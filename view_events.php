<?php

global $wpdb;
$table_name = $wpdb->prefix . 'my_schedule';

$results = $wpdb->get_results( "SELECT * FROM $table_name" );
if ( ! empty( $results ) ) {
	echo "<h1>Events</h1>";
	echo "<table border='1'>";
	echo "<tbody>";
	echo "<tr>";
	echo "
		<th colspan='5'>ID</th>" .
		"<th colspan='10'>Event</th>" .
		"<th colspan='22'>Start DNT</th>" .
		"<th colspan='22'>End DNT</th>" .
		"<th colspan='22'>Title</th>" .
		"<th colspan='22'>Location</th>" .
		"<th  colspan='10'>Show Pre</th>" .
		"<th  colspan='10'>Show Mid</th>" .
		"<th  colspan='10'>Show Post</th>" .
		"<th  colspan='10'>Show End</th>";
	echo "<hr size='1'>";
	echo "</tr>";
	foreach ( $results as $row ) {
		echo "<tr>";
		echo "
				<td colspan='5'>" . $row->id . "</td>" . "
				<td colspan='10'>" . $row->event . "</td>" . "
				<td colspan='22'>" . $row->start_dnt . "</td>" . "
				<td colspan='22'>" . $row->end_dnt . "</td>" . "
				<td colspan='22'>" . $row->title . "</td>" . "
				<td colspan='22'>" . $row->loc . "</td>" . "
				<td colspan='10'>" . $row->show_pre . "</td>" . "
				<td colspan='10'>" . $row->show_mid . "</td>" . "
				<td colspan='10'>" . $row->show_post . "</td>" . "
				<td colspan='10'>" . $row->show_end . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";

}