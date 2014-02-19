<?php slot('title', sprintf('GENEPI - '.__('Temporal statement')))?>

<h1>
	<?php echo __("Temporal statement"); ?>
	<br />
	<?php echo "-"?>
	<br />
	<?php echo __('From the ').date_format(date_create($from), __('m/d/Y'))." ".__('to the ').date_format(date_create($to), __('m/d/Y'))?>
</h1>

<div id="panelStat">
	<div class="info-message-white">
    	<span class="info-message-icon"></span>
		<em><?php echo __('Temporal statistics per act depending on different criterias.')?></em>
	</div>	
	<br /><br />
	<table class="statementTable">
		  <thead>
		 	 <tr>
		        <th>
		        	<div style="width:200px">
		        		<?php echo __('Criterias') ?>
		        	</div>
		        </th>
		        
		        <?php foreach($statement as $act => $stat):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo $act ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        <th><?php echo __('Total') ?></th>
		      </tr>
		  </thead>
		  <tbody>
		    <tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('Global data')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Global Data'] as $column):?>
				<tr>
			  		<td>
			  			<?php echo __($column)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
				  		<td class="centered">
				  			<?php echo gmdate('G', $stat[$column]).'h'.gmdate('i', $stat[$column])?>
				  		</td>
			  		<?php endforeach;?>
			  		<td class="centered">
			  			<?php echo gmdate('G', $total[$column]).'h'.gmdate('i', $total[$column])?>
			  		</td>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By gender')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Gender'] as $column):?>
				<tr>
			  		<td>
			  			<?php echo __($column)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
				  		<td class="centered">
				  			<?php echo gmdate('G', $stat[$column]).'h'.gmdate('i', $stat[$column])?>
				  		</td>
			  		<?php endforeach;?>
			  		<td class="centered">
			  			<?php echo gmdate('G', $total[$column]).'h'.gmdate('i', $total[$column])?>
			  		</td>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By age range')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Age range'] as $column):?>
				<tr>
			  		<td>
			  			<?php echo __($column)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
				  		<td class="centered">
				  			<?php echo gmdate('G', $stat[$column]).'h'.gmdate('i', $stat[$column])?>
				  		</td>
			  		<?php endforeach;?>
			  		<td class="centered">
			  			<?php echo gmdate('G', $total[$column]).'h'.gmdate('i', $total[$column])?>
			  		</td>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By countries/cities')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($countries as $country):?>
				<tr>
					<td>
						<?php echo __($country);?>
					</td>
					<?php foreach($statement as $stat):?>
						<?php if(isset($stat[$country])):?>
							<td class="centered">
						  		<?php echo gmdate('G', $stat[$country][0]).'h'.gmdate('i', $stat[$country][0])?>
						  	</td>
						<?php else:?>
							<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
						<?php endif;?>
					<?php endforeach;?>
					<td class="centered">
			  			<?php echo gmdate('G', $total[$country][0]).'h'.gmdate('i', $total[$country][0])?>
			  		</td>
				</tr>
				<?php foreach($cities[$country] as $city):?>
					<tr>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $city?>
						</td>
						<?php foreach($statement as $stat):?>
							<?php if(isset($stat[$country])&&(isset($stat[$country][$city]))):?>
						  		<td class="centered">
						  			<?php echo gmdate('G', $stat[$country][$city]).'h'.gmdate('i', $stat[$country][$city] )?>
						  		</td>
						  	<?php else:?>
						  		<td class="centered">
						  			<?php echo "0h00"?>
						  		</td>
						  	<?php endif;?>
			  			<?php endforeach;?>
			  			<td class="centered">
			  				<?php echo gmdate('G', $total[$country][$city]).'h'.gmdate('i', $total[$country][$city])?>
			  			</td>
					</tr>
				<?php endforeach;?>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By day/time slot')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Day'] as $day):?>
				<tr>
			  		<td>
			  			<?php echo __($day)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
						<?php if(isset($stat[$day])):?>
							<td class="centered">
						  		<?php echo gmdate('G', $stat[$day][0]).'h'.gmdate('i', $stat[$day][0])?>
						  	</td>
						<?php else:?>
							<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
						<?php endif;?>
					<?php endforeach;?>
					<?php if(isset($total[$day])):?>
						<td class="centered">
				  			<?php echo gmdate('G', $total[$day][0]).'h'.gmdate('i', $total[$day][0])?>
				  		</td>
				  	<?php else:?>
				  		<td class="centered">
					  		<?php echo "0h00"?>
					  	</td>
				  	<?php endif;?>
				</tr>
				<?php foreach($columns['Time slot'] as $timeSlot):?>
					<tr>
				  		<td>
				  			&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __($timeSlot)?>
				  		</td>
				  		<?php foreach($statement as $stat):?>
							<?php if(isset($stat[$day]) && isset($stat[$day][$timeSlot])):?>
								<td class="centered">
							  		<?php echo gmdate('G', $stat[$day][$timeSlot]).'h'.gmdate('i', $stat[$day][$timeSlot])?>
							  	</td>
							<?php else:?>
								<td class="centered">
							  		<?php echo "0h00"?>
							  	</td>
							<?php endif;?>
						<?php endforeach;?>
						<?php if(isset($total[$day]) && isset($total[$day][$timeSlot])):?>
							<td class="centered">
					  			<?php echo gmdate('G', $total[$day][$timeSlot]).'h'.gmdate('i', $total[$day][$timeSlot]) ?>
					  		</td>
				  		<?php else:?>
					  		<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
				  		<?php endif;?>
				  	</tr>
				  	<?php foreach($columns[$timeSlot]['Hour'] as $hour):?>
					  	<tr>
					  		<td>
					  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __($hour)?>
					  		</td>
					  		<?php foreach($statement as $stat):?>
								<?php if(isset($stat[$day]) && isset($stat[$day][$hour])):?>
									<td class="centered">
								  		<?php echo gmdate('G', $stat[$day][$hour]).'h'.gmdate('i', $stat[$day][$hour]) ?>
								  	</td>
								<?php else:?>
									<td class="centered">
								  		<?php echo "0h00"?>
								  	</td>
								<?php endif;?>
							<?php endforeach;?>
					  		<?php if(isset($total[$day]) && isset($total[$day][$hour])):?>
								<td class="centered">
						  			<?php echo gmdate('G', $total[$day][$hour]).'h'.gmdate('i', $total[$day][$hour])?>
						  		</td>
					  		<?php else:?>
						  		<td class="centered">
							  		<?php echo "0h00"?>
							  	</td>
				  			<?php endif;?>
					  	</tr>
				  	<?php endforeach;?>
				<?php endforeach;?>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By public category')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Category'] as $id => $category):?>
				<tr>
			  		<td>
			  			<?php echo __($category)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
			  			<?php if(isset($stat['Category']) && isset($stat['Category'][$id])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $stat['Category'][$id]).'h'.gmdate('i', $stat['Category'][$id])?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					  	<?php endif;?>
			  		<?php endforeach;?>
			  		<?php if(isset($total['Category'][$id])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Category'][$id]).'h'.gmdate('i', $total['Category'][$id]) ?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					 <?php endif;?>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By socio-economic group')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['SEG'] as $id => $seg):?>
				<tr>
			  		<td>
			  			<?php echo __($seg)?>
			  		</td>
			  		<?php foreach($statement as $stat):?>
			  			<?php if(isset($stat['SEG']) && isset($stat['SEG'][$id])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $stat['SEG'][$id]).'h'.gmdate('i', $stat['SEG'][$id])?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					  	<?php endif;?>
			  		<?php endforeach;?>
			  		<?php if(isset($total['SEG'][$id])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['SEG'][$id]).'h'.gmdate('i', $total['SEG'][$id])?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					  <?php endif;?>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By building/room/computer')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Building'] as $buildingId => $building):?>
				<tr>
					<td>
						<?php echo $building?>
					</td>
					<?php foreach($statement as $stat):?>
			  			<?php if(isset($stat['Building']) && isset($stat['Building'][$buildingId])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $stat['Building'][$buildingId][0]).'h'.gmdate('i', $stat['Building'][$buildingId][0])?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					  	<?php endif;?>
			  		<?php endforeach;?>
			  		<?php if(isset($total['Building'][$buildingId])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Building'][$buildingId][0]).'h'.gmdate('i', $total['Building'][$buildingId][0]) ?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					  <?php endif;?>
				</tr>
				<?php if(isset($columns[$buildingId])):?>
				<?php foreach($columns[$buildingId]['Room'] as $roomId => $room):?>
					<tr>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $room?>
						</td>
						<?php foreach($statement as $stat):?>
				  			<?php if(isset($stat['Building']) && isset($stat['Building'][$buildingId]) && isset($stat['Building'][$buildingId][$roomId])):?>
						  		<td class="centered">
						  			<?php echo gmdate('G', $stat['Building'][$buildingId][$roomId][0]).'h'.gmdate('i', $stat['Building'][$buildingId][$roomId][0]) ?>
						  		</td>
						  	<?php else:?>
						  		<td class="centered">
						  			<?php echo "0h00"?>
						  		</td>
						  	<?php endif;?>
			  			<?php endforeach;?>
			  			<?php if(isset($total['Building'][$buildingId]) && (isset($total['Building'][$buildingId][$roomId]))):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Building'][$buildingId][$roomId][0]).'h'.gmdate('i', $total['Building'][$buildingId][$roomId][0]) ?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					    <?php endif;?>
					</tr>
					<?php foreach($columns[$buildingId][$roomId]['Computer'] as $computerId => $computer):?>
						<tr>
							<td>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __($computer)?>
							</td>
							<?php foreach($statement as $stat):?>
					  			<?php if(isset($stat['Building']) && isset($stat['Building'][$buildingId]) && isset($stat['Building'][$buildingId][$roomId]) && isset($stat['Building'][$buildingId][$roomId][$computerId])):?>
							  		<td class="centered">
							  			<?php echo gmdate('G', $stat['Building'][$buildingId][$roomId][$computerId]).'h'.gmdate('i', $stat['Building'][$buildingId][$roomId][$computerId]) ?>
							  		</td>
							  	<?php else:?>
							  		<td class="centered">
							  			<?php echo "0h00"?>
							  		</td>
							  	<?php endif;?>
			  				<?php endforeach;?>
			  				<?php if(isset($total['Building'][$buildingId]) && (isset($total['Building'][$buildingId][$roomId])) && (isset($total['Building'][$buildingId][$roomId][$computerId]))):?>
						  		<td class="centered">
						  			<?php echo gmdate('G', $total['Building'][$buildingId][$roomId][$computerId][0]).'h'.gmdate('i',$total['Building'][$buildingId][$roomId][$computerId][0]) ?>
						  		</td>
						  	<?php else:?>
						  		<td class="centered">
						  			<?php echo "0h00"?>
						  		</td>
						    <?php endif;?>
						</tr>
					<?php endforeach;?>
				<?php endforeach;?>
				<?php endif;?>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By type of connection')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Type of connection'] as $typeOfConnectionId => $typeOfConnection):?>
				<tr>
					<td>
						<?php echo $typeOfConnection?>
					</td>
					<?php foreach($statement as $stat):?>
						<?php if(isset($stat['Connection']) && isset($stat['Connection'][$typeOfConnectionId])):?>
							<td class="centered">
						  		<?php echo gmdate('G', $stat['Connection'][$typeOfConnectionId]).'h'.gmdate('i', $stat['Connection'][$typeOfConnectionId])?>
						  	</td>
						<?php else:?>
							<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
						<?php endif;?>
					<?php endforeach;?>
					<?php if(isset($total['Connection'][$typeOfConnectionId])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Connection'][$typeOfConnectionId]).'h'.gmdate('i', $total['Connection'][$typeOfConnectionId]) ?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					 <?php endif;?>
				</tr>
			<?php endforeach;?>
			<tr>
			  	<td class="importantLeft" colspan="<?php echo $numberOfActs->getTotal()+2 ?>" style="font-weight:bold">
			  		<br />
		        	<?php echo __('By way of awareness')?>
		        	<br /><br />
			  	</td>
			</tr>
			<?php foreach($columns['Awareness'] as $awarenessId => $awareness):?>
				<tr>
					<td>
						<?php echo __($awareness)?>
					</td>
					<?php foreach($statement as $stat):?>
						<?php if(isset($stat['Awareness']) && isset($stat['Awareness'][$awarenessId])):?>
							<td class="centered">
						  		<?php echo gmdate('G', $stat['Awareness'][$awarenessId]).'h'.gmdate('i', $stat['Awareness'][$awarenessId])?>
						  	</td>
						<?php else:?>
							<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
						<?php endif;?>
					<?php endforeach;?>
					<?php if(isset($total['Awareness'][$awarenessId])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Awareness'][$awarenessId]).'h'.gmdate('i', $total['Awareness'][$awarenessId])?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					 <?php endif;?>
				</tr>
			<?php endforeach;?>
		  </tbody>
	</table>
</div>

<div id="panelStat">
	<div class="info-message-white">
    	<span class="info-message-icon"></span>
		<em><?php echo __('Temporal statistics per gender, city and age range depending on the category.')?></em>
	</div>	
	<br /><br />
	<table class="statementTable">
		  <thead>
		 	 <tr>
		        <th>
		        	<div>
		        		<?php echo __('Details per categories') ?>
		        	</div>
		        </th>
		        <?php foreach($columns['Gender'] as $gender):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __($gender) ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        <?php foreach($columns['City'] as $city):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo $city ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        <?php foreach($columns['Age range'] as $ageRange):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __($ageRange) ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __("Total") ?>
		        		</div>
		        	</th>
		   	 </tr>
		   </thead>
		   <tbody>
		   <?php foreach($columns['Category'] as $id => $category):?>
				<tr>
					<td>
						<?php echo __($category)?>
					</td>
					<?php foreach($columns['Gender'] as $gender):?>
						<td class="centered">
							<?php if(isset($detailsPerCategory['Details per category']) && isset($detailsPerCategory['Details per category'][$id]) && isset($detailsPerCategory['Details per category'][$id][$gender])):?>
								<?php echo gmdate('G', $detailsPerCategory['Details per category'][$id][$gender]).'h'.gmdate('i', $detailsPerCategory['Details per category'][$id][$gender])?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php foreach($columns['City'] as $city):?>
						<td class="centered">
							<?php if(isset($detailsPerCategory['Details per category']) && isset($detailsPerCategory['Details per category'][$id]) && isset($detailsPerCategory['Details per category'][$id][$city])):?>
								<?php echo gmdate('G', $detailsPerCategory['Details per category'][$id][$city]).'h'.gmdate('i', $detailsPerCategory['Details per category'][$id][$city]) ?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php foreach($columns['Age range'] as $ageRange):?>
						<td class="centered">
							<?php if(isset($detailsPerCategory['Details per category']) && isset($detailsPerCategory['Details per category'][$id]) && isset($detailsPerCategory['Details per category'][$id][$ageRange])):?>
								<?php echo gmdate('G', $detailsPerCategory['Details per category'][$id][$ageRange]).'h'.gmdate('i', $detailsPerCategory['Details per category'][$id][$ageRange])?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php if(isset($total['Category'][$id])):?>
					  		<td class="centered">
					  			<?php echo gmdate('G', $total['Category'][$id]).'h'.gmdate('i', $total['Category'][$id]) ?>
					  		</td>
					  	<?php else:?>
					  		<td class="centered">
					  			<?php echo "0h00"?>
					  		</td>
					 <?php endif;?>
				</tr>
		   <?php endforeach;?>
		   </tbody>
	</table>
</div>

<div id="panelStat">
	<div class="info-message-white">
    	<span class="info-message-icon"></span>
		<em><?php echo __('Temporal statistics per gender, city and age range depending on the time slot.')?></em>
	</div>	
	<br /><br />
	<table class="statementTable">
		  <thead>
		 	 <tr>
		        <th>
		        	<div>
		        		<?php echo __('Details per time slots') ?>
		        	</div>
		        </th>
		        <?php foreach($columns['Gender'] as $gender):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __($gender) ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        <?php foreach($columns['City'] as $city):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo $city ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        <?php foreach($columns['Age range'] as $ageRange):?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __($ageRange) ?>
		        		</div>
		        	</th>
		        <?php endforeach;?>
		        	<th>
		        		<div style="width:150px">
		        			<?php echo __("Total") ?>
		        		</div>
		        	</th>
		   	   </tr>
		   </thead>
		   <tbody>
		   <?php foreach($columns['Day'] as $day):?>
				<tr>
					<td>
						<?php echo __($day)?>
					</td>
					<?php foreach($columns['Gender'] as $gender):?>
						<td class="centered">
							<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$gender])):?>
								<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$gender]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$gender])?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php foreach($columns['City'] as $city):?>
						<td class="centered">
							<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$city])):?>
								<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$city]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$city])?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php foreach($columns['Age range'] as $ageRange):?>
						<td class="centered">
							<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$ageRange])):?>
								<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$ageRange]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$ageRange])?>
							<?php else :?>
								<?php echo "0h00"?>
							<?php endif;?>
						</td>
					<?php endforeach;?>
					<?php if(isset($total[$day])):?>
						<td class="centered">
				  			<?php echo gmdate('G', $total[$day][0]).'h'.gmdate('i', $total[$day][0])?>
				  		</td>
				  	<?php else:?>
				  		<td class="centered">
					  		<?php echo "0h00"?>
					  	</td>
				  	<?php endif;?>
				</tr>
				<?php foreach($columns['Hour'] as $hour):?>
					<tr>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __($hour)?>
						</td>
						<?php foreach($columns['Gender'] as $gender):?>
							<td class="centered">
								<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour][$gender])):?>
									<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$gender]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$gender])?>
								<?php else :?>
									<?php echo "0h00"?>
								<?php endif;?>
							</td>
						<?php endforeach;?>
						<?php foreach($columns['City'] as $city):?>
							<td class="centered">
								<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour][$city])):?>
									<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$city]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$city])?>
								<?php else :?>
									<?php echo "0h00"?>
								<?php endif;?>
							</td>
						<?php endforeach;?>
						<?php foreach($columns['Age range'] as $ageRange):?>
							<td class="centered">
								<?php if(isset($detailsPerTimeSlot['Details per time slot']) && isset($detailsPerTimeSlot['Details per time slot'][$day]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour]) && isset($detailsPerTimeSlot['Details per time slot'][$day][$hour][$ageRange])):?>
									<?php echo gmdate('G', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$ageRange]).'h'.gmdate('i', $detailsPerTimeSlot['Details per time slot'][$day][$hour][$ageRange])?>
								<?php else :?>
									<?php echo "0h00"?>
								<?php endif;?>
							</td>
						<?php endforeach;?>
						<?php if(isset($total[$day]) && isset($total[$day][$hour])):?>
							<td class="centered">
					  			<?php echo gmdate('G', $total[$day][$hour]).'h'.gmdate('i', $total[$day][$hour])?>
					  		</td>
				  		<?php else:?>
					  		<td class="centered">
						  		<?php echo "0h00"?>
						  	</td>
			  			<?php endif;?>
					</tr>
				<?php endforeach;?>
		   <?php endforeach;?>
		   </tbody>
	</table>
</div>