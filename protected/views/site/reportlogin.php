<style type="text/css">
#overlay {
	position: absolute;
	left: 0;
	top: 0;
	bottom: 0;
	right: 0;
	/*background: gray;*/
	/*opacity: 0.9;*/
	background: rgba(38,38,38,0.7);
	/*filter: alpha(opacity=80);*/	
}
#loading {
    width: 64px;
    height: 64px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -32px 0 0 -32px;
}

#loadingBox {
	width: 70px;
    height: 70px;
    position: absolute;
    background-color: white;
    top: 50%;
    left: 50%;
    margin: -35px 0 0 -35px;
    border-radius: 35px;
}

#results{
	color: red;
	font-weight: bold;
	text-align: center;
}

</style>

<script type="text/javascript">  

$( document ).ready(function() {

	var over = '<div id="overlay">' +
            '<span id="loadingBox"><img id="loading" src="<?php echo Yii::app()->getBaseUrl(true)  ?>/images/loader.gif"></span>' +
            '</div>';

	$("#submitbtn").click(function() {
		$('#results').text('');
		$(over).appendTo('body');
		var input_data = $('#wp_login_form').serialize();
		$.ajax({
			type: 'POST',
			url:  'http://www.thaiconnections.org/accounting-login-api',
			crossDomain: true,
			data: input_data,
			success: function(responseData, textStatus, jqXHR) {
				// console.log(responseData);
		        // Checking if response is an object
		        try
				{
				   	var obj = JSON.parse(responseData);
				   	var username = obj.username;
					var password = obj.password;
					var accountNumbers = obj.accountNumbers;
					var accountTags = obj.accountTags;
					var reportIds = obj.reportIds;

					if(obj.msgType == 'success'){
						if((accountNumbers && accountNumbers.length > 0) || (accountTags && accountTags.length > 0)){
							$('#main_username').val(username);
							$('#main_password').val(password);
							$('#main_accountNumbers').val(accountNumbers);
							$('#main_accountTags').val(accountTags);
							$('#main_reportIds').val(reportIds);
							// $('#overlay').remove();
							$('#mainLogin').submit();
						}else{
							$('#overlay').remove();
							$('#results').text('Please contact webmaster@thaiconnections.org to gain access to this feature');
						}
					}else{
						$('#overlay').remove();
						$('#results').text('Authentication failed. Please try again.');
					}
					

				}
				catch(e)
				{
					$('#overlay').remove();
				   	$('#results').text('Authentication failed. Please try again.');
				}

		    },
		    error: function (responseData, textStatus, errorThrown) {
		    	$('#overlay').remove();
		        alert('POST failed.');
		    }
			
		});

		return false;

	});
});


</script>

<?php

 $this->pageTitle=Yii::app()->name . ' - Login'; 

 ?>

<h1><?php echo Yii::t('lazy8','Reports Login'); ?></h1>

<form id="wp_login_form" action="" method="post">

<div class="yiiForm">

<div class="simple">
<label for="wp_username">Username:</label>
<input type="text" name="username" id="wp_username" class="text" placeholder="username..." value="">
</div>

<div class="simple">
<label for="wp_password">Password:</label>
<input type="password" name="password" id="wp_password" placeholder="password..." class="text" value="">
</div>

<input type="hidden" name="shared_key" class="text" value="accounting_api_ZEW3ew2Lkd">

<div class="action" style="margin-left: 100px;">
<input type="submit" id="submitbtn" name="submit" value="Login">
</div>

<p id="results">
	
</p>

</div>

<p>
*Please use your Thaiconnections username and password to login. If you have used your Google or Facebook account to login to your Thaiconnections account then click <a target="_blank" href="https://www.dropbox.com/s/igh6rjgmbwi4aik/Thaiconnections%20Accounting%20Login%20med.mov?dl=0">here</a> to watch a short tutorial of how you can login.
</p>

<p>
If you are still having trouble logging in then please contact support at <a href="mailto:webmaster@thaiconnections.org?Subject=[Thaiconnections%20Accounting]%20Login%20Error" target="_top">webmaster@thaiconnections.org</a>
</p>

</div><!-- yiiForm -->

</form>

<!-- The actual Yii Form -->
<?php echo CHtml::beginForm('', 'post', array('id'=>'mainLogin')); ?>

<?php echo CHtml::activeHiddenField($form,'username', array('id'=>'main_username')) ?>

<?php echo CHtml::activeHiddenField($form,'password', array('id'=>'main_password')) ?>

<?php echo CHtml::activeHiddenField($form,'accountNumbers', array('id'=>'main_accountNumbers')) ?>

<?php echo CHtml::activeHiddenField($form,'accountTags', array('id'=>'main_accountTags')) ?>

<?php echo CHtml::activeHiddenField($form,'reportIds', array('id'=>'main_reportIds')) ?>

<?php // echo CHtml::submitButton(Yii::t('lazy8','Login')); ?>


<?php echo CHtml::endForm(); ?>