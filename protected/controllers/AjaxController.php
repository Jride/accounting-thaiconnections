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


class AjaxController extends CController
{
	

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='request';

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
				'actions'=>array('request'),
				'expression'=>'Yii::app()->user->getState(\'allowDonor\')',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRequest()
	{
		if(isset($_POST['request'])){
			$request = $_POST['request'];
			$accountId = intval($_POST['accountId']);
			$customerId = intval($_POST['customerId']);
			switch ($request) {
				case 'add_account':
					$record=new AccountCustomerAssignment;
					$record->accountId = $accountId;
					$record->customerId = $customerId;
					if($record->save()){
						$response  = array(
							'type' => 'success', 
							'message' => 'saved record successfully'
						);
					}else{
						$response  = array(
							'type' => 'fail', 
							'message' => 'Could not save the entry into the database'
						);	
					}
					echo json_encode($response);
					break;
				
				case 'remove_account':
					if(AccountCustomerAssignment::model()->deleteByPk(array('accountId'=>$accountId,'customerId'=>$customerId))){
						$response  = array(
							'type' => 'success', 
							'message' => 'removed record successfully'
						);	
					}else{
						$response  = array(
							'type' => 'fail', 
							'message' => 'Could not remve the entry from the database'
						);	
					}
					echo json_encode($response);
					break;

				default:
					# code...
					break;
			}

		}else{
			$response  = array(
					'type' => 'fail', 
					'message' => 'no request was found'
				);
			echo json_encode($response);
		}
	}

	
	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$deleteDonor=$this->loadDonor($_POST['id']);
			ChangeLog::addLog('DELETE','Donor',$deleteDonor->toString());
			$deleteDonor->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}