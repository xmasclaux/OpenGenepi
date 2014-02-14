<?php foreach ($updated_table as $entry): ?>
	<?php if(!$entry->getDisabled()):?>
		<tr style="height:40px;">
			<td align=center><input type="checkbox"></input></td>
			<td class="actPrice" align=center><input type="text" size="3" style="text-align: center; border: none;" value="<?php echo $entry->getSortOrder()?>"></input></td>
			<td class="actPrice" align=center><input type="text" size="3" style="text-align: center; border: none;" value="<?php echo $entry->getShortenedDesignation()?>"></input></td>
			<td align=right>
				<?php echo $entry->getDesignation() ?>
			</td>
			<td style="display: none"><span><?php echo $entry->getId()?></span></td>
		</tr>
	<?php endif;?>
<?php endforeach; ?>
