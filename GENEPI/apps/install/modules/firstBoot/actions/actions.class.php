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

define('PROJECT_CONFIGURATION',dirname(__FILE__).'/../../../../mgmt/modules/configuration/lib/ParametersConfiguration.class.php');
require_once(PROJECT_CONFIGURATION);
require_once(dirname(__FILE__).'/../../../../mgmt/modules/moderator/lib/ModeratorManagement.class.php');
require_once(dirname(__FILE__).'/../../../../mgmt/modules/moderator/lib/DefaultParametersFile.class.php');
require_once(dirname(__FILE__).'/../../../../core/modules/kernel/lib/Kernel.class.php');


/**
 * firstBoot actions.
 *
 * @package    epi
 * @subpackage firstBoot
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class firstBootActions extends sfActions
{

	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
    {
    	$configuration = sfProjectConfiguration::getActive();
    	$cultures = Kernel::getInstalledCultures($configuration);
    	$cultures[] = "en";

    	$this->cultures = ParametersConfiguration::formatLanguages(array_fill_keys($cultures, null));
    }

    public function executeIntroduction(sfWebRequest $request)
    {
    	$culture = $request->getParameter('culture');

    	$this->getUser()->setCulture($culture);
    }

    public function executeStepOne(sfWebRequest $request)
    {
     	$this->form = new SystemParametersForm($this->values);
     	$this->error = null;
    }

  	public function executeSystemParameters(sfWebRequest $request)
  	{
		$error = 0;

		$this->forward404Unless($request->isMethod(sfRequest::POST));

		//If the HTTP method is "post", get the values entered by the user:

		$this->values = array(
            'ip_address'   => $this->getRequestParameter('ip_address'),
            'srv_port'     => $this->getRequestParameter('srv_port'),
            'dbms'         => $this->getRequestParameter('dbms') + 1,
            'db_name'      => $this->getRequestParameter('db_name'),
            'db_user_name' => $this->getRequestParameter('db_user_name'),
            'db_password'  => $this->getRequestParameter('db_password'),
            '_csrf_token'  => $this->getRequestParameter('_csrf_token'),
		);

		//Build the form with theses values:
		$form = new SystemParametersForm($this->values);

		//Execute the validators of this form:
		$form->bind($this->values);

		//If everything is fine:
  		if ($form->isValid())
  		{
			//Insert the new values in the xml configuration file:*/
			ParametersConfiguration::setBddParams($this->values);
			ParametersConfiguration::editYaml();

  			sfToolkit::clearGlob(sfConfig::get('sf_cache_dir').'/install/*');

  			$this->redirect('firstBoot/stepTwo');
		}

		else
		{
			$this->form=$form;
			$this->setTemplate("stepOne");
		}

	  }

	  public function executeStepTwo(sfWebRequest $request)
	  {
	  }

	  public function executeUpdateStructure(sfWebRequest $request)
      {
        $structureName = $request->getParameter('structure_name');

        if(strlen($structureName))
        {
            $structure = Doctrine::getTable('Structure')
            ->createQuery('a')
            ->fetchOne();

            // -----------------------------------------------------------------------------------------------------------
            // KYXAR 0008 - 08/07/2011
            // On vérifie qu'il y a bien une structure en BD
                    if ($structure === false)
            {
                $address = Doctrine::getTable('address')
                    ->createQuery('a')
                    ->fetchOne();

                if ($address === false)
                {
                    $addr = new Address();
                    $addr->setAddress_city_id(40147);
                    $addr->save();

                    $address = Doctrine::getTable('address')
                        ->createQuery('a')
                        ->fetchOne();
                }

                $addr_id = $address->getId();

                $struct = new Structure();
                $struct->setName($structureName);
                $struct->setLogo_path('logo.png');
                $struct->setAddress_id($addr_id);
                $struct->save();

                $structure = Doctrine::getTable('Structure')
                    ->createQuery('a')
                    ->fetchOne();
            }
            // FIN KYXAR
            // -----------------------------------------------------------------------------------------------------------

            $structure->setName($structureName);
            $structure->save();

            $this->getUser()->setFlash('notice', 'The structure has been created.');
            $this->redirect('firstBoot/stepThree');
        }
        else
        {
            $this->getUser()->setFlash('error', 'The structure name cannot be empty.', false);
            $this->setTemplate('stepTwo');
        }
	  }


	  public function executeStepThree(sfWebRequest $request)
	  {
	  	$error = 0;

  		$configuration = sfProjectConfiguration::getActive();
		$db = new sfDatabaseManager($configuration);

		foreach ($db->getNames() as $connection)
		{
			try
			{
				@$db->getDatabase($connection)->getConnection();
			}
			catch(Exception $e)
			{
				$error = 1;
			}
		}

		if($error == 1)
		{
			$this->getUser()->setFlash('error',$e->getMessage());
			$this->redirect('firstBoot/stepOne');
		}

		$moderator = new Moderator();
	  	$login = new Login();
	  	$login->setIsModerator(true);
	  	$moderator->setLogin($login);

	    $this->form = new ModeratorForm($moderator, array('new' => true));
	  }

	  public function executeCreateNewUser(sfWebRequest $request)
	  {
	    $this->forward404Unless($request->isMethod(sfRequest::POST));

	    $this->form = new ModeratorForm(array(), array('new' => true));
	    $this->processForm($request, $this->form, true);

	    $this->setTemplate('stepThree');
	  }

	  protected function processForm(sfWebRequest $request, sfForm $form, $new = false)
	  {
		$req_param = $request->getParameter($form->getName());

		if(!isset($req_param['login']['is_moderator'])){
			$req_param['login']['is_moderator'] = 'on';

		}
	 	if(!isset($req_param['login']['locked']) || is_null($req_param['login']['locked'])){
			$req_param['login']['locked'] = 0;

		}

		$form->bind($req_param);

	    if ($form->isValid())
	    {
	    	if(ModeratorManagement::checkForDoubloon($req_param['login']['login']))
	    	{
				$moderator = $form->save();

		    	if($new)
		    	{
		    		ModeratorManagement::createXML($moderator->getLogin()->getLogin());
		    	}

		    	firstBootLib::editSecurity();

		    	$installPath = ProjectConfiguration::guessRootDir().'/web/index.php';
		    	rename($installPath, 'install.php');
		    	$indexPath = ProjectConfiguration::guessRootDir().'/web/genepi.php';
		    	rename($indexPath, 'index.php');

		    	firstBootLib::editUploadParameters();

		   		header("Location: "."http://".$_SERVER["SERVER_NAME"]);
		   		exit();
	    	}
	    	else
	    	{
	    		$this->getUser()->setFlash('error', 'This login already exists, please choose another.');
	    	}
	    }
	 }

     public function execute404Error(sfWebRequest $request)
  	 {
    	header("Location: "."http://".$_SERVER["SERVER_NAME"]);
		exit();
     }
}