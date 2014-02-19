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
 * act_price actions.
 *
 * @package    epi
 * @subpackage act_price
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class act_priceActions extends sfActions
{
	
  public function executeIndex(sfWebRequest $request)
  {
    $acts = Doctrine::getTable('Act')
      ->createQuery()
      ->select('a.*')
	  ->from('Act a')
	  ->where('a.disabled <> 1')
	  ->orderBy('a.shortened_designation')
	  ->execute();
      
    $publicCategories = Doctrine::getTable('ActPublicCategory')
      ->createQuery()
      ->select('ap.*')
	  ->from('ActPublicCategory ap')
	  ->orderBy('ap.sort_order')
      ->execute();
	
    $actPrices_query = Doctrine_Query::create()
	      	->select('a.*')
	    	->from('ActPrice a');
    $actPrices_res = $actPrices_query->fetchArray();
    
    $actPrices = array();
    
    foreach($actPrices_res as $price){
    	$actPrices[$price['act_id']][$price['act_public_category_id']] = $price['value'];
    }
    	
    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');
	
	$errorArray = null;
	
	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getDesignation();
	$this->price = $actPrices;
	$this->acts = $acts;
	$this->publicCategories = $publicCategories;
	$this->errorArray = $errorArray;
  }

  
  public function executeUpdateActPrices(sfWebRequest $request)
  {
	$acts = Doctrine::getTable('Act')
      ->createQuery()
      ->select('a.*')
	  ->from('Act a')
	  ->where('a.disabled <> 1')
	  ->execute();
      
    $publicCategories = Doctrine::getTable('ActPublicCategory')
      ->createQuery()
      ->select('ap.*')
	  ->from('ActPublicCategory ap')
	  ->orderBy('ap.sort_order')
      ->execute();
  	
    $noError = 1;
    
    $errorArray = array();
    
    //We get the modified cells
    $modifiedCellsRequest = $request->getParameter('modifiedCells');
    
    $modifiedCells = explode(",",$modifiedCellsRequest);
    
    //If some cells have been modified
    if ($modifiedCellsRequest != null)
    {
	   	foreach ($modifiedCells as $modifiedCell)
	   	{
	   		$exploded = explode("_",$modifiedCell);
	   		$actId = $exploded[1];
	   		$actPublicCategoryId = $exploded[2];
	   		
	   		$newPrice = $request->getParameter('price_'.$actId.'_'.$actPublicCategoryId);
	   		
	   		$newPrice = strtr($newPrice,",",".");
	      	$convert = array(" " => "");
			$newPrice = strtr($newPrice,$convert);
	   		
	   		$correctInsert = 0;
	
	      	if(is_numeric($newPrice))
	      	{
	      		$priceToInsert = $newPrice;
	      		$correctInsert = 1;
	      	}
	      	
	   		else if(!strcmp($newPrice,""))
	      	{
	      		$priceToInsert = -1;
	      		$correctInsert = 1;
	      	}
	      	
	   		else
	      	{
	      		$this->getUser()->setFlash('error', 'You made a mistake on one or several price(s). If you have any problem, click on the Help button.', false);
	      		$noError = 0;
	      		$errorArray[$actId][$actPublicCategoryId] = $newPrice;
	      	}
	      	
	   		if($correctInsert)
	      	{
		      	$updatedActPrice = Doctrine::getTable('ActPrice')->findOneByActIdAndActPublicCategoryId($actId,$actPublicCategoryId);
		      	$updatedActPrice->setValue($priceToInsert);
		      	$updatedActPrice->save();
	      	}
	   	}
	   	
		if($noError)
		{
			$this->getUser()->setFlash('notice', 'The prices have been updated.', false);
		}
    }
    
    $actPrices_query = Doctrine_Query::create()
	      	->select('a.*')
	    	->from('ActPrice a');
    $actPrices_res = $actPrices_query->fetchArray();
    
  	$actPrices = array();
    
    foreach($actPrices_res as $price){
    	$actPrices[$price['act_id']][$price['act_public_category_id']] = $price['value'];
    }
    
	/*Redirect*/
	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
	$defaultCurrencyId = ParametersConfiguration::getDefault('default_currency');

	$this->defaultCurrency = Doctrine::getTable('Unity')->findOneById($defaultCurrencyId)->getDesignation();
	$this->price = $actPrices;
	$this->acts = $acts;
	$this->publicCategories = $publicCategories;
	$this->errorArray = $errorArray;
	
    $this->setTemplate('index');
  }
  
}