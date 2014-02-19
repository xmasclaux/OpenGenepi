
<?php foreach ($updated_table as $entry): ?>
	<tr style="height:40px;">
		<td align=center><input type="checkbox"></input></td>
		<td class="actPrice" align=center><input type="text" size="3" style="text-align: center; border: none;" value="<?php echo $entry->getSortOrder()?>"></input></td>
		<td align=right>
			<?php if($table_name == PredefinedLists::COMPUTER_OS_FAMILY):?>
						    			<?php echo $entry->getFamily() ?>
						    		<?php else:?>
						    			<?php echo $entry->getDesignation() ?>
						    		<?php endif;?>
		</td>
		<td style="display: none"><span><?php echo $entry->getId()?></span></td>
	</tr>
<?php endforeach; ?>
