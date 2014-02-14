<?php slot('title', sprintf('GENEPI - '.__('Anonymization')))?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3 class = "selected"><?php echo __('Anonymize')?></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('List the groups')?></a></h3>
    <h3><a href="<?php echo url_for('user/groupnew') ?>"><?php echo __('Add a group')?></a></h3>
<?php end_slot(); ?>

<h1><?php echo __('Uses anonymization')?></h1>

<script type="text/javascript">
    $(document).ready(function() {

        function anonymize(){
            $("#dialog").dialog( {
                width: 700,
                close: false,
                resizable: false,
                modal: true,
                draggable : false,
                buttons: {
                    <?php echo __('Confirm') ?>: function() {
                        document.anonymization.submit();
                    },
                    <?php echo __('Back') ?>: function() {
                            $(this).dialog("close");
                    }
                }

            } );
        };

        $('input[type="button"]').click(function(){
            $("#helpDialog").dialog( {
                width: 700,
                close: false,
                resizable: false,
                modal: true,
                draggable : false,
                buttons: {
                    <?php echo __('Ok') ?>: function() {
                            $(this).dialog("close");
                    }
                }
            } );
        });

        $('form#anonymization input[name="confirm"]').click(function(){
            $("span#anonymization").html($('input:radio:checked').attr("id"));
            anonymize();
            return false;
        });

        $('input:radio').click(function(){
            $('input[name="confirm"]').show();
        });
    });
</script>

<div id="dialog" title="<?php echo __('Uses anonymization')?>" style="display:none">
    <p><?php echo __('All the imputations realized more than')." "?><span id ="anonymization" style="font-weight: bold;"></span><?php echo " ".__('will be anonymized.')?></p>
    <p><?php echo __('Caution, this action is irreversible.')?></p>
</div>

<div id="helpDialog" title="<?php echo __('Help')?>" style="display:none">
    <p><?php echo __('Once this action performed, there will not be a match between an use an an user anymore.')?></p>
    <p><?php echo __('It will not affect the statistics, only the history.')?></p>
    <p><?php echo __("Furthermore, accounts and susbscriptions won't be affected.")?></p>
</div>

<form name="anonymization" id="anonymization" action="<?php echo url_for('user/anonymization') ?>" method="post">
    <div class="panel">
        <h6><?php echo __('Anonymize all the uses that happened more than')." : "?></h6>
        <table class="twoColumnsTableForm">
            <tr><td><input type="radio" name="anonymization" id="<?php echo __('three months ago')?>" value="1"><?php echo __('three months ago')?></td></tr>
            <tr><td><input type="radio" name="anonymization" id="<?php echo __('six months ago')?>" value="2"><?php echo __('six months ago')?></td></tr>
            <tr><td><input type="radio" name="anonymization" id="<?php echo __('one year ago')?>" value="3"><?php echo __('one year ago')?></td></tr>
            <tr><td><input type="radio" name="anonymization" id="<?php echo __('two years ago')?>" value="4"><?php echo __('two years ago')?></td></tr>
        </table>
    </div>
    <span class="deletion-button">
          <input type="button" value="<?php echo __('Help')."..."?>"></input>
    </span>
    <div class="rightAlignement"><input type="submit" style="display:none" name="confirm" value="<?php echo __('Confirm')."..."?>" /></input></div>
</form>