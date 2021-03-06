<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ComputerTypeOfConnexion', 'doctrine');

/**
 * BaseComputerTypeOfConnexion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $designation
 * @property Doctrine_Collection $Computer
 * 
 * @method integer                 getId()          Returns the current record's "id" value
 * @method string                  getDesignation() Returns the current record's "designation" value
 * @method Doctrine_Collection     getComputer()    Returns the current record's "Computer" collection
 * @method ComputerTypeOfConnexion setId()          Sets the current record's "id" value
 * @method ComputerTypeOfConnexion setDesignation() Sets the current record's "designation" value
 * @method ComputerTypeOfConnexion setComputer()    Sets the current record's "Computer" collection
 * 
 * @package    GENEPI
 * @subpackage model
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseComputerTypeOfConnexion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('computer_type_of_connexion');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('designation', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '45',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Computer', array(
             'local' => 'id',
             'foreign' => 'computer_type_of_connexion_id'));
    }
}