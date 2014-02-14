<?php

/**
 * UserArchive filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserArchiveFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'age'        => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'city_name'  => new sfWidgetFormFilterInput(),
      'country'    => new sfWidgetFormFilterInput(),
      'gender'     => new sfWidgetFormFilterInput(),
      'seg'        => new sfWidgetFormFilterInput(),
      'awareness'  => new sfWidgetFormFilterInput(),
      'category'   => new sfWidgetFormFilterInput(),
      'user_id'    => new sfWidgetFormFilterInput(),
      'deleted_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'age'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'city_name'  => new sfValidatorPass(array('required' => false)),
      'country'    => new sfValidatorPass(array('required' => false)),
      'gender'     => new sfValidatorPass(array('required' => false)),
      'seg'        => new sfValidatorPass(array('required' => false)),
      'awareness'  => new sfValidatorPass(array('required' => false)),
      'category'   => new sfValidatorPass(array('required' => false)),
      'user_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_archive_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserArchive';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'age'        => 'Number',
      'created_at' => 'Date',
      'city_name'  => 'Text',
      'country'    => 'Text',
      'gender'     => 'Text',
      'seg'        => 'Text',
      'awareness'  => 'Text',
      'category'   => 'Text',
      'user_id'    => 'Number',
      'deleted_at' => 'Date',
    );
  }
}
