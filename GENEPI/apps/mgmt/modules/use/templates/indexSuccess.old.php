<?php slot('title', sprintf('GENEPI - '.__('Uses')))?>

<head>
  <script type="text/javascript">

	/*Global variables*/
  	var users = new Array();
  	var usersToAddDatatable;
  	var usersDatatable;
  	var selectedCategoryId;

  /*-------------------------------------------- Events management------------------------------------------------------*/
$(document).ready(function() {

	$("#usersTab_filter").live('keydown, keyup', function() {
		$('table tbody tr td[class="dataTables_empty"]').attr('colspan',5);
	});

	$("#users_to_add_filter").live('keydown, keyup', function() {
		$('table tbody tr td[class="dataTables_empty"]').attr('colspan',4);
	});

	/*
	This code binds an event on the click on an user name in the usersTab table. It displays information about him.
	*/
	$('#usersTab tbody tr td:has(a[class=userInfo])').live('click', function () {

		var rowNumber = usersDatatable.fnGetPosition(this);
		var data = usersDatatable.fnGetData( rowNumber[0] );
		var userId = data[4];

		$("#dialog").load('<?php echo url_for('user/AjaxUserInfo') ?>', { id: userId, okOnly: 1},
				function(data) {
			  	  $( "#dialog" ).dialog( {
					width: 600,
					close: true,
					resizable: false,
					modal: true,
					draggable: false,
					buttons: {
						"Ok": function() { $(this).dialog("close"); },
						"<?php echo __('Choisir') ?>" : function(){
							$(this).dialog("close");
							directSelection(userId);
							}
					}
				} );
			},"json")
	});

	$('#users_to_add tbody tr td:has(a[class=userInfo])').live('click', function () {

		var rowNumber = usersToAddDatatable.fnGetPosition(this);
		var data = usersToAddDatatable.fnGetData( rowNumber[0] );
		var userId = data[4];

		$("#dialog").load('<?php echo url_for('user/AjaxUserInfo') ?>', { id: userId, okOnly: 1},
				function(data) {
			  	  $( "#dialog" ).dialog( {
					width: 600,
					close: true,
					resizable: false,
					modal: true,
					draggable: false,
					buttons: {
						"Ok": function() { $(this).dialog("close"); }
					}
				} );
			},"json")
	});

	/*
	Actions on a quick select button
	*/
	$('#usersTab tbody tr td:has(a input[name=quickSelection])').live('click', function () {
		var rowNumber = usersDatatable.fnGetPosition(this);
		var data = usersDatatable.fnGetData( rowNumber[0]);
		var userId = data[4];
		quickSelect(rowNumber[0],userId);
	});

		usersDatatable = $("#usersTab").dataTable({
			"aoColumns": [

			  			{ "bSortable": false },
          				 null,
          				 null,
          				 null,
          				{ "bVisible": false },
          				{ "bVisible": false },
          				{ "bSortable": false }
          				 ],
          	"fnInitComplete": function(){
				$('table tbody tr td[class="dataTables_empty"]').attr('colspan',5);
			},
			"sPaginationType": "full_numbers",
			"bAutoWidth": false,
	      	"iDisplayLength": <?php /* KYXAR 0003 - 30/06/2011 */ echo $defaultLength; ?>,
	      	"oLanguage": {
	    		"sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
	    		}
		} );

		usersToAddDatatable=$("#users_to_add").dataTable({
			"aoColumns": [
			  			{ "bSortable": false },
          				 null,
          				 null,
          				 null,
         				{ "bVisible": false },
         				{ "bVisible": false },
          				{ "bVisible": false }
          				 ],
          	"fnInitComplete": function(){
				$('table tbody tr td[class="dataTables_empty"]').attr('colspan',5);
			},
          	"bPaginate": false,
			"sPaginationType": "two_button",
			"bAutoWidth": false,
	      	"oLanguage": {
			"sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>" +"_2",
	    		},
	    		"sDom": '<"top"if>'
		} );

	/*
		This code binds an event on the click on the checkbox located in the <th> elements in this page.
	*/
	$("#usersTab th:has(input[type=checkbox])").click(function(){
		toggleCheckAll("usersTab",$("#usersTab th input[type=checkbox]").attr("checked"));
	});

	$("#usersToAdd th:has(input[type=checkbox])").click(function(){
		toggleCheckAll("usersToAdd",$("#usersToAdd th input[type=checkbox]").attr("checked"));
	});

	/*
		This code binds an event on the click on the 'add' button.
		It triggers a functions that remove an entry from the 'users' list and move it to the corresponding
		'to_add' list.
	*/
	$("#users input[name='add'] ").click(function(){
		moveFromTo("usersTab",usersDatatable,"users_to_add",usersToAddDatatable);
		hidePanels();
	});


	$("#users input[name='del'] ").click(function(){
		moveFromTo("users_to_add",usersToAddDatatable,"usersTab",usersDatatable);
		hidePanels();
	});

	/*
	Manage the behaviour of the Public Category Tab
	*/
	$("#publicCategoriesTab tbody tr td").click(function(){
		$("#publicCategoriesTab tbody tr td").removeClass("selectedTd");
		$("#publicCategoriesTab tbody tr td").addClass("blank");
		$(this).addClass("selectedTd");
		var categoryId=$(this).parent().children("td[id='categoryId']").html();
		selectCategory(categoryId);
	});

	/*
	Actions on validation of the users list
	*/
	$("[name='usersValidation'] ").click(function(){
		validateUsersList();
	});

	/*
	Initialize view
	*/
	 hidePanels();
	 $("#usersToAdd").hide();
	 $("[name=del]").hide();
	 $("[name=usersValidation]").hide();
	 toggleCheckAll("usersTab",false);
	 toggleCheckAll("users_to_add",false);

	 /*
		Actions on a direct user selection
	*/
	directSelection(<?php echo $userId ?>);

  });

	  /*-------------------------------------------- Functions------------------------------------------------------*/


    /*
    This function hides all panels except the users selection panel
    */

    function hidePanels(){
    	 $("#publicCategory").hide();
    	 $("#act").hide();
	  }


   /*
	  This function toggle the "checked" attribute value for each table of the #list div
	*/
	function toggleCheckAll(id, check){
		$("#" + id +" input[type=checkbox]").each(function(){
			$(this).attr("checked", check);
		});
	}

	  /*
		This function remove entries checked from the table specified by the id "idFrom" and the datatable "dataTableFrom" . It moves this entry in the
		table specified by the id "idTo" and the datatable "dataTableTo".
	*/
	function moveFromTo(idFrom,dataTableFrom,idTo,dataTableTo){

		$("#" + idFrom + " tbody tr:has(input[type=checkbox]:checked)").each(function(){
			var rowNumber=dataTableFrom.fnGetPosition( this );
			data=dataTableFrom.fnGetData( rowNumber );
			data[0]="<div align=center><input  align=center type=\"checkbox\"></input></div>";
			dataTableFrom.fnDeleteRow( rowNumber,null,true );
			dataTableTo.fnAddData( data,true  );
		});
		toggleCheckAll(idFrom,false);

		hideEmptyDataTable();
	}

	function validateUsersList(){
		users = usersToAddDatatable.fnGetData();
		if(users.length!=0){
		$("#publicCategory").fadeIn('slow');

			/*In the case of an automatic choice of the public category*/
			if(samePublicCategory()){
				/*selection of the public category in the Public Category Tab*/
				$("#publicCategory tbody tr td[id='categoryId']").each(function(){
					if($(this).html()===users[0][5]){
						$(this).parent().children("td[id='categoryDesignation']").addClass("selectedTd");
						}
					else{
						$(this).parent().children("td[id='categoryDesignation']").removeClass("selectedTd");
						$(this).parent().children("td[id='categoryDesignation']").addClass("blank");
						}
				});
				selectCategory(users[0][5]);
			}
			else
			{
				$("#publicCategory tbody tr td[id='categoryId']").each(function(){
					$(this).parent().children("td[id='categoryDesignation']").removeClass("selectedTd");
					$(this).parent().children("td[id='categoryDesignation']").addClass("blank");
				});
				$("#act").hide();
				document.location.href='#publicCategory';
			}
		}
	}


	/*
	This function move entry selected by the button "quick select" from the 'usersTab' table to the
	'users_to_add' table. The parameter is the number of the row.
	*/
	function quickSelect(rowNumber,userId){

		/*Move all entries from users_to_add table to 'usersTab' table*/
		var data=usersDatatable.fnGetData(rowNumber);
		var allData = usersToAddDatatable.fnGetData();
		usersToAddDatatable.fnClearTable(true);
		for (var i=0; i< allData.length; i++){
			if(allData[i]!=null){
				usersDatatable.fnAddData(allData[i], true);
			}
		}
	    /* Move only the row indicated by the parameter*/
		data[0]="<div align=center><input  align=center type=\"checkbox\"></input></div>";
		usersDatatable.fnDeleteRow( rowNumber,null,true );
		usersToAddDatatable.fnAddData( data,true);

		toggleCheckAll("usersTab",false);
		hideEmptyDataTable();
		validateUsersList();
	}

	/*
	This function select automatically an user (as a quick selection) defined by his Id.
	*/
	function directSelection(userId){
		if(userId!=null){

			var allData = usersDatatable.fnGetData();
			for(var i=0; i<allData.length; i++){
				if ((allData[i]!=null) && (allData[i][4]==userId)){
					quickSelect(i,userId);
				}
			}
		}
	}


	function hideEmptyDataTable(){
		var allData = usersToAddDatatable.fnGetData();

		/*Array "allData" is Empty?*/
		if(isAnEmptyArray (allData)){
			$("#usersToAdd").hide();
			$("[name=del]").hide();
			$("[name=usersValidation]").hide();
			}
		else{
			$("#usersToAdd").fadeIn('slow');
			$("[name=del]").fadeIn('slow');
			$("[name=usersValidation]").fadeIn('slow');
		}
		$('table tbody tr td[class="dataTables_empty"]').attr('colspan',4);
	}


	function isAnEmptyArray (array) {
		for (var i=0; i<array.length; i++)
		{
		   if(array[i]!=null){
			   return false;
		   }
		}
		return true;
	}

	function samePublicCategory(){

		var different=false;

		/*Clean the array by deleting empty rows*/
		var j=0;
		var usersclean=new Array();
		for(var i=0; i < users.length; i++)
		{
			if(users[i]!=null){
				usersclean[j]=users[i];
				j++;
			}
		}
		users=new Array();
		users=usersclean;

		/*verify if all user have the same public category*/
		var publicCategory=users[0][5];
		if(users[0][5]==""){return false;}

		for(var i=1; i < users.length; i++)
		{
			//if one user has no public category or one user has not the same public category than the first user
			if( ((users[i][5]=="")||(publicCategory!=users[i][5]))){
				return false;
			}
		}
		return true;
	}

	function selectCategory(categoryId){
		$("#act").fadeIn('slow');
		selectedCategoryId=categoryId;
		displayPossibleActs(categoryId);

	}

	function displayPossibleActs(categoryId)
	{
		$(".panel[id='act']").load('<?php echo url_for('use/AjaxPossibleActs') ?>', { id: categoryId , numberUsers :users.length},
				function(data) {document.location.href='#act';}
			,"json")

	}

  </script>
</head>

<?php include_partial('global/messages')?>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3 class = "selected"><?php echo __('Impute an act')?></h3>
	<h3><a href="<?php echo url_for('use/history') ?>"><?php echo __('View history')?></a></h3>
<?php end_slot(); ?>

<div id="dialog" title="<?php echo __("User info")?>" style="display:none"></div>

<div class="panel">
    <div id="users">
		<h1><?php echo __('Users selection')?></h1>
		<table id="usersTab" class="largeTable">
		  <thead>
		    <tr class="sortableTable">

		      <th class="greyCell" style="width:50px"><input type="checkbox"></input></th>
		      <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
		      <th style="width:50px" ><?php echo __('Age')?></th>
		      <th><?php echo __('Public category')?></th>
		      <th>userId</th>
		      <th>categoryId</th>
		      <th style="width:100px" class="greyCell"><?php echo __('Quick select')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($users as $user): ?>
		    <tr>
		      <td align=center><input type="checkbox"></input></td>
		      <td ><a class="userInfo"><?php /* KYXAR 0004 - 30/06/2011 */ echo $user->getSurname() ?> <?php echo $user->getName() ?></a></td>
		      <td><?php echo $user->getAge() ?></td>
		      <td><?php echo $user->getActPublicCategory() ?></td>
		      <td class="userId"><?php echo $user->getId() ?></td>
			  <td><?php echo $user->getActPublicCategoryId() ?></td>
			  <td><a><input name="quickSelection" type="button" class="thinButton"  value="<?php echo __('select')?>"></a></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<table class="centerElement">
			<thead>
				<tr>
					<td style="text-align: center;">
						<input type="button" name="add" value="<?php echo __('Add')?>">
						<input  type="button" name="del" value="<?php echo __('Delete')?>">
					</td>
				</tr>
			</thead>
		</table>
		<br />
		<div id="usersToAdd">
			<table id="users_to_add" class="largeTable">
				  <thead>
					    <tr class="sortableTable">
					      <th class="greyCell" style="width:50px"><input type="checkbox"></input></th>
					      <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
					      <th style="width:50px" ><?php echo __('Age')?></th>
					      <th><?php echo __('Public category')?></th>
					      <th>userId</th>
		    			  <th>categoryId</th>
		    			  <th>Quickselect</th>
					    </tr>
				  </thead>
				  <tbody></tbody>
			</table>
		</div>
	</div>

	<br />
		<a href="#publicCategory"><input type="button" style="float:right" name="usersValidation" value="<?php echo __('Ok')?>"></a>
	<br /><br /><br />
</div>

<div class="panel" id="publicCategory" >
	<h1><?php echo __('Public category selection')?></h1>
	<table id="publicCategoriesTab" class="centered_tab">
		  <thead>
		    <tr>
		      <th><?php echo __('Public categories'); ?></th>
		      <th style="display:none">id</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($publicCategories as $publicCategory): ?>
		    <tr>
		      <td id="categoryDesignation" class="selectable"><?php echo $publicCategory->getDesignation(); ?></td>
			  <td id="categoryId" style="display:none"><?php echo $publicCategory->getId(); ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
	</table>
	<br />
</div>

<div class="panel" id="act" >


</div>