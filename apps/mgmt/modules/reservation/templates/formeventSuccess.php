<?php slot('title', sprintf('GENEPI - '.__('Add a reservation')))?>

<?php include_partial('global/messages')?>

<head>
    <script type='text/javascript'>

    function event_deletion()
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

        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
    });

    </script>
</head>

<?php if ($event): ?>
    <div id="dialog" title="<?php echo __("Event deletion")?>" style="display:none">
        <p><?php echo __("Caution, this event will be deleted.") ?></p>

        <input type="button" id="back-button" value=<?php echo __('Back')?>></input>

        <span class="deletion-button" style="float:right; margin-top:18px;">
            <?php echo link_to(__('Confirm'), 'reservation/deleteevent?id='.$event->getId(), array('method' => 'delete')) ?>
        </span>
    </div>
<?php endif; ?>

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

    <h1><?php if ($event) echo __("Edit a event"); else echo __("Add a event")?></h1>

    <div class='panel'>

        <form action="<?php echo url_for('reservation/validateevent'); ?>" method="post">
            <input type='hidden' name='id' value='<?php if ($event) echo $event->getId(); ?>' />

            <table class="formTable">
            <tbody>
                <tr>
                    <th><?php echo __('Title') ?></th>
                    <td><input type='text' name='designation' value='<?php if ($event) echo $event->getDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Description') ?></th>
                    <td><textarea name='description' rows='4' cols='30'><?php if ($event) echo $event->getDescription(); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php echo __('Reservation') ?></th>
                    <td>
                        <select name='reservation_id' id='reservation_id'>
                            <?php foreach ($reservations as $reservation): ?>
                                <option value='<?php echo $reservation->getId(); ?>'<?php if ($event && ($event->getReservationId() == $reservation->getId())) echo " selected='selected'"; ?>><?php echo $reservation->getDesignation(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
            </table>

            <div class="rightAlignement">
                <input type="submit" value="<?php echo __('Save') ?>" />
            </div>
            <input type="button" value="<?php echo __('Back')?>" onClick="document.location.href='<?php echo url_for('reservation/events')?>';">
            <?php if ($event): ?>
                <span class="deletion-button" onclick="event_deletion();">
                    <input type="button" value="<?php echo __('Delete')."..."?>"></input>
                </span>
            <?php endif; ?>

        </form>

    </div>

</div>
