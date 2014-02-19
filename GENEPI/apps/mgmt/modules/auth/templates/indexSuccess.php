<?php slot('title', sprintf('GENEPI - '.__('Authentification')))?>

<script type="text/javascript">
	$(document).ready(function() {
		$( "#dialog" ).dialog( { 
			draggable: false,
			width: 530,
			close: false,
			resizable: false,
			modal: true , 
		} );
	});
</script>

<div id="dialog" title="<?php echo __('Authentification')?>">


<h1><?php echo $structure->getName() ?></h1>
<form method="post" action="#">
		<table id="auth">
			<tbody>
				<tr valign=middle>
					<th><label><?php echo __('Login :')?></label></th>
					<td>
						<input type="text" name="login" autocomplete="off"></input>
					</td>
				</tr>
				<tr valign=middle>
					<th><label><?php echo __('Password :')?></label></th>
					<td><input type="password" name="password"></input></td>
			    </tr>
			</tbody>
		</table>
		<?php if ($sf_user->hasFlash('error') || $sf_user->hasFlash('notice')): ?>
			<div class="error-message-red">
		    	<span class="error-message-icon"></span>
		        <em><?php echo __($sf_user->getFlash('error')) ?></em>
		    </div>
		<?php endif; ?>
		<input class="valid" type="submit" value="<?php echo __("Connection")?>"></input>
	</form>	
</div>