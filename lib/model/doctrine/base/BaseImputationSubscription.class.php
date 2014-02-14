<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ImputationSubscription', 'doctrine');

/**
 * BaseImputationSubscription
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $number_of_members
 * @property date $final_date
 * @property integer $imputation_id
 * @property Imputation $Imputation
 * 
 * @method integer                getId()                Returns the current record's "id" value
 * @method integer                getNumberOfMembers()   Returns the current record's "number_of_members" value
 * @method date                   getFinalDate()         Returns the current record's "final_date" value
 * @method integer                getImputationId()      Returns the current record's "imputation_id" value
 * @method Imputation             getImputation()        Returns the current record's "Imputation" value
 * @method ImputationSubscription setId()                Sets the current record's "id" value
 * @method ImputationSubscription setNumberOfMembers()   Sets the current record's "number_of_members" value
 * @method ImputationSubscription setFinalDate()         Sets the current record's "final_date" value
 * @method ImputationSubscription setImputationId()      Sets the current record's "imputation_id" value
 * @method ImputationSubscription setImputation()        Sets the current record's "Imputation" value
 * 
 * @package    GENEPI
 * @subpackage model
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseImputationSubscription extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('imputation_subscription');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('number_of_members', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('final_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('imputation_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Imputation', array(
             'local' => 'imputation_id',
             'foreign' => 'id'));
    }
}