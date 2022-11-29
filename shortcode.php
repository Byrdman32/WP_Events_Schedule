<?php

function event( $atts = array() ): string {

	// Arguments
	extract( shortcode_atts( array(
		'name'     => 'name',      // Event Name
		'alt_name' => 'aName',     // Alternate Name

		'sDate' => 'sDate',     // Start Date
		'eDate' => 'eDate',     // End Date
		'sTime' => 'sTime',     // Start Time
		'eTime' => 'eTime',     // End Time

		'loc' => 'loc',       // Location of Event
		'alt' => 'alt',       // Alternate Location of Event

		'alert' => 'alert',     // Show or Hide Announcement Message
		'msg'   => 'msg',       // Announcement Message

		'pre' => 'pre',       // Show or Hide: "Event Starting Soon"
		'mid' => 'mid',       // Show or Hide: "Event Happening"
		'end' => 'end',       // Show or Hide: "Event Ending Soon"

		'post' => 'post',      // Show or Hide: Event End Time

		'desc' => array()      // Description of Event
	), $atts ) );

	$desc = $atts['desc'];
	$desc = explode( ',', $desc );

	$preAlert_start = '';   // 15 minutes before Start
	$preAlert_end   = '';   // 00 minutes before Start
	$midAlert_start = '';   // 00 minutes before Start
	$midAlert_end   = '';   // 15 minutes before End
	$endAlert_start = '';   // 15 minutes before End
	$endAlert_end   = '';   // 00 minutes before End

	if ( $sDate != 'sDate' & $sTime != 'sTime' ) {
		// FIXME: Currently all events must start no earlier than 00:00:00

		$oldHour = substr( $sTime, 0, 2 );
		$oldMin  = substr( $sTime, 3, 2 );
		$oldSec  = substr( $sTime, 6 );

		$month  = substr( $sDate, 0, 2 );
		$day    = substr( $sDate, 3, 2 );
		$year   = substr( $sDate, 6 );
		$hour   = substr( $sDate, 0, 2 );
		$minute = substr( $sDate, 3, 2 );
		$second = substr( $sDate, 6 );

		$logic  = timeLogic( $month, $day, $year, $hour, $minute, $second );
		$hour   = $logic[0];
		$minute = $logic[1];

		$preAlert_start = $sDate . ' ' . $hour . ':' . $minute . ':' . $second;
		$preAlert_end   = $sDate . ' ' . $oldhour . ':' . $oldminute . ':' . $oldsecond;
		$midAlert_start = $sDate . ' ' . $oldhour . ':' . $oldminute . ':' . $oldsecond;
	}

	if ( $eDate != 'sDate' & $eTime != 'sTime' ) {
		// FIXME: Currently all events must end no earlier than 23:59:59

		$eoldHour = substr( $eTime, 0, 2 );
		$eoldMin  = substr( $eTime, 3, 2 );
		$eoldSec  = substr( $eTime, 6 );

		$emonth  = substr( $eDate, 0, 2 );
		$eday    = substr( $eDate, 3, 2 );
		$eyear   = substr( $eDate, 6 );
		$ehour   = substr( $eDate, 0, 2 );
		$eminute = substr( $eDate, 3, 2 );
		$esecond = substr( $eDate, 6 );

		$logic   = timeLogic( $emonth, $eday, $eyear, $ehour, $eminute, $esecond );
		$ehour   = $logic[0];
		$eminute = $logic[1];

		$midAlert_end   = $eDate . ' ' . $ehour . ':' . $eminute . ':' . $esecond;
		$endAlert_start = $eDate . ' ' . $ehour . ':' . $eminute . ':' . $esecond;
		$endAlert_end   = $eDate . ' ' . $eoldHour . ':' . $eoldMin . ':' . $eoldSec;
	}

	$Content = "<style>\r\n";
	$Content .= ".eventObject {\r\n";
	$Content .= "margin-top: 1.5rem;\r\n";
	$Content .= "margin-bottom: 0;\r\n";
	$Content .= "}\r\n";
	$Content .= ".eventLine {\r\n";
	$Content .= "font-size: 1.2rem;\r\n";
	$Content .= "margin-top: 0px;\r\n";
	$Content .= "margin-bottom: 0px;\r\n";
	$Content .= "}\r\n";
	$Content .= ".green {\r\n";
	$Content .= "color: #329900;\r\n";
	$Content .= "font-style: italic;\r\n";
	$Content .= "margin-top: 0px;\r\n";
	$Content .= "margin-bottom: 0px;\r\n";
	$Content .= "}\r\n";
	$Content .= ".yellow {\r\n";
	$Content .= "color: #fcb900;\r\n";
	$Content .= "font-style: italic;\r\n";
	$Content .= "margin-top: 0px;\r\n";
	$Content .= "margin-bottom: 0px;\r\n";
	$Content .= "}\r\n";
	$Content .= ".red {\r\n";
	$Content .= "color: #cf2e2e;\r\n";
	$Content .= "font-style: italic;\r\n";
	$Content .= "margin-top: 0px;\r\n";
	$Content .= "margin-bottom: 0px;\r\n";
	$Content .= "}\r\n";
	$Content .= ".rain {\r\n";
	$Content .= "color: #f22222;\r\n";
	$Content .= "background-color: rgba(0,0,0,0);\r\n";
	$Content .= "}\r\n";
	$Content .= "</style>\r\n";
	$Content .= '<div class="eventObject">';

	if ( $sDate != 'sDate' ) {

		$month   = substr( $sDate, 0, 2 );
		$day     = substr( $sDate, 3, 2 );
		$year    = substr( $sDate, 6 );
		$hour    = substr( $sTime, 0, 2 );
		$minute  = substr( $sTime, 3, 2 );
		$hour2   = substr( $eTime, 0, 2 );
		$minute2 = substr( $eTime, 3, 2 );

		$rain_out     = "<strong><mark class=\"rain\">(Rain Plan Active)</mark></strong>";
		$announce_out = "<strong><mark class=\"rain\">$msg</mark></strong>";
		$alt_name_out = "<em>$alt_name</em>";

		$stringDateTime = timeToString( $month, $hour, $minute, $hour2, $minute2 );

		if ( $alert == 'rain' ) {
			if ( $post == 'yes' ) {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . ' - ' . $stringDateTime[2] . ' ' . $rain_out . '[/time-restrict]';
			} else {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . ' ' . $rain_out . '[/time-restrict]';
			}
		} else if ( $alert == 'other' && $msg != 'no' ) {
			if ( $post == 'yes' ) {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . ' - ' . $stringDateTime[2] . ' ' . $announcement_out . '[/time-restrict]';
			} else {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . ' ' . $announcement_out . '[/time-restrict]';
			}
		} else {
			if ( $post == 'yes' ) {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . ' - ' . $stringDateTime[2] . '[/time-restrict]';
			} else {
				$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $stringDateTime[0] . ' ' . $day . ', ' . $year . ' @ ' . $stringDateTime[1] . '[/time-restrict]';
			}
		}

		if ( $name != 'name' ) {
			$Content .= '<p class="eventLine">';

			if ( $alert == 'rain' && $alt != 'loc' ) {
				if ( $alt_name != 'aName' ) {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . $name . ' (' . $alt_name_out . ')</strong> | ' . $alt_location . '[/time-restrict]';
				} else {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . $name . '</strong> | ' . $alt_location . '[/time-restrict]';
				}
			} elseif ( $location != 'loc' ) {
				if ( $alt_name != 'aName' ) {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . $name . ' (' . $alt_name_out . ')</strong> | ' . $location . '[/time-restrict]';
				} else {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . $name . '</strong> | ' . $location . '[/time-restrict]';
				}
			} else {
				if ( $alt_name != 'aName' ) {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . ' ' . $name . ' (' . $alt_name_out . ')</strong>[/time-restrict]';
				} else {
					$Content .= '[time-restrict off="' . $end_date . ' ' . $end_time . '"]<strong>' . $name . '</strong>[/time-restrict]';
				}
			}

			$Content .= '</p>';
		}
	}

	if ( $sDate != 'sDate' && $sTime != 'sTime' && $eDate != 'eDate' && $eTime != 'eTime' ) {
		if ( $pre == 'on' ) {
			echo $pre;
			$Content .= '<p class="green">';
			$Content .= '[time-restrict on="' . $preAlert_start . '" off="' . $preAlert_end . '"]<strong>Event Starting Soon</strong>[/time-restrict]';
			$Content .= '</p>';
		}

		if ( $mid == 'on' ) {
			echo $mid;
			$Content .= '<p class="yellow">';
			$Content .= '[time-restrict on="' . $midAlert_start . '" off="' . $midAlert_end . '"]<strong>Happening Now</strong>[/time-restrict]';
			$Content .= '</p>';
		}

		if ( $end == 'on' ) {
			echo $end;
			$Content .= '<p class="red">';
			$Content .= '[time-restrict on="' . $endAlert_start . '" off="' . $endAlert_end . '"]<strong>Event Ending Soon</strong>[/time-restrict]';
			$Content .= '</p>';
		}
	}

	if ( $desc[0] != "" ) {
		$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]<ul>[/time-restrict]';

		for ( $x = 0; $x < sizeof( $desc ); $x += 1 ) {
			$Content .= '';
			$Content .= '[time-restrict off="' . $eDate . ' ' . $Time . '"]<li>[/time-restrict]';
			$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]' . $description[ $x ] . '[/time-restrict]';
			$Content .= '[time-restrict off="' . $eDate . ' ' . $eTime . '"]</li>[/time-restrict]';
		}
	}

	$Content .= '</div>';

	return $Content;
}

function timeLogic( $month, $day, $year, $hour, $minute, $second ): array {

	$tempMin  = (int) $minute;
	$tempHour = (int) $hour;

	if ( $tempMin < 15 ) {

		$min = 45 + $tempMin;

	} else {

		$min = $tempMin - 15;

	}
	if ( $tempHour != 0 && $tempHour < 10 ) {
		$output = '0' . $tempHour;
	} else {
		$output = $tempHour;
	}

	return array( $output, $min );
}

function timeToString( $month, $sHour, $sMin, $eHour, $eMin ): array {

	$tempMonth = '';
	$tempTime  = '';
	$tempTime2 = '';

	switch ( $month ) {
		case '01':
			$tempMonth = 'January';
			break;
		case '02':
			$tempMonth = 'February';
			break;
		case '03':
			$tempMonth = 'March';
			break;
		case '04':
			$tempMonth = 'April';
			break;
		case '05':
			$tempMonth = 'May';
			break;
		case '06':
			$tempMonth = 'June';
			break;
		case '07':
			$tempMonth = 'July';
			break;
		case '08':
			$tempMonth = 'August';
			break;
		case '09':
			$tempMonth = 'September';
			break;
		case '10':
			$tempMonth = 'October';
			break;
		case '11':
			$tempMonth = 'November';
			break;
		case '12':
			$tempMonth = 'December';
			break;
		default:
			echo "Invalid Date";
	}
	switch ( $sHour ) {
		case '00':
			$tempTime = '12:' . $sMin . ' AM';
			break;
		case '01':
			$tempTime = '1:' . $sMin . ' AM';
			break;
		case '02':
			$tempTime = '2:' . $sMin . ' AM';
			break;
		case '03':
			$tempTime = '3:' . $sMin . ' AM';
			break;
		case '04':
			$tempTime = '4:' . $sMin . ' AM';
			break;
		case '05':
			$tempTime = '5:' . $sMin . ' AM';
			break;
		case '06':
			$tempTime = '6:' . $sMin . ' AM';
			break;
		case '07':
			$tempTime = '7:' . $sMin . ' AM';
			break;
		case '08':
			$tempTime = '8:' . $sMin . ' AM';
			break;
		case '09':
			$tempTime = '9:' . $sMin . ' AM';
			break;
		case '10':
			$tempTime = '10:' . $sMin . ' AM';
			break;
		case '11':
			$tempTime = '11:' . $sMin . ' AM';
			break;
		case '12':
			$tempTime = '12:' . $sMin . ' PM';
			break;
		case '13':
			$tempTime = '1:' . $sMin . ' PM';
			break;
		case '14':
			$tempTime = '2:' . $sMin . ' PM';
			break;
		case '15':
			$tempTime = '3:' . $sMin . ' PM';
			break;
		case '16':
			$tempTime = '4:' . $sMin . ' PM';
			break;
		case '17':
			$tempTime = '5:' . $sMin . ' PM';
			break;
		case '18':
			$tempTime = '6:' . $sMin . ' PM';
			break;
		case '19':
			$tempTime = '7:' . $sMin . ' PM';
			break;
		case '20':
			$tempTime = '8:' . $sMin . ' PM';
			break;
		case '21':
			$tempTime = '9:' . $sMin . ' PM';
			break;
		case '22':
			$tempTime = '10:' . $sMin . ' PM';
			break;
		case '23':
			$tempTime = '11:' . $sMin . ' PM';
			break;
	}
	switch ( $eHour ) {
		case '00':
			$tempTime2 = '12:' . $eMin . ' AM';
			break;
		case '01':
			$tempTime2 = '1:' . $eMin . ' AM';
			break;
		case '02':
			$tempTime2 = '2:' . $eMin . ' AM';
			break;
		case '03':
			$tempTime2 = '3:' . $eMin . ' AM';
			break;
		case '04':
			$tempTime2 = '4:' . $eMin . ' AM';
			break;
		case '05':
			$tempTime2 = '5:' . $eMin . ' AM';
			break;
		case '06':
			$tempTime2 = '6:' . $eMin . ' AM';
			break;
		case '07':
			$tempTime2 = '7:' . $eMin . ' AM';
			break;
		case '08':
			$tempTime2 = '8:' . $eMin . ' AM';
			break;
		case '09':
			$tempTime2 = '9:' . $eMin . ' AM';
			break;
		case '10':
			$tempTime2 = '10:' . $eMin . ' AM';
			break;
		case '11':
			$tempTime2 = '11:' . $eMin . ' AM';
			break;
		case '12':
			$tempTime2 = '12:' . $eMin . ' PM';
			break;
		case '13':
			$tempTime2 = '1:' . $eMin . ' PM';
			break;
		case '14':
			$tempTime2 = '2:' . $eMin . ' PM';
			break;
		case '15':
			$tempTime2 = '3:' . $eMin . ' PM';
			break;
		case '16':
			$tempTime2 = '4:' . $eMin . ' PM';
			break;
		case '17':
			$tempTime2 = '5:' . $eMin . ' PM';
			break;
		case '18':
			$tempTime2 = '6:' . $eMin . ' PM';
			break;
		case '19':
			$tempTime2 = '7:' . $eMin . ' PM';
			break;
		case '20':
			$tempTime2 = '8:' . $eMin . ' PM';
			break;
		case '21':
			$tempTime2 = '9:' . $eMin . ' PM';
			break;
		case '22':
			$tempTime2 = '10:' . $eMin . ' PM';
			break;
		case '23':
			$tempTime2 = '11:' . $eMin . ' PM';
			break;
	}

	return array( $tempMonth, $tempTime, $tempTime2 );
}

function build_page(  $atts = array() ): string {

	extract( shortcode_atts( array(
		'event_name'    => 'event_name',        // Event Name
		'startDate'     => 'startDate',         // Start Date
		'endDate'       => 'endDate',           // End Date
	), $atts ) );

	$Content = "";

	$startDate   = date( 'Y-m-d H:i:s', strtotime( $startDate ) );
	$endDate     = date( 'Y-m-d H:i:s', strtotime( $endDate ) );
	$currentDate = date( 'Y-m-d H:i:s' );

	global $wpdb;
	$table_name = $wpdb->prefix . 'my_schedule';

	$results = $wpdb->get_results( "SELECT * FROM $table_name" );

	if ( ! empty( $results ) ) {
		$Content .= "<p style=\"font-size:1.25rem\">Friday</p>";
		foreach ( $results as $row ) {
			if ( $row->event == $event_name ) {
				if ( date( 'Y-m-d', strtotime($row->start_dnt)) == date( 'Y-m-d', strtotime($startDate)) ) {
					if ( $row->end_dnt > $currentDate ) {
						$Content .= buildShort( $row->start_dnt, $row->end_dnt, $row->title, $row->loc, $row->show_pre, $row->show_mid, $row->show_post, $row->show_end ) . "\r\n";
					}
				}
			}
		}

		$Content .= "<p style=\"font-size:1.25rem\">Saturday</p>";
		foreach ( $results as $row ) {
			if ( $row->event == $event_name ) {
				if ( date( 'Y-m-d', strtotime($row->start_dnt)) == date('Y-m-d', strtotime($startDate. ' + 1 days')) ) {
					if ( $row->end_dnt > $currentDate ) {
						$Content .= buildShort( $row->start_dnt, $row->end_dnt, $row->title, $row->loc, $row->show_pre, $row->show_mid, $row->show_post, $row->show_end ) . "\r\n";
					}
				}
			}
		}

		$Content .= "<p style=\"font-size:1.25rem\">Sunday</p>";
		foreach ( $results as $row ) {
			if ( $row->event == $event_name ) {
				if ( date( 'Y-m-d', strtotime($row->start_dnt)) == date( 'Y-m-d', strtotime($endDate)) ) {
					if ( $row->end_dnt > $currentDate ) {
						$Content .= buildShort( $row->start_dnt, $row->end_dnt, $row->title, $row->loc, $row->show_pre, $row->show_mid, $row->show_post, $row->show_end ) . "\r\n";
					}
				}
			}
		}
	}

	return $Content;
}

function buildShort( $start_dnt, $end_dnt, $title, $loc, $show_pre, $show_mid, $show_post, $show_end ): string {

	$sDate = explode( ' ', $start_dnt );
	$eDate = explode( ' ', $end_dnt );
	$pre   = 'false';
	$mid   = 'false';
	$post  = 'false';
	$end   = 'false';

	if ( $show_pre == 1 ) {
		$pre = 'true';
	}

	if ( $show_mid == 1 ) {
		$mid = 'true';
	}

	if ( $show_post == 1 ) {
		$post = 'true';
	}

	if ( $show_end == 1 ) {
		$end = 'true';
	}

	$output = '[custom-event name=\'';
	$output .= $title;
	$output .= '\' sDate=\'';
	$output .= $sDate[0];
	$output .= '\' sTime=\'';
	$output .= $sDate[1];
	$output .= ':00\' eDate=\'';
	$output .= $eDate[0];
	$output .= '\' eTime=\'';
	$output .= $eDate[1];
	$output .= ':00\' loc=\'';
	$output .= $loc;
	$output .= '\' pre=\'';
	$output .= $pre;
	$output .= '\' mid=\'';
	$output .= $mid;
	$output .= '\' end=\'';
	$output .= $post;
	$output .= '\' post=\'';
	$output .= $end;
	$output .= '\' ]';

	return $output;
}

add_shortcode('custom-event', 'event');
add_shortcode('all-events', 'build_page');

//echo build_page( array ( 'event_name' => 'LLD ', 'startDate' => '2023-01-13 17:30', 'endDate' => '2023-01-15 11:00' ));