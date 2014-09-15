<?php
Yii::import('application.modules.helpdesk.models.Helpdesk');
class CmsModule extends CWebModule
{
	//public $layout = 'application.views.layouts.default';
	static private $_admin;
	
	// set avoidSql to true if you intent do use yii-user-management on a non
	// mysql database. All places where a SQL query would be used for performance
	// reason are overwritten with a ActiveRecord implementation. This should
	// make it more compatible with other rdbms. Experimental of course.
	public $avoidSql = false;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'cms.models.*',
			'cms.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function renderMenu() {
		if(Helpdesk::module('user')->user()->superuser)
		{
			$this->widget('AdminMenu');
		}
		else if(!Yii::app()->user->isGuest)
		{
			$this->widget('UserMenu');
		}
	}
	
	
}
