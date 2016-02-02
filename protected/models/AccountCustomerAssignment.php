<?php

class AccountCustomerAssignment extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Customer':
	 * @var integer $accountId
	 * @var integer $customerId
	 */
	 
	 public function toString(){
	 	 return 'accountId=' . $this->accountId . ';'
	 	 	.'customerId='.$this->accountId;
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
		return 'AccountCustomerAssignment';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			// 'account'=>array(self::MANY_MANY, 'Account', 'code'), 
			'account'=>array(self::BELONGS_TO, 'Account', 'accountId'),
			'customer'=>array(self::BELONGS_TO, 'Customer', 'customerId'),
		);
	}
}