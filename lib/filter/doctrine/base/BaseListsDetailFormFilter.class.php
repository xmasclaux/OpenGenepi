<?php

/**
 * ListsDetail filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListsDetailFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'lists_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'domain'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'lists_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'domain'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lists_detail_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListsDetail';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'lists_id' => 'Number',
      'domain'   => 'Text',
    );
  }
}
