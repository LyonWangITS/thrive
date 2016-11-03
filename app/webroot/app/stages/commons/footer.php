<footer<?= $target_stage != 0 ? ' class="internal"' : '' ?>>

 	<p class="confidential"><a href="#confidentiality-statement" title="About Confidentiality"><i class="icn lock"></i>About Confidentiality</a>
 	</p>
 	
	<?php
	if ( !empty( $partner->data['logo_path'] ) ) {

		//<a href="http://curtin.edu.au" target="_blank" class="icn curtin">Curtin University</a>
		$image_resizer = new WebImageHelper();
		if ( !empty( $partner->data['website'] ) ) {

			echo "<a href=\"{$partner->data['website']}\" target=\"_blank\" class=\"footer-logo\">";
		}
		echo "<img src=\"" . $image_resizer->resize( $partner->data['logo_path'], 200, null, 'max' ) . "\" width=\"200\" alt=\"{$partner->data['name']}\">";
		if ( !empty( $partner->data['website'] ) ) {

			echo "</a>";
		}
	}
	?>	


</footer>
<div id="confidentiality-statement">
	
	<?php
	if ( !empty( $partner->data['confidentiality_text'] ) ) {

		echo nl2br( $partner->data['confidentiality_text'] );
	}
	/*
	else {
		?>
		<p>The survey is being conducted by the Western Australian Centre for Health Promotion Research (WACHPR) to explore the use of alcohol by Polytechnic West students. However, the survey is independent, not connected to Polytechnic West student services and completely anonymous.</p>
		
		<p>This study has been approved by the Curtin University Human Research Ethics Committee (Approval Number HR70/2013). The Committee is comprised of members of the public, academics, lawyers, doctors and pastoral carers. If needed, verification of approval can be obtained either by writing to the Curtin University Human Research Ethics Committee, c/- Office of Research and Development, Curtin University, GPO Box U1987, Perth 6845 or by telephoning 9266 9223 or by emailing <a href="mailto:hrec@curtin.edu.au">hrec@curtin.edu.au</a>.</p>
		<?php
	}
	*/
	?>	
	
	<p><a href="#" class="close" title="Close">Close</a>
</div>


<!-- JavaScript : Include an embedded version -->
<? 
	/*
	<script src="" type="text/javascript"></script>
	*/
?>
<script src="<?php echo BASE_URL; ?>js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.infieldlabel.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.cycle2.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.shuffleLetters.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/QTransform.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/dragdealer.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/jquery.placeholder.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/functions.js?t=150127" type="text/javascript"></script>

</body>
</html>