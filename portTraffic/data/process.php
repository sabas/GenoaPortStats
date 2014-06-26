<?php
function csvRead($file,$sep)
{
	if (($handle = fopen($file, "r")) !== FALSE) {
		$k=0;

		while (($data = fgetcsv($handle, 1000, $sep)) !== FALSE) {
			++$k;

			if ($k==1)
			{
				$i=-1;
				foreach ($data as $cell)
				{
					$titles[++$i]=$cell;
				}
			continue;
			}

			$i=-1;
				foreach ($data as $cell)
				{
				$csv[$k-2][$titles[++$i]]=$cell;
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

$i=$_GET['i'];
$sep="\t";
$in=csvRead($i,$sep);

$hold=array();

foreach ($in as $row){
    $unit=$row['unit'];
    unset($row['unit']);
    $key=$row['object'];
    unset($row['object']);
    if(!is_array($hold))$hold[$unit]=[];
    $temp=[];

    $temp['key']=$key;
    $temp['values']=[];
    foreach($row as $y=>$occ){
        $temp['values'][]=[$y,(int)$occ];
    }
    $hold[$unit][]=$temp;
}

//echo json_encode($hold,JSON_NUMERIC_CHECK);

foreach ($hold as $unit => $data){
file_put_contents($unit.".json",json_encode($data));
}

?>