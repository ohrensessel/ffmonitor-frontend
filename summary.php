<?php
setlocale(LC_TIME, 'de_DE.utf8');
date_default_timezone_set('Europe/Berlin');
$periods = array('hour', 'day', 'week', 'month', 'year');

if (!isset($_GET['periode']) || !in_array($_GET['periode'], $periods)) {
    $period=$periods[0];
} else {
    $period = $_GET['periode'];
}


$nodelist = json_decode(file_get_contents('namedb.json'), true);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>FFHH: Node <?=$nodename?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/ffhh/style.css" />
</head>
<body>
    <header>
        <h1>Freifunk Hamburg</h1>
        <h2>&Uuml;bersicht</h2>
    </header>
<?php include('navigation.php'); ?>
    <aside>
        Zeitraum anzeigen
        <ul>
<?php foreach($periods as $name): ?>
            <li><a href="/ffhh/summary/<?=$name?>"> <?=$name?></a></li>
<?php endforeach; ?>
        </ul>
    </aside>
    <section>
<?
$even = true;
foreach($nodelist as $mac => $name): ?>
        <figure>
            <img src="/ffhh/graph/<?=$mac?>/<?=$period?>" alt="connections of freifunk node <?=$mac?> - by <?=$period?>" id="<?=$mac?>" class="nimg" /><?=PHP_EOL?>
            <figcaption>
                <a href="/ffhh/view/<?=$mac?>">
                <? if (strlen($name) == 0): ?>
    <?=wordwrap($mac, 2, ':', true)?>
                <? else: ?>
    <?=$name?>
                <? endif; ?><?=PHP_EOL?>
                </a>
            </figcaption>
        </figure><? if ($even): ?><br /><? endif; ?><?=PHP_EOL?>
<? $even = !$even;
endforeach; ?>
<? if ($even): ?><br /><? endif; ?>
    </section>
<?php include('footer.php'); ?>
</body>
</html>
