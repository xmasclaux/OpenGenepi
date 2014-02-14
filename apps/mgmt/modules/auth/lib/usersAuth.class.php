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
 * Methods of this class are used in the authentification process
 * 
 */

class usersAuth
{
	
	/**
	 * This method verify the login and the password.
	 * If the authentification is successfull, others methods are called in order to connect the user
	 * as Admin or as Viewer.
	 * @return true if the authentification is successfull and false otherwise
	 */
  private $currentUser;
  
  /* Each method of this class can access to the current User thanks to this object*/
  public function __construct(){
  	  $context=sfContext::getInstance();
  	  $this->currentUser=$context->getUser();
	}
  
	/*
	 * Execute connections according the type of user and the validity of the authentification
     * 
     * Returns : 0 if the couple is incorrect.
     * 			 1 if the couple corresponds to a moderator.
     * 			 2 if the couple corresponds to a viewer.
     * 			-1 if we can't connect to the database
     *  	    -2 if the couple matches and the user is locked
	 */
  public function verifyAuth($login, $password)
  {
	  $password = md5("X21LE7PI12".$password); /*The password is crypted with the md5 algorythm with a salt*/
	  $validation = $this->isValidLogin($login, $password);

	  if ($validation == 1)
	  {
		$this->connectAsAdmin();
	  }
	  else if($validation == 2)
	  {
	  	$this->connectAsViewer();
	  }
	  return $validation;
  }
 
  private function connectAsViewer()
  {
	  $this->currentUser->setAuthenticated(true);
	  $this->currentUser->addCredential('viewer');
  }
  
   private function connectAsAdmin()
  {
	  $this->currentUser->setAuthenticated(true);
	  $this->currentUser->addCredential('admin');
	  $this->currentUser->addCredential('viewer');
  }
  
  public function disconnect()
  {

	  $this->currentUser->clearCredentials();
	  $this->currentUser->setAuthenticated(false);
  }
 
  
  /*These functions are used to know  if the user is connected and what is his user type (his credential)
   */
  public function isConnected()
  {
	  return   $this->currentUser->isAuthenticated();
  }
  
  public function isAdmin()
  {
	  if ($this->isConnected()){
	  
		  $credentials=  $this->currentUser->getCredentials();
		  foreach ($credentials as $credential){
			  if ($credential=="admin"){
			  	return true;
			  }
		  }
	  }
	  return false;
  }
  
  public function isViewer()
  {
	   if ($this->isConnected()){
	  
		  $credentials=  $this->currentUser->getCredentials();
		  foreach ($credentials as $credential){
			  if ($credential=="admin"){
			  	return $this->isAdmin();
			  }
		  }
	  }
	  return true;
  }
 
  
	
	/**
     * Check if the couple login/password given in parameter is correct.
     * 
     * Returns : 0 if the couple is incorrect.
     * 			 1 if the couple corresponds to a moderator.
     * 			 2 if the couple corresponds to a viewer.
     * 			-1 if we can't connect to the database
     *  	    -2 if the couple matches and the user is locked
     */
    public function isValidLogin($login, $md5password)
    {
	    try
	    {
		    $loginTable = Doctrine_Core::getTable('Login');
		    $userTable = Doctrine_Core::getTable('Moderator');
		    $valid = $loginTable->findOneByLoginAndPassword($login,$md5password);
		    if($valid)
		    {
		    	$unlocked = $loginTable->findOneByLoginAndPasswordAndLocked($login,$md5password,'0');
		    	
		    	if($unlocked) 
		    	{
		    		$admin = $loginTable->findOneByLoginAndPasswordAndIsModerator($login,$md5password,'1');
		    		
		    		if ($admin)
		    		{
		    			$user = $userTable->findOneByLoginId($admin->getId());
		    		}
		    		else
		    		{
		    			$viewer = $loginTable->findOneByLoginAndPasswordAndIsModerator($login,$md5password,'0');
		    			$user = $userTable->findOneByLoginId($viewer->getId());
		    		}
		    		
		    		$name = $user->getName();
		    		$surname = $user->getSurname();
		    		$userId = $user->getId();
		  			
		    		//Login is not case sensitive.
		    		$this->currentUser->setAttribute('login', strtolower($login));
		    		$this->currentUser->setAttribute('name', $name);
		    		$this->currentUser->setAttribute('surname', $surname);
		    		$this->currentUser->setAttribute('userId', $userId);
		    		
			    	if($admin) return 1; //admin
			    	else return 2; //viewer
		    	}
		    	else return -2;
		    }
		    return 0; //incorrect couple
	   }
	   catch (Doctrine_Connection_Exception $exception)
	   {
	      	//no connection to the database
	      	return $exception->getMessage();
	   }
    }
 
  /*These functions are used to know pieces of information about the current user: name, surname, moderator id
   */
  public function getName()
  {
	return $this->currentUser->getAttribute('name'); 
  }
  
  public function getSurname()
  {
	return $this->currentUser->getAttribute('surname');
  }
  
  public function getUserId()
  {
	return $this->currentUser->getAttribute('userId');
  }
  
  public function getLogin()
  {
	return $this->currentUser->getAttribute('login');
  }
}