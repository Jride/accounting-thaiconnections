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
?>
<h2><?php echo Yii::t('lazy8','Select Report'); ?></h2>
<div style="margin-top:50px" class="yiiForm">

<?php echo CHtml::beginForm('', 'post', array('target' => '_blank')) ; ?>

<?php /* echo CHtml::errorSummary($model);*/ ?>

<table>
<?php if(isset($reports) && count($reports)>0) { ?>
<tr><td>

<?php 
// Check if reports only user and limit report types

// echo "<pre>";
// print_r($reports);
// echo "</pre>";

$tagList = Yii::app()->user->getState('tagList');
if($tagList != ""){
	// This is a thaiconnections user so filter out the reports they are allowed to access

	// $reportIds = Yii::app()->user->getState('reportIds');

	// if(empty($reportIds)){
	// 	// die('Sorry but you currently do not have any access to any reports. Please contact webmasters@thaiconnections.org to gain access to the reports section.');
	// 	$reportIds = '37'; // Adds the account summary report as default
	// }
	// $reportAccess = explode(',', $reportIds);

	// if(!in_array('37', $reportAccess)){
	// 	$reportAccess[] = '37';
	// }
	
	$newReports = array();
	foreach ($reports as $key => $value) {
		if(strpos($value,'ReportsOnlyUser') !== false){
			// if(in_array($key, $reportAccess)){
			// 	// User has access to this report
			// 	$value = str_replace(" ReportsOnlyUser", "", $value);
			// 	$newReports[$key] = $value;
			// }
			$value = str_replace(" ReportsOnlyUser", "", $value);
			$newReports[$key] = $value;
		}
	}
	$reports = $newReports;

	if(empty($newReports)){
		die('Sorry you do not have access to any valid reports. Please contatct webmasters@thaiconnections.org to resolve this issue.');
	}
}

// $accountList = '';
// if(Yii::app()->user->name == "ReportsOnlyUser"){
// 	$accountNumbers = Yii::app()->session['accountNumbers'];
// 	if(strpos($accountNumbers,'101059') == false){$accountNumbers .= ',101059';}
// 	$accountList = ' AND code IN ('.$accountNumbers.')';
// }
// $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(array('condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId').$accountList,'select'=>'CONCAT(\'AND Account.id=\',id) as  id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name','order'=>'code')),'id','name'));
// $sqlList['']='';
// echo "<pre>";
// print_r($sqlList);
// echo "</pre>";

// $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()->findAll(array('condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId').' AND code = "101059"','select'=>'CONCAT(\'AND Account.id=\',id) as  id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name','order'=>'code')),'id','name'));
// $sqlList['']='';

?>

<?php echo CHtml::label(Yii::t('lazy8','Select Report'),false,array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.Select Report'),'onclick'=>'alert(this.title)')); ?>
</td><td>
<?php echo CHtml::dropDownList("reportId", $_POST['reportId'],$reports,array('onchange'=>"this.form.submit()")); ?>
</td><td>
<?php } ?>

<?php if(isset($model)) { ?>

<?php 
$repParams=$model->reportparameters;
//die();
if(isset($repParams)&&count($repParams)>0){
	foreach($repParams as $n=>$repParam){
		if($repParam->dataType=='FREE_TEXT' || $repParam->dataType=='DROP_DOWN' || $repParam->dataType=='DATE' || $repParam->dataType=='BOOLEAN'){
			?><tr><td><?php
			 echo CHtml::label(Yii::t('lazy8',$repParam->name),false,array('class'=>'help','title'=>Yii::t('lazy8',$repParam->desc),'onclick'=>'alert(this.title)'))  ; 
			?></td><td><?php
			switch($repParam->dataType){
			case 'FREE_TEXT':
				echo CHtml::textField($n,$_POST[$n]); 
				break;
			case 'DROP_DOWN':
				//echo $repParam->phpSecondaryInfo;die();
				try{
					eval($repParam->phpSecondaryInfo);
				}catch(Exception $e){
					echo '<h2>Died on following php param</h2>'.$repParam->phpSecondaryInfo ;throw $e;
				}
				//print_r($sqlList);die();
				echo CHtml::dropDownList($n,$_POST[$n], $sqlList,array('style'=>'width:200px;')); 
				break;
			case 'DATE':
				echo CHtml::textField($n,'',array('size'=>15)); 
				$this->widget('application.extensions.calendar.SCalendar',array(	
							'firstDay'=>'1',
							'language'=>'en',
							'inputField'=>$n,
							'ifFormat'=>User::getPhPDateFormatDatePickerReports(),
						      )); 
				break;
			case 'BOOLEAN':
				echo CHtml::checkBox($n,$_POST[$n]); 
				break;
			}
			?></td></tr><?php 
		}
	}
}
}
?>
<tr><td><?php
 echo CHtml::label(Yii::t('lazy8','Black and white only'),false,array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.Black and white only'),'onclick'=>'alert(this.title)')); 
?></td><td><?php
echo CHtml::checkBox('blackandwhite',$_POST['blackandwhite']);
?></td><td><?php
?></td></tr><?php
?><tr><td><?php
 echo CHtml::label(Yii::t('lazy8','Printout view'),false,array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.Printout view'),'onclick'=>'alert(this.title)')); 
?></td><td><?php
echo CHtml::checkBox('printoutview',$_POST['printoutview']); 
?></td><td><?php
?></td></tr>
</table>

<div class="action">
<?php echo CHtml::submitButton(Yii::t('lazy8','Show report'),array('name'=>'ShowReport','title'=>Yii::t('lazy8','contexthelp.Show report'))); ?>
<?php echo CHtml::submitButton(Yii::t('lazy8','Download PDF'),array('name'=>'DownloadPDF','title'=>Yii::t('lazy8','contexthelp.Download PDF'))); ?>
<?php echo CHtml::submitButton(Yii::t('lazy8','Download Excel'),array('name'=>'DownloadExcel','title'=>Yii::t('lazy8','contexthelp.Download Excel'))); ?>
</div>





<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->