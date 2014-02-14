<?php

/**
 * Groups form.
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GroupsForm extends BaseGroupsForm
{
    public function configure()
    {
        $this->setValidator('name', new sfValidatorString(
            array('max_length' => 45),
            array(
                'required'   => 'The name field is compulsory.',
                'max_length' => 'The name field must not exceed %max_length% characters.'
            )
        ));

        $this->widgetSchema->setLabel('name', 'Group name');

    }
}
