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

abstract class PredefinedLists{
	
	/**
	 * The table name for predefined unities.
	 * @var const
	 */
	const UNITY = 'Unity';
	
	/**
	 * The default title display at the top of the Unity list.
	 * @var const
	 */
	const UNITY_TITLE = 'Unities';
	
	/**
	 * The table name for predefined public categories.
	 * @var const
	 */
	const PUBLIC_CATEGORIES = 'ActPublicCategory';
	
	/**
	 * The default title display at the top of the Public Categories list.
	 * @var const
	 */
	const PUBLIC_CATEGORIES_TITLE = 'Public Categories';
	
	/**
	 * The table name for predefined user awareness ways.
	 * @var const
	 */
	const USER_AWARENESS = 'UserAwareness';
	
	/**
	 * The default title display at the top of the awareness ways list.
	 * @var const
	 */
	const USER_AWARENESS_TITLE = 'Awareness Ways';
	
	/**
	 * The table name for predefined socio-economic group.
	 * @var const
	 */
	const USER_SEG = 'UserSeg';
	
	/**
	 * The default title display at the top of the seg list.
	 * @var const
	 */
	const USER_SEG_TITLE = 'Socio-economic Groups';
	
	/**
	 * The table name for predefined operating systems.
	 * @var const
	 */
	const COMPUTER_OS = 'ComputerOs';
	
	/**
	 * The default title display at the top of the OS list.
	 * @var const
	 */
	const COMPUTER_OS_TITLE = 'Operating Systems';
	
	/**
	 * The table name for predefined operating system families.
	 * @var const
	 */
	const COMPUTER_OS_FAMILY = 'ComputerOsFamily';
	
	/**
	 * The default title display at the top of the OS families list.
	 * @var const
	 */
	const COMPUTER_OS_FAMILY_TITLE = 'Operating System Families';
	
	/**
	 * The table name for predefined operating system families.
	 * @var const
	 */
	const METHOD_OF_PAYMENT = 'ImputationMethodOfPayment';
	
	/**
	 * The default title display at the top of the OS families list.
	 * @var const
	 */
	const METHOD_OF_PAYMENT_TITLE = 'Methods of Payment';
	
	/**
	 * This function instanciate a new entry of the table passed as a string in parameter.
	 * It must only be called for the tables which represent a predefined list.
	 * @param string $table_name
	 * @return a new instance of the table passed in parameter
	 */
	public static function instanciate($table_name){
		
		$instance = null;
		
		switch($table_name){
			case self::PUBLIC_CATEGORIES:
				$instance = new ActPublicCategory();
				break;
				
			case self::UNITY:
				$instance = new Unity();
				break;
				
			case self::USER_AWARENESS:
				$instance = new UserAwareness();
				break;
			
			case self::USER_SEG:
				$instance = new UserSeg();
				break;
				
			case self::COMPUTER_OS:
				$instance = new ComputerOs();
				break;
				
			case self::COMPUTER_OS_FAMILY:
				$instance = new ComputerOsFamily();
				break;
				
			case self::METHOD_OF_PAYMENT:
				$instance = new ImputationMethodOfPayment();
				break;
				
			default: break;
		}
		
		return $instance;
	}
	
	
	/**
	 * This function determine the title to display in templates for the table passed in parameter.
	 * It must only be called for the tables which represent a predefined list.
	 * @param string $table_name
	 * @return string The title to display
	 */
	public static function getTableTitle($table_name){
		
		$title = null;
		
		switch($table_name){
			case self::PUBLIC_CATEGORIES:
				$title = self::PUBLIC_CATEGORIES_TITLE;
				break;
				
			case self::UNITY:
				$title = self::UNITY_TITLE;
				break;
				
			case self::USER_AWARENESS:
				$title = self::USER_AWARENESS_TITLE;
				break;
			
			case self::USER_SEG:
				$title = self::USER_SEG_TITLE;
				break;
				
			case self::COMPUTER_OS:
				$title = self::COMPUTER_OS_TITLE;
				break;
				
			case self::COMPUTER_OS_FAMILY:
				$title = self::COMPUTER_OS_FAMILY_TITLE;
				break;
				
			case self::METHOD_OF_PAYMENT:
				$title = self::METHOD_OF_PAYMENT_TITLE;
				break;
				
			default: break;
		}
		
		return $title;
	}
	
	
	/**
	 * This function retrieves data from the database for all the tables that represents predefined lists.
	 * The parameter must be an array. The keys must be the tables name, the values are ignored.
	 * It returns an array, indexed by the same keys of the parameter, containing the data extracted from the database
	 * for each table.
	 * @param array $tables_names
	 */
	public static function getData($tables_names){
		
		$tables_data = $tables_names;
		
		foreach($tables_data as $table_name => $table_data){
			
			if($table_name == PredefinedLists::COMPUTER_OS){
				
				$tables_data[$table_name] = Doctrine_Core::getTable(PredefinedLists::COMPUTER_OS)
			   	->createQuery()
			    ->select('c.*, f.family as family')
			    ->from(PredefinedLists::COMPUTER_OS.' c')
			    ->leftJoin('c.'.PredefinedLists::COMPUTER_OS_FAMILY.' f')
			    ->orderBy('c.sort_order')
			    ->execute();
			    
			}else{
				
				$tables_data[$table_name] = Doctrine_Core::getTable($table_name)
		      	->createQuery()
		      	->select('t.*')
		      	->from($table_name.' t')
		      	->orderBy('t.sort_order')
		     	->execute();
			}
		}
		
		return $tables_data;
		
	}
	
	
	/**
	 * This function removes the ids passed as an array in the first parameter from the table which name
	 * is passed as a string in the second parameter.
	 * @param array $entries_to_remove
	 * @param string $table
	 */
	public static function removeFrom($entries_to_remove, $table){
		
		foreach($entries_to_remove as $entry){
			if(!is_null(($list_entry = Doctrine::getTable($table)->find($entry)))){
				$list_entry->delete();
			}
		}
		
	}
	
	/**
	 * This function adds the designations passed as an array in the first parameter into the table which name
	 * is passed as a string in the second parameter.
	 * @param array $entries_to_add_designation
	 * @param string $table
	 */
	public static function addInto($entries_to_add_designation, $entries_to_add_order, $entries_to_add_short_designation, $entries_to_add_family_id, $table){
		
		foreach($entries_to_add_designation as $key => $entry_designation){
			
			//Instanciate the right table:
			$new_entry = self::instanciate($table);

			//Specifcy the designation and the order in all cases:
			if($table == self::COMPUTER_OS_FAMILY){
				$new_entry->setFamily($entry_designation);
			}else{
				$new_entry->setDesignation($entry_designation);
			}
			
			$new_entry->setSortOrder(intval($entries_to_add_order[$key]));
			
			switch($table){
				
				case self::UNITY:
					//If the table is 'Unity':
					//Specifiy the 'disabled' attribute to false:
					$new_entry->setDisabled(false);
					//Specify the short designation attribute:
					$new_entry->setShortenedDesignation($entries_to_add_short_designation[$key]);
					$new_entry->save();
					break;
				
				case self::COMPUTER_OS:
					//For a OS, specify the foreign key (pointing to a computer os family)
					$new_entry->setComputerOsFamilyId(($entries_to_add_family_id[$key] != 0)? intval($entries_to_add_family_id[$key]) : null);
					$new_entry->save();
					break;
					
				case self::PUBLIC_CATEGORIES:
					$new_entry->save();
					ActPublicCategoryTable::createActPrice($new_entry->id);
					break;
					
				default: 
					$new_entry->save();
					break;
			}
		}
	}
	
	
	/**
	 * This function disables the ids passed as an array in the first parameter from the table which name
	 * is passed as a string in the second parameter.
	 * @param array $entries_to_disable
	 * @param string $table
	 */
	public static function disable($entries_to_disable, $table){
		
		foreach($entries_to_disable as $entry){
			
			if(!is_null(($list_entry = Doctrine::getTable($table)->find($entry)))){
				$list_entry->setDisabled(true);
    			$list_entry->save();
			}
		}
	}
	
	
	public static function update($update_id, $update_short_designation, $update_order, $table){
		
		foreach($update_id as $key => $id){
			
			//Except for the ones that didn't have an id when executeUpdateLists:
			if($id != 'null'){
			
				if($table == PredefinedLists::UNITY){
					
					//If the target is the table 'Unity', also get the shortened designation from the parameters:
					$des = $update_short_designation[$key];
					$order = $update_order[$key];
					//Find the corresponding entry:
					if(!is_null(($list_entry = Doctrine::getTable($table)->find($id)))){
						//Update it:
						$list_entry->setShortenedDesignation($des);
						$list_entry->setSortOrder(intval($order));
						//Save it:
						$list_entry->save();
					}

				}else{
					
					//Otherwise, get the corresponding entry:
					if(!is_null(($list_entry = Doctrine::getTable($table)->find($id)))){
						
						//Update it (only the order there):
						$order = $update_order[$key];
						$list_entry->setSortOrder(intval($order));
						//Save it:
						$list_entry->save();
					}
				}
			}
		}
	}
}