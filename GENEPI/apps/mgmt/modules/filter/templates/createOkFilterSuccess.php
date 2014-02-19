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

<h1>
	<?php echo __('It\'s done !');
	
	?>
</h1>