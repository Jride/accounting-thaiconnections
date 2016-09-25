<?php 
/*

*/

 $accountList = ''; 
 if(Yii::app()->user->name == "ReportsOnlyUser" || Yii::app()->user->getState('thaiconnectionsUser') == 'true'){ 
  $accountTags = Yii::app()->user->getState('tagList');

  if($accountTags != ''){
    $account_ids = Yii::app()->db->createCommand('SELECT DISTINCT aca.accountId as AccountID FROM AccountCustomerAssignment aca INNER JOIN ( SELECT c.id, c.name FROM Customer c WHERE c.code IN ('.$accountTags.')) ww ON aca.customerId = ww.id ORDER BY AccountID')->queryAll();

    $accountID_string = '';
    $i = 0;
    foreach ($account_ids as $acc) {  
      if ($i == 0) {
        $accountID_string .= $acc['AccountID'];
      }else{
        $accountID_string .= ','.$acc['AccountID'];
      }
      $i++;
    }

    $accountList = ' AND id IN ('.$accountID_string.')';
  }else{
    $accountList = ' AND id IN (701)';
  }

 }

 $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(
 	array(
 		'condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId').$accountList,
 		'select'=>'CONCAT(\'AND Account.id=\',id) as  id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name',
 		'order'=>'code')
 	),'id','name')); 

 $sqlList['']='';


// ********************************************************

  $accountList = ''; 
 if(Yii::app()->user->name == "ReportsOnlyUser"){ 
 	$accountNumbers = Yii::app()->session['accountNumbers']; 	
	if(strpos($accountNumbers,'101059') == false){
		$accountNumbers .= ',101059';
	} 	
	$accountList = ' AND code IN ('.$accountNumbers.')';
 }
 $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(
 	array(
 		'condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId').$accountList,
 		'select'=>'CONCAT(\'AND Account.id=\',id) as id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name',
 		'order'=>'code')
 	),'id','name')); 
$sqlList['']='';

// ***********************************

 $accountList = '';   
 if(Yii::app()->user->name == "ReportsOnlyUser"){   	
 	$accountNumbers = Yii::app()->session['accountNumbers']; 	 	
 	if(strpos($accountNumbers,'101059') == false){ 		
 		$accountNumbers .= ',101059'; 	
 	} 	 	
 	$accountList = ' AND code IN ('.$accountNumbers.')';  
 }   

 $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(  	array(  		'condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId').$accountList,  		'select'=>'CONCAT(\'AND Account.code=\',code) as code, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name',  		'order'=>'code')  	),'code','name'));   
  $sqlList['']='';

  $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(array('condition'=>'companyId=' 	.Yii::app()->user->getState('selectedCompanyId'),'select'=>'CONCAT(\'AND Account.id=\',id) as  id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name','order'=>'code')),'id','name'));
  $sqlList['']='';

 ?>

