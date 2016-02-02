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


<script type="text/javascript">

function isOdd(num) { return num % 2;}

$( document ).ready(function() {

	var objectConstructor = {}.constructor;

	var $yiiForm = $('.yiiForm');

	var over = '<div id="overlay">' +
            '<span id="loadingBox"><img id="loading" src="<?php echo Yii::app()->getBaseUrl(true)  ?>/images/loader.gif"></span>' +
            '</div>';

    $(".remove_account").live("click", function(event){
		event.stopPropagation();
		$(over).appendTo('body');
		var accountId = this.id;
		var customerId = $yiiForm.find('table.tagged-accounts').data('customer-id');
		var row = $(this).closest('tr');
		var saveData = $.ajax({
		      type: 'POST',
		      url: "index.php?r=ajax",
		      data: {
		      	request: 'remove_account',
		      	accountId: accountId,
		      	customerId: customerId
		      },
		      dataType: "text",
		      success: function(data) {
		      	$('#overlay').remove();
		      	var obj;
                if(data.constructor === objectConstructor){
                    obj = data;
                }else{
                    obj = JSON.parse(data);
                }
		      	if(obj.type == 'success'){
		      		row.remove();
		      		var i = 1;
		      		$yiiForm.find('.tagged-accounts > tbody > tr').each(function() {
		      			$this = $(this);
		      			$this.removeClass('even');
		      			if(i == 2){
		      				$this.addClass('even');
		      				i = 1;
		      			}else{
		      				i++;
		      			}

		      		});
		      	}else{
		      		alert(obj.message);
		      	}
		      },
		      error: function() {
		      	$('#overlay').remove();
		      	alert("An error occured when adding the selected account to this tag. Please double check to see if you have alreaydy added this account"); 
		      }
		});
	});

	$('.add_account').click(function(event){
		event.stopPropagation();
		$(over).appendTo('body');
		var accountId = $yiiForm.find('#AddAccountToTag').find(":selected").val();
		var customerId = $(this).data('customer'); 
		var saveData = $.ajax({
		      type: 'POST',
		      url: "index.php?r=ajax",
		      data: {
		      	request: 'add_account',
		      	accountId: accountId,
		      	customerId: customerId
		      },
		      dataType: "text",
		      success: function(data) {
		      	$('#overlay').remove();
		      	var obj;
                if(data.constructor === objectConstructor){
                    obj = data;
                }else{
                    obj = JSON.parse(data);
                }
		      	if(obj.type == 'success'){
		      		var numItems = $yiiForm.find('.tagged-accounts tbody tr').length;
		      		var classStyle='';
		      		if(isOdd(numItems)){
		      			classStyle='even';
		      		}
		      		var html = '<tr class="'+classStyle+'">' +
		      					'<td>'+ $yiiForm.find('#AddAccountToTag').find(":selected").text() +'</td>' +
		      					'<td><a href="#" class="remove_account btn-red" id="'+ accountId +'">Remove</a></td>' +
		      					'</tr>';

		      		$yiiForm.find('.tagged-accounts tbody').append(html);
		      	}else{
		      		alert(obj.message);
		      	}
		      },
		      error: function() {
		      	$('#overlay').remove();
		      	alert("An error occured when adding the selected account to this tag. Please double check to see if you have alreaydy added this account"); 
		      }
		});
	});
});
</script>

<style type="text/css">
	.tagged-accounts {
		border-collapse: collapse;
	}
	.tagged-accounts td{
		padding: 15px;
	}
	.tagged-accounts .even {
		background-color: #BBD6EA;
	}
	.tagged-accounts tr {
		border-bottom: 1pt	solid darkGray;
	}
</style>

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
<?php echo CHtml::activeLabelEx($model,'desc',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.desc'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'desc',array('size'=>35,'maxlength'=>255)); ?>
</div>

<?php if($update){ ?>
	<center>
		<div class="selectAccount" style="width: 90%;margin: 1em;">

			<div style="font-weight: bold;text-align: center;margin-bottom: 1em;">Add an account to this tag: </div>

			<div class="accountList" style="float: left;margin-bottom: 1em;">
				<?php 
				echo CHtml::dropDownList('AddAccountToTag', 'accountId', 
				CHtml::encodeArray(CHtml::listData(Account::model()->findAll(array('condition'=>'companyId='
				.Yii::app()->user->getState('selectedCompanyId'),'select'=>'id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name','order'=>'code')),'id','name')));
				?>
			 </div>
				
			<div>
				<a href="#" class="add_account btn" data-customer="<?php echo $model->id; ?>" style="float: right;">+ Add account</a>
			</div>
		</div>
	</center>

	<center>
		<div style="width: 90%;margin: 1em;clear:both">
			<div style="font-weight: bold;margin-bottom: 1em">Accounts Associated with this tag</div>
			<table class="tagged-accounts" data-customer-id="<?php echo $model->id; ?>">
				<tbody>
				<?php 
				if ($numTaggedAccounts > 0) {
					$i = 1;
					foreach ($taggedAccounts as $t_acc) {
						$class = '';
						if($i==2){
							$class = 'even';
							$i = 0;
						}
						echo "<tr class='".$class."'>";
						echo "<td>" . $t_acc->account->code . " " . $t_acc->account->name . "</td>";
						echo "<td><a href='#' class='remove_account btn-red' id='" . $t_acc->accountId . "'>Remove</a></td>";
						echo "</tr>";

						$i++;
					} 
				}
				?>
				</tbody>
			</table>
		</div>
	</center>

<?php 	
	 }
?>


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