<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aForm module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aForm
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormActions extends sfActions
{  
  public function executeEdit(sfRequest $request)
  {
    if($request->isXmlHttpRequest())
    {
      $this->setLayout(false);
    }
    
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);
  }
  
  public function executeEditLayout(sfRequest $request)
  {
    $this->a_form_layout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    
    $this->form = new aFormLayoutForm($this->a_form_layout);

    return $this->renderPartial('aForm/aFormLayoutForm', array('a_form_layout' => $this->a_form_layout, 'a_form_layout_form' => $this->form));
  }
  
  
  public function executeShow(sfWebRequest $request)
  {
    $this->a_form = $this->getObject();
  }
  
  public function executeAddLayout(sfWebRequest $request)
  {
    $aForm = $this->getObject();
    
    $aFormLayoutForm = new aFormLayoutForm();
    
    $aFormLayoutForm->bind($request->getParameter($aFormLayoutForm->getName()));
    if($aFormLayoutForm->isValid())
    {
      $aFormLayoutForm->save();
    }
    
    return $this->renderComponent('aForm', 'aFormEdit', array('a_form' => $this->a_form, 'a_form_layout_form' => $this->form));
  }
  

  /**
   * getObject 
   * helper method to retrieve a form object from the routing class and check if
   * the user has permission to access the object.
   * @return 
   */
  public function getObject()
  {
    $object = $this->getRoute()->getObject();
    if(true)
      return $object;
    else
      $this->forward404(); 
  }
  
  
  
}
