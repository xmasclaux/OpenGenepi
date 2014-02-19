<?php

/**
 * ComputerOs filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseComputerOsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'computer_os_family_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOsFamily'), 'add_empty' => true)),
      'sort_order'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'designation'           => new sfValidatorPass(array('required' => false)),
      'computer_os_family_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ComputerOsFamily'), 'column' => 'id')),
      'sort_order'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('computer_os_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComputerOs';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'designation'           => 'Text',
      'computer_os_family_id' => 'ForeignKey',
      'sort_order'            => 'Number',
    );
  }
}
