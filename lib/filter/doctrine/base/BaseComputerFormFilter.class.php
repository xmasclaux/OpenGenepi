<?php

/**
 * Computer filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseComputerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'shortened_name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'                       => new sfWidgetFormFilterInput(),
      'year'                          => new sfWidgetFormFilterInput(),
      'mac_address'                   => new sfWidgetFormFilterInput(),
      'ip_address'                    => new sfWidgetFormFilterInput(),
      'room_id'                       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'add_empty' => true)),
      'computer_machine_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerMachineType'), 'add_empty' => true)),
      'computer_os_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOs'), 'add_empty' => true)),
      'computer_type_of_connexion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerTypeOfConnexion'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                          => new sfValidatorPass(array('required' => false)),
      'shortened_name'                => new sfValidatorPass(array('required' => false)),
      'comment'                       => new sfValidatorPass(array('required' => false)),
      'year'                          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mac_address'                   => new sfValidatorPass(array('required' => false)),
      'ip_address'                    => new sfValidatorPass(array('required' => false)),
      'room_id'                       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Room'), 'column' => 'id')),
      'computer_machine_type_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ComputerMachineType'), 'column' => 'id')),
      'computer_os_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ComputerOs'), 'column' => 'id')),
      'computer_type_of_connexion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ComputerTypeOfConnexion'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('computer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Computer';
  }

  public function getFields()
  {
    return array(
      'id'                            => 'Number',
      'name'                          => 'Text',
      'shortened_name'                => 'Text',
      'comment'                       => 'Text',
      'year'                          => 'Number',
      'mac_address'                   => 'Text',
      'ip_address'                    => 'Text',
      'room_id'                       => 'ForeignKey',
      'computer_machine_type_id'      => 'ForeignKey',
      'computer_os_id'                => 'ForeignKey',
      'computer_type_of_connexion_id' => 'ForeignKey',
    );
  }
}
