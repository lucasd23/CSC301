<?php

//writeJSON('newjson.json',
	//[['firstname'=>'Paul','lastname'=>'McCartney']]);
//print_r(json_decode(file_get_contents('newjson.json'),true));
//modifyJSON('newjson.json', 2, ['firstname'=>'Dillon','lastname'=>'Lucas']);
//deleteJSON('newjson.json', 2);
//print_r(readJSON('newjson.json'));

function writeAllJSON($file,$data){
	$h=fopen($file,'w');
	fwrite($h,json_encode($data));
	fclose($h);
}

function writeJSON($file,$data){
	$array=json_decode(file_get_contents($file),true);
	$array[]=$data;
	writeAllJSON($file,$array);	
}

function readJSON($file,$index=null){
	$array=json_decode(file_get_contents($file),true);
	if($index==null || $index >= count($array)) return $array;
	return $array[$index][0];
}

function modifyJSON($file,$index=null, $info){
	
	$array=json_decode(file_get_contents($file),true);
	$array[$index]=$info;
	writeAllJSON($file,$array);
}

function deleteJSON($file,$index=null){
	$array=json_decode(file_get_contents($file),true);
	unset($array[$index]);
	$array=array_values($array);
	writeAllJSON($file,$array);
}

/*
read all the records from a JSON file
read the record with index i in the JSON file
modify the record with index i in the JSON file
delete the record with index i from the JSON file
*/