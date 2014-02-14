<?php

/**
 * Copyright 2010 Pierre Boitel, Bastien Libersa, Paul Périé
 *
 * This file is part of GENEPI.
 *
 * GENEPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GENEPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GENEPI. If not, see <http://www.gnu.org/licenses/>.
 */

class DefaultParametersFile {

    private $file_name;

    private $file_content;

    private $tags_values = array(
            'default_building'          => 1,
            'default_room'              => 1,
            'default_method_of_payment' => 1,
            'default_computer'          => 1,
            'default_num_to_display'    => 10,
            'default_follow_moderator'  => 0,
            'default_language'          => 'fr',
            'default_currency'          => 1,
            'def_mysql_port'            => 3306,
            'def_pgsql_port'            => 5432,
            'reservation_min_time'      => 8,
            'reservation_max_time'      => 18,
    );

    private $param_ids = array(
            'default_building',
            'default_room',
            'default_method_of_payment',
            'default_computer',
            'default_num_to_display',
            'default_follow_moderator',
            'default_language',
            'default_currency',
            'def_mysql_port',
            'def_pgsql_port',
            'reservation_min_time',
            'reservation_max_time',
    );

    /**
     *
     * @param $name
     * @param $encoding
     */
    function __construct($name, $encoding){
        $this->file_name = $name;
        $this->file_content = '<?xml version="1.0" encoding="'.$encoding.'"?>';
    }

    /**
     *
     */
    public function buildEntireFile(){

        $this->openNode('parameters');

        foreach($this->param_ids as $param_id){

            $this->openNode('param', array('id' => $param_id ));

                $this->openNode('name');
                    $this->printNodeContent($param_id);
                $this->closeNode('name');

                $this->openNode('value');
                    $this->printNodeContent($this->tags_values[$param_id]);
                $this->closeNode('value');

            $this->closeNode('param');
        }

        $this->closeNode('parameters');

        return $this->file_content;
    }

    /**
     *
     * @param string $tag_name
     * @param array $tag_attributes
     */
    private function openNode($tag_name, $tag_attributes = array()){

        $this->file_content .= '<'.$tag_name;

        foreach($tag_attributes as $attr_name => $attr_value){
            $this->file_content .= ' '.$attr_name.'="'.$attr_value.'"';
        }

        $this->file_content .= '>';
    }


    /**
     *
     * @param string $tag_name
     */
    private function closeNode($tag_name){
        $this->file_content .= '</'.$tag_name.'>';
    }


    /**
     *
     * @param string $content
     */
    private function printNodeContent($content){
        $this->file_content .= $content;
    }
}

?>