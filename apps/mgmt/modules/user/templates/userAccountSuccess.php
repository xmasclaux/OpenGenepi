<script type="text/javascript">
	$(document).ready(function() {
		$("#back-button").click ( function() { $("#dialog").dialog("close");  } );
	});
</script>

<?php if($selectedAccounts) :?>
	<?php foreach($accountsToDelete as $accountToDelete): ?>
		<p><?php echo __("The deletion of the account")." <b>".$accounts[$accountToDelete]->getAct()->getDesignation()."</b> "."(".$accounts[$accountToDelete]->getValue()." ".$accounts[$accountToDelete]->getAct()->getUnity().") ".__("will affect the following users: ")?></p>	
		<ul>
			<?php foreach($users[$accountToDelete] as $user):?>
					<li><p><?php echo $user ?></p></li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>
	
	<p><?php echo __('Caution, this action is irreversible : the selected account(s) and their value will be completely deleted.')?></p>
	
	<span class="deletion-button" style="float:right; margin-top:18px;">
		<?php echo link_to(__('Confirm'), 'user/deleteAccount?id='.$accountsToDeleteExploded, array('method' => 'delete')) ?>
	</span>
<?php else :?>
	<p><?php echo __('No accounts selected')?></p>
<?php endif;?>

<input type="button" id="back-button" value=<?php echo __('Back')?>></input>