<?php

/**
 * System Parameters form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class DefaultParametersForm extends sfForm{

    public function setup(){

        //Get the buildings designation:
        $buildings = array(0 => '');
        $buildings_query = Doctrine_Query::create()
              ->select('b.*')
            ->from('Building b');
        $buildings_res = $buildings_query->fetchArray();
        foreach($buildings_res as $building){
            $buildings[$building['id']] = $building['designation'];
        }

        //Get the rooms designation:
        $rooms = array(0 => '');
        $rooms_query = Doctrine_Query::create()
              ->select('r.designation')
            ->from('Room r');
        $rooms_res = $rooms_query->fetchArray();
        foreach($rooms_res as $room){
            $rooms[$room['id']] = $room['designation'];
        }

        //Get the methods of payment designation:
        $methods_of_payment = array(0 => '');
        $methods_of_payment_query = Doctrine_Query::create()
              ->select('m.designation')
              ->from('ImputationMethodOfPayment m')
              ->orderBy('m.sort_order');
        $methods_of_payment_res = $methods_of_payment_query->fetchArray();
        foreach($methods_of_payment_res as $method_of_payment){
            $methods_of_payment[$method_of_payment['id']] = $method_of_payment['designation'];
        }

           //Get the computers name:
           $computers = array(0 => '');
        $computers_query = Doctrine_Query::create()
              ->select('c.name')
            ->from('Computer c');
        $computers_res = $computers_query->fetchArray();
        foreach($computers_res as $computer){
            $computers[$computer['id']] = $computer['name'];
        }

        $unities = array(0 => '');
        $unities_query = Doctrine_Query::create()
              ->select('u.*')
            ->from('Unity u')
            ->orderBy('u.sort_order');
        $unities_res = $unities_query->fetchArray();
        foreach($unities_res as $unity){
            if(!$unity['disabled']){
                $unities[$unity['id']] = $unity['designation'];
            }
        }

        //Get the installed cultures passed as an option in the super class constructor:
        $languages = array_fill_keys($this->getOption('cultures', array('en')), null);
        $languages = ParametersConfiguration::formatLanguages($languages);

        //Fill the list of the choices for numbers of entries to display in a list:
        $numbers_to_display = array(10   => '10',
                                    25   => '25',
                                    50   => '50',
                                    100  => '100',);

        $agenda_time = array();
        for ($i=0 ; $i<24 ; $i++)
            $agenda_time[$i] = $i;


        /*----------------------------------WIDGETS----------------------------------------------*/

        $this->setWidgets(array(
            'default_building'              => new sfWidgetFormSelect(array('choices' => $buildings)),
            'default_room'                  => new sfWidgetFormSelect(array('choices' => $rooms)),
            'default_method_of_payment'     => new sfWidgetFormSelect(array('choices' => $methods_of_payment)),
            'default_computer'              => new sfWidgetFormSelect(array('choices' => $computers)),
            'default_num_to_display'        => new sfWidgetFormSelect(array('choices' => $numbers_to_display)),
            'default_follow_moderator'      => new sfWidgetFormInputCheckbox(array(), array('value' => $this->getOption('follow'))),
            'default_language'              => new sfWidgetFormSelect(array('choices' => $languages)),
            'default_currency'				=> new sfWidgetFormSelect(array('choices' => $unities)),
            'def_mysql_port'                => new sfWidgetFormInputText(),
            'def_pgsql_port'                => new sfWidgetFormInputText(),
            'reservation_min_time'          => new sfWidgetFormSelect(array('choices' => $agenda_time)),
            'reservation_max_time'          => new sfWidgetFormSelect(array('choices' => $agenda_time)),
        ));

        $this->widgetSchema->setLabels(array(
            'default_building'              => 'Building',
            'default_room'                  => 'Room',
            'default_method_of_payment'     => 'Method of payment',
            'default_computer'              => 'Computer',
            'default_num_to_display'        => 'Number of entries to display',
            'default_follow_moderator'      => 'Follow administrator actions',
            'default_language'              => 'Language',
            'default_currency'              => 'Currency',
            'def_mysql_port'                => 'MySQL port',
            'def_pgsql_port'                => 'PostgreSQL port',
            'reservation_min_time'          => 'Beginning time',
            'reservation_max_time'          => 'End time',
        ));

        /*-----------------------------------VALIDATORS-------------------------------------------*/

        $this->setValidators(array(
            'default_building'              => new sfValidatorInteger(array('min' => 0)),
            'default_room'                  => new sfValidatorInteger(array('min' => 0)),
            'default_method_of_payment'     => new sfValidatorInteger(array('min' => 0)),
            'default_computer'              => new sfValidatorInteger(array('min' => 0)),
            'default_num_to_display'        => new sfValidatorInteger(array('min' => 0)),
            'default_follow_moderator'      => new sfValidatorBoolean(),
            'default_language'              => new sfValidatorString(array('max_length' => 2)),
            'default_currency'              => new sfValidatorInteger(array('min' => 0)),
            'def_mysql_port'                => new sfValidatorInteger(array('max' => 65535, 'min' => 0)),
            'def_pgsql_port'                => new sfValidatorInteger(array('max' => 65535, 'min' => 0)),
            'reservation_min_time'          => new sfValidatorInteger(array('min' => 0, 'max' => 23)),
            'reservation_max_time'          => new sfValidatorInteger(array('min' => 0, 'max' => 23)),
        ));


        $this->widgetSchema->setNameFormat('%s');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    }

}