<?php slot('title', sprintf('GENEPI - '.__('Groups')))?>

<?php include_partial('global/messages')?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3 class = "selected"><?php echo __('List the groups')?></h3>
    <h3><a href="<?php echo url_for('user/groupnew') ?>"><?php echo __('Add a group')?></a></h3>
<?php end_slot(); ?>

<div id="dialog" title="<?php echo __("Group users list")?>" style="display:none"></div>

<div id="tabs">

        <h1><?php echo __('Users for the group:').' '.$group->getName()?></h1>

        <form action="<?php echo url_for('user/groupusersupdate'); ?>" method="post">
        <input type='hidden' name='id' value='<?php echo $group->getId(); ?>'>

        <table id="allUsersTab" class="largeTable">
          <thead>
            <tr class="sortableTable">
              <th><?php echo __('User name')?></th>
              <th class='greyCell' style='width:20%;'>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $k => $user): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
              <td><?php echo $user->getName().' '.$user->getSurname() ?></td>
              <td align='center'><input type='checkbox' name='group_user[]' value='<?php echo $user->getId(); ?>' <?php if ($group_user[$user->getId()]) echo "checked='checked'"; ?> /></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="rightAlignement">
          <input type="submit" value="<?php echo __('Save') ?>" />
        </div>
        <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('user/groups')?>';">

        </form>

</div>
