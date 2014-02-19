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
 * use actions.
 *
 * @package    epi
 * @subpackage use
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class useActions extends sfActions
{

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->user_culture = $this->getUser()->getCulture();
    $this->users = Doctrine::getTable('User')
      ->createQuery('u')
      ->orderBy('u.surname')
      ->execute();

    $this->userId = $request->getParameter('user_id');
    
    $usersListe = $request->getParameter('users_liste');
    if ( $usersListe != "" )
    {
    	$this->usersId = "[";
    	$usersTab = explode(",",$usersListe);
    	foreach ( $usersTab as $val )
    	{
    		$this->usersId .= $sep.$val;
    		$sep = ",";
    	}
    	$this->usersId .= "]";
    }

  	$this->userCulture = $this->getUser()->getCulture();

  	$this->publicCategories = Doctrine_Query::create()
      	->select('a.*')
    	->from('ActPublicCategory a')
    	->orderBy('a.sort_order')
    	->execute();

    // -----------------------------------------------------------------------------------------------------------
    // KYXAR 0003 - 30/06/2011
    // Nombre d'entrées à afficher par défaut
    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
    $this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
    // FIN KYXAR
    // -----------------------------------------------------------------------------------------------------------
  }

  /**
   *
   * Enter description here ...
   */
  public function executeChangeUsersCategoriesIndex(sfWebRequest $request){

  	$users_id = $request->getParameter('users_id', array());

  	$this->users = Doctrine_Query::create()
      	->select('u.*')
    	->from('User u')
    	->whereIn('u.id', $users_id)
    	->execute();

    $this->form = new ChangeUsersCategoriesForm(null, array('users' => $this->users));
  }

  /**
   *
   * Enter description here ...
   * @param array $user_ids
   */
  public function executeChangeUsersCategories(sfWebRequest $request){

  	$this->forward404Unless($request->isMethod(sfRequest::POST));

  	$parameters = $request->getParameter('change_category', array());

  	if(!is_null($parameters['ids'])){

  		foreach($parameters['ids'] as $user_id){

  			$user = Doctrine::getTable('User')->find($user_id);
  			$user->setActPublicCategoryId($parameters['category'][$user_id]);
  			$user->save();

  		}

  	}

  	$this->getUser()->setFlash('notice', 'The categories have been changed.');
  	$this->redirect('use/index');

  }


  /**
   *
   * @param sfWebRequest $request
   */
  public function executeNewImputation(sfWebRequest $request){

  	//First of all, check if the request is of type 'post' and is an XHR:
  	$this->forward404Unless($request->isMethod(sfRequest::POST) && $request->isXmlHttpRequest());

  	//When we received an imputation, first we need to know what type the imputation is:
  	$type_of_imputation = $request->getParameter('type_of_imputation');
  	//echo(ImputationDefaultValues::UNITARY_SERVICE_TYPE);exit();
  	//Then, we call the correct function is this controller depending on the type of imputation which is requested:
  	switch($type_of_imputation){

  		case ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE:
  			$this->executeNewAccountTransaction($request);
  			$this->setTemplate('newAccountTransaction','use');
  			break;

  		case ImputationDefaultValues::PURCHASE_TYPE:
  			$this->executeNewPurchase($request);
  			$this->setTemplate('newPurchase','use');
  			break;

  		case ImputationDefaultValues::COUNTABLE_SERVICE_TYPE:
  			$this->executeNewCountableService($request);
  			$this->setTemplate('newCountableService','use');
  			break;

  		case ImputationDefaultValues::UNITARY_SERVICE_TYPE:
  			$this->executeNewUnitaryService($request);
  			$this->setTemplate('newUnitaryService','use');
  			break;

  		case ImputationDefaultValues::SUBSCRIPTION_TYPE:
  			$this->executeNewSubscription($request);
  			$this->setTemplate('newSubscription','use');
  			break;

  		default:
  			break;
  	}


  }


  /**
   *
   * @param sfWebRequest $request
   */
  protected function executeNewAccountTransaction(sfWebRequest $request){

  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));

  	$user_id = $request->getParameter('users_id', array());;
  	$user_id = $user_id[0];

  	//Create a new ImputationAccountTransaction object in order to predefine the form:
  	$transaction = new ImputationAccountTransaction();

  	$transaction->preConfigure($user_id, sfContext::getInstance()->getUser()->getAttribute('userId'));

  	//Create the form:
  	$this->form = new ImputationAccountTransactionForm($transaction, array('culture' => ParametersConfiguration::getDefault('default_language')));

  	//Get the user accounts in order to be able to display their values and unities:

  	$this->user_account_values = ImputationAccountTransaction::getUserAccountValues($user_id);
  	$this->user_account_unities = ImputationAccountTransaction::getUserAccountUnities($user_id);
  	$this->error_account = false;
  	$this->display_secondary = false;

  }

  /**
   *
   * @param sfWebRequest $request
   */
  public function executeCreateAccountTransaction(sfWebRequest $request){

	$this->forward404Unless($request->isMethod(sfRequest::POST));

	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));


	$imputation_parameters = $request->getParameter('imputation_account_transaction');
	$user_id = $imputation_parameters['imputation']['user_id'];

	$transaction = new ImputationAccountTransaction();
	$transaction->getImputation()->setUserId($user_id);

	$this->form = new ImputationAccountTransactionForm($transaction, array('culture' => ParametersConfiguration::getDefault('default_language')));

	$this->processAccountTransactionForm($request, $this->form);

	//Get the user accounts in order to be able to display their values and unities:
  	$this->user_account_values = ImputationAccountTransaction::getUserAccountValues($user_id);
  	$this->user_account_unities = ImputationAccountTransaction::getUserAccountUnities($user_id);
  	$this->display_secondary = true;

	$this->setTemplate('newAccountTransaction');
  }


  /**
   *
   * @param sfWebRequest $request
   */
  protected function executeNewPurchase(sfWebRequest $request){

  	$this->executeNew('purchase', $request);

  }


  /**
   *
   * @param sfWebRequest $request
   */
  public function executeCreatePurchase(sfWebRequest $request){

  	$this->forward404Unless($request->getMethod() == sfRequest::POST);

  	$this->executeCreate('purchase', $request);

	$this->setTemplate('newPurchase');

  }

  /**
   *
   * @param sfWebRequest $request
   */
  protected function executeNewCountableService(sfWebRequest $request){

  	$this->executeNew('countable_service', $request);

  	$this->currency_symbol = ImputationDefaultValues::getDefaultCurrencySymbol();
  }


  /**
   *
   * @param sfWebRequest $request
   */
  public function executeCreateCountableService(sfWebRequest $request){

  	$this->executeCreate('countable_service', $request);

  	$this->currency_symbol = ImputationDefaultValues::getDefaultCurrencySymbol();

	$this->setTemplate('newCountableService');

  }


  /**
   *
   * @param sfWebRequest $request
   */
  protected function executeNewUnitaryService(sfWebRequest $request){

  	$unitary_service = $this->executeNew('unitary_service', $request);

  	$this->duration = $unitary_service->getImputation()->getAct()->getDuration();

  }


  /**
   *
   * @param sfWebRequest $request
   */
  public function executeCreateUnitaryService(sfWebRequest $request){

  	$unitary_service = $this->executeCreate('unitary_service', $request);

	$this->duration = $unitary_service->getImputation()->getAct()->getDuration();

	$this->setTemplate('newUnitaryService');

  }

  /**
   *
   * @param sfWebRequest $request
   */
  protected function executeNewSubscription(sfWebRequest $request){

  	$subscription = $this->executeNew('subscription', $request);

  	$this->duration = $subscription->getImputation()->getAct()->getDuration();
  }

  /**
   *
   * @param sfWebRequest $request
   */
  public function executeCreateSubscription(sfWebRequest $request){

  	$subscription = $this->executeCreate('subscription', $request);

	$this->duration = $subscription->getImputation()->getAct()->getDuration();

	$this->setTemplate('newSubscription');

  }

  public function executeAjaxPossibleActs(sfWebRequest $request)
  {
  	$categoryId = $request->getParameter('id');
  	$possibleActs = array();

  	$acts = Doctrine::getTable('Act')
	    ->createQuery('a')
        // -----------------------------------------------------------------------------------------------------------
        // KYXAR 0001 - 30/06/2011
        // On n'affiche pas les actes qui ont été supprimés
        ->addWhere('a.disabled = ?',0)
        // FIN KYXAR
        // -----------------------------------------------------------------------------------------------------------
        ->execute();

	$this->actTypes = Doctrine::getTable('ActType')
	    ->createQuery('a')
	    ->execute();

	foreach($acts as $act)
	{
		$actPrice = Doctrine::getTable('ActPrice')->findOneByActIdAndActPublicCategoryId($act->getId(),$categoryId);

		if(($actPrice['value'] != -1)&&($actPrice['value'] != null))
		{
			 $possibleActs[$act->getActTypeId()][$act->getId()][0] = $act->getDesignation();
		     $possibleActs[$act->getActTypeId()][$act->getId()][1] = $actPrice['value'];
		     $possibleActs[$act->getActTypeId()][$act->getId()][2] = $act->getId();
		     $possibleActs[$act->getActTypeId()][$act->getId()][3] = $act->getActTypeId();
		}
	}

  	$this->setTemplate('possibleActs','use');
  	$this->possibleActs = $possibleActs;

  	if($request->getParameter('numberUsers') > 1){
  		$this->multiUsers = 1;
  	}
  	else $this->multiUsers = 0;

  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
  }

  protected function executeNew($type_of_imputation, sfWebRequest $request){

  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));

  	/* -------------------------------------- PARAMETERS PREPARATION: --------------------------------------*/
  	$users_id = $request->getParameter('users_id', array());
  	$act_id = $request->getParameter('act_id');
  	$act_public_category_id = $request->getParameter('act_public_category_id');

  	$first_user_id = $users_id[0];
  	unset($users_id[0]);

  	/* ----------------------------------------- FORM CREATION: ---------------------------------------------*/

  	//Create a new ImputationAccountTransaction object in order to predefine the form:
  	$object = Imputation::instanciate($type_of_imputation);
  	$object->preConfigure($first_user_id, sfContext::getInstance()->getUser()->getAttribute('userId'), $act_id, $act_public_category_id);
  	//Create the form:
  	$this->form = Imputation::instanciateForm($type_of_imputation, $object, array('culture' => ParametersConfiguration::getDefault('default_language'), 'public_category' => $act_public_category_id, 'users' => $users_id));

  	/* -------------------------------- VARIABLES TO PASS TO THE TEMPLATE: -----------------------------------*/

  	$this->prepareToNewPage($first_user_id, $users_id, $act_public_category_id);

  	return $object;
  }

  /**
   *
   * @param unknown_type $type_of_imputation
   * @param sfWebRequest $request
   */
  protected function executeCreate($type_of_imputation, sfWebRequest $request){



	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));

	/* ----------------------------------- WE GET THE PARAMETERS --------------------------------------- */

	$imputation_parameters = $request->getParameter('imputation_'.$type_of_imputation);
	$first_user_id = $imputation_parameters['imputation']['user_id'];

	$mop_ids = Imputation::getMethodOfPaymentIds($imputation_parameters);
	$account_ids = Imputation::getAccountIds($imputation_parameters);

	if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::UNITARY_SERVICE_TYPE){
		$computer_ids = Imputation::getComputerIds($imputation_parameters);
	}

	if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::COUNTABLE_SERVICE_TYPE){

		if(!isset($imputation_parameters['account_is_shared'])){
			$imputation_parameters['account_is_shared'] = 'off';
		}

	}

	$imputation_parameters = Imputation::cleanParameters($imputation_parameters);

	/* ---------------------------- WE TRY TO VALIDATE A FORM FOR EACH USER --------------------------- */

	if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::UNITARY_SERVICE_TYPE){

		if($this->processEachForm($type_of_imputation, $request, $imputation_parameters, $mop_ids, $account_ids, $computer_ids)){
			$this->getUser()->setFlash('notice', 'The imputation has been saved.');
			$this->redirect('use/index');
		}

	}else{

		if($this->processEachForm($type_of_imputation, $request, $imputation_parameters, $mop_ids, $account_ids)){

			$this->getUser()->setFlash('notice', 'The imputation has been saved.');

			if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::SUBSCRIPTION_TYPE){
				$request->setParameter('users_id', array_keys($mop_ids));
				$this->redirect('use/changeUsersCategoriesIndex');
			}else{
				$this->redirect('use/index');
			}

		}

	}

	/* ---------------------------- IF IT REACHES THIS LINE, THE FORM IS INVALID ---------------------------- */

	$this->getUser()->setFlash('error', 'Some fields are missing or incorrect');
	return $this->prepareToErrorPage($type_of_imputation, $first_user_id, $mop_ids, $request, $imputation_parameters);

  }

  /**
   *
   * @param unknown_type $type_of_imputation
   * @param unknown_type $first_user_id
   * @param unknown_type $mop_ids
   * @param sfWebRequest $request
   */
  private function prepareToErrorPage($type_of_imputation, $first_user_id, $mop_ids, sfWebRequest $request, $imputation_parameters){


  	//Get the first user accounts in order to be able to display their values and unities:
  	$this->first_user_account_values = ImputationAccountTransaction::getUserAccountValues($first_user_id);
  	$this->first_user_account_unities = ImputationAccountTransaction::getUserAccountUnities($first_user_id);


  	//Get the others users ids, names, and accounts values and unities:
  	unset($mop_ids[$first_user_id]);
  	$users_names = array();
  	$user_account_values = array();
  	$user_account_unities = array();

  	foreach($mop_ids as $user_id => $mop_id){
  		$users_names[$user_id] = User::getNameAndSurname($user_id);
  		$user_account_values[$user_id] = ImputationAccountTransaction::getUserAccountValues($user_id);
  		$user_account_unities[$user_id] = ImputationAccountTransaction::getUserAccountUnities($user_id);
  	}

  	//Pass variables to the template:
  	$this->users_id = array_keys($mop_ids);
  	$this->users_account_values = $user_account_values;
  	$this->users_account_unities = $user_account_unities;
  	$this->users_names = $users_names;

  	//Pass the form to display to the template
  	$object = Imputation::instanciate($type_of_imputation);
  	$object->preConfigure($first_user_id, sfContext::getInstance()->getUser()->getAttribute('userId'), $imputation_parameters['imputation']['act_id']);
  	$act_public_category_id = $request->getParameter('act_public_category_id');

  	$this->form = Imputation::instanciateForm($type_of_imputation, $object, array('culture' => ParametersConfiguration::getDefault('default_language'), 'public_category' => $act_public_category_id, 'users' => array_keys($mop_ids)));
	unset($imputation_parameters['account_is_shared']);
  	$this->form->bind($imputation_parameters);

  	$this->act_public_category_id = $act_public_category_id;

  	$this->display_secondary = true;

  	return $object;
  }



  /**
   *
   * @param integer $first_user_id
   * @param array $users_id
   */
  private function prepareToNewPage($first_user_id, $users_id, $act_public_category_id){

  	//Get the first user accounts in order to be able to display their values and unities:
  	$this->first_user_account_values = ImputationAccountTransaction::getUserAccountValues($first_user_id);
  	$this->first_user_account_unities = ImputationAccountTransaction::getUserAccountUnities($first_user_id);

  	//Get the others users ids, names, and accounts values and unities:
  	$users_names = array();
  	$user_account_values = array();
  	$user_account_unities = array();
  	foreach($users_id as $id){
  		$users_names[$id] = User::getNameAndSurname($id);
  		$user_account_values[$id] = ImputationAccountTransaction::getUserAccountValues($id);
  		$user_account_unities[$id] = ImputationAccountTransaction::getUserAccountUnities($id);
  	}

  	//Pass variables to the template:
  	$this->users_id = $users_id;
  	$this->users_account_values = $user_account_values;
  	$this->users_account_unities = $user_account_unities;
  	$this->users_names = $users_names;
  	$this->act_public_category_id = $act_public_category_id;
  	$this->display_secondary = false;
  	$this->error_account = false;

  }


 /**
   *
   * @param $type_of_imputation
   * @param $request
   * @param $imputation_parameters
   * @param $mop_ids
   * @param $account_ids
   * @param $computer_ids
   */
  private function processEachForm($type_of_imputation, sfWebRequest $request, $imputation_parameters, $mop_ids, $account_ids, $computer_ids = null){

	  $ret = true;
	  $first = true;

  	  /*For each user represented by its method_of_payment_id (mop_id):*/
	  foreach($mop_ids as $user_id => $mop_id){

	  		//we set the parameters:
			$imputation_parameters['imputation']['user_id'] = $user_id;
			$imputation_parameters['imputation']['method_of_payment_id'] = $mop_id;
			$imputation_parameters['imputation']['account_id'] = $account_ids[$user_id];

			if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::UNITARY_SERVICE_TYPE){
				$imputation_parameters['computer_id'] = $computer_ids[$user_id];
			}

			//we set theses parameters in the request object:
			$request->setParameter('imputation_'.$type_of_imputation, $imputation_parameters);

			//create the object which will be used for creating the form:
			$object = Imputation::instanciate($type_of_imputation);
			$object->getImputation()->setUserId($user_id);
			$object->getImputation()->setActId($imputation_parameters['imputation']['act_id']);

			//we build the form based on the object:
			$this->form = Imputation::instanciateForm($type_of_imputation, $object, array('culture' => ParametersConfiguration::getDefault('default_language')));

			//we try to validate this form with request which contains the correct parameters:
			if($imputation_parameters['imputation']['imputation_type'] == ImputationDefaultValues::COUNTABLE_SERVICE_TYPE){
				if(($imputation_parameters['account_is_shared'] == 'on') && (isset($this->current_account_id))){

					$ret = $ret && $this->processForm($request, $this->form, $this->current_account_id);

				}else{
					$ret = $ret && $this->processForm($request, $this->form);
				}
			}else{
				$ret = $ret && $this->processForm($request, $this->form);
			}

			$first = false;
	 }

	 return $ret;

  }


  /**
   *
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  private function processForm(sfWebRequest $request, sfForm $form, $account_id = null){

  	$parameters = $request->getParameter($form->getName());

  	if($parameters['imputation']['imputation_type'] == ImputationDefaultValues::COUNTABLE_SERVICE_TYPE){

		$parameters['account']['value'] = $parameters['initial_value'];
		$parameters['account']['monetary_account'] = $form->getObject()->getImputation()->getAct()->getMonetaryAccount();
		$parameters['account']['created_at'] = $parameters['imputation']['date'];
		$parameters['account']['act_id'] = $form->getObject()->getImputation()->getActId();

		unset($parameters['account_is_shared']);

  	}

  	$form->bind($parameters);

    if ($form->isValid()){


    	//If the method of payment is 'account':
    	if($parameters['imputation']['method_of_payment_id'] == ImputationDefaultValues::getAccountMethodId()){
    		//We create a new 'hidden' imputation of type account_transaction

    		if(ImputationAccountTransaction::buildAndSaveTransactionFrom($parameters)){
    			$saved_object = $form->save();
    			$this->error_account = false;
    		}else{
    			if($parameters['imputation']['account_id'] == 0){
    				$this->error_account = true;
    			}else{
    				$this->error_account = false;
    			}
    			return false;
    		}
    	}else{
    		$saved_object = $form->save();
    		$this->error_account = false;
    	}



    	//If the type of the imputation is 'countable_service'
    	if($parameters['imputation']['imputation_type'] == ImputationDefaultValues::COUNTABLE_SERVICE_TYPE){
    		//We create a new account user entry:
    		if(!is_null($account_id)){
    			ImputationCountableService::createAccountUser(
    				$form->getEmbeddedForm('imputation')->getObject()->getUserId(),
    				$account_id);
    		}else{
    			$this->current_account_id = ImputationCountableService::createAccountUser(
    				$form->getEmbeddedForm('imputation')->getObject()->getUserId(),
    				$form->getEmbeddedForm('account')->getObject()->getId());
    		}

    	}
    	//A FAIRE ICI: DUPLICATION DANS LA TABLE ARCHIVE
    	/**
    	 * @todo
    	 */

    	$archive = new ImputationArchive();
    	$archive->fillAndSave($form);

    	return true;
    }else{

   		if($parameters['imputation']['account_id'] == 0){
    		$this->error_account = true;
    	}else{
    		$this->error_account = false;
    	}

    	return false;
    }
  }

 /**
  *
  * @param sfWebRequest $request
  * @param ImputationAccountTransactionForm $form
  */
 private function processAccountTransactionForm(sfWebRequest $request, ImputationAccountTransactionForm $form){

  	$parameters = $request->getParameter($form->getName());

  	if($parameters['imputation']['account_id'] == 0){
  		$parameters['imputation']['account_id'] = null;
  		$this->error_account = true;
  	}

  	if($parameters['quantity'] != ''){

  		$parameters['sum'] = -$parameters['quantity'];
  		$parameters['imputation']['total'] = 0;

  		$parameters['imputation']['method_of_payment_id'] = ImputationDefaultValues::getFreeMethodId();
  		unset($parameters['unitary_price']);
  		unset($parameters['quantity']);

  		$this->error_account = false;
  	}


  	$form->bind($parameters);

    if ($form->isValid()){

    	$transaction = $form->save();

    	$account = Doctrine::getTable('Account')->find($parameters['imputation']['account_id']);
    	$account->setValue($account->getValue() + $parameters['sum']);
    	$account->save();

	    if($parameters['imputation']['method_of_payment_id'] == ImputationDefaultValues::getAccountMethodId()){

	  			//If the method of payment is 'account':
	  			//Find the target account (the account used to pay):
	  			$target_account = Doctrine::getTable('Account')->find($parameters['account_to_pay_id']);

	  			$parameters_to_pay = $parameters;
	  			$parameters_to_pay['sum'] = $parameters['imputation']['total'];
				$parameters_to_pay['imputation']['total'] = $parameters_to_pay['sum'];
				$parameters_to_pay['imputation']['account_id'] = $parameters['account_to_pay_id'];
				$parameters_to_pay['imputation']['unity_id'] = $target_account->getAct()->getUnityId();

				//print_r($parameters_to_pay);exit(-1);

	    		//Duplicate the form:
	    		$transaction = new ImputationAccountTransaction();
				$transaction->getImputation()->setUserId($parameters['imputation']['user_id']);

				$form_to_pay = new ImputationAccountTransactionForm($transaction, array('culture' => ParametersConfiguration::getDefault('default_language')));

	    		//Bind it with the duplicate parameters:
	    		$form_to_pay->bind($parameters_to_pay);

	    		if($form_to_pay->isValid()){
	    			//If the form is valid, change the target account value:
	    			$target_account->setValue($target_account->getValue() - $parameters_to_pay['sum']);
	    			$target_account->save();

	    			//Eventually if the form is valid, save the duplicated form:
	    			$form_to_pay->save();

	    			$this->error_account = false;
	    		}
	    }else $this->error_account = true;

    	$this->redirect('use/index');
    }
  }

  public function executeHistory(sfWebRequest $request)
  {
  	$this->imputations = Doctrine::getTable('Imputation')
	    ->createQuery('i')
	    ->orderBy('i.date DESC')
	    ->execute();

	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
  	$this->userCulture = $this->getUser()->getCulture();
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById(ParametersConfiguration::getDefault('default_currency'))->getShortenedDesignation();
  }

  public function executeAjaxImputationInfo(sfWebRequest $request)
  {
  	$accountTransaction = null;
  	$purchase = null;
  	$countableService = null;
  	$unitaryService = null;
  	$subscription = null;
  	$computer = null;

  	$imputationId = $request->getParameter('id');
  	$imputation = Doctrine::getTable('Imputation')->findOneById($imputationId);

  	switch ($imputation->getImputationType())
  	{
  		case ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE:
  			$accountTransaction = Doctrine::getTable('ImputationAccountTransaction')->findOneByImputationId($imputationId);
  			$imputationType = "Account transaction";
  			break;

  		case ImputationDefaultValues::PURCHASE_TYPE:
  			$purchase = Doctrine::getTable('ImputationPurchase')->findOneByImputationId($imputationId);
  			$imputationType = "Purchase";
  			break;

  		case ImputationDefaultValues::COUNTABLE_SERVICE_TYPE:
  			$countableService = Doctrine::getTable('ImputationCountableService')->findOneByImputationId($imputationId);
  			$imputationType = "Countable service";
  			break;

  		case ImputationDefaultValues::UNITARY_SERVICE_TYPE:
  			$unitaryService = Doctrine::getTable('ImputationUnitaryService')->findOneByImputationId($imputationId);
  			$imputationType = "Unitary service";
  			$computer = Doctrine::getTable('Computer')->findOneById($unitaryService['computer_id'])->getName();
  			break;

  		case ImputationDefaultValues::SUBSCRIPTION_TYPE:
  			$subscription = Doctrine::getTable('ImputationSubscription')->findOneByImputationId($imputationId);
  			$imputationType = "Subscription";
  			break;
  	}

  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById(ParametersConfiguration::getDefault('default_currency'))->getShortenedDesignation();

  	$this->accountTransaction = $accountTransaction;
  	$this->purchase = $purchase;
  	$this->countableService = $countableService;
  	$this->unitaryService = $unitaryService;
  	$this->subscription = $subscription;
  	$this->imputation = $imputation;
  	$this->imputationType = $imputationType;
  	$this->computer = $computer;
  	$this->setTemplate('imputationInfo','use');
  }


  public function executeAjaxDeleteImputation(sfWebRequest $request)
  {
  	$imputationsToDelete = $request->getParameter('id');
  	$imputationsToDeleteExploded = "";

  	if(sizeof($imputationsToDelete))
  	{
	  	foreach($imputationsToDelete as $imputationToDelete)
	  	{
	  		$imputationsToDeleteExploded .= ','.$imputationToDelete;
	  	}
  	}

  	$this->imputationsToDelete = $imputationsToDeleteExploded;
  	$this->numberOfImputationsToDelete = sizeof($request->getParameter('id'));
  	$this->setTemplate('deleteImputation','use');
  }

  public function executeDeleteImputation(sfWebRequest $request)
  {
  	$imputationsToDelete = $request->getParameter('id');
  	$imputationsToDelete = explode(",",$imputationsToDelete);

  	foreach($imputationsToDelete as $imputationToDelete)
  	{
  		if($imputationToDelete != null)
  	  	{
  	  		Doctrine_Query::create()
    			->delete('Imputation i')
    			->where('i.id = ?',$imputationToDelete)
    			->execute();

  	  		Doctrine_Query::create()
    				->delete('ImputationArchive a')
    				->where('a.imputation_id = ?',$imputationToDelete)
    				->execute();
  	  	}
  	}

  	$this->getUser()->setFlash('notice', 'The uses have been deleted.');
    $this->redirect('use/history');
  }

}
