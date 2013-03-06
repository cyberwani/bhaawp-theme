<?php get_header(); ?>
	<?php
	if($data['blog_full_width']) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
	} elseif($data['blog_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif($data['blog_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}
	
	$leagueSummary = new LeagueSummary(get_the_ID());
	$division = strtoupper( get_query_var('division'));
	$table = $leagueSummary->getDivisionSummary('A');
	?>
	<div id="content" style="<?php echo $content_css; ?>">
	
		<div class="portfolio-content">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<h4><?php echo get_the_term_list($post->ID, 'division', '', ', ', ''); ?></h4>
			<?php the_excerpt(); ?>
			<div class="buttons"></div>
		</div>
		Division <?php echo $division; ?>
	
<?php 

echo '<table>';
echo '<tr>
	<th>Position</th>
    <th>Name</th>
    <th>Standard</th>
	<th>Races</th>
  	<th>Points</th>
	</tr>';

foreach($table as $row) :
//[ID] => 1600 [user_login] => martin.prunty 
// [user_pass] => $.8/ 
// [user_nicename] => martin-prunty 
// [user_email] =>[user_url] => [user_registered] => 2012-12-01 15:03:58 
// [user_activation_key] => [user_status] => 0 [display_name] => Martin Prunty ) 
// [2] => stdClass Object ( [league] => 2492 [leaguetype] => I 
// [leagueparticipant] => 1628 [leaguestandard] => 7 [leaguedivision] => A 
// [leagueposition] => 37 [leaguescorecount] => 1 [leaguepoints] => 10 
// [leaguesummary] => {"eid":"2121","race":"2359","leaguepoints":"10"},{"eid":"2123","race":"2362","leaguepoints":"10"}
if($row->leaguedivision!=$division)
{
	$i++;
}
else
{
	// specific row
	echo '<tr>
	<td>'.$row->leagueposition.'</td>
    <td>'.$row->display_name.'</td>
    <td>'.$row->leaguestandard.'</td>
	<td>'.$row->leaguescorecount.'</td>
    <td>'.$row->leaguepoints.'</td>
  	</tr>';
}

endforeach;
echo '</table>';
?>
		<?php //echo print_r($table); ?>
		
	</div>
<?php get_footer(); ?>