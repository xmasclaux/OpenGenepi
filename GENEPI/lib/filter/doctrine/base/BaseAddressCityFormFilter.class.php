<?php

/**
 * AddressCity filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAddressCityFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(),
      'postal_code'        => new sfWidgetFormFilterInput(),
      'insee_code'         => new sfWidgetFormFilterInput(),
      'address_country_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCountry'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'postal_code'        => new sfValidatorPass(array('required' => false)),
      'insee_code'         => new sfValidatorPass(array('required' => false)),
      'address_country_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AddressCountry'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('address_city_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AddressCity';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'postal_code'        => 'Text',
      'insee_code'         => 'Text',
      'address_country_id' => 'ForeignKey',
    );
  }
}
