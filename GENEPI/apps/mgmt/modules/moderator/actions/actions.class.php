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
 * moderator actions.
 *
 * @package    epi
 * @subpackage moderator
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class moderatorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->moderators = Doctrine::getTable('Moderator')
      ->createQuery('a')
      ->orderBy('a.surname')
      ->execute();
    
    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
    $this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
  	$this->userCulture = $this->getUser()->getCulture();
  }

  public function executeNew(sfWebRequest $request)
  {
  	
  	$isModerator = ($request->getParameter('type') == 'animator')? true : false;
  	$this->isModerator = $isModerator;
  	
  	$moderator = new Moderator();
  	$login = new Login();
  	$login->setIsModerator($isModerator);
  	$moderator->setLogin($login);
  	
    $this->form = new ModeratorForm($moderator, array('new' => true));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $isModerator = ($request->getParameter('type') == 'animator')? true : false;
  	$this->isModerator = $isModerator;

    $this->form = new ModeratorForm(array(), array('new' => true));
    $this->processForm($request, $this->form, true);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($moderator = Doctrine::getTable('Moderator')->find(array($request->getParameter('id'))), sprintf('Object moderator does not exist (%s).', $request->getParameter('id')));
    $this->form = new ModeratorForm($moderator, array('login_readonly' => true, 'login' => $moderator->getId()));

    $this->is_myself = (strtolower(sfContext::getInstance()->getUser()->getAttribute('login')) == strtolower($moderator->getLogin()->getLogin()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
  	
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($moderator = Doctrine::getTable('Moderator')->find(array($request->getParameter('id'))), sprintf('Object moderator does not exist (%s).', $request->getParameter('id')));

    $password_change = $request->getParameter('password_change');
    $this->form = new ModeratorForm($moderator, array('login_readonly' => true, 'login' => $moderator->getId(), 'password_change' => $password_change));

    $this->processForm($request, $this->form);

    $this->is_myself = (sfContext::getInstance()->getUser()->getAttribute('login') == $moderator->getLogin()->getLogin());
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
  	$login = Doctrine::getTable('Login')->findOneById($request->getParameter('id'));
  	
  	$loginToDelete = $login['login'];
  	
  	ModeratorManagement::deleteXML($loginToDelete);
  	
  	Doctrine_Query::create()
    	->delete('Login l')
    	->where('l.id = ?',$request->getParameter('id'))
    	->execute();
  	
	$this->getUser()->setFlash('notice', 'The moderator has been removed.');
    $this->redirect('moderator/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $new = false)
  {
  	
	$req_param = $request->getParameter($form->getName());
	
	$req_param['login']['login'] = strtolower($req_param['login']['login']);

	if(!isset($req_param['login']['is_moderator'])){
		$req_param['login']['is_moderator'] = 'off';
		
	}
 	if(!isset($req_param['login']['locked']) || is_null($req_param['login']['locked'])){
		$req_param['login']['locked'] = 0;
		
	}
	
	$form->bind($req_param);
	
    if ($form->isValid())
    {
		if(!$form->getObject()->isNew() || ModeratorManagement::checkForDoubloon($req_param['login']['login'])){
			
			$moderator = $form->save();
		
	    	if($new){
	    		ModeratorManagement::createXML($moderator->getLogin()->getLogin());
	    		$this->getUser()->setFlash('notice', 'The moderator has been added.');
	    	}
	    	
	    	else
	    	{
	    		$this->getUser()->setFlash('notice', 'The moderator has been updated.');
	    	}
	    	
	   		$this->redirect('moderator/index');
	   		
		}else{
			$this->getUser()->setFlash('error', 'This login already exists, please choose another.');
		}
    	
    }
    else
    {
    	$this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
}
