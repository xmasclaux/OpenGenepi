<?php slot('title', sprintf('GENEPI - '.__('Events')))?>

<?php include_partial('global/messages')?>

<head>
</head>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <?php
        $html_menu = '';
        foreach ($menu as $action)
        {
            if ($action['active'])
                $html_menu .= '<h3 class = "selected">'.__($action['label']).'</h3>';
            else
                $html_menu .= '<h3><a href="'.url_for("reservation/$action[key]").'">'.__($action['label']).'</a></h3>';
        }
        echo $html_menu;
    ?>
<?php end_slot(); ?>

<div id="tabs">

    <h1><?php echo __('Events')?></h1>

    <table id="allReservationsTab" class="largeTable">
        <thead>
            <tr class="sortableTable">
                <th><?php echo __('Designation')?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $k => $event): ?>
                <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                    <td><a href='<?php echo url_for('reservation/formevent?id='.$event->getId()); ?>'><?php echo $event->getDesignation(); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <input type="button" value="<?php echo __('Add')?>" onClick="document.location.href='<?php echo url_for('reservation/formevent')?>';">

</div>
