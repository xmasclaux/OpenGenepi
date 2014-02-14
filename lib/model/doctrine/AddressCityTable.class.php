<?php

class AddressCityTable extends Doctrine_Table
{
	
  public function findPostalCode($q, $limit = 30, $country)
  {
    $q = $this->createQuery('c')
          ->where('c.postal_code LIKE ?', $q.'%')
          ->addwhere('c.address_country_id = ?', $country)
          ->limit($limit)
          ;

    return $q->execute();
  }
  
  public function findCity($q, $limit = 30, $country)
  {
    $q = $this->createQuery('c')
          ->where('c.name LIKE ?', $q.'%')
          ->addwhere('c.address_country_id = ?', $country)
          ->limit($limit)
          ;

    return $q->execute();
  }
  
}
