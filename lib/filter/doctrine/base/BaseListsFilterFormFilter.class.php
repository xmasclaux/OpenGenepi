<?php

/**
 * ListsFilter filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListsFilterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filter_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ordre'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'list_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'filter_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ordre'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('lists_filter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListsFilter';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'list_id'   => 'Number',
      'filter_id' => 'Number',
      'ordre'     => 'Number',
    );
  }
}
