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

abstract class ParametersConfiguration {

    const MYSQL_STRING_FOR_DOCTRINE = 'mysql';

    const POSTGRESQL_STRING_FOR_DOCTRINE = 'pgsql';

    const DB_PARAMS_FILE = 'bdd.parameters.xml';

    const DEFAULT_PARAMS_FILE = 'default.parameters.xml';

    private static $USER_CONFIG_PREFIX;

    private static $POSSIBLE_CULTURES = array(
        'en' => 'English',
        'fr' => 'French',
    );


/*-------------------------------------------------GETTERS---------------------------------------------------------------*/

    public static function getUserPrefix(){
        return self::$USER_CONFIG_PREFIX;
    }

    /**
     * This methods gets all of the parameters for the application:
     * For the server/database
     * For the default values
     * @return an array, indexed by the name of the parameter, of the values of theses parameters.
     */
    public static function getAll(){

        //Get the bdd parameters:
        $bdd_params = self::getBddParams();


        //Get the defaults values parameters:
        $def_params = self::getDefaultParams();

        if($bdd_params['dbms'] == 1){
            $bdd_params['srv_port'] = $def_params['def_mysql_port'];
        }else if ($bdd_params['dbms'] == 2){
            $bdd_params['srv_port'] = $def_params['def_pgsql_port'];
        }

        return array_merge($bdd_params, $def_params);
    }


    /**
     * This methods gets the parameters for the database.
     * @return an arrray, indexed by the name of the parameter, of the values of theses parameters.
     */
    public static function getBddParams(){

        libxml_use_internal_errors(true);

        $bdd_params = array();


        //Get the xml configuration file as a DOM element:
        if( !($parameters = simplexml_load_file(ProjectConfiguration::guessRootDir().'/config/'.self::DB_PARAMS_FILE)) ){
            Kernel::setError('Error while reading '.self::DB_PARAMS_FILE.': the file probably doesn\'t exists');
            return false;
        }
        $dom_parameters = dom_import_simplexml($parameters);

        //For each parameter found,
        foreach($dom_parameters->getElementsByTagName('param') as $param){

                $nodelist_name = $param->getElementsByTagName('name');
                $nodelist_value = $param->getElementsByTagName('value');

                //Get the name and the value of the parameter:
                $bdd_params[$nodelist_name->item(0)->nodeValue] = $nodelist_value->item(0)->nodeValue;
        }

        libxml_use_internal_errors(false);

        return $bdd_params;
    }


    /**
     * This methods gets the parameters for the database.
     * @return an arrray, indexed by the name of the parameter, of the values of theses parameters.
     */
    public static function getDefaultParams(){

        libxml_use_internal_errors(true);

        $def_params = array();


        //Get the xml configuration file as a DOM element:
        if( !($parameters = simplexml_load_file(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE)) ){
            Kernel::setError('Error while reading '.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE.': the file probably doesn\'t exists');
            return false;
        }
        $dom_parameters = dom_import_simplexml($parameters);

        //For each parameter found,
        foreach($dom_parameters->getElementsByTagName('param') as $param){

                $nodelist_name = $param->getElementsByTagName('name');
                $nodelist_value = $param->getElementsByTagName('value');

                //Get the name and the value of the parameter:
                $def_params[$nodelist_name->item(0)->nodeValue] = $nodelist_value->item(0)->nodeValue;
        }


        libxml_use_internal_errors(false);

        return $def_params;
    }

    /**
     *
     * @param string $param
     */
    public static function getDefault($param_to_search){

        libxml_use_internal_errors(true);
        $param_value = '';


        //Get the xml configuration file as a DOM element:
        if( !($parameters = simplexml_load_file(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE)) ){
            Kernel::setError('Error while reading '.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE.': the file probably doesn\'t exists');
            return false;
        }
        $dom_parameters = dom_import_simplexml($parameters);

        //For each parameter found,
        foreach($dom_parameters->getElementsByTagName('param') as $param){

                //Get the name and the value of the parameter:
                $param_name = $param->getElementsByTagName('name')->item(0)->nodeValue;

                //If the param is the one we're looking for:
                if($param_to_search == $param_name){
                    return $param->getElementsByTagName('value')->item(0)->nodeValue;;
                }
        }


        libxml_use_internal_errors(false);

        return $param_value;
    }


/*-------------------------------------------------SETTERS---------------------------------------------------------------*/

    public static function setUserPrefix($prefix){
        self::$USER_CONFIG_PREFIX = $prefix;
    }

    /**
     *
     * @param array $values
     */
    public static function setAll($values){
        self::setBddParams($values);
        self::setDefaultParams($values);
    }


    /**
     * This method replace all the parameters passed in the parameter (an array) in the bdd parameters
     * configuration file.
     * The parameter is an array, indexed by some or all the parameters of the file, containing the new parameters values.
     * If a parameters is not present in the file, it's just ignored.
     * @param array $bdd_values
     */
    public static function setBddParams($bdd_values){

        //Get the xml configuration file as a DOM element:

        $dom_doc = new DOMDocument();
        $dom_doc->load(ProjectConfiguration::guessRootDir().'/config/'.self::DB_PARAMS_FILE);
        $dom_parameters = $dom_doc->documentElement;

        //For each parameter found in the file:
        foreach($dom_parameters->getElementsByTagName('param') as $param){

            //Check it has attributes and gets the 'id' attribute:
            if($param->hasAttributes()){
                $param_id = $param->attributes->getNamedItem('id');


                //If the id attribute is present in the array passed as an argument,
                $bdd_param_names = array_keys($bdd_values);
                if(in_array($param_id->value, $bdd_param_names)){


                    //Get the new value to insert
                    $new_param_value = $bdd_values[$param_id->value];


                    //$param->getElementsByTagName('value')->item(0)->nodeValue = $new_param_value;
                    //Construct an new node by copying the actual node and import it in the document:
                    $new_node = $param->getElementsByTagName('value')->item(0);
                    $new_node->nodeValue = $new_param_value;

                    $dom_doc->importNode($new_node, true);

                    //Replace the old 'value' node by the new we've just constructed:
                    $to_remove = $param->getElementsByTagName('value')->item(0);
                    $param->replaceChild($new_node, $to_remove);

                }
            }
        }

        $dom_doc->save(ProjectConfiguration::guessRootDir().'/config/'.self::DB_PARAMS_FILE);
    }


    /**
     * This method replace all the parameters passed in the parameter (an array) in the default parameters
     * configuration file.
     * The parameter is an array, indexed by some or all the parameters of the file, containing the new parameters values.
     * If a parameters is not present in the file, it's just ignored.
     * @param array $def_params
     */
    public static function setDefaultParams($def_params)
    {
        $dom_doc = new DOMDocument();
        $dom_doc->load(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE);
        $dom_parameters = $dom_doc->documentElement;

        $all_params = array(
            'reservation_min_time' => 0,
            'reservation_max_time' => 0,
        );

        //For each parameter found in the file:
        foreach($dom_parameters->getElementsByTagName('param') as $param) {

            //Check it has attributes and gets the 'id' attribute:
            if($param->hasAttributes())
            {
                $param_id = $param->attributes->getNamedItem('id');

                //If the id attribute is present in the array passed as an argument,
                $def_param_names = array_keys($def_params);
                if(in_array($param_id->value, $def_param_names)) {

                    $all_params[$param_id->value] = 1;

                    //Get the new value to insert
                    $new_param_value = $def_params[$param_id->value];

                    //$param->getElementsByTagName('value')->item(0)->nodeValue = $new_param_value;
                    //Construct an new node by copying the actual node and import it in the document:
                    $new_node = $param->getElementsByTagName('value')->item(0);
                    $new_node->nodeValue = $new_param_value;

                    $dom_doc->importNode($new_node, true);

                    //Replace the old 'value' node by the new we've just constructed:
                    $to_remove = $param->getElementsByTagName('value')->item(0);
                    $param->replaceChild($new_node, $to_remove);
                }
            }
        }

        foreach ($all_params as $param => $v)
        {
            if ($v)
                continue;

            $new_param_value = $def_params[$param];
            $new_node = $dom_doc->createElement('param');
            $new_node->setAttribute('id', $param);

            $new_param = $dom_doc->createElement('name', $param);
            $new_node->appendChild($new_param);
            $new_param = $dom_doc->createElement('value', $new_param_value);
            $new_node->appendChild($new_param);

            $dom_parameters->appendChild($new_node);
        }

        $dom_doc->save(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE);
    }

    /**
     * This method replace only one parameter in the default parameters configuration file.
     * This parameter is identified by its id.
     * @param string $param_to_set_id
     * @param string $param_to_set_value
     * @return true if the parameter have been found and the file corretly updated, false otherwise.
     */
    public static function setDefault($param_to_set_id, $param_to_set_value){

        $dom_doc = new DOMDocument();
        $dom_doc->load(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE);
        $dom_parameters = $dom_doc->documentElement;

        //For each parameter found in the file:
        foreach($dom_parameters->getElementsByTagName('param') as $param){

            $param_id = $param->attributes->getNamedItem('id')->value;
            //Check if the id passed as parameter is the current parameter id:
            if($param_to_set_id == $param_id){

                //If so, get the old node, replace the value:
                $new_node = $param->getElementsByTagName('value')->item(0);
                $new_node->nodeValue = $param_to_set_value;

                //Import the new node in the dom document:
                $dom_doc->importNode($new_node, true);

                //Replace the old node by the new we've just constructed:
                $to_remove = $param->getElementsByTagName('value')->item(0);
                $param->replaceChild($new_node, $to_remove);

                //Save the file:
                $dom_doc->save(ProjectConfiguration::guessRootDir().'/config/'.self::getUserPrefix().'_'.self::DEFAULT_PARAMS_FILE);

                return true;

            }
        }

        return false;

    }

/*-------------------------------------------------OTHERS---------------------------------------------------------------*/

    /**
     *
     */
    public static function editYaml(){

        //Get the new parameters of the database:
        $params = self::getBddParams();


        //Loads the current databases.yml file:
        $databases = sfYaml::load(ProjectConfiguration::guessRootDir().'/config/databases.yml');

        //Edit the php variable that corresponds to this file:
        $databases['all']['doctrine']['param']['dsn'] = self::formatDbms($params['dbms']).':host='.$params['ip_address'].';dbname='.$params['db_name'].';port='.$params['srv_port'];

        $databases['all']['doctrine']['param']['username'] = $params['db_user_name'];

        $databases['all']['doctrine']['param']['password'] = $params['db_password'];

        //Dump this php variable to a yaml string:
        $text = sfYaml::dump($databases);

        //Write this string into the yaml file:
        $db_yaml = fopen(ProjectConfiguration::guessRootDir().'/config/databases.yml','w+');
        fwrite($db_yaml, $text);
        fclose($db_yaml);
    }


    /**
     *
     * @param string $dbms
     */
    private static function formatDbms($dbms){

        if($dbms == 1){
            return self::MYSQL_STRING_FOR_DOCTRINE;
        }else if($dbms == 2){
            return self::POSTGRESQL_STRING_FOR_DOCTRINE;
        }
    }

    /**
     *
     * @param array $langs
     */
    public static function formatLanguages($langs){

        $to_ret = array();

        foreach($langs as $code => $lang){
            $to_ret[$code] = self::formatLanguage($code);
        }

        return $to_ret;
    }



    /**
     *
     * @param string $lang
     */
    private static function formatLanguage($lang){
        foreach(self::$POSSIBLE_CULTURES as $code => $lang_as_string){
            if($lang == $code){
                return $lang_as_string;
            }
        }
        return $lang;
    }

}