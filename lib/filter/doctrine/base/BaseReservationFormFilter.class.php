<?php

/**
 * Reservation filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReservationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'        => new sfWidgetFormFilterInput(),
      'description'        => new sfWidgetFormFilterInput(),
      'type'               => new sfWidgetFormChoice(array('choices' => array('' => '', 'user' => 'user', 'group' => 'group'))),
      'type_id'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'public'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'public_designation' => new sfWidgetFormFilterInput(),
      'public_description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'designation'        => new sfValidatorPass(array('required' => false)),
      'description'        => new sfValidatorPass(array('required' => false)),
      'type'               => new sfValidatorChoice(array('required' => false, 'choices' => array('user' => 'user', 'group' => 'group'))),
      'type_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'public'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'public_designation' => new sfValidatorPass(array('required' => false)),
      'public_description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reservation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservation';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'designation'        => 'Text',
      'description'        => 'Text',
      'type'               => 'Enum',
      'type_id'            => 'Number',
      'public'             => 'Number',
      'public_designation' => 'Text',
      'public_description' => 'Text',
    );
  }
}
