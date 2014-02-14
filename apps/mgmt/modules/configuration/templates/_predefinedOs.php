<div>
	<h1 id="<?php echo $table_name.'_title' ?>" style="margin-top: 60px; padding-top: 1px;"><?php echo __($table_title)?><span class="rightAlignement" style="margin-right: 0"><a href="#lists"><?php echo __('Top')?></a></span></h1>
    <table style="border: none">
    	<thead></thead>
    	<tbody>
        	<tr>
        	<td style="background: none" valign=top>
				<table id="<?php echo $table_name ?>" >
				  	<thead>
					    <tr>
					    	<th class="greyCell"><input type="checkbox"></input></th>
					    	<th><?php echo __('Order')?></th>
					    	<th><?php echo __('Family')?></th>
					    	<th><?php echo __('Designation')?></th>
					    </tr>
				  	</thead>
				  	<tbody>
					    <?php foreach ($table_data as $table_entry): ?>
						    <tr style="height:40px;">
						    	<td align=center><input type="checkbox"></input></td>
						    	<td class="actPrice" align=center><input type="text" size="3" style="text-align: center; border: none;" value="<?php echo $table_entry->getSortOrder()?>"></input></td>
						    	<td align=center><input type="text" size="10" style="text-align: center; border: none;" value="<?php echo $table_entry['family']?>" readonly></input></td>
						    	<td align=right><?php echo $table_entry->getDesignation() ?></td>
						    	<td style="display:none"><span><?php echo $table_entry->getId()?></span></td>	
						    </tr>
				   		<?php endforeach; ?>
				  	</tbody>
				  	<tfoot>
					  	<tr>
					  		<td></td>
					  		<td colspan=3><input style="text-align:right; font-style:italic; font-weight:bold;" type="text" value="<?php echo __('New')?>..."></input></td>
					  	</tr>
					  	
					  	<tr>
						  	<td><input type="button" name="del" value="<?php echo __('Delete')?>"></td>
						  	<td colspan=3><input class="rightAlignement" type="button" name="add" value="<?php echo __('Add')?>"></td>
					  	</tr>
				 	 </tfoot>
				</table>
			</td>
			
			<td style="background: none; display: none;" valign=top>
				<div id="<?php echo $table_name.'_to_delete_info_delete' ?>" class="info-message-white">
			    	<span class="info-message-icon"></span>
					<em><?php echo __('Theses entries are going to be removed')?>:</em>
				</div>
			</td>
			
			<td style="background: none; display: none;" valign=top>
				<table id="<?php echo $table_name.'_to_delete' ?>">
					<thead>
					    <tr>
					    	<th><input type="checkbox"></input></th>
					    	<th><?php echo __('Order')?></th>
					    	<th colspan=2><?php echo __('Will be removed')?></th>
					    </tr>
				  </thead>
				  <tbody></tbody>
				  <tfoot>
				  	<tr>
					  	<td><button type="button" name="cancel"><?php echo image_tag('cancelRemoveArrow.png', array()) ?></button></td>
					  	<td></td>
				  	</tr>
				  </tfoot>
				</table>
			</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td style="background: none">
					<div class="info-message-white" style="float:left; margin-left:20px; display:none">
			    		<span class="info-message-icon"></span>
						<em><?php echo __('The list has been updated')?></em>
					</div>
				</td>
				<td colspan=2 style="background: none">
					<div>
						<input type="button" name="update" value="<?php echo __('Ok')?>" style="float:left"></input>
						<div class="info-message-white" style="float:left; margin-left:20px; margin-top:13px; display:none">
			    			<span class="info-message-icon"></span>
							<em><?php echo __('Caution: Click on \'Ok\' will only update this table')?><br></em>
						</div>
						<br style="clear:left">
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
