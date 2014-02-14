<?php slot('title', sprintf('GENEPI - '.__('Parameters')))?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('act/index') ?>"><?php echo __('Manage acts')?></a></h3>
    <h3><a href="<?php /* KYXAR 0007 - 01/07/2011 */ echo url_for('configuration/parameters#lists') ?>"><?php echo __('Manage public categories')?></a></h3>
    <h3><a href="<?php echo url_for('act_price/index') ?>"><?php echo __('Manage prices')?></a></h3>
    <h3><a href="<?php echo url_for('moderator/index') ?>"><?php echo __('Manage moderators')?></a></h3>
    <h3><a href="<?php echo url_for('struct/index') ?>"><?php echo __('Manage structure')?></a></h3>
    <h3 class="selected"><?php echo __('Manage parameters')?></h3>
    <h3><a href="<?php echo url_for('configuration/plugins') ?>"><?php echo __('Manage plugins')?></a></h3>
    <h3><a href="<?php echo url_for('configuration/export') ?>"><?php echo __('Export logs')?></a></h3>
    <h3><a href="<?php echo url_for('dashboard/index') ?>"><?php echo __('Back to homepage')?></a></h3>
<?php end_slot(); ?>


<head>

    <script type="text/javascript">
        var tmp_footer_content = "<?php echo __('New')?>...";
        /*
            This function initialize the default selected value in the dbms select element in this page.
        */
        function initSelect(){
            $("select[name='dbms'] option").get(<?php echo $values['dbms'];?> - 1).selected = true;

            $("select[name='default_room'] option[value='<?php echo $values['default_room'];?>']").selected = true;

            $("select[name='default_method_of_payment'] option[value='<?php echo $values['default_method_of_payment'];?>']").selected = true;

            $("select[name='default_computer'] option[value='<?php echo $values['default_computer'];?>']").selected = true;

            $("select[name='default_language'] option[value='<?php echo $values['default_language'];?>']").selected = true;
        }


        /*
        This function add the entry entered by the user in the list specified by its id.
        */

        function addInto(id){

            var val = $("#" + id + " tfoot input[type=text]").val();

            if((tmp_footer_content != '<?php echo __('New')?>...') && tmp_footer_content != ''){

                if(id == 'Unity'){

                    $("#" + id + " tbody").append(
                            "<tr style=\"height:40px;\">"+
                            "<td align=center><input type=checkbox></input></td>"+
                            "<td align=center><input type=\"text\" size=\"3\" style=\"text-align: center; border: none;\"></td>" +
                            "<td align=center><input type=\"text\" size=\"3\" style=\"text-align: center; border: none;\"></input></td>" +
                            "<td align=right>"+ tmp_footer_content +"</td></tr>"

                    );

                }else if(id == 'ComputerOs'){

                    $("#" + id + " tbody").append(
                            "<tr style=\"height:40px;\">"+
                            "<td align=center><input type=checkbox></input></td>"+
                            "<td align=center><input type=\"text\" size=\"3\" style=\"text-align: center; border: none;\"></td>"+
                            "<td align=center></td></tr>");
                    $("#" + id + " tbody tr:last td:last").append($("#os_family_form").html());
                    $("#" + id + " tbody tr:last").append("<td align=right>" + tmp_footer_content + "</td>");

                }else{

                    $("#" + id + " tbody").append(
                            "<tr style=\"height:40px;\">"+
                            "<td align=center><input type=checkbox></input></td>"+
                            "<td align=center><input type=\"text\" size=\"3\" style=\"text-align: center; border: none;\"></td>" +
                            "<td align=right>" + tmp_footer_content + "</td></tr>"
                    );

                }


                $("#" + id).parents("table").children("tfoot").children("tr:first").children("td:last").children("div").children("div").show('slow');
                $("#" + id + " tfoot input[type=text]").val('<?php echo __('New')?>...');

                initRows($("#" + id).children("tbody").get());
            }
        }

        /*
            This function remove an entry from the list specified by the id. It moves this entry in the
            corresponding 'to_delete' table.
        */
        function deleteFrom(id){

            var i = 0;

            $("#" + id + " tbody tr:has(input[type=checkbox]:checked)").each(function(i){

                if(i == 0){
                    $("td:has(table[id='" + id + "_to_delete'])").fadeIn('slow');

                    $("td:has(div[id='" + id + "_to_delete_info_delete'])").fadeIn('slow');
                }

                $(this).fadeOut('slow');

                $("#" + id + "_to_delete tbody").append("<tr style=\"height:40px;\">" + this.innerHTML + "</tr>");

                $(this).remove();

                if(i == 0){
                    $("#" + id + " th input[type=checkbox]").attr("checked", false);
                    $("#" + id).parents("table").children("tfoot").children("tr:first").children("td:last").children("div").children("div").show('slow');
                }

                initRows($("#" + id).children("tbody").get());
                initRows($("#" + id + "_to_delete").children("tbody").get());
            });
        }


        /*
            This function cancel the deletion of an entry removed by the user in the list specified by its id.
        */
        function cancelDelete(id){

            var i = 0;

            $("#" + id + " tbody tr:has(input[type=checkbox]:checked)").each(function(i){

                if(i == 0){
                    id_len = id.length;
                    id_to_insert = id.substr(0, id_len - 10);
                }


                $(this).fadeOut('slow');
                $("#" + id_to_insert + " tbody").append("<tr style=\"height:40px;\">" + this.innerHTML + "</tr>");
                $(this).remove();


                if(i == 0){
                    $("#" + id + " th input[type=checkbox]").attr("checked", false);
                }

                if($("#" + id + " tbody").val() == ''){
                    $("td:has(table[id='"+ id +"'])").fadeOut('slow');
                    $("td:has(div[id='" + id + "_info_delete'])").fadeOut('slow');
                }

                initRows($("#" + id_to_insert).children("tbody").get());
                initRows($("#" + id).children("tbody").get());
            });
        }


        /*
            This function toggle the "checked" attribute value for each table of the #list div
        */
        function toggleCheckAll(id, check){

            $("#" + id + " tbody input[type=checkbox]").each(function(){
                $(this).attr("checked", check);
            });
        }

        function initRows(body){

            $(body).children("tr:even").addClass("even");

            $(body).children("tr").each(function(){

                if($(this).hasClass("even")){

                    $(this).children("td:has(input[type=text])").children("input[type=text]").hover(function () {

                        $(this).css({"background" : "#d3d3d3"});

                      }, function () {

                          $(this).css({"background" : "#f2f2f2"});

                      });
                }
            });
        }



        /*
            This function initialize the events for this page. It must be called after document.ready or
            after an ajax request.
        */
        function initPage(){

            $("#tabs").tabs();

            initSelect();

            $( "#dialog_update" ).dialog( {
                width: 620,
                close: null,
                resizable: false,
                modal: true ,
            } );

            $("#dialog_update_def").dialog({
                width: 470,
                close: null,
                resizable: false,
                modal: true ,
                buttons: {
                    Ok: function() {
                        $(this).dialog('close');
                    }
                }

            });

            $("select[name='dbms']").change(function(){
                var dbms = $("select[name='dbms'] option:selected").val();
                if(dbms == "mysql"){
                    $("input[name='srv_port']").val('<?php echo $values['def_mysql_port']?>');
                }else if(dbms == "pgsql"){
                    $("input[name='srv_port']").val('<?php echo $values['def_pgsql_port']?>');
                }
            });

            $("input:button[name='raz']").click(function(){
                $("input[name='ip_address']").val('<?php echo $values['ip_address']?>');
                $("input[name='srv_port']").val('<?php echo $values['srv_port']?>');
                $("input[name='db_name']").val('<?php echo $values['db_name']?>');
                $("input[name='db_user_name']").val('<?php echo $values['db_user_name']?>');
                $("input[name='db_password']").val('<?php echo $values['db_password']?>');

                initSelect();
            });

            /*
                This code binds an event on the click on the checkbox located in the <th> elements in this page.
            */
            $("#lists table:not(:has(table)) th input[type=checkbox]").click(function(){
                toggleCheckAll($(this).parents("#lists table:not(:has(table))").attr("id"), $(this).attr("checked"));
              });


            /*
                This code binds an event on the click on each 'Delete' button of #lists table of this page.
                It triggers a functions that remove an entry from the list and move it to the corresponding
                'to_delete' list.
            */
            $("#lists table:not(:has(table)):has(input[type=button]) tfoot input[name='del']").click(function(){
                deleteFrom($(this).parents("#lists table:not(:has(table)):has(input[type=button])").attr("id"));

            });

            /*
                This code binds an event on the click on each 'Cancel' button of #lists 'to_delete' table of this page.
                It triggers a functions that cancel the remove of a <tr> element from the original list.
            */
            $("#lists table:not(:has(table)):has(button) tfoot button[name='cancel']").click(function(){
                cancelDelete($(this).parents("#lists table:not(:has(table)):has(button)").attr("id"));
            });


            /*
                This code binds an event on the click on each 'Add' button of #lists table of this page.
                It triggers a functions that append a <tr> element in the list.
            */
            $("#lists table:not(:has(table)):has(input[type=button]) tfoot input[name='add']").click(function(){
                addInto($(this).parents("#lists table:not(:has(table)):has(input[type=button])").attr("id"));
                tmp_footer_content = "<?php echo __('New')?>...";
            });


            /*
                This code binds an event on the focus of the input of type text located in the footers of the table
                in this page.
            */
            $("tfoot input[type=text]").focus(function(){
                    this.value = "";
            });

            /*
                This code binds an event on the blur of the input of type text located in the footers of the table
                in this page.
            */
            $("tfoot input[type=text]").blur(function(){
                tmp_footer_content = this.value;
                this.value = "<?php echo __('New')?>...";
            });


            /*
                This code places an animation on the click on an anchor of the page.
            */
            $('a[href*=#]').not('a[href=#]').bind('click', function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var $target = $(this.hash);
                    $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
                    if ($target.length) {
                        var targetOffset = $target.offset().top;
                        $('html,body').animate({scrollTop: targetOffset}, "normal");
                        return false;
                    }
                }
            });


            $("#anchors a").each(function(){
                $(this).button();
            });

            $("h1 a").each(function(){
                $(this).css('font-size', '11px');
                $(this).button({
                    icons: {
                        primary: "ui-icon-triangle-1-n"
                    }
                });
            });

            document.getElementById("javascript-support").innerHTML = "<?php echo __('enabled')?>";

            $('#lists table table tbody').each(function() {
                initRows($(this));
            });
        }

        /*
            This code defines what to do when the document is ready.
        */
        $(document).ready(function() {
            initPage();

            /*
                This code binds an event on the click on each 'Ok' button of #lists div of this page.
                It triggers an ajax request for each list.
            */
            $("#lists input[name='update']").click(function(){

                var id_table = $(this).parents("tfoot").parent("table").children("tbody").children("tr").children("td:first").children("table").attr("id");
                    var order_tmp;
                    var data = new Array();

                        data["remove"] = new Array();

                        data["disable"] = new Array();

                        data["add_designation"] = new Array();
                        data["add_family_id"] = new Array();
                        data["add_short_designation"] = new Array();
                        data["add_order"] = new Array();

                        data["table_to_select"] = id_table;

                        data["update_short_designation"] = new Array();
                        data["update_id"] = new Array();
                        data["update_order"] = new Array();

                    //Get the order values for the second ajax request:
                    $("#" + id_table + " tbody tr").each(function(){

                        order_tmp = $(this).children("td:has(input[type=text]):first").children("input").val();

                        if(id_table == "<?php echo PredefinedLists::UNITY?>"){

                            data["update_id"].push($(this).children("td:has(span):first").children("span:first").html());
                            data["update_order"].push(order_tmp);
                            data["update_short_designation"].push($(this).children("td:has(input[type=text]):last").children("input").val());

                        }else{
                            data["update_id"].push($(this).children("td:has(span):first").children("span:first").html());
                            data["update_order"].push(order_tmp);
                        }
                    });

                    //Get the entries to delete:
                    $("#" + id_table + "_to_delete tbody tr td:last-child span").each(function(i){
                        if(id_table == "<?php echo PredefinedLists::UNITY?>"){
                            data["disable"].push(this.innerHTML);
                        }else{
                            data["remove"].push(this.innerHTML);
                        }
                    });

                    //Get the entries to add:
                    $("#" + id_table + " tbody tr td:last-child:not(:has(span))").each(function(i){
                        //Get the designation:
                        data["add_designation"].push($(this).html());

                        if(id_table == "<?php echo PredefinedLists::UNITY?>"){

                            //For the 'Unity' table, get the short designation:
                            data["add_short_designation"].push($(this).prev().children("input").val());
                            //and the order value:
                            data["add_order"].push($(this).prev().prev().children("input").val());

                        }else if(id_table == "<?php echo PredefinedLists::COMPUTER_OS?>"){

                            data["add_family_id"].push($(this).prev().children("select").val());
                            data["add_order"].push($(this).prev().prev().children("input").val());

                        }else{

                            //For all the others table, get the order value only:
                            data["add_order"].push($(this).prev().children("input").val());

                        }

                    });


                    //Execute the ajax request and loads the new html content:
                    $("#" + id_table + " tbody").load(
                        "<?php  echo url_for('configuration/updateLists')?>", {remove:data["remove"], add_designation:data["add_designation"], add_short_designation:data["add_short_designation"], add_order:data["add_order"], add_family_id:data["add_family_id"], disable:data["disable"], table: data["table_to_select"]},
                        function(){

                            //Empty the table of the "to_delete" table:
                            $("#" + id_table + "_to_delete tbody").empty();
                            //Make it disappear:
                            $("td:has(table[id='"+ id_table +"_to_delete'])").fadeOut('slow');
                            $("td:has(div[id='"+ id_table +"_to_delete_info_delete'])").fadeOut('slow');


                            $("#" + id_table + " tbody").load(
                                "<?php  echo url_for('configuration/updateOrders')?>", {update_id: data["update_id"], update_order: data["update_order"], update_short_designation:data["update_short_designation"], table: id_table},
                                function(){

                                    if(id_table == 'Unity'){
                                        $("#default_currency").parent("td").load(
                                                "<?php  echo url_for('configuration/refreshUnities')?>"
                                        );
                                    }
                                    initRows($("#" + id_table).children("tbody").get());
                                });
                        });

                $(this).parent().parent().prev().children("div").show('slow').fadeOut(2000);
                $(this).next().hide('slow');


            });

        });
  </script>
</head>

<div id="tabs">
    <ul>
        <li><a href="#def_val"><span><?php echo __('Default values')?></span></a></li>
        <li><a href="#lists"><span><?php echo __('Lists')?></span></a></li>
        <li><a href="#system"><span><?php echo __('System')?></span></a></li>
    </ul>

    <!-- ------------------------------------  DEFAULTS VALUES  -------------------------------------------- -->
    <div id="def_val">
        <h1><?php echo __('Default Parameters Setting')?></h1>
        <div>
            <div class="info-message-white">
                <span class="info-message-icon"></span>
                <em><?php echo __('Parameters setting in this page will only affect your own account.')?><br></em>
            </div>
            <div style="width:auto; float:left"></div>
        </div>
        <br style="clear:left">
        <?php echo $def_form->renderGlobalErrors()?>
        <form method="post" action="<?php echo url_for('configuration/updateDefaultParameters')?>">
            <table class="formTable">
            <tr><th style="text-align: center;"><label><?php echo __('Imputations')?></label></th>
                <td><table class="formTable">
                    <tr>
                        <th><label><?php echo $def_form['default_building']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_building']->renderError()?>
                            <?php echo $def_form['default_building']?>
                        </td>

                        <td rowspan = 4>
                            <div class="info-message-white">
                                <span class="info-message-icon"></span>
                                <em><?php echo __('Theses parameters will be the ones selected by default during an imputation.')?><br></em>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_room']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_room']->renderError()?>
                            <?php echo $def_form['default_room']?>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_method_of_payment']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_method_of_payment']->renderError()?>
                            <?php echo $def_form['default_method_of_payment']?>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_computer']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_computer']->renderError()?>
                            <?php echo $def_form['default_computer']?>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_num_to_display']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_num_to_display']->renderError()?>
                            <?php echo $def_form['default_num_to_display']?>
                        </td>

                        <td>
                            <div class="info-message-white">
                                <span class="info-message-icon"></span>
                                <em><?php echo __('Set the default number of entries to display in a list (users, acts, ...).')?><br></em>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_follow_moderator']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_follow_moderator']->renderError()?>
                            <?php echo $def_form['default_follow_moderator']?>
                        </td>

                        <td>
                            <div class="info-message-white">
                                <span class="info-message-icon"></span>
                                <em><?php echo __('Set whether the moderator actions must be memorized.')?><br></em>
                            </div>
                        </td>
                    </tr>
                </table></td>
            </tr>
            <tr>
                <th style="text-align: center;"><label><?php echo __('Calendar')?></label></th>
                <td>
                    <table class="formTable">
                        <tr>
                            <th><label><?php echo $def_form['reservation_min_time']->renderLabel(); ?></label></th>
                            <td>
                                <?php echo $def_form['reservation_min_time']->renderError(); ?>
                                <?php echo $def_form['reservation_min_time']; ?>
                            </td>
                            <td rowspan=2>
                                <div class="info-message-white">
                                    <span class="info-message-icon"></span>
                                    <em><?php echo __('Min and max time displayed in the calendar')?></em>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php echo $def_form['reservation_max_time']->renderLabel(); ?></label></th>
                            <td>
                                <?php echo $def_form['reservation_max_time']->renderError(); ?>
                                <?php echo $def_form['reservation_max_time']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><th style="text-align: center;"><label><?php echo __('Operation')?></label></th>
                <td><table class="formTable">
                    <tr>
                        <th><label><?php echo $def_form['default_language']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_language']->renderError()?>
                            <?php echo $def_form['default_language']?>
                        </td>
                        <td>
                            <div class="info-message-white">
                                <span class="info-message-icon"></span>
                                <em><?php echo __('Caution: Changing language will not translate the data in your database.')?><br></em>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['default_currency']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['default_currency']->renderError()?>
                            <?php echo $def_form['default_currency']?>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['def_mysql_port']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['def_mysql_port']->renderError()?>
                            <?php echo $def_form['def_mysql_port']?>
                        </td>
                        <td rowspan=2>
                            <div class="info-message-white">
                                <span class="info-message-icon"></span>
                                <em><?php echo __('The DBMS ports setting will not affect the operation of the application.')?><br>
                                    <?php echo __('It will only help while debugging.')?></em>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th><label><?php echo $def_form['def_pgsql_port']->renderLabel()?></label></th>
                        <td>
                            <?php echo $def_form['def_pgsql_port']->renderError()?>
                            <?php echo $def_form['def_pgsql_port']?>
                        </td>
                    </tr>
                </table></td>
            </tr>
            </table>

            </table>
            <?php echo $def_form->renderHiddenFields(); ?>
            <input type="submit" class="rightAlignement" value="<?php echo __('Save')?>">
        </form>
    </div>





    <!-- ------------------------------------  PREDEFINED LISTS  -------------------------------------------- -->
    <div id="lists">
        <div style="width:100%">
            <div class="info-message-white">
                <span class="info-message-icon"></span>
                <em><?php echo __('Caution: once a new value is inserted in a list, you will not be able to edit its designation.')?><br>
                <?php echo __('You can only edit its order, its short designation and add and delete entries.')?></em>
            </div>
            <div style="float:left width:auto"></div>
        </div>
        <br style="clear:left"><br><br>

        <div id="anchors" align=center >
            <?php foreach($tables as $table_name => $table_data): ?>
                <?php $table_anchor_string = '#'.$table_name.'_title';?>
                <a href="<?php echo $table_anchor_string?>"><?php echo __(PredefinedLists::getTableTitle($table_name))?></a>
            <?php endforeach;?>
        </div>



        <?php
            foreach($tables as $table_name => $table_data){
                if($table_name == PredefinedLists::UNITY){
                    include_partial('predefinedUnities', array('table_name' => PredefinedLists::UNITY, 'table_data' => $table_data, 'table_title' => PredefinedLists::getTableTitle(PredefinedLists::UNITY)) );
                }else if($table_name == PredefinedLists::COMPUTER_OS){
                    include_partial('predefinedOs', array('table_name' => PredefinedLists::COMPUTER_OS, 'table_data' => $table_data, 'table_title' => PredefinedLists::getTableTitle(PredefinedLists::COMPUTER_OS)) );
                }else{
                    include_partial('predefinedList', array('table_name' => $table_name, 'table_data' => $table_data, 'table_title' => PredefinedLists::getTableTitle($table_name)) );
                }
            }
        ?>
    </div>


    <!-- ----------------------------------  SYSTEM PARAMETERS  ------------------------------------------- -->
    <div id="system">

    <?php echo $form->renderGlobalErrors()?>
    <h1><?php echo __('System Parameters')?></h1>
    <form method="post" action="<?php echo url_for('configuration/updateSystemParameters')?>">
        <table class="formTable">
            <tr>
            <th style="text-align: center;"><label><?php echo __('Server')?></label></th>

            <td><table class="formTable">
                <tr valign=middle>

                    <th><label><?php echo $form['ip_address']->renderLabel()?>:</label></th>
                    <td>
                    <?php echo $form['ip_address']->renderError() ?>
                    <?php echo $form['ip_address']?>
                    </td>

                </tr>
                <tr>

                    <th><label><?php echo $form['srv_port']->renderLabel()?>:</label></th>
                    <td>
                    <?php echo $form['srv_port']->renderError() ?>
                    <?php echo $form['srv_port']?>
                    </td>

                </tr>
            </table></td>
            </tr>
            <tr>
                <th style="text-align: center;"><label><?php echo __('Database')?></label></th>

                <td><table class="formTable">
                    <tr valign=middle>

                        <th><label><?php echo $form['dbms']->renderLabel()?>:</label></th>
                        <td>
                            <?php echo $form['dbms']->renderError() ?>
                            <?php echo $form['dbms']?>
                        </td>

                    </tr>

                    <tr>

                        <th><label><?php echo $form['db_name']->renderLabel()?>:</label></th>
                        <td>
                        <?php echo $form['db_name']->renderError() ?>
                        <?php echo $form['db_name']?>
                        </td>

                    </tr>
                    <tr>

                        <th><label><?php echo $form['db_user_name']->renderLabel()?>:</label></th>
                        <td>
                        <?php echo $form['db_user_name']->renderError() ?>
                        <?php echo $form['db_user_name']?>
                        </td>

                    </tr>
                    <tr>

                        <th><label><?php echo $form['db_password']->renderLabel()?>:</label></th>
                        <td>
                        <?php echo $form['db_password']->renderError() ?>
                        <?php echo $form['db_password']?>
                        </td>

                    </tr>
                </table></td>
            </tr>
            
            
        </table>
        <br>
        <?php echo $form->renderHiddenFields(); ?>

        <input type="button" name="raz" value="<?php echo __('Saved parameters')?>">
        <input type="submit" class="rightAlignement" value="<?php echo __('Save')?>">
    </form>
    <br>
    <h1><?php echo __('System Informations')?></h1>
        <div class="panel">
            <h6><?php echo __('Server')?></h6>
            <?php echo __('Signature').' : '.getenv("SERVER_SOFTWARE"); ?>
        </div>
        <div class="panel">
        <h6><?php echo __('Database')?></h6>
        <?php echo __('DBMS').' :'?>
        <?php if($values['dbms'] == 1) : ?> <?php echo 'MySQL'?>
        <?php else : ?> <?php echo 'PostgreSQL'?>
        <?php endif; ?>

        </div>
        <div class="panel">
        <h6><?php echo __('Client')?></h6>
        <?php echo __('Browser').' : '.getenv("HTTP_USER_AGENT"); ?>
        <br />
        <?php $screenWidth = "<script>document.write(screen.width)</script>"; ?>
        <?php $screenHeight = "<script>document.write(screen.height)</script>"; ?>
        <?php echo __('Screen resolution').' : '.$screenWidth.'x'.$screenHeight; ?>

        </div>
        <div class="panel">
        <h6><?php echo __('JavaScript')?></h6>

        <?php echo __('JavaScript support').' : '?>
        <div id="javascript-support" style="display: inline;">
            <?php echo __('disabled')?>
        </div>
        </div>
    </div>
</div>


<?php if($update_system):?>
    <div id="dialog_update" title="<?php echo __('Restart is necessary')?>">

        <form method="post" action="<?php echo url_for('@homepage')?>">

            <p><?php echo __('The parameters values have been correctly updated')?>.</p>
            <p><?php echo __('You have to re-init the application to take the change into account:')?></p>

            <input type="submit" value="<?php echo __('Re-init the application')?>"></input>
        </form>
    </div>
<?php endif;?>


<?php if($update_default):?>
    <div id="dialog_update_def" title="<?php echo __('Update successful')?>">
            <p><?php echo __('The default parameters values have been correctly updated')?>.</p>
    </div>
<?php endif;?>


<div id="os_family_form" style="display:none">
    <?php echo $os_form['computer_os_family_id']?>
</div>
