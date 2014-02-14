<?php

/**
 * User form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
  	//We specify the range of the years and the format of the birthdate for an user.
  	$years = range(date('Y'), 1900);
  	
  	$culture = sfContext::getInstance()->getUser()->getCulture();
  	
  	$this->widgetSchema['birthdate'] = new sfWidgetFormI18nDate(array(
  		'culture' => $culture,
  		'years'	  => array_combine($years, $years)
  	));
  	
  	//Public Categories
 	$publicCategories = array(0 => '');
	$publicCategoriesQuery = Doctrine_Query::create()
      	->select('a.designation')
    	->from('ActPublicCategory a')
    	->orderBy('a.sort_order');
    $publicCategoriesRes = $publicCategoriesQuery->fetchArray();
    foreach($publicCategoriesRes as $publicCategory){
    	$publicCategories[$publicCategory['id']] = $publicCategory['designation'];
    }
    
    $this->widgetSchema['act_public_category_id'] = new sfWidgetFormSelect(array('choices' => $publicCategories));
    
    //SEG
    $segs = array(0 => '');
	$segsQuery = Doctrine_Query::create()
      	->select('s.designation')
    	->from('UserSeg s')
    	->orderBy('s.sort_order');
    $segsRes = $segsQuery->fetchArray();
    foreach($segsRes as $seg){
    	$segs[$seg['id']] = $seg['designation'];
    }
    
    $this->widgetSchema['user_seg_id'] = new sfWidgetFormSelect(array('choices' => $segs));
    
    //Awareness
    $awarenesses = array(0 => '');
	$awarenessesQuery = Doctrine_Query::create()
      	->select('a.designation')
    	->from('UserAwareness a')
    	->orderBy('a.sort_order');
    $awarenessesRes = $awarenessesQuery->fetchArray();
    foreach($awarenessesRes as $awareness){
    	$awarenesses[$awareness['id']] = $awareness['designation'];
    }
    
    $this->widgetSchema['user_awareness_id'] = new sfWidgetFormSelect(array('choices' => $awarenesses));
  	
    $this->widgetSchema['direct_imputation'] = new sfWidgetFormInputHidden();
    $this->setDefault('direct_imputation',"0");
    
    unset($this['address_id']);
  	//$this->widgetSchema['address_id'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema['login_id'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema['comment'] = new sfWidgetFormTextarea();

  	//We check if the name is set and if it's correct.
  	$this->setValidator('name', new sfValidatorString(
  		array('max_length' => 45), 
  		array('required'   => 'The name field is compulsory.', 
  			  'max_length' => 'The name field must not exceed %max_length% characters.')
  	));
  	
  	//We check if the surname is set and if it's correct.
    $this->setValidator('surname', new sfValidatorString(
     	array('max_length' => 45), 
     	array('required'   => 'The surname field is compulsory.',
     		  'max_length' => 'The surname field must not exceed %max_length% characters.')
  	));
     
    //We check if the birthdate is set and if it's correct.
    $this->setValidator('birthdate', new sfValidatorDate(
      	array(), 
      	array('required' => 'The birthdate field is compulsory.',
      		  'invalid'  => 'This birthdate is invalid.')
    ));
    
    $this->setValidator('created_at', new sfValidatorString(
     	array('required' => false), 
     	array()
  	));
    
    $this->setValidator('organization_name', new sfValidatorString(
     	array('required' => false, 'max_length' => 45), 
     	array('max_length' => 'The organization name field must not exceed %max_length% characters.')
  	));
    
  	//We check if the email address is correct.
  	$this->setValidator('email', new sfValidatorEmail(
   		array('required' => false), 
   		array('invalid'  => 'This email address is invalid.') 
  	));
    
  	$this->setValidator('cellphone_number', new sfValidatorString(
     	array('max_length' => 20, 'required' => false), 
     	array('max_length' => 'The cellphone number field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('comment', new sfValidatorString(
     	array('required' => false, 'max_length' => 250), 
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('user_gender_id', new sfValidatorString(
     	array('required' => true), 
     	array('required' => 'The gender field is compulsory.')
  	));
  	
  	$this->setValidator('user_seg_id', new sfValidatorString(
     	array('required' => false), 
     	array()
  	));
  	
  	$this->setValidator('user_awareness_id', new sfValidatorString(
     	array('required' => false), 
     	array()
  	));
  	
  	$this->setValidator('act_public_category_id', new sfValidatorString(
     	array('required' => false), 
     	array()
  	));
  	
  	$this->setValidator('direct_imputation', new sfValidatorString(
     	array('required' => false), 
     	array()
  	));

    //We set the labels for these fields.
    $this->widgetSchema->setLabel('comment', 'Further information');
    $this->widgetSchema->setLabel('user_gender_id', 'Gender');
    $this->widgetSchema->setLabel('user_seg_id', 'Socio-economic group'); 
    $this->widgetSchema->setLabel('user_awareness_id', 'Awareness'); 
    $this->widgetSchema->setLabel('act_public_category_id', 'Category'); 
    
    $this->widgetSchema->setNameFormat('form[%s]');
    
    
    /*Add an embed login form*/
    $subFormLogin = new LoginForm($this->getObject()->getLogin(),array('user_only'=>true, 'login_readonly'=>$this->getOption('login_readonly')));
    $subFormLogin->widgetSchema->setLabel('login', 'Login');
    $this->embedForm('login', $subFormLogin);

    
    
  	//We embed a subform Address
  	$subFormAddress = new AddressForm($this->getObject()->getAddress());
  	$this->embedForm('address', $subFormAddress);
  }
}
