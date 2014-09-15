<?php

/**
 * This is the model class for table "cms_node".
 *
 * The followings are the available columns in table 'cms_node':
 * @property integer $id
 * @property string $created
 * @property string $updated
 * @property integer $cms_type
 * @property string $name
 * @property integer $deleted
 */
class CmsNode extends CActiveRecord
{
	public $pageTitle;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_node';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('cms_type, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('updated, pageTitle', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created, updated, cms_type, name, deleted, pageTitle', 'safe', 'on'=>'search'),
			//array('id, created, updated, cms_type, name, deleted, pageTitle', 'safe', 'on'=>'searchPage'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cms' => array(self::HAS_ONE, 'CmsContent', 'nodeId'),
			'services' => array(self::HAS_MANY, 'HelpdeskServices', 'cms_node_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created' => 'Created',
			'updated' => 'Updated',
			'cms_type' => 'Cms Type',
			'name' => 'Identifier',
			'deleted' => 'Deleted',
			'pageTitle' => 'Page Title',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('cms_type',$this->cms_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function searchpage()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria = new CDbCriteria;
		$criteria->with = array('cms' => array('together' => true));
		//$criteria->together = true;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('t.updated',$this->updated,true);
		$criteria->compare('t.cms_type',1);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.deleted',$this->deleted);
		
		$criteria->compare('cms.pageTitle',$this->pageTitle, true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'pageTitle'=>array(
						'asc'=>'cms.pageTitle',
						'desc'=>'cms.pageTitle DESC',
					),
				)
			),
		));
	}
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function searchblock()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria = new CDbCriteria;
		$criteria->with = array('cms' => array('together' => true));
		//$criteria->together = true;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('t.updated',$this->updated,true);
		$criteria->compare('t.cms_type',2);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.deleted',$this->deleted);
		$criteria->compare('cms.pageTitle',$this->pageTitle, true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'pageTitle'=>array(
						'asc'=>'cms.pageTitle',
						'desc'=>'cms.pageTitle DESC',
					),
				)
			),
		));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CmsNode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
