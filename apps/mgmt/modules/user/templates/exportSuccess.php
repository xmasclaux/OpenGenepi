<?php slot('title', sprintf('GENEPI - '.__('Export')))?>

<?php include_partial('global/messages')?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3 class = "selected"><?php echo __('Export')?></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('List the groups')?></a></h3>
    <h3><a href="<?php echo url_for('user/groupnew') ?>"><?php echo __('Add a group')?></a></h3>
<?php end_slot(); ?>

<div id="dialog" title="<?php echo __("User info")?>" style="display:none"></div>

<head>
  <script type="text/javascript">

        var allUsersTab;

        var emailsToPrint = new Array();

      $(document).ready(function() {
        $("#tabs").tabs();
        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );

        $("#allUsersTab th:has(input[type=checkbox])").click(function(){

            toggleCheckAll("allUsersTab",$("#allUsersTab th input[type=checkbox]").attr("checked"));

            $("#allUsersTab").children("tbody").children("tr").each(function(){

                $(this).children("td:last").each(function(){
                    printEmails(this);
                });
            });

        });

        $("#allUsersTab td:has(input[type=checkbox])").click(function(){
            printEmails(this);
        });



        $("#allUsersTab_filter").live('keydown, keyup', function() {
            $('table tbody tr td[class="dataTables_empty"]').attr('colspan',6);
        });

        allUsersTab = $("#allUsersTab").dataTable({
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
              "iDisplayLength": <?php echo $defaultLength ?>,
              "oLanguage": {
                  "sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
                },
            "aoColumns": [
                { "bVisible": false },
                null,
                null,
                null,
                null,
                null,
                { "bSortable": false }
            ],
            "fnInitComplete": function(){
                $('table tbody tr td[class="dataTables_empty"]').attr('colspan',6);
            },
            "aaSorting": []
        } );

        $("#exportAll").click(function(){

            var userData = new Array();
            var dataToSend = new Array();

            $("#allUsersTab").children("tbody").children("tr").each(function(){

                if($(this).children("td:last").children("input[type=checkbox]").attr("checked") == true){
                    userData = allUsersTab.fnGetData(this);
                    dataToSend.push(userData[0]);
                }

            });

        });
      });

      function user_info(userId){
          $("#dialog").load('<?php echo url_for('user/AjaxUserInfo') ?>', { id: userId },
            function(data) {
                $( "#dialog" ).dialog( {
                width: 600,
                close: true,
                resizable: false,
                modal: true,
                draggable: false,
            } );
        },"json")
      }

      function toggleCheckAll(id, check){
            $("#" + id +" input[type=checkbox]").each(function(){
                $(this).attr("checked", check);
            });
       }


      function printEmails(object)
      {
            if ($(object).text() == "")
            {
                var rowNumber = allUsersTab.fnGetPosition(object);
                var data = allUsersTab.fnGetData( rowNumber[0] );
                var userId = data[0];

                if($(object).children("input").attr("checked") == true)
                {
                    $("#emails").show();

                    var name = data[1].substr(3,(data[1].length - 7));
                    var email = data[4];

                    if(emailsToPrint[userId] == null)
                    {
                        emailsToPrint[userId] = name+" <"+email+">; ";
                    }
                }

                else
                {
                    delete emailsToPrint[userId];
                }
            }

            var i;
            var emails = 0;

            $("textarea#emailExport").val("");

            for (i = 0; i <= emailsToPrint.length-1; i++)
            {
                if(emailsToPrint[i] != null)
                {
                    $("textarea#emailExport").val($("textarea#emailExport").val() + emailsToPrint[i]);
                    emails = 1;
                }
            }

            if(emails == 0)
            {
                $("#emails").hide();
            }
        }
  </script>
</head>


<h1><?php echo __('Email addresses export')?></h1>

<div class="info-message-white">
    <span class="info-message-icon"></span>
    <em><?php echo __('This menu allows you to export email addresses from selected users. To export the email address of an user, just tick the corresponding box.')?></em>
</div>
<br /><br /><br />

<form action="<?php echo url_for('user/exportEmail')?>" method="post">
    <table id="allUsersTab" class="largeTable">
      <thead>
        <tr class="sortableTable">
          <th>Id</th>
          <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
          <th style="width: 120px"><?php echo __('Birthdate')?></th>
          <th style="width: 120px"><?php echo __('Gender')?></th>
          <th><?php echo __('E-mail')?></th>
          <th style="width: 120px"><?php echo __('Cellphone number')?></th>
          <th class="greyCell" style="width:50px"><input type="checkbox"></input></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td><?php echo $user->getId()?></td>
          <td onclick="user_info(<?php echo $user->getId()?>);"><a><?php echo $user->getName() ?> <?php echo $user->getSurname() ?></a></td>
          <td><?php echo date_format(new DateTime($user->getBirthdate()), __('m-d-Y')) ?></td>
          <td><?php echo __($user->getUserGender()->getDesignation())?></td>
          <td><?php echo $user->getEmail() ?></td>
          <td><?php echo $user->getCellphoneNumber() ?></td>
          <?php if($user->getEmail() != null):?>
              <td align=center><input type="checkbox" name="usersId[]" value="<?php echo $user->getId()?>" ></input></td>
          <?php else:?>
              <td></td>
          <?php endif;?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <br /><br /><br />
    <div id="emails" style="display:none">
        <textarea class="emailExport" id="emailExport"></textarea>
    </div>

    <div class="rightAlignement">
        <input type="submit" id="exportAll" value="<?php echo __('Export email addresses')?>"/>
    </div>
</form>