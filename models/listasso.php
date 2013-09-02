<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * ListAsso Model
 */
class ListAssoModelListAsso extends JModelItem
{
	/**
	* @var array assos
	*/
	protected $assos;

	/**
	* @var array ville
	*/
	protected $villes;

	/**
	* @var array sports
	*/
	protected $sports;

	/**
	* Get the list of associations
	* @return string The message to be displayed to the user
	*/
	public function getAssos() 
	{
		if (!is_array($this->assos))
		{
			$this->assos = array();
		}

		if(empty($this->assos))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__listasso');
			$query->order('type ASC');
			//$query->join('LEFT', '#__ville ON #__listasso.ville = #__ville.id');
			$db->setQuery((string)$query);
			$this->assos = $db->loadObjectList();
		}

		return $this->assos;
	}
	
	public function getAsso($id) 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__listasso');
		$query->where(' id = ' . (int) $id);
		$db->setQuery((string)$query);

		return $db->loadObject();
	}

	public function getVilles() 
	{
		if (!is_array($this->villes))
		{
			$this->villes = array();
		}

		if(empty($this->villes))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__ville');
			$query->order('name ASC');
			$db->setQuery((string)$query);
			$this->villes = $db->loadObjectList();
		}

		return $this->villes;
	}

	public function getSports()
	{
		if (!is_array($this->sports))
		{
			$this->sports = array();
		}

		if(empty($this->sports))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('type');
			$query->from('#__listasso');
			$query->order('type ASC');
			$db->setQuery((string)$query);
			$this->sports = $db->loadColumn();
			$this->sports = array_map('strtolower', $this->sports);
			$this->sports = array_map('ucwords', $this->sports);
		}

		return array_values(array_unique($this->sports));
	}
		
	public function updClub($data)
	{
		if(filter_var($data->website, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED))
			$url = $data->website;
		else
			$url = null;
			
		// set the data into a query to update the record
		$db = JFactory::getDBO();
		$query= $db->getQuery(true);
		$query->clear();
		$query->update(' #__listasso ');
		$query->set(' name = '.$db->Quote($data->name) );
		$query->set(' type = '.$db->Quote($data->type) );
		$query->set(' website = '.$db->Quote($data->website) );
		$query->set(' contact = '.$db->Quote($data->contact) );
		$query->where(' id = ' . (int) $data->id );

		$db->setQuery((string)$query);

		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
	
	public function deleteClub($data)
	{
		if(filter_var($data, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) != null)
			$id = $data;
		else
			return false;
			
		$db = JFactory::getDBO();
		$query= $db->getQuery(true);
		$query->clear();
		$query->remove(' #__listasso ');
		$query->where(' id = ' . (int) $id );

		$db->setQuery((string)$query);

		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
}
