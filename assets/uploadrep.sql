<?xml version="1.0" encoding="utf-8"?>
<lazy8webportreport version="1.00">
  <report name="Account summary ReportsOnlyUser">
    <desc>A listing of all transactions in each account</desc>
    <selectsql>select CONCAT('&lt;a href="{url}?r=trans/update&amp;id=',Trans.id,'"  target="_blank"&gt;',{TransNumField},'&lt;/a&gt;') as TransNum,&#13;
        Trans.*,&#13;
		Trans.notes AS Notes,&#13;
		CASE WHEN Donor.name IS NOT NULL &#13;
			THEN CONCAT(COALESCE(TransRow.notes, ''), ' - Donor[', COALESCE(Donor.name, ''), ']')&#13;
			ELSE TransRow.notes&#13;
		END AS rownotes,&#13;
		e1.ingoing, &#13;
		Account.code AS accountcode, &#13;
		Account.name AS accountname,&#13;
		IF(amount&lt;0, 0, amount) AS Debit,&#13;
		IF(amount&lt;0,-amount,0) AS Credit &#13;
FROM TransRow&#13;
LEFT JOIN Donor on TransRow.donorId=Donor.id&#13;
JOIN Trans ON TransRow.transId=Trans.id &#13;
JOIN Account ON TransRow.accountId=Account.id&#13;
LEFT JOIN (&#13;
	SELECT IF(isInBalance,TRIM(TRAILING 0 FROM ROUND(SUM(amount),5)),0) AS 'ingoing',&#13;
	accountId &#13;
	FROM TransRow&#13;
	LEFT JOIN Donor on TransRow.donorId=Donor.id	&#13;
	JOIN Trans ON TransRow.transId=Trans.id &#13;
	JOIN Account ON Account.id=accountId &#13;
	JOIN AccountType ON AccountType.id=Account.accountTypeId&#13;
	WHERE Trans.companyId={companyId} &#13;
	AND invDate&lt;DATE '{startDate}' &#13;
	GROUP BY accountid&#13;
) e1 ON e1.accountId=TransRow.accountId  &#13;
WHERE Trans.companyId={companyId} &#13;
AND Trans.invDate&gt;=DATE '{startDate}' &#13;
AND Trans.invDate&lt;=DATE '{stopDate}' &#13;
{accountLimit}&#13;
ORDER BY TransRow.accountId,Trans.invDate</selectsql>
    <csscolorfilename>reportcolor.css</csscolorfilename>
    <cssbwfilename>reportbw.css</cssbwfilename>
    <sortOrder>1</sortOrder>
    <parameter sortorder="1" name="Title" alias="" datatype="FREE_TEXT" isdefaultphp="false" isdate="false" isdecimal="false">
      <desc>A text that will show only in the header of the report and should describe the report</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue></defaultvalue>
    </parameter>
    <parameter sortorder="2" name="Report type" alias="" datatype="HIDDEN_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue></defaultvalue>
    </parameter>
    <parameter sortorder="3" name="Company" alias="{companyId}" datatype="HIDDEN_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo>$defaultValue=Yii::app()-&gt;user-&gt;getState('selectedCompany');</phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('selectedCompanyId');</defaultvalue>
    </parameter>
    <parameter sortorder="4" name="User" alias="" datatype="HIDDEN_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('displayname');</defaultvalue>
    </parameter>
    <parameter sortorder="5" name="Last used transaction" alias="" datatype="HIDDEN_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('showPeriodTransactionNumber')? Period::model()-&gt;findbyPk(Yii::app()-&gt;user-&gt;getState('selectedPeriodId'))-&gt;lastPeriodTransNum :Company::model()-&gt;findbyPk(Yii::app()-&gt;user-&gt;getState('selectedCompanyId'))-&gt;lastAbsTransNum;</defaultvalue>
    </parameter>
    <parameter sortorder="6" name="Start date" alias="{startDate}" datatype="DATE" isdefaultphp="true" isdate="true" isdecimal="false">
      <desc>The start date for the report</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('selectedPeriodStart');</defaultvalue>
    </parameter>
    <parameter sortorder="7" name="End date" alias="{stopDate}" datatype="DATE" isdefaultphp="true" isdate="true" isdecimal="false">
      <desc>The end date for the report</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('selectedPeriodEnd');</defaultvalue>
    </parameter>
    <parameter sortorder="8" name="Account" alias="{accountLimit}" datatype="DROP_DOWN" isdefaultphp="false" isdate="false" isdecimal="false">
      <desc>If desired, choose just one account to show</desc>
      <phpsecondaryinfo>$accountList = ''; if(Yii::app()-&gt;user-&gt;name == "ReportsOnlyUser"){ 	$accountNumbers = Yii::app()-&gt;session['accountNumbers']; 	if(strpos($accountNumbers,'101059') == false){$accountNumbers .= ',101059';} 	$accountList = ' AND code IN ('.$accountNumbers.')'; } $sqlList=CHtml::encodeArray(CHtml::listData(Account::model()-&gt;findAll(array('condition'=&gt;'companyId='.Yii::app()-&gt;user-&gt;getState('selectedCompanyId').$accountList,'select'=&gt;'CONCAT(\'AND Account.id=\',id) as  id, CAST(CONCAT(code,\' \',name) AS CHAR CHARACTER SET utf8) as name','order'=&gt;'code')),'id','name')); $sqlList['']='';</phpsecondaryinfo>
      <defaultvalue></defaultvalue>
    </parameter>
    <parameter sortorder="9" name="" alias="{TransNumField}" datatype="HIDDEN_NO_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;user-&gt;getState('showPeriodTransactionNumber')=='true'?'Trans.periodNum':'companyNum';</defaultvalue>
    </parameter>
    <parameter sortorder="10" name="Todays date" alias="" datatype="HIDDEN_SHOW_HEAD" isdefaultphp="true" isdate="true" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=date('Y-m-d');</defaultvalue>
    </parameter>
    <parameter sortorder="11" name="Url" alias="{url}" datatype="HIDDEN_NO_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;request-&gt;hostInfo . Yii::app()-&gt;request-&gt;scriptUrl;</defaultvalue>
    </parameter>
    <group sortorder="1" breakingfield="accountcode" pagebreak="false" showgrid="false" showheader="false" continuesumsovergroup="false">
      <field sortorder="1" fieldname="accountcode" fieldwidth="15px" row="1" isdate="false" isdecimal="false">
        <fieldcalc></fieldcalc>
      </field>
      <field sortorder="2" fieldname="accountname" fieldwidth="100px" row="1" isdate="false" isdecimal="false">
        <fieldcalc></fieldcalc>
      </field>
    </group>
    <rows sortorder="1" fieldname="TransNum" fieldwidth="10px" row="0" issummed="false" isalignright="false" isdate="false" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="2" fieldname="invDate" fieldwidth="23px" row="0" issummed="false" isalignright="false" isdate="true" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="3" fieldname="Notes" fieldwidth="40px" row="0" issummed="false" isalignright="false" isdate="false" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="4" fieldname="rownotes" fieldwidth="20px" row="0" issummed="false" isalignright="false" isdate="false" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="6" fieldname="Debit" fieldwidth="23px" row="0" issummed="true" isalignright="true" isdate="false" isdecimal="true">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="7" fieldname="Credit" fieldwidth="23px" row="0" issummed="true" isalignright="true" isdate="false" isdecimal="true">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="8" fieldname="balance" fieldwidth="23px" row="0" issummed="false" isalignright="true" isdate="false" isdecimal="true">
      <fieldcalc>$display=$row['ingoing']+ $sums['Debit'] -$sums['Credit'];</fieldcalc>
    </rows>
  </report>
</lazy8webportreport>