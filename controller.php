<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Hello World Component Controller
 */
class ListAssoController extends JControllerLegacy
{
	function updateClub()
	{
		/* Si utilisateur connecté */
		$user = JFactory::getUser() ;
		$data = (object) JRequest::getVar('data');
		if ( $user->id && $data->id )
		{
			$model = $this->getModel('ListAsso');

			$return = $model->updAsso($data);
			sleep(1.5);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = JFactory::getApplication();
		$app->close();
	}
	
	function deleteClub()
	{
		/* Si utilisateur connecté */
		$user = JFactory::getUser() ;
		$id = (int) JRequest::getVar('id');
		if ( $user->id && $id )
		{
			$model = $this->getModel('ListAsso');

			$return = $model->delAsso($id);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = JFactory::getApplication();
		$app->close();
	}
	
	function getClub() {
		$id = (int) JRequest::getVar('id');
		if( $id )
		{
			$model = $this->getModel('ListAsso');
			echo json_encode($model->getAsso($id));
		}
		$app = JFactory::getApplication();
		$app->close();
	}

	function typeahead() {
		$model = $this->getModel('ListAsso');

		echo json_encode($model->getSports());		

		$app = JFactory::getApplication();
		$app->close();
	}

	function createCity()
	{
		/* Si utilisateur connecté */
		$user = JFactory::getUser() ;
		$name = (string) JRequest::getVar('name');
		if ( $user->id && $name )
		{
			$model = $this->getModel('ListAsso');

			$return = $model->createCity($name);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = JFactory::getApplication();
		$app->close();
	}

	function editCity()
	{
		/* Si utilisateur connecté */
		$user = JFactory::getUser() ;
		$id = (int) JRequest::getVar('id');
		$name = (string) JRequest::getVar('name');
		if ( $user->id && $id && $name)
		{
			$model = $this->getModel('ListAsso');

			$return = $model->editCity($id, $name);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = JFactory::getApplication();
		$app->close();
	}

}