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


class AccountController extends CController
{
	

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='admin';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('create','update','admin', 'cronbalance', 'cronreports' ),
				'expression'=>'Yii::app()->user->getState(\'allowAccount\')',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionCronbalance()
	{
		echo "Running Script...<br>";
		// Yii::app()->db->createCommand($sql)->queryAll();
		// Get all of the current asset accounts
		$sql = "SELECT Account.code AS accountcode, Account.name AS accountname, Account.email AS email, Account.balance_threshold AS threshold, Account.days AS days, e1.amount AS balance
				FROM Account
				JOIN (
				select accountId, TRIM( TRAILING 0 FROM ROUND( SUM( amount ) , 5 ) ) AS 'amount'
				FROM TransRow
				join Account on Account.id=accountId
				WHERE accountId = Account.id
				group by accountId) e1 ON e1.accountId = Account.id
				WHERE (Account.code BETWEEN '101000' AND '102999')
				ORDER BY Account.code";
				// OR (Account.companyId = ".Yii::app()->user->getState('selectedCompanyId')."))
		$accounts = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($accounts as $account)
		{
			if(!empty($account['email']))
			{
				echo "Email Found...<br>";
				if(!empty($account['threshold']) && !empty($account['days']))
				{
					echo "Threshold is: ".$account['threshold']."<br>";
					echo "Balance is: ".$account['balance']."<br>";
					// Continue with checking balance
					if(intval($account['balance']) < intval($account['threshold']))
					{
						echo "Notifying email...<br>";
						// Notify all emails attatched to account
						$to = $account['email'];
						$subject = 'Account Balance Breached Threshold';
						$headers = "From: Accounting@thaiconnections.org \r\n";
						$headers .= "Reply-To: no-reply@thaiconnections.org\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						
						$message = '<html><body>';
						$message .= '<p>Hello,</p>';
						$message .= '<p>This a automated notification saying that the balance for Account: <strong>'.$account['accountname'].' </strong>has gone lower than the current threshold.<p>';
						$message .= '<p>The current balance is:<strong> '.$account['balance'].' Baht</strong><p>';
						$message .= '<p>Kindest Regards,<br>';
						$message .= 'Thaiconnections Accounting</p>';
						$message .= '</body></html>';
						
						if(mail($to, $subject, $message, $headers)){
							echo "Email sent...<br>";	
						}else{
							echo "Mail did not send. Error occurred";
						}
					}
				}
			}
		}
/*		echo "<pre>";
		//var_dump($accounts);
		echo "</pre>";*/
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		$model=new Account;
		if(isset($_POST['American']) || isset($_POST['Swedish']))
		{
			$filename="DefaultAccounts.US.xml";
			if (isset($_POST['Swedish'])) $filename="DefaultAccounts.SE.xml"; 
			//must first delete any account types because this will add those as well
			ChangeLog::addLog('ADD','Account','Added default accounts '.$filename);
			$model->dbConnection->createCommand("DELETE FROM AccountType WHERE companyId=" . Yii::app()->user->getState('selectedCompanyId'))->execute();		
			$errors=Account::ImportAccounts(dirname(__FILE__).DIRECTORY_SEPARATOR.$filename);
			if(isset($errors) && count($errors)>0){
				foreach($errors as $error){
					$model->addError('id',$error);
				}
			}else{
				$this->redirect(array('admin'));
			}
		}
		elseif(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			$model->companyId=Yii::app()->user->getState('selectedCompanyId');
			if($model->save()){
				ChangeLog::addLog('ADD','Account',$model->toString());
				$this->redirect(array('admin','id'=>$model->id));
			}
		}
		$criteria=new CDbCriteria;
		$criteria->addSearchCondition('companyId',Yii::app()->user->getState('selectedCompanyId'));
		$models=Account::model()->findAll($criteria);
		$isAccountsInCompany=(isset($models) && count($models)>0);
		$model->dateChanged=User::getDateFormatted(date('Y-m-d'));
		$this->render('create',array('model'=>$model,
					'isAccountsInCompany'=>$isAccountsInCompany,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadAccount();
		if(isset($_POST['Account']))
		{
			$modelBeforeChange=$model->toString();
			$model->attributes=$_POST['Account'];
			if($model->save()){
				$stringModel=$model->toString();
				if ($modelBeforeChange!=$stringModel)
					ChangeLog::addLog('UPDATE','Account','BEFORE<br />' . $modelBeforeChange . '<br />AFTER<br />' . $stringModel);
				$this->redirect(array('admin','id'=>$model->id));
			}
		}

		// Get the Accounts associated with this Customer
		$accountId = $model->id;
		$count = AccountCustomerAssignment::model()->count(array(
													    'condition'=>'accountId=:accountId',
													    'params'=>array(':accountId'=>intval($accountId))
													));
		$tags = array();
		
		if($count > 0){
			$tags = AccountCustomerAssignment::model()->findAll(array(
													    'condition'=>'accountId=:accountId',
													    'params'=>array(':accountId'=>intval($accountId))
													));
		}

		$tagList = Account::model()->findAll();

		$this->render('update', array('model'=>$model, 'tags' => $tags, 'count' => $count, 'tagList' => $tagList));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;
		$criteria->addSearchCondition('companyId',Yii::app()->user->getState('selectedCompanyId'));

		$pages=new CPagination(Account::model()->count($criteria));
		$pages->pageSize=Yii::app()->user->getState('NumberRecordsPerPage');
		$pages->applyLimit($criteria);

		$sort=new CSort('Account');
		$sort->applyOrder($criteria);

		$models=Account::model()->findAll($criteria);

		$this->render('admin',array(
			'models'=>$models,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadAccount($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=Account::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$deleteAccount=$this->loadAccount($_POST['id']);
			ChangeLog::addLog('DELETE','Account',$deleteAccount->toString());
			$deleteAccount->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
	
}
