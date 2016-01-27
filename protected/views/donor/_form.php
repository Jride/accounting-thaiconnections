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
<div class="yiiForm">

<p>
<?php echo Yii::t('lazy8','Fields with a red star are required') . ' <span class="required">*</span>';?>
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>
<?php $cLoc=null;$dateformatter=null; ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'code',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.code'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'code'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'name',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.name'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'name',array('size'=>35,'maxlength'=>100)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'lastname',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.lastname'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'lastname',array('size'=>35,'maxlength'=>100)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'email',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.email'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'email',array('size'=>35,'maxlength'=>100)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'phone',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.phone'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'phone',array('size'=>35,'maxlength'=>80)); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'organization',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.organization'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'organization',array('size'=>35,'maxlength'=>80)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'project',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.project'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'project',array('size'=>35,'maxlength'=>80)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'address',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.address'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextArea($model,'address',array('rows'=>5, 'cols'=>50, 'maxlength'=>950)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'city',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.city'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'city',array('size'=>35,'maxlength'=>80)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'state',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.state'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'state',array('size'=>35,'maxlength'=>80)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'country',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.country'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'country',array('size'=>35,'maxlength'=>80)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'postal',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.postal'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'postal',array('size'=>35,'maxlength'=>80)); ?>
</div>


<div class="simple">
<?php echo CHtml::activeLabelEx($model,'desc',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.desc'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'desc',array('size'=>35,'maxlength'=>255)); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'changedBy',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.changedBy'),'onclick'=>'alert(this.title)'));  echo CHtml::label($model->changedBy,false); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'dateChanged',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.dateChanged'),'onclick'=>'alert(this.title)'));  echo CHtml::label(User::getDateFormatted($model->dateChanged,$cLoc,$dateformatter),false); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? Yii::t('lazy8','Save') : Yii::t('lazy8','Create'),array('title'=>$update ? Yii::t('lazy8','contexthelp.Save') : Yii::t('lazy8','contexthelp.Create'))); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->