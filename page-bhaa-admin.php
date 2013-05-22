<?php
/**
 * Template Name: BHAA ADMIN
*/
get_header();

echo '<p>hi</p>';

$members = array(
	'meta_key' => 'bhaa_runner_status',
	'meta_value' => 'M',
	'meta_compare' => '='
);

$missingStandard = array(
	'meta_query' => array(
		'relation' => 'AND',
		array(
				'key' => 'bhaa_runner_status',
				'value' => 'M',
				'compare' => '='
		),
		array(
				'key' => 'bhaa_runner_standard',
				'compare' => 'NOT EXISTS'
		)
	),
	'orderby'=>'ID',
	'fields'=>'all'
);

$user_query = new WP_User_Query( $missingStandard );
echo 'members :'.$user_query->get_total();

if ( ! empty( $user_query->results ) ) {
	foreach ( $user_query->results as $user ) {
		echo '<p>' .$user->ID.' - '.$user->display_name . '</p>';
	}
}

wp_reset_query();

get_footer();
?>