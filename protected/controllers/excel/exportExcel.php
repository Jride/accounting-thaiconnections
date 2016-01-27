<?php

class exportExcel {
	public function exportExcel($model, $reader, $pdf_name, $numberFormatter, $dateFormatter, $numberFormat, $printoutview, $parameterValues){


		// filename for download
		$filename = 'Exported_Data_' . date('Ymd') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$flag = false;
		foreach($reader as $row) {

			// Edit the balance to 2 decimal places
			if (isset($row['balance'])){
				$row['balance'] = number_format((float)$row['balance'], 2, '.', '');
			}

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
