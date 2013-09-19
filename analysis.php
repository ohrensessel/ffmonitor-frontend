<?php
setlocale(LC_TIME, 'de_DE.utf8');
date_default_timezone_set('Europe/Berlin');

$nodelist = json_decode(file_get_contents('namedb.json'), true);

$statsf = fopen('stats.txt', 'r');


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
    <title>FFHH: Statistiken</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/ffhh/style.css" />
</head>
<body>
    </header>
        <h1>Freifunk Hamburg</h1>
        <h2>Offline Statistik</h2>
    </header>
<?php include('navigation.php'); ?>
    <section>
        <table>
            <tr>
                <th>Offline [%]</th>
                <th>Knoten</th>
            </tr>
<?php
$statsf = fopen('stats.txt', 'r');

while(!feof($statsf)) {
    $line = fgetcsv($statsf, 28, ' '); 
    $nodename=(isset($nodelist[$line[1]]) && strlen($nodelist[$line[1]]) > 0)?$nodelist[$line[1]]:wordwrap($line[1], 2, ':', true);?>
            <tr>
                <td class="offline"><? printf('%3.2f', $line[0]);?></td>
                <td><a href="/ffhh/view/<?=$line[1];?>"><?=$nodename;?></a></td>
            </tr>
<?php }

fclose($file_handle);
?>
        </table>
    </section>
<?php include('footer.php'); ?>
</body>
</html>
