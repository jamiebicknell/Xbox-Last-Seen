<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>XBOX Widget</title>
<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
<link href='./screen.css' rel='stylesheet' type='text/css' />
</head>
<body>

<?php

$user = 'rentedsmile';
$url = 'http://gamercard.xbox.com/en-US/' . rawurlencode($user) . '.card';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$output = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$html = new DOMDocument;
$html->loadHTML($output);
$user = $html->getElementById('Gamertag')->nodeValue;
$game = $html->getElementById('Gamerscore')->nodeValue;
$list = $html->getElementById('PlayedGames');
$imge = $list->getElementsByTagName('img')->item(0)->getAttribute('src');
$name = $list->getElementsByTagName('span')->item(0)->nodeValue;
$date = strtotime($list->getElementsByTagName('span')->item(1)->nodeValue);
$time = (date('dmy',$date)==date('dmy')) ? 'earlier today' : ((date('dmy',$date)==date('dmy',strtotime('yesterday'))) ? 'yesterday' : floor((time()-$date)/86400) . ' days ago');
$sco1 = $list->getElementsByTagName('span')->item(2)->nodeValue;
$sco2 = $list->getElementsByTagName('span')->item(3)->nodeValue;
$perc = $list->getElementsByTagName('span')->item(6)->nodeValue;

?>

<div id='widget'>
    <span><?=$game;?></span>
    <a href='http://live.xbox.com/en-US/MyXbox/Profile?Gamertag=<?=rawurlencode($user);?>'><?=$user;?></a>
    <div class='left'>
        <img src='<?=$imge;?>' alt='<?=$name;?>' />
    </div>
    <div class='right'>
        Last seen <?=$time;?> playing <?=str_replace('â¢','&trade;',$name);?>
        <span><?=$sco1;?> <em>out of</em> <?=$sco2;?></span>
        <div class='indicator'><div><div style='width:<?=$perc;?>;'></div></div></div>
    </div>
    <div class='clear'></div>
</div>

</body>
</html>