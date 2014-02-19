<?php

/**
 * ComputerOs form base class.
 *
 * @method ComputerOs getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseComputerOsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'designation'           => new sfWidgetFormInputText(),
      'computer_os_family_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOsFamily'), 'add_empty' => true)),
      'sort_order'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'           => new sfValidatorString(array('max_length' => 45)),
      'computer_os_family_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOsFamily'), 'required' => false)),
      'sort_order'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('computer_os[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComputerOs';
  }

}
