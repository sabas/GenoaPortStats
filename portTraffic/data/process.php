<?php

function csvRead($file,$sep)
{
$csv=[];
	if (($handle = fopen($file, "r")) !== FALSE) {
		$k=0;

		while (($data = fgetcsv($handle, 1000, $sep)) !== FALSE) {
			++$k;

			if ($k==1)
			{
				$i=-1;
				foreach ($data as $cell)
				{
                    $i++;
					$csv[$i]['series']=$cell;
				}
			continue;
			}

			if ($k==2)
			{
				$i=-1;
				foreach ($data as $cell)
				{
                    $i++;
					$csv[$i]['unit']=$cell;
				}
			continue;
			}

			$i=-1;
			foreach ($data as $cell)
			{
                $i++;
				$csv[$i]['data'][]=$cell;
			}
		}
		fclose($handle);
	}
	return $csv;
}

function csvDump($arr,$sep)
{
	$tmp='';
    $tmp.= implode($sep,array_keys($array))."\n";
	foreach ($arr as $line)
	{
        if (!is_array($line))$tmp.=$line;
        else
		$tmp.= implode($sep,$line)."\n";
    }
    return 	$tmp;
}

$i="MonthlyPortStats.tsv";
$sep="\t";
$in=csvRead($i,$sep);
$hold=array();

$time=[];
foreach ($in as $k => $series){
    //first is time
    if ($k==0) {
        $time=$series['data'];
        continue;
    }
    $arr['key']=$series['series'];
    $arr['values']=[];
    foreach ($series['data'] as $i => $d){
    $arr['values'][]=[$time[$i],$d];
    }
    $hold[$series['unit']][]=$arr;
}
foreach ($hold as $unit =>$data){
file_put_contents($unit.".json",json_encode($data,JSON_NUMERIC_CHECK));
}
?>
