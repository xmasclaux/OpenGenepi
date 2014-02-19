<option value=""></option>
<?php foreach($family as $name): ?>
	<option value="<?php echo $name->getId() ?>"><?php echo $name->getDesignation() ?></option>
<?php endforeach; ?>