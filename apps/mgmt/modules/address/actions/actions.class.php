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
 * address actions.
 *
 * @package    epi
 * @subpackage address
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class addressActions extends sfActions
{ 
  public function executeGetCities(sfWebRequest $request)
  {
  	//We get the parameters of the request
    $q = $request->getParameter('q');
    $limit = $request->getParameter('limit');
    $country = $request->getParameter('country_id');
    
    //If it's a number, we seek a postal code
    if (is_numeric($q))
    {
    	$cities = Doctrine::getTable('AddressCity')->findPostalCode($q, $limit, $country);
    }
    
    //Else we seek the name of a city
    else
    {
    	$cities = Doctrine::getTable('AddressCity')->findCity($q, $limit, $country);
    }
    
    //We put the suggestions in a list, $list. It looks like this :
    //$list[id] = city_name (postal_code)
    $list = array();
    foreach($cities as $city)
    {
    	if($city->getPostalCode())
    	{
      		$list[$city->getId()] = sprintf('%s (%s)', $city->getName(), $city->getPostalCode());
    	}
    	else
    	{
    		$list[$city->getId()] = sprintf('%s', $city->getName());
    	}
    }
    
    //We render the text to the template.
    return $this->renderText(json_encode($list));
  }
}
