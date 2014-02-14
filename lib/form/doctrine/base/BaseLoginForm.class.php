<?php

/**
 * Login form base class.
 *
 * @method Login getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLoginForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'login'        => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'is_moderator' => new sfWidgetFormInputText(),
      'locked'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'login'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'password'     => new sfValidatorString(array('max_length' => 40)),
      'is_moderator' => new sfValidatorInteger(),
      'locked'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Login';
  }

}
