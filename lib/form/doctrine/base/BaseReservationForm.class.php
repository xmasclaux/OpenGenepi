<?php

/**
 * Reservation form base class.
 *
 * @method Reservation getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReservationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'designation'        => new sfWidgetFormInputText(),
      'description'        => new sfWidgetFormTextarea(),
      'type'               => new sfWidgetFormChoice(array('choices' => array('user' => 'user', 'group' => 'group'))),
      'type_id'            => new sfWidgetFormInputText(),
      'public'             => new sfWidgetFormInputText(),
      'public_designation' => new sfWidgetFormInputText(),
      'public_description' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'        => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'description'        => new sfValidatorString(array('required' => false)),
      'type'               => new sfValidatorChoice(array('choices' => array('user' => 'user', 'group' => 'group'))),
      'type_id'            => new sfValidatorInteger(),
      'public'             => new sfValidatorInteger(array('required' => false)),
      'public_designation' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'public_description' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reservation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservation';
  }

}
