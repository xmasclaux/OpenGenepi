<?php

/**
 * Unitary service form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class UnitaryServiceForm extends sfForm{

	public function setup(){

		$minutes = array("00", "15", "30", "45");
		$hours = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
		$beginning_years = range(date('Y'), date('Y') + 3);
		$end_years = range(date('Y'), date('Y') + 5);
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$durationUnities = array(
			'0'		=> '',
			'1' 	=> 'minute(s)',
			'2' 	=> 'hour(s)'
		);

		/*----------------------------------WIDGETS----------------------------------------------*/

	  	$this->setWidgets(array(
	  		'designation' 			        => new sfWidgetFormInputText(),
	  		'shortened_designation' 	    => new sfWidgetFormInputText(),
	  		'comment' 						=> new sfWidgetFormTextarea(),
	  		'duration' 						=> new sfWidgetFormInputHidden(),
	  		'duration_temp'					=> new sfWidgetFormInputText(),
	  		'duration_unity'              	=> new sfWidgetFormSelect(array('choices' => $durationUnities)),
	  		'beginning_datetime'			=> new sfWidgetFormI18nDateTime(
	  											array('culture' => $culture),
	  											array('date' => array(
                    									'can_be_empty' => true,
                    									'years' => array_combine($beginning_years, $beginning_years)),
                  									  'format' => '%date% - %time%',
	  												  'time' => array(
	  													'minutes' => array_combine($minutes, $minutes),
	  													'hours' => array_combine($hours, $hours)
	  													)
	  												)),
	  		'end_date'						=> new sfWidgetFormI18nDate(
	  											array('culture' => $culture,
	  												'years' => array_combine($end_years, $end_years))),
	  		'recurrence'					=> new sfWidgetFormInputHidden(),
	  		'recurrence_monday'				=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_tuesday'			=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_wednesday'			=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_thursday'			=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_friday'				=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_saturday'			=> new sfWidgetFormInputCheckbox(),
	  		'recurrence_sunday'				=> new sfWidgetFormInputCheckbox(),
	  		'act_type_id'					=> new sfWidgetFormInputHidden(),
	    ));

	    $this->widgetSchema->setLabels(array(
	    	'designation'                   => 'Act name',
	  		'shortened_designation'         => 'Shortened name',
	    	'recurrence_monday'				=> 'Monday',
	  		'recurrence_tuesday'			=> 'Tuesday',
	  		'recurrence_wednesday'			=> 'Wednesday',
	  		'recurrence_thursday'			=> 'Thursday',
	  		'recurrence_friday'				=> 'Friday',
	  		'recurrence_saturday'			=> 'Saturday',
	  		'recurrence_sunday'				=> 'Sunday',
	    	'beginning_datetime'			=> 'Beginning date and time',
	    	'end_date'						=> 'End of the recurrence',
	    ));

	    $this->widgetSchema->setDefaults(array(
	    	'act_type_id'                  => '2',
	    ));

	    /*-----------------------------------VALIDATORS-------------------------------------------*/

	   	$this->setValidator('designation', new sfValidatorString(
     	array('max_length' => 45, 'required' => true),
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  		));

  		$this->setValidator('shortened_designation', new sfValidatorString(
     	array('max_length' => 20, 'required' => true),
     	array('max_length' => 'The shortened name field must not exceed %max_length% characters.',
     		  'required' => 'The shortened name field is compulsory.')
  		));

  		$this->setValidator('comment', new sfValidatorString(
     	array('max_length' => 250, 'required' => false),
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  		));

  		$this->setValidator('duration_temp', new sfValidatorNumber(
  		array('required' => true, 'min' => 0),
  		array('min' => 'The duration must be positive.',
  			  'invalid' => 'The duration must be a number.',
  			  'required' => 'The duration field is compulsory.')
  		));

  		$this->setValidator('beginning_datetime', new sfValidatorString(
     	array('required' => false)
  		));

  		$this->setValidator('end_date', new sfValidatorString(
     	array('required' => false)
  		));

  		$this->setValidator('duration', new sfValidatorString(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence', new sfValidatorString(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_monday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_tuesday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_wednesday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_thursday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_friday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_saturday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('recurrence_sunday', new sfValidatorBoolean(
     	array('required' => false)
  		));

  		$this->setValidator('act_type_id', new sfValidatorString(
     	array('required' => true)
  		));


	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/

	    $this->widgetSchema->setNameFormat('%s');
	    $this->widgetSchema->setLabel('duration_temp', 'Duration');

	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

	}

}