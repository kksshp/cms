<?php
/**
 * CmsBlock class file.
 * @author Christoffer Niska <christoffer.niska@nordsoftware.com>
 * @copyright Copyright &copy; 2011, Nord Software Ltd
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package cms.widgets
 */

/**
 * Widget that renders the node with the given name.
 */
Yii::import("application.modules.cms.models.*");
class CmsBlock extends CWidget
{
	/**
	 * @property string the content name.
	 */
	public $name;

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		
		$model = CmsNode::model()->with('cms')->findByAttributes(array('cms_type'=>2,'name'=>$this->name));

		
		$this->render('block', array(
		    'model'=>$model,
		    'content'=>$model->cms->body,
		));
	}
}
