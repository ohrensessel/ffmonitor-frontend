<?php
setlocale(LC_TIME, 'de_DE.utf8');
date_default_timezone_set('Europe/Berlin');
$periods = array('hour', 'day', 'week', 'month', 'year');

$filename = './graphs/'.$_GET['node'].'_'.$periods[0].'.png';

if ($_GET['node'] == "total" || !file_exists($filename)) {
    header("Status: 404 Not Found");
    echo('<h1>404 - Not Found</h1>');
    exit();
}

$nodelist = json_decode(file_get_contents('namedb.json'), true);
$nodename = (isset($nodelist[$_GET['node']]) && strlen($nodelist[$_GET['node']]) > 0)?$nodelist[$_GET['node']]:wordwrap($_GET['node'], 2, ':', true);

$statsf = fopen('stats.txt', 'r');

$fractoff = NAN;

while(!feof($statsf)) {
    $line = fgetcsv($statsf, 28, ' ');
    if ($line[1] ==  $_GET['node']) {
        $fractoff = floatval($line[0]);
        break;
    }
}
fclose($file_handle);
$statsmodified =filemtime('stats.txt');

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>FFHH: Node <?=$nodename?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/ffhh/style.css" />
</head>
<body>
    <header>
        <h1>Freifunk Hamburg</h1>
        <h2>Verbindungsstatistik f&uuml;r Knoten <i><?=$nodename?></i></h2>
    </header>
<?php include('navigation.php'); ?>
    <aside>
        <ul>
            <li><b>Knoten</b>: <?=$nodename?></li>
<? if (isset($nodelist[$_GET['node']]) && strlen($nodelist[$_GET['node']]) >0) { ?>
            <li><b>MAC</b>: <?=wordwrap($_GET['node'], 2, ':', true); ?></li>
<? } ?>
            <li><b>Anteilig Offline</b>: <? printf('%.2f',round($fractoff,2));?>%<br /><i>(innerhalb von 24 Stunden, zwischen <?=strftime("%e. %B %Y %R", $statsmodified - 86400)?> Uhr und <?=strftime("%e. %B %Y %R", $statsmodified)?> Uhr)</i></li>
            <li><b>Diagramme aktualisiert</b>: <?=strftime("%e. %B %Y um %R:%S", filemtime($filename))?> Uhr</li>
        </ul>
    </aside>
    <section>
<?
$even = true;
foreach($periods as $period): ?>
        <img src="/ffhh/graph/<?=$_GET['node']?>/<?=$period?>" alt="connections of freifunk node <?=$_GET['node']?> - by <?=$period?>" id="n<?=$period?>" class="nimg" /><? if ($even): ?><br /><? endif; ?><?=PHP_EOL?>
<? $even = !$even;
endforeach; ?>
    </section>
<?php include('footer.php'); ?>
</body>
</html>
