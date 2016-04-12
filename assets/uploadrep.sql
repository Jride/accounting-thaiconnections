<?xml version="1.0" encoding="utf-8"?>
<lazy8webportreport version="1.00">
  <report name="Account Balances">
    <desc>Balances of all Accounts that are given</desc>
    <selectsql>SELECT Account.code AS accountcode, Account.name AS accountname, e1.amount AS balance&#13;
FROM Account&#13;
JOIN (&#13;
select accountId, TRIM( TRAILING 0 FROM ROUND( SUM( amount ) , 5 ) ) AS 'amount'&#13;
FROM TransRow&#13;
join Account on Account.id=accountId&#13;
WHERE accountId = Account.id&#13;
group by accountId) e1 ON e1.accountId = Account.id&#13;
WHERE (Account.companyId = {companyId})&#13;
AND (Account.code BETWEEN {startAccount} AND {stopAccount})&#13;
ORDER BY Account.code</selectsql>
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
      <defaultvalue>$defaultValue=Yii::t('lazy8','Account Balance');</defaultvalue>
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
    <parameter sortorder="6" name="Start Account" alias="{startAccount}" datatype="FREE_TEXT" isdefaultphp="false" isdate="false" isdecimal="false">
      <desc>The starting account number</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>101000</defaultvalue>
    </parameter>
    <parameter sortorder="7" name="End Account" alias="{stopAccount}" datatype="FREE_TEXT" isdefaultphp="false" isdate="false" isdecimal="false">
      <desc>The finishing account number</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue></defaultvalue>
    </parameter>
    <parameter sortorder="8" name="Date" alias="{dateBy}" datatype="DATE" isdefaultphp="false" isdate="true" isdecimal="false">
      <desc>Enter a date to get the balances of that date</desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue></defaultvalue>
    </parameter>
    <parameter sortorder="11" name="Url" alias="{url}" datatype="HIDDEN_NO_SHOW_HEAD" isdefaultphp="true" isdate="false" isdecimal="false">
      <desc></desc>
      <phpsecondaryinfo></phpsecondaryinfo>
      <defaultvalue>$defaultValue=Yii::app()-&gt;request-&gt;hostInfo . Yii::app()-&gt;request-&gt;scriptUrl;</defaultvalue>
    </parameter>
    <rows sortorder="1" fieldname="accountcode" fieldwidth="10px" row="0" issummed="false" isalignright="false" isdate="false" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="2" fieldname="accountname" fieldwidth="23px" row="0" issummed="false" isalignright="false" isdate="false" isdecimal="false">
      <fieldcalc></fieldcalc>
    </rows>
    <rows sortorder="6" fieldname="balance" fieldwidth="23px" row="0" issummed="false" isalignright="true" isdate="false" isdecimal="true">
      <fieldcalc></fieldcalc>
    </rows>
  </report>
</lazy8webportreport>
