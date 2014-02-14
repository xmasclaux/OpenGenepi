<div id="tabs">

    <h1><?php echo __("Add a period")?></h1>

    <div class='panel'>

        <form id="formulaire" action="<?php echo url_for('reservation/validateperiod'); ?>" method="post">
        	<input type='hidden' name='ajax' value=1>
            <input type='hidden' name='id' value='<?php echo $reservation->getId(); ?>' />
            <input type='hidden' name='create' value='<?php echo $create;?>'>

            <table class="formTable">
            <tbody>
                <tr>
                    <th><?php echo __('Type') ?></th>
                    <td>
                        <select name='type' id='type'>
                            <option value='computer'><?php echo __('Computer'); ?></option>
                            <option value='room'><?php echo __('Room'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php echo __('Computer').' / '.__('Room'); ?></th>
                    <td>
                        <div id='select_computer' class='select_type'>
                            <select name='type_computer'>
                                <?php foreach ($computers as $k => $computer): ?>
                                    <option value='<?php echo $computer->getId(); ?>'><?php echo $computer->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id='select_room' class='select_type'>
                            <select name='type_room'>
                                <?php foreach ($rooms as $k => $room): ?>
                                    <option value='<?php echo $room->getId(); ?>'><?php echo $room->getDesignation(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo __('Start date') ?></th>
                    <td>
                        <input type='text' name='start_date' id='start_date' class="datepicker" value="<?php echo $start_date;?>" />
                        <input type='hidden' name='formatted_start' id='formatted_start' value="<?php echo $formatted_start;?>"/>

                        <?php echo __('at'); ?>
                        <select name='start_hour'>
                            <?php for ($i=0 ; $i<24 ; $i++):?>
                                <option value='<?php echo $i; ?>' <?php if (sprintf('%02s', $i) == $start_hour) echo "selected=SELECTED"?>><?php echo sprintf('%02s', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                        <?php echo __(':'); ?>
                        <select name='start_minute'>
                            <?php for ($i=0 ; $i<60 ; $i+=15):?>
                                <option value='<?php echo $i; ?>' <?php if (sprintf('%02s', $i) == $start_minute) echo "selected=SELECTED"?>><?php echo sprintf('%02s', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php echo __('End date') ?></th>
                    <td>
                        <input type='text' name='end_date' id='end_date' class="datepicker" value="<?php echo $end_date;?>" />
                        <input type='hidden' name='formatted_end' id='formatted_end' value="<?php echo $formatted_end;?>"/>

                        <?php echo __('at'); ?>
                        <select name='end_hour'>
                            <?php for ($i=0 ; $i<24 ; $i++):?>
                                <option value='<?php echo $i; ?>' <?php if (sprintf('%02s', $i) == $end_hour) echo "selected=SELECTED"?>><?php echo sprintf('%02s', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                        <?php echo __(':'); ?>
                        <select name='end_minute'>
                            <?php for ($i=0 ; $i<60 ; $i+=15):?>
                                <option value='<?php echo $i; ?>' <?php if (sprintf('%02s', $i) == $end_minute) echo "selected=SELECTED"?>><?php echo sprintf('%02s', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
            </table>

            <div class="rightAlignement">
            <input type="button" id="sub" value="<?php echo __('Save') ?>" />
            </div>
            <input type="button" id="Back-Button" value="<?php echo __('Back')?>">
        </form>

    </div>

</div>



<script type='text/javascript'>

$('#sub').click(function(){
	
	form_query = $('#formulaire').serialize();

	$("#event_detail").dialog('close');
	
	$("#event_detail").load(
            '<?php echo url_for('reservation/validateperiod') ?>',
            form_query,
            function(data) {

            	$('#calendar').fullCalendar('refetchEvents');
            	
                if (!data)
                    return false;

                $("#event_detail").dialog({
                    width: 700,
                    close: true,
                    resizable: false,
                    modal: true,
                    draggable: false
                });
            }
        );		
});

$('#Back-Button').click(function(){

	$("#event_detail").dialog('close');
        		
	$("#event_detail").load(
		'<?php echo url_for('reservation/AjaxEditPeriod') ?>',
        { id: <?php echo $reservation->getId(); ?> },
        function(data) {

			if (!data) return false;

			$("#event_detail").dialog({
				width: 700,
				close: true,
				resizable: false,
				modal: true,
				draggable: false
			});
		});		
});

    function selectType()
    {
        $('.select_type').hide();
        $('#select_' + $('#type').val()).show();
    }

    $(function() {

        selectType();

        $('#type').change(selectType);
    });

    $(function() {

        var dateFrom = $('#start_date').datepicker({
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: null,
            minDate: null,
            firstDay: 1,
            altField: '#formatted_start',
            altFormat: 'yy-mm-dd',
            onSelect: function(selectedDate) {
                var option = this.id == "start_date" ? "minDate" : "maxDate";
                var instance = $(this).data("datepicker");
                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dateFrom.not(this).datepicker("option", option, date);
            }
        });

        var dateTo = $('#end_date').datepicker({
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: null,
            firstDay: 1,
            altField: '#formatted_end',
            altFormat: 'yy-mm-dd',
            beforeShow: function() {
                var startDate = $("#start_date").datepicker('getDate');
                if (startDate != null) {
                    startDate.setDate(startDate.getDate());
                    $(this).datepicker('option', 'minDate', startDate);
                }},
            onSelect: function(selectedDate) {
                var option = this.id == "start_date" ? "minDate" : "maxDate";
                var instance = $(this).data("datepicker");
                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dateTo.not(this).datepicker("option", option, date);
            }
        });

    });

    $(function($) {
        $.datepicker.regional['<?php echo $userCulture?>'] = {
            monthNamesShort: ['<?php echo __('Jan')?>','<?php echo __('Feb')?>','<?php echo __('Mar')?>','<?php echo __('Apr')?>','<?php echo __('May')?>','<?php echo __('Jun')?>','<?php echo __('Jul')?>','<?php echo __('Aug')?>','<?php echo __('Sep')?>','<?php echo __('Oct')?>','<?php echo __('Nov')?>','<?php echo __('Dec')?>'],
            dayNamesMin: ['<?php echo __('Su')?>','<?php echo __('Mo')?>','<?php echo __('Tu')?>','<?php echo __('We')?>','<?php echo __('Th')?>','<?php echo __('Fr')?>','<?php echo __('Sa')?>'],
            dateFormat: '<?php echo __('mm/dd/yy')?>'};
        $.datepicker.setDefaults($.datepicker.regional['<?php echo $userCulture?>']);
    });

</script>
