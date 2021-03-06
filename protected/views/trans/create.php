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
<h2><?php echo Yii::t('lazy8','New Transaction'); ?></h2>

<div class="actionBar">
[<?php echo CHtml::link(Yii::t('lazy8','Manage Trans'),array('admin')); ?>]
[<?php echo CHtml::label(Yii::t('lazy8','How to write this quickly'),false,array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.How to write this quickly'),'onclick'=>'alert(this.title)'));?>]
</div>


<?php 

// echo "<pre>";
// print_r($models);
// echo "</pre>";
if(count($models) > 2){
	if(isset($models[2])){
		unset($models[2]);
	}
	if(isset($models[3])){
		unset($models[3]);
	}
}

echo $this->renderPartial('_form', array(
	'models'=>$models,
	'Locale'=>$Locale,
	'numberFormatter'=>$numberFormatter,
	'numberFormat'=>$numberFormat,
	'update'=>false,
)); ?>