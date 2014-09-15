<?php
/**
 * NodeController class file.
 * @author Christoffer Niska <christoffer.niska@nordsoftware.com>
 * @copyright Copyright &copy; 2011, Nord Software Ltd
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package cms.controllers
 */

class AdminController extends Controller
{
	public $defaultAction = 'pages';
	
	private $_model;
	
	public function beforeAction($action) { 
		
		$this->layout = Helpdesk::module('helpdesk')->layout;
		return parent::beforeAction($action);
	}
	
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('pages','createpage', 'updatepage', 'blocks','createblock', 'updateblock', 'delete', 'deleteblock'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionPages()
	{
		$model = new CmsNode('search');
		$cms = new CmsContent();
		$model->unsetAttributes();  // clear any default values
		//echo "<pre>"; print_r($_GET);die;
		if(isset($_GET['CmsNode']))
		    $model->attributes=$_GET['CmsNode'];
		    
		$this->render('pages', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionCreatepage()
	{
		
		$model = new CmsNode();
		$cms = new CmsContent();
		if(isset($_POST['CmsNode']))
		{
			$model->attributes = $_POST['CmsNode'];
			$model->created = date('Y-m-d h:m:s');
			
			if($model->validate())
			{
				if($model->save())
				{
					$cms->attributes = $_POST['CmsContent'];
					$cms->nodeId = $model->id;
					if($cms->save())
					{
						$this->redirect(array("//cms/admin/pages"));
					}
				}
			}
		}
		$this->render('createpage', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionUpdatepage($id = null)
	{
		
		$model = CmsNode::model()->with('cms')->findByPk($id);
		$cms = CmsContent::model()->findByAttributes(array('nodeId' => $model->id));
		if(isset($_POST['CmsNode']))
		{
			$model->attributes = $_POST['CmsNode'];
			$model->created = date('Y-m-d h:m:s');
			
			if($model->validate())
			{
				if($model->save())
				{
					$cms->attributes = $_POST['CmsContent'];
					$cms->nodeId = $model->id;
					if($cms->save())
					{
						$this->redirect(array("//cms/admin/pages"));
					}
				}
			}
		}
		$this->render('updatepage', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionBlocks()
	{
		$model = new CmsNode('search');
		$cms = new CmsContent();
		$model->unsetAttributes();  // clear any default values
		//echo "<pre>"; print_r($_GET);die;
		if(isset($_GET['CmsNode']))
		    $model->attributes=$_GET['CmsNode'];
		    
		$this->render('blocks', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionCreateblock()
	{
		
		$model = new CmsNode();
		$cms = new CmsContent();
		if(isset($_POST['CmsNode']))
		{
			$model->attributes = $_POST['CmsNode'];
			$model->created = date('Y-m-d h:m:s');
			
			if($model->validate())
			{
				if($model->save())
				{
					$cms->attributes = $_POST['CmsContent'];
					$cms->nodeId = $model->id;
					if($cms->save())
					{
						$this->redirect(array("//cms/admin/blocks"));
					}
				}
			}
		}
		$this->render('createblock', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionUpdateblock($id = null)
	{
		
		$model = CmsNode::model()->with('cms')->findByPk($id);
		$cms = CmsContent::model()->findByAttributes(array('nodeId' => $model->id));
		if(isset($_POST['CmsNode']))
		{
			$model->attributes = $_POST['CmsNode'];
			$model->created = date('Y-m-d h:m:s');
			
			if($model->validate())
			{
				if($model->save())
				{
					$cms->attributes = $_POST['CmsContent'];
					$cms->nodeId = $model->id;
					if($cms->save())
					{
						$this->redirect(array("//cms/admin/blocks"));
					}
				}
			}
		}
		$this->render('updateblock', array('model'=>$model, 'cms'=>$cms));
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$cms = CmsContent::model()->findByAttributes(array('nodeId' => $model->id));
			$model->delete();
			$cms->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/cms/admin/pages'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDeleteblock()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$cms = CmsContent::model()->findByAttributes(array('nodeId' => $model->id));
			$model->delete();
			$cms->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/cms/admin/blocks'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model = CmsNode::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}