<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginaFormLayout extends BaseaFormLayout
{ 
  protected $form;
  
  public static function getTypes()
  {
    return aFormLayoutTable::getTypes();
  }
   
  public function getFormClass()
  {
    return 'aForm'.sfInflector::camelize($this->getType());
  }
    
  public function getFormOptions()
  {
    $options = array(
      'slug' => $this->getSlug(), 
      'label' => $this->getLabel(),
      'required' => $this->getRequired(),
    );
    
    if ($this->usesOptions())
    {
      $options['choices'] = array();
      foreach ($this->aFormLayoutOptions as $choice)
      {
        $options['choices'][(string)$choice->getValue()] = $choice->getName();
      }
    }
    
    return $options;
  }
  
  public function usesOptions()
  {
    if (in_array($this->getType(), array('select', 'select_radio', 'select_checkbox')))
    {
      return true;
    }
    
    return false;
  }
  
  public function getForm($defaults = null, $options = array())
  {

    $class = $this->getFormClass();
    $this->form = new $class($defaults, array_merge($options, $this->getFormOptions()));
    
    return $this->form;
  }
  
  public function getOptionsForm()
  {
    $form = new aFormLayoutOptionsForm(null, array('a_form_layout' => $this));
    
    return $form;
  }
  
  public function preSave($event)
  {
    if($this->isNew() && (!isset($this->rank) || is_null($this->rank)))
    {
      $max = Doctrine::getTable('aForm')->getMaxRank($this->getFormId());
      if(is_null($max))
        $this->setRank(0);
      else
        $this->setRank($max + 1);
    }
  }
  
  public function setType($value)
  {
    if(!$this->isNew())
      return false;
    return $this->_set('type', $value);
  }
	
	public function postDelete($event)
	{
		Doctrine_Query::create()
		  ->update('aFormLayout')
			->set('rank', 'rank - 1')
			->where('aFormLayout.form_id = ? AND aFormLayout.rank > ?', array($this->getFormId(), $this->getRank()))
			->execute();
	}
}