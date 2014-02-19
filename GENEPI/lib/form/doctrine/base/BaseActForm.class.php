<?php

/**
 * Act form base class.
 *
 * @method Act getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'designation'           => new sfWidgetFormInputText(),
      'shortened_designation' => new sfWidgetFormInputText(),
      'comment'               => new sfWidgetFormInputText(),
      'quantity'              => new sfWidgetFormInputText(),
      'duration'              => new sfWidgetFormInputText(),
      'max_members'           => new sfWidgetFormInputText(),
      'extra_cost'            => new sfWidgetFormInputText(),
      'disabled'              => new sfWidgetFormInputText(),
      'act_type_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActType'), 'add_empty' => false)),
      'unity_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'), 'add_empty' => true)),
      'beginning_datetime'    => new sfWidgetFormDateTime(),
      'end_date'              => new sfWidgetFormDate(),
      'recurrence'            => new sfWidgetFormInputText(),
      'monetary_account'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'           => new sfValidatorString(array('max_length' => 45)),
      'shortened_designation' => new sfValidatorString(array('max_length' => 20)),
      'comment'               => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'quantity'              => new sfValidatorNumber(array('required' => false)),
      'duration'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'max_members'           => new sfValidatorInteger(array('required' => false)),
      'extra_cost'            => new sfValidatorNumber(array('required' => false)),
      'disabled'              => new sfValidatorInteger(array('required' => false)),
      'act_type_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ActType'))),
      'unity_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'), 'required' => false)),
      'beginning_datetime'    => new sfValidatorDateTime(array('required' => false)),
      'end_date'              => new sfValidatorDate(array('required' => false)),
      'recurrence'            => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'monetary_account'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('act[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Act';
  }

}
