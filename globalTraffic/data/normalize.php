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

$coordf="../../../common/countryInfo.tsv";

$file=$_GET['i'];

$sep="\t";
$coord=csvRead($coordf,$sep);
$data=csvRead($file,$sep);

$res= fopen("normalized_".$file, "w+");

$header=array_keys($data[0]);

fputcsv($res,$header,$sep);
foreach($data as &$r)
{
$t=array();
    $area=findR(trim($r['ISO_A3']));
if($area==-1){echo $r['ISO_A3']; continue;}
foreach($r as $k=>$v){
if ($k=='ISO_A3'||$k=='Nation') $t[]=$v;
else
$t[]=number_format($v/$area,10,".",""); //10 decimali
}

fputcsv($res,$t,"\t");
}
fclose($res);

function findR($p){
global $coord;
foreach($coord as $k){
    if ($k['ISO3']==$p) return $k['Population'];
}
return -1;
}
?>
