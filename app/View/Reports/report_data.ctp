<?php
$this->layout = "ajax";

$title = $report_title;
if ( !empty( $total ) ) {

	$title .= " ({$total} entries)";
}

$series_json = "";
$first_series = true;
$max_value = 0;
$yaxis_format = '%d';
foreach ( $series as $values ) {

	foreach ( $values as $value ) {

		$value += 0; // Cast to number
		$max_value = max( $max_value, $value );
		if ( fmod( $value, 1 ) > 0 ) {
			
			$yaxis_format = '%.1f';
		}
	}

	if ( !$first_series ) {

		$series_json .= ', ';
	}
	$first_series = false;
	$series_json .= '[' . implode( ', ', $values ) . ']';
}

$values_count = count( $series[0] );

$ticks_json = "";
$first_tick = true;
$max_tick_length = 0;
foreach ( $ticks as $tick ) {

	$max_tick_length = max( $max_tick_length, strlen( $tick ) );

	if ( !$first_tick ) {

		$ticks_json .= ', ';
	}
	$first_tick = false;
	$ticks_json .= "\"{$tick}\"";
}

?>
{
	"series": [<?php echo $series_json; ?>],
	"options": {
		"axes": {
			"xaxis": {
				"label": "<?php echo $xaxis; ?>",
				"labelOptions": {
					"fontSize": "10pt",
					"fontWeight": "bold",
					"textColor": "#999999"
				},
				"ticks": [<?php echo $ticks_json; ?>],
				"tickOptions": {
					<?php
					if ( $max_tick_length > 20 ) {
						?>
						"angle": -45,
						<?php
					}
					?>
					"fontSize": "9pt",
					"fontWeight": "bold",
					"markSize": 7,
					"showGridline": false,
					"textColor": "#333333"
				}
			},
			"yaxis": {
				"label": "<?php echo $yaxis; ?>",
				"labelOptions": {
					"fontSize": "10pt",
					"fontWeight": "bold",
					"textColor": "#999999"
				},
				"min": 0,
				<?php
				if ( $max_value < 10 ) {
					?>
					"tickInterval": 1,
					"numberTicks": 11,
					<?php	
				}
				?>
				"tickOptions": {
					"fontSize": "10pt",
					"fontWeight": "bold",
					"fontSize": "10pt",
					"formatString": "<?php echo $yaxis_format; ?>",
					"textColor": "#333333"
				}
			}
		},
		"grid": {
			"borderColor": "#cecad9",
			"borderWidth": 1,
			"gridLineColor": "#e0e0e0",
			"shadow": false
		},
		<?php
		if ( !empty( $legends ) ) {
			?>
			"legend": {
				"fontSize": "6pt",
				"labels": <?php echo json_encode( $legends ); ?>,
				"placement": "outside",
				"show": true,
				"rendererOptions": {
					"seriesToggle": "fast",
					"disableIEFading": true
				}
			},
			<?php
		}
		?>
		"seriesColors": ["#98d4be", "#9186af", "#70b8da", "#ecc87b", "#e67184", "#d999d7", "#848992", "#cecece"],
		"seriesDefaults": {
			"pointLabels": {
				"hideZeros": true
			},
			"rendererOptions": {
				<?php
				if ( !empty( $legends ) ) {
					?>
					"barPadding": 2,
					<?php
				}
				?>
				"barWidth": <?php echo floor( 400 / $values_count / count( $series ) ); ?>,
				"fillToZero": true,
				"hideZeros": true,
				"highlightMouseOver": false,
				"shadowDepth": 0
			}
        }
	},
	"title": "<?php echo $title; ?>"
}
