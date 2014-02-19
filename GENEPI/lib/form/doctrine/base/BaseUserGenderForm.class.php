<?php

/**
 * UserGender form base class.
 *
 * @method UserGender getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserGenderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'designation' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_gender[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserGender';
  }

}
