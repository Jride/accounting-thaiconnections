SELECT 
	CONCAT('<a href="{url}?r=trans/update&id=',Trans.id,'"  target="_blank">',{TransNumField},'</a>') as TransNum, 
	Trans.*,
	Trans.notes as Notes,
	TransRow.notes as rownotes, 
	Account.code as accountcode, 
	Account.name as accountname,
	CAST(CONCAT(Customer.code,' ', Customer.name) AS CHAR CHARACTER SET utf8) as CustomerName, 
	IF(amount<0, 0, amount) as Debit,
	IF(amount<0,-amount,0) as Credit,
	CONCAT(Customer.code, ' - ', Customer.name) AS Tag,
	CONCAT(Donor.code, ' - ', Donor.name) AS Donor
FROM TransRow 
JOIN Trans ON TransRow.transId=Trans.id 
JOIN Account ON TransRow.accountId=Account.id

LEFT join Customer ON customerId=Customer.id 

WHERE Trans.companyId={companyId} 
AND Trans.invDate>=DATE '{startDate}' 
AND Trans.invDate<=DATE '{stopDate}' 
AND {TransNumField}>=CAST('{startTransNum}' as UNSIGNED) 
AND IF(CAST('{endTransNum}' AS UNSIGNED)>0,({TransNumField}<=CAST('{endTransNum}' AS UNSIGNED)),true) 
ORDER BY companyNum

-- // ***********************

select CONCAT('<a href="{url}?r=trans/update&id=',Trans.id,'"  target="_blank">',{TransNumField},'</a>') as TransNum,
        Trans.*,
		Trans.notes AS Notes,
		CASE WHEN Donor.name IS NOT NULL 
			THEN CONCAT(COALESCE(TransRow.notes, ''), ' - Donor[', COALESCE(Donor.name, ''), ']')
			ELSE TransRow.notes
		END AS rownotes,
		e1.ingoing, 
		Account.code AS accountcode, 
		Account.name AS accountname,
		IF(amount<0, 0, amount) AS Debit,
		IF(amount<0,-amount,0) AS Credit,
		CONCAT(Customer.code, ' - ', Customer.name) AS Tag,
		CONCAT(Donor.code, ' - ', Donor.name) AS Donor
FROM TransRow
LEFT JOIN Donor on TransRow.donorId=Donor.id
JOIN Trans ON TransRow.transId=Trans.id 
JOIN Account ON TransRow.accountId=Account.id
LEFT JOIN AccountCustomerAssignment on Account.id=AccountCustomerAssignment.accountId
LEFT JOIN Customer on Customer.id=AccountCustomerAssignment.customerId
LEFT JOIN (
	SELECT IF(isInBalance,TRIM(TRAILING 0 FROM ROUND(SUM(amount),5)),0) AS 'ingoing',
	accountId 
	FROM TransRow
	LEFT JOIN Donor on TransRow.donorId=Donor.id	
	JOIN Trans ON TransRow.transId=Trans.id 
	JOIN Account ON Account.id=accountId 
	JOIN AccountType ON AccountType.id=Account.accountTypeId
	WHERE Trans.companyId={companyId} 
	AND invDate<DATE '{startDate}' 
	GROUP BY accountid
) e1 ON e1.accountId=TransRow.accountId  
WHERE Trans.companyId={companyId} 
AND Trans.invDate>=DATE '{startDate}' 
AND Trans.invDate<=DATE '{stopDate}' 
{accountLimit}
ORDER BY TransRow.accountId,Trans.invDate