<?php

/**
 * aFormBuilderFilter form.
 *
 * @package    filters
 * @subpackage aFormBuilder *
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class aFormBuilderFilter extends BaseaFormSubmissionFormFilter
{ 
  protected $filterFieldsetFields;
  
  /*TODO: This needs to be changed to only use LIKE queries for text input fields.  Other fields like choice, radio,
   * etc should use different methods.
   */
  public function addFieldColumnQuery($query, $field, $value)
  {
    if ('' != $value)
    {
      $query->addHaving(sprintf('%s LIKE ?', $field), '%'.$value.'%');
    }
  }
 
  public function setup()
  {
    parent::setup();
		//unset($this['form_id'], $this['ip_address'], $this['created_at'], $this['updated_at'], $this['deleted_at']);
    if (!$this->getOption('a_form') instanceof aForm)
    {
      throw new Exception("aFormBuilderFilter requires an instance of aForm in the 'a_form' option.");
    }
    
		/*TODO: This is a temporary fix, the ideal solution would be to handle the filter form in the same manner
		 * as the regular form, embedding subFilters into this form.  This will provide the functionality for now though
		 */
    foreach($this->getOption('a_form')->aFormFieldsets as $aFormFieldset)
    {
    	$form = $aFormFieldset->getForm();
      foreach($aFormFieldset->aFormFields as $aFormField)
      {
        $this->setWidget($aFormField['id'], new sfWidgetFormInput());
        $label = count($aFormFieldset->aFormFields) > 1? $aFormField['name'] : $aFormFieldset->getLabel();
        $this->getWidget($aFormField['id'])->setLabel($label);
        $this->setValidator($aFormField['id'], new sfValidatorString(array('required' => false)));
        $this->filterFieldsetFields[$aFormFieldset->getId()][] = $this[$aFormField['id']];
      }
    }
  }
  
  public function doBuildQuery(array $values)
  {
    $query = Doctrine_Query::create()
      ->from('aFormSubmission fs, aFormFieldSubmission ffs')
      ->addSelect('fs.*')
      ->where('fs.id = ffs.submission_id')
      ->andWhere('fs.form_id = ?', $this->getOption('a_form')->getId());
    foreach($this->getOption('a_form')->aFormFieldsets as $aFormFieldset)
    {
      foreach($aFormFieldset->aFormFields as $aFormField)
      {
        $query->addSelect(sprintf("GROUP_CONCAT(IF(ffs.field_id = %s, ffs.value, null)) AS %s", $aFormField['id'], 'field_'.$aFormField['id']));
        if(isset($values[$aFormField['id']]))
          $this->addFieldColumnQuery($query, 'field_'.$aFormField['id'], $values[$aFormField['id']]);
      }
    }
    $query->addGroupBy('fs.id');
    return $query;
  }
}