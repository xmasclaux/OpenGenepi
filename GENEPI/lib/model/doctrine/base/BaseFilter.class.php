<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Filter', 'doctrine');

/**
 * BaseFilter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * 
 * @method integer getId()          Returns the current record's "id" value
 * @method string  getName()        Returns the current record's "name" value
 * @method string  getDescription() Returns the current record's "description" value
 * @method Filter  setId()          Sets the current record's "id" value
 * @method Filter  setName()        Sets the current record's "name" value
 * @method Filter  setDescription() Sets the current record's "description" value
 * 
 * @package    GENEPI
 * @subpackage model
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFilter extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('filter');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}