<?php slot('title', sprintf('GENEPI - '.__('Reservations')))?>

<?php include_partial('global/messages')?>

<?php ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login')); ?>

<head>
    <link rel="stylesheet" type="text/css" media="screen" href="/js/fullcalendar/fullcalendar.css" />
    <script type="text/javascript" src="/js/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript">

    // Réajuste les dimensions du calendrier pour éviter d'afficher un ascenseur à cause de quelques pixels (constaté sous Chrome)
    function viewDisplay(view)
    {
        if ((view.name != 'agendaDay') && (view.name != 'agendaWeek'))
            return;

        var $div_cal = $('div.fc-view-agendaDay.fc-agenda>div>div, div.fc-view-agendaWeek.fc-agenda>div>div');
        var h = $div_cal.css('height').replace('px', '');
        if (h > 0)
        {
            h = h * 1.02;
            $div_cal.css('height', h + 'px');
        }
    }

    var positions = [];
    var nb_positions = 0;

    // Compte et indexe le nombre d'éléments (ordinateurs, pièces) réservés sur la journée affichée
    function beforeResizeEvents(event, element, view)
    {
        if (view.name != 'agendaDay')
            return;

        var t = event.id.split('-');
        var obj_id = t[0];
        if (!positions[obj_id])
        {
            nb_positions++;
            positions[obj_id] = nb_positions;
        }
    }

    // Réorganise les éléments (ordinateurs, pièces) réservés sur la journée car l'affichage par
    // défaut de fullCalendar est un peu bizarre
    function resizeEvents(event, element, view)
    {
        if (view.name != 'agendaDay')
            return;

        var wtot = $('#calendar').width();
        var wunit = (wtot - 80) / nb_positions;
        if (wunit > 250)
            wunit = 250;

        $(element).css('width', (wunit - 20) + 'px');
        var t = event.id.split('-');
        var obj_id = t[0];

        var left = (positions[obj_id] - 1) * wunit + 64;
        $(element).css('left', left + 'px');
    }

    $(function() {

        $('#event_computer_filter').change(function() {
            $('#calendar').fullCalendar('refetchEvents');
        });

        $('#event_room_filter').change(function() {
            $('#event_computer_filter').val('');
        	$('#event_computer_filter').load('<?php echo url_for('reservation/AjaxSelectComputerByRoom') ?>',{room_filter: function() { return $('#event_room_filter').val();}});
            $('#calendar').fullCalendar('refetchEvents');
        });

        $('#calendar').fullCalendar({
            monthNames : ['<?php echo __('January'); ?>','<?php echo __('February'); ?>','<?php echo __('March'); ?>','<?php echo __('April'); ?>','<?php echo __('May'); ?>','<?php echo __('June'); ?>','<?php echo __('July'); ?>','<?php echo __('August'); ?>','<?php echo __('September'); ?>','<?php echo __('October'); ?>','<?php echo __('November'); ?>','<?php echo __('December'); ?>'],
            monthNamesShort : ['<?php echo __('Jan'); ?>','<?php echo __('Feb'); ?>','<?php echo __('Mar'); ?>','<?php echo __('Apr'); ?>','<?php echo __('May'); ?>','<?php echo __('Jun'); ?>','<?php echo __('Jul'); ?>','<?php echo __('Aug'); ?>','<?php echo __('Sep'); ?>','<?php echo __('Oct'); ?>','<?php echo __('Nov'); ?>','<?php echo __('Dec'); ?>'],
            dayNames : ['<?php echo __('Sunday'); ?>','<?php echo __('Monday'); ?>','<?php echo __('Tuesday'); ?>','<?php echo __('Wednesday'); ?>','<?php echo __('Thursday'); ?>','<?php echo __('Friday'); ?>','<?php echo __('Saturday'); ?>','<?php echo __('Sunday'); ?>'],
            dayNamesShort : ['<?php echo __('Sun'); ?>','<?php echo __('Mon'); ?>','<?php echo __('Tue'); ?>','<?php echo __('Wed'); ?>','<?php echo __('Thu'); ?>','<?php echo __('Fri'); ?>','<?php echo __('Sat'); ?>','<?php echo __('Sun'); ?>'],
            firstDay : 1,
            timeFormat: "<?php echo __('HH:mm{ - HH:mm} '); ?>",
            titleFormat: {
                month: "<?php echo __('MMMM yyyy'); ?>",
                week: "<?php echo __("MMMM d[ yyyy]{ '-'[ MMM] d yyyy}"); ?>",
                day: "<?php echo __('dddd, MMM d, yyyy'); ?>"
            },
            buttonText : {
                prev :     '&nbsp;&#9668;&nbsp;',
                next :     '&nbsp;&#9658;&nbsp;',
                prevYear : '&nbsp;&lt;&lt;&nbsp;',
                nextYear : '&nbsp;&gt;&gt;&nbsp;',
                today :    "<?php echo __('today'); ?>",
                month :    "<?php echo __('month'); ?>",
                week :     "<?php echo __('week'); ?>",
                day :      "<?php echo __('day'); ?>"
            },
            minTime: "<?php $time = ParametersConfiguration::getDefault('reservation_min_time'); echo $time ? $time : 8; ?>",
            maxTime: "<?php $time = ParametersConfiguration::getDefault('reservation_max_time'); echo $time ? $time : 18; ?>",
            allDaySlot: false,
            axisFormat: "<?php echo __('HH:mm{ - HH:mm} '); ?>",
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            aspectRatio: 2,
            events : {
                url: 'reservation/AjaxLoadEvents',
                type: 'GET',
                data: {
                    room_filter: function() { return $('#event_room_filter').val();},
                    computer_filter : function() { return $('#event_computer_filter').val();}
                }
            },
            viewDisplay: viewDisplay,
            eventRender: beforeResizeEvents,
            eventAfterRender: resizeEvents,
            loading: function(bool) {
                if (bool)
                {
                    $('.fc-header-title h2').hide();
                    $('.fc-header-title').append('<h1 style="margin:0;"><?php echo __('Loading').'...'; ?></h1>');
                }
                else
                {
                    if ($('.fc-header-title h1').length > 0)
                        $('.fc-header-title h1').remove();
                    $('.fc-header-title h2').show();
                }
            },
            eventClick: function(event) {

                var id = event.id;

                $("#event_detail").load(
                    '<?php echo url_for('reservation/AjaxDetailedReservation') ?>',
                    { id: event.id },
                    function(data) {

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
            },

            dayClick: function(date, allDay, jsEvent, view) {

                if (allDay) {
                    //alert('Clicked on the entire day: ' + date);
                }else{
                    //alert('Clicked on the slot: ' + date);
                }

                //alert( date.getHours() + 'h' + date.getMinutes() + ', day :'+ date.getDate() + ', month : '+ (date.getMonth()+1) +', year : '+ date.getFullYear() );

				query = "d="+date.getDate()+"&m="+(date.getMonth()+1)+"&y="+date.getFullYear();

				if ( ! allDay)
				{
					query = query + "&h=" + date.getHours() + "&min=" + date.getMinutes();
				}
                
                $("#event_detail").load(
                        '<?php echo url_for('reservation/AjaxCreateReservation') ?>',
                        query,
                        function(data) {

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
                
            }            
        });
    });

    
    </script>
</head>

<div id="event_detail" title="<?php echo __("Reservation")?>" style="display:none">
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

<div id="tabs" style="position:relative;">

    <div style='padding:5px 0;'>
        <?php echo __('Filter'); ?>
        
        <select id='event_room_filter'>
            <option value=''>- - -</option>
            <option value='room'><?php echo __('Rooms only'); ?></option>
            <?php foreach ($rooms as $room): ?>
                <option value='room-<?php echo $room->getId(); ?>'><?php echo $room->getDesignation(); ?></option>
            <?php endforeach; ?>
        </select>
        
        <select id='event_computer_filter'>
        	<option value=''>- - -</option>
            <?php foreach ($computers as $computer): ?>
                <option value='computer-<?php echo $computer->getId(); ?>'><?php echo $computer->getName(); ?></option>
            <?php endforeach; ?>
        </select>
        
        <!--
        <select id='event_filter'>
            <option value=''>- - -</option>
            <option value='computer'><?php echo __('Computers only'); ?></option>
            <?php foreach ($computers as $computer): ?>
                <option value='computer-<?php echo $computer->getId(); ?>'>&nbsp;&nbsp;-&nbsp;<?php echo $computer->getName(); ?></option>
            <?php endforeach; ?>
            <option value='room'><?php echo __('Rooms only'); ?></option>
            <?php foreach ($rooms as $room): ?>
                <option value='room-<?php echo $room->getId(); ?>'>&nbsp;&nbsp;-&nbsp;<?php echo $room->getDesignation(); ?></option>
            <?php endforeach; ?>
        </select>
        -->
        
        
    </div>

    <div id="calendar"></div>

</div>
