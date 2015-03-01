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

$coordf="../../../isoalpha3.tsv";

$file=$_GET['i'];

$sep="\t";
$coord=csvRead($coordf,$sep);
$data=csvRead($file,$sep);

$res= fopen("mat_".$file, "w+");

$header=array_keys($data[0]);
fputcsv($res,$header,$sep);
foreach($data as &$r)
{
    $port=findR(trim($r['Nation']));
    if($port!=-1)
	{
    $r['ISO_A3']=$port;
	}
    else
    {
        echo $r['Nation']."<br>";
    }

fputcsv($res,$r,"\t");
}
fclose($res);

function findR($p){
global $coord;
foreach($coord as $k){
    if ($k['name']==$p) return $k['alpha-3'];
}
return -1;
}
?>
