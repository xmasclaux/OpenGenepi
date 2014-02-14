<?php

/**
 * Unity form base class.
 *
 * @method Unity getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUnityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'designation'           => new sfWidgetFormInputText(),
      'shortened_designation' => new sfWidgetFormInputText(),
      'disabled'              => new sfWidgetFormInputText(),
      'sort_order'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'           => new sfValidatorString(array('max_length' => 45)),
      'shortened_designation' => new sfValidatorString(array('max_length' => 20)),
      'disabled'              => new sfValidatorInteger(array('required' => false)),
      'sort_order'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('unity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Unity';
  }

}
