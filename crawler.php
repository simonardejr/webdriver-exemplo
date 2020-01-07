<?php

require_once 'webdriver.php';

$wd = new webdriver;

$wd->get('https://www.torneo.ca/', 'section[id="canv-container"]');
echo $wd->getText('.description');

$wd->get('https://www.torneo.ca/statistics/basketball/1', 'div[id="matches"]');
echo $wd->getText('.container');