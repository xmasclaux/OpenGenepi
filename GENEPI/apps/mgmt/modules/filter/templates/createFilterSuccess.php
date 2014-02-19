<?php slot('title', sprintf('GENEPI - '.__('New filter')))?>
<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <?php
        $html_menu = '';
        foreach ($menu as $action)
        {
            if ($action['active'])
                $html_menu .= '<h3 class = "selected">'.__($action['label']).'</h3>';
            else
                $html_menu .= '<h3><a href="'.url_for("filter/$action[key]").'">'.__($action['label']).'</a></h3>';
        }
        echo $html_menu;
    ?>
<?php end_slot(); ?>

<h1>
	<?php echo __('New Filter')?>
</h1>

<div class="panel">
	<form method="post" action="<?php echo url_for('filter/createOkFilter') ?>">
		<table class="formTable">
			<tr>
				<td colspan="3"><?php echo __('Name:')?> &nbsp;<input type="text"
					id="form_name" name="form[name]">&nbsp; <?php echo __('Description:')?>
					&nbsp;<input type="text" id="form_decription"
					name="form[description]">
				</td>
			</tr>
			<tr>
				<td><?php echo __('Global Whitelist:')?></td>
				<td><?php echo __('Filter\'s Whitelist:')?></td>
				<td><?php echo __('Whitelist Helper:')?></td>
			</tr>
			<tr>
				<td><textarea id="form_GWlist" name="form[GWlist]" cols="30"
						rows="4"><?php echo $whitelist ?></textarea></td>
				<td><textarea id="form_PWlist" name="form[PWlist]" cols="30"
						rows="4"></textarea></td>
				<td><?php echo $informations->getRaw('wl_helper'); ?></td>
			</tr>
			<tr>
				<td><?php echo __('Global Blacklist:')?></td>
				<td><?php echo __('Filter\'s Blacklist:')?></td>
				<td><?php echo __('Blacklist Helper:')?></td>
			</tr>
			<tr>
				<td><textarea id="form_GBlist" name="form[GBlist]" cols="30"
						rows="4"><?php echo $blacklist ?></textarea></td>
				<td><textarea id="form_PBlist" name="form[PBlist]" cols="30"
						rows="4"></textarea></td>
				<td><?php echo $informations->getRaw('bl_helper'); ?></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo __('External blacklist to apply:')?>
				</td>
				<td><?php echo __('External lists helper:')?></td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<td><?php
							$unTiers = round(count($lists)/3);
							$deTiers = round((count($lists)/3)*2);
							$trTiers = count($lists);
							for($i=0;$i<$unTiers;$i++)
							{
								$id = $lists[$i]->getId();
								echo "<input type=\"checkbox\"  id=\"chBox_$id\" value=\"ON\" name=\"chBox_$id\"> " . $lists[$i]->getName() . "<br />";
							}
							?>
							</td>
							<td><?php
							for($i=$unTiers;$i<$deTiers;$i++)
							{
								$id = $lists[$i]->getId();
								echo "<input type=\"checkbox\"  id=\"chBox_$id\" value=\"ON\" name=\"chBox_$id\"> " . $lists[$i]->getName() . "<br />";
							}
							?>
							</td>

							<td><?php
							for($i=$deTiers;$i<$trTiers;$i++)
							{
								$id = $lists[$i]->getId();
								echo "<input type=\"checkbox\"  id=\"chBox_$id\" value=\"ON\" name=\"chBox_$id\"> " . $lists[$i]->getName() . "<br />";
							}
							?>
							</td>
						</tr>
					</table>
				</td>
				<td><?php echo $informations->getRaw('el_helper'); ?></td>
			</tr>
		</table>
		<input type="button" onclick="document.location.href='<?php echo url_for('filter/index') ?>';" value="<?php echo __('Back') ?>">
		<div class="rightAlignement">
			<input type="submit" value="<?php echo __('Save')?>">
		</div>
	</form>
</div>
