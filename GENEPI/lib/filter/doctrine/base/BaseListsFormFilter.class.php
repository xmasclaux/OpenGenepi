<?php

/**
 * Lists filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormFilterInput(),
      'type'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'W' => 'W', 'B' => 'B'))),
      'origin'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'SI' => 'SI', 'TO' => 'TO'))),
      'static'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'    => new sfValidatorPass(array('required' => false)),
      'type'    => new sfValidatorChoice(array('required' => false, 'choices' => array('W' => 'W', 'B' => 'B'))),
      'origin'  => new sfValidatorChoice(array('required' => false, 'choices' => array('SI' => 'SI', 'TO' => 'TO'))),
      'static'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'content' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lists_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lists';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'name'    => 'Text',
      'type'    => 'Enum',
      'origin'  => 'Enum',
      'static'  => 'Number',
      'content' => 'Text',
    );
  }
}
