<?php if ($sf_user->hasFlash('error') || $sf_user->hasFlash('notice')): ?>
	<?php slot('feedbackFrame') ?>
		<script type="text/javascript">
			document.getElementById('feedbackFrame').style.display = 'inherit';
	    </script>
		<?php if ($sf_user->hasFlash('notice')): ?>
			<div class="feedback-info-message">
		    	<span class="info-message-icon"></span>
		    	<?php echo __($sf_user->getFlash('notice')) ?>
		 	</div>
		 	<?php endif; ?>
			<?php if ($sf_user->hasFlash('error')): ?>
		 		<div class="feedback-error-message"> 
		  			<span class="error-message-icon"></span> 
		    		<?php echo __($sf_user->getFlash('error')) ?>
		 		</div>
		 <?php endif; ?>
	<?php end_slot();?>
	
<?php else: ?>
	<script type="text/javascript">
		document.getElementById('feedbackFrame').style.display = 'none';
	</script>	
<?php endif; ?>