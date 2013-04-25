<?php
/**
 * Template Name: BHAA Raceday Admin
 */
if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

if(isset($_GET['action'])){
	$race = trim($_GET['raceid']);
	$booking = trim($_GET['booking']);
	
	global $wpdb;
	
	if($_GET['action']=='deleterunner') {
		$runner = trim($_GET['runner']);
		error_log("deleterunner ".$runner.' '.$race);
		$BHAA->registration->deleteRunner($runner,$race);
	} elseif($_GET['action']=='deleteall') {
		error_log("deleteall ".$booking.' '.$race);
		$wpdb->query(
			$wpdb->prepare('delete from wp_bhaa_raceresult where class="RACE_REG" and race=%d',$race)
		);
	} elseif($_GET['action']=='preregimport') {
		error_log("preregimport ".$booking.' '.$race);
		$wpdb->query(
			$wpdb->prepare('delete from wp_bhaa_raceresult where class="PRE_REG" and race=%d',$race)
		);
		$wpdb->query(
			$wpdb->prepare('insert into wp_bhaa_raceresult(race,runner,class)
				select %d,person_id,"PRE_REG"
				from wp_em_bookings 
				join wp_users on wp_users.id=wp_em_bookings.person_id
				where event_id=%d
				and booking_status=1
				order by display_name desc',$race,$booking)		
		);

	} elseif($_GET['action']=='preregexport') {
		error_log("preregexport ".$booking.' '.$race);
	}
}

get_header();

include_once 'page-raceday-header.php';

$racetec = $BHAA->registration->listRegisteredRunners();

echo '<h2>BHAA RACE DAY ADMIN</h2>';
echo '<h3>Actions</h3>';
echo sprintf('<h3><a href="/raceday-admin/?action=preregimport&booking=%d&raceid=%d">Import PRE_REG</a></h3>',113,2598);
echo sprintf('<h3><a href="/raceday-admin/?action=preregexport&booking=%d&raceid=%d">Export PRE_REG</a></h3>',113,2598);
echo sprintf('<h3><a href="/raceday-admin/?action=deleteall&booking=%d&raceid=%d">Delete All RACE_REG</a></h3>',113,2598);
echo '<hr/>';

echo '<table id="raceteclist" >
<tr class="row">
<th class="cell">Name</th>
<th class="cell">Number</th>
<th class="cell">DELETE</th>
</tr>';

foreach($racetec as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->racenumber;?></td>
<td class="cell"><?php echo sprintf('<a href="/raceday-admin/?action=deleterunner&runner=%d&raceid=%d">%d</a>',$racetec->runner,$racetec->race,$racetec->runner);?></td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>