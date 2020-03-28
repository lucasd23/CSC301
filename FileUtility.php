<?php

class FileUtility{

public static function writeAllJSON($file,$data){
	$h=fopen($file,'w');
	fwrite($h,json_encode($data));
	fclose($h);
}

public static function writeJSON($file,$data){
	$array=json_decode(file_get_contents($file),true);
	$array[]=$data;
	FileUtility::writeAllJSON($file,$array);	
}

public static function readJSON($file,$index=null){
	$array=json_decode(file_get_contents($file),true);
	if($index==null || $index >= count($array)) return $array;
	return $array[$index];
}

public static function modifyJSON($file,$index=null, $info){
	
	$array=json_decode(file_get_contents($file),true);
	$array[$index]=$info;
	FileUtility::writeAllJSON($file,$array);
}

public static function deleteJSON($file,$index=null){
	$array=json_decode(file_get_contents($file),true);
	unset($array[$index]);
	$array=array_values($array);
	FileUtility::writeAllJSON($file,$array);
}

public static function readCSV($file,$index=null,$delimiter=';'){
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


public static function deleteCSV($file,$index,$delimiter=';'){
	$data=FileUtility::readCSV($file);
	if($index>count($data)-1) return false;
	unset($data[$index]);
	echo '<pre>';
	print_r($data);
	FileUtility::writeAllCSV($file,$data,$delimiter);
	return true;	
}

public static function modifyCSV($file,$index,$info,$delimiter=';'){
	$data=FileUtility::readCSV($file);
	if($index>count($data)-1) return false;
	$data[$index]=$info;
	echo '<pre>';
	print_r($data);
	FileUtility::writeAllCSV($file,$data,$delimiter);
	return true;	
}


public static function writeCSV($file,$data,$delimiter=';'){
	$h=fopen($file,file_exists($file) ? 'a' : 'w');
	fwrite($h,implode($delimiter,$data).PHP_EOL);
	fclose($h);
}

public static function writeAllCSV($file,$data,$delimiter=';'){
	$h=fopen($file,'w');
	foreach($data as $row){
		fwrite($h,implode($delimiter,$row));
	}
	fclose($h);
}
}
/*
read all the records from a JSON file
read the record with index i in the JSON file
modify the record with index i in the JSON file
delete the record with index i from the JSON file
*/