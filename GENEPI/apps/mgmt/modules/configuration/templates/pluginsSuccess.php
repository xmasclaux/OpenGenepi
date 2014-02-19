<?php slot('title', sprintf('GENEPI - '.__('Plugins')))?>

<script type="text/javascript">
    function hideCompulsories(id){
        $("#" + id + " tbody tr").each(function(){
            if($(this).children("td:first").html() == 1){
                $(this).hide();
            }
        });
    }

    function showCompulsories(id){
        $("#" + id + " tbody tr").each(function(){
            if($(this).children("td:first").html() == 1){
                $(this).show();
            }
        });
    }

    $(document).ready(function() {
        $("#tabs").tabs();
        document.getElementById('feedbackFrame').style.display = 'inherit';

        $("#hide_compulsory_dep input[type=checkbox]").click(function(){
            if($(this).attr("checked") == true){
                hideCompulsories("dep_table");
            }else{
                showCompulsories("dep_table");
            }
        });

        $("#hide_compulsory_dep input[type=checkbox]").ready(function(){
            hideCompulsories("dep_table");
        });


        $("#hide_compulsory_mod input[type=checkbox]").click(function(){
            if($(this).attr("checked") == true){
                hideCompulsories("activated_modules");
            }else{
                showCompulsories("activated_modules");
            }
        });

        $("#hide_compulsory_mod input[type=checkbox]").ready(function(){
            hideCompulsories("activated_modules");
        });


        $('#activated_modules').each(function() {
            $('tr:even', this).addClass('even');
        });
    });
</script>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('act/index') ?>"><?php echo __('Manage acts')?></a></h3>
    <h3><a href="<?php /* KYXAR 0007 - 01/07/2011 */ echo url_for('configuration/parameters#lists') ?>"><?php echo __('Manage public categories')?></a></h3>
    <h3><a href="<?php echo url_for('act_price/index') ?>"><?php echo __('Manage prices')?></a></h3>
    <h3><a href="<?php echo url_for('moderator/index') ?>"><?php echo __('Manage moderators')?></a></h3>
    <h3><a href="<?php echo url_for('struct/index') ?>"><?php echo __('Manage structure')?></a></h3>
    <h3><a href="<?php echo url_for('configuration/parameters') ?>"><?php echo __('Manage parameters')?></a></h3>
    <h3 class="selected"><?php echo __('Manage plugins')?></h3>
    <h3><a href="<?php echo url_for('configuration/parameters#agenda') ?>"><?php echo __('Manage agenda')?></a></h3>
    <h3><a href="<?php echo url_for('configuration/export') ?>"><?php echo __('Export logs')?></a></h3>
    <h3><a href="<?php echo url_for('dashboard/index') ?>"><?php echo __('Back to homepage')?></a></h3>
<?php end_slot(); ?>

<?php if(is_null($new) && is_null($delete) && is_null($delete_force)):?>
    <?php slot('feedbackFrame') ?>
        <div class="error-message-red" style="margin-top:-4px;">
          <span class="error-message-icon"></span>
          <?php echo __('You are in the plugin configuration menu.')?>
          <?php echo __('Changes can alter operation of the software.')?>
        </div>
    <?php end_slot();?>
<?php endif;?>

<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo __('Activated modules')?></span></a></li>
        <li><a href="#fragment-2"><span><?php echo __('Dependencies')?></span></a></li>
        <li><a href="#fragment-3"><span><?php echo __('Install/Remove')?></span></a></li>
    </ul>

    <div id="fragment-1">
        <h1><?php echo __('Activated Modules Table')?></h1>
        <div id="hide_compulsory_mod"><input type=checkbox checked><label><?php echo __('Hide compulsory modules')?></label></div><br>
        <table id="activated_modules" style="border-style: solid;">
            <thead>
                <tr>
                    <th><?php echo __('Module Name')?></th>
                    <th><?php echo __('Is Compulsory')?></th>
                    <th><?php echo __('Menu Entry Name')?></th>
                    <th><?php echo __('Module Description')?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Modules as $module):?>
                <tr>
                    <?php if($module->isCompulsory()): ?>
                        <td style="display: none"><?php echo 1?></td>
                    <?php else:?>
                        <td style="display: none"><?php echo 0?></td>
                    <?php endif;?>

                    <td><?php echo ($module->getModuleName())?></td>

                    <?php if($module->isCompulsory()): ?>
                        <td><?php echo __('yes');?></td>
                    <?php else:?>
                        <td><?php echo __('no');?></td>
                    <?php endif;?>
                    <td><?php echo __($module->getMenuEntryName())?></td>
                    <td><?php echo $module->getModuleDescription()?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="fragment-2">
        <h1><?php echo __('Dependencies Table')?></h1>
        <div id="hide_compulsory_dep"><input type=checkbox checked><label><?php echo __('Hide compulsory modules')?></label></div><br>
        <table id="dep_table">
            <thead>
                <tr>
                    <th><?php echo __('Module Name')?></th>
                    <th><?php echo __('Dependencies')?></th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($Kernel->getDependenciesTable() as $module => $dependencies):?>
                <?php $display_alert = false;?>
                <tr>
                    <td style="display: none"><?php if(Module::isCompulsoryByName($module)) echo 1; else echo 0;?></td>
                    <td style="width: 200px;" align=center><strong><?php echo($module)?></strong></td>
                    <td>
                        <table class="formTable" style="border: none;" >
                        <?php foreach ($dependencies as $dependency):?>
                            <tr>
                                <th style="width: 150px;" class="greyCell"><label><?php echo($dependency)?></label></th>
                                <td>
                                    <?php if( Module::isActivated($Modules, $dependency)):?>
                                        <div class="info-message-green">
                                            <span class="info-message-icon"></span>
                                            <?php echo __('Dependency satisfied')?>
                                        </div>
                                    <?php else:?>
                                        <div class="error-message-red">
                                            <span class="error-message-icon"></span>
                                            <?php $display_alert = true;?>
                                            <?php echo __('Dependency not satisfied')?>
                                        </div>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </table>
                    </td>
                    <?php if($display_alert):?>
                        <td style="background: none; border: none;">

                            <div class="ui-state-highlight ui-corner-all" style="margin: 0px; padding: 5px; border: 2; border-color: #990000; background: #FFFFFF;">
                                <em><?php echo __('This module is not activated.')?><br><?php echo __('Please correct the dependencies to enable this module.')?></em>
                                <br><br>
                                <?php if(!Module::isCompulsoryByName($module)):?>
                                    <form method="post" action="#">
                                        <em><?php echo __('You can also:')?></em>
                                        <input type="hidden" name="module_name_to_delete_force" value="<?php echo($module)?>"></input>
                                        <input type="submit" value="<?php echo __('Uninstall this module')?>"></input>
                                    </form>
                                <?php endif;?>

                            </div>

                        </td>
                    <?php endif;?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="fragment-3">

        <h1><?php echo __('Install a plugin')?></h1>
        <form method="post" action="#">
        <table class="formTable">
        <tr>
            <td><table class="formTable"><tbody>
                <tr valign=middle>
                    <th><label><?php echo __('Select the plugin name:')?></label></th>
                    <?php $installables = Module::getInstallables();?>
                    <td>
                    <select name="module_name_to_add" style="width: 100px;"><option></option>
                        <?php foreach($installables as $installable):?>
                            <option><?php echo($installable);?></option>
                        <?php endforeach;?>
                    </select>
                    </td>
                </tr>
                <tr valign=middle>
                    <th><label><?php echo __('Enter the plugin menu entry label:')?></label></th>

                    <td><input type="text" name="menu_entry"></input></td>

                    <td>
                        <div class="info-message">
                            <span class="info-message-icon"></span>
                            <em><?php echo __('Leave empty if the plugin must not have a menu entry.')?></em>
                        </div>
                    </td>
                </tr>

                </tbody></table></td></tr></table><br>
            <input type="submit" value="<?php echo __('Install')?>"></input>
        </form>

        <h1><?php echo __('Remove a plugin')?></h1>
        <form method="post" action="#">
            <table class="formTable">
                <tr>
                <td><table class="formTable"><tr>
                    <th><label><?php echo __('Select the plugin name:')?></label></th>
                    <td><select id="select_module" name="module_name_to_delete" style="width: 100px;"><option></option>
                        <?php $list_empty = true;?>
                        <?php foreach($Modules as $module):?>
                            <?php if(!$module->isCompulsory()):?>
                                <?php $list_empty = false;?>
                                <option><?php echo $module->getModuleName()?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                        </select>
                    </td>
                    <td>
                    <?php if($list_empty):?>
                        <div class="info-message">
                            <span class="info-message-icon"></span>
                            <em><?php echo __('No additional plugins activated')?></em>
                        </div>
                    <?php endif;?>
                    </td>
                    </tr>
                    </table>
                    </td>
                </tr>
            </table>
            <br>
            <input id="select_module_ok" type="submit" value="<?php echo __('Remove')?>"></input>
        </form>
    </div>
</div>

<?php
    if($new){
        include_component('configuration','addmodule', array('module_name' => $new, 'menu_entry' => $new_entry));
    }elseif($delete){
        include_component('configuration','removemodule', array('module_name' => $delete));
    }elseif($delete_force){
        include_component('configuration','removemoduleforce', array('module_name' => $delete_force));
    }
?>