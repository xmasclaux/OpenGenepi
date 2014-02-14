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

class ImputationDefaultValues{
	
	const ACCOUNT_TRANSACTION_TYPE = 1;
	
	const PURCHASE_TYPE            = 2;
	
	const COUNTABLE_SERVICE_TYPE   = 3;
	
	const UNITARY_SERVICE_TYPE     = 4;
	
	const SUBSCRIPTION_TYPE        = 5;
	
	
	
	const DEFAULT_COMPUTER = 'default_computer';
	
	const DEFAULT_ROOM     = 'default_room';
	
	const DEFAULT_BUILDING = 'default_building';
	
	
	const ACCOUNT_METHOD_OF_PAYMENT = 'Account';
	
	const FREE_METHOD_OF_PAYMENT = 'Free';
	
	
	/**
	 * 
	 * @param string $ressource
	 * @param integer $type
	 */
	public static function getDefaultValueByType($ressource, $type){
		
		switch($ressource){
			
			case self::DEFAULT_COMPUTER:
				return self::getComputerByType($type);
				break;
				
			case self::DEFAULT_BUILDING:
				return self::getBuildingByType($type);
				break;
				
			case self::DEFAULT_ROOM:
				return self::getRoomByType($type);
				break;
				
			default:
				return null;
		}
	}
	
	
	/**
	 * 
	 */
	public static function getAccountMethodId(){
		
		$tab_method = Doctrine_Query::create()
			->select('m.designation, m.id')
			->where('m.designation = ?', self::ACCOUNT_METHOD_OF_PAYMENT)
			->addWhere('m.designation = ?', strtolower(self::ACCOUNT_METHOD_OF_PAYMENT))
			->addWhere('m.designation = ?', strtoupper(self::ACCOUNT_METHOD_OF_PAYMENT))
			->from('ImputationMethodOfPayment m')
			->fetchOne();
			
		if(!is_null($tab_method)){
			return $tab_method['id'];
		}else{
			return null;
		}
	}
	
	/**
	 * 
	 */
	public static function getFreeMethodId(){
		
		$tab_method = Doctrine_Query::create()
			->select('m.designation, m.id')
			->where('m.designation = ?', self::FREE_METHOD_OF_PAYMENT)
			->addWhere('m.designation = ?', strtolower(self::FREE_METHOD_OF_PAYMENT))
			->addWhere('m.designation = ?', strtoupper(self::FREE_METHOD_OF_PAYMENT))
			->from('ImputationMethodOfPayment m')
			->fetchOne();
			
		if(!is_null($tab_method)){
			return $tab_method['id'];
		}else{
			return null;
		}
	}
	
	
	/**
	 * 
	 */
	public static function getDefaultCurrencySymbol(){
		
		$id_def_currency = ParametersConfiguration::getDefault('default_currency');
		
		$def_currency = Doctrine::getTable('Unity')
				->find($id_def_currency);
				
		if($def_currency != null){
			return $def_currency['shortened_designation'];
		}else{
			return '€';
		}
	}
	
	
	/**
	 * 
	 * @param integer $type
	 */
	private static function getComputerByType($type){
		
		switch($type){
			
			case self::ACCOUNT_TRANSACTION_TYPE:
				return null;
				break;
				
			case self::PURCHASE_TYPE:
				return null;
				break;
				
			case self::COUNTABLE_SERVICE_TYPE:
				return null;
				break;
				
			case self::UNITARY_SERVICE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_COMPUTER);
				break;
				
			case self::SUBSCRIPTION_TYPE:
				return null;
				break;
				
			default:
				return null;
		}
	}
	
	
	/**
	 * 
	 * @param integer $type
	 */
	private static function getRoomByType($type){
		
		switch($type){
			
			case self::ACCOUNT_TRANSACTION_TYPE:
				return null;
				break;
				
			case self::PURCHASE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_ROOM);
				break;
				
			case self::COUNTABLE_SERVICE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_ROOM);
				break;
				
			case self::UNITARY_SERVICE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_ROOM);
				break;
				
			case self::SUBSCRIPTION_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_ROOM);
				break;
				
			default:
				return null;
		}
	}
	
	
	/**
	 * 
	 * @param integer $type
	 */
	private static function getBuildingByType($type){
		
		switch($type){
			
			case self::ACCOUNT_TRANSACTION_TYPE:
				return null;
				break;
				
			case self::PURCHASE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_BUILDING);
				break;
				
			case self::COUNTABLE_SERVICE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_BUILDING);
				break;
				
			case self::UNITARY_SERVICE_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_BUILDING);
				break;
				
			case self::SUBSCRIPTION_TYPE:
				return ParametersConfiguration::getDefault(self::DEFAULT_BUILDING);
				break;
				
			default:
				return null;
		}
	}
	
}