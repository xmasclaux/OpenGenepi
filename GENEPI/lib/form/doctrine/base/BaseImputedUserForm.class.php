<?php

/**
 * ImputedUser form base class.
 *
 * @method ImputedUser getObject() Returns the current form's model object
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputedUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'imputation_id' => new sfWidgetFormInputHidden(),
      'user_id'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'imputation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'imputation_id', 'required' => false)),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imputed_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputedUser';
  }

}
