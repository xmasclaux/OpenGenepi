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
					<tr>
						 <td class="important"><a href="changeLinkFilter?id=<?php echo $category['cat_id'];?>"><?php echo $category['designation'] ?></a></td>
						 <td>
						 	<?php echo $category['filter'];?>
						 </td>
					</tr>
				<?php endforeach;?>	
			</tbody>
		</table>
</div>