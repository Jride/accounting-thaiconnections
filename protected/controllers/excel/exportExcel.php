<?php

class exportExcel {
	public function exportExcel($model, $reader, $pdf_name, $numberFormatter, $dateFormatter, $numberFormat, $printoutview, $parameterValues){

		// echo "<pre>";
		// var_dump($dateFormatter);
		// echo "</pre>";
		// die();

		// filename for download
		$filename = 'Exported_Data_' . date('Ymd') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$flag = false;
		foreach($reader as $row) {

			// Edit the balance to 2 decimal places
			if (isset($row['balance']))
				$row['balance'] = $numberFormatter->format($numberFormat,$row['balance']);

			if (isset($row['Debit']))
				$row['Debit'] = $numberFormatter->format($numberFormat,$row['Debit']);

			if (isset($row['Credit']))
				$row['Credit'] = $numberFormatter->format($numberFormat,$row['Credit']);

			if(isset($row['regDate']))
				$row['regDate'] = $dateFormatter->formatDateTime($row['regDate'],'medium',null);

			if(isset($row['invDate']))
				$row['invDate'] = $dateFormatter->formatDateTime($row['invDate'],'medium',null);

			if(isset($row['dateChanged']))
				$row['dateChanged'] = $dateFormatter->formatDateTime($row['dateChanged'],'medium',null);

			if(!$flag) {
			  // display field/column names as first row
			  echo implode("\t", array_keys($row)) . "\r\n";
			  $flag = true;
			}

			array_walk($row, array($this, 'cleanData'));
			
			echo implode("\t", array_values($row)) . "\r\n";
		}
		
		exit;

	}

	function cleanData(&$str)
  	{
    	$str = preg_replace("/\t/", "\\t", $str);
    	$str = preg_replace("/\r?\n/", "\\n", $str);
   		if(strstr($str, '"')){
   			$str = '"' . str_replace('"', '""', $str) . '"';
   		}
  	}
}
