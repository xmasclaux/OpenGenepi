<?php

/**
 * Copyright 2010 Pierre Boitel, Bastien Libersa, Paul Périé
 *
 * This file is part of GENEPI.
 *
 * GENEPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GENEPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GENEPI. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * configuration actions.
 *
 * @package    epi
 * @subpackage configuration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */


class configurationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request){
        $this->forward('act', 'index');
    }


    public function executePlugins(sfWebRequest $request){
        $this->Modules = $this->getContext()->get('Modules');
        $this->Kernel = $this->getContext()->get('Kernel');

        $this->missing_dep = $this->getContext()->get('DependenciesErrors');
        if(!empty($this->missing_dep)){
            $this->getUser()->setFlash('error', 'Required dependencies are missing. Go to the configuration menu to correct this issue.', false);
        }


        if($request->isMethod(sfRequest::POST)){
            $this->new = $this->getRequestParameter('module_name_to_add');
            $this->new_entry = $this->getRequestParameter('menu_entry');
            $this->delete = $this->getRequestParameter('module_name_to_delete');
            $this->delete_force = $this->getRequestParameter('module_name_to_delete_force');
        }else{
            $this->new = null;
            $this->new_entry = null;
            $this->delete = null;
            $this->delete_force = null;
        }

    }


    public function executeParameters(sfWebRequest $request){

        /*------------------------------ PREDEFINED LISTS---------------------------------------*/
        //List of tables to display:
        $this->tables = array_fill_keys(array(
            PredefinedLists::PUBLIC_CATEGORIES,
            PredefinedLists::UNITY,
            PredefinedLists::USER_AWARENESS,
            PredefinedLists::USER_SEG,
            PredefinedLists::COMPUTER_OS,
            PredefinedLists::COMPUTER_OS_FAMILY,
            PredefinedLists::METHOD_OF_PAYMENT), null);

        //Get all the tables to display:
        $this->tables = PredefinedLists::getData($this->tables);

        //Create a computer os form in order to have the select for the computer os family when adding a computer os:
        $this->os_form = new ComputerOsForm();

        /*---------------------------------- PARAMETERS------------------------------------------*/
        //Get the prefix of the current user:
        ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
        //Get the parameters from xml file:
        $this->values = ParametersConfiguration::getAll();
        (!$this->values['default_follow_moderator']) ? $this->values['default_follow_moderator'] = false : $this->values['default_follow_moderator'] = true;
        //Indicate to the template if the system parameters have been updated (not by default):
        $this->update_system = $request->getAttribute('update_system', false);
        //Indicate to the template if the default parameters have been updated (not by default):
        $this->update_default = $request->getAttribute('update_def', false);

            /*------------------------------ SYSTEM PARAMETERS------------------------------------*/
            //Build the form:
             $this->form = new SystemParametersForm($this->values);

             /*----------------------------- DEFAULT PARAMETERS------------------------------------*/
            //Build the form:
            $cultures = array_merge($this->getContext()->get('InstalledCultures'), array('en'));
            $this->def_form = new DefaultParametersForm($this->values, array('cultures' => $cultures, 'follow' => $this->values['default_follow_moderator']));
    }


    public function executeUpdateSystemParameters(sfWebRequest $request){

        $this->forward404Unless($request->isMethod(sfRequest::POST));

        //If the HTTP method is "post", get the values entered by the user:

        $this->values = array(
            'ip_address'   => $this->getRequestParameter('ip_address'),
            'srv_port'     => $this->getRequestParameter('srv_port'),
            'dbms'         => $this->getRequestParameter('dbms') + 1,
            'db_name'      => $this->getRequestParameter('db_name'),
            'db_user_name' => $this->getRequestParameter('db_user_name'),
            'db_password'  => $this->getRequestParameter('db_password'),
            '_csrf_token'  => $this->getRequestParameter('_csrf_token'),
        );

        //Build the form with theses values:
        $this->form = new SystemParametersForm($this->values);

        //Execute the validators of this form:
        $this->form->bind($this->values);

        //If everything is fine:
        if ($this->form->isValid()){
            //Insert the new values in the xml configuration file:
            ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
            ParametersConfiguration::setAll($this->values);
            //Indicate to the template that the values are correct and have been updated:
            $request->setAttribute('update_system', true);
        }

        
        
        $this->forward('configuration','parameters');
    }



    public function executeUpdateLists(sfWebRequest $request){

        //Check that the HTTP method is 'POST':
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        //Get the POST parameters:
        $entries_to_remove = $request->getParameter('remove', array());
        $entries_to_disable = $request->getParameter('disable', array());
        $table = $request->getParameter('table');

        $entries_to_add_designation = $request->getParameter('add_designation', array());
        $entries_to_add_short_designation = $request->getParameter('add_short_designation', array());
        $entries_to_add_order = $request->getParameter('add_order', array());
        $entries_to_add_family_id = $request->getParameter('add_family_id', array());


        //Remove the entries passed in the 'remove' parameter:
        PredefinedLists::removeFrom($entries_to_remove, $table);

        //Add the entries passed in the 'add' parameter:
        PredefinedLists::addInto($entries_to_add_designation, $entries_to_add_order, $entries_to_add_short_designation, $entries_to_add_family_id, $table);

        //Disable the entries passed in the 'disable' parameter:
        PredefinedLists::disable($entries_to_disable, $table);

        //Re-get the table that have been updated:
        $data = PredefinedLists::getData(array($table => null));
        $this->updated_table = $data[$table];

        //Set the correct template to display:
         if($table == PredefinedLists::UNITY){
             $this->setTemplate('updateUnities','configuration');
         }else if($table == PredefinedLists::COMPUTER_OS){
             $this->setTemplate('updateOs','configuration');
         }else{
             $this->table_name = $table;
         }

    }


    public function executeUpdateOrders(sfWebRequest $request){

        //Check that the HTTP method is 'POST':
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        //Get the POST parameters:
        $update_order = $request->getParameter('update_order', array());
        $update_short_designation = $request->getParameter('update_short_designation', array());
        $update_id = $request->getParameter('update_id', array());
        $table = $request->getParameter('table');


        //Update the orders and the short designations:
        PredefinedLists::update($update_id, $update_short_designation, $update_order, $table);


        //Re-get the table that have been updated
        $data = PredefinedLists::getData(array($table => null));
        $this->updated_table = $data[$table];

         if($table == PredefinedLists::UNITY){
             $this->setTemplate('updateUnities','configuration');
         }else if($table == PredefinedLists::COMPUTER_OS){
             $this->setTemplate('updateOs','configuration');
         }else{
             $this->table_name = $table;
             $this->setTemplate('updateLists','configuration');
         }

    }


    public function executeUpdateDefaultParameters(sfWebRequest $request){

        $this->forward404Unless($request->isMethod(sfRequest::POST));

        //If the HTTP method is "post", get the values entered by the user:

        $this->def_values = array(
            'default_building'             => $this->getRequestParameter('default_building'),
            'default_room'                 => $this->getRequestParameter('default_room'),
            'default_method_of_payment'    => $this->getRequestParameter('default_method_of_payment'),
            'default_computer'             => $this->getRequestParameter('default_computer'),
            'default_num_to_display'	   => $this->getRequestParameter('default_num_to_display'),
            'default_follow_moderator'	   => $this->getRequestParameter('default_follow_moderator'),
            'default_language'             => $this->getRequestParameter('default_language'),
            'default_currency'			   => $this->getRequestParameter('default_currency'),
            'def_mysql_port'               => $this->getRequestParameter('def_mysql_port'),
            'def_pgsql_port'               => $this->getRequestParameter('def_pgsql_port'),
            'reservation_min_time'         => $this->getRequestParameter('reservation_min_time'),
            'reservation_max_time'         => $this->getRequestParameter('reservation_max_time'),
            '_csrf_token'                  => $this->getRequestParameter('_csrf_token'),
        );

        //Build the form with theses values:
        $this->def_form = new DefaultParametersForm();

        //Execute the validators of this form:
        $this->def_form->bind($this->def_values);

        //If everything is fine:
        if ($this->def_form->isValid()){
            //Insert the new values in the xml configuration file:
            ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
            (!$this->def_values['default_follow_moderator']) ? $this->def_values['default_follow_moderator'] = null : $this->def_values['default_follow_moderator'] = 1;
            ParametersConfiguration::setDefaultParams($this->def_values);
            //Indicate to the template that the values are correct and have been updated:
            $request->setAttribute('update_def', true);
            $this->getUser()->setCulture(ParametersConfiguration::getDefault('default_language'));
        }

        $this->forward('configuration','parameters');

    }

    public function executeRefreshUnities(sfWebRequest $request){

        $this->form = new DefaultParametersForm(array('default_currency' => ParametersConfiguration::getDefault('default_currency')));

    }

    public function executeExport(sfWebRequest $request){

        ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
        $this->dbvalues = ParametersConfiguration::getAll();

        $this->Modules = $this->getContext()->get('Modules');
        $this->Kernel = $this->getContext()->get('Kernel');

        $this->missing_dep = $this->getContext()->get('DependenciesErrors');

        if($request->isMethod(sfRequest::POST)){
            $this->new = $this->getRequestParameter('module_name_to_add');
            $this->new_entry = $this->getRequestParameter('menu_entry');
            $this->delete = $this->getRequestParameter('module_name_to_delete');
            $this->delete_force = $this->getRequestParameter('module_name_to_delete_force');
        }else{
            $this->new = null;
            $this->new_entry = null;
            $this->delete = null;
            $this->delete_force = null;
        }
    }

    public function executeTextExport(sfWebRequest $request)
    {
        $this->setLayout(false);

        ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
        $this->dbvalues = ParametersConfiguration::getAll();

        $this->Modules = $this->getContext()->get('Modules');
        $this->Kernel = $this->getContext()->get('Kernel');

        $this->missing_dep = $this->getContext()->get('DependenciesErrors');

        if($request->isMethod(sfRequest::POST)){
            $this->new = $this->getRequestParameter('module_name_to_add');
            $this->new_entry = $this->getRequestParameter('menu_entry');
            $this->delete = $this->getRequestParameter('module_name_to_delete');
            $this->delete_force = $this->getRequestParameter('module_name_to_delete_force');
        }
        else{
            $this->new = null;
            $this->new_entry = null;
            $this->delete = null;
            $this->delete_force = null;
        }

        $this->getResponse()->setContentType('text/plain');
    }

    public function executeAgenda(sfWebRequest $request)
    {

    }
}
