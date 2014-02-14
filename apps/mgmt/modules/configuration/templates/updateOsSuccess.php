<?php foreach ($updated_table as $table_entry): ?>
						    <tr style="height:40px;">
						    	<td align=center><input type="checkbox"></input></td>
						    	<td class="actPrice" align=center><input type="text" size="3" style="text-align: center; border: none;" value="<?php echo $table_entry->getSortOrder()?>" readonly></input></td>
						    	<td><input type="text" size="10" style="text-align: center; border: none;" value="<?php echo $table_entry['family']?>" readonly></input></td>
						    	<td align=right><?php echo $table_entry->getDesignation() ?></td>
						    	<td style="display:none"><span><?php echo $table_entry->getId()?></span></td>	
						    </tr>
				   		<?php endforeach; ?>