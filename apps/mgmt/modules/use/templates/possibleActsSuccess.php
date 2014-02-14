
<script type="text/javascript">

$(document).ready(function() {
	$("#actsTab tbody tr td[class='selectable']").click(function(){
		var actTypeId;
		
		$("#actsTab tbody tr td").removeClass("selectedTd");
		$("#actsTab tbody tr td").addClass("blank");
		
		$(this).parent().children("td").addClass("selectedTd");
		var actId=$(this).parent().children("td[id='actId']").html();
		actId = actId.replace(/(^\s*)|(\s*$)/g,"");
		
		if (actId==="accountTransaction"){
			//alert("Account Transaction");
			actTypeId=5;
			//alert("Id Type de l'acte:"+actTypeId);
			//alert(users[0][4]);
		}
		else{
			//alert("Id de l'acte:"+actId);
			actTypeId=$(this).parent().children("td[id='actTypeId']").html();
			actTypeId = actTypeId.replace(/(^\s*)|(\s*$)/g,"");
			//alert("Id Type de l'acte:"+actTypeId);
			//selectAct(actId);
		}
		/*Array which links an actTypeId (the index) to an ImputationType (the value)
		Returns 1 if it is an Account Transaction*/
		
		 var correspondence=["0", "5", "4", "3", "2", "1"];

		usersId = new Array();
		for(var i=0; i<users.length;i++){
			usersId[i]=users[i][4];
		}
		
		//alert("actId:"+actId+"  actPublicCategory:"+selectedCategoryId+"  ImputationType:"+correspondence[actTypeId]);

		$(".panel[id='form_input']").load('<?php echo url_for('use/newImputation') ?>', { type_of_imputation: correspondence[actTypeId] ,act_id: actId, users_id : usersId, act_public_category_id: selectedCategoryId},
				function(data) {document.location.href='#form_input';}
			,"json");
		});

	$("#actsTab tbody tr").hover(function(){
		$(this).children("td").addClass("selectableHover");
	 },function(){
		 $(this).children("td").removeClass("selectableHover");
	 });
});

</script>


<h1><?php echo __('Act selection')?></h1>
	  	
<table id="actsTab" class="centered_tab noColumnGap">
	<?php foreach ($actTypes as $actType): ?>
	  <thead>
	    <tr>
	      <th class="actSelection"><?php echo __($actType->getDesignation());?></th>
	      <th class="actSelection" style="width:60px;"> </th>
	      <th class="hiddenCell"> actId </th>	
	      <th class="hiddenCell"> actTypeId </th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php if(isset($possibleActs[$actType->getId()])):?>
			<?php foreach($possibleActs[$actType->getId()] as $act):?>
				<tr>
				    <td class="selectable">
				    	<?php echo $act[0];?>
				    </td>
					<td style="padding-left:3px">
						<?php 
						if ($act[1]!=0){
							echo $act[1];
					    	echo $defaultCurrency;
						}
						else{
							echo __('Free');
						}
						?>
					</td>
					<td class="hiddenCell" id="actId">
						<?php echo $act[2];?>
					</td>
					<td class="hiddenCell" id="actTypeId">
						<?php echo $act[3];?>
					</td>
				</tr>
	    	<?php endforeach;?>
	    <?php else:?>
	    	<tr>
	    		<td>
	    			<?php echo __('No predefined acts')?>
	    		</td>
	    		<td></td>
	    	</tr>
	    <?php endif;?>
	  </tbody>
	<?php endforeach; ?>
	
	<!-- Account Transaction appears if only one user is selected-->
	<?php if($multiUsers != 1):?>
	<thead class="accountTransaction">
	    <tr >
	      <th class="actSelection"><?php echo __('Account Transaction');?></th>	
	     <th class="actSelection" style="width:60px;"></th>
	     <th class="hiddenCell"> actId </th>
	    </tr>
	</thead>
	<tbody class="accountTransaction">
	  	<tr>
			<td class="selectable">
				<?php echo __('Modify the balance of an account');?>
			</td>
			<td>
	    	</td>
	    	<td class="hiddenCell" id="actId">
	    		accountTransaction
	    	</td>
		</tr>
	</tbody>
	<?php endif;?>
</table>

<div class="panel" id="form_input" >

	
</div>

