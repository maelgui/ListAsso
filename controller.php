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
		$user = &JFactory::getUser() ;
		$data = (object) JRequest::getVar('data');
		if ( $user->id && $data->id )
		{
			$model = $this->getModel('ListAsso');

			$return = $model->updClub($data);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = &JFactory::getApplication();
		$app->close();
	}
	
	function deleteClub()
	{
		/* Si utilisateur connecté */
		$user = &JFactory::getUser() ;
		$id = (object) JRequest::getVar('id');
		if ( $user->id && $id )
		{
			$model = $this->getModel('ListAsso');

			$return = $model->deleteClub($id);

			echo $return;
		}
		else 
		{
			echo 'Vous devez être <a href="/connexion">connecté</a>';
		}
		$app = &JFactory::getApplication();
		$app->close();
	}
	
	function getClub() {
		$id = (int) JRequest::getVar('id');
		if( $id )
		{
			$model = $this->getModel('ListAsso');
			echo json_encode($model->getAsso($id));
		}
		$app = &JFactory::getApplication();
		$app->close();
	}

	function typeahead() {
		$model = $this->getModel('ListAsso');

		echo json_encode($model->getSports());		

		$app = &JFactory::getApplication();
		$app->close();
	}

}