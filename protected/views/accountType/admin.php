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
<h2><?php echo Yii::t('lazy8','Managing AccountType'); ?></h2>

<div class="actionBar">
[<?php echo CHtml::link(Yii::t('lazy8','New AccountType'),array('create')); ?>]
</div>
<?php $cLoc=null;$dateformatter=null; ?>
<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('code'); ?></th>
    <th><?php echo $sort->link('name'); ?></th>
    <th><?php echo $sort->link('sortOrder'); ?></th>
    <th><?php echo $sort->link('isInBalance'); ?></th>
    <th><?php echo $sort->link('userId'); ?></th>
    <th><?php echo $sort->link('dateChanged'); ?></th>
    <th><?php echo CHtml::encode(Yii::t('lazy8','Actions')); ?></th>

  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::encode($model->code); ?></td>
    <td><?php echo CHtml::encode($model->name); ?></td>
    <td><?php echo CHtml::encode($model->sortOrder); ?></td>
    <td><?php echo CHtml::encode($model->isInBalance==1?'true':'false'); ?></td>
    <td><?php echo CHtml::encode($model->changedBy); ?></td>
    <td><?php echo CHtml::encode(User::getDateFormatted($model->dateChanged,$cLoc,$dateformatter)); ?></td>
    <td>
      <?php echo CHtml::link(Yii::t('lazy8','Update'),array('update','id'=>$model->id)); ?>
      <?php if(Account::model()->find('accountTypeId='.$model->id)==null){
      		$deletebutton=CHtml::linkButton(Yii::t('lazy8','Delete'),array(
			  'submit'=>'',
			  'params'=>array('command'=>'delete','id'=>$model->id),
			  'confirm'=>Yii::t('lazy8',"Are you sure to delete?") . ' - ' . $model->name));
      	      }else{
      		$deletebutton=CHtml::linkButton(Yii::t('lazy8','Delete'),array(
			  'submit'=>'',
			  'params'=>array('command'=>'admin','id'=>$model->id),
			  'confirm'=>Yii::t('lazy8',"You cannot delete this record because other records are dependent on it.")));
      	      }
      echo $deletebutton;  ?>
      </td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>