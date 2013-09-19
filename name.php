<?php
$nodelist = json_decode(file_get_contents('namedb.json'), true);
$nodelist = array_flip($nodelist);
if (isset($nodelist[$_GET['node']])) {
    header( 'Location: /ffhh/view/'.$nodelist[$_GET['node']]);
} else {
    header("Status: 404 Not Found");
    echo('<h1>404 - Not Found</h1>');
    exit();    
}    
?>
