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
 * dashboard actions.
 *
 * @package    epi
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

  	//We check if there is modules which have not been activated:
  	if($this->getContext()->get('Kernel')->getUnsatisfiedDependencies()){
  		$this->getUser()->setFlash('error','Some modules are not activated because dependencies are missing. Please go to the configuration menu to correct theses issues.',false);
  	}

    // -----------------------------------------------------------------------------------------------------------
    // KYXAR 0006 - 30/06/2011
    // Modification des libellés du nombre d'abonnements valides sur le tableau de bord
    $todayDate = strftime("%Y%m%d");
  	// KYXAR 0006 - 30/06/2011
    // -----------------------------------------------------------------------------------------------------------
    $beginningDate = strftime("%Y%m%d",mktime(0,0,0,date("m"),1,date("Y")));
    $endDate = strftime("%Y%m%d",mktime(0,0,0,date("m")+1,0,date("Y")));
  	$firstDayOfNextMonth = strftime("%Y%m%d",mktime(0,0,0,date("m")+1,1,date("Y")));
  	$numberOfValidSubscriptionsBeginning = 0;
  	$numberOfValidSubscriptionsEnd = 0;
  	$numberOfUsesPerCategory = array();
  	$numberOfUses = 0;
  	$totalDuration = 0;

  	/*We get the public categories*/
  	$publicCategories = Doctrine_Query::create()
      	->select('a.*')
    	->from('ActPublicCategory a')
    	->orderBy('a.sort_order')
    	->execute();

	/*We count the number of visits*/
  	$numberVisits = Doctrine_Query::create()
  		->from('Imputation i')
  		->where('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
  		->addWhere('i.imputation_type <> ?', 1)
	    ->count();

	/*We count the number of unique visitors*/
	$numberOfUniqueVisitors = Doctrine_Query::create()
  		->from('Imputation i')
  		->where('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
  		->groupBy('i.user_id')
  		->count();

  	$numberOfRegularVisitors = Doctrine_Query::create()
  		->from('Imputation i')
  		->where('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
  		->groupBy('i.user_id, i.user_id HAVING COUNT(*)>1')
  		->count();

	/*We count the total of the checkout*/
	$checkoutTotal = Doctrine_Query::create()
		->select('sum(i.total)')
   		->from('Imputation i')
  		->where('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
  		->fetchArray();

  	/*We get all the subscriptions*/
  	$subscriptions = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('Imputation i')
	    ->where('i.imputation_type = ?', "5")
	    ->execute();

	/*For each subscription, we compare its end date to the beginning date and the end date*/
	foreach ($subscriptions as $subscription)
	{
		$subscriptionFinalDateQuery = Doctrine::getTable('ImputationSubscription')->findOneByImputationId($subscription->getId());

		// -----------------------------------------------------------------------------------------------------------
        // KYXAR 0005 - 30/06/2011
        // Correction du nombre d'abonnements valides
        $beginOfSubscription = strtotime($subscription->getDate());
		$endOfSubscription = strtotime($subscriptionFinalDateQuery->getFinalDate());

	    if(($beginOfSubscription <= strtotime($todayDate)) && ($endOfSubscription >= strtotime($todayDate)))
	    {
	    	$numberOfValidSubscriptionsBeginning++;
	    }

	    if (($beginOfSubscription <= strtotime($endDate)) && ($endOfSubscription >= strtotime($endDate)))
	    {
	    	$numberOfValidSubscriptionsEnd++;
	    }
        // FIN KYXAR 0005 - 30/06/2011
        // -----------------------------------------------------------------------------------------------------------
	}

	/*We get all the uses (expected the transaction on an account uses*/
  	$uses = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('Imputation i')
	    ->where('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
  		->addWhere('i.imputation_type <> ?', 1)
	    ->execute();

	foreach ($publicCategories as $publicCategory)
	{
	    $numberOfUsesPerCategory[$publicCategory->getId()] = 0;
	    $timePerCategory[$publicCategory->getId()] = 0;
	}
	$numberOfUsesPerCategory[0] = 0;
	$timePerCategory[0] = 0;

	foreach ($uses as $use)
	{
		$numberOfUses++;

		if($use->getUserId() != null)
		{
			$user = Doctrine::getTable('User')->findOneById($use->getUserId());

			if($user->getActPublicCategoryId() != null)
			{
				$numberOfUsesPerCategory[$user->getActPublicCategoryId()]++;
			}
			else
			{
				$numberOfUsesPerCategory[0]++;
			}
		}
		else
		{
			$numberOfUsesPerCategory[0]++;
		}
	}

	/*We get all the unitary services (services with a time)*/
  	$unitaryServices = Doctrine_Query::create()
	    ->select('i.*')
	    ->from('Imputation i')
	    ->where('i.imputation_type = ?', "4")
	    ->addWhere('i.date >= ?', $beginningDate)
  		->addWhere('i.date < ?', $firstDayOfNextMonth)
	    ->execute();

	foreach($unitaryServices as $unitaryService)
	{
		$imputationUnitaryService = Doctrine::getTable('ImputationUnitaryService')->findOneByImputationId($unitaryService->getId());
		$beginningTime = $imputationUnitaryService->getBeginningTime();
		$endTime = $imputationUnitaryService->getEndTime();

		$duration = round((strtotime($endTime)-strtotime($beginningTime))/3600,1);

		if($unitaryService->getUserId() != null)
		{
			$user = Doctrine::getTable('User')->findOneById($unitaryService->getUserId());

			if($user->getActPublicCategoryId() != null)
			{
				$timePerCategory[$user->getActPublicCategoryId()] += $duration;
			}
			else
			{
				$timePerCategory[0] += $duration;
			}
		}
		else
		{
			$timePerCategory[0] += $duration;
		}

		$totalDuration += $duration;
	}

	/*Send to the template*/
	$this->beginningDate = $beginningDate;
	$this->endDate = $endDate;
	$this->numberOfVisits = $numberVisits;
	$this->numberOfUniqueVisitors = $numberOfUniqueVisitors;
	$this->numberOfRegularVisitors = $numberOfRegularVisitors;
	$this->checkoutTotal = round($checkoutTotal[0]['sum'],2);
	$this->numberOfValidSubscriptionsBeginning = $numberOfValidSubscriptionsBeginning;
	$this->numberOfValidSubscriptionsEnd = $numberOfValidSubscriptionsEnd;
	$this->numberOfUsesPerCategory = $numberOfUsesPerCategory;
	$this->publicCategories = $publicCategories;
	$this->numberOfUses = $numberOfUses;
	$this->totalDuration = $totalDuration;
	$this->timePerCategory = $timePerCategory;

	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getDesignation();
  }

  /*Manage a 404 error*/
  public function execute404Error(sfWebRequest $request)
  {
	/*A log line is added*/
	$this->getContext()->get('Kernel')->addLog("error", "Login \"".sfContext::getInstance()->getUser()->getAttribute('login')."\" had a 404 error.");

	/* A flash message is set*/
	$this->getUser()->setFlash('error', 'Error 404: Page not found.', true);

	/*The user is redirected to the index page */
	$this->redirect('dashboard/index') ;
  }
}
