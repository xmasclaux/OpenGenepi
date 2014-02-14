<?php

/**
 * Structure form base class.
 *
 * @method Structure getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'email'            => new sfWidgetFormInputText(),
      'siret_number'     => new sfWidgetFormInputText(),
      'logo_path'        => new sfWidgetFormInputText(),
      'website'          => new sfWidgetFormInputText(),
      'telephone_number' => new sfWidgetFormInputText(),
      'address_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Address'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 45)),
      'email'            => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'siret_number'     => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'logo_path'        => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'website'          => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'telephone_number' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'address_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Address'))),
    ));

    $this->widgetSchema->setNameFormat('structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Structure';
  }

}
