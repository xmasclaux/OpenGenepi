<?php

/**
 * ImputationArchive form base class.
 *
 * @method ImputationArchive getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationArchiveForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'imputation_id'              => new sfWidgetFormInputText(),
      'imputation_date'            => new sfWidgetFormDateTime(),
      'imputation_type'            => new sfWidgetFormInputText(),
      'duration'                   => new sfWidgetFormTime(),
      'designation'                => new sfWidgetFormInputText(),
      'price'                      => new sfWidgetFormInputText(),
      'method_of_payment'          => new sfWidgetFormInputText(),
      'building_designation'       => new sfWidgetFormInputText(),
      'room_designation'           => new sfWidgetFormInputText(),
      'computer_name'              => new sfWidgetFormInputText(),
      'computer_type_of_connexion' => new sfWidgetFormInputText(),
      'user_archive_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserArchive'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'imputation_id'              => new sfValidatorInteger(array('required' => false)),
      'imputation_date'            => new sfValidatorDateTime(),
      'imputation_type'            => new sfValidatorString(array('max_length' => 45)),
      'duration'                   => new sfValidatorTime(array('required' => false)),
      'designation'                => new sfValidatorString(array('max_length' => 45)),
      'price'                      => new sfValidatorNumber(),
      'method_of_payment'          => new sfValidatorString(array('max_length' => 45)),
      'building_designation'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'room_designation'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'computer_name'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'computer_type_of_connexion' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'user_archive_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserArchive'))),
    ));

    $this->widgetSchema->setNameFormat('imputation_archive[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationArchive';
  }

}
