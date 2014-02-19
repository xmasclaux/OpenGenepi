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

require_once(dirname(__FILE__).'/../../../../mgmt/modules/moderator/lib/ModeratorManagement.class.php');

/**
 * user actions.
 *
 * @package    epi
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {

      $subscriberId = array();

      $tenDaysAgo = date("Y-m-j", mktime(0, 0, 0, date("m"), date("d")-10,  date("Y")));

      $this->user_culture = $this->getUser()->getCulture();
    $this->users = Doctrine::getTable('User')
      ->createQuery('u')
      ->orderBy('u.surname')
      ->execute();

    $this->subscribers = Doctrine_Query::create()
        ->select('u.*')
        ->from('User u')
        ->leftJoin('u.Imputation i')
        ->whereIn('i.imputation_type', "5")
        ->leftJoin('i.ImputationSubscription s')
        ->addWhere('s.final_date > ?',$tenDaysAgo)
        ->orderBy('u.surname')
        ->execute();

    foreach($this->subscribers as $subscriber)
    {
        $subscriberId[$subscriber->getId()] = $subscriber->getId();
    }

    $this->nonSubscribers = Doctrine_Query::create()
        ->select('u.*')
        ->from('User u')
        ->whereNotIn('u.id', $subscriberId)
        ->orderBy('u.surname')
        ->execute();

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
      $this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
      $this->userCulture = $this->getUser()->getCulture();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserForm(array(),array('new' => true));
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form, 1);

    $this->setTemplate('new');

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $login = Doctrine::getTable('login')->find($user['login_id']);
    $user_t = $user->getData();
    $login_id = $user_t['login_id'];
    $login = Doctrine::getTable('login')->find($login_id);
    //$this->form = new UserForm($user,array('login_readonly'=>true));
    $this->form = new UserForm($user);
    $this->userId = $user->getId();
    $this->login = $login;
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserForm($user);

    $this->processForm($request, $this->form, 0);

    $this->setTemplate('edit');

    $this->userId = $user->getId();
  }

  public function executeDelete(sfWebRequest $request)
  {

    $user = $request->getParameter('id');

    // Delete login account
    $userToDelete = Doctrine::getTable('user')->findOneById($user);
    $login_id = $userToDelete['login_id'];
    Doctrine_Query::create()
    ->delete('Login l')
    ->where('l.id = ?',$login_id)
    ->execute();
    
    //Accounts owned by the user to delete
    $accounts = Doctrine_Query::create()
        ->from('AccountUser a')
        ->where('a.user_id = ?', $user)
        ->execute();

    //Foreach account owned
    foreach($accounts as $account)
    {
        $sharedAccounts = Doctrine_Query::create()
            ->from('AccountUser a')
            ->where('a.account_id = ?', $account->getAccount()->getId())
            ->execute();

        if(sizeof($sharedAccounts) == "1")
        {
            Doctrine_Query::create()
                ->delete('Account a')
                ->where('a.id = ?',$account->getAccount()->getId())
                ->execute();
        }
    }

      $imputations = Doctrine_Query::create()
        ->select('i.*')
        ->from('Imputation i')
        ->where('i.user_id = ?', $user)
        ->execute();

      foreach($imputations as $imputation)
    {
        if($imputation->getUserId() != null)
        {
            $imputation->setUserId(null);
            $imputation->save();
        }
    }

    $userArchive = Doctrine::getTable('UserArchive')->findOneByUserId($user);

    Doctrine_Query::create()
        ->update('UserArchive')
        ->set('deleted_at', 'CURRENT_TIMESTAMP')
        ->where('user_id = ?', $user)
        ->execute();

    Doctrine_Query::create()
        ->update('UserArchive')
        ->set('user_id', 'NULL')
        ->where('user_id = ?', $user)
        ->execute();

    Doctrine_Query::create()
        ->delete('Address a')
        ->where('a.id = ?',$request->getParameter('address'))
        ->execute();

    $this->getUser()->setFlash('notice', 'The user has been deleted.');
    $this->redirect('user/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $new)
  {

      $req_param = $request->getParameter($form->getName());

      $req_param['birthdate'] = $req_param['birthdate']['year']."-".$req_param['birthdate']['month']."-".$req_param['birthdate']['day'];

      if($new)
      {
          $req_param['created_at'] = date("Y-m-j H:i:s");
      }

    if(!isset($req_param['login']['locked']) || is_null($req_param['login']['locked']))
    {
      	$req_param['login']['locked'] = 0;
    }
      
    $form->bind($req_param);

    if ($form->isValid())
    {
    	
    	if(!$form->getObject()->isNew() || ModeratorManagement::checkForDoubloon($req_param['login']['login']))
    	{
	        $user = $form->save();
	
	        $country = Doctrine::getTable('AddressCountry')->findOneById($req_param['address']['address_country_id']);
	        if($country) $countryName = $country->getName();
	        else $countryName = null;
	
	        $userSeg = Doctrine::getTable('UserSeg')->findOneById($req_param['user_seg_id']);
	        if($userSeg) $userSegDesignation = $userSeg->getDesignation();
	        else $userSegDesignation = null;
	
	        $userAwareness = Doctrine::getTable('UserAwareness')->findOneById($req_param['user_awareness_id']);
	        if($userAwareness) $userAwarenessDesignation = $userAwareness->getDesignation();
	        else $userAwarenessDesignation = null;
	
	        $userGender = Doctrine::getTable('UserGender')->findOneById($req_param['user_gender_id']);
	        if($userGender) $userGenderDesignation = $userGender->getDesignation();
	        else $userGenderDesignation = null;
	
	        $category = Doctrine::getTable('ActPublicCategory')->findOneById($req_param['act_public_category_id']);
	        if($category) $categoryDesignation = $category->getDesignation();
	        else $categoryDesignation = null;
	
	           $cityName = $req_param['address']['name'];
	
	          if($new)
	          {
		          /*Duplication of certain data in the table user_archive, in a new entry*/
		          $this->values = array(
		            'age'   			=> UserLib::getAge($req_param['birthdate']),
		              'created_at'		=> $req_param['created_at'],
		            'city_name'			=> $cityName,
		              'country'			=> $countryName,
		              'seg'				=> $userSegDesignation,
		              'awareness'			=> $userAwarenessDesignation,
		              'gender'			=> $userGenderDesignation,
		            'category'			=> $categoryDesignation,
		              'user_id'			=> $user->id,
		          );
		
		          $this->archiveForm = new UserArchiveForm();
		
		          $this->archiveForm->bind($this->values);
		
		          if ($this->archiveForm->isValid())
		          {
		              $this->archiveForm->save();
		          }
		
		          $this->getUser()->setFlash('notice', 'The user has been added.');
	          }
	          else
	          {
	
	              /*Duplication of certain data in the table user_archive, in the existing entry*/
	              $updatedUserArchive = Doctrine::getTable('UserArchive')->findOneByUserId($user->id);
	              $updatedUserArchive->setCountry($countryName);
	              $updatedUserArchive->setCityName($cityName);
	              $updatedUserArchive->setSeg($userSegDesignation);
	              $updatedUserArchive->setAwareness($userAwarenessDesignation);
	              $updatedUserArchive->setGender($userGenderDesignation);
	              $updatedUserArchive->setCategory($categoryDesignation);
	              $updatedUserArchive->save();
	
	              $this->getUser()->setFlash('notice', 'The user has been updated.');
	          }
	
	
	      if($req_param['direct_imputation'])
	      {
	          $this->getRequest()->setParameter('user_id', $user->id);
	          $this->forward('use', 'index');
	      }
	      else
	      {
	          $this->redirect('user/index');
	      }
      
    	}
    	else
    	{
    		$this->getUser()->setFlash('error', 'This login already exists, please choose another.');
    	}
    }
    else
    {
      $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }

  public function executeAjaxUserInfo(sfWebRequest $request)
  {
      $finalDate = array();
      $daysLeft = array();
      $daysLate = array();
      $noDaysLeft = array();

      $today = strtotime(date("Y-m-j"));
    $inTenDays = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m"), date("d")+10,  date("Y"))));
    $tenDaysAgo = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m"), date("d")-10,  date("Y"))));
      $subscription = 0;

      $userQuery = Doctrine::getTable('User')->findOneById($request->getParameter('id'));
      $userAccountsQuery = Doctrine::getTable('AccountUser')->findByUserId($request->getParameter('id'));
      $userSubscriptionsQuery = Doctrine_Query::create()
        ->select('i.*')
        ->from('Imputation i')
        ->where('i.user_id = ?', $request->getParameter('id'))
        ->addWhere('i.imputation_type = ?', "5")
        ->execute();

    foreach ($userSubscriptionsQuery as $userSubscriptionQuery)
    {
        $userSubscriptionsFinalDateQuery = Doctrine::getTable('ImputationSubscription')->findOneByImputationId($userSubscriptionQuery->getId());

        $endOfSubscription = strtotime($userSubscriptionsFinalDateQuery->getFinalDate());

        //end of the subscription > today + 10
        if($endOfSubscription > $inTenDays)
        {
            $finalDate[$userSubscriptionsFinalDateQuery->getImputationId()] = $userSubscriptionsFinalDateQuery->getFinalDate();
            $subscription = 1;
        }

        //end of the subscription = today
        else if($endOfSubscription == $today)
        {
            $finalDate[$userSubscriptionsFinalDateQuery->getImputationId()] = $userSubscriptionsFinalDateQuery->getFinalDate();;
            $noDaysLeft[$userSubscriptionsFinalDateQuery->getImputationId()] = 1;
            $subscription = 1;
        }

        //today < end of the subscription < today + 10
        else if(($endOfSubscription > $today) && ($endOfSubscription <= $inTenDays))
        {
            $finalDate[$userSubscriptionsFinalDateQuery->getImputationId()] = $userSubscriptionsFinalDateQuery->getFinalDate();
            $daysLeft[$userSubscriptionsFinalDateQuery->getImputationId()] = date("j",$endOfSubscription-$today);
            $subscription = 1;
        }

        //today - 10 < end of the subscription < today
        else if(($endOfSubscription > $tenDaysAgo) && ($endOfSubscription <= $today))
        {
            $finalDate[$userSubscriptionsFinalDateQuery->getImputationId()] = $userSubscriptionsFinalDateQuery->getFinalDate();
            $daysLate[$userSubscriptionsFinalDateQuery->getImputationId()] = date("j",$today-$endOfSubscription);
            $subscription = 1;
        }

        else
        {
            $finalDate[$userSubscriptionsFinalDateQuery->getImputationId()] = null;
        }
    }

      $this->setTemplate('userInfo','user');
      $this->user = $userQuery;
      $this->userAccounts = $userAccountsQuery;
      $this->userSubscriptions = $userSubscriptionsQuery;
      $this->finalDate = $finalDate;
      $this->daysLate = $daysLate;
      $this->daysLeft = $daysLeft;
      $this->noDaysLeft = $noDaysLeft;
      $this->subscription = $subscription;
      $this->okOnly = $request->getParameter('okOnly');
  }

  public function executeAnonymize(sfWebRequest $request)
  {
  }

  public function executeAnonymization(sfWebRequest $request)
  {
      $anonymization = $request->getParameter('anonymization');

      if($anonymization)
      {
          $anonymized = 0;

          switch($anonymization)
          {
              case 1:
                $maxDate = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m")-3, date("d"),  date("Y"))));
                  $log = "3 months ago";
                break;
              case 2:
                  $maxDate = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m")-6, date("d"),  date("Y"))));
                  $log = "6 months ago";
                  break;
              case 3:
                  $maxDate = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m"), date("d"),  date("Y")-1)));
                  $log = "1 year ago";
                  break;
              case 4:
                  $maxDate = strtotime(date("Y-m-j", mktime(0, 0, 0, date("m"), date("d"),  date("Y")-2)));
                  $log = "2 years ago";
                  break;
          }

          $imputations = Doctrine::getTable('Imputation')
          ->createQuery('a')
          ->execute();

        foreach($imputations as $imputation)
        {
            if((strtotime($imputation->getDate()) < $maxDate) && ($imputation->getUserId() != null) && ($imputation->getImputationType() != "5"))
            {
                $imputation->setUserId(null);
                $imputation->save();
                $anonymized = 1;
            }
        }

        /*$imputationsArchive = Doctrine::getTable('ImputationArchive')
          ->createQuery('a')
          ->execute();

          foreach($imputationsArchive as $imputationArchive)
        {
            if((strtotime($imputationArchive->getImputationDate()) < $maxDate) && ($imputationArchive->getUserId() != null))
            {
                $imputationArchive->setUserId(null);
                $imputationArchive->save();
            }
        }*/

        if ($anonymized)
        {
            $this->getUser()->setFlash('notice', 'The uses have been anonymized.');

            $login = sfContext::getInstance()->getUser()->getAttribute('login');

            ParametersConfiguration::setUserPrefix($login);
            $loginDisplay = ParametersConfiguration::getDefault('default_follow_moderator');

            /*According to the 'default_follow_moderator' parameter, the login will appear in logs or not*/
            if ($loginDisplay)
            {
                $this->getContext()->get('Kernel')->addLog("info", $login." anonymized all the imputations realized more than ".$log.".");
            }
            else
            {
                $this->getContext()->get('Kernel')->addLog("info", "A moderator anonymized all the imputations realized more than ".$log.".");
            }
        }
      }

    $this->redirect('user/index');
  }

  public function executeAccount(sfWebRequest $request)
  {

    $this->accountUsers = Doctrine::getTable('AccountUser')
      ->createQuery('a')
      ->execute();

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
      $this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
      $this->userCulture = $this->getUser()->getCulture();
  }

  public function executeAjaxDeleteAccount(sfWebRequest $request)
  {
      $accountsToDelete = $request->getParameter('id');
      $accountsToDeleteExploded = "";

      if(sizeof($accountsToDelete))
      {
          foreach($accountsToDelete as $accountToDelete)
          {
              $selectedAccounts = 1;
              $accounts[$accountToDelete] = Doctrine::getTable('Account')->findOneById($accountToDelete);

              $accountsToDeleteExploded .= ','.$accountToDelete;

              $accountUsers = Doctrine::getTable('AccountUser')->findByAccountId($accountToDelete);

              foreach($accountUsers as $affectedUser)
              {
                  $user = Doctrine::getTable('User')->findOneById($affectedUser->getUserId());
                  $userName[$accountToDelete][] = $user->getName()." ".$user->getSurname();
              }
          }

          $this->users = $userName;
          $this->accountsToDelete = $accountsToDelete;
          $this->accounts = $accounts;
      }
      else
      {
          $selectedAccounts = 0;
      }

      $this->selectedAccounts = $selectedAccounts;
      $this->accountsToDeleteExploded = $accountsToDeleteExploded;
      $this->setTemplate('userAccount','user');
  }

  public function executeDeleteAccount(sfWebRequest $request)
  {
        $accountsToDelete = $request->getParameter('id');
        $accountsToDelete = explode(",",$accountsToDelete);

        foreach ($accountsToDelete as $accountToDelete)
        {
            if($accountToDelete != null)
            {
                $accountUsers = Doctrine::getTable('AccountUser')->findByAccountId($accountToDelete);

                foreach($accountUsers as $accountUser)
                {
                    Doctrine_Query::create()
                    ->delete('AccountUser a')
                    ->where('a.id = ?',$accountUser->getId())
                    ->execute();
                }

                Doctrine_Query::create()
                    ->delete('Account a')
                    ->where('a.id = ?',$accountToDelete)
                    ->execute();
            }
        }
        $this->getUser()->setFlash('notice', 'The selected account(s) have been deleted.');
      $this->redirect('user/account');
  }

  public function executeAjaxAccountInfo(sfWebRequest $request)
  {

      $accountId = $request->getParameter('id');
      $this->accountUsers = Doctrine::getTable('AccountUser')->findByAccountId($accountId);
      $this->setTemplate('accountInfo','user');
  }

  public function executeExport(sfWebRequest $request)
  {
      $this->users = Doctrine::getTable('User')
      ->createQuery('u')
      ->orderBy('u.surname')
      ->execute();

    ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
      $this->defaultLength = ParametersConfiguration::getDefault('default_num_to_display');
      $this->userCulture = $this->getUser()->getCulture();

  }

  public function executeExportEmail(sfWebRequest $request)
  {

    $usersId = $request->getParameter('usersId');

      $this->setLayout(false);

      if($usersId != null)
      {
          $this->numberEmails = sizeof($usersId);

          $this->users = Doctrine_Query::create()
              ->select('u.*')
            ->from('User u')
            ->whereIn('u.id', $usersId)
            ->orderBy('u.surname')
            ->execute();
      }

      else
      {
          $this->getUser()->setFlash('notice', 'No email addresses selected.');
          $this->redirect('user/export');
      }

  }

  public function executeGroups(sfWebRequest $request)
  {
        $this->groups = Doctrine::getTable('Groups')
        ->createQuery('g')
        ->orderBy('g.name')
        ->execute();
  }

  public function executeGroupnew(sfWebRequest $request)
  {
      $this->groupform = new GroupsForm();
  }

  public function executeGroupcreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->groupform = new GroupsForm();

    $this->processGroupform($request, $this->groupform, 1);

    $this->setTemplate('groupnew');
  }

  protected function processGroupform(sfWebRequest $request, sfForm $form, $new)
  {
    $req_param = $request->getParameter($form->getName());

    $form->bind($req_param);

    if ($form->isValid())
    {
        $group = $form->save();
        $this->redirect('user/groups');
    }
    else
    {
        $this->getUser()->setFlash('error', 'Required field(s) are missing or some field(s) are incorrect.', false);
    }
  }

  public function executeGroupedit(sfWebRequest $request)
  {
    $this->forward404Unless($group = Doctrine::getTable('Groups')->find(array($request->getParameter('id'))), sprintf('Object groups does not exist (%s).', $request->getParameter('id')));
    $this->groupform = new GroupsForm($group);
    $this->groupId = $group->getId();
  }

  public function executeGroupupdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($group = Doctrine::getTable('Groups')->find(array($request->getParameter('id'))), sprintf('Object groups does not exist (%s).', $request->getParameter('id')));
    $this->groupform = new GroupsForm($group);

    $this->processGroupform($request, $this->groupform, 0);

    $this->setTemplate('groupedit');

    $this->groupId = $group->getId();
  }

  public function executeGroupdelete(sfWebRequest $request)
  {
    Doctrine_Query::create()
        ->delete('Groups g')
        ->where('g.id = ?',$request->getParameter('id'))
        ->execute();

    $this->getUser()->setFlash('notice', 'The group has been deleted.');
    $this->redirect('user/groups');
  }

  public function executeGroupusers(sfWebRequest $request)
  {
    $group_id = $request->getParameter('id');

    $this->forward404Unless($group = Doctrine::getTable('Groups')->find(array($group_id)), sprintf('Object groups does not exist (%s).', $group_id));

    $this->group = $group;

    $this->users = Doctrine::getTable('User')
      ->createQuery('u')
      ->orderBy('u.surname')
      ->execute();

    $gp = Doctrine_Query::create()
        ->select('g.*')
        ->from('GroupUser g')
        ->addWhere('g.group_id = ?', $group_id)
        ->execute();

    $group_user = array();
    foreach ($gp as $gpu)
        $group_user[$gpu->getUser_id()] = 1;

    $this->group_user = $group_user;
  }

  public function executeGroupusersupdate(sfWebRequest $request)
  {
    $group_id = $request->getParameter('id');

    $this->forward404Unless($group = Doctrine::getTable('Groups')->find(array($group_id)), sprintf('Object groups does not exist (%s).', $group_id));

    Doctrine_Query::create()
        ->delete('GroupUser g')
        ->where('g.group_id = ?', $group_id)
        ->execute();

    $gpu = $request->getParameter('group_user');
    if (is_array($gpu))
    {
        foreach ($gpu as $k => $user_id)
        {
            $vals = array('group_id' => $group_id, 'user_id' => $user_id);

            $gp_form = new GroupUserForm();
            $gp_form->bind($vals);
            if ($gp_form->isValid())
                $gp_form->save();
        }
    }

    $this->getUser()->setFlash('notice', 'The group has been updated.');
    $this->redirect('user/groups');
  }

}
