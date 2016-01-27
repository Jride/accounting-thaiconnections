<?php
/*
*    This is Lazy8Web, a book-keeping ledger program for professionals
*    Copyright (C) 2010  Thomas Dilts                                 
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or   
*    (at your option) any later version.                                 
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of 
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the  
*    GNU General Public License for more details.                   
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*/


class Donor extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Donor':
	 * @var integer $id
	 * @var integer $companyId
	 * @var integer $code
	 * @var string $name
	 * @var string $lastname
	 * @var string $email
	 * @var string $organization
	 * @var string $project
	 * @var string $address
	 * @var string $city
	 * @var string $state
	 * @var string $country
	 * @var string $postal
	 * @var string $phone
	 * @var string $desc
	 * @var string $changedBy
	 * @var string $dateChanged
	 */
	 
	 public function toString(){
	 	 return 'id=' . $this->id . ';'
	 	 	.'code='.$this->code .  ';' 
	 	 	.'name='.$this->name .  ';'
	 	 	.'lastname='.$this->lastname .  ';' 
			.'email='.$this->email.  ';'
			.'phone='.$this->phone .  ';' 
			.'organization='.$this->organization .  ';'
			.'project='.$this->project .  ';'
			.'address='.$this->address .  ';'
			.'city='.$this->city .  ';'
			.'state='.$this->state .  ';'
			.'country='.$this->country .  ';'
			.'postal='.$this->postal .  ';'
	 	 	.'desc='.$this->desc;
	 }
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Donor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('companyId, code, name', 'required'),
			array('companyId, code, phone', 'numerical', 'integerOnly'=>true),
			array('name, lastname, email, organization, project, city, state, country, postal','length', 'max'=>100),
			array('phone', 'length', 'max'=>80),
			array('desc', 'length', 'max'=>255),
			array('address', 'length', 'max'=>950),
			array('dateChanged', 'safe'),
			array('dateChanged','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('dateChanged','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('changedBy','default','value'=>Yii::app()->user->name),
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
			//'account'=>array(self::BELONGS_TO, 'Account', 'accountId'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('lazy8','Id'),
			'companyId' => Yii::t('lazy8','Company'),
			'code' => Yii::t('lazy8','Code'),
			'name' => Yii::t('lazy8','Name'),
			'lastname' => Yii::t('lazy8','Last Name'),
			'email' => Yii::t('lazy8','Email'),
			'phone' => Yii::t('lazy8','Phone'),
			'organization' => Yii::t('lazy8','Organization'),
			'project' => Yii::t('lazy8','Project Association'),
			'address' => Yii::t('lazy8','Address'),
			'city' => Yii::t('lazy8','City'),
			'state' => Yii::t('lazy8','State / Province'),
			'country' => Yii::t('lazy8','Country'),
			'postal' => Yii::t('lazy8','Postal Code'),
			'desc' => Yii::t('lazy8','Notes'),
			'userId' => Yii::t('lazy8','User'),
			'dateChanged' => Yii::t('lazy8','Date Changed'),
			'changedBy' => Yii::t('lazy8','Changed by'),
			'actions' => Yii::t('lazy8','Actions'),
		);
	}
	public function delete()
	{
		parent::delete();
		yii::app()->onDeletePost(new Lazy8Event('Donor',$this->id));
	}
}