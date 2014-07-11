<?php

require_once './vendor/autoload.php';

$app  = new \Kurses\Application();
$eventLoop = $app->getEventLoop();
$screen = $app->getScreen();
$tabsManager = $screen->getManager();

$tab1 = $tabsManager->addTab('Tab One');
$tab2 = $tabsManager->addTab('Tab Two');


$eventLoop->every(function()use($tab1) {
        $tab1->panel->addLine(sprintf("[%03d] %s",mt_rand(0,100),time()));
    }, 5);


$eventLoop->every(function()use($tab2) {
        $tab2->panel->addLine(sprintf("[%03d] %s",mt_rand(0,100),time()));
    }, 500);

//$this->panel->addLine(sprintf("%s : [%03d] %s",$this->name, mt_rand(0,100),time()));

$eventLoop->start();