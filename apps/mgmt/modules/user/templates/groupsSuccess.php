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

<div id="dialog" title="<?php echo __("Groups list")?>" style="display:none"></div>

<div id="tabs">

        <h1><?php echo __('Groups list')?></h1>
        <table id="allGroupsTab" class="largeTable">
          <thead>
            <tr class="sortableTable">
              <th><?php echo __('Group name')?></th>
              <th class='greyCell' style='width:20%;'>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($groups as $k => $group): ?>
            <tr class="<?php if ($k % 2) echo 'even'; else echo 'odd'; ?>">
              <td><a href='<?php echo url_for('user/groupedit?id='.$group->getId())?>'><?php echo $group->getName() ?></a></td>
              <td align='center'><a href='<?php echo url_for('user/groupusers?id='.$group->getId())?>'><?php echo __('Manage users')?></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="rightAlignement">
            <input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('user/groupnew')?>';">
        </div>

</div>
