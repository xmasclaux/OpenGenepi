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

<h1><?php echo __('Filters')?></h1>
 
 <div class="panel">
	<h6><?php echo __('Filters')?></h6>
		<table class="largeTable">
			<thead>
				<tr>
					<th><?php echo __('Name')?></th>
					<th><?php echo __('Description')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($filters as $filter):?>
				<?php 
				$name = $filter->getName(); 
				$id = $filter->getId();
				$description = $filter->getDescription();
				?>
					<tr>
						 <td class="important"><a href="filter/updateFilter?id=<?php echo $id?>"><?php echo __($name)?></a></td>
						 <td><?php echo __($description)?></td>
					</tr>
				<?php endforeach;?>	
			</tbody>
		</table>
</div>