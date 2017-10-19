<?php
$this->set( 'title_for_layout', 'Manage partners' );
$this->Html->meta( 'description', '', array( 'inline' => false ) );
$this->Html->meta( 'keywords', '', array( 'inline' => false ) );
?>

<p class="breadcrumb">
	<a href="<?php echo $this->webroot; ?>admin">Dashboard</a> /
	<strong>Partners</strong>
</p>

<div id="content">

<h1>Manage partners</h1>

<div class="content-padding admin">
	
	<a class="add-partner btn sm d-purple" href="<?php echo $this->webroot; ?>partners/add"><i class="icn plus"></i> Add partner</a>
	
	<?php
	echo $this->Form->create( false, array('type' => 'get') );
	?>
		<h3 class="first">Filter partners <label for="toggle_filter" class="btn d-purple sm show-toggle"><?php echo $this->Form->Checkbox( 'toggle_filter' ); ?>Show</label></h3>
		<div id="filter_wrapper" class="hidden clearfix">
			<?php
			echo $this->Form->input( 'name', array( 'label' => 'Name' ) );
			?>
			<div class="submit">
				<input class="btn green-btn" type="submit" value="Update" />
			</div>
		</div>
	</form>
	
	<p><?php echo $this->Paginator->counter( 'Page {:page} of {:pages}, showing {:start}-{:end} of {:count} partners.' ); ?></p>
	
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort( 'Partner.name', 'Name' ); ?></th>
			<th><?php echo $this->Paginator->sort( 'Partner.slug', 'Path' ); ?></th>
			<th><?php echo $this->Paginator->sort( 'Account.name', 'Contact' ); ?></th>
			<th><?php echo $this->Paginator->sort( 'LuPartnerState.name', 'Status' ); ?></th>
			<th></th>
		</tr>
		<?php
		$zebra = '';
		foreach ( $results as $result ) {
			?>
			<tr class="<?php echo $zebra; ?>">
				<td>
					<a href="<?php echo $this->webroot; ?>partners/edit/<?php p( $result['Partner']['id'] ); ?><?php echo $return_url; ?>"><?php p( $result['Partner']['name'] ); ?></a>
					<?php
					if ( !empty( $result['PendingChange']['id'] ) ) {
	
						echo " (Pending change)";
					}
					?>
	
				</td>
				<td><a href="<?php echo $this->webroot; p(  $result['Partner']['slug'] ); ?>/survey.php"><?php p( $result['Partner']['slug'] ); ?></a></td>
				<td><a href="mailto:<?php p( $result['Account']['email'] ); ?>"><?php p( $result['Account']['name'] ); ?></a></td>
				<td><?php p( $result['LuPartnerState']['name'] ); ?></td>
				<td class="button"><a class="btn d-purple sm" href="<?php echo $this->webroot; ?>partners/delete/<?php p( $result['Partner']['id'] ); ?><?php echo $return_url; ?>"><i class="icn trash"></i> Delete</a></td>
			</tr>
			<?php
			$zebra = ( $zebra == '' ) ? 'zebra' : '';
		}
		?>
	</table>
	
	<p class="paging"><?php echo $this->Paginator->numbers( array( 'before' => '<strong>Pages:</strong> ', 'first' => 'First page', 'last' => 'Last page' ) ); ?></p>
	
	<script type="text/javascript">
	function toggle_filter() {
		
		var hidden = !$( '#toggle_filter' ).is( ':checked' );
		if ( hidden ) {
		
			$( '#filter_wrapper' ).hide();
		}
		else {
	
			$( '#filter_wrapper' ).show();
		}
	}
	$( '#toggle_filter' ).change( toggle_filter );
	toggle_filter();
	</script>

</div>

</div>
