<?php

/**
 * Address filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAddressFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'street'           => new sfWidgetFormFilterInput(),
      'telephone_number' => new sfWidgetFormFilterInput(),
      'address_city_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCity'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'street'           => new sfValidatorPass(array('required' => false)),
      'telephone_number' => new sfValidatorPass(array('required' => false)),
      'address_city_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AddressCity'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('address_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Address';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'street'           => 'Text',
      'telephone_number' => 'Text',
      'address_city_id'  => 'ForeignKey',
    );
  }
}
