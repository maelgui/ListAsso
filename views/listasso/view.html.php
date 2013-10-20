<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 

class ListAssoViewListAsso extends JViewLegacy
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
		// Assign data to the view
        $this->assos = $this->get('Assos');
		$this->villes = $this->get('Villes');
		$this->user = JFactory::getUser() ;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
            return false;
        }

        // Display the view
        parent::display($tpl);
    }
}