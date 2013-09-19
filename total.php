<?php
setlocale(LC_TIME, 'de_DE.utf8');
date_default_timezone_set('Europe/Berlin');
$periods = array('hour', 'day', 'week', 'month', 'year');

$filename = './graphs/total_'.$periods[0].'.png';

if ($_GET['node'] == "total" || !file_exists($filename)) {
    header("Status: 404 Not Found");
    echo('<h1>404 - Not Found</h1>');
    exit();
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>FFHH: Mesh Size</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/ffhh/style.css" />
</head>
<body>
    <header>
        <h1>Freifunk Hamburg</h1>
        <h2>Mesh Size</i></h2>
    </header>
<?php include('navigation.php'); ?>
    <aside>
        <ul>
            <li><b>Diagramme aktualisiert</b>: <?=strftime("%e. %B %Y um %R:%S", filemtime($filename))?> Uhr</li>
        </ul>
    </aside>
    <section>
<?
$even = true;
foreach($periods as $period): ?>
        <img src="/ffhh/graph/total/<?=$period?>" alt="bla - by <?=$period?>" id="n<?=$period?>" class="nimg" /><? if ($even): ?><br /><? endif; ?><?=PHP_EOL?>
<? $even = !$even;
endforeach; ?>
    </section>
<?php include('footer.php'); ?>
</body>
</html>
