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

$coordf="../../common/locode_coordinates.tsv";

$file=$_GET['i'];

$sep="\t";
$coord=csvRead($coordf,$sep);
$data=csvRead($file,$sep);

$res= fopen("gc_".$file, "w+");

$header=array_keys($data[0]);
$header[]="lon";
$header[]="lat";
fputcsv($res,$header,$sep);
foreach($data as &$r)
{
    $port=findR(trim($r['locode']));
    if($port!=-1)
	{
    $r['lon']=$port['lon'];
    $r['lat']=$port['lat'];
	}
    else
    {
        echo $r['locode']."   ";
        echo $r['Ports']."<br>";
        $r['lon']="#";
        $r['lat']="#";
    }

fputcsv($res,$r,"\t");
}
fclose($res);

function findR($p){
global $coord;
foreach($coord as $k){
    if ($k['locode']==$p) return $k;
}
return -1;
}
?>
