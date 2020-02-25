<?php


function readCSV($file,$index=null,$delimiter=';'){
	$handle=fopen($file,'r');
	$output=[];
	$count=0;
	while(!feof($handle)){
		$line=fgets($handle);
		if(!isset($line{0})) continue;
		if(isset($index) && $index==$count){
			fclose($handle);
			return explode($delimiter,$line);
		}
		$output[]=explode($delimiter,$line);
		$count++;
	}
	fclose($handle);
	if(isset($index)) return null;
	return $output;
}


function deleteCSV($file,$index,$delimiter=';'){
	$data=readCSV($file);
	if($index>count($data)-1) return false;
	unset($data[$index]);
	echo '<pre>';
	print_r($data);
	writeAllCSV($file,$data,$delimiter);
	return true;	
}

function modifyCSV($file,$index,$info,$delimiter=';'){
	$data=readCSV($file);
	if($index>count($data)-1) return false;
	$data[$index]=$info;
	echo '<pre>';
	print_r($data);
	writeAllCSV($file,$data,$delimiter);
	return true;	
}


function writeCSV($file,$data,$delimiter=';'){
	$h=fopen($file,file_exists($file) ? 'a' : 'w');
	fwrite($h,implode($delimiter,$data).PHP_EOL);
	fclose($h);
}

function writeAllCSV($file,$data,$delimiter=';'){
	$h=fopen($file,'w');
	foreach($data as $row){
		fwrite($h,implode($delimiter,$row));
	}
	fclose($h);
}