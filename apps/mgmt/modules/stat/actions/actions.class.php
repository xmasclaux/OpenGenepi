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

require_once(dirname(__FILE__).'/../../use/lib/ImputationDefaultValues.class.php');

/**
 * stat actions.
 *
 * @package    epi
 * @subpackage stat
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	//We get the parameters which have been possibly added (dates 'from' and 'to'):
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');
  	
  	if(!empty($from) && !empty($to)){
  		$this->from = $from;
  		$this->to = $to;
  		$this->executeAjaxDetailedStat($request, false);
  		$this->setTemplate('detailedStat','stat');
  	}
  	
  	$this->userCulture = $this->getUser()->getCulture();
  }
  
  public function executeAjaxDetailedStat(sfWebRequest $request, $xhr = true)
  {
  	
  	$begin_date = $request->getParameter('from');
  	$end_date = $request->getParameter('to');
  	
  	$this->from = $begin_date;
  	$this->to = $end_date;
  	$this->xhr = $xhr;
  	$this->userCulture = $this->getUser()->getCulture();
  	
  	$countries = Array();
  	$cities = Array();
  	$citiesTable = Array();

  	$imputationsGlobal = Doctrine_Query::create()
	    ->select('COUNT(*) as number, SUM(TIME_TO_SEC(i.duration)) as duration')
	    ->from('ImputationArchive i')
  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
  		->fetchOne();
  	
  	$imputations = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('ImputationArchive i')
  		->where('imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
  		->execute();

  	$numberImputations = $imputationsGlobal->getNumber();
  	$totalDuration = $imputationsGlobal->getDuration();
  	
  	/*Global statistics*/
  	$this->numberImputations = $numberImputations;
	$this->totalTime = $totalDuration;
	
	if($numberImputations != 0)
	{
	  	/*Gender Stats*/
	  	$this->genderStats = Statistics::getDetailedValuesByGender($begin_date,$end_date,$numberImputations);
	  	
	  	/*Age Range Stats*/
	  	$this->ageRangeStats = Statistics::getDetailedValuesByAgeRange($begin_date,$end_date,$numberImputations);
	  	
	  	/*Countries/Cities Stats*/
	  	foreach($imputations as $imputation)
	  	{
	  		$country = $imputation->getUserArchive()->getCountry();
	  		$city = $imputation->getUserArchive()->getCityName();
		  	if(!in_array($country, $countries)) $countries[] = $country;
		  	if(!in_array($city, $citiesTable)) 
		  	{
		  		$citiesTable[] = $city;
		  		$cities[$country][] = $city;
		  	}
	  	}
	  	
	  	$this->countries = $countries;
		$this->cities = $cities;
		$this->countryCityStats = Statistics::getDetailedValuesByCountryAndCity($begin_date,$end_date,$numberImputations);
	
		/*By day/time slot Stats*/
		$this->days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		
		$dayStats = Statistics::getDetailedValuesByDay($begin_date,$end_date,$numberImputations);
		$this->dayStats = $dayStats;
		
		$timeslots = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
		
		// KYXAR 0010 : Changement du nom de la fonction getDetailedValuesByTimeSlot -> getDetailedValuesByDaysAndTimeSlot
		//$this->dayAndTimeSlotStats = Statistics::getDetailedValuesByTimeSlot($begin_date,$end_date);
		$this->dayAndTimeSlotStats = Statistics::getDetailedValuesByDaysAndTimeSlot($begin_date,$end_date);
		
		// KYXAR 0010 : Appel de la nouvelle fonction getDetailedValuesByTimeSlot
		$this->TimeSlotStats = Statistics::getDetailedValuesByTimeSlot($begin_date, $end_date);
		
		$hours[$timeslots[0]] = Array('8h-9h','9h-10h','10h-11h','11h-12h');
	  	$hours[$timeslots[1]] = Array('12h-13h','13h-14h','14h-15h','15h-16h');
	  	$hours[$timeslots[2]] = Array('16h-17h','17h-18h','18h-19h','19h-20h');
	  	$hours[$timeslots[3]] = Array('20h-21h','21h-22h','22h-23h','23h-24h');
		$this->timeslots = $timeslots;
	  	$this->hours = $hours;
		
	  	$this->hourStats = Statistics::getDetailedValuesByHour($begin_date,$end_date,$dayStats);
		
	  	/*By public categories*/
	  	$this->publicCategoryStats = Statistics::getDetailedValuesByPublicCategory($begin_date,$end_date,$numberImputations);
	
	  	/*By act*/
	  	$this->actStats = Statistics::getDetailedValuesByAct($begin_date,$end_date,$numberImputations);
	  	
	  	/*By SEG*/
	  	$this->segStats = Statistics::getDetailedValuesBySeg($begin_date,$end_date,$numberImputations);
	  	
	  	/*By building/room/computer*/
	  	$this->buildingStats = Statistics::getDetailedValuesByBuilding($begin_date,$end_date,$numberImputations);
	  	$this->roomStats = Statistics::getDetailedValuesByRoom($begin_date,$end_date);
	  	$this->computerStats = Statistics::getDetailedValuesByComputer($begin_date,$end_date);
	  	
	  	/*By type of connection*/
	  	$this->typeOfConnectionStats = Statistics::getDetailedValuesByTypeOfConnection($begin_date,$end_date);
	  	
	  	/*By way of awareness*/
	  	$this->awarenessStats = Statistics::getDetailedValuesByAwareness($begin_date,$end_date,$numberImputations);
	}
	
	else
	{
		$this->getUser()->setFlash('notice','No uses found between these two dates.');
		$this->setTemplate('index','stat');
	}
	
  	$this->setTemplate('detailedStat','stat');
  }
  
  
  /**
   * 
   * @param sfWebRequest $request
   */
  public function executeBalanceIndex(sfWebRequest $request){
  	
  	//We get the parameters which have been possibly added (dates 'from' and 'to'):
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');
  	
  	if(!empty($from) && !empty($to)){
  		$this->executeBalance($request, false);
  		$this->setTemplate('balance','stat');
  	}
  	
  	$this->from = $from;
  	$this->to = $to;
  	$this->userCulture = $this->getUser()->getCulture();
  }
  
  
  /**
   * 
   * @param sfWebRequest $request
   */
  public function executeBalance(sfWebRequest $request, $xhr = true){
  	
  	$this->userCulture = $this->getUser()->getCulture();
  	
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');

  	$this->from = $from;
  	$this->to = $to;
  	
  	$this->xhr = $xhr;
  	
  	$this->currency_symbol = ImputationDefaultValues::getDefaultCurrencySymbol();
  	
  	$this->positive_accounts = Statistics::getPositiveAccounts();
  	$this->negative_accounts = Statistics::getNegativeAccounts();
  	$total_accounts['value'] = $this->positive_accounts['value'] + $this->negative_accounts['value'];
  	$total_accounts['number'] = $this->positive_accounts['number'] + $this->negative_accounts['number'];
	
  	$this->total_accounts = $total_accounts;
  	
  	$this->methods_of_payments_values = Statistics::getTotalValuesByMethodOfPayment($from, $to);
  	
  	$this->acts_values = Statistics::getValuesByAct($from, $to);
  }
  
  
  /**
   * 
   * @param sfWebRequest $request
   */
  public function executeExportIndex(sfWebRequest $request){
  	
  	$this->userCulture = $this->getUser()->getCulture();
  	
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');

  	$this->from = $from;
  	$this->to = $to;
  	
  	$this->form = new StatExportForm();
  	
  }
  
  /**
   * 
   * @param sfWebRequest $request
   * @param string $ressource
   */
  public function executeExport(sfWebRequest $request){
  	
  	 $this->forward404Unless($request->isMethod(sfRequest::POST));
  	 
     $this->form = new StatExportForm();
     
     return $this->processExport($request, $this->form);
  }
  
  
  /**
   * 
   * @param sfWebRequest $request
   * @param StatExportForm $form
   */
  protected function processExport(sfWebRequest $request, StatExportForm $form){
  	
  	//We get the parameters:
  	$req_param = $request->getParameter($form->getName());
  	
  	$req_param['from'] = $request->getParameter('formattedFrom');
  	$req_param['to'] = $request->getParameter('formattedTo');
  	
  	//Check if there is imputations between the dates that have been specified:
  	$imputationsGlobal = Doctrine_Query::create()
	    ->select('COUNT(*) as number')
	    ->from('ImputationArchive i')
  		->where('i.imputation_date BETWEEN ? AND ?',array($req_param['from'], $req_param['to']))
  		->fetchOne();
  	$numberImputations = $imputationsGlobal->getNumber();
  	
  	//If any, process to the export:
  	if(($numberImputations != 0) || ($req_param['ressource'] == ExportDocument::BALANCE_RESSOURCE)){
 
	  	$export = ExportDocument::instanciateDocument($req_param['format'], $this->getUser()->getCulture());
	  	
	  	$export->export($req_param['ressource'], $req_param['from'], $req_param['to']);
	
	  	return sfView::NONE;
	  	
  	}else{
  		//Else, inform the user:
  		$this->getUser()->setFlash('notice','No uses found between these two dates.');
  		$this->setTemplate('exportIndex');
  		
  	}
  }
  
  
  public function executeQuantitativeStatementIndex(sfWebRequest $request)
  {
  	//We get the parameters which have been possibly added (dates 'from' and 'to'):
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');
  	
  	if(!empty($from) && !empty($to)){
  		$this->from = $from;
  		$this->to = $to;
  	}
  	
  	$this->userCulture = $this->getUser()->getCulture();
  }
  
  public function executeQuantitativeStatement(sfWebRequest $request)
  {
  	$from = $request->getParameter('formattedFrom');
  	$to = $request->getParameter('formattedTo');
  	
  	$countries = array();
  	$citiesTable = array();
  	$cities = array();
  	
  	$this->acts = Doctrine_Query::create()
		->select('a.designation')
		->from('Act a')
		->where('a.disabled = ?', 0)
		->orderBy('a.designation')
		->execute();
		
	$this->numberOfActs = Doctrine_Query::create()
	    ->select('COUNT(*) as total')
	    ->from('Act a')
		->where('a.disabled = ?', 0)
  		->fetchOne();
  	
  	$imputations = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('ImputationArchive i')
  		->where('imputation_date BETWEEN ? AND ?',array($from,$to))
  		->execute();	
  		
  	foreach($imputations as $imputation)
  	{
  		$country = $imputation->getUserArchive()->getCountry();
  		$city = $imputation->getUserArchive()->getCityName();
	  	if(!in_array($country, $countries)) $countries[] = $country;
	  	if(!in_array($city, $citiesTable)) 
	  	{
	  		$citiesTable[] = $city;
	  		$cities[$country][] = $city;
	  	}
  	}
	  	
	$this->countries = $countries;
	$this->cities = $cities;	
  		
	$this->statement = Statistics::getQuantitativeStatementValuesByAct($from,$to);
	$this->detailsPerCategory = Statistics::getQuantitativeDetailsPerCategory($from, $to);
	$this->detailsPerTimeSlot = Statistics::getQuantitativeDetailsPerTimeSlot($from, $to);
  	$this->total = Statistics::getTotalQuantitativeStatementValues($from,$to);
	
	$this->columns = Statistics::getQuantitativeStatementColumns($from,$to);
	
	$this->from = $from;
	$this->to = $to;
	
  	$this->setLayout('emptyLayout');
  }

  public function executeTemporalStatementIndex(sfWebRequest $request)
  {
  	//We get the parameters which have been possibly added (dates 'from' and 'to'):
  	$from = $request->getParameter('from');
  	$to = $request->getParameter('to');
  	
  	if(!empty($from) && !empty($to)){
  		$this->from = $from;
  		$this->to = $to;
  	}
  	
  	$this->userCulture = $this->getUser()->getCulture();
  }  
  
  public function executeTemporalStatement(sfWebRequest $request)
  {
  	$from = $request->getParameter('formattedFrom');
  	$to = $request->getParameter('formattedTo');
  	
  	$countries = array();
  	$citiesTable = array();
  	$cities = array();
  	
  	$this->acts = Doctrine_Query::create()
		->select('a.designation')
		->from('Act a')
		->where('a.disabled = ?', 0)
		->orderBy('a.designation')
		->execute();
		
	$this->numberOfActs = Doctrine_Query::create()
	    ->select('COUNT(*) as total')
	    ->from('Act a')
		->where('a.disabled = ?', 0)
  		->fetchOne();
  	
  	$imputations = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('ImputationArchive i')
  		->where('imputation_date BETWEEN ? AND ?',array($from,$to))
  		->execute();	
  		
  	foreach($imputations as $imputation)
  	{
  		$country = $imputation->getUserArchive()->getCountry();
  		$city = $imputation->getUserArchive()->getCityName();
	  	if(!in_array($country, $countries)) $countries[] = $country;
	  	if(!in_array($city, $citiesTable)) 
	  	{
	  		$citiesTable[] = $city;
	  		$cities[$country][] = $city;
	  	}
  	}
	  	
	$this->countries = $countries;
	$this->cities = $cities;	
  		
	$this->statement = Statistics::getTemporalStatementValuesByAct($from,$to);
	$this->detailsPerCategory = Statistics::getTemporalDetailsPerCategory($from, $to);
	$this->detailsPerTimeSlot = Statistics::getTemporalDetailsPerTimeSlot($from, $to);
  	$this->total = Statistics::getTotalTemporalStatementValues($from,$to);
	
	$this->columns = Statistics::getTemporalStatementColumns($from,$to);
	
	$this->from = $from;
	$this->to = $to;
	
  	$this->setLayout('emptyLayout');
  }
  
  public function executeUploadIndex(sfWebRequest $request)
  {
  
  	$this->last_upload = Upload::readUploadParameters();
  	
  }
  
  public function executeUpload(sfWebRequest $request)
  {
  	$last_upload = Upload::readUploadParameters();
    Upload::exportToSql($last_upload);

  	Upload::editUploadParameters();
  	
  	$this->getUser()->setFlash('notice','Your statistics have been uploaded on the server.');
  	$this->redirect('stat/index');
  }
  
  public function executeDownload(sfWebRequest $request)
  {
    $last_upload = Upload::readUploadParameters();
    
    $structure = Doctrine::getTable('Structure')
      	->createQuery('a')
      	->fetchOne();
  	
  	$fileName = $structure->getName().'&'.$structure->getAddress()->getStreet().'&'.$structure->getAddress()->getAddressCity()->getPostalCode().'&'.$structure->getAddress()->getAddressCity()->getName().'&'.$structure->getAddress()->getAddressCity()->getAddressCountry()->getName();
  	
  	$this->fileName = Upload::rewrite(utf8_decode($fileName));
  	
  	$this->usersStatistics = Doctrine_Query::create()
		    ->select('*')
		    ->from('UserArchive')
		    ->execute();

    $this->usesStatistics = Doctrine_Query::create()
		    ->select('*')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array(date('Y-m-d', strtotime($last_upload)),date('Y-m-d')))
	  		->execute();
    
  	Upload::editUploadParameters();
  	
  	$this->setLayout(false);
  }
  
}