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
 * auth actions.
 *
 * @package    epi
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class authActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	
  	$this->structure = Doctrine::getTable('Structure')
      	->createQuery('a')
      	->fetchOne();
  	
  	sfContext::getInstance()->getUser()->setAttribute('relativeUrlRoot', $request->getRelativeUrlRoot());
  	
  	if($request->isMethod(sfRequest::POST))
  	{
  		/*$context=sfContext::getInstance();*/
		$login = $this->getRequestParameter('login');
		$password = $this->getRequestParameter('password');
		
		$usersAuth = new usersAuth();
		$checked= $usersAuth->verifyAuth($login, $password);
		
		//if the authentification is done
		if ($checked == 1 || $checked == 2)
		{	
			ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
			$loginDisplay = ParametersConfiguration::getDefault('default_follow_moderator');
			
			/*According to the 'default_follow_moderator' parameter, the login will appear in logs or not*/
			if ($loginDisplay==1){
				$this->getContext()->get('Kernel')->addLog("info", "Authentification success for the login \"".$login."\".");
			}
			else {
				$this->getContext()->get('Kernel')->addLog("info", "Authentification success.");
			}
			
			//Get the preferred culture of the user, based on those which are installed:
		  	$culture = ParametersConfiguration::getDefault('default_language');
			$this->getUser()->setCulture($culture);
			$request->setParameter('sf_culture',$culture);
			
			$this->redirect('@localized_homepage') ;
		}
		//Else, display an error message
		else if ($checked === 0)
		{
			// this delay complicates a brute force attack
			 sleep(1);
			 $this->getUser()->setFlash('error', 'Login or password incorrect. Please try again.', true);
			 $this->getContext()->get('Kernel')->addLog("error", "Authentification denied for the login \"".$login."\".");
		}

  		else if ($checked === -2)
		{
			$this->getUser()->setFlash('error', 'Login and password are correct but your account is locked.', true);
			$this->getContext()->get('Kernel')->addLog("error", "Authentification denied for the login \"".$login."\". Account is locked.");
		}
		
		else 
		{
			//The error message is copied in the error log
			$this->getContext()->get('Kernel')->addLog("error", "Connection to the database failed:\"".$checked."\".");
			$this->getUser()->setFlash('error', 'Impossible authentification. Check the connection to the database.', true);	
		}
	}
	else
	{
		$this->login = null;
		$this->password = null;
	}
	
  }
  
  
  public function executeDisconnect(sfWebRequest $request)
  {

	$usersAuth = new usersAuth();
	$checked= $usersAuth->disconnect();
	$this->redirect('auth/index') ;
  }
  
  /*If an user tries to access to a forbidden url*/ 
  public function executeSecure(sfWebRequest $request)
  {
   /*The user is disconnected*/
	$usersAuth = new usersAuth();
	$checked= $usersAuth->disconnect();
	
	/*A log line is added*/
	$this->getContext()->get('Kernel')->addLog("error", "Login \"".$usersAuth->getLogin()."\" tried to access to a forbidden address.");
	
	/* A flash message is set*/
	$this->getUser()->setFlash('error', 'You tried to access to a fordidden page.', true);
	
	/*The user is redirected to the index page */
	$this->redirect('auth/index') ;
  }
  
  
}
