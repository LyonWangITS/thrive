<?php
/**
 * Uses FPDF to generate a downloadable PDF of a given user's feedback and results.
 */

require_once( 'app/config.php' );
require_once( 'app/db.php' );
require_once( 'app/helpers.php' );
require_once( 'app/Partner.class.php' );
require_once( 'app/Survey.class.php' );
require_once( 'app/library/fpdf/fpdf.php' );
require_once( 'app/library/fpdi/fpdi.php' );
require_once( 'app/library/fpdi_html.php' );

//
// Parse input to get user's survey and the associated partner
$survey = new Survey();
$param_token = ifne( $_REQUEST, 't' );
if ( $param_token != '' && Survey::tokenExists( $param_token ) ) {

	$survey->loadFrom( 'token', $param_token );
}

// If survey not found, stop
if ( empty( $survey->id ) ) {

	die( 'Sorry, unable to generate PDF.' );
}

$partner = Partner::getPartnerById( $survey->data['partner_id'] );
$services = $partner->loadServices( $survey->data['partner_id'] );

if ( empty( $partner ) ) {

	die( 'Sorry, invalid partner.' );
}

/**
 * Build PDF
 */

// Init PDF
$pdf = new FPDI_HTML( 'P', 'mm', array( 318, 450 ) );
$pdf->AddFont( 'ProximaNova', '', 'ProximaNova-Reg.php' );
$pdf->AddFont( 'ProximaNova', 'B', 'ProximaNova-Bold.php' );
$pdf->AddFont( 'ProximaNova Light', '', 'ProximaNova-Light.php' );
$pdf->SetTitle( "THRIVE feedback for {$survey->data['00_participant_name']}", true );
$pdf->SetAutoPageBreak( false );
$pdf->SetLineWidth( 0.2 );
$pdf->SetMargins( 0, 0, 0 );

// Build content.
add_intro( $pdf, $survey );
add_audit_score_graph( $pdf, $survey );
add_comparisons( $pdf, $survey );
add_expenses( $pdf, $survey );
add_bac_estimate( $pdf, $survey );
add_adis( $pdf, $partner );
add_faqs_and_tips( $pdf );
add_support( $pdf, $services );

// Output
// TODO: make this a download?
$pdf->Output();

/**
 * Individual blocks of the PDF. All of our add methods are careful to leave the PDF Y position where the next element
 * should start drawing, and make their own checks on if a new page is required. Methods should make no assumptions
 * about the position of X.
 */

function add_intro( FPDF $pdf, Survey $survey ) {

	// Ensure required height is available
	$block_height = 133;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Create intro from template
	$pdf->setSourceFile( 'pdf-assets/intro.pdf' );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, $offset_y, $pdf->w );

	// Title
	$pdf->SetTextColor( 255, 255, 255 );
	$pdf->SetFont( 'ProximaNova', 'B', 25 );
	$pdf->SetXY( 20, 27.5 );
	$pdf->Cell( $pdf->w - 40, 20, "Thanks for completing the survey, {$survey->data['00_participant_name']}.", 0, 2, 'C' );

	// Done, set height. In this case reset to what it was.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_audit_score_graph( FPDF $pdf, Survey $survey ) {

	// Ensure required height is available
	$block_height = 147.5;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Calculate audit score
	$score = $survey->calculateAuditScore();

	// Use template based on the audit score
	$audit_score_filename = 'audit-score-0-7.pdf';
	$font_color = '#8ed0b7';
	if ( $score >= 20 ) {

		$font_color = '#f27678';
		$audit_score_filename = 'audit-score-20-40.pdf';
	}
	else if ( $score >= 16 ) {

		$font_color = '#b07cb7';
		$audit_score_filename = 'audit-score-16-19.pdf';
	}
	else if ( $score >= 8 ) {

		$font_color = '#6bc3ee';
		$audit_score_filename = 'audit-score-8-15.pdf';
	}

	// Create first page from template to show the audit score graphic
	$pdf->setSourceFile( 'pdf-assets/' . $audit_score_filename );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, $offset_y + 1, $pdf->w );

	// Stamp audit score
	$font_color = $pdf->hex2dec( $font_color );
	$pdf->SetTextColor( $font_color['R'], $font_color['G'], $font_color['B'] );
	$pdf->SetFont( 'ProximaNova', 'B', 29.5 );
	$pdf->SetXY( 225, $offset_y + 38.5 );
	$pdf->Cell( 20, 10, $score );

	// Done, set height.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_comparisons( FPDF $pdf, Survey $survey ) {

	// Check if section required
	$consumption = $survey->calculateConsumption();
	$show_per_occasion = $consumption['typical_day'] > 4;
	$show_per_week = $consumption['per_week'] > 6;
	if ( !$show_per_occasion && !$show_per_week ) {

		return;
	}
	// This is broken into 3 blocks: the title, then 2 graphs. We don't want a pagebreak between the title and
	// the first graph, though.

	// Ensure required height is available for title and first graph
	$block_height = 76;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Title
	$pdf->SetTextColor( 111, 110, 110 );
	$pdf->SetFont( 'ProximaNova', 'B', 22 );
	$pdf->SetXY( 26, $offset_y + 16 );
	$pdf->Cell( $pdf->w, 10, 'How do you compare?', 0, 2 );

	// First graph
	if ( $show_per_occasion ) {

		// Intro
		$pdf->SetXY( 26, $pdf->GetY() + 7 );
		$pdf->SetTextColor( 102, 102, 102 );
		$pdf->SetFont( 'ProximaNova', 'B', 14 );
		$pdf->Cell( 0, 0, 'Standard drinks on a typical occasion', 0, 2 );

		// Axis
		$pdf->SetXY( 26, $pdf->GetY() + 7 );
		$bar_y = $pdf->GetY() + 0.5;
		$pdf->SetTextColor( 134, 133, 133 );
		$pdf->SetFont( 'ProximaNova', 'B', 10 );
		$pdf->MultiCell( 76, 6, "You reported having approximately {$consumption['typical_day']} drinks on a typical occasion. This is a comparison with other people your age.", 0, 'L' );

		// Bars
		draw_graph_bar( $pdf, $bar_y, '<font color="#b2b2b2">YOU HAVE</font> <font color="#f27678">' . $consumption['typical_day'] . ' STANDARD DRINKS</font> <font color="#b2b2b2">ON A TYPICAL OCCASION</font>', $consumption['typical_day'], 100, 'red' );
		draw_graph_bar( $pdf, $bar_y + 10, '<font color="#b2b2b2">AVERAGE HAS 4.0 STANDARD DRINKS ON A TYPICAL OCCASION</font>', 4.0, ( 4 / $consumption['typical_day'] * 100 ), 'gray' );
		$pdf->SetY( $pdf->GetY() + 10 );
	}

	// If showing both graphs, require more height
	if ( $show_per_occasion && $show_per_week ) {

		$extra_height = 51;
		$block_height += $extra_height;
		ensure_fixed_height_available( $pdf, $extra_height );
	}

	// Second graph
	if ( $show_per_week ) {

		// Intro
		$pdf->SetXY( 26, $pdf->GetY() + 7 );
		$pdf->SetTextColor( 102, 102, 102 );
		$pdf->SetFont( 'ProximaNova', 'B', 14 );
		$pdf->Cell( 0, 0, 'Standard drinks per week', 0, 2 );

		// Axis
		$pdf->SetXY( 26, $pdf->GetY() + 7 );
		$bar_y = $pdf->GetY() + 0.5;
		$pdf->SetTextColor( 134, 133, 133 );
		$pdf->SetFont( 'ProximaNova', 'B', 10 );
		$pdf->MultiCell( 76, 6, "You reported consuming approximately {$consumption['per_week']} drinks per week, and {$consumption['per_month']} drinks per month. This is a comparison with other people your age.", 0, 'L' );

		// Bars
		draw_graph_bar( $pdf, $bar_y, '<font color="#b2b2b2">YOU HAVE</font> <font color="#f27678">' . $consumption['per_week'] . ' STANDARD DRINKS</font> <font color="#b2b2b2">PER WEEK</font>', $consumption['per_week'], 100, 'red' );
		draw_graph_bar( $pdf, $bar_y + 10, '<font color="#b2b2b2">AVERAGE HAS 6.0 STANDARD DRINKS PER WEEK</font>', 6.0, ( 6 / $consumption['per_week'] * 100 ), 'gray' );
		$pdf->SetY( $pdf->GetY() + 10 );
	}

	// Bottom border
	$pdf->SetY( $pdf->GetY() + 10 );
	$pdf->SetDrawColor( 241, 242, 242 );
	$pdf->SetLineWidth( 0.5 );
	$pdf->Line( 0, $pdf->GetY(), $pdf->w, $pdf->GetY() );

	// Done, set height.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_bac_estimate( FPDF $pdf, Survey $survey ) {

	// Calculate BAC
	if ( empty( $survey->data['03_past_4wk_consumed_alcohol'] ) ) {

		return;
	}
	$bac = $survey->calculateBAC();

	// Ensure required height is available
	$block_height = 134;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Create from template to show the BAC background
	$pdf->setSourceFile( 'pdf-assets/bac.pdf' );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, $offset_y, $pdf->w );

	// Stamp BAC score
	$pdf->SetTextColor( 242, 118, 120 );
	$pdf->SetFont( 'ProximaNova', 'B', 28 );
	$pdf->SetXY( 27, $offset_y + 25 );
	$pdf->Cell( 30, 10, round( floatval( $bac ), 2 ) . '%', 0, 0, 'R' );

	// Stamp appropriate feedback
	$feedback = '';
	$angle = 0;
	$adjust_x = 0;
	$adjust_y = 0;
	// <= 0.02 doesn't show any memo
	if ( ( $bac >= 0.02 ) && ( $bac <= 0.04 ) ) {

		$feedback = 'At a BAC between 0.05-0.09 you are 11 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.';
		$angle = 45;
		$adjust_x = 0;
		$adjust_y = 0;
	}
	elseif ( ( $bac >= 0.05 ) && ( $bac <= 0.09 ) ) {

		$feedback = 'At a BAC between 0.05-0.09 you are 11 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.';
		$angle = 90;
		$adjust_x = 0;
		$adjust_y = 2.5;
	}
	elseif ( ( $bac >= 0.10 ) && ( $bac <= 0.14 ) ) {

		$feedback = 'At a BAC between 0.10 to 0.14 you are 48 times more likely to be killed in a single-vehicle crash than a driver with a zero BAC.';
		$angle = 135;
		$adjust_x = -2.5;
		$adjust_y = 3.5;
	}
	elseif ( ( $bac >= 0.15 ) ) {

		$feedback = 'At a BAC between 0.15 and above you are 380 times more likely to be killed in a single- vehicle crash than a driver with a zero BAC.';
		$angle = 165;
		$adjust_x = -4;
		$adjust_y = 3;
	}
	$pdf->SetTextColor( 133, 133, 133 );
	$pdf->SetFont( 'ProximaNova', '', 12 );
	$pdf->SetXY( 26, $offset_y + 60.5 );
	$pdf->MultiCell( 140, 7, $feedback );

	// Stamp needle
	$pdf->RotatedImage( 'pdf-assets/metre-hand.png', 239 + $adjust_x, $offset_y + 92 + $adjust_y, 0, 35, -90 - $angle );

	// Done, set height.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_expenses( FPDI_HTML $pdf, Survey $survey ) {

	// Check if section required
	$expenses = $survey->calculateExpenses();
	if ( empty( $expenses['from'] ) && empty( $expenses['to'] ) ) {

		return;
	}

	// Ensure required height is available
	$block_height = 93.5;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Create content from template
	$pdf->setSourceFile( 'pdf-assets/expenses.pdf' );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, $offset_y, $pdf->w );

	// Appropriate text
	$pdf->SetTextColor( 242, 118, 120 );
	$pdf->SetFont( 'ProximaNova', 'B', 25 );
	$pdf->SetLeftMargin( 105 );
	$pdf->SetRightMargin( 5 );
	$pdf->SetXY( 140, $offset_y + 38 );
	$pdf->Cell( 140, 0, 'Between $' . number_format( $expenses['from'], 0 ) . ' and $' . number_format( $expenses['to'], 0 ), 0, 0, 'C' );

	// Done, set height.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_adis( FPDF $pdf, Partner $partner ) {

	// Check if enabled
	if ( empty( $partner->data['is_adis_enabled'] ) ) {

		return;
	}

	// Ensure required height is available
	$block_height = 133;
	ensure_fixed_height_available( $pdf, $block_height );
	$offset_y = $pdf->GetY();

	// Create from template to show the BAC background
	$pdf->setSourceFile( 'pdf-assets/adis.pdf' );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, $offset_y, $pdf->w );

	// Manually recreate links from PDF
	$pdf->Link( 85, 92 + $offset_y, 49, 9, 'mailto:adis@health.wa.gov.au' );
	$pdf->Link( 164, 64 + $offset_y, 128, 48, 'http://drugaware.com.au/' );

	// Done, set height.
	$pdf->SetY( $offset_y + $block_height );
	debug_block_height( $pdf );
}

function add_support( FPDF $pdf, array $services ) {

	// Check if section required
	if ( empty( $services ) ) {

		return;
	}

	// Start new page and enable freeflow
	$pdf->AddPage();

	// Title bg
	$pdf->Image( 'pdf-assets/support-bg.png', 0, 0, $pdf->w, 39 );

	// Title
	$pdf->SetTextColor( 255, 255, 255 );
	$pdf->SetFont( 'ProximaNova', 'B', 28 );
	$pdf->SetXY( 26, 21 );
	$pdf->Cell( $pdf->w, 0, 'Support', 0, 2 );

	// Space
	$pdf->SetY( $pdf->GetY() + 20 );

	// Services
	// To avoid a service breaking across a page, we buffer each one then append it
	foreach ( $services as $service ) {

		// Create a buffer
		$buffer = new FPDI_HTML( 'P', 'mm', array( 318, 450 ) );
		$buffer->AddFont( 'ProximaNova', '', 'ProximaNova-Reg.php' );
		$buffer->AddFont( 'ProximaNova', 'B', 'ProximaNova-Bold.php' );
		$buffer->SetAutoPageBreak( false );
		$buffer->SetLineWidth( 0.2 );
		$buffer->SetMargins( 0, 0, 0 );
		$buffer->AddPage();

		// Space between
		$buffer->SetY( $buffer->GetY() + 10 );

		// Title and bg
		$buffer->Image( 'pdf-assets/service-bg.png', 55, $buffer->GetY(), 208, 12 );
		$buffer->SetTextColor( 209, 200, 221 );
		$buffer->SetFont( 'ProximaNova', 'B', 12 );
		$buffer->SetXY( 60, $buffer->GetY() );
		$buffer->Cell( 0, 12, $service['name'], 0, 2 );

		$side_border_top = $buffer->GetY();

		// Details
		draw_support_row( $buffer, 'phone', 'Phone', $service['contact_numbers'] );
		$buffer->Image( 'pdf-assets/service-divider.png', 55, $buffer->GetY(), 208 );
		draw_support_row( $buffer, 'address', 'Address', $service['address'] );
		$buffer->Image( 'pdf-assets/service-divider.png', 55, $buffer->GetY(), 208 );
		draw_support_row( $buffer, 'hours', 'Opening hours', $service['opening_hours'] );
		$buffer->Image( 'pdf-assets/service-divider.png', 55, $buffer->GetY(), 208 );
		draw_support_row( $buffer, 'fees', 'Fees', $service['fees'] );
		if ( !empty( $service['website'] ) ) {

			$buffer->Image( 'pdf-assets/service-divider.png', 55, $buffer->GetY(), 208 );
			draw_support_row( $buffer, 'website', 'Website', $service['website'] );
		}
		if ( !empty( $service['additional_info'] ) ) {

			$buffer->Image( 'pdf-assets/service-divider.png', 55, $buffer->GetY(), 208 );
			draw_support_row( $buffer, 'info', 'Additional info', $service['additional_info'] );
		}

		// Draw side and bottom borders
		$buffer->SetDrawColor( 68, 68, 68 );
		$buffer->SetLineWidth( 0.2 );
		$buffer->Line( 55, $buffer->GetY(), 263, $buffer->GetY() );
		$buffer->Line( 55, $side_border_top, 55, $buffer->GetY() );
		$buffer->Line( 263, $side_border_top, 263, $buffer->GetY() );

		// Store height of buffer, create a new page if it's not going to fit
		$buffer_height = $buffer->GetY();
		ensure_fixed_height_available( $pdf, $buffer_height + 5 );

		// Store buffer as temporary PDF
		$temp_file = tempnam( sys_get_temp_dir(), 'service' );
		$temp_file_handle = fopen( $temp_file, 'w' );
		fwrite( $temp_file_handle, $buffer->Output( null, 'S' ) );
		fclose( $temp_file_handle );

		// Embed the buffered PDF
		$pdf->setSourceFile( $temp_file );
		$template_id = $pdf->importPage( 1 );
		$pdf->useTemplate( $template_id, 0, $pdf->GetY(), $pdf->w );
		$pdf->SetY( $pdf->GetY() + $buffer_height );

		// Remove buffer
		unlink( $temp_file );
	}
}

function add_faqs_and_tips( FPDF $pdf ) {

	// Page 1
	$pdf->AddPage();
	$pdf->setSourceFile( 'pdf-assets/tips-faqs.pdf' );
	$template_id = $pdf->importPage( 1 );
	$pdf->useTemplate( $template_id, 0, 0, $pdf->w );

	// Page 2
	$pdf->AddPage();
	$template_id = $pdf->importPage( 2 );
	$pdf->useTemplate( $template_id, 0, 0, $pdf->w, 440 );
	$pdf->Link( 40, 297, 46, 9, 'http://www.police.wa.gov.au/Traffic/Drinkdriving/Penalties/tabid/989/Default.aspx' );
	$pdf->Link( 40, 310, 23, 9, 'https://www.vicroads.vic.gov.au/safety-and-road-rules/road-rules/penalties/drink-driving-penalties' );
	$pdf->Link( 40, 322, 41, 9, 'http://www.dpti.sa.gov.au/towardszerotogether/Safer_behaviours/Drink_and_drug_driving_penalties2' );
	$pdf->Link( 40, 335, 33, 9, 'http://www.qld.gov.au/transport/safety/road-safety/drink-driving/penalties/' );
	$pdf->Link( 40, 347, 45, 9, 'http://transport.nt.gov.au/safety/road-safety/our-safer-road-users/alcohol-and-drugs' );
	$pdf->Link( 40, 359, 45, 9, 'http://www.rms.nsw.gov.au/usingroads/penalties/alcoholanddrugs.html' );
	$pdf->Link( 40, 372, 65, 9, 'http://www.police.act.gov.au/roads-and-traffic/drink-driving.aspx' );


	// Page 3
	$pdf->AddPage();
	$template_id = $pdf->importPage( 3 );
	$pdf->useTemplate( $template_id, 0, 0, $pdf->w );
	$pdf->Link( 74, 288, 36, 9, 'http://alcohol.gov.au/internet/alcohol/publishing.nsf/Content/standard' );

	// Page 4
	$pdf->AddPage();
	$template_id = $pdf->importPage( 4 );
	$pdf->useTemplate( $template_id, 0, 0, $pdf->w );
	$pdf->Link( 105, 114, 67, 9, 'http://theothertalk.org.au/safe-partying-tips-for-schoolies' );
	$pdf->Link( 180, 114, 77, 9, 'http://www.alcohol.gov.au/internet/alcohol/publishing.nsf/Content/C6738D5F231CC231CA25767200820337/$File/young.pdf' );
	$pdf->Link( 25, 122, 54, 9, 'http://www.alcohol.gov.au/internet/alcohol/publishing.nsf/Content/guide-young' );
}

//
// Utility methods

/**
 * Call this whenever rendering a fixed-height block (or part within a block) to ensure the required height is
 * available on the current page. If not, creates a new page.
 * @param FPDF $pdf
 * @param $required_height int Required height in units. Default is mm, but it'll be whatever you have set it to.
 */
function ensure_fixed_height_available( FPDF $pdf, $required_height ) {

	// Check there's any page
	if ( $pdf->GetY() == null ) {

		$pdf->AddPage();
		return;
	}

	// Create new page if required height not available. Factors in margins.
	$remaining_height = (
		$pdf->h - $pdf->GetY() - $pdf->tMargin - $pdf->bMargin
	);
	if ( $required_height > 0 && $remaining_height < $required_height ) {

		$pdf->AddPage();
	}
}

function draw_divider( FPDF $pdf ) {

	$pdf->SetDrawColor( 241, 242, 242 );
	$pdf->SetLineWidth( 0.2 );
	$pdf->Line( 0, $pdf->GetY(), $pdf->w, $pdf->GetY() );
}

function draw_graph_bar( FPDF $pdf, $y, $label, $score, $width_percent, $color ) {

	// Preserve original XY position
	$original_x = $pdf->GetX();
	$original_y = $pdf->GetY();

	$x = 110; // Fixed left margin
	$max_width = 182;

	// Label
	$pdf->SetFont( 'ProximaNova', 'B', 11 );
	$pdf->SetXY( $x - 1, $y );
	$pdf->WriteHtml( $label );

	// Draw bar background and filled region
	$width = ( $max_width / 100 ) * $width_percent;
	$pdf->Image( 'pdf-assets/bar-light-gray.png', $x, $y + 6, $max_width, 1 );
	$pdf->Image( 'pdf-assets/bar-' . $color . '.png', $x, $y + 6, $width, 1 );

	// Restore origin
	$pdf->SetXY( $original_x, $original_y );
}

function draw_support_row( FPDF $pdf, $icon, $label, $content ) {

	// Padding
	$pdf->SetY( $pdf->GetY() + 5 );

	// Icon
	$pdf->Image( 'pdf-assets/icon-' . $icon . '.png', 62, $pdf->GetY() );

	// Label
	$pdf->SetTextColor( 111, 110, 110 );
	$pdf->SetFont( 'ProximaNova', 'B', 11 );
	$pdf->SetXY( 72, $pdf->GetY() );
	$pdf->Cell( 40, 6, $label, 0, 0 );

	$pdf->SetTextColor( 111, 110, 110 );
	$pdf->SetFont( 'ProximaNova', '', 11 );
	$pdf->SetXY( 112, $pdf->GetY() );
	$pdf->MultiCell( 140, 6, $content, 0, 'L' );

	// Padding
	$pdf->SetY( $pdf->GetY() + 5 );
}

function debug_block_height( FPDF $pdf ) {

	if ( true ) {

		return;
	}
	$pdf->SetDrawColor( 0, 255, 0 );
	$pdf->SetLineWidth( 0.2 );
	$pdf->Line( 0, $pdf->GetY(), $pdf->w, $pdf->GetY() );
}
