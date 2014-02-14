<?php include_partial('global/messages')?>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3 class = "selected"><?php echo __('Impute an act')?></h3>
	<h3><a href="<?php echo url_for('use/history') ?>"><?php echo __('View history')?></a></h3>
<?php end_slot(); ?>

<form action="<?php echo url_for('use/changeUsersCategories')?>" method="post">
	<div class="panel">
	
		<h1><?php echo __('Users category change')?></h1>
		
		<div class="info-message-white">
			<span class="info-message-icon"></span>
			<em><?php echo __('You have just imputed a subscription to one or several users. This menu allows you to change their category.')?></em>
		</div>
		
		<table class="formTable">
			<tbody>
			<?php echo $form->renderGlobalErrors() ?>
				<?php foreach($users as $user):?>
					<tr>
						<td><?php echo $form['ids['.$user->getId().']']?></td>
						<td><?php echo $form['name['.$user->getId().']']?></td>
						<td><?php echo $form['category['.$user->getId().']']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		
		<input type="button" value="<?php echo __('Ignore this step')?>" onclick="document.location.href='<?php echo url_for('use/index')?>'">
		<div class="rightAlignement"><input type="submit" value="<?php echo __('Confirm')?>"></div>
	</div>
</form>