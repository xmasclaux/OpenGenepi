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
 * struct actions.
 *
 * @package    epi
 * @subpackage struct
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class structActions extends sfActions
{
	/**
	 * Prints the data about the structure, and draw the lists of the buildings, the rooms, the computers and the financiers.
	 * @param sfWebRequest $request
	 */
  public function executeIndex(sfWebRequest $request)
  {
    $this->structure = Doctrine::getTable('Structure')
      	->createQuery('a')
      	->fetchOne();
    
    $this->buildings = Doctrine_Core::getTable('Building')
	    ->createQuery()
	    ->select('b.*, COUNT(r.id) as number_rooms')
	    ->from('Building b')
	    ->leftJoin('b.Room r')
	    ->groupBy('b.id')
	    ->orderBy('b.designation')
	    ->execute();

	$this->rooms = Doctrine_Core::getTable('Room')
	    ->createQuery()
	    ->select('r.*, COUNT(c.id) as number_computers')
	    ->from('Room r')
	    ->leftJoin('r.Computer c')
	    ->groupBy('r.id')
	    ->orderBy('r.designation')
	    ->execute();
	    
    $this->financiers = Doctrine::getTable('Financier')
	    ->createQuery('a')
	    ->orderBy('a.name')
	    ->execute();
    
	$this->computers = Doctrine::getTable('Computer')
	    ->createQuery()
	    ->select('c.*, cosf.family as os_family')
	    ->from('Computer c')
	    ->leftJoin('c.ComputerOs cos')
	    ->leftJoin('cos.ComputerOsFamily cosf')
	    ->groupBy('c.id')
	    ->orderBy('c.name')
	    ->execute();
	
	/*We get the default building, room and computer. They will appear in bold in the lists.*/
	ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
	$this->defaultRoom = ParametersConfiguration::getDefault('default_room');
	$this->defaultComputer = ParametersConfiguration::getDefault('default_computer');
	$this->defaultBuilding = ParametersConfiguration::getDefault('default_building');
  	$this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
  	$this->userCulture = $this->getUser()->getCulture();
  }

  
  /****************************************STRUCTURE***********************************************/
  
  /**
   * Called for editing the structure.
   * @param sfWebRequest $request
   */
  public function executeEditStructure(sfWebRequest $request)
  {
    $this->forward404Unless($structure = Doctrine::getTable('Structure')->find(array($request->getParameter('id'))), sprintf('Object structure does not exist (%s).', $request->getParameter('id')));
    $this->form = new StructureForm($structure);
  }

  /**
   * Called for executing the update of the structure
   * @param sfWebRequest $request
   */
  public function executeUpdateStructure(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($structure = Doctrine::getTable('Structure')->find(array($request->getParameter('id'))), sprintf('Object structure does not exist (%s).', $request->getParameter('id')));
    $this->form = new StructureForm($structure);
    
    $this->processStructureForm($request, $this->form);

    $this->setTemplate('editStructure');
  }

  /**
   * Processes the insert of the new data about the structure.
   * @param $request
   * @param $form
   */
  protected function processStructureForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $structure = $form->save();
      $this->getUser()->setFlash('notice', 'The structure has been updated.');
      $this->redirect('struct/index?');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
  
  
  /*****************************************BUILDING***************************************************/
  
  /**
   * Called for creating a new building
   * @param sfWebRequest $request
   */
  public function executeNewBuilding(sfWebRequest $request)
  {
    $this->form = new BuildingForm(); 
  }
  
  /**
   * Processes the insert of the new building
   * @param sfWebRequest $request
   */
  public function executeCreateBuilding(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BuildingForm();

    $this->processBuildingForm($request, $this->form, 1);

    $this->setTemplate('newBuilding');
  }
  
  /**
   * Displays the current data for the selected building.
   * @param sfWebRequest $request
   */
  public function executeEditBuilding(sfWebRequest $request)
  {
    $this->forward404Unless($building = Doctrine::getTable('Building')->find(array($request->getParameter('id'))), sprintf('Object structure does not exist (%s).', $request->getParameter('id')));
    $this->form = new BuildingForm($building);
    
    /*If the user decides to delete a building, we have to print the associated rooms :*/
    $this->associatedRooms = Doctrine_Core::getTable('Room')
	    ->createQuery()
	    ->select('r.*')
	    ->from('Room r')
	    ->where('r.building_id=?',$request->getParameter('id'))
	    ->execute();
  }
  
  /**
   * Called for executing the update of the building
   * @param sfWebRequest $request
   */
  public function executeUpdateBuilding(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($building = Doctrine::getTable('Building')->find(array($request->getParameter('id'))), sprintf('Object building does not exist (%s).', $request->getParameter('id')));
    $this->form = new BuildingForm($building);

    $this->processBuildingForm($request, $this->form, 0);
    
    $this->setTemplate('editBuilding');
  }

  /**
   * Checks is the building form is correct.
   * @param $request
   * @param $form
   */
  protected function processBuildingForm(sfWebRequest $request, sfForm $form, $new)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $building = $form->save();
      
      if($new)
      {
      	$this->getUser()->setFlash('notice', 'The building has been added.');
      }
      
      else
      {
      	$this->getUser()->setFlash('notice', 'The building has been updated.');
      }
      $this->redirect('struct/index#buildings');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
  
  /**
   * Processes the deletion of a building.
   * @param sfWebRequest $request
   */
  public function executeDeleteBuilding(sfWebRequest $request)
  {

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
  	$defaultBuilding = ParametersConfiguration::getDefault('default_building');
    
  	/*If this building was the default building, we set the parameter 'default_building' to zero.*/
  	if($defaultBuilding == $request->getParameter('id'))
    {
    	ParametersConfiguration::setDefault('default_building',0);
    }
    
    Doctrine_Query::create()
    	->delete('Address a')
    	->where('a.id = ?',$request->getParameter('address'))
    	->execute();
    	
	$this->getUser()->setFlash('notice', 'The building has been deleted.');
    $this->redirect('struct/index#buildings');
  }

  /*****************************************ROOM***************************************************/
  
  /**
   * Called for creating a new room
   * @param sfWebRequest $request
   */
  public function executeNewRoom(sfWebRequest $request)
  {
    $this->form = new RoomForm(); 
  }

  /**
   * Processes the insert of the new room
   * @param sfWebRequest $request
   */
  public function executeCreateRoom(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new RoomForm();

    $this->processRoomForm($request, $this->form, 1);

    $this->setTemplate('newRoom');
  }

  /**
   * Displays the current data for the selected room.
   * @param sfWebRequest $request
   */
  public function executeEditRoom(sfWebRequest $request)
  {
    $this->forward404Unless($room = Doctrine::getTable('Room')->find(array($request->getParameter('id'))), sprintf('Object room does not exist (%s).', $request->getParameter('id')));
    $this->form = new RoomForm($room);
    
    /*If the user decides to delete this room, we have to print the associated computers :*/
    $this->associatedComputers = Doctrine_Core::getTable('Computer')
	    ->createQuery()
	    ->select('c.*')
	    ->from('Computer c')
	    ->where('c.room_id=?',$request->getParameter('id'))
	    ->execute();
  }

  /**
   * Called for executing the update of the room
   * @param sfWebRequest $request
   */
  public function executeUpdateRoom(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($room = Doctrine::getTable('Room')->find(array($request->getParameter('id'))), sprintf('Object room does not exist (%s).', $request->getParameter('id')));
    $this->form = new RoomForm($room);

    $this->processRoomForm($request, $this->form, 0);

    $this->setTemplate('editRoom');
  }
  
  /**
   * Processes the deletion of a room.
   * @param sfWebRequest $request
   */
  public function executeDeleteRoom(sfWebRequest $request)
  {

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
    $defaultRoom = ParametersConfiguration::getDefault('default_room');
    
    /*If this room was the default room, we set the parameter 'default_room' to zero.*/
    if($defaultRoom == $request->getParameter('id'))
    {
    	ParametersConfiguration::setDefault('default_room',0);
    }
    
    Doctrine_Query::create()
    	->delete('Room r')
    	->where('r.id = ?',$request->getParameter('id'))
    	->execute();
    	
	$this->getUser()->setFlash('notice', 'The room has been deleted.');
    $this->redirect('struct/index#rooms');
  }

  /**
   * Checks is the room form is correct.
   * @param $request
   * @param $form
   */
  protected function processRoomForm(sfWebRequest $request, sfForm $form , $new)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $room = $form->save();
      
      if($new)
      {
      	$this->getUser()->setFlash('notice', 'The room has been added.');
      }
      
      else
      {
      	$this->getUser()->setFlash('notice', 'The room has been updated.');
      }
      
      $this->redirect('struct/index#rooms');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
  
  
  /***************************************COMPUTER*****************************************************/
  
  /**
   * Called for creating a new computer
   * @param sfWebRequest $request
   */
  public function executeNewComputer(sfWebRequest $request)
  {
    $this->form = new ComputerForm();
    $this->culture = $this->getUser()->getCulture(); 
  }
  
  /**
   * Processes the insert of the new computer
   * @param sfWebRequest $request
   */  
  public function executeCreateComputer(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ComputerForm();

    $this->culture = $this->getUser()->getCulture(); 
    
    $this->processComputerForm($request, $this->form, 1);

    $this->setTemplate('newComputer');
  }

  /**
   * Displays the current data for the selected computer.
   * @param sfWebRequest $request
   */
  public function executeEditComputer(sfWebRequest $request)
  {
    $this->forward404Unless($computer = Doctrine::getTable('Computer')->find(array($request->getParameter('id'))), sprintf('Object computer does not exist (%s).', $request->getParameter('id')));
    $this->form = new ComputerForm($computer);
    $this->culture = $this->getUser()->getCulture();
  }

  /**
   * Called for executing the update of the computer
   * @param sfWebRequest $request
   */
  public function executeUpdateComputer(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($computer = Doctrine::getTable('Computer')->find(array($request->getParameter('id'))), sprintf('Object computer does not exist (%s).', $request->getParameter('id')));
    $this->form = new ComputerForm($computer);

    $this->processComputerForm($request, $this->form, 0);

    $this->setTemplate('editComputer');
  }

  /**
   * Processes the deletion of a computer.
   * @param sfWebRequest $request
   */
  public function executeDeleteComputer(sfWebRequest $request)
  {

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
    $defaultComputer = ParametersConfiguration::getDefault('default_computer');
    
    /*If this computer was the default computer, we set the parameter 'default_computer' to zero.*/
    if($defaultComputer == $request->getParameter('id'))
    {
    	ParametersConfiguration::setDefault('default_computer',0);
    }
    
    Doctrine_Query::create()
    	->delete('Computer c')
    	->where('c.id = ?',$request->getParameter('id'))
    	->execute();
    	
	$this->getUser()->setFlash('notice', 'The computer has been deleted.');
    $this->redirect('struct/index#computers');
  }
  
  /**
   * Checks is the computer form is correct.
   * @param $request
   * @param $form
   */  
  protected function processComputerForm(sfWebRequest $request, sfForm $form, $new)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $computer = $form->save();
      
      if($new)
      {
      	$this->getUser()->setFlash('notice', 'The computer has been added.');
      }
      
      else
      {
      	$this->getUser()->setFlash('notice', 'The computer has been updated.');
      }
      
      $this->redirect('struct/index#computers');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
  
  /**
   * When an OS family is selected, it sends it to the template _selectOsName
   * @param sfWebRequest $request
   */
  public function executeAjaxOsName(sfWebRequest $request)
  {
    $family = Doctrine::getTable('ComputerOs')
    	->createQuery()
    	->select('c.*')
	    ->from('ComputerOs c')
	    ->where('c.computer_os_family_id = ?',$request->getParameter('family'))
	    ->orderBy('c.sort_order')
	    ->execute();
  	
    return $this->renderPartial('struct/selectOsName', array('family' => $family));
  }
  
  /*****************************************FINANCIER***************************************************/
  
  /**
   * Called for creating a new financier
   * @param sfWebRequest $request
   */
  public function executeNewFinancier(sfWebRequest $request)
  {
    $this->form = new FinancierForm();
    
    $this->financier = null;
  }

  /**
   * Processes the insert of the new financier
   * @param sfWebRequest $request
   */
  public function executeCreateFinancier(sfWebRequest $request)
  {
  	
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FinancierForm();
    
    $this->financier = null;

    $this->processFinancierForm($request, $this->form, 1);

    $this->setTemplate('newFinancier');
  }
  
  /**
   * Displays the current data for the selected financier.
   * @param sfWebRequest $request
   */
  public function executeEditFinancier(sfWebRequest $request)
  {
    $this->forward404Unless($financier = Doctrine::getTable('Financier')->find(array($request->getParameter('id'))), sprintf('Object financier does not exist (%s).', $request->getParameter('id')));
    $this->form = new FinancierForm($financier);
    $this->financier = $financier;
  }
  
  /**
   * Called for executing the update of the financier
   * @param sfWebRequest $request
   */
  public function executeUpdateFinancier(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($financier = Doctrine::getTable('Financier')->find(array($request->getParameter('id'))), sprintf('Object financier does not exist (%s).', $request->getParameter('id')));
    $this->form = new FinancierForm($financier);

    $this->processFinancierForm($request, $this->form, 0);

    $this->setTemplate('editFinancier');
  }

  /**
   * Processes the deletion of a financier.
   * @param sfWebRequest $request
   */
  public function executeDeleteFinancier(sfWebRequest $request)
  {
  	$financier = Doctrine::getTable('Financier')->findOneById($request->getParameter('id'));

    $uploadDir = sfConfig::get('sf_upload_dir').'/images';
    $logoPath = $uploadDir.'/'.$financier->getLogoPath();
    
    /*We delete the logo that was uploaded on the server*/
    if (file_exists($logoPath))
    {
    	unlink($logoPath);
    }
    
    Doctrine_Query::create()
    	->delete('Financier f')
    	->where('f.id = ?',$request->getParameter('id'))
    	->execute();
    
	$this->getUser()->setFlash('notice', 'The financier has been deleted.');
    $this->redirect('struct/index#financiers');
  }
  
  /**
   * Checks is the financier form is correct.
   * @param $request
   * @param $form
   */
  protected function processFinancierForm(sfWebRequest $request, sfForm $form, $new)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $structure = $form->save();
      
      if($new)
      {
      	$this->getUser()->setFlash('notice', 'The financier has been added.');
      }
      else
      {
      	$this->getUser()->setFlash('notice', 'The financier has been updated.');
      }
      	
      $this->redirect('struct/index#financiers');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }
}