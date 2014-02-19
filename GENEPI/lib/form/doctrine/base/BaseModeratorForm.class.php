<?php

/**
 * Moderator form base class.
 *
 * @method Moderator getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseModeratorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'name'     => new sfWidgetFormInputText(),
      'surname'  => new sfWidgetFormInputText(),
      'email'    => new sfWidgetFormInputText(),
      'login_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Login'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'     => new sfValidatorString(array('max_length' => 45)),
      'surname'  => new sfValidatorString(array('max_length' => 45)),
      'email'    => new sfValidatorString(array('max_length' => 80)),
      'login_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Login'))),
    ));

    $this->widgetSchema->setNameFormat('moderator[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Moderator';
  }

}
