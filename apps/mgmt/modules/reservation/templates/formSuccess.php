<?php slot('title', sprintf('GENEPI - '.__('Add a reservation')))?>

<?php include_partial('global/messages')?>

<head>
    <script type='text/javascript'>

    function selectType()
    {
        $('.select_type').hide();
        $('#select_' + $('#type').val()).show();
    }

    function reservation_deletion()
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

        selectType();

        $('#type').change(selectType);
        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
    });

    </script>
</head>

<?php if ($reservation): ?>
    <div id="dialog" title="<?php echo __("Reservation deletion")?>" style="display:none">
        <p><?php echo __("Caution, this reservation will be deleted.") ?></p>

        <input type="button" id="back-button" value="<?php echo __('Back')?>"></input>

        <span class="deletion-button" style="float:right; margin-top:18px;">
            <?php echo link_to(__('Confirm'), 'reservation/delete?id='.$reservation->getId(), array('method' => 'delete')) ?>
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

    <h1><?php echo __("Add a reservation")?></h1>

    <div class='panel'>

        <form action="<?php echo url_for('reservation/validate'); ?>" method="post">
            <input type='hidden' name='id' value='<?php if ($reservation) echo $reservation->getId(); ?>' />

            <table class="formTable">
            <tbody>
                <tr>
                    <th><?php echo __('Title') ?></th>
                    <td><input type='text' name='designation' value='<?php if ($reservation) echo $reservation->getDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Description') ?></th>
                    <td><textarea name='description' rows='4' cols='30'><?php if ($reservation) echo $reservation->getDescription(); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php echo __('Type') ?></th>
                    <td>
                        <select name='type' id='type'>
                            <option value='user'<?php if ($reservation && ($reservation->getType() == 'user')) echo " selected='selected'"; ?>><?php echo __('User'); ?></option>
                            <option value='group'<?php if ($reservation && ($reservation->getType() == 'group')) echo " selected='selected'"; ?>><?php echo __('Group'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php echo __('User').' / '.__('Group').' / '.__('Event'); ?></th>
                    <td>
                        <div id='select_user' class='select_type'>
                            <select name='type_user'>
                                <?php foreach ($users as $k => $user): ?>
                                    <?php

                                        $sel = '';
                                        if ($reservation && ($reservation->getType() == 'user') && ($user->getId() == $reservation->getTypeId()))
                                            $sel = " selected='selected'";

                                    ?>
                                    <option value='<?php echo $user->getId(); ?>'<?php echo $sel; ?>><?php echo $user->getSurname().' '.$user->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id='select_group' class='select_type'>
                            <select name='type_group'>
                                <?php foreach ($groups as $k => $group): ?>
                                    <?php

                                        $sel = '';
                                        if ($reservation && ($reservation->getType() == 'group') && ($group->getId() == $reservation->getTypeId()))
                                            $sel = " selected='selected'";

                                    ?>
                                    <option value='<?php echo $group->getId(); ?>'<?php echo $sel; ?>><?php echo $group->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </td>
                </tr>
                <tr>
                    <th><?php echo __('Public') ?></th>
                    <td><input type='checkbox' name='public' value='1' <?php if ($reservation && $reservation->getPublic()) echo "checked='checked'"; ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Public title') ?></th>
                    <td><input type='text' name='public_designation' value='<?php if ($reservation) echo $reservation->getPublicDesignation(); ?>' /></td>
                </tr>
                <tr>
                    <th><?php echo __('Public description') ?></th>
                    <td><textarea name='public_description' rows='4' cols='30'><?php if ($reservation) echo $reservation->getPublicDescription(); ?></textarea></td>
                </tr>
            </tbody>
            </table>

            <div class="rightAlignement">
                <input type="submit" value="<?php echo __('Save') ?>" />
            </div>
            <input type="button" value="<?php echo __('Back')?>" onClick="document.location.href='<?php echo url_for('reservation/list')?>';">
            <?php if ($reservation): ?>
                <span class="deletion-button" onclick="reservation_deletion();">
                    <input type="button" value="<?php echo __('Delete')."..."?>"></input>
                </span>
            <?php endif; ?>

        </form>

    </div>

</div>
