<?php

/**
 * This is the model class for table "cms_content".
 *
 * The followings are the available columns in table 'cms_content':
 * @property string $id
 * @property string $nodeId
 * @property string $locale
 * @property string $heading
 * @property string $body
 * @property string $css
 * @property string $url
 * @property string $pageTitle
 * @property string $breadcrumb
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 */
class CmsContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nodeId', 'required'),
			array('nodeId', 'length', 'max'=>10),
			array('locale', 'length', 'max'=>50),
			array('heading, url, pageTitle, breadcrumb, metaTitle, metaDescription, metaKeywords', 'length', 'max'=>255),
			array('body, css', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nodeId, locale, heading, body, css, url, pageTitle, breadcrumb, metaTitle, metaDescription, metaKeywords', 'safe', 'on'=>'search'),
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
			'cmsnode' => array(self::BELONGS_TO, 'CmsNode', 'nodeId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nodeId' => 'Node',
			'locale' => 'Locale',
			'heading' => 'Heading',
			'body' => 'Body',
			'css' => 'Css',
			'url' => 'Url',
			'pageTitle' => 'Page Title',
			'breadcrumb' => 'Breadcrumb',
			'metaTitle' => 'Meta Title',
			'metaDescription' => 'Meta Description',
			'metaKeywords' => 'Meta Keywords',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nodeId',$this->nodeId,true);
		$criteria->compare('locale',$this->locale,true);
		$criteria->compare('heading',$this->heading,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('css',$this->css,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('pageTitle',$this->pageTitle,true);
		$criteria->compare('breadcrumb',$this->breadcrumb,true);
		$criteria->compare('metaTitle',$this->metaTitle,true);
		$criteria->compare('metaDescription',$this->metaDescription,true);
		$criteria->compare('metaKeywords',$this->metaKeywords,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CmsContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
