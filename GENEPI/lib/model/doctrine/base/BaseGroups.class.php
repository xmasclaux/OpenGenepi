<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Groups', 'doctrine');

/**
 * BaseGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * 
 * @method integer getId()   Returns the current record's "id" value
 * @method string  getName() Returns the current record's "name" value
 * @method Groups  setId()   Sets the current record's "id" value
 * @method Groups  setName() Sets the current record's "name" value
 * 
 * @package    GENEPI
 * @subpackage model
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseGroups extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('groups');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}