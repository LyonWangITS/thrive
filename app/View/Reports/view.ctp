<?php
/**
*	There is a lot of common code for all the reports, so this is the base template
*	that sets all of that up.
*/

//
// Start of page
$page_title = "{$section_name} reports";
if ( !empty( $report_name ) ) {

	$page_title = $report_name . " - {$page_title}";
}
$this->set( 'title_for_layout', $page_title );
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );
?>


<p class="breadcrumb display-right">
	<a href="/admin">Dashboard</a> /
	<a href="/reports">Reports</a> /
	<?php
	if ( empty( $report_name ) ) {

		echo "<strong>{$section_name}</strong>";
	}
	else {

		echo "<a href=\"/reports/view/{$section}\">{$section_name}</a> / ";
		echo "<strong>{$report_name}</strong>";
	}
	?>
</p>

<div id="content" class="reports">

	<?php
	if ( empty( $report_name ) ) {

		echo "<h1>{$section_name} reports</h1>";
	}
	else {

		echo "<h1>{$report_name}</h1>";
	}
	?>

	<div class="content-padding admin">

		<div class="select-wrap">

			<p class="label">Select report</p>

			<div class="selected-option">
				
				<p><?php echo ( !empty( $report_name ) ) ? $report_name : 'Click to show'; ?></p>
				<a class="icn drop" href="#" title="Open selection"></a>
				
			</div>

			<ul class="select-menu">
				<?php
				foreach ( $reports[$section] as $report_slug => $report_details ) {
			
					if ( strpos( $report_slug, '_' ) === 0 ) {
			
						continue;
					}
					$active_class = ( $report_slug == $report ) ? 'active' : '';
					echo "<li class=\"{$active_class}\"><a href=\"/reports/view/{$section}/{$report_slug}\">{$report_details['title']}</a></li>";
				}
				?>
			</ul>

		</div>

		<?php 
		//
		// If there's a report, display interactive graph
		if ( !empty( $report ) ) {
			?>
			<div class="filter-wrap">

			<p class="label">Filter report</p>

			<?php
				echo $this->Form->create( false, array( 'type' => 'get', 'id' => 'filter_form' ) );
				?>
					<div id="filter_wrapper">
						<?php
						echo $this->Form->input( 'from', array( 'label' => 'From (inclusive)' ) );//, 'default' => date( 'Y-m-01' ) ) );
						echo $this->Form->input( 'to', array( 'label' => 'To (inclusive)' ) );//, 'default' => date( MYSQL_DATE ) ) );
						?>
						<div class="submit">
							<input class="btn d-purple sm" type="submit" value="Update" />
						</div>
					</div>
				</form>
			</div>
			<?php
		}
		?>
		<div class="clear"></div>

	</div>

	<script type="text/javascript">
	//
	// Init selector
	$( '.selected-option' ).click( function() {

		$( '.select-menu' ).toggle();
	} );
	</script>

	<?php 
	//
	// If there's a report, display interactive graph
	if ( !empty( $report ) ) {
		?>

		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/js/jqplot/excanvas.js"></script><![endif]-->
		<script language="javascript" type="text/javascript" src="/js/jqplot/jquery.jqplot.js"></script>

		<!-- Additional plugins go here -->
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.barRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.enhancedLegendRenderer.min.js"></script>
	    <script class="include" language="javascript" type="text/javascript" src="/js/jqplot/plugins/jqplot.pointLabels.min.js"></script>
		<!-- End additional plugins -->

	<h1 id="graph_title">Loading...</h1>
	<p id="legend_help">Click on labels in the legend to toggle the display of that data series.</p>
	
	<div id="graph_wrapper">

		<div id="graph"></div>
		<img src="img/spinner.gif" alt="" width="16" height="16" class="hidden spinner" />

	</div>

	<script type="text/javascript">

	//
	// Init datepickers
	var datepicker_config = {
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		minDate: new Date( '<?php echo date( JAVASCRIPT_DATE, strtotime( $current_user['Partner']['created'] ) ) ?>' ), 
		maxDate: '+0d'
	};
	$( '#from' ).datepicker( datepicker_config );
	$( '#to' ).datepicker( datepicker_config );

	//
	// Init graph
	var jqplot = null;
	$.jqplot.config.enablePlugins = true;

	function load_data() {

		// Show spinner
		$( '.spinner' ).removeClass( 'hidden' );

		// Fetch data
		var url = '/reports/data_<?php echo $section; ?>_<?php echo $report; ?>?from=' + $( '#from' ).val() + '&to=' + $( '#to' ).val();
		var originalBarWidth = 0;
		$.ajax( {
			cache: false,
			dataType: 'json',
			url: url
		} )
		.done( function( response ) {

			// Set renderers
			response.options.axes.xaxis.renderer = $.jqplot.CategoryAxisRenderer;
			response.options.axes.xaxis.labelRenderer = $.jqplot.CanvasAxisLabelRenderer;
			response.options.axes.xaxis.tickRenderer = $.jqplot.CanvasAxisTickRenderer;
			response.options.axes.yaxis.labelRenderer = $.jqplot.CanvasAxisLabelRenderer;
			response.options.seriesDefaults.renderer = $.jqplot.BarRenderer;
			if ( response.options.legend != undefined ) {

				response.options.legend.renderer = $.jqplot.EnhancedLegendRenderer;
				$( '#legend_help' ).removeClass( 'hidden' ).show();
			}
			else {

				$( '#legend_help' ).hide();
			}

			// Update title
			$( '#graph_title' ).html( response.title );

			// Store original bar width
			originalBarWidth = response.options.seriesDefaults.rendererOptions.barWidth;

			// Calculate new bar width
			var newBarWidth = originalBarWidth * ( $('#graph' ).width() / 750 );
			response.options.seriesDefaults.rendererOptions.barWidth = newBarWidth;

			// Update graph
			if ( jqplot != null ) {

				jqplot.destroy();
			}
			jqplot = $.jqplot( 'graph', response.series, response.options );

			$( window ).resize( function() {

				newBarWidth = originalBarWidth * ( $('#graph' ).width() / 750 );
				response.options.seriesDefaults.rendererOptions.barWidth = newBarWidth;

				jqplot.destroy();
				jqplot = $.jqplot( 'graph', response.series, response.options );
			} );

			// Hide spinner
			$( '.spinner' ).addClass( 'hidden' );
		} );

		return false;
	}
	$( '#filter_form' ).submit( load_data );
	load_data();

	</script>

	<?php
	}
	?>

</div>
