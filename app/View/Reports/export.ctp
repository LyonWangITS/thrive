<?php
$this->set( 'title_for_layout', 'Export data to CSV file' );
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );
?>

<p class="breadcrumb display-right">
	<a href="/admin">Dashboard</a> /
	<a href="/reports">Reports</a> /
	<strong>Export data</strong>
</p>

<div id="content" class="reports">

<h1>Export data to CSV file</h1>

<div class="content-padding admin">

<div class="filter-wrap exports">
<?php
echo $this->Form->create( false );
?>
	<h3 class="first">Select date range</h3>
	<div id="filter_wrapper">
		<?php
		echo $this->Form->input( 'from', array( 'label' => 'From (inclusive)' ) );
		echo $this->Form->input( 'to', array( 'label' => 'To (inclusive)' ) );
		?>
		<div class="submit">
			<input class="btn d-purple sm" type="submit" value="Download" />
		</div>
	</div>
</form>

</div>

<div class="clear"></div>

<script type="text/javascript">
//
// Init datepickers
var config = {
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd/mm/yy',
	minDate: new Date( '<?php echo date( JAVASCRIPT_DATE, strtotime( $current_user['Partner']['created'] ) ) ?>' ), 
	maxDate: '+0d'
};
$( '#from' ).datepicker( config );
$( '#to' ).datepicker( config );
</script>

</div>

</div>