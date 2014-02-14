<?php

/**
 * Listfilter filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListfilterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'), 'add_empty' => true)),
      'filter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'), 'add_empty' => true)),
      'order'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'list_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lists'), 'column' => 'id')),
      'filter_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Filter'), 'column' => 'id')),
      'order'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('listfilter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Listfilter';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'list_id'   => 'ForeignKey',
      'filter_id' => 'ForeignKey',
      'order'     => 'Number',
    );
  }
}
