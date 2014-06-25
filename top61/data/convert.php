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

function csv2geojson($csv,$sep){
	$in=csvRead($csv,$sep);

	$geo=['type'=>'FeatureCollection'];
	$geo['features']=array();

	foreach ($in as $row){
		$f=['type'=>'Feature'];
		$f['geometry']=['type'=>'Point','coordinates'=>[(float)$row['lon'],(float)$row['lat']]];
		foreach($row as $k=>$el){
		if($k=="lon" || $k=="lat") continue;
		$f['properties'][$k]=$el;
		}
	$geo['features'][]=$f;
	}
	return json_encode($geo);
}

$i=$_GET['i'];
$o=str_replace("tsv","geojson",$i);
file_put_contents($o,csv2geojson($i,"\t"));
?>
