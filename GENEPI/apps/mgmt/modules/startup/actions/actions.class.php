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
 * startup actions.
 *
 * @package    epi
 * @subpackage startup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

define('USERS_AUTH',dirname(__FILE__).'/../../auth/lib/usersAuth.class.php');

require_once(USERS_AUTH);


class startupActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeInit(sfWebRequest $request)
  {
  	
	//Check if kernel init went fine:
  	$this->status = $this->getContext()->get('KernelStatus');
  	
  	$this->getContext()->getUser()->setAttribute('relativeUrlRoot',$request->getRelativeUrlRoot());
	
  	//Add the log entry corresponding to the Kernel status:
  	$log_ok = $this->getContext()->get('Kernel')->addLogIf(empty($this->status),
  					array('info' => 'Application startup successful', 'error' => 'Application startup failed.'));
  					
	//Check if error occured while logging:
  	if(!$log_ok) $this->status['log'] = 'Log files are unreachable, please check permissions on the log directory.';
  	
  	//Edit the databases.yml file:
	ParametersConfiguration::editYaml();
  	
  	//Redirect to the localized homepage if everything went fine:
  			
			$usersAuth = new usersAuth();
			
	/*Depending on the user Type (disconnected, admin, viewer), a redirection is done*/
			if($usersAuth->isAdmin()){
 				$this->redirectIf(empty($this->status),'@localized_homepage');
			}
  			else if($usersAuth->isViewer()){
 				$this->redirectIf(empty($this->status),'@localized_homepage');
			}
			else{
				$this->redirectIf(empty($this->status),'@authentification');
			}
  }
}
