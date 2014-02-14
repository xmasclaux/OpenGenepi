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

abstract class ActLib{
	
	/**
	 * Alter a couple duration/unity to a string under the form minutes:hours:days:months:years
	 * This string can be inserted into the database.
	 * 
	 * @param $duration_temp
	 * @param $duration_unity
	 */
	public static function getFormattedDuration($duration_temp,$duration_unity)
	{
		if(is_numeric($duration_temp) && ($duration_unity != 0))
		{
		  	switch ($duration_unity) {
				case 1:
					$duration = $duration_temp.":00:00:00:00";
		   			break;
				case 2:
					$duration = "00:".$duration_temp.":00:00:00";
		    		break;
				case 3:
					$duration = "00:00:".$duration_temp.":00:00";
		    		break;
		    	case 4:
		    		$duration = "00:00:00:".$duration_temp.":00";
		    		break;
				case 5:
					$duration = "00:00:00:00:".$duration_temp;
		    		break;
			}
			
			return $duration;
		}
		else 
		{
			return null;
		}
	}
	
	/**
	 * Alter a string under the form minutes:hours:days:months:years to a couple duration/unity.
	 * 
	 * @param unknown_type $duration
	 */
	public static function getExplodedDuration($duration)
	{
		$explodedDuration = array(); 
		
		if($duration)
	    {
		    $exploded = explode(":", $duration);
		    
		    if(intval($exploded[0]))
		    {
		    	$explodedDuration['duration'] = $exploded[0];
		    	$explodedDuration['unity'] = 1;
		    	$explodedDuration['unity_designation'] = 'minute(s)';
		    }
		
		  	else if(intval($exploded[1]))
		    {
		    	$explodedDuration['duration'] = $exploded[1];
		    	$explodedDuration['unity'] = 2;
		    	$explodedDuration['unity_designation'] = 'hour(s)';
		    }
		    
		  	else if(intval($exploded[2]))
		    {
		    	$explodedDuration['duration'] = $exploded[2];
		    	$explodedDuration['unity'] = 3;
		    	$explodedDuration['unity_designation'] = 'day(s)';
		    }
		    
		  	else if(intval($exploded[3]))
		    {
		    	$explodedDuration['duration'] = $exploded[3];
		    	$explodedDuration['unity'] = 4;
		    	$explodedDuration['unity_designation'] = 'month(s)';
		    }
		    
		  	else
		    {
		    	$explodedDuration['duration'] = $exploded[4];
		    	$explodedDuration['unity'] = 5;
		    	$explodedDuration['unity_designation'] = 'year(s)';
		    }
	    }
	    
	    else
	    {
	    	$explodedDuration['duration'] = null;
		    $explodedDuration['unity'] = 0;
		    $explodedDuration['unity_designation'] = null;
	    }
	    
	    return $explodedDuration;
	}
	
	/**
	 * Alter boolean fields to one string which codes the recurrence of an unitary service.
	 * The length of the string is 7. Each digit codes one day of the week.
	 * 
	 * @param unknown_type $request
	 */
	public static function getFormattedRecurrence($request)
	{
		if($request->getParameter('recurrence_monday'))
		{
			$recurrence = "1";
		}
		else
		{
			$recurrence = "0";
		}
		
		if($request->getParameter('recurrence_tuesday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		if($request->getParameter('recurrence_wednesday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		if($request->getParameter('recurrence_thursday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		if($request->getParameter('recurrence_friday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		if($request->getParameter('recurrence_saturday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		if($request->getParameter('recurrence_sunday'))
		{
			$recurrence .= "1";
		}
		else
		{
			$recurrence .= "0";
		}
		
		return $recurrence;
	}
	
	public static function checkRecurrences($formattedRecurrence, $form)
	{
		if(substr($formattedRecurrence,0,1))
		{
			$form->getWidget('recurrence_monday')->setAttribute('checked', 'checked');
		}
		else
		{ 
			$form->getWidget('recurrence_monday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,1,1)) 
		{
			$form->getWidget('recurrence_tuesday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_tuesday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,2,1)) 
		{
			$form->getWidget('recurrence_wednesday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_wednesday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,3,1)) 
		{
			$form->getWidget('recurrence_thursday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_thursday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,4,1)) 
		{
			$form->getWidget('recurrence_friday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_friday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,5,1)) 
		{
			$form->getWidget('recurrence_saturday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_saturday')->setAttribute('unchecked', 'unchecked');
		}
		
		if(substr($formattedRecurrence,6,1)) 
		{
			$form->getWidget('recurrence_sunday')->setAttribute('checked', 'checked');
		}
		else 
		{
			$form->getWidget('recurrence_sunday')->setAttribute('unchecked', 'unchecked');	
		}
	}
	
	
	public static function getFormattedDatetime($datetime)
	{
		$formattedDatetime = $datetime['year'];
		$formattedDatetime .= "-";
		$formattedDatetime .= $datetime['month'];
		$formattedDatetime .= "-";
		$formattedDatetime .= $datetime['day'];
		$formattedDatetime .= " ";
		
		if($datetime['hour'] != null && $datetime['minute'] != null)
		{
			$formattedDatetime .= $datetime['hour'];
			$formattedDatetime .= ":";
			$formattedDatetime .= $datetime['minute'];
			$formattedDatetime .= ":";
			$formattedDatetime .= "00";
		}
		
		else
		{
			$formattedDatetime .= null;
		}
		
		return $formattedDatetime;
	}
	
	public static function getFormattedDate($date)
	{
	
		$formattedDate = $date['year'];
		$formattedDate .= "-";
		$formattedDate .= $date['month'];
		$formattedDate .= "-";
		$formattedDate .= $date['day'];
		
		return $formattedDate;
	}
	
	public static function getFormattedNumber($number)
	{
		$number = strtr($number,",",".");
    	$convert = array(" " => "");
		$number = strtr($number,$convert);
		
		return $number;
	}
	
}
?>