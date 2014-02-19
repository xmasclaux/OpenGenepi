<?php slot('title', sprintf('GENEPI - '.__('Manage periods')))?>

<?php include_partial('global/messages')?>

<head>
    <script type='text/javascript'>

    function period_deletion()
    {
        $( "#dialog" ).dialog( {
            width: 600,
            close: false,
            resizable: false,
            modal: true,
            draggable: false
        } );
    }

    $(function() {

        $('.deletecomputer, .deleteroom').click(function() {

            period_deletion();
            $('#deletion_link').attr('href', $(this).attr('href'));
            return false;
        });
        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
    });

    </script>
</head>

<div id="dialog" title="<?php echo __("Period deletion")?>" style="display:none">
    <p><?php echo __("Caution, this period will be deleted.") ?></p>

    <input type="button" id="back-button" value=<?php echo __('Back')?>></input>

    <span class="deletion-button" style="float:right; margin-top:18px;">
        <a id='deletion_link' href='#'><?php echo __('Confirm'); ?></a>
    </span>
</div>

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

    <h1><?php echo __("Manage periods")?></h1>

    <fieldset>
        <legend><?php echo __("Computers")?></legend>
        <table id="allReservationComutersTab" class="largeTable">
            <thead>
                <tr class="sortableTable">
                    <th><?php echo __('Computer')?></th>
                    <th><?php echo __('From')?></th>
                    <th><?php echo __('To')?></th>
                    <th class='greyCell' style='width:120px;'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($computer_reservations as $k => $computer_reservation): ?>
                    <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                        <td><?php echo $computer_reservation->getComputer()->getName(); ?></td>
                        <td><?php echo date_format(new DateTime($computer_reservation->getStartDate()), __('m-d-Y').' H:i'); ?></td>
                        <td><?php echo date_format(new DateTime($computer_reservation->getEndDate()), __('m-d-Y').' H:i'); ?></td>
                        <td align='center'><a class='deletecomputer' href='<?php echo url_for('reservation/deletecomputer?id='.$reservation->getId().'&reservation_computer_id='.$computer_reservation->getId()); ?>'><?php echo __('Delete') ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset>
        <legend><?php echo __("Rooms")?></legend>
        <table id="allReservationRoomsTab" class="largeTable">
            <thead>
                <tr class="sortableTable">
                    <th><?php echo __('Room')?></th>
                    <th><?php echo __('From')?></th>
                    <th><?php echo __('To')?></th>
                    <th class='greyCell' style='width:120px;'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($room_reservations as $k => $room_reservation): ?>
                    <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
                        <td><?php echo $room_reservation->getRoom()->getDesignation(); ?></td>
                        <td><?php echo date_format(new DateTime($room_reservation->getStartDate()), __('m-d-Y').' H:i'); ?></td>
                        <td><?php echo date_format(new DateTime($room_reservation->getEndDate()), __('m-d-Y').' H:i'); ?></td>
                        <td align='center'><a class='deleteroom' href='<?php echo url_for('reservation/deleteroom?id='.$reservation->getId().'&reservation_room_id='.$room_reservation->getId()); ?>'><?php echo __('Delete') ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>

    <div class="rightAlignement">
        <input type="button" value="<?php echo __('Add a period')?>" onClick="document.location.href='<?php echo url_for('reservation/addperiod?id='.$reservation->getId())?>';">
    </div>
    <input type="button" value="<?php echo __('Back')?>" onClick="document.location.href='<?php echo url_for('reservation/list')?>';">

</div>
