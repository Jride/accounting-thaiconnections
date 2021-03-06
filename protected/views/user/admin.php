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
<h2><?php echo Yii::t('lazy8','Managing User'); ?></h2>

<div class="actionBar">
[<?php echo CHtml::link(Yii::t('lazy8','New User'),array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('username'); ?></th>
    <th><?php echo $sort->link('displayname'); ?></th>
    <th><?php echo $sort->link('mobil'); ?></th>
    <th><?php echo $sort->link('email'); ?></th>
    <th><?php echo $sort->link('dateLastLogin'); ?></th>
    <th><?php echo $sort->link('dateLastLogout'); ?></th>
    <th><?php echo $sort->link('changedBy'); ?></th>
    <th><?php echo $sort->link('dateChanged'); ?></th>
    <th><?php echo CHtml::encode(Yii::t('lazy8','Actions')); ?></th>

  </tr>
  </thead>
  <tbody>
<?php	$cLoc=CLocale::getInstance('en'); 
	$dateformatter=new CDateFormatter($cLoc);   foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::encode($model->username); ?></td>
    <td><?php echo CHtml::encode($model->displayname); ?></td>
    <td><?php echo CHtml::encode($model->mobil); ?></td>
    <td><?php echo CHtml::encode($model->email); ?></td>
    <td><?php echo CHtml::encode($model->dateLastLogin); ?></td>
    <td><?php echo CHtml::encode($model->dateLastLogout); ?></td>
    <td><?php echo CHtml::encode($model->changedBy); ?></td>
    <td><?php echo CHtml::encode(User::getDateFormatted($model->dateChanged,$cLoc,$dateformatter)); ?></td>
    <td>
      <?php echo CHtml::link(Yii::t('lazy8','Update'),array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton(Yii::t('lazy8','Delete'),array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>Yii::t('lazy8',"Are you sure to delete?") . ' - ' . $model->displayname)); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>