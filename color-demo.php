<?php

require_once '../../autoload.php';

$app         = new \Kurses\Application();
$eventLoop   = $app->getEventLoop();
$screen      = $app->getScreen();
$tabsManager = $screen->getManager();
$tab1        = $tabsManager->addTab('Tab One');

$panel = $tab1->panel;
$panel->setFormatter(new \Kurses\Formatter\NcursesOutputFormatter);
$panel->writeFormattedLineToScreen(3, "<1>hello</1> <2>Worls</2>");

$eventLoop->start();