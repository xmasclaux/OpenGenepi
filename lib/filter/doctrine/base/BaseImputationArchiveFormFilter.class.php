<?php

/**
 * ImputationArchive filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationArchiveFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'imputation_id'              => new sfWidgetFormFilterInput(),
      'imputation_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'imputation_type'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'                   => new sfWidgetFormFilterInput(),
      'designation'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'method_of_payment'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'building_designation'       => new sfWidgetFormFilterInput(),
      'room_designation'           => new sfWidgetFormFilterInput(),
      'computer_name'              => new sfWidgetFormFilterInput(),
      'computer_type_of_connexion' => new sfWidgetFormFilterInput(),
      'user_archive_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserArchive'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'imputation_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'imputation_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'imputation_type'            => new sfValidatorPass(array('required' => false)),
      'duration'                   => new sfValidatorPass(array('required' => false)),
      'designation'                => new sfValidatorPass(array('required' => false)),
      'price'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'method_of_payment'          => new sfValidatorPass(array('required' => false)),
      'building_designation'       => new sfValidatorPass(array('required' => false)),
      'room_designation'           => new sfValidatorPass(array('required' => false)),
      'computer_name'              => new sfValidatorPass(array('required' => false)),
      'computer_type_of_connexion' => new sfValidatorPass(array('required' => false)),
      'user_archive_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserArchive'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('imputation_archive_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationArchive';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'imputation_id'              => 'Number',
      'imputation_date'            => 'Date',
      'imputation_type'            => 'Text',
      'duration'                   => 'Text',
      'designation'                => 'Text',
      'price'                      => 'Number',
      'method_of_payment'          => 'Text',
      'building_designation'       => 'Text',
      'room_designation'           => 'Text',
      'computer_name'              => 'Text',
      'computer_type_of_connexion' => 'Text',
      'user_archive_id'            => 'ForeignKey',
    );
  }
}
