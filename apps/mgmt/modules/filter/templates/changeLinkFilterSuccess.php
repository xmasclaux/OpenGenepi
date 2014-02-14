<?php slot('title', sprintf('GENEPI - '.__('Filters')))?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <?php
        $html_menu = '';
        foreach ($menu as $action)
        {
            if ($action['active'])
                $html_menu .= '<h3 class = "selected">'.__($action['label']).'</h3>';
            else
                $html_menu .= '<h3><a href="'.url_for("filter/$action[key]").'">'.__($action['label']).'</a></h3>';
        }
        echo $html_menu;
    ?>
<?php end_slot(); ?>

<h1><?php echo __('Link Filters')?></h1>

 <div class="panel">
	<h6><?php echo __('Filters')?></h6>
		<table class="largeTable">
			<thead>
				<tr>
					<th><?php echo __('Public Category')?></th>
					<th><?php echo __('Filter')?></th>
				</tr>
			</thead>
			<tbody>

					<?php foreach ($categorys as $category):?>
					<form id="formulaire">
					<input type=hidden name=id value='<?php echo $category['id']; ?>'>
					<tr>
						 <td class="important"><?php echo $category['designation'] ?></td>
						 <td>
						 	<select name=filter_id>
						 	<?php foreach ($filters as $filter):?>
						 	<option value='<?php echo $filter['id']?>' <?php if ( $category['filter_id'] == $filter['id'] ) echo "SELECTED";?>><?php echo $filter['name'];?></option>
						 	<?php endforeach;?>
						 	</select>
						 </td>
					</tr>
					</form>
					<?php endforeach;?>	
					
					

			</tbody>
		</table>
		<input type="button" onclick="document.location.href='<?php echo url_for('filter/linkFilter') ?>';" value="<?php echo __("Back");?>">
		<div class="rightAlignement">
		<input type="button" id="Save-Button" value="<?php echo __('Save') ?>">
		</div>
</div>

<script>

$('#Save-Button').click(function(){

	form_query = $('#formulaire').serialize();

	$(location).attr('href',"<?php echo url_for('filter/updateLinkFilter')?>?" + form_query);

});

</script>

