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

    $(".remove_tag").live("click", function(event){
		event.stopPropagation();
		$(over).appendTo('body');
		var customerId = this.id;
		var accountId = $yiiForm.find('table.account-tags').data('account-id');
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
		      		$yiiForm.find('.account-tags > tbody > tr').each(function() {
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

	$('.add_tag').click(function(event){
		event.stopPropagation();
		$(over).appendTo('body');
		var accountId = $(this).data('account'); 
		var customerId = $yiiForm.find('#AddTagToAccount').find(":selected").val();
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
		      		var numItems = $yiiForm.find('.account-tags tbody tr').length;
		      		var classStyle='';
		      		if(isOdd(numItems)){
		      			classStyle='even';
		      		}
		      		var html = '<tr class="'+classStyle+'">' +
		      					'<td>'+ $yiiForm.find('#AddTagToAccount').find(":selected").text() +'</td>' +
		      					'<td><a href="#" class="remove_tag btn-red" id="'+ customerId +'">Remove</a></td>' +
		      					'</tr>';

		      		$yiiForm.find('.account-tags tbody').append(html);
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
	.account-tags {
		border-collapse: collapse;
	}
	.account-tags td{
		padding: 15px;
	}
	.account-tags .even {
		background-color: #BBD6EA;
	}
	.account-tags tr {
		border-bottom: 1pt	solid darkGray;
	}
</style>

<style>
#legend{
	position: absolute;
	right: 10%;
	top: 55%;
}
</style>

<script type="text/javascript">
function check(boxid){
	var e = document.getElementById("Account_accountTypeId");
	var accountType = e.options[e.selectedIndex].value;
	if(accountType == 89 || accountType == 97 || accountType == 81){
		$("#AccountEmail").show('slow');
	}else{
		$("#AccountEmail").hide('slow');
	}
}
</script>

<div class="yiiForm">

<p>
<?php echo Yii::t('lazy8','Fields with a red star are required') . ' <span class="required">*</span>';?>
</p>

<?php echo CHtml::beginForm(); ?>
<?php $cLoc=null;$dateformatter=null; ?>
<?php echo CHtml::errorSummary($model);  if ( (isset($isAccountsInCompany) && ! $isAccountsInCompany) && ! $update){ 
	//You need several accounts for your company. We recommend that you select one of the two buttons below a standard accounts system.  Or you may create manually your own accounts 
?>

<div class="action">
<table><tr><td colspan="2">
<?php echo CHtml::encode(Yii::t('lazy8','You.need.several.accounts.for.your.company')); ?>
</td></tr><tr><td>
<?php echo CHtml::submitButton(Yii::t('lazy8','English'),array('title'=>Yii::t('lazy8','contexthelp.English.Accounts'),'name'=>'American')); ?>
</td><td>
<?php echo CHtml::submitButton(Yii::t('lazy8','Swedish'),array('title'=>Yii::t('lazy8','contexthelp.Swedish.Accounts'),'name'=>'Swedish')); ?>
</td><tr></table>	
</div>
	
<?php } ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'code',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.code'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'code'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'name',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.name'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'name',array('size'=>35,'maxlength'=>100)); ?>
</div>

<?php 
if($model['attributes']['accountTypeId'] == '89' || $model['attributes']['accountTypeId'] == '81' || $model['attributes']['accountTypeId'] == '97' || !$update){ ?>
<div id="AccountEmail">
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'email',array('class'=>'help','title'=>Yii::t('lazy8','The email list associated with this account. Emails should be comma seperated'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'email',array('size'=>50,'maxlength'=>500)); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'balance_threshold',array('class'=>'help','title'=>Yii::t('lazy8','Set the accounts balance thrshold here. The accounts email/s will be notified if the balance goes below the desired amount'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'balance_threshold',array('size'=>35,'maxlength'=>100)); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'report_id',array('class'=>'help','title'=>Yii::t('lazy8','Enter the id of the report you wish to run once a week'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'report_id',array('size'=>10,'maxlength'=>50)); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'days',array('class'=>'help','title'=>Yii::t('lazy8','The past number of days the report should include'),'onclick'=>'alert(this.title)'));  echo CHtml::activeTextField($model,'days',array('size'=>35,'maxlength'=>100)); ?>
    </div>
</div>
<!-- <div id="legend">
	<strong>Report Type Legend </strong><br />
    Account Balance = 17 <br />
    Project Expense = 16 <br />
	Account Summary (default) = 3<br />
	Account Summary (reconciled) = 14 <br />
</div> -->
<?php } ?>


<div class="simple">
<?php echo CHtml::activeLabelEx($model,'accountTypeId',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.accountTypeId'),'onclick'=>'alert(this.title)'));  
echo CHtml::activeDropDownList($model, 
	'accountTypeId', 
	CHtml::listData(AccountType::model()->findAll(array('order'=>'isInBalance DESC, sortOrder','condition'=>'companyId='.Yii::app()->user->getState('selectedCompanyId') )),'id','name'),
	array(
        'onchange' => 'check(\'AccountEmail\');',
    ));
 ?>
</div>

<?php if($update){ ?>
	<center>
		<div class="selectTag" style="width: 90%;margin: 1em;">

			<div style="font-weight: bold;text-align: center;margin-bottom: 1em;">Add a tag to this account: </div>

			<div class="tagList" style="float: left;margin-bottom: 1em;">
				<?php 
				echo CHtml::dropDownList('AddTagToAccount', 'customerId', 
				CHtml::encodeArray(CHtml::listData(Customer::model()->findAll(array('condition'=>'companyId='
				.Yii::app()->user->getState('selectedCompanyId'),'select'=>'id, CAST(CONCAT(code, ": " ,name) AS CHAR CHARACTER SET utf8) as name','order'=>'code')),'id','name')));
				?>
			 </div>
				
			<div>
				<a href="#" class="add_tag btn" data-account="<?php echo $model->id; ?>" style="float: right;">+ Add tag</a>
			</div>
		</div>
	</center>

	<center>
		<div style="width: 90%;margin: 1em;clear:both">
			<div style="font-weight: bold;margin-bottom: 1em">Tags Associated with this account</div>
			<table class="account-tags" data-account-id="<?php echo $model->id; ?>">
				<tbody>
				<?php 
				if ($count > 0) {
					$i = 1;
					foreach ($tags as $t_acc) {
						$class = '';
						if($i==2){
							$class = 'even';
							$i = 0;
						}
						echo "<tr class='".$class."'>";
						echo "<td>" . $t_acc->customer->code . ": " . $t_acc->customer->name . "</td>";
						echo "<td><a href='#' class='remove_tag btn-red' id='" . $t_acc->customerId . "'>Remove</a></td>";
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
<?php
	// var_dump($model->dateChanged);
	// echo "<br><br>";
	// var_dump($dateformatter); 
	echo CHtml::activeLabelEx($model,'dateChanged',array('class'=>'help','title'=>Yii::t('lazy8','contexthelp.dateChanged'),'onclick'=>'alert(this.title)'));  
	echo CHtml::label(User::getDateFormatted($model->dateChanged,$cLoc,$dateformatter),false); 
?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? Yii::t('lazy8','Save') : Yii::t('lazy8','Create'),array('title'=>$update ? Yii::t('lazy8','contexthelp.Save') : Yii::t('lazy8','contexthelp.Create'))); ?>
</div>

<?php // var_dump($model); ?>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->