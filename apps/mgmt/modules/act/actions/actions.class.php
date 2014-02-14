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
 * act actions.
 *
 * @package    epi
 * @subpackage act
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->acts = Doctrine::getTable('Act')
      ->createQuery()
      ->select('a.*')
	  ->from('Act a')
	  ->where('a.disabled <> 1')
	  ->orderBy('a.designation')
	  ->execute();
      
    $this->subscriptions = Doctrine::getTable('Act')
    	->createQuery()
      	->select('a.*')
	    ->from('Act a')
	    ->where('a.act_type_id = 1')
	    ->addWhere('a.disabled <> 1')
	    ->orderBy('a.designation')
	    ->execute();
    
	$this->unitaryServices = Doctrine::getTable('Act')
    	->createQuery()
      	->select('a.*')
	    ->from('Act a')
	    ->where('a.act_type_id = 2')
	    ->addWhere('a.disabled <> 1')
	    ->orderBy('a.designation')
	    ->execute();
    
	$this->multipleServices = Doctrine::getTable('Act')
    	->createQuery()
      	->select('a.*')
	    ->from('Act a')
	    ->where('a.act_type_id = 3')
	    ->addWhere('a.disabled <> 1')
	    ->orderBy('a.designation')
	    ->execute();
	    
    $this->purchases = Doctrine::getTable('Act')
    	->createQuery()
      	->select('a.*')
	    ->from('Act a')
	    ->where('a.act_type_id = 4')
	    ->addWhere('a.disabled <> 1')
	    ->orderBy('a.designation')
	    ->execute();
	 
	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
  	$this->userCulture = $this->getUser()->getCulture();
  }

  public function executeNewSubscription(sfWebRequest $request)
  {
  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
  	
    $this->form = new SubscriptionForm();
  }
  
  public function executeNewUnitaryService(sfWebRequest $request)
  {
    $this->form = new UnitaryServiceForm();
  }
  
  public function executeNewMultipleService(sfWebRequest $request)
  {
  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
  	
    $this->form = new MultipleServiceForm();
  }
  
  public function executeNewPurchase(sfWebRequest $request)
  {
    $this->form = new PurchaseForm();
  }

  
/*****************************************SUBSCRIPTION**********************************************/
  
  /**
   * Creates a new subscription
   * @param sfWebRequest $request
   */
  public function executeCreateSubscription(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SubscriptionForm();
    
    $this->processSubscriptionForm($request, $this->form);

    $this->setTemplate('newSubscription');
  }

   /**
   * Processes the insert of the new subscription into the database
   * Uses the function ActTable::saveSubscription
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processSubscriptionForm(sfWebRequest $request, sfForm $form)
  {
  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
  	
  	$this->forward404Unless($request->isMethod(sfRequest::POST));

  	$duration_temp = ActLib::getFormattedNumber($this->getRequestParameter('duration_temp'));
	
  	$duration = ActLib::getFormattedDuration($duration_temp,$this->getRequestParameter('duration_unity'));
	
  	$extra_cost = ActLib::getFormattedNumber($this->getRequestParameter('extra_cost'));
  	
	$this->values = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'duration_temp'        		=> $duration_temp,
		'duration'        			=> $duration,
		'max_members'				=> $this->getRequestParameter('max_members'),
		'extra_cost'				=> $extra_cost,
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
  	
	//Build the form with theses values:
	$this->form = new SubscriptionForm($this->values);
		
	//Execute the validators of this form:
	$this->form->bind($this->values);

    if ($this->form->isValid())
    {
      $actTable = Doctrine::getTable('Act');
      $actTable->saveSubscription($this->values);
      
      $this->getUser()->setFlash('notice', 'The subscription has been added.');
      $this->redirect('act/index#subscriptions');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  } 
  
   /**
   * Diplays the current values for the selected predefined subscription
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeEditSubscription(sfWebRequest $request)
  {
    $this->forward404Unless($subscription = Doctrine::getTable('Act')->find(array($request->getParameter('id'))), sprintf('Object subscription does not exist (%s).', $request->getParameter('id')));
    
    $explodedDuration = ActLib::getExplodedDuration($subscription['duration']);
    
    $this->values = array(
		'designation'   			=> $subscription['designation'],
		'shortened_designation'     => $subscription['shortened_designation'],
		'comment'        			=> $subscription['comment'],
    	'duration'					=> $subscription['duration'],
    	'duration_temp'				=> $explodedDuration['duration'],
    	'duration_unity'			=> $explodedDuration['unity'],
    	'max_members'				=> $subscription['max_members'],
		'extra_cost'				=> $subscription['extra_cost'],
		'act_type_id'        		=> $subscription['act_type_id'],
	);

	$this->subscriptionId = $request->getParameter('id');
	
	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
	
	//Used for the redirection
	if($request->getParameter('index'))
	{
		$this->index = 1;
	}
	else
	{
		$this->index = 0;
	}
	
    $this->form = new SubscriptionForm($this->values);
    
    $this->form->setWidget('duration_unity',new sfWidgetFormInputHidden());
    
    $this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('duration_temp')->setAttribute('readonly', 'readonly');
    
    
    if($explodedDuration['unity_designation'] != null)
    {
    	$this->unity = $explodedDuration['unity_designation'];
    }
    else
    {
    	$this->unity = null;
    }
  }  
  
  /**
   * Processes the update of the selected subscription into the database
   * Uses the function ActTable::updateSubscription
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeUpdateSubscription(sfWebRequest $request)
  {
  	$actTable = Doctrine::getTable('Act');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($subscription = $actTable->find(array($request->getParameter('id'))), sprintf('Object subscription does not exist (%s).', $request->getParameter('id')));

    $duration_temp = ActLib::getFormattedNumber($this->getRequestParameter('duration_temp'));
	
  	$duration = ActLib::getFormattedDuration($duration_temp,$this->getRequestParameter('duration_unity'));
	
  	$extra_cost = ActLib::getFormattedNumber($this->getRequestParameter('extra_cost'));
    
    $explodedDuration = ActLib::getExplodedDuration($duration);
    
	$this->newValues = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'duration_temp'        		=> $duration_temp,
		'duration_unity'        	=> $this->getRequestParameter('duration_unity'),
		'duration'        			=> $duration,
		'max_members'				=> $this->getRequestParameter('max_members'),
		'extra_cost'				=> $extra_cost,
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
    
    $this->form = new SubscriptionForm($this->newValues);

  	//Execute the validators of this form:
	$this->form->bind($this->newValues);

    if ($this->form->isValid())
    {
      $purchase = $actTable->updateSubscription($this->newValues,$this->getRequestParameter('id'));
      $this->getUser()->setFlash('notice', 'The predefined subscription has been updated.');
      $this->redirect('act/index#subscriptions');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }

    $this->subscriptionId = $request->getParameter('id');
    
    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
    $defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
    $this->index = 0;
    
    $this->form->setWidget('duration_unity',new sfWidgetFormInputHidden());
    
  	$this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('duration_temp')->setAttribute('readonly', 'readonly');
  	
    if($explodedDuration['unity_designation'] != null)
    {
    	$this->unity = $explodedDuration['unity_designation'];
    }
    else
    {
    	$this->unity = null;
    }
    
    $this->setTemplate('editSubscription');
  }   
  
  /**
   * Disables a predefined subscription. It still appears in the database but the user cannot see it in the act lists.
   * 
   * @param sfWebRequest $request
   */
  public function executeDeleteSubscription(sfWebRequest $request)
  {
    $actTable = Doctrine::getTable('Act');
    
    $this->forward404Unless($subscription = $actTable->find(array($request->getParameter('id'))), sprintf('Object subscription does not exist (%s).', $request->getParameter('id')));

    $actTable->disableAct($this->getRequestParameter('id'));
    
	$this->getUser()->setFlash('notice', 'The predefined subscription has been deleted.');
	
	$this->redirect('act/index#subscriptions');
  }  
  
  
  /*****************************************UNITARY SERVICE***************************************/
  
  /**
   * Creates a new unitary service
   * @param sfWebRequest $request
   */
  public function executeCreateUnitaryService(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UnitaryServiceForm();
    
    $this->processUnitaryServiceForm($request, $this->form);

    $this->setTemplate('newUnitaryService');
  }
  
  /**
   * Processes the insert of the new unitary service into the database
   * Uses the function ActTable::saveUnitaryService
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processUnitaryServiceForm(sfWebRequest $request, sfForm $form)
  {

  	$this->forward404Unless($request->isMethod(sfRequest::POST));

  	$duration_temp = ActLib::getFormattedNumber($this->getRequestParameter('duration_temp'));
	
  	$duration = ActLib::getFormattedDuration($duration_temp,$this->getRequestParameter('duration_unity'));

  	$recurrence = ActLib::getFormattedRecurrence($request);
	
  	$beginning_datetime = ActLib::getFormattedDateTime($this->getRequestParameter('beginning_datetime'));
  	
  	$end_date = ActLib::getFormattedDate($this->getRequestParameter('end_date'));
  	
	$this->values = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'duration_temp'        		=> $duration_temp,
		'duration'        			=> $duration,
		'beginning_datetime'		=> $beginning_datetime,
		'end_date'					=> $end_date,
		'recurrence'				=> $recurrence,
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);


	//Build the form with theses values:
	$this->form = new UnitaryServiceForm($this->values);
		
	//Execute the validators of this form:
	$this->form->bind($this->values);

    if ($this->form->isValid())
    {
      $actTable = Doctrine::getTable('Act');
      $unitaryService = $actTable->saveUnitaryService($this->values);
      $this->getUser()->setFlash('notice', 'The unitary service has been added.');
      $this->redirect('act/index#unitary-services');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
  
  
 /**
   * Diplays the current values for the selected predefined unitary service
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeEditUnitaryService(sfWebRequest $request)
  {
    $this->forward404Unless($unitaryService = Doctrine::getTable('Act')->find(array($request->getParameter('id'))), sprintf('Object unitary service does not exist (%s).', $request->getParameter('id')));
    
    $explodedDuration = ActLib::getExplodedDuration($unitaryService['duration']);
    
    $this->values = array(
		'designation'   			=> $unitaryService['designation'],
		'shortened_designation'     => $unitaryService['shortened_designation'],
		'comment'        			=> $unitaryService['comment'],
    	'duration'					=> $unitaryService['duration'],
    	'duration_temp'				=> $explodedDuration['duration'],
    	'duration_unity'			=> $explodedDuration['unity'],
    	'beginning_datetime'		=> $unitaryService['beginning_datetime'],
    	'end_date'					=> $unitaryService['end_date'],
    	'recurrence'				=> $unitaryService['recurrence'],
    	'act_type_id'        		=> $unitaryService['act_type_id'],
	);
	
	$this->unitaryServiceId = $request->getParameter('id');
	
	//Used for the redirection
	if($request->getParameter('index'))
	{
		$this->index = 1;
	}
	else
	{
		$this->index = 0;
	}
	
    $this->form = new UnitaryServiceForm($this->values);
    
    $this->form->setWidget('duration_unity',new sfWidgetFormInputHidden());
    
    $this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('duration_temp')->setAttribute('readonly', 'readonly');
    
  	if($explodedDuration['unity_designation'] != null)
    {
    	$this->unity = $explodedDuration['unity_designation'];
    }
    else
    {
    	$this->unity = null;
    }
    
    ActLib::checkRecurrences($unitaryService['recurrence'],$this->form);
	
  }
  
/**
   * Processes the update of the selected unitary service into the database
   * Uses the function ActTable::updateUnitaryService
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeUpdateUnitaryService(sfWebRequest $request)
  {
  	$actTable = Doctrine::getTable('Act');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($unitaryService = $actTable->find(array($request->getParameter('id'))), sprintf('Object unitary service does not exist (%s).', $request->getParameter('id')));
    
    $duration = ActLib::getFormattedDuration($this->getRequestParameter('duration_temp'),$this->getRequestParameter('duration_unity'));
	
    $explodedDuration = ActLib::getExplodedDuration($duration);
    
    $recurrence = ActLib::getFormattedRecurrence($request);
	
  	$beginning_datetime = ActLib::getFormattedDateTime($this->getRequestParameter('beginning_datetime'));
  	
  	$end_date = ActLib::getFormattedDate($this->getRequestParameter('end_date'));
  	
	$this->newValues = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'duration_temp'        		=> $this->getRequestParameter('duration_temp'),
		'duration'        			=> $duration,
		'beginning_datetime'		=> $beginning_datetime,
		'end_date'					=> $end_date,
		'recurrence'				=> $recurrence,
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
    
    $this->form = new UnitaryServiceForm($this->newValues);

  	//Execute the validators of this form:
	$this->form->bind($this->newValues);

    if ($this->form->isValid())
    {
      $unitaryService = $actTable->updateUnitaryService($this->newValues,$this->getRequestParameter('id'));
      $this->getUser()->setFlash('notice', 'The predefined unitary service has been updated.');
      $this->redirect('act/index#unitary-services');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }

    $this->unitaryServiceId = $request->getParameter('id');
    $this->index = 0;
    
    $this->form->setWidget('duration_unity',new sfWidgetFormInputHidden());
    
  	$this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('duration_temp')->setAttribute('readonly', 'readonly');
  	
    ActLib::checkRecurrences($this->getRequestParameter('recurrence'),$this->form);
    
    if($explodedDuration['unity_designation'] != null)
    {
    	$this->unity = $explodedDuration['unity_designation'];
    }
    else
    {
    	$this->unity = null;
    }
    
    
  	$this->setTemplate('editUnitaryService');
  }
  
    /**
   * Disables a predefined unitary service. It still appears in the database but the user cannot see it in the act lists.
   * 
   * @param sfWebRequest $request
   */
  public function executeDeleteUnitaryService(sfWebRequest $request)
  {
    $actTable = Doctrine::getTable('Act');
    
    $this->forward404Unless($unitaryService = $actTable->find(array($request->getParameter('id'))), sprintf('Object unitary service does not exist (%s).', $request->getParameter('id')));

    $actTable->disableAct($this->getRequestParameter('id'));
    
	$this->getUser()->setFlash('notice', 'The predefined unitary service has been deleted.');
	
	$this->redirect('act/index#unitary-services');
  }  
  
  /*****************************************MULTIPLE SERVICE***************************************/

   /**
   * Creates a new multiple service
   * @param sfWebRequest $request
   */
  public function executeCreateMultipleService(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MultipleServiceForm();

    $this->processMultipleServiceForm($request, $this->form);

    $this->setTemplate('newMultipleService');
  }    
  
    /**
   * Processes the insert of the new multiple service into the database
   * Uses the function ActTable::saveMultipleService
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processMultipleServiceForm(sfWebRequest $request, sfForm $form)
  {
  	
  	$this->forward404Unless($request->isMethod(sfRequest::POST));
		
	//If the HTTP method is "post", get the values entered by the user:

  	$quantity = ActLib::getFormattedNumber($this->getRequestParameter('quantity'));
  	
  	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  	
  	if($this->getRequestParameter('unity_id') == 0)
  	{
  		$unity = $defaultCurrencyId;
  	}
  	else
  	{
  		$unity = $this->getRequestParameter('unity_id');
  	}
  	
  	if($this->getRequestParameter('monetary_account') == "on")
  	{
  		$monetaryAccount = 1;
  	}
  	else
  	{
  		$monetaryAccount = 0;
  	}
  	
	$this->values = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'monetary_account'        	=> $monetaryAccount,
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'quantity'					=> $quantity,
		'unity_id'					=> $unity,
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
  	
	//Build the form with theses values:
	$this->form = new MultipleServiceForm($this->values);
		
	//Execute the validators of this form:
	$this->form->bind($this->values);

    if ($this->form->isValid())
    {
      $actTable = Doctrine::getTable('Act');
      $multipleService = $actTable->saveMultipleService($this->values);
      $this->getUser()->setFlash('notice', 'The multiple service has been added.');
      $this->redirect('act/index#multiple-services');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  } 
  
  /**
   * Diplays the current values for the selected predefined multiple service
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeEditMultipleService(sfWebRequest $request)
  {
    $this->forward404Unless($multipleService = Doctrine::getTable('Act')->find(array($request->getParameter('id'))), sprintf('Object purchase does not exist (%s).', $request->getParameter('id')));
    
  	if($multipleService['monetary_account'] == "0")
  	{
  		$monetaryAccount = null;
  	}
  	else
  	{
  		$monetaryAccount = 1;
  	}
  	
    $this->values = array(
		'designation'   			=> $multipleService['designation'],
		'shortened_designation'     => $multipleService['shortened_designation'],
    	'monetary_account'			=> $monetaryAccount,
    	'quantity'     				=> $multipleService['quantity'],
    	'unity_id'					=> $multipleService['unity_id'],
		'comment'        			=> $multipleService['comment'],
		'act_type_id'        		=> $multipleService['act_type_id'],
	);

	$this->multipleServiceId = $request->getParameter('id');
	
	//Used for the redirection
	if($request->getParameter('index'))
	{
		$this->index = 1;
	}
	else
	{
		$this->index = 0;
	}
	
    $this->form = new MultipleServiceForm($this->values);
    
    $this->form->setWidget('unity_id',new sfWidgetFormInputHidden());
    
    if(!$multipleService['monetary_account'])
    {
    	$this->unity = Doctrine::getTable('Unity')->findOneById($multipleService['unity_id']);
    }
	else
	{
		ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  		$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
  		$this->unity = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getShortenedDesignation();
	}
    
  	$this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
  	$this->form->getWidget('monetary_account')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('quantity')->setAttribute('readonly', 'readonly');
  }   
  
  /**
   * Processes the update of the selected multiple service into the database
   * Uses the function ActTable::updateMultipleService
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeUpdateMultipleService(sfWebRequest $request)
  {
  	$actTable = Doctrine::getTable('Act');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($multipleService = $actTable->find(array($request->getParameter('id'))), sprintf('Object multiple service does not exist (%s).', $request->getParameter('id')));
    
    $this->newValues = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
    	'quantity'     				=> $multipleService['quantity'],
    	'unity_id'					=> $multipleService['unity_id'],
    	'monetary_account'			=> $this->getRequestParameter('monetary_account'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
    
    $this->form = new MultipleServiceForm($this->newValues);

  	//Execute the validators of this form:
	$this->form->bind($this->newValues);

    if ($this->form->isValid())
    {
      $multipleService = $actTable->updateMultipleService($this->newValues,$this->getRequestParameter('id'));
      $this->getUser()->setFlash('notice', 'The predefined multiple service has been updated.');
      $this->redirect('act/index#multiple-services');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
    
    $this->unity = Doctrine::getTable('Unity')->findOneById($multipleService['unity_id']);
    $this->multipleServiceId = $request->getParameter('id');
	$this->index = 0;
    $this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('quantity')->setAttribute('readonly', 'readonly');
    
    
    $this->setTemplate('editMultipleService');
  	
  }
  
  
  /**
   * Disables a predefined multiple service. It still appears in the database but the user cannot see it in the act lists.
   * 
   * @param sfWebRequest $request
   */
  public function executeDeleteMultipleService(sfWebRequest $request)
  {
    $actTable = Doctrine::getTable('Act');
    
    $this->forward404Unless($multipleService = $actTable->find(array($request->getParameter('id'))), sprintf('Object purchase does not exist (%s).', $request->getParameter('id')));

    $actTable->disableAct($this->getRequestParameter('id'));
    
	$this->getUser()->setFlash('notice', 'The predefined multiple service has been deleted.');
    $this->redirect('act/index#multiple-services');
  }
  
  
  
  /*****************************************PURCHASE**********************************************/
  
  /**
   * Creates a new purchase
   * @param sfWebRequest $request
   */
  public function executeCreatePurchase(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PurchaseForm();

    $this->processPurchaseForm($request, $this->form);

    $this->setTemplate('newPurchase');
  }   

  /**
   * Processes the insert of the new purchase into the database
   * Uses the function ActTable::savePurchase
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processPurchaseForm(sfWebRequest $request, sfForm $form)
  {
  	
  	$this->forward404Unless($request->isMethod(sfRequest::POST));
		
	//If the HTTP method is "post", get the values entered by the user:

	$this->values = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
  	
	//Build the form with theses values:
	$this->form = new PurchaseForm($this->values);
		
	//Execute the validators of this form:
	$this->form->bind($this->values);

    if ($this->form->isValid())
    {
      $actTable = Doctrine::getTable('Act');
      $purchase = $actTable->savePurchase($this->values);
      $this->getUser()->setFlash('notice', 'The purchase has been added.');
      $this->redirect('act/index#purchases');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  } 
  
  /**
   * Diplays the current values for the selected predefined purchase
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeEditPurchase(sfWebRequest $request)
  {
    $this->forward404Unless($purchase = Doctrine::getTable('Act')->find(array($request->getParameter('id'))), sprintf('Object purchase does not exist (%s).', $request->getParameter('id')));
    
    $this->values = array(
		'designation'   			=> $purchase['designation'],
		'shortened_designation'     => $purchase['shortened_designation'],
		'comment'        			=> $purchase['comment'],
		'act_type_id'        		=> $purchase['act_type_id'],
	);

	$this->purchaseId = $request->getParameter('id');
	
	//Used for the redirection
	if($request->getParameter('index'))
	{
		$this->index = 1;
	}
	else
	{
		$this->index = 0;
	}
	
    $this->form = new PurchaseForm($this->values);

    $this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
  }  
  
  /**
   * Processes the update of the selected purchase into the database
   * Uses the function ActTable::updatePurchase
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  public function executeUpdatePurchase(sfWebRequest $request)
  {
  	$actTable = Doctrine::getTable('Act');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($purchase = $actTable->find(array($request->getParameter('id'))), sprintf('Object purchase does not exist (%s).', $request->getParameter('id')));
    
    $this->newValues = array(
		'designation'   			=> $this->getRequestParameter('designation'),
		'shortened_designation'     => $this->getRequestParameter('shortened_designation'),
		'comment'        			=> $this->getRequestParameter('comment'),
		'act_type_id'        		=> $this->getRequestParameter('act_type_id'),
		'_csrf_token'  				=> $this->getRequestParameter('_csrf_token'),
	);
    
    $this->form = new PurchaseForm($this->newValues);

  	//Execute the validators of this form:
	$this->form->bind($this->newValues);

    if ($this->form->isValid())
    {
      $purchase = $actTable->updatePurchase($this->newValues,$this->getRequestParameter('id'));
      $this->getUser()->setFlash('notice', 'The predefined purchase has been updated.');
      $this->redirect('act/index#purchases');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
    
	$this->index = 0;
    $this->form->getWidget('designation')->setAttribute('readonly', 'readonly');
    $this->form->getWidget('shortened_designation')->setAttribute('readonly', 'readonly');
    $this->setTemplate('editPurchase');
  }  

  /**
   * Disables a predefined purchase. It still appears in the database but the user cannot see it in the act lists.
   * 
   * @param sfWebRequest $request
   */
  public function executeDeletePurchase(sfWebRequest $request)
  {
    $actTable = Doctrine::getTable('Act');
    
    $this->forward404Unless($purchase = $actTable->find(array($request->getParameter('id'))), sprintf('Object purchase does not exist (%s).', $request->getParameter('id')));

    $actTable->disableAct($this->getRequestParameter('id'));
    
	$this->getUser()->setFlash('notice', 'The predefined purchase has been deleted.');
    $this->redirect('act/index#purchases');
  }
}