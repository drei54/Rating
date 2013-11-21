<?php

#inlcude flibrary 
require_once 'E:/xampp/htdocs/homeasia/lib/PHPExcel.php';

/**
* class count average rating from item list
*/
class rating_average{
	/**
	* get data from file excel
	*/
	public function get_excel($inputFileName){
		$ret = array();
		 
		$objReader 		= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel 	= $objReader->load($inputFileName);
		$objWorksheet 	= $objPHPExcel->getActiveSheet();
		$highestRow 	= $objWorksheet->getHighestRow();
		 
		for ($row = 2; $row <= $highestRow; $row++) {
			$a 	= $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
			$b 	= $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();    
			$c 	= $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();    
			$ret[$a][] = array('b'=>$b, 'c'=>$c);   
		}
		
		return $ret;
	}

	/**
	* view list item 
	*/
	public function view_list($items){
		foreach ($items as $item) {
				echo $item['a'] . " ". $item['c']." ".$item['b']."\r\n";
		}
	}
	
	/**
	* count rating averate item 
	*/
	public function count_average($items, $var){
		$sd = str_replace('-','',$var['sd']);
		$ed = str_replace('-','',$var['ed']);
		
		foreach ($items as $k => $item) {
			foreach ($item as $it){
				$exp = explode(' ',$it['c']);
				$dt = str_replace('-','',$exp[0]);
				if($dt >= $sd AND $dt <= $ed){
					$cnt[$k]['cnt'] 	= (isset($cnt[$k]['cnt']) == 0) ? 1 : $cnt[$k]['cnt'] + 1;
					$cnt[$k]['sum'] 	= (isset($cnt[$k]['sum']) == 0) ? $it['b'] : $cnt[$k]['sum'] + $it['b'];
				}
			}
		}
		
		foreach($items as $k => $item){
			$cnt[$k]['avg'] = round(($cnt[$k]['sum'] / $cnt[$k]['cnt']),1);
			#echo $k." ".sizeof($item)." ".$cnt[$k]['cnt']." ".$cnt[$k]['sum']." ".$cnt[$k]['avg']."\r\n";
		}
		
		return $cnt;
	}

	/**
	* main program
	*/
	public function main($var){
		$ret['item_list'] 		= $this->get_excel($var['location_item_list']);
		$ret['item_rating'] 	= $this->get_excel($var['location_item_rating']);
		$ret['cnt'] 				= $this->count_average($ret['item_rating'], $var);
		
		return $ret;
	}
}
/*
#assign variable
$var['location_item_list'] 		= 'E:/xampp/htdocs/homeasia/item_list.xlsx';
$var['location_item_rating'] 	= 'E:/xampp/htdocs/homeasia/item_rating.xlsx';

#call class
$class = new rating_average();
$class->main($var);
*/
?>