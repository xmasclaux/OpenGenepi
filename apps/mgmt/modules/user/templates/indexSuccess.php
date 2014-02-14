<?php slot('title', sprintf('GENEPI - '.__('Users')))?>

<?php include_partial('global/messages')?>

<head>
  <script type="text/javascript">

      $(document).ready(function() {
        $("#tabs").tabs();
        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );

        $("#allUsersTab, #subscribersTab, #nonSubscribersTab").dataTable({
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
              "iDisplayLength": <?php echo $defaultLength ?>,
              "oLanguage": {
                  "sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
                },
            "aaSorting": []
        } );

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
  </script>
</head>


<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3 class = "selected"><?php echo __('List the users')?></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('List the groups')?></a></h3>
    <h3><a href="<?php echo url_for('user/groupnew') ?>"><?php echo __('Add a group')?></a></h3>
<?php end_slot(); ?>


<div id="dialog" title="<?php echo __("User info")?>" style="display:none"></div>

<div id="tabs">
    <ul>
        <li><a href="#all"><span><?php echo __('All')?></span></a></li>
        <li><a href="#subscriber"><span><?php echo __('Subscribers')?></span></a></li>
        <li><a href="#nonSubscriber"><span><?php echo __('Non-subscribers')?></span></a></li>
    </ul>
    <div id="all">
        <h1><?php echo __('Users list')?></h1>
        <table id="allUsersTab" class="largeTable">
          <thead>
            <tr class="sortableTable">
              <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
              <th style="width: 120px"><?php echo __('Birthdate')?></th>
              <th style="width: 120px"><?php echo __('Gender')?></th>
              <th><?php echo __('E-mail')?></th>
              <th style="width: 120px"><?php echo __('Cellphone number')?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
              <td onclick="user_info(<?php echo $user->getId()?>);"><a><?php /* KYXAR 0004 - 30/06/2011 */ echo $user->getSurname() ?> <?php echo $user->getName() ?></a></td>
              <td><?php echo date_format(new DateTime($user->getBirthdate()), __('m-d-Y')) ?></td>
              <td><?php echo __($user->getUserGender()->getDesignation())?></td>
              <td><?php echo $user->getEmail() ?></td>
              <td><?php echo $user->getCellphoneNumber() ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="rightAlignement">
            <input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('user/new')?>';">
        </div>

    </div>
    <div id="subscriber">
        <h1><?php echo __('Subscribers list')?></h1>
        <div class="info-message-white">
            <span class="info-message-icon"></span>
            <em><?php echo __('A subscriber is an user to whom a moderator has imputed at least one subscription.')?></em>
        </div>
        <br /><br />
        <table id="subscribersTab" class="largeTable">
          <thead>
            <tr class="sortableTable">
              <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
              <th style="width: 120px"><?php echo __('Birthdate')?></th>
              <th style="width: 120px"><?php echo __('Gender')?></th>
              <th><?php echo __('E-mail')?></th>
              <th style="width: 120px"><?php echo __('Cellphone number')?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subscribers as $subscriber): ?>
            <tr>
              <td onclick="user_info(<?php echo $subscriber->getId()?>);"><a><?php echo $subscriber->getName() ?> <?php echo $subscriber->getSurname() ?></a></td>
              <td><?php echo date_format(new DateTime($subscriber->getBirthdate()), __('m-d-Y')) ?></td>
              <td><?php echo __($subscriber->getUserGender()->getDesignation())?></td>
              <td><?php echo $subscriber->getEmail() ?></td>
              <td><?php echo $subscriber->getCellphoneNumber() ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
    <div id="nonSubscriber">
        <h1><?php echo __('Non-subscribers list')?></h1>
        <table id="nonSubscribersTab" class="largeTable">
          <thead>
            <tr class="sortableTable">
              <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
              <th style="width: 120px"><?php echo __('Birthdate')?></th>
              <th style="width: 120px"><?php echo __('Gender')?></th>
              <th><?php echo __('E-mail')?></th>
              <th style="width: 120px"><?php echo __('Cellphone number')?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($nonSubscribers as $nonSubscriber): ?>
            <tr>
              <td onclick="user_info(<?php echo $nonSubscriber->getId()?>);"><a><?php echo $nonSubscriber->getName() ?> <?php echo $nonSubscriber->getSurname() ?></a></td>
              <td><?php echo date_format(new DateTime($nonSubscriber->getBirthdate()), __('m-d-Y')) ?></td>
              <td><?php echo __($nonSubscriber->getUserGender()->getDesignation())?></td>
              <td><?php echo $nonSubscriber->getEmail() ?></td>
              <td><?php echo $nonSubscriber->getCellphoneNumber() ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
</div>

