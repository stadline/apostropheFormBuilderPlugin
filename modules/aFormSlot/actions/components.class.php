<?php

class aFormSlotComponents extends BaseaFormSlotComponents
{
  public function executeEditView()
  {
    $this->setup();
    
    $this->form = new aFormForm($this->slot->getpkForm());
  }

	public function executeNormalView()
	{	  
    $this->setup();
    
		$this->a_form = $this->slot->getpkForm();

		// This should be refactored into the slot object or the base actions or
		// something like that.
		$this->slotParams = array(
      'slug' => $this->slug,
      'slot' => $this->name,
      'permid' => $this->permid, 
    );
	}

	public function executePkFormView()
	{
    if (!isset($this->form) || !$this->form->hasErrors())
    {
  		$this->form = $this->a_form->buildForm();
    }
	}

	public function executePkFormEdit()
	{
		$this->form = $this->a_form->buildForm();

    if (!isset($this->a_form_form) || !$this->a_form_form->hasErrors())
    {
      $this->a_form_form = new aFormForm($this->a_form);
    }
    
    if (!isset($this->a_form_layout_form) || !$this->a_form_layout_form->hasErrors())
    {
      $this->a_form_layout = new aFormLayout();
      $this->a_form_layout_form = new aFormLayoutForm($this->a_form_layout, array('a_form' => $this->a_form));
    }
	}
	
	public function executePkFormFieldOptions()
	{
    $this->a_form_layout_options_form = $this->a_form_layout->getOptionsForm();
	}
	
	public function executeSubmitEmail()
	{
	  $values = $this->form->getValues();
    $this->values = array();
	  foreach ($values['fields'] as $field_id => $field_values)
	  {
	    $this->values[Doctrine::getTable('aFormLayout')->find($field_id)->getLabel()] = $field_values;
	  }
	}
}
