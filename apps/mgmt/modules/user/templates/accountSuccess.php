<?php slot('title', sprintf('GENEPI - '.__('Accounts')))?>

<?php include_partial('global/messages')?>

<head>
  <script type="text/javascript">

        var accountUsers;

        $("#accountUsersTable_filter").live('keydown, keyup', function() {
        $('table tbody tr td[class="dataTables_empty"]').attr('colspan',4);
      });

      $(document).ready(function() {

        $('#accountUsersTable tr').each(function(e, f){
              $(f).mouseover(
                   function() { $('#accountUsersTable tr:nth-child(' + e + ')').addClass("highlight"); },
                   function() { $('#accountUsersTable tr:nth-child(' + e + ')').removeClass("highlight"); }
              );
              $(f).mouseout(
                   function() { $('#accountUsersTable tr:nth-child(' + e + ')').removeClass("highlight"); }
              );
        });

        $("#accountDeletion").click(function(){removeAccount();});

        $('#accountUsersTable tbody tr td:not(:has(input[type="checkbox"]))').live('click', function () {
            var rowNumber = accountUsers.fnGetPosition(this);
            var data = accountUsers.fnGetData(rowNumber[0]);
            var accountId = data[4];

            $("#dialogAccountInfo").load('<?php echo url_for('user/AjaxAccountInfo') ?>', { id: accountId },
                    function(data) {
                        $( "#dialogAccountInfo" ).dialog( {
                        width: 750,
                        close: true,
                        resizable: false,
                        modal: true,
                        draggable: false,
                        buttons: {
                            "Ok": function() { $(this).dialog("close"); }}
                    } );
                },"json")
        });

        accountUsers = $("#accountUsersTable").dataTable({
            "aoColumns": [
                { "bSortable": false },
                  null,
                  null,
                  null,
                  {"bVisible": false}
            ],
            "fnInitComplete": function(){
                $('table tbody tr td[class="dataTables_empty"]').attr('colspan',4);
            },
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
              "iDisplayLength": <?php echo $defaultLength ?>,
              "oLanguage": {
                  "sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
                }
        } );
      });

      function removeAccount(){
          var accountId = new Array();
          $("#accountUsersTable tbody tr:has(input[type=checkbox]:checked)").each(function(){
              var rowNumber = accountUsers.fnGetPosition( this );
              var data = accountUsers.fnGetData( rowNumber );

              if(jQuery.inArray(data[4], accountId))
              {
                accountId.push(data[4]);
              }
          })

          $("#dialog").load('<?php echo url_for('user/AjaxDeleteAccount') ?>', { id: accountId },
            function(data) {
                $( "#dialog" ).dialog( {
                width: 750,

                close: true,
                resizable: false,
                modal: true,
                draggable: false,
            } );
        },"json")

      }

  </script>
</head>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3 class = "selected"><?php echo __('Manage the accounts')?></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('List the groups')?></a></h3>
    <h3><a href="<?php echo url_for('user/groupnew') ?>"><?php echo __('Add a group')?></a></h3>
<?php end_slot(); ?>

<h1><?php echo __('Accounts list')?></h1>

<div id="dialog" title="<?php echo __("Account deletion")?>" style="display:none"></div>
<div id="dialogAccountInfo" title="<?php echo __("Account info")?>" style="display:none"></div>

<div class="info-message-white">
    <span class="info-message-icon"></span>
    <em><?php echo __('This menu allows you to delete accounts, monetary or not.')?></em>
    <em><?php echo __('Once an account is deleted, its value is lost, and the former user(s) cannot use it anymore.')?></em>
</div>
<br /><br /><br /><br />

<table class="largeTable" id="accountUsersTable">
  <thead>
    <tr class="sortableTable">
      <th class="greyCell" style="width:50px"></th>
      <th><?php echo __("Account name");?></th>
      <th><?php echo __("User");?></th>
      <th style="width: 180px"><?php echo __("Value");?></th>
      <th class="hiddenCell"><?php echo "accountId" ?></th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($accountUsers as $accountUser): ?>
        <tr <?php if($accountUser->getAccount()->getValue()<0) echo 'style="color:#ff3333"'?>>
          <td align=center>
              <input type="checkbox"></input>
          </td>
          <td><?php echo __($accountUser->getAccount()->getAct()->getDesignation());?></td>
          <td><?php echo __($accountUser->getUser());?></td>
          <td>
            <?php echo $accountUser->getAccount()->getValue()." ".$accountUser->getAccount()->getAct()->getUnity();?>
          </td>

          <td class="hiddenCell"><?php echo __($accountUser->getAccountId());?></td>
        </tr>
      <?php endforeach; ?>
  </tbody>
</table>

<div class="rightAlignement">
    <input type="button" id="accountDeletion" value="<?php echo __('Delete')."..."?>">
</div>
