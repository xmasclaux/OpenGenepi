<?php

/**
 * Copyright 2010 Pierre Boitel, Bastien Libersa, Paul PÃ©riÃ©
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

abstract class Statistics {
	
	/**
	 * 
	 * @return unknown
	 */
	public static function getPositiveAccounts(){
		
		$to_return = array();
		
		$positive_accounts = Doctrine_Query::create()
	  		->select('SUM(a.value) as value, COUNT(*) as number')
	  		->from('Account a')
	  		->where('a.monetary_account = ?', 1)
	  		->addWhere('a.value > ?', 0)
	  		->fetchOne();

  		$to_return['value'] = is_null($value = $positive_accounts->getValue())? 0: $value;
  		$to_return['number'] = $positive_accounts->getNumber();
  		
  		return $to_return;
  		
	}
	
	/**
	 * 
	 */
	public static function getNegativeAccounts(){
		
		$to_return = array();
		
		$negative_accounts = Doctrine_Query::create()
	  		->select('SUM(a.value) as value, COUNT(*) as number')
	  		->from('Account a')
	  		->where('a.monetary_account = ?', 1)
	  		->addWhere('a.value < ?', 0)
	  		->fetchOne();
  		
  		$to_return['value'] = is_null($value = $negative_accounts->getValue())? 0: $value;
  		$to_return['number'] = $negative_accounts->getNumber();
  		
  		return $to_return;
	}
	
	
	/**
	 * 
	 * @param $begin_date
	 * @param $end_date
	 */
	public static function getTotalValuesByMethodOfPayment($begin_date, $end_date){
		
		$to_return = array();
		$to_return['mop'] = array();
		$total_value = 0;
		$max_value = -PHP_INT_MAX;
		$min_value = PHP_INT_MAX;
		
		//First, we get all the methods of payment designations:
		$methods = Doctrine_Query::create()
			->select('m.designation')
			->from('ImputationMethodOfPayment m')
			->orderBy('m.sort_order')
			->execute();
			
		/*Then, for each method of payment we have, we calculate the total price of each
		  imputation that have been done using this method of payment:*/
		foreach($methods as $method_of_payment){
			
			$to_return['mop'][$method_of_payment->getDesignation()] = array();
			
			//We get all the imputations summing the prices:
			$value = Doctrine_Query::create()
				->select('SUM(a.price) as value')
				->from('ImputationArchive a')
				->where('a.method_of_payment = ?', $method_of_payment->getDesignation())
				->andWhere('a.imputation_date BETWEEN ? AND ?',array($begin_date, $end_date))
				->fetchOne();
				
			//We affect this value into the result array:
			$to_return['mop'][$method_of_payment->getDesignation()]['value'] = is_null($val = round($value->getValue(),1))? 0: $val;
			
			//update the total value:
			$total_value += $to_return['mop'][$method_of_payment->getDesignation()]['value'];
			
			
			//update the min and max values if necessary:
			if(($to_return['mop'][$method_of_payment->getDesignation()]['value'] > $max_value)
				&& ($to_return['mop'][$method_of_payment->getDesignation()]['value'] != 0)){
					
				$max_value = $to_return['mop'][$method_of_payment->getDesignation()]['value'];
				
			}
			
			if(($to_return['mop'][$method_of_payment->getDesignation()]['value'] < $min_value)
				&& ($to_return['mop'][$method_of_payment->getDesignation()]['value'] != 0)){
					
				$min_value = $to_return['mop'][$method_of_payment->getDesignation()]['value'];
				
			}
		}
		
		$to_return['max'] = $max_value;
		$to_return['min'] = $min_value;
		$to_return['total_value'] = $total_value;
		
		
		/*To finish, for each method of payment we have, we calculate the percentage (in value)
		  of this method of payment.*/
		foreach($to_return['mop'] as $method_of_payment_des => $method_of_payment_datas){
			
			//Be careful of the case: none imputations have been done:
			if($total_value != 0){
				$to_return['mop'][$method_of_payment_des]['percentage'] = 
							($to_return['mop'][$method_of_payment_des]['value'] * 100) / $total_value;
							
				$to_return['mop'][$method_of_payment_des]['percentage'] = round($to_return['mop'][$method_of_payment_des]['percentage'], 1);
			}else{
				$to_return['mop'][$method_of_payment_des]['percentage'] = 0;
			}
		}
		
		return $to_return;
	}
	
	
	/**
	 * 
	 * @param $begin_date
	 * @param $end_date
	 */
	public static function getValuesByAct($begin_date, $end_date){
		
		$to_return = array();
		$to_return['act'] = array();
		$total_value = 0;
		$total_time = 0;
		$max_value = -PHP_INT_MAX;
		$min_value = PHP_INT_MAX;
		$max_time = -PHP_INT_MAX;
		$min_time = PHP_INT_MAX;
		
		//First, we get all the methods of payment designations:
		$act_designations = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();
			
			
		foreach($act_designations as $act_des){
			
			//We get all the imputations summing the prices and the durations:
			$value = Doctrine_Query::create()
				->select('SUM(a.price) as value, SUM(TIME_TO_SEC(a.duration)) as duration')
				->from('ImputationArchive a')
				->where('a.designation = ?', $act_des->getDesignation())
				->andWhere('a.imputation_date BETWEEN ? AND ?',array($begin_date, $end_date))
				->fetchOne();
				
				
			//We affect the value into the result array:
			$to_return['act'][$act_des->getDesignation()]['value'] = is_null($val = round($value->getValue(),1))? 0: $val;
			
			//We affect the duration into the result array:
			$to_return['act'][$act_des->getDesignation()]['time'] = is_null($time = intval($value->getDuration()))? 0: $time;

			//update the total value:
			$total_value += $to_return['act'][$act_des->getDesignation()]['value'];
			
			//update the total time
			$total_time += $to_return['act'][$act_des->getDesignation()]['time'];
			
			//update the min and max values if necessary:
			if(($to_return['act'][$act_des->getDesignation()]['value'] > $max_value)
				&& ($to_return['act'][$act_des->getDesignation()]['value'] != 0)){
					
				$max_value = $to_return['act'][$act_des->getDesignation()]['value'];
				
			}
			
			if(($to_return['act'][$act_des->getDesignation()]['value'] < $min_value)
				&& ($to_return['act'][$act_des->getDesignation()]['value'] != 0)){
					
				$min_value = $to_return['act'][$act_des->getDesignation()]['value'];
				
			}
			
			
			//update the min and max times if necessary:
			if(($to_return['act'][$act_des->getDesignation()]['time'] > $max_time)
				&& ($to_return['act'][$act_des->getDesignation()]['time'] != 0)){
					
				$max_time = $to_return['act'][$act_des->getDesignation()]['time'];
				
			}
			
			if(($to_return['act'][$act_des->getDesignation()]['time'] < $min_time)
				&& ($to_return['act'][$act_des->getDesignation()]['time'] != 0)){
					
				$min_time = $to_return['act'][$act_des->getDesignation()]['time'];
				
			}

		}
		
		$to_return['max'] = $max_value;
		$to_return['min'] = $min_value;
		$to_return['max_time'] = $max_time;
		$to_return['min_time'] = $min_time;
		$to_return['total_time'] = $total_time;
		$to_return['total_value'] = $total_value;
		

		/*To finish, for each method of payment we have, we calculate the percentage (in value)
		  of this method of payment.*/
		foreach($to_return['act'] as $act_des => $act_datas){
			
			//Be careful of the case: none imputations have been done:
			if($total_value != 0){
				$to_return['act'][$act_des]['percentage'] = 
							($to_return['act'][$act_des]['value'] * 100) / $total_value;
							
				$to_return['act'][$act_des]['percentage'] = round($to_return['act'][$act_des]['percentage'], 1);
				
			}else{
				$to_return['act'][$act_des]['percentage'] = 0;
			}
		}
		
		return $to_return;
	}
	
	
	public static function getDetailedValuesByGender($begin_date, $end_date, $numberImputations)
	{
		$maleUses = Doctrine_Query::create()
		    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->leftJoin('i.UserArchive u')
	  		->andWhere('u.gender = ?',"Male")
	  		->fetchOne();
	  		
		$femaleUses = Doctrine_Query::create()
		    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->leftJoin('i.UserArchive u')
	  		->andWhere('u.gender = ?',"Female")
	  		->fetchOne();
	  		
	    $genderStats['female'][0] = $femaleUses->getTotal();
	    $genderStats['female'][1] = round($femaleUses->getTotal()/$numberImputations,3)*100;
	    $genderStats['female'][2] = $femaleUses->getDuration();
	    
  		$genderStats['male'][0] = $maleUses->getTotal();
  		$genderStats['male'][1] = round($maleUses->getTotal()/$numberImputations,3)*100;
  		$genderStats['male'][2] = $maleUses->getDuration();
  		
  		if($maleUses->getTotal()>$femaleUses->getTotal()) $genderStats['maxUses'] = $maleUses->getTotal();
  		else $genderStats['maxUses'] = $femaleUses->getTotal();
  	
  		if($maleUses->getDuration()>$femaleUses->getDuration()) $genderStats['maxTime'] = $maleUses->getDuration();
  		else $genderStats['maxTime'] = $femaleUses->getDuration();
  		
  		return $genderStats;
  		
	}
	
	public static function getDetailedValuesByAgeRange($begin_date,$end_date,$numberImputations)
	{
		$imputations = Doctrine_Query::create()
		    ->select('*')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
		
	  	$ageRangeStats[0][0] = "<= 10";
  		$ageRangeStats[1][0] = "11 - 20";
  		$ageRangeStats[2][0] = "21 - 30";
  		$ageRangeStats[3][0] = "31 - 40";
  		$ageRangeStats[4][0] = "41 - 50";
  		$ageRangeStats[5][0] = "51 - 60";
  		$ageRangeStats[6][0] = "61 - 70";
  		$ageRangeStats[7][0] = "71 - 80";
  		$ageRangeStats[8][0] = "> 80";	
	  	
		for($i=0;$i<9;$i++)
  		{
	  		$ageRangeStats[$i][1] = 0;
	  		$ageRangeStats[$i][2] = 0;
	  		$ageRangeStats[$i][3] = 0;
  		}
  		
	  	foreach($imputations as $imputation)
	  	{
	  		$imputationDate = strtotime($imputation->getImputationDate());
  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
	  		$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");

	  		switch($age)
	  		{
	  			case ($age <= 10) :
					$ageRangeStats[0][1]++;
					$ageRangeStats[0][3] += $duration;
	  			break;
	  			case ($age > 10 AND $age <= 20) :
					$ageRangeStats[1][1]++;
					$ageRangeStats[1][3] += $duration;
	  			break;
	  			case ($age > 20 AND $age <= 30) :
					$ageRangeStats[2][1]++;
					$ageRangeStats[2][3] += $duration;
	  			break;
	  			case ($age > 30 AND $age <= 40) :
					$ageRangeStats[3][1]++;
					$ageRangeStats[3][3] += $duration;
	  			break;
	  			case ($age > 40 AND $age <= 50) :
					$ageRangeStats[4][1]++;
					$ageRangeStats[4][3] += $duration;
	  			break;
	  			case ($age > 50 AND $age <= 60) :
					$ageRangeStats[5][1]++;
					$ageRangeStats[5][3] += $duration;
	  			break;
	  			case ($age > 60 AND $age <= 70) :
					$ageRangeStats[6][1]++;
					$ageRangeStats[6][3] += $duration;
	  			break;
	  			case ($age > 70 AND $age <= 80) :
					$ageRangeStats[7][1]++;
					$ageRangeStats[7][3] += $duration;
	  			break;
	  			default :
	  				$ageRangeStats[8][1]++;
	  				$ageRangeStats[8][3] += $duration;
	  			break;
	  		}
	  	}
	  	
	  	for($i=0;$i<9;$i++)
	  	{
	  		$ageRangeStats[$i][2] = round($ageRangeStats[$i][1]/$numberImputations,3)*100;
	  	}

	  	$ageRangeStats[0]['maxUses'] = -PHP_INT_MAX;
	  	$ageRangeStats[0]['minUses'] = PHP_INT_MAX;
	  	$ageRangeStats[0]['maxTime'] = -PHP_INT_MAX;
	  	$ageRangeStats[0]['minTime'] = PHP_INT_MAX;
	  	
		for($i=0;$i<9;$i++)
	  	{
	  		if(($ageRangeStats[$i][1] > $ageRangeStats[0]['maxUses'])) $ageRangeStats[0]['maxUses'] = $ageRangeStats[$i][1];
	  			
	  		if(($ageRangeStats[$i][1] < $ageRangeStats[0]['minUses']) && ($ageRangeStats[$i][1] != 0)) $ageRangeStats[0]['minUses'] = $ageRangeStats[$i][1];
	  			
	  		if(($ageRangeStats[$i][3] > $ageRangeStats[0]['maxTime'])) $ageRangeStats[0]['maxTime'] = $ageRangeStats[$i][3];
	  			
	  		if(($ageRangeStats[$i][3] < $ageRangeStats[0]['minTime']) && ($ageRangeStats[$i][3] != 0)) $ageRangeStats[0]['minTime'] = $ageRangeStats[$i][3];
	  	}
	  	return $ageRangeStats;	
	}
	
	
	public static function getDetailedValuesByCountryAndCity($begin_date,$end_date,$numberImputations)
	{
		$countries = Array();
		$cities = Array();
		
		$citiesReq = Doctrine_Query::create()
		    ->select('i.*, u.city_name as city, u.country as country')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->leftJoin('i.UserArchive u')
	  		->execute();
	  		
	  	foreach($citiesReq as $city)
	  	{
	  		$duration = strtotime($city->getDuration())-strtotime("00:00:00");
	  		
	  		if(!isset($countryCityStats[$city->getCountry()][$city->getCity()]))
	  		{
	  			$countryCityStats[$city->getCountry()][$city->getCity()][0] = 1;
	  			$countryCityStats[$city->getCountry()][$city->getCity()][2] = $duration;
	  		}
	  		
	  		else
	  		{
	  			$countryCityStats[$city->getCountry()][$city->getCity()][0]++;
	  			$countryCityStats[$city->getCountry()][$city->getCity()][2] += $duration;
	  		}
	  	}
	  	
	  	foreach($citiesReq as $city)
	  	{
	  		$countryCityStats[$city->getCountry()][$city->getCity()][1] = round($countryCityStats[$city->getCountry()][$city->getCity()][0]/$numberImputations,3)*100;

	  		$countryCityStats[$city->getCountry()][$city->getCity()]['maxUses'] = -PHP_INT_MAX;
	  		$countryCityStats[$city->getCountry()][$city->getCity()]['minUses'] = PHP_INT_MAX;
	  		$countryCityStats[$city->getCountry()][$city->getCity()]['maxTime'] = -PHP_INT_MAX;
	  		$countryCityStats[$city->getCountry()][$city->getCity()]['minTime'] = PHP_INT_MAX;
	   }
	  	
	  	$countriesReq = Doctrine_Query::create()
		    ->select('i.*, u.country as country')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->leftJoin('i.UserArchive u')
	  		->execute();
	  	
		foreach($countriesReq as $country)
	  	{
	  		
	  		$duration = strtotime($country->getDuration())-strtotime("00:00:00");
	  		
	  		if(!isset($countryCityStats[$country->getCountry()][0]))
	  		{
	  			$countryCityStats[$country->getCountry()][0] = 1;
	  			$countryCityStats[$country->getCountry()][2] = $duration;
	  		}
	  		
	  		else
	  		{
	  			$countryCityStats[$country->getCountry()][0]++;
	  			$countryCityStats[$country->getCountry()][2] += $duration;
	  		}
	  	}
	  	
		foreach($countriesReq as $country)
	  	{
	  		$countryCityStats[$country->getCountry()][1] = round($countryCityStats[$country->getCountry()][0]/$numberImputations,3)*100;
	    }
	   
	   foreach($countriesReq as $country)
	   {
	   	
	   	$countryCityStats[$country->getCountry()]['maxUses'] = -PHP_INT_MAX;
	  	$countryCityStats[$country->getCountry()]['minUses'] = PHP_INT_MAX;
	  	$countryCityStats[$country->getCountry()]['maxTime'] = -PHP_INT_MAX;
	  	$countryCityStats[$country->getCountry()]['minTime'] = PHP_INT_MAX;
	   	
	   	foreach($citiesReq as $city)
	  	{
	  		if(isset($countryCityStats[$country->getCountry()][$city->getCity()]))
	  		{
		  		if(($countryCityStats[$country->getCountry()][$city->getCity()][0] > $countryCityStats[$city->getCountry()]['maxUses']))
		  			$countryCityStats[$country->getCountry()]['maxUses'] = $countryCityStats[$country->getCountry()][$city->getCity()][0];
		  		if(($countryCityStats[$country->getCountry()][$city->getCity()][0] < $countryCityStats[$city->getCountry()]['minUses']) && ($countryCityStats[$country->getCountry()][$city->getCity()][0] != 0))
		  			$countryCityStats[$country->getCountry()]['minUses'] = $countryCityStats[$country->getCountry()][$city->getCity()][0];
		  		if(($countryCityStats[$country->getCountry()][$city->getCity()][2] > $countryCityStats[$city->getCountry()]['maxTime']))
		  			$countryCityStats[$country->getCountry()]['maxTime'] = $countryCityStats[$country->getCountry()][$city->getCity()][2];
		  		if(($countryCityStats[$country->getCountry()][$city->getCity()][2] < $countryCityStats[$city->getCountry()]['minTime']) && ($countryCityStats[$country->getCountry()][$city->getCity()][2] != 0))
		  			$countryCityStats[$country->getCountry()]['minTime'] = $countryCityStats[$country->getCountry()][$city->getCity()][2];
	  		}
	  	}
	  		
	   }
	   
	  return $countryCityStats;
	}
	
	public static function getDetailedValuesByDay($begin_date,$end_date,$numberImputations)
	{
		$imputations = Doctrine_Query::create()
		    ->select('i.imputation_date')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
	  	
	  	$days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');	
	  		
	  	foreach($imputations as $imputation)
	  	{
			$day = date('l', strtotime($imputation->getImputationDate()));
			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
			
			if(isset($dayStats[$day]))
			{
				$dayStats[$day][0]++;
				$dayStats[$day][2] += $duration;
			}
			else
			{
				$dayStats[$day][0] = 1;
				$dayStats[$day][2] = $duration;
			}
	  	}
	  	
	  	$dayStats['maxUses'] = -PHP_INT_MAX;
	  	$dayStats['minUses'] = PHP_INT_MAX;
	  	$dayStats['maxTime'] = -PHP_INT_MAX;
	  	$dayStats['minTime'] = PHP_INT_MAX;
	  	
	  	foreach($days as $day)
	  	{
	  		if (isset($dayStats[$day]))
	  		{
		  		if($dayStats[$day][0] > $dayStats['maxUses']) $dayStats['maxUses'] = $dayStats[$day][0];
		  		if($dayStats[$day][0] < $dayStats['minUses'] && $dayStats[$day][0] != 0) $dayStats['minUses'] = $dayStats[$day][0];
	  			if($dayStats[$day][2] > $dayStats['maxTime']) $dayStats['maxTime'] = $dayStats[$day][2];
		  		if($dayStats[$day][2] < $dayStats['minTime'] && $dayStats[$day][2] != 0) $dayStats['minTime'] = $dayStats[$day][2];
	  		
		  		$dayStats[$day][1] = round($dayStats[$day][0]/$numberImputations,3)*100;
	  		}
	  	}
	  	
	  	return $dayStats;
	} 
	
	// KYXAR 0010 : Création d'une fonction détail par horaire non dépendante des jours
	public static function getDetailedValuesByTimeSlot($begin_date,$end_date)
	{
		// Search imputation between dates
		$imputations = Doctrine_Query::create()
		->select('i.imputation_date')
		->from('ImputationArchive i')
		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		->execute();
		
        // Init timeslots array
		$timeslots = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
		
		
		foreach($imputations as $imputation)
		{
			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
			$hour = date('G', strtotime($imputation->getImputationDate()));
			
			switch($hour)
			{
				case ($hour >= 8 AND $hour < 12) :
					$numberOfImputations++;
					if(isset($TimeSlotStats["8h-12h"]))
					{
						$TimeSlotStats["8h-12h"][0]++;
						$TimeSlotStats["8h-12h"][2] += $duration;
					}
					else
					{
						$TimeSlotStats["8h-12h"] = array();
						$TimeSlotStats["8h-12h"][0] = 1;
						$TimeSlotStats["8h-12h"][2] = $duration;
					}
					break;
				case ($hour >= 12 AND $hour < 16) :
					$numberOfImputations++;
					if(isset($TimeSlotStats["12h-16h"]))
					{
						$TimeSlotStats["12h-16h"][0]++;
						$TimeSlotStats["12h-16h"][2] += $duration;
					}
					else
					{
						$TimeSlotStats["12h-16h"] = array();
						$TimeSlotStats["12h-16h"][0] = 1;
						$TimeSlotStats["12h-16h"][2] = $duration;
					}
					break;
				case ($hour >= 16 AND $hour < 20) :
					$numberOfImputations++;
					if(isset($TimeSlotStats["16h-20h"]))
					{
						$TimeSlotStats["16h-20h"][0]++;
						$TimeSlotStats["16h-20h"][2] += $duration;
					}
					else
					{
						$TimeSlotStats["16h-20h"] = array();
						$TimeSlotStats["16h-20h"][0] = 1;
						$TimeSlotStats["16h-20h"][2] = $duration;
					}
					break;
				default :
					$numberOfImputations++;
					if(isset($TimeSlotStats["20h-24h"]))
					{
						$TimeSlotStats["20h-24h"][0]++;
						$TimeSlotStats["20h-24h"][2] += $duration;
					}
					else
					{
						$TimeSlotStats["20h-24h"] = array();
						$TimeSlotStats["20h-24h"][0] = 1;
						$TimeSlotStats["20h-24h"][2] = $duration;
					}
					break;
			}
		}
		
		// calculate percents by timeslot
		foreach ( $timeslots as $timeslot )
		{
			$TimeSlotStats[$timeslot][1] = round($TimeSlotStats[$timeslot][0]/$numberOfImputations,3)*100;
		}
		
		// calculate min max
		$TimeSlotStats['maxUses'] = -PHP_INT_MAX;
		$TimeSlotStats['minUses'] = PHP_INT_MAX;
		$TimeSlotStats['maxTime'] = -PHP_INT_MAX;
		$TimeSlotStats['minTime'] = PHP_INT_MAX;
	
		foreach($timeslots as $timeslot)
		{
			if (isset($TimeSlotStats[$timeslot][0]))
			{
				if($TimeSlotStats[$timeslot][0] > $TimeSlotStats['maxUses']) $TimeSlotStats['maxUses'] = $TimeSlotStats[$timeslot][0];
				if($TimeSlotStats[$timeslot][0] < $TimeSlotStats['minUses']) $TimeSlotStats['minUses'] = $TimeSlotStats[$timeslot][0];
				if($TimeSlotStats[$timeslot][2] > $TimeSlotStats['maxTime']) $TimeSlotStats['maxTime'] = $TimeSlotStats[$timeslot][2];
				if($TimeSlotStats[$timeslot][2] < $TimeSlotStats['maxTime']) $TimeSlotStats['minTime'] = $TimeSlotStats[$timeslot][2];
			}
		}
		
		// End
		return $TimeSlotStats;
	}
	
	// KYXAR 0010 : Changement du nom de la fonction getDetailedValuesByTimeSlot -> getDetailedValuesByDaysAndTimeSlot
	public static function getDetailedValuesByDaysAndTimeSlot($begin_date,$end_date)
	{
		$imputations = Doctrine_Query::create()
		    ->select('i.imputation_date')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();

	  	$days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	  	$timeslots = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
	  	
	  	foreach($days as $day) $numberOfImputations[$day] = 0;
	  	
	  	foreach($imputations as $imputation)
	  	{
			$day = date('l', strtotime($imputation->getImputationDate()));
			$hour = date('G', strtotime($imputation->getImputationDate()));
			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
			
			switch($hour)
		  	{
	  			case ($hour >= 8 AND $hour < 12) :
	  				$numberOfImputations[$day]++;
					if(isset($dayAndTimeSlotStats[$day]["8h-12h"]))
					{
						$dayAndTimeSlotStats[$day]["8h-12h"][0]++;
						$dayAndTimeSlotStats[$day]["8h-12h"][2] += $duration;
					}
					else
					{
						$dayAndTimeSlotStats[$day]["8h-12h"] = array();
						$dayAndTimeSlotStats[$day]["8h-12h"][0] = 1;
						$dayAndTimeSlotStats[$day]["8h-12h"][2] = $duration;
					}
	  			break;
	  			case ($hour >= 12 AND $hour < 16) :
	  				$numberOfImputations[$day]++;
					if(isset($dayAndTimeSlotStats[$day]["12h-16h"]))
					{
						$dayAndTimeSlotStats[$day]["12h-16h"][0]++;
						$dayAndTimeSlotStats[$day]["12h-16h"][2] += $duration;
					}
					else
					{
						$dayAndTimeSlotStats[$day]["12h-16h"] = array();
						$dayAndTimeSlotStats[$day]["12h-16h"][0] = 1;
						$dayAndTimeSlotStats[$day]["12h-16h"][2] = $duration;
					}
				break;
	  			case ($hour >= 16 AND $hour < 20) :
	  				$numberOfImputations[$day]++;
					if(isset($dayAndTimeSlotStats[$day]["16h-20h"]))
					{
						$dayAndTimeSlotStats[$day]["16h-20h"][0]++;
						$dayAndTimeSlotStats[$day]["16h-20h"][2] += $duration;
					}
					else
					{
						$dayAndTimeSlotStats[$day]["16h-20h"] = array();
						$dayAndTimeSlotStats[$day]["16h-20h"][0] = 1;
						$dayAndTimeSlotStats[$day]["16h-20h"][2] = $duration;
					}
	  			break;
	  			default :
	  				$numberOfImputations[$day]++;
	  				if(isset($dayAndTimeSlotStats[$day]["20h-24h"]))
	  				{
						$dayAndTimeSlotStats[$day]["20h-24h"][0]++;
						$dayAndTimeSlotStats[$day]["20h-24h"][2] += $duration;
	  				}
					else
					{
						$dayAndTimeSlotStats[$day]["20h-24h"] = array();
						$dayAndTimeSlotStats[$day]["20h-24h"][0] = 1;
						$dayAndTimeSlotStats[$day]["20h-24h"][2] = $duration;
					}
	  			break;
		  	}
	  	}
	  	
	  	foreach($days as $day)
	  	{
	  		$dayAndTimeSlotStats[$day]['maxUses'] = -PHP_INT_MAX;
		  	$dayAndTimeSlotStats[$day]['minUses'] = PHP_INT_MAX;
		  	$dayAndTimeSlotStats[$day]['maxTime'] = -PHP_INT_MAX;
		  	$dayAndTimeSlotStats[$day]['minTime'] = PHP_INT_MAX;
	  			
			foreach($timeslots as $timeslot)
		  	{
		  		if (isset($dayAndTimeSlotStats[$day][$timeslot]))
		  		{
			  		if($dayAndTimeSlotStats[$day][$timeslot][0] > $dayAndTimeSlotStats[$day]['maxUses']) $dayAndTimeSlotStats[$day]['maxUses'] = $dayAndTimeSlotStats[$day][$timeslot][0];
			  		if($dayAndTimeSlotStats[$day][$timeslot][0] < $dayAndTimeSlotStats[$day]['minUses']) $dayAndTimeSlotStats[$day]['minUses'] = $dayAndTimeSlotStats[$day][$timeslot][0];
		  			if($dayAndTimeSlotStats[$day][$timeslot][2] > $dayAndTimeSlotStats[$day]['maxTime']) $dayAndTimeSlotStats[$day]['maxTime'] = $dayAndTimeSlotStats[$day][$timeslot][2];
			  		if($dayAndTimeSlotStats[$day][$timeslot][2] < $dayAndTimeSlotStats[$day]['maxTime']) $dayAndTimeSlotStats[$day]['minTime'] = $dayAndTimeSlotStats[$day][$timeslot][2];
		  		
			  		$dayAndTimeSlotStats[$day][$timeslot][1] = round($dayAndTimeSlotStats[$day][$timeslot][0]/$numberOfImputations[$day],3)*100;
		  		}
		  	}
	  	}
	  	
	  	return $dayAndTimeSlotStats;
	}
	
	public static function getDetailedValuesByHour($begin_date,$end_date,$dayStats)
	{
		$imputations = Doctrine_Query::create()
		    ->select('i.imputation_date')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();

	  	$days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	  	$intervals = Array('8h-9h','9h-10h','10h-11h','11h-12h', '12h-13h','13h-14h','14h-15h','15h-16h', '16h-17h','17h-18h','18h-19h','19h-20h', '20h-21h','21h-22h','22h-23h','23h-24h');	
	  	$slots = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
	  	
	  	foreach($imputations as $imputation)
	  	{
			$day = date('l', strtotime($imputation->getImputationDate()));
			$hour = date('G', strtotime($imputation->getImputationDate()));
			
			$hourAfter = $hour+1;
			$interval = $hour."h-".$hourAfter."h";
			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
			
			if(isset($hourStats[$day][$interval]))
			{
				$hourStats[$day][$interval][0]++;
				$hourStats[$day][$interval][2] += $duration;
			}
			else
			{
				$hourStats[$day][$interval][0] = 1;
				$hourStats[$day][$interval][2] = $duration;
			}
			
			if(isset($numberOfImputations[$day][$interval]))
			{
				$numberOfImputations[$day][$interval]++;
			}
			else
			{
				$numberOfImputations[$day][$interval] = 1;
			}
	  	}
	  	
	  	foreach($days as $day)
	  	{
	  		foreach($intervals as $inter)
	  		{
	  			if(isset($hourStats[$day][$inter]))
	  			{
	  				$hourStats[$day][$inter][1] = round($hourStats[$day][$inter][0]/$dayStats[$day][0],3)*100;
	  			}
	  		}
	  	}
		return $hourStats;
	}
	
	public static function getDetailedValuesByPublicCategory($begin_date,$end_date,$numberImputations)
	{
		$publicCategories = Doctrine_Query::create()
		    ->select('a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();
	  	
	  	$publicCategoryStats['maxUses'] = -PHP_INT_MAX;
	  	$publicCategoryStats['minUses'] = PHP_INT_MAX;
	  	$publicCategoryStats['maxTime'] = -PHP_INT_MAX;
	  	$publicCategoryStats['minTime'] = PHP_INT_MAX;	
	  		
	  	foreach($publicCategories as $publicCategory)
	  	{
	  		$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.category = ?',$publicCategory->getDesignation())
		  		->fetchOne();

		  	$publicCategoryStats['cat'][$publicCategory->getDesignation()][0] = $imputations->getTotal();
		  	$publicCategoryStats['cat'][$publicCategory->getDesignation()][1] = round($imputations->getTotal()/$numberImputations,3)*100;
	   		$publicCategoryStats['cat'][$publicCategory->getDesignation()][2] = $imputations->getDuration();
	   		
	   		if($publicCategoryStats['cat'][$publicCategory->getDesignation()][0]>$publicCategoryStats['maxUses']) $publicCategoryStats['maxUses'] = $publicCategoryStats['cat'][$publicCategory->getDesignation()][0];
	  		if($publicCategoryStats['cat'][$publicCategory->getDesignation()][0]<$publicCategoryStats['minUses'] && $publicCategoryStats['cat'][$publicCategory->getDesignation()][0] != 0) $publicCategoryStats['minUses'] = $publicCategoryStats['cat'][$publicCategory->getDesignation()][0];
	  		if($publicCategoryStats['cat'][$publicCategory->getDesignation()][2]>$publicCategoryStats['maxTime']) $publicCategoryStats['maxTime'] = $publicCategoryStats['cat'][$publicCategory->getDesignation()][2];
			if($publicCategoryStats['cat'][$publicCategory->getDesignation()][2]<$publicCategoryStats['minTime'] && $publicCategoryStats['cat'][$publicCategory->getDesignation()][2] != 0) $publicCategoryStats['minTime'] = $publicCategoryStats['cat'][$publicCategory->getDesignation()][2];	  	
	  	}
	  	
	  	$noCategoryImputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.category IS NULL OR u.category = ?',"")
		  		->fetchOne();
		
		$publicCategoryStats['cat']["No category"][0] = $noCategoryImputations->getTotal();
		$publicCategoryStats['cat']["No category"][1] = round($noCategoryImputations->getTotal()/$numberImputations,3)*100;
	    $publicCategoryStats['cat']["No category"][2] = $noCategoryImputations->getDuration();
	  	
	  	if($publicCategoryStats['cat']["No category"][0]>$publicCategoryStats['maxUses']) $publicCategoryStats['maxUses'] = $publicCategoryStats['cat']["No category"][0];
	  	if($publicCategoryStats['cat']["No category"][0]<$publicCategoryStats['minUses'] && $publicCategoryStats['cat']["No category"][0] != 0) $publicCategoryStats['minUses'] = $publicCategoryStats['cat']["No category"][0];
	  	if($publicCategoryStats['cat']["No category"][2]>$publicCategoryStats['maxTime']) $publicCategoryStats['maxTime'] = $publicCategoryStats['cat']["No category"][2];
		if($publicCategoryStats['cat']["No category"][2]<$publicCategoryStats['minTime'] && $publicCategoryStats['cat']["No category"][2] != 0) $publicCategoryStats['minTime'] = $publicCategoryStats['cat']["No category"][2];	  	
	  	
	  	return $publicCategoryStats;
	}
	
	
	public static function getDetailedValuesByAct($begin_date,$end_date,$numberImputations)
	{
		$acts = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();

		$actStats['maxUses'] = -PHP_INT_MAX;
	  	$actStats['minUses'] = PHP_INT_MAX;
	  	$actStats['maxTime'] = -PHP_INT_MAX;
	  	$actStats['minTime'] = PHP_INT_MAX;
			
		foreach($acts as $act)
	  	{
	  		$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->andWhere('i.designation = ?',$act->getDesignation())
		  		->fetchOne();

		  	$actStats['act'][$act->getDesignation()][0] = $imputations->getTotal();
		  	$actStats['act'][$act->getDesignation()][1] = round($imputations->getTotal()/$numberImputations,3)*100;
	   		$actStats['act'][$act->getDesignation()][2] = $imputations->getDuration();
	   		
	   		if($actStats['act'][$act->getDesignation()][0]>$actStats['maxUses']) $actStats['maxUses'] = $actStats['act'][$act->getDesignation()][0];
	  		if($actStats['act'][$act->getDesignation()][0]<$actStats['minUses'] && $actStats['act'][$act->getDesignation()][0] != 0) $actStats['minUses'] = $actStats['act'][$act->getDesignation()][0];
	  		if($actStats['act'][$act->getDesignation()][2]>$actStats['maxTime']) $actStats['maxTime'] = $actStats['act'][$act->getDesignation()][2];
			if($actStats['act'][$act->getDesignation()][2]<$actStats['minTime'] && $actStats['act'][$act->getDesignation()][2] != 0) $actStats['minTime'] = $actStats['act'][$act->getDesignation()][2];	  	
	  	}
	  	
	  	return $actStats;
	}
	
	public static function getDetailedValuesBySeg($begin_date,$end_date,$numberImputations)
	{
		$segs = Doctrine_Query::create()
			->select('u.designation')
			->from('UserSeg u')
			->orderBy('u.sort_order')
			->execute();

		$segStats['maxUses'] = -PHP_INT_MAX;
	  	$segStats['minUses'] = PHP_INT_MAX;
	  	$segStats['maxTime'] = -PHP_INT_MAX;
	  	$segStats['minTime'] = PHP_INT_MAX;
			
		foreach($segs as $seg)
	  	{
	  		$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.seg = ?',$seg->getDesignation())
		  		->fetchOne();

		  	$segStats['seg'][$seg->getDesignation()][0] = $imputations->getTotal();
		  	$segStats['seg'][$seg->getDesignation()][1] = round($imputations->getTotal()/$numberImputations,3)*100;
	   		$segStats['seg'][$seg->getDesignation()][2] = $imputations->getDuration();
	   		
	   		if($segStats['seg'][$seg->getDesignation()][0]>$segStats['maxUses']) $segStats['maxUses'] = $segStats['seg'][$seg->getDesignation()][0];
	  		if($segStats['seg'][$seg->getDesignation()][0]<$segStats['minUses'] && $segStats['seg'][$seg->getDesignation()][0] != 0) $segStats['minUses'] = $segStats['seg'][$seg->getDesignation()][0];
	  		if($segStats['seg'][$seg->getDesignation()][2]>$segStats['maxTime']) $segStats['maxTime'] = $segStats['seg'][$seg->getDesignation()][2];
			if($segStats['seg'][$seg->getDesignation()][2]<$segStats['minTime'] && $segStats['seg'][$seg->getDesignation()][2] != 0) $segStats['minTime'] = $segStats['seg'][$seg->getDesignation()][2];	  	
	  	}
	  	
	  	$noSegImputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.seg IS NULL OR u.seg = ?','')
		  		->fetchOne();
	  	
		$segStats['seg']["Other"][0] = $noSegImputations->getTotal();
	  	$segStats['seg']["Other"][1] = round($noSegImputations->getTotal()/$numberImputations,3)*100;
   		$segStats['seg']["Other"][2] = $noSegImputations->getDuration();
   		
   		if($segStats['seg']["Other"][0]>$segStats['maxUses']) $segStats['maxUses'] = $segStats['seg']["Other"][0];
  		if($segStats['seg']["Other"][0]<$segStats['minUses'] && $segStats['seg']["Other"][0] != 0) $segStats['minUses'] = $segStats['seg']["Other"][0];
  		if($segStats['seg']["Other"][2]>$segStats['maxTime']) $segStats['maxTime'] = $segStats['seg']["Other"][2];
		if($segStats['seg']["Other"][2]<$segStats['minTime'] && $segStats['seg']["Other"][2] != 0) $segStats['minTime'] = $segStats['seg']["Other"][2];  		
		
	  	return $segStats;
	}
	
	
	public static function getDetailedValuesByTypeOfConnection($begin_date,$end_date)
	{
		$typeOfConnections = Doctrine_Query::create()
			->select('c.designation')
			->from('ComputerTypeOfConnexion c')
			->orderBy('c.designation')
			->execute();

		$imputationsUnitaryService = Doctrine_Query::create()
		    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->andWhere('i.imputation_type = ?', "unitary_service")
	  		->fetchOne();

	  	$typeOfConnectionStats['totalUses'] = $imputationsUnitaryService->getTotal();
	  	$typeOfConnectionStats['totalTime'] = $imputationsUnitaryService->getDuration();
			
		$typeOfConnectionStats['maxUses'] = -PHP_INT_MAX;
	  	$typeOfConnectionStats['minUses'] = PHP_INT_MAX;
	  	$typeOfConnectionStats['maxTime'] = -PHP_INT_MAX;
	  	$typeOfConnectionStats['minTime'] = PHP_INT_MAX;
			
		foreach($typeOfConnections as $typeOfConnection)
	  	{
	  		$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->andWhere('i.computer_type_of_connexion = ?',$typeOfConnection->getDesignation())
		  		->andWhere('i.imputation_type = ?', "unitary_service")
		  		->fetchOne();

		  	$typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0] = $imputations->getTotal();
		  	
		  	if($imputationsUnitaryService->getTotal() != 0) $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][1] = round($imputations->getTotal()/$imputationsUnitaryService->getTotal(),3)*100;
	   		else $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][1] = "0";
		  	
		  	$typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2] = $imputations->getDuration();
	   		
	   		if($typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0]>$typeOfConnectionStats['maxUses']) $typeOfConnectionStats['maxUses'] = $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0];
	  		if($typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0]<$typeOfConnectionStats['minUses'] && $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0] != 0) $typeOfConnectionStats['minUses'] = $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][0];
	  		if($typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2]>$typeOfConnectionStats['maxTime']) $typeOfConnectionStats['maxTime'] = $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2];
			if($typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2]<$typeOfConnectionStats['minTime'] && $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2] != 0) $typeOfConnectionStats['minTime'] = $typeOfConnectionStats['type'][$typeOfConnection->getDesignation()][2];	  	
	  	}
	  	
	  	return $typeOfConnectionStats;
	}
	
	public static function getDetailedValuesByAwareness($begin_date,$end_date,$numberImputations)
	{
		$awarenesses = Doctrine_Query::create()
			->select('u.designation')
			->from('UserAwareness u')
			->orderBy('u.sort_order')
			->execute();

		$awarenessStats['maxUses'] = -PHP_INT_MAX;
	  	$awarenessStats['minUses'] = PHP_INT_MAX;
	  	$awarenessStats['maxTime'] = -PHP_INT_MAX;
	  	$awarenessStats['minTime'] = PHP_INT_MAX;
			
		foreach($awarenesses as $awareness)
	  	{
	  		$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.awareness = ?',$awareness->getDesignation())
		  		->fetchOne();

		  	$awarenessStats['awareness'][$awareness->getDesignation()][0] = $imputations->getTotal();
		  	$awarenessStats['awareness'][$awareness->getDesignation()][1] = round($imputations->getTotal()/$numberImputations,3)*100;
	   		$awarenessStats['awareness'][$awareness->getDesignation()][2] = $imputations->getDuration();
	   		
	   		if($awarenessStats['awareness'][$awareness->getDesignation()][0]>$awarenessStats['maxUses']) $awarenessStats['maxUses'] = $awarenessStats['awareness'][$awareness->getDesignation()][0];
	  		if($awarenessStats['awareness'][$awareness->getDesignation()][0]<$awarenessStats['minUses'] && $awarenessStats['awareness'][$awareness->getDesignation()][0] != 0) $awarenessStats['minUses'] = $awarenessStats['awareness'][$awareness->getDesignation()][0];
	  		if($awarenessStats['awareness'][$awareness->getDesignation()][2]>$awarenessStats['maxTime']) $awarenessStats['maxTime'] = $awarenessStats['awareness'][$awareness->getDesignation()][2];
			if($awarenessStats['awareness'][$awareness->getDesignation()][2]<$awarenessStats['minTime'] && $awarenessStats['awareness'][$awareness->getDesignation()][2] != 0) $awarenessStats['minTime'] = $awarenessStats['awareness'][$awareness->getDesignation()][2];	  	
	  	}
	  	
	  	$noAwarenessImputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
		  		->andWhere('u.awareness IS NULL OR u.awareness = ?','')
		  		->fetchOne();
	  	
		if($noAwarenessImputations->getTotal() != 0)
		{
			$awarenessStats['awareness']["Not available"][0] = $noAwarenessImputations->getTotal();
		  	$awarenessStats['awareness']["Not available"][1] = round($noAwarenessImputations->getTotal()/$numberImputations,3)*100;
	   		$awarenessStats['awareness']["Not available"][2] = $noAwarenessImputations->getDuration();
	   		
	   		if($awarenessStats['awareness']["Not available"][0]>$awarenessStats['maxUses']) $awarenessStats['maxUses'] = $awarenessStats['awareness']["Not available"][0];
	  		if($awarenessStats['awareness']["Not available"][0]<$awarenessStats['minUses'] && $awarenessStats['awareness']["Not available"][0] != 0) $awarenessStats['minUses'] = $awarenessStats['awareness']["Not available"][0];
	  		if($awarenessStats['awareness']["Not available"][2]>$awarenessStats['maxTime']) $awarenessStats['maxTime'] = $awarenessStats['awareness']["Not available"][2];
			if($awarenessStats['awareness']["Not available"][2]<$awarenessStats['minTime'] && $awarenessStats['awareness']["Not available"][2] != 0) $awarenessStats['minTime'] = $awarenessStats['awareness']["Not available"][2];	  	
		}
			
	  	return $awarenessStats;
	}
	
	public static function getDetailedValuesByBuilding($begin_date,$end_date,$numberImputations)
	{
		$buildings = Doctrine_Query::create()
			->select('b.designation')
			->from('Building b')
			->execute();

		$buildingStats['maxUses'] = -PHP_INT_MAX;
	  	$buildingStats['minUses'] = PHP_INT_MAX;
	  	$buildingStats['maxTime'] = -PHP_INT_MAX;
	  	$buildingStats['minTime'] = PHP_INT_MAX;	
			
		foreach($buildings as $building)
		{
			$imputations = Doctrine_Query::create()
			    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.building_designation = ?',$building->getDesignation())
		  		->fetchOne();
		  	
		  	$buildingStats['building'][$building->getDesignation()][0] = $imputations->getTotal();
		  	$buildingStats['building'][$building->getDesignation()][1] = round($imputations->getTotal()/$numberImputations,3)*100;
		  	$buildingStats['building'][$building->getDesignation()][2] = $imputations->getDuration();	
		  	
		  	if($buildingStats['building'][$building->getDesignation()][0]>$buildingStats['maxUses']) $buildingStats['maxUses'] = $buildingStats['building'][$building->getDesignation()][0];
  			if($buildingStats['building'][$building->getDesignation()][0]<$buildingStats['minUses'] && $buildingStats['building'][$building->getDesignation()][0] != 0) $buildingStats['minUses'] = $buildingStats['building'][$building->getDesignation()][0];
  			if($buildingStats['building'][$building->getDesignation()][2]>$buildingStats['maxTime']) $buildingStats['maxTime'] = $buildingStats['building'][$building->getDesignation()][2];
			if($buildingStats['building'][$building->getDesignation()][2]<$buildingStats['minTime'] && $buildingStats['building'][$building->getDesignation()][2] != 0) $buildingStats['minTime'] = $buildingStats['building'][$building->getDesignation()][2];	  	
		}
	
		return $buildingStats;
	}
	
	public static function getDetailedValuesByRoom($begin_date,$end_date)
	{
		$buildings = Doctrine_Query::create()
			->select('b.designation, b.id')
			->from('Building b')
			->execute();

		foreach($buildings as $building)
		{
			$rooms = Doctrine_Query::create()
				->select('r.designation')
				->from('Room r')
				->innerJoin('r.Building b ON r.building_id = ?',$building->getId())
				->execute();
				
			$numberImputations = Doctrine_Query::create()
				->select('COUNT(*) as total')
				->from('ImputationArchive i')
				->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
			  	->addWhere('i.building_designation = ?',$building->getDesignation())
				->fetchOne();	
				
			$roomStats[$building->getDesignation()]['maxUses'] = -PHP_INT_MAX;
	  		$roomStats[$building->getDesignation()]['minUses'] = PHP_INT_MAX;
	  		$roomStats[$building->getDesignation()]['maxTime'] = -PHP_INT_MAX;
	  		$roomStats[$building->getDesignation()]['minTime'] = PHP_INT_MAX;		
				
			foreach($rooms as $room)
			{
				$imputations = Doctrine_Query::create()
				    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
				    ->from('ImputationArchive i')
			  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
			  		->addWhere('i.room_designation = ?',$room->getDesignation())
			  		->addWhere('i.building_designation = ?',$building->getDesignation())
			  		->fetchOne();

			  	if($numberImputations->getTotal() != 0)
			  	{
				  	$roomStats['room'][$building->getDesignation()][$room->getDesignation()][0] = $imputations->getTotal();
				  	$roomStats['room'][$building->getDesignation()][$room->getDesignation()][1] = round($imputations->getTotal()/$numberImputations->getTotal(),3)*100;
				  	$roomStats['room'][$building->getDesignation()][$room->getDesignation()][2] = $imputations->getDuration();
			  	}
			  	else
			  	{
			  		$roomStats['room'][$building->getDesignation()][$room->getDesignation()][0] = 0;
				  	$roomStats['room'][$building->getDesignation()][$room->getDesignation()][1] = 0;
				  	$roomStats['room'][$building->getDesignation()][$room->getDesignation()][2] = 0;
			  	}
				  	
			  	if($roomStats['room'][$building->getDesignation()][$room->getDesignation()][0]>$roomStats[$building->getDesignation()]['maxUses']) $roomStats[$building->getDesignation()]['maxUses'] = $roomStats['room'][$building->getDesignation()][$room->getDesignation()][0];
	  			if($roomStats['room'][$building->getDesignation()][$room->getDesignation()][0]<$roomStats[$building->getDesignation()]['minUses'] && $roomStats['room'][$building->getDesignation()][$room->getDesignation()][0] != 0) $roomStats[$building->getDesignation()]['minUses'] = $roomStats['room'][$building->getDesignation()][$room->getDesignation()][0];
	  			if($roomStats['room'][$building->getDesignation()][$room->getDesignation()][2]>$roomStats[$building->getDesignation()]['maxTime']) $roomStats[$building->getDesignation()]['maxTime'] = $roomStats['room'][$building->getDesignation()][$room->getDesignation()][2];
				if($roomStats['room'][$building->getDesignation()][$room->getDesignation()][2]<$roomStats[$building->getDesignation()]['minTime'] && $roomStats['room'][$building->getDesignation()][$room->getDesignation()][2] != 0) $roomStats[$building->getDesignation()]['minTime'] = $roomStats['room'][$building->getDesignation()][$room->getDesignation()][2];
			}
		}

		return $roomStats;
	}
	
	public static function getDetailedValuesByComputer($begin_date,$end_date)
	{
		$buildings = Doctrine_Query::create()
			->select('b.designation, b.id')
			->from('Building b')
			->execute();

		foreach($buildings as $building)
		{
			$rooms = Doctrine_Query::create()
				->select('r.designation,r.id')
				->from('Room r')
				->innerJoin('r.Building b ON r.building_id = ?',$building->getId())
				->execute();

			foreach($rooms as $room)
			{
				$computers = Doctrine_Query::create()
					->select('c.name')
					->from('Computer c')
					->innerJoin('c.Room r ON c.room_id = ?',$room->getId())
					->execute();
					
				$numberImputations = Doctrine_Query::create()
					->select('COUNT(*) as total')
					->from('ImputationArchive i')
					->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
			  		->addWhere('i.room_designation = ?',$room->getDesignation())
					->fetchOne();		
					
				foreach($computers as $computer)
				{
					$imputations = Doctrine_Query::create()
					    ->select('COUNT(*) as total, SUM(TIME_TO_SEC(i.duration)) as duration')
					    ->from('ImputationArchive i')
				  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
				  		->addWhere('i.computer_name = ?',$computer->getName())
				  		->addWhere('i.room_designation = ?',$room->getDesignation())
				  		->fetchOne();
				  		
				  	if($numberImputations->getTotal() != 0)
				  	{
					  	$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][0] = $imputations->getTotal();
				  		$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][1] = round($imputations->getTotal()/$numberImputations->getTotal(),3)*100;
				  		$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][2] = $imputations->getDuration();
				  	}
				  	else
				  	{
				  		$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][0] = 0;
				  		$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][1] = 0;
				  		$computerStats['computer'][$building->getDesignation()][$room->getDesignation()][$computer->getName()][2] = 0;
				  	}
				  }
			}
				
		}
		
		return $computerStats;
	}
	
	public static function getQuantitativeStatementValuesByAct($begin_date,$end_date)
	{
		$acts = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();

		$publicCategories = Doctrine_Query::create()
		    ->select('a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();	

	  	$users = Doctrine_Query::create()
			->select('i.user_archive_id')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->groupBy('i.user_archive_id')
	  		->execute();

	  	$numberDays = round((strtotime($end_date) - strtotime($begin_date))/(60*60*24));	
	  		
		foreach($acts as $act)
		{
			/*Global data*/
			$numberOfUses = Doctrine_Query::create()
			    ->select('COUNT(*) as total')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->fetchOne();
			
			$statement[$act->getDesignation()]['Total of uses'] = $numberOfUses->getTotal();
			
			$numberOfUniqueVisitors = Doctrine_Query::create()
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->groupBy('i.user_archive_id')
		  		->count();
			
			$statement[$act->getDesignation()]['Number of unique visitors'] = $numberOfUniqueVisitors;
			
			$numberOfUniqueVisitors = Doctrine_Query::create()
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->groupBy('i.user_archive_id, i.user_archive_id HAVING COUNT(*)>1')
		  		->count();
			
		  	$statement[$act->getDesignation()]['Number of regular visitors'] = 0;	
		  		
			foreach($users as $user)
		  	{
		  		$userImputations = Doctrine_Query::create()
				    ->from('ImputationArchive i')
			  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
			  		->addWhere('i.user_archive_id = ?',$user->getUserArchiveId())
			  		->addWhere('i.designation = ?',$act->getDesignation())
			  		->groupBy('i.user_archive_id')
			  		->count();
			  		
		  		if(($userImputations/$numberDays)>=(2/30)) $statement[$act->getDesignation()]['Number of regular visitors']++;
		  	}	

			/*By Gender*/
			$numberOfMaleUses = Doctrine_Query::create()
			    ->select('COUNT(*) as total')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.gender = ?',"Male")
		  		->fetchOne();
		  		
		  	$statement[$act->getDesignation()]['Male'] = $numberOfMaleUses->getTotal();
		  	$statement[$act->getDesignation()]['Female'] =  $numberOfUses->getTotal()-$numberOfMaleUses->getTotal();

		  	/*By age range*/
		  	$imputations = Doctrine_Query::create()
			    ->select('*')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->execute();

		  	$statement[$act->getDesignation()]["inferior to 10"] = 0;
		  	$statement[$act->getDesignation()]["11 to 20"] = 0;
		  	$statement[$act->getDesignation()]["21 to 30"] = 0;		
		  	$statement[$act->getDesignation()]["31 to 40"] = 0;	
		  	$statement[$act->getDesignation()]["41 to 50"] = 0;	
		  	$statement[$act->getDesignation()]["51 to 60"] = 0;	
		  	$statement[$act->getDesignation()]["61 to 70"] = 0;	
		  	$statement[$act->getDesignation()]["71 to 80"] = 0;	
		  	$statement[$act->getDesignation()]["superior to 80"] = 0;
		  	
		  	foreach($imputations as $imputation)
		  	{
			  	$imputationDate = strtotime($imputation->getImputationDate());
	  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
	  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
	  			
			  	switch($age)
		  		{
		  			case ($age <= 10) :
						$statement[$act->getDesignation()]["inferior to 10"]++;
					break;
		  			case ($age > 10 AND $age <= 20) :
						$statement[$act->getDesignation()]["11 to 20"]++;
		  			break;
		  			case ($age > 20 AND $age <= 30) :
						$statement[$act->getDesignation()]["21 to 30"]++;
		  			break;
		  			case ($age > 30 AND $age <= 40) :
						$statement[$act->getDesignation()]["31 to 40"]++;
		  			break;
		  			case ($age > 40 AND $age <= 50) :
						$statement[$act->getDesignation()]["41 to 50"]++;
		  			break;
		  			case ($age > 50 AND $age <= 60) :
						$statement[$act->getDesignation()]["51 to 60"]++;
		  			break;
		  			case ($age > 60 AND $age <= 70) :
						$statement[$act->getDesignation()]["61 to 70"]++;
		  			break;
		  			case ($age > 70 AND $age <= 80) :
						$statement[$act->getDesignation()]["71 to 80"]++;
		  			break;
		  			default :
		  				$statement[$act->getDesignation()]["superior to 80"]++;
		  			break;
		  		}
		  		
		  		/*By country/city*/
		  		$country = $imputation->getUserArchive()->getCountry();
		  		$city = $imputation->getUserArchive()->getCityName();

		  		if(isset($statement[$act->getDesignation()][$country][$city])) $statement[$act->getDesignation()][$country][$city]++;
		  		else $statement[$act->getDesignation()][$country][$city] = 1;
		  		if(isset($statement[$act->getDesignation()][$country][0])) $statement[$act->getDesignation()][$country][0]++;
		  		else $statement[$act->getDesignation()][$country][0] = 1;

		  		/*By day/time slot*/
		  		$day = date('l', strtotime($imputation->getImputationDate()));
			
				if(isset($statement[$act->getDesignation()][$day])) $statement[$act->getDesignation()][$day][0]++;
				else $statement[$act->getDesignation()][$day][0] = 1;
		  		
				$hour = date('G', strtotime($imputation->getImputationDate()));
			
				switch($hour)
			  	{
		  			case ($hour >= 8 AND $hour < 12) :
						if(isset($statement[$act->getDesignation()][$day]["8h-12h"])) $statement[$act->getDesignation()][$day]["8h-12h"]++;
						else $statement[$act->getDesignation()][$day]["8h-12h"] = 1;
		  			break;
		  			case ($hour >= 12 AND $hour < 16) :
						if(isset($statement[$act->getDesignation()][$day]["12h-16h"])) $statement[$act->getDesignation()][$day]["12h-16h"]++;
						else $statement[$act->getDesignation()][$day]["12h-16h"] = 1;
		  			break;
		  			case ($hour >= 16 AND $hour < 20) :
						if(isset($statement[$act->getDesignation()][$day]["16h-20h"])) $statement[$act->getDesignation()][$day]["16h-20h"]++;
						else $statement[$act->getDesignation()][$day]["16h-20h"] = 1;
		  			break;
		  			default :
						if(isset($statement[$act->getDesignation()][$day]["20h-24h"])) $statement[$act->getDesignation()][$day]["20h-24h"]++;
						else $statement[$act->getDesignation()][$day]["20h-24h"] = 1;
		  			break;
			  	}
			  	
			  	$hourAfter = $hour+1;
			  	$interval = $hour."h-".$hourAfter."h";
			  	
			  	if(isset($statement[$act->getDesignation()][$day][$interval])) $statement[$act->getDesignation()][$day][$interval]++;
				else $statement[$act->getDesignation()][$day][$interval] = 1;
				
				/*By category*/
				$category = $imputation->getUserArchive()->getCategory();
				
				if($category != null)
				{
					$categoryId = Doctrine::getTable('ActPublicCategory')->findOneByDesignation($category)->getId();
					
					if(isset($statement[$act->getDesignation()]['Category'][$categoryId])) $statement[$act->getDesignation()]['Category'][$categoryId]++;
					else $statement[$act->getDesignation()]['Category'][$categoryId] = 1;
				}
				else
				{
					if(isset($statement[$act->getDesignation()]['Category']["No category"])) $statement[$act->getDesignation()]['Category']["No category"]++;
					else $statement[$act->getDesignation()]['Category']["No category"] = 1;
				}
				
				/*By SEG*/
		  		$seg = $imputation->getUserArchive()->getSeg();

				if($seg != null)
				{
					$segId = Doctrine::getTable('UserSeg')->findOneByDesignation($seg)->getId();
					
					if(isset($statement[$act->getDesignation()]['SEG'][$segId])) $statement[$act->getDesignation()]['SEG'][$segId]++;
					else $statement[$act->getDesignation()]['SEG'][$segId] = 1;
				}
				else
				{
					if(isset($statement[$act->getDesignation()]['SEG']["Other"])) $statement[$act->getDesignation()]['SEG']["Other"]++;
					else $statement[$act->getDesignation()]['SEG']["Other"] = 1;
				}
					
				/*By building/room/computer*/
				$building = $imputation->getBuildingDesignation();
				
				$buildingId = Doctrine::getTable('Building')->findOneByDesignation($building)->getId();
				
				if(isset($statement[$act->getDesignation()]['Building'][$buildingId])) $statement[$act->getDesignation()]['Building'][$buildingId][0]++;
				else $statement[$act->getDesignation()]['Building'][$buildingId][0] = 1;
				
				$room = $imputation->getRoomDesignation();
				
				$roomId = Doctrine::getTable('Room')->findOneByDesignation($room)->getId();

				if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][0]++;
				else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][0] = 1;
				
				$computer = $imputation->getComputerName();

				if($computer != null)
				{
					$computerId = Doctrine::getTable('Computer')->findOneByName($computer)->getId();
					
					if($computerId != null)
					{
						if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId]++;
						else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId] = 1;
					}
					else
					{
						if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"]++;
						else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"] = 1;
					}
				}
				
				/*By awareness*/
				$awareness = $imputation->getUserArchive()->getAwareness();
				
			  	if($awareness != null)
		  		{
		  			$awarenessId = Doctrine::getTable('UserAwareness')->findOneByDesignation($awareness)->getId();
		  			
		  			if(isset($statement[$act->getDesignation()]['Awareness'][$awarenessId])) $statement[$act->getDesignation()]['Awareness'][$awarenessId]++;
					else $statement[$act->getDesignation()]['Awareness'][$awarenessId] = 1;
		  		}
		  		else
		  		{
		  			if(isset($statement[$act->getDesignation()]['Awareness']["Not available"])) $statement[$act->getDesignation()]['Awareness']["Not available"]++;
		  			else $statement[$act->getDesignation()]['Awareness']["Not available"] = 1;
	  			}
			}
			  
			/*By type of connection*/
			$imputationsUnitaryService = Doctrine_Query::create()
			    ->select('*')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->andWhere('i.designation = ?',$act->getDesignation())
		  		->andWhere('i.imputation_type = ?', "unitary_service")
		  		->execute();
			
		  	foreach($imputationsUnitaryService as $imputationUnitaryService)
		  	{
		  		$typeOfConnection = $imputationUnitaryService->getComputerTypeOfConnexion();
		  		
		  		$typeOfConnectionId = Doctrine::getTable('ComputerTypeOfConnexion')->findOneByDesignation($typeOfConnection)->getId();
		  		
		  		if(isset($statement[$act->getDesignation()]['Connection'][$typeOfConnectionId])) $statement[$act->getDesignation()]['Connection'][$typeOfConnectionId]++;
				else $statement[$act->getDesignation()]['Connection'][$typeOfConnectionId] = 1;
		  	}
		}
		
		return $statement;
	}
	
	public static function getQuantitativeDetailsPerCategory($begin_date, $end_date)
	{
		$categories = Doctrine_Query::create()
		    ->select('a.id, a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();
	  		
	  	foreach($categories as $category)
	  	{	
	  		$categoryColumn = $category->getId();
	  		
	  		$statement['Details per category'][$categoryColumn]["inferior to 10"] = 0;
		  	$statement['Details per category'][$categoryColumn]["11 to 20"] = 0;
		  	$statement['Details per category'][$categoryColumn]["21 to 30"] = 0;		
		  	$statement['Details per category'][$categoryColumn]["31 to 40"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["41 to 50"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["51 to 60"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["61 to 70"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["71 to 80"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["superior to 80"] = 0;
	  		
	  		$imputations = Doctrine_Query::create()
			    ->select('i.*')
	  			->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.category = ?', $category->getDesignation())
		  		->execute();
		  		
		  	foreach($imputations as $imputation)
		  	{
		  		
		  		if(isset($statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()])) $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()]++;
		  		else $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()] = 1;

		  		if(isset($statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()])) $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()]++;
		  		else $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()] = 1;
		  		
		  		$imputationDate = strtotime($imputation->getImputationDate());
	  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
	  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
	  			
			  	switch($age)
		  		{
		  			case ($age <= 10) :
						$statement['Details per category'][$categoryColumn]["inferior to 10"]++;
					break;
		  			case ($age > 10 AND $age <= 20) :
						$statement['Details per category'][$categoryColumn]["11 to 20"]++;
		  			break;
		  			case ($age > 20 AND $age <= 30) :
						$statement['Details per category'][$categoryColumn]["21 to 30"]++;
		  			break;
		  			case ($age > 30 AND $age <= 40) :
						$statement['Details per category'][$categoryColumn]["31 to 40"]++;
		  			break;
		  			case ($age > 40 AND $age <= 50) :
						$statement['Details per category'][$categoryColumn]["41 to 50"]++;
		  			break;
		  			case ($age > 50 AND $age <= 60) :
						$statement['Details per category'][$categoryColumn]["51 to 60"]++;
		  			break;
		  			case ($age > 60 AND $age <= 70) :
						$statement['Details per category'][$categoryColumn]["61 to 70"]++;
		  			break;
		  			case ($age > 70 AND $age <= 80) :
						$statement['Details per category'][$categoryColumn]["71 to 80"]++;
		  			break;
		  			default :
		  				$statement['Details per category'][$categoryColumn]["superior to 80"]++;
		  			break;
		  		}
		  	}
	  	}
	  	return $statement;
	}
	
	public static function getQuantitativeDetailsPerTimeSlot($begin_date, $end_date)
	{
  		$imputations = Doctrine_Query::create()
		    ->select('i.*')
  			->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
	  		
	  	foreach($imputations as $imputation)
	  	{
	  		$day = date('l', strtotime($imputation->getImputationDate()));
	  		$hour = date('G', strtotime($imputation->getImputationDate()));
			$hourAfter = $hour+1;
			$interval = $hour."h-".$hourAfter."h";
	  		
	  		if(isset($statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()])) $statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()]++;
	  		else $statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()] = 1;

	  		if(isset($statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()])) $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()]++;
	  		else $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()] = 1;
	  		
	  		if(isset($statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()])) $statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()]++;
	  		else $statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()] = 1;
	  		
	  		if(isset($statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()])) $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()]++;
	  		else $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()] = 1;
	  		
	  		$imputationDate = strtotime($imputation->getImputationDate());
  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
  			
		  	switch($age)
	  		{
	  			case ($age <= 10) :
					if(isset($statement['Details per time slot'][$day]["inferior to 10"])) $statement['Details per time slot'][$day]["inferior to 10"]++;
					else $statement['Details per time slot'][$day]["inferior to 10"] = 1;
					
					if(isset($statement['Details per time slot'][$day][$interval]["inferior to 10"])) $statement['Details per time slot'][$day][$interval]["inferior to 10"]++;
					else $statement['Details per time slot'][$day][$interval]["inferior to 10"] = 1;
				break;
	  			case ($age > 10 AND $age <= 20) :
					if(isset($statement['Details per time slot'][$day]["11 to 20"])) $statement['Details per time slot'][$day]["11 to 20"]++;
					else $statement['Details per time slot'][$day]["11 to 20"] = 1;
					
					if(isset($statement['Details per time slot'][$day][$interval]["11 to 20"])) $statement['Details per time slot'][$day][$interval]["11 to 20"]++;
					else $statement['Details per time slot'][$day][$interval]["11 to 20"] = 1;
	  			break;
	  			case ($age > 20 AND $age <= 30) :
					if(isset($statement['Details per time slot'][$day]["21 to 30"])) $statement['Details per time slot'][$day]["21 to 30"]++;
					else $statement['Details per time slot'][$day]["21 to 30"] = 1;
					
					if(isset($statement['Details per time slot'][$day][$interval]["21 to 30"])) $statement['Details per time slot'][$day][$interval]["21 to 30"]++;
					else $statement['Details per time slot'][$day][$interval]["21 to 30"] = 1;
	  			break;
	  			case ($age > 30 AND $age <= 40) :
					if(isset($statement['Details per time slot'][$day]["31 to 40"])) $statement['Details per time slot'][$day]["31 to 40"]++;
	  				else $statement['Details per time slot'][$day]["31 to 40"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["31 to 40"])) $statement['Details per time slot'][$day][$interval]["31 to 40"]++;
	  				else $statement['Details per time slot'][$day][$interval]["31 to 40"] = 1;
				break;
	  			case ($age > 40 AND $age <= 50) :
					if(isset($statement['Details per time slot'][$day]["41 to 50"])) $statement['Details per time slot'][$day]["41 to 50"]++;
	  				else $statement['Details per time slot'][$day]["41 to 50"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["41 to 50"])) $statement['Details per time slot'][$day][$interval]["41 to 50"]++;
	  				else $statement['Details per time slot'][$day][$interval]["41 to 50"] = 1;
				break;
	  			case ($age > 50 AND $age <= 60) :
					if(isset($statement['Details per time slot'][$day]["51 to 60"])) $statement['Details per time slot'][$day]["51 to 60"]++;
	  				else $statement['Details per time slot'][$day]["51 to 60"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["51 to 60"])) $statement['Details per time slot'][$day][$interval]["51 to 60"]++;
	  				else $statement['Details per time slot'][$day][$interval]["51 to 60"] = 1;
				break;
	  			case ($age > 60 AND $age <= 70) :
					if(isset($statement['Details per time slot'][$day]["61 to 70"])) $statement['Details per time slot'][$day]["61 to 70"]++;
	  				else $statement['Details per time slot'][$day]["61 to 70"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["61 to 70"])) $statement['Details per time slot'][$day][$interval]["61 to 70"]++;
	  				else $statement['Details per time slot'][$day][$interval]["61 to 70"] = 1;
				break;
	  			case ($age > 70 AND $age <= 80) :
					if(isset($statement['Details per time slot'][$day]["71 to 80"])) $statement['Details per time slot'][$day]["71 to 80"]++;
	  				else $statement['Details per time slot'][$day]["71 to 80"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["71 to 80"])) $statement['Details per time slot'][$day][$interval]["71 to 80"]++;
	  				else $statement['Details per time slot'][$day][$interval]["71 to 80"] = 1;
				break;
	  			default :
	  				if(isset($statement['Details per time slot'][$day]["superior to 80"])) $statement['Details per time slot'][$day]["superior to 80"]++;
	  				else $statement['Details per time slot'][$day]["superior to 80"] = 1;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["superior to 80"])) $statement['Details per time slot'][$day][$interval]["superior to 80"]++;
	  				else $statement['Details per time slot'][$day][$interval]["superior to 80"] = 1;
	  			break;
	  		}
	  	}
	  	return $statement;
	}
	
	
	public static function getQuantitativeStatementColumns($begin_date, $end_date)
	{
		$citiesTable = array();
		
		$columns['Global Data'] = Array("Total of uses", "Number of unique visitors", "Number of regular visitors");
		
		$columns['Gender'] = Array("Female", "Male");
		
		$columns['Age range'] = Array("inferior to 10", "11 to 20", "21 to 30", "31 to 40", "41 to 50", "51 to 60", "61 to 70", "71 to 80", "superior to 80");
		
		$columns['Day'] = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

		$columns['Time slot'] = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
		
		$columns[$columns['Time slot'][0]]['Hour'] = Array('8h-9h','9h-10h','10h-11h','11h-12h');
		$columns[$columns['Time slot'][1]]['Hour'] = Array('12h-13h','13h-14h','14h-15h','15h-16h');
		$columns[$columns['Time slot'][2]]['Hour'] = Array('16h-17h','17h-18h','18h-19h','19h-20h');
		$columns[$columns['Time slot'][3]]['Hour'] = Array('20h-21h','21h-22h','22h-23h','23h-24h');
		
		$columns['Hour'] = Array('8h-9h','9h-10h','10h-11h','11h-12h', '12h-13h','13h-14h','14h-15h','15h-16h', '16h-17h','17h-18h','18h-19h','19h-20h', '20h-21h','21h-22h','22h-23h','23h-24h');
		
		$publicCategories = Doctrine_Query::create()
		    ->select('a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();
		
	  	foreach ($publicCategories as $publicCategory)
	  	{
	  		$columns['Category'][$publicCategory->getId()] = $publicCategory->getDesignation();
	  	}

	  	$columns['Category']["Other"] = "No category";
	  	
	  	$segs = Doctrine_Query::create()
			->select('u.id, u.designation')
			->from('UserSeg u')
			->orderBy('u.sort_order')
			->execute();
			
		foreach ($segs as $seg)
	  	{
	  		$columns['SEG'][$seg->getId()] = $seg->getDesignation();
	  	}

	  	$columns['SEG']["Other"] = "Other";
	  	
	  	$buildings = Doctrine_Query::create()
			->select('b.id, b.designation')
			->from('Building b')
			->execute();
			
		foreach($buildings as $building)
		{
			$columns['Building'][$building->getId()] = $building->getDesignation();	
		}
		
		$rooms = Doctrine_Query::create()
			->select('r.*')
			->from('Room r')
			->execute();
		
		foreach($rooms as $room)
		{
			$columns[$room->getBuilding()->getId()]['Room'][$room->getId()] = $room->getDesignation();
		}
	  	
		$computers = Doctrine_Query::create()
			->select('c.*')
			->from('Computer c')
			->execute();
		
		foreach($computers as $computer)
		{
			$columns[$computer->getRoom()->getBuilding()->getId()][$computer->getRoom()->getId()]['Computer'][$computer->getId()] = $computer->getName();
		}
			
		$columns[$computer->getRoom()->getBuilding()->getId()][$computer->getRoom()->getId()]['Computer']["Other"] = "Other";
	  	
		$typeOfConnections = Doctrine_Query::create()
			->select('c.id, c.designation')
			->from('ComputerTypeOfConnexion c')
			->orderBy('c.designation')
			->execute();
			
		foreach($typeOfConnections as $typeOfConnection)
		{
			$columns['Type of connection'][$typeOfConnection->getId()] = $typeOfConnection->getDesignation();
		}
		
		$awarenesses = Doctrine_Query::create()
			->select('u.id, u.designation')
			->from('UserAwareness u')
			->orderBy('u.sort_order')
			->execute();
			
		foreach($awarenesses as $awareness)
		{
			$columns['Awareness'][$awareness->getId()] = $awareness->getDesignation();
		}
		
		$columns['Awareness']["Other"] = "Not available";
		
		$imputations = Doctrine_Query::create()
		    ->select('i.*')
		    ->from('ImputationArchive i')
	  		->where('imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
		
		foreach($imputations as $imputation)
	  	{
	  		$city = $imputation->getUserArchive()->getCityName();
		  	if(!in_array($city, $citiesTable)) 
		  	{
		  		$citiesTable[] = $city;
		  		$columns['City'][] = $city;
		  	}
	  	}
		
		return $columns;
	}
	
	public static function getTotalQuantitativeStatementValues($begin_date,$end_date)
	{
		$numberOfUses = Doctrine_Query::create()
			    ->select('COUNT(*) as total')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->fetchOne();
			
		$total['Total of uses'] = $numberOfUses->getTotal();

		$numberOfUniqueVisitors = Doctrine_Query::create()
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->groupBy('i.user_archive_id')
		  		->count();
			
		$total['Number of unique visitors'] = $numberOfUniqueVisitors;
		
		$numberOfMaleUses = Doctrine_Query::create()
			    ->select('COUNT(*) as total')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.gender = ?',"Male")
		  		->fetchOne();
		  		
	  	$total['Male'] = $numberOfMaleUses->getTotal();
	  	$total['Female'] =  $numberOfUses->getTotal()-$numberOfMaleUses->getTotal();

	  	$users = Doctrine_Query::create()
			->select('i.user_archive_id')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->groupBy('i.user_archive_id')
	  		->execute();

	  	$numberDays = round((strtotime($end_date) - strtotime($begin_date))/(60*60*24));
	  	
		$total['Number of regular visitors'] = 0;	
		  		
		foreach($users as $user)
	  	{
	  		$userImputations = Doctrine_Query::create()
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.user_archive_id = ?',$user->getUserArchiveId())
		  		->groupBy('i.user_archive_id')
		  		->count();
		  		
	  		if(($userImputations/$numberDays)>=(2/30)) $total['Number of regular visitors']++;
	  	}

		$imputations = Doctrine_Query::create()
		    ->select('*')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();

	  	$total["inferior to 10"] = 0;
	  	$total["11 to 20"] = 0;
	  	$total["21 to 30"] = 0;		
	  	$total["31 to 40"] = 0;	
	  	$total["41 to 50"] = 0;	
	  	$total["51 to 60"] = 0;	
	  	$total["61 to 70"] = 0;	
	  	$total["71 to 80"] = 0;	
	  	$total["superior to 80"] = 0;
		  	
	  	foreach($imputations as $imputation)
	  	{
		  	$imputationDate = strtotime($imputation->getImputationDate());
  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
  			
		  	switch($age)
	  		{
	  			case ($age <= 10) :
					$total["inferior to 10"]++;
				break;
	  			case ($age > 10 AND $age <= 20) :
					$total["11 to 20"]++;
	  			break;
	  			case ($age > 20 AND $age <= 30) :
					$total["21 to 30"]++;
	  			break;
	  			case ($age > 30 AND $age <= 40) :
					$total["31 to 40"]++;
	  			break;
	  			case ($age > 40 AND $age <= 50) :
					$total["41 to 50"]++;
	  			break;
	  			case ($age > 50 AND $age <= 60) :
					$total["51 to 60"]++;
	  			break;
	  			case ($age > 60 AND $age <= 70) :
					$total["61 to 70"]++;
	  			break;
	  			case ($age > 70 AND $age <= 80) :
					$total["71 to 80"]++;
	  			break;
	  			default :
	  				$total["superior to 80"]++;
	  			break;
	  		}
	  		
	  		$country = $imputation->getUserArchive()->getCountry();
	  		$city = $imputation->getUserArchive()->getCityName();

	  		if(isset($total[$country][$city])) $total[$country][$city]++;
	  		else $total[$country][$city] = 1;
	  		
	  		if(isset($total[$country][0])) $total[$country][0]++;
	  		else $total[$country][0] = 1;
	  		
	  		$day = date('l', strtotime($imputation->getImputationDate()));
			
			if(isset($total[$day])) $total[$day][0]++;
			else $total[$day][0] = 1;
			
	  		$hour = date('G', strtotime($imputation->getImputationDate()));
			
			switch($hour)
		  	{
	  			case ($hour >= 8 AND $hour < 12) :
					if(isset($total[$day]["8h-12h"])) $total[$day]["8h-12h"]++;
					else $total[$day]["8h-12h"] = 1;
	  			break;
	  			case ($hour >= 12 AND $hour < 16) :
					if(isset($total[$day]["12h-16h"])) $total[$day]["12h-16h"]++;
					else $total[$day]["12h-16h"] = 1;
	  			break;
	  			case ($hour >= 16 AND $hour < 20) :
					if(isset($total[$day]["16h-20h"])) $total[$day]["16h-20h"]++;
					else $total[$day]["16h-20h"] = 1;
	  			break;
	  			default :
					if(isset($total[$day]["20h-24h"])) $total[$day]["20h-24h"]++;
					else $total[$day]["20h-24h"] = 1;
	  			break;
		  	}
		  	
		  	$hourAfter = $hour+1;
		  	$interval = $hour."h-".$hourAfter."h";
		  	
		  	if(isset($total[$day][$interval])) $total[$day][$interval]++;
			else $total[$day][$interval] = 1;
	  	
			$category = $imputation->getUserArchive()->getCategory();
					
			if($category != null)
			{
				$categoryId = Doctrine::getTable('ActPublicCategory')->findOneByDesignation($category)->getId();
				
				if(isset($total['Category'][$categoryId])) $total['Category'][$categoryId]++;
				else $total['Category'][$categoryId] = 1;
			}
			else
			{
				if(isset($total['Category']["No category"])) $total['Category']["No category"]++;
				else $total['Category']["No category"] = 1;
			}
		
	  		$seg = $imputation->getUserArchive()->getSeg();
					
			if($seg != null)
			{
				$segId = Doctrine::getTable('UserSeg')->findOneByDesignation($seg)->getId();
				
				if(isset($total['SEG'][$segId])) $total['SEG'][$segId]++;
				else $total['SEG'][$segId] = 1;
			}
			else
			{
				if(isset($total['SEG']["Other"])) $total['SEG']["Other"]++;
				else $total['SEG']["Other"] = 1;
			}
			
			$building = $imputation->getBuildingDesignation();
			
			$buildingId = Doctrine::getTable('Building')->findOneByDesignation($building)->getId();
			
			if(isset($total['Building'][$buildingId][0])) $total['Building'][$buildingId][0]++;
	  		else $total['Building'][$buildingId][0] = 1;
			
	  		$room = $imputation->getRoomDesignation();
			
	  		$roomId = Doctrine::getTable('Room')->findOneByDesignation($room)->getId();
	  		
	  		if(isset($total['Building'][$buildingId][$roomId][0])) $total['Building'][$buildingId][$roomId][0]++;
	  		else $total['Building'][$buildingId][$roomId][0] = 1;
	  		
	  		$computer = $imputation->getComputerName();
	  		
	  		if($computer != null)
	  		{
	  			$computerId = Doctrine::getTable('Computer')->findOneByName($computer)->getId();
	  			
	  			if(isset($total['Building'][$buildingId][$roomId][$computerId][0])) $total['Building'][$buildingId][$roomId][$computerId][0]++;
	  			else $total['Building'][$buildingId][$roomId][$computerId][0] = 1;
	  		}
	  		else
	  		{
	  			if(isset($total['Building'][$buildingId][$roomId]["Other"][0])) $total['Building'][$buildingId][$roomId]["Other"][0]++;
	  			else $total['Building'][$buildingId][$roomId]["Other"][0] = 1;
	  		}
		  		
	  		$typeOfConnection = $imputation->getComputerTypeOfConnexion();
	  		
		  	if($typeOfConnection != null)
	  		{	
		  		$typeOfConnectionId = Doctrine::getTable('ComputerTypeOfConnexion')->findOneByDesignation($typeOfConnection)->getId();
		  		
		  		if(isset($total['Connection'][$typeOfConnectionId])) $total['Connection'][$typeOfConnectionId]++;
		  		else $total['Connection'][$typeOfConnectionId] = 1;
	  		}
		  		
	  		$awareness = $imputation->getUserArchive()->getAwareness();
	  		
	  		if($awareness != null)
	  		{
	  			$awarenessId = Doctrine::getTable('UserAwareness')->findOneByDesignation($awareness)->getId();
	  			
	  			if(isset($total['Awareness'][$awarenessId])) $total['Awareness'][$awarenessId]++;
	  			else $total['Awareness'][$awarenessId] = 1;
	  		}
	  		else
	  		{
	  			if(isset($total['Awareness']["Not available"])) $total['Awareness']["Not available"]++;
	  			else $total['Awareness']["Not available"] = 1;
	  		}
	  	}
		return $total;
	}
	
	
	public static function getTemporalStatementValuesByAct($begin_date,$end_date)
	{
		$acts = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();

		$publicCategories = Doctrine_Query::create()
		    ->select('a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();	
			
		foreach($acts as $act)
		{
			/*Global data*/
			$numberOfUses = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->fetchOne();
			
			$statement[$act->getDesignation()]['Total time'] = $numberOfUses->getDuration();
			
			$uniqueVisitors = Doctrine_Query::create()
		  		->select('i.user_archive_id as id')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->groupBy('i.user_archive_id')
		  		->execute();
		  		
			$statement[$act->getDesignation()]['Total time of unique visitors'] = 0;
		  		
		  	foreach($uniqueVisitors as $uniqueVisitor)
		  	{
		  		$time = Doctrine_Query::create()
				    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
				    ->from('ImputationArchive i')
			  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
			  		->addWhere('i.designation = ?',$act->getDesignation())
			  		->addWhere('i.user_archive_id = ?',$uniqueVisitor->getId())
			  		->fetchOne();
			  		
			  	$statement[$act->getDesignation()]['Total time of unique visitors'] += $time->getDuration();
		  	}

			/*By Gender*/
			$numberOfMaleUses = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.gender = ?',"Male")
		  		->fetchOne();
		  		
		  	$statement[$act->getDesignation()]['Male'] = $numberOfMaleUses->getDuration();
		  	$statement[$act->getDesignation()]['Female'] =  $numberOfUses->getDuration()-$numberOfMaleUses->getDuration();

		  	/*By age range*/
		  	$imputations = Doctrine_Query::create()
			    ->select('*')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.designation = ?',$act->getDesignation())
		  		->execute();

		  	$statement[$act->getDesignation()]["inferior to 10"] = 0;
		  	$statement[$act->getDesignation()]["11 to 20"] = 0;
		  	$statement[$act->getDesignation()]["21 to 30"] = 0;		
		  	$statement[$act->getDesignation()]["31 to 40"] = 0;	
		  	$statement[$act->getDesignation()]["41 to 50"] = 0;	
		  	$statement[$act->getDesignation()]["51 to 60"] = 0;	
		  	$statement[$act->getDesignation()]["61 to 70"] = 0;	
		  	$statement[$act->getDesignation()]["71 to 80"] = 0;	
		  	$statement[$act->getDesignation()]["superior to 80"] = 0;
		  	
		  	foreach($imputations as $imputation)
		  	{
			  	$imputationDate = strtotime($imputation->getImputationDate());
	  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
	  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
	  			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
	  			
			  	switch($age)
		  		{
		  			case ($age <= 10) :
						$statement[$act->getDesignation()]["inferior to 10"] += $duration;
					break;
		  			case ($age > 10 AND $age <= 20) :
						$statement[$act->getDesignation()]["11 to 20"] += $duration;
		  			break;
		  			case ($age > 20 AND $age <= 30) :
						$statement[$act->getDesignation()]["21 to 30"] += $duration;
		  			break;
		  			case ($age > 30 AND $age <= 40) :
						$statement[$act->getDesignation()]["31 to 40"] += $duration;
		  			break;
		  			case ($age > 40 AND $age <= 50) :
						$statement[$act->getDesignation()]["41 to 50"] += $duration;
		  			break;
		  			case ($age > 50 AND $age <= 60) :
						$statement[$act->getDesignation()]["51 to 60"] += $duration;
		  			break;
		  			case ($age > 60 AND $age <= 70) :
						$statement[$act->getDesignation()]["61 to 70"] += $duration;
		  			break;
		  			case ($age > 70 AND $age <= 80) :
						$statement[$act->getDesignation()]["71 to 80"] += $duration;
		  			break;
		  			default :
		  				$statement[$act->getDesignation()]["superior to 80"] += $duration;
		  			break;
		  		}
		  		
		  		/*By country/city*/
		  		$country = $imputation->getUserArchive()->getCountry();
		  		$city = $imputation->getUserArchive()->getCityName();

		  		if(isset($statement[$act->getDesignation()][$country][$city])) $statement[$act->getDesignation()][$country][$city] += $duration;
		  		else $statement[$act->getDesignation()][$country][$city] = $duration;
		  		if(isset($statement[$act->getDesignation()][$country][0])) $statement[$act->getDesignation()][$country][0] += $duration;
		  		else $statement[$act->getDesignation()][$country][0] = $duration;

		  		/*By day/time slot*/
		  		$day = date('l', strtotime($imputation->getImputationDate()));
			
				if(isset($statement[$act->getDesignation()][$day])) $statement[$act->getDesignation()][$day][0] += $duration;
				else $statement[$act->getDesignation()][$day][0] = $duration;
		  		
				$hour = date('G', strtotime($imputation->getImputationDate()));
			
				switch($hour)
			  	{
		  			case ($hour >= 8 AND $hour < 12) :
						if(isset($statement[$act->getDesignation()][$day]["8h-12h"])) $statement[$act->getDesignation()][$day]["8h-12h"] += $duration;
						else $statement[$act->getDesignation()][$day]["8h-12h"] = $duration;
		  			break;
		  			case ($hour >= 12 AND $hour < 16) :
						if(isset($statement[$act->getDesignation()][$day]["12h-16h"])) $statement[$act->getDesignation()][$day]["12h-16h"] += $duration;
						else $statement[$act->getDesignation()][$day]["12h-16h"] = $duration;
		  			break;
		  			case ($hour >= 16 AND $hour < 20) :
						if(isset($statement[$act->getDesignation()][$day]["16h-20h"])) $statement[$act->getDesignation()][$day]["16h-20h"] += $duration;
						else $statement[$act->getDesignation()][$day]["16h-20h"] = $duration;
		  			break;
		  			default :
						if(isset($statement[$act->getDesignation()][$day]["20h-24h"])) $statement[$act->getDesignation()][$day]["20h-24h"] += $duration;
						else $statement[$act->getDesignation()][$day]["20h-24h"] = $duration;
		  			break;
			  	}
			  	
			  	$hourAfter = $hour+1;
			  	$interval = $hour."h-".$hourAfter."h";
			  	
			  	if(isset($statement[$act->getDesignation()][$day][$interval])) $statement[$act->getDesignation()][$day][$interval] += $duration;
				else $statement[$act->getDesignation()][$day][$interval] = $duration;
				
				/*By category*/
				$category = $imputation->getUserArchive()->getCategory();
				
				if($category != null)
				{
					$categoryId = Doctrine::getTable('ActPublicCategory')->findOneByDesignation($category)->getId();
					
					if(isset($statement[$act->getDesignation()]['Category'][$categoryId])) $statement[$act->getDesignation()]['Category'][$categoryId] += $duration;
					else $statement[$act->getDesignation()]['Category'][$categoryId] = $duration;
				}
				else
				{
					if(isset($statement[$act->getDesignation()]['Category']["No category"])) $statement[$act->getDesignation()]['Category']["No category"] += $duration;
					else $statement[$act->getDesignation()]['Category']["No category"] = $duration;
				}
				
				/*By SEG*/
		  		$seg = $imputation->getUserArchive()->getSeg();
				
				if($seg != null)
				{
					$segId = Doctrine::getTable('UserSeg')->findOneByDesignation($seg)->getId();
					
					if(isset($statement[$act->getDesignation()]['SEG'][$segId])) $statement[$act->getDesignation()]['SEG'][$segId] += $duration;
					else $statement[$act->getDesignation()]['SEG'][$segId] = $duration;
				}
				else
				{
					if(isset($statement[$act->getDesignation()]['SEG']["Other"])) $statement[$act->getDesignation()]['SEG']["Other"] += $duration;
					else $statement[$act->getDesignation()]['SEG']["Other"] = $duration;
				}
					
				/*By building/room/computer*/
				$building = $imputation->getBuildingDesignation();
				
				$buildingId = Doctrine::getTable('Building')->findOneByDesignation($building)->getId();
				
				if(isset($statement[$act->getDesignation()]['Building'][$buildingId])) $statement[$act->getDesignation()]['Building'][$buildingId][0] += $duration;
				else $statement[$act->getDesignation()]['Building'][$buildingId][0] = $duration;
				
				$room = $imputation->getRoomDesignation();

				$roomId = Doctrine::getTable('Room')->findOneByDesignation($room)->getId();
				
				if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][0] += $duration;
				else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][0] = $duration;
				
				$computer = $imputation->getComputerName();

				if($computer != null)
				{
					$computerId = Doctrine::getTable('Computer')->findOneByName($computer)->getId();
					
					if($computerId != null)
					{
						if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId] += $duration;
						else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId][$computerId] = $duration;
					}
					else
					{
						if(isset($statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"])) $statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"] += $duration;
						else $statement[$act->getDesignation()]['Building'][$buildingId][$roomId]["Other"] = $duration;
					}
				}
				
				/*By awareness*/
				$awareness = $imputation->getUserArchive()->getAwareness();
				
			  	if($awareness != null)
		  		{
		  			$awarenessId = Doctrine::getTable('UserAwareness')->findOneByDesignation($awareness)->getId();
		  			
		  			if(isset($statement[$act->getDesignation()]['Awareness'][$awarenessId])) $statement[$act->getDesignation()]['Awareness'][$awarenessId] += $duration;
					else $statement[$act->getDesignation()]['Awareness'][$awarenessId] = $duration;
		  		}
		  		else
		  		{
		  			if(isset($statement[$act->getDesignation()]['Awareness']["Not available"])) $statement[$act->getDesignation()]['Awareness']["Not available"] += $duration;
		  			else $statement[$act->getDesignation()]['Awareness']["Not available"] = $duration;
	  			}
			}
			  
			/*By type of connection*/
			$imputationsUnitaryService = Doctrine_Query::create()
			    ->select('*')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->andWhere('i.designation = ?',$act->getDesignation())
		  		->andWhere('i.imputation_type = ?', "unitary_service")
		  		->execute();
			
		  	foreach($imputationsUnitaryService as $imputationUnitaryService)
		  	{
		  		$typeOfConnection = $imputationUnitaryService->getComputerTypeOfConnexion();
		  		
		  		$typeOfConnectionId = Doctrine::getTable('ComputerTypeOfConnexion')->findOneByDesignation($typeOfConnection)->getId();
		  		
		  		$duration = strtotime($imputationUnitaryService->getDuration())-strtotime("00:00:00");
		  		
		  		if(isset($statement[$act->getDesignation()]['Connection'][$typeOfConnectionId])) $statement[$act->getDesignation()]['Connection'][$typeOfConnectionId] += $duration;
				else $statement[$act->getDesignation()]['Connection'][$typeOfConnectionId] = $duration;
		  	}
		}
		return $statement;
	}
	
	
	public static function getTemporalDetailsPerCategory($begin_date, $end_date)
	{
		$categories = Doctrine_Query::create()
		    ->select('a.id, a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();
	  		
	  	foreach($categories as $category)
	  	{	
	  		$categoryColumn = $category->getId();
	  		
	  		$statement['Details per category'][$categoryColumn]["inferior to 10"] = 0;
		  	$statement['Details per category'][$categoryColumn]["11 to 20"] = 0;
		  	$statement['Details per category'][$categoryColumn]["21 to 30"] = 0;		
		  	$statement['Details per category'][$categoryColumn]["31 to 40"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["41 to 50"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["51 to 60"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["61 to 70"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["71 to 80"] = 0;	
		  	$statement['Details per category'][$categoryColumn]["superior to 80"] = 0;
	  		
	  		$imputations = Doctrine_Query::create()
			    ->select('i.*')
	  			->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.category = ?', $category->getDesignation())
		  		->execute();
		  		
		  	foreach($imputations as $imputation)
		  	{
		  		$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
		  		
		  		if(isset($statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()])) $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()] += $duration;
		  		else $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getGender()] = $duration;

		  		if(isset($statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()])) $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()] += $duration;
		  		else $statement['Details per category'][$categoryColumn][$imputation->getUserArchive()->getCityName()] = $duration;
		  		
		  		$imputationDate = strtotime($imputation->getImputationDate());
	  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
	  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
	  			
			  	switch($age)
		  		{
		  			case ($age <= 10) :
						$statement['Details per category'][$categoryColumn]["inferior to 10"] += $duration;
					break;
		  			case ($age > 10 AND $age <= 20) :
						$statement['Details per category'][$categoryColumn]["11 to 20"] += $duration;
		  			break;
		  			case ($age > 20 AND $age <= 30) :
						$statement['Details per category'][$categoryColumn]["21 to 30"] += $duration;
		  			break;
		  			case ($age > 30 AND $age <= 40) :
						$statement['Details per category'][$categoryColumn]["31 to 40"] += $duration;
		  			break;
		  			case ($age > 40 AND $age <= 50) :
						$statement['Details per category'][$categoryColumn]["41 to 50"] += $duration;
		  			break;
		  			case ($age > 50 AND $age <= 60) :
						$statement['Details per category'][$categoryColumn]["51 to 60"] += $duration;
		  			break;
		  			case ($age > 60 AND $age <= 70) :
						$statement['Details per category'][$categoryColumn]["61 to 70"] += $duration;
		  			break;
		  			case ($age > 70 AND $age <= 80) :
						$statement['Details per category'][$categoryColumn]["71 to 80"] += $duration;
		  			break;
		  			default :
		  				$statement['Details per category'][$categoryColumn]["superior to 80"] += $duration;
		  			break;
		  		}
		  	}
	  	}
	  	return $statement;
	}
	
	public static function getTemporalDetailsPerTimeSlot($begin_date, $end_date)
	{
  		$imputations = Doctrine_Query::create()
		    ->select('i.*')
  			->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
	  		
	  	foreach($imputations as $imputation)
	  	{
	  		$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
	  		
	  		$day = date('l', strtotime($imputation->getImputationDate()));
	  		$hour = date('G', strtotime($imputation->getImputationDate()));
			$hourAfter = $hour+1;
			$interval = $hour."h-".$hourAfter."h";
	  		
	  		if(isset($statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()])) $statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()] += $duration;
	  		else $statement['Details per time slot'][$day][$imputation->getUserArchive()->getGender()] = $duration;

	  		if(isset($statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()])) $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()] += $duration;
	  		else $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getGender()] = $duration;
	  		
	  		if(isset($statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()])) $statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()] += $duration;
	  		else $statement['Details per time slot'][$day][$imputation->getUserArchive()->getCityName()] = $duration;
	  		
	  		if(isset($statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()])) $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()] += $duration;
	  		else $statement['Details per time slot'][$day][$interval][$imputation->getUserArchive()->getCityName()] = $duration;
	  		
	  		$imputationDate = strtotime($imputation->getImputationDate());
  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
  			
		  	switch($age)
	  		{
	  			case ($age <= 10) :
					if(isset($statement['Details per time slot'][$day]["inferior to 10"])) $statement['Details per time slot'][$day]["inferior to 10"] += $duration;
					else $statement['Details per time slot'][$day]["inferior to 10"] = $duration;
					
					if(isset($statement['Details per time slot'][$day][$interval]["inferior to 10"])) $statement['Details per time slot'][$day][$interval]["inferior to 10"] += $duration;
					else $statement['Details per time slot'][$day][$interval]["inferior to 10"] = $duration;
				break;
	  			case ($age > 10 AND $age <= 20) :
					if(isset($statement['Details per time slot'][$day]["11 to 20"])) $statement['Details per time slot'][$day]["11 to 20"] += $duration;
					else $statement['Details per time slot'][$day]["11 to 20"] = $duration;
					
					if(isset($statement['Details per time slot'][$day][$interval]["11 to 20"])) $statement['Details per time slot'][$day][$interval]["11 to 20"] += $duration;
					else $statement['Details per time slot'][$day][$interval]["11 to 20"] = $duration;
	  			break;
	  			case ($age > 20 AND $age <= 30) :
					if(isset($statement['Details per time slot'][$day]["21 to 30"])) $statement['Details per time slot'][$day]["21 to 30"] += $duration;
					else $statement['Details per time slot'][$day]["21 to 30"] = $duration;
					
					if(isset($statement['Details per time slot'][$day][$interval]["21 to 30"])) $statement['Details per time slot'][$day][$interval]["21 to 30"] += $duration;
					else $statement['Details per time slot'][$day][$interval]["21 to 30"] = $duration;
	  			break;
	  			case ($age > 30 AND $age <= 40) :
					if(isset($statement['Details per time slot'][$day]["31 to 40"])) $statement['Details per time slot'][$day]["31 to 40"] += $duration;
	  				else $statement['Details per time slot'][$day]["31 to 40"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["31 to 40"])) $statement['Details per time slot'][$day][$interval]["31 to 40"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["31 to 40"] = $duration;
				break;
	  			case ($age > 40 AND $age <= 50) :
					if(isset($statement['Details per time slot'][$day]["41 to 50"])) $statement['Details per time slot'][$day]["41 to 50"] += $duration;
	  				else $statement['Details per time slot'][$day]["41 to 50"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["41 to 50"])) $statement['Details per time slot'][$day][$interval]["41 to 50"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["41 to 50"] = $duration;
				break;
	  			case ($age > 50 AND $age <= 60) :
					if(isset($statement['Details per time slot'][$day]["51 to 60"])) $statement['Details per time slot'][$day]["51 to 60"] += $duration;
	  				else $statement['Details per time slot'][$day]["51 to 60"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["51 to 60"])) $statement['Details per time slot'][$day][$interval]["51 to 60"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["51 to 60"] = $duration;
				break;
	  			case ($age > 60 AND $age <= 70) :
					if(isset($statement['Details per time slot'][$day]["61 to 70"])) $statement['Details per time slot'][$day]["61 to 70"] += $duration;
	  				else $statement['Details per time slot'][$day]["61 to 70"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["61 to 70"])) $statement['Details per time slot'][$day][$interval]["61 to 70"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["61 to 70"] = $duration;
				break;
	  			case ($age > 70 AND $age <= 80) :
					if(isset($statement['Details per time slot'][$day]["71 to 80"])) $statement['Details per time slot'][$day]["71 to 80"] += $duration;
	  				else $statement['Details per time slot'][$day]["71 to 80"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["71 to 80"])) $statement['Details per time slot'][$day][$interval]["71 to 80"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["71 to 80"] = $duration;
				break;
	  			default :
	  				if(isset($statement['Details per time slot'][$day]["superior to 80"])) $statement['Details per time slot'][$day]["superior to 80"] += $duration;
	  				else $statement['Details per time slot'][$day]["superior to 80"] = $duration;
	  				
	  				if(isset($statement['Details per time slot'][$day][$interval]["superior to 80"])) $statement['Details per time slot'][$day][$interval]["superior to 80"] += $duration;
	  				else $statement['Details per time slot'][$day][$interval]["superior to 80"] = $duration;
	  			break;
	  		}
	  	}
	  	return $statement;
	}
	
	
	
	public static function getTemporalStatementColumns($begin_date,$end_date)
	{
		$citiesTable = array();
		
		$columns['Global Data'] = Array("Total time", "Total time of unique visitors");
		
		$columns['Gender'] = Array("Male", "Female");
		
		$columns['Age range'] = Array("inferior to 10", "11 to 20", "21 to 30", "31 to 40", "41 to 50", "51 to 60", "61 to 70", "71 to 80", "superior to 80");
		
		$columns['Day'] = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

		$columns['Time slot'] = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
		
		$columns[$columns['Time slot'][0]]['Hour'] = Array('8h-9h','9h-10h','10h-11h','11h-12h');
		$columns[$columns['Time slot'][1]]['Hour'] = Array('12h-13h','13h-14h','14h-15h','15h-16h');
		$columns[$columns['Time slot'][2]]['Hour'] = Array('16h-17h','17h-18h','18h-19h','19h-20h');
		$columns[$columns['Time slot'][3]]['Hour'] = Array('20h-21h','21h-22h','22h-23h','23h-24h');
		
		$columns['Hour'] = Array('8h-9h','9h-10h','10h-11h','11h-12h', '12h-13h','13h-14h','14h-15h','15h-16h', '16h-17h','17h-18h','18h-19h','19h-20h', '20h-21h','21h-22h','22h-23h','23h-24h');
		
		$publicCategories = Doctrine_Query::create()
		    ->select('a.id, a.designation')
		    ->from('ActPublicCategory a')
	  		->orderBy('a.sort_order')
	  		->execute();
		
	  	foreach ($publicCategories as $publicCategory)
	  	{
	  		$columns['Category'][$publicCategory->getId()] = $publicCategory->getDesignation();
	  	}

	  	$columns['Category']["Other"] = "No category";
	  	
	  	$segs = Doctrine_Query::create()
			->select('u.id, u.designation')
			->from('UserSeg u')
			->orderBy('u.sort_order')
			->execute();
			
		foreach ($segs as $seg)
	  	{
	  		$columns['SEG'][$seg->getId()] = $seg->getDesignation();
	  	}

	  	$columns['SEG']["Other"] = "Other";
	  	
	  	$buildings = Doctrine_Query::create()
			->select('b.designation')
			->from('Building b')
			->execute();
			
		foreach($buildings as $building)
		{
			$columns['Building'][$building->getId()] = $building->getDesignation();	
		}
		
		$rooms = Doctrine_Query::create()
			->select('r.*')
			->from('Room r')
			->execute();
		
		foreach($rooms as $room)
		{
			$columns[$room->getBuilding()->getId()]['Room'][$room->getId()] = $room->getDesignation();
		}
	  	
		$computers = Doctrine_Query::create()
			->select('c.*')
			->from('Computer c')
			->execute();
		
		foreach($computers as $computer)
		{
			$columns[$computer->getRoom()->getBuilding()->getId()][$computer->getRoom()->getId()]['Computer'][$computer->getId()] = $computer->getName();
		}
			
		$columns[$computer->getRoom()->getBuilding()->getId()][$computer->getRoom()->getId()]['Computer']["Other"] = "Other";
	  	
		$typeOfConnections = Doctrine_Query::create()
			->select('c.designation')
			->from('ComputerTypeOfConnexion c')
			->orderBy('c.designation')
			->execute();
			
		foreach($typeOfConnections as $typeOfConnection)
		{
			$columns['Type of connection'][$typeOfConnection->getId()] = $typeOfConnection->getDesignation();
		}
		
		$awarenesses = Doctrine_Query::create()
			->select('u.designation')
			->from('UserAwareness u')
			->orderBy('u.sort_order')
			->execute();
			
		foreach($awarenesses as $awareness)
		{
			$columns['Awareness'][$awareness->getId()] = $awareness->getDesignation();
		}
		
		$columns['Awareness']["Other"] = "Not available";
		
		$imputations = Doctrine_Query::create()
		    ->select('i.*')
		    ->from('ImputationArchive i')
	  		->where('imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();
		
		foreach($imputations as $imputation)
	  	{
	  		$city = $imputation->getUserArchive()->getCityName();
		  	if(!in_array($city, $citiesTable)) 
		  	{
		  		$citiesTable[] = $city;
		  		$columns['City'][] = $city;
		  	}
	  	}
		
		
		return $columns;
	}
	
	public static function getTotalTemporalStatementValues($begin_date,$end_date)
	{
		$totalTime = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->fetchOne();
			
		$total['Total time'] = $totalTime->getDuration();

		$uniqueVisitors = Doctrine_Query::create()
		  		->select('i.user_archive_id as id')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->groupBy('i.user_archive_id')
		  		->execute();
		  		
		$total['Total time of unique visitors'] = 0;
		  		
	  	foreach($uniqueVisitors as $uniqueVisitor)
	  	{
	  		$time = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->addWhere('i.user_archive_id = ?',$uniqueVisitor->getId())
		  		->fetchOne();
		  		
		  	$total['Total time of unique visitors'] += $time->getDuration();
	  	}
	  	
	  	$numberOfUses = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->fetchOne();
	  	
	  	$numberOfMaleUses = Doctrine_Query::create()
			    ->select('SUM(TIME_TO_SEC(i.duration)) as duration')
			    ->from('ImputationArchive i')
		  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
		  		->leftJoin('i.UserArchive u')
	  			->addWhere('u.gender = ?',"Male")
		  		->fetchOne();
		  		
	  	$total['Male'] = $numberOfMaleUses->getDuration();
	  	$total['Female'] = $numberOfUses->getDuration()-$numberOfMaleUses->getDuration();
	  	
		$imputations = Doctrine_Query::create()
		    ->select('*')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($begin_date,$end_date))
	  		->execute();

	  	$total["inferior to 10"] = 0;
	  	$total["11 to 20"] = 0;
	  	$total["21 to 30"] = 0;		
	  	$total["31 to 40"] = 0;	
	  	$total["41 to 50"] = 0;	
	  	$total["51 to 60"] = 0;	
	  	$total["61 to 70"] = 0;	
	  	$total["71 to 80"] = 0;	
	  	$total["superior to 80"] = 0;
		  	
	  	foreach($imputations as $imputation)
	  	{
		  	$imputationDate = strtotime($imputation->getImputationDate());
  			$creationDate = strtotime($imputation->getUserArchive()->getCreatedAt());
  			$age = $imputation->getUserArchive()->getAge()+round(($imputationDate - $creationDate)/(60*60*24*365));
  			$duration = strtotime($imputation->getDuration())-strtotime("00:00:00");
  			
		  	switch($age)
	  		{
	  			case ($age <= 10) :
					$total["inferior to 10"] += $duration;
				break;
	  			case ($age > 10 AND $age <= 20) :
					$total["11 to 20"] += $duration;
	  			break;
	  			case ($age > 20 AND $age <= 30) :
					$total["21 to 30"] += $duration;
	  			break;
	  			case ($age > 30 AND $age <= 40) :
					$total["31 to 40"] += $duration;
	  			break;
	  			case ($age > 40 AND $age <= 50) :
					$total["41 to 50"] += $duration;
	  			break;
	  			case ($age > 50 AND $age <= 60) :
					$total["51 to 60"] += $duration;
	  			break;
	  			case ($age > 60 AND $age <= 70) :
					$total["61 to 70"] += $duration;
	  			break;
	  			case ($age > 70 AND $age <= 80) :
					$total["71 to 80"] += $duration;
	  			break;
	  			default :
	  				$total["superior to 80"] += $duration;
	  			break;
	  		}
	  		
	  		$country = $imputation->getUserArchive()->getCountry();
	  		$city = $imputation->getUserArchive()->getCityName();

	  		if(isset($total[$country][$city])) $total[$country][$city] += $duration;
	  		else $total[$country][$city] = $duration;
	  		
	  		if(isset($total[$country][0])) $total[$country][0] += $duration;
	  		else $total[$country][0] = $duration;
	  		
	  		$day = date('l', strtotime($imputation->getImputationDate()));
			
			if(isset($total[$day])) $total[$day][0] += $duration;
			else $total[$day][0] = $duration;
			
	  		$hour = date('G', strtotime($imputation->getImputationDate()));
			
			switch($hour)
		  	{
	  			case ($hour >= 8 AND $hour < 12) :
					if(isset($total[$day]["8h-12h"])) $total[$day]["8h-12h"] += $duration;
					else $total[$day]["8h-12h"] = $duration;
	  			break;
	  			case ($hour >= 12 AND $hour < 16) :
					if(isset($total[$day]["12h-16h"])) $total[$day]["12h-16h"] += $duration;
					else $total[$day]["12h-16h"] = $duration;
	  			break;
	  			case ($hour >= 16 AND $hour < 20) :
					if(isset($total[$day]["16h-20h"])) $total[$day]["16h-20h"] += $duration;
					else $total[$day]["16h-20h"] = $duration;
	  			break;
	  			default :
					if(isset($total[$day]["20h-24h"])) $total[$day]["20h-24h"] += $duration;
					else $total[$day]["20h-24h"] = $duration;
	  			break;
		  	}
		  	
		  	$hourAfter = $hour+1;
		  	$interval = $hour."h-".$hourAfter."h";
		  	
		  	if(isset($total[$day][$interval])) $total[$day][$interval] += $duration;
			else $total[$day][$interval] = $duration;
	  		
	  		$category = $imputation->getUserArchive()->getCategory();
					
			if($category != null)
			{
				$categoryId = Doctrine::getTable('ActPublicCategory')->findOneByDesignation($category)->getId();
				
				if(isset($total['Category'][$categoryId])) $total['Category'][$categoryId] += $duration;
				else $total['Category'][$categoryId] = $duration;
			}
			else
			{
				if(isset($total['Category']["No category"])) $total['Category']["No category"] += $duration;
				else $total['Category']["No category"] = $duration;
			}
			
	  		$seg = $imputation->getUserArchive()->getSeg();
					
			if($seg != null)
			{
				$segId = Doctrine::getTable('UserSeg')->findOneByDesignation($seg)->getId();
				
				if(isset($total['SEG'][$segId])) $total['SEG'][$segId] += $duration;
				else $total['SEG'][$segId] = $duration;
			}
			else
			{
				if(isset($total['SEG']["Other"])) $total['SEG']["Other"] += $duration;
				else $total['SEG']["Other"] = $duration;
			}
			
	  		$building = $imputation->getBuildingDesignation();
			
	  		$buildingId = Doctrine::getTable('Building')->findOneByDesignation($building)->getId();
	  		
			if(isset($total['Building'][$buildingId][0])) $total['Building'][$buildingId][0] += $duration;
	  		else $total['Building'][$buildingId][0] = $duration;
			
	  		$room = $imputation->getRoomDesignation();
			
	  		$roomId = Doctrine::getTable('Room')->findOneByDesignation($room)->getId();
	  		
	  		if(isset($total['Building'][$buildingId][$roomId][0])) $total['Building'][$buildingId][$roomId][0] += $duration;
	  		else $total['Building'][$buildingId][$roomId][0] = $duration;
	  		
	  		$computer = $imputation->getComputerName();
	  		
	  		if($computer != null)
	  		{
	  			$computerId = Doctrine::getTable('Computer')->findOneByName($computer)->getId();
	  			
	  			if(isset($total['Building'][$buildingId][$roomId][$computerId][0])) $total['Building'][$buildingId][$roomId][$computerId][0] += $duration;
	  			else $total['Building'][$buildingId][$roomId][$computerId][0] = $duration;
	  		}
	  		else
	  		{
	  			if(isset($total['Building'][$buildingId][$roomId]["Other"][0])) $total['Building'][$buildingId][$roomId]["Other"][0] += $duration;
	  			else $total['Building'][$buildingId][$roomId]["Other"][0] = $duration;
	  		}
			
	  		$typeOfConnection = $imputation->getComputerTypeOfConnexion();
	  		
	  		if($typeOfConnection != null)
	  		{
		  		$typeOfConnectionId = Doctrine::getTable('ComputerTypeOfConnexion')->findOneByDesignation($typeOfConnection)->getId();
		  		
		  		if(isset($total['Connection'][$typeOfConnectionId])) $total['Connection'][$typeOfConnectionId] += $duration;
		  		else $total['Connection'][$typeOfConnectionId] = $duration;
	  		}
		  		
	  		$awareness = $imputation->getUserArchive()->getAwareness();
	  		
	  		if($awareness != null)
	  		{
	  			$awarenessId = Doctrine::getTable('UserAwareness')->findOneByDesignation($awareness)->getId();
	  			
	  			if(isset($total['Awareness'][$awarenessId])) $total['Awareness'][$awarenessId] += $duration;
	  			else $total['Awareness'][$awarenessId] = $duration;
	  		}
	  		else
	  		{
	  			if(isset($total['Awareness']["Not available"])) $total['Awareness']["Not available"] += $duration;
	  			else $total['Awareness']["Not available"] = $duration;
	  		}
	  	}

	  	return $total;
	}
	
	
	
}