<?php

/**
 * ActSubscription filter form base class.
 *
 * @package    epi
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActSubscriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'duration'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_members' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'extra_cost'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'duration'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_members' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'extra_cost'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('act_subscription_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ActSubscription';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'duration'    => 'Number',
      'max_members' => 'Number',
      'extra_cost'  => 'Number',
    );
  }
}
