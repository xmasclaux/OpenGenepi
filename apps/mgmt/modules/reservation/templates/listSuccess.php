<?php slot('title', sprintf('GENEPI - '.__('Reservations')))?>

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

    <h1><?php echo __('Reservations')?></h1>

    <table id="allReservationsTab" class="largeTable">
        <thead>
            <tr class="sortableTable">
                <th><?php echo __('Designation')?></th>
                <th class='greyCell' style='width:200px;'>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $k => $reservation): ?>
                <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                    <td><a href='<?php echo url_for('reservation/form?id='.$reservation['id'])?>'><?php echo $reservation['designation'] ?></a></td>
                    <td align='center'><a href='<?php echo url_for('reservation/periods?id='.$reservation['id'])?>'><?php echo __('Manage periods') ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <input type="button" value="<?php echo __('Add')?>" onClick="document.location.href='<?php echo url_for('reservation/form')?>';">

</div>
