<?php
/**
 * main.php
 * @author ciaran
 * @date 10/07/14 18:46
 *
 */

require_once './vendor/autoload.php';

$screen = new \Kurses\Screen();
$main = $screen->addPanel('main');
$main->border();
$main->setTitle('Main Screen');

$vPanels = $screen->vSplitPanel($main, [1,1,1]);
$hPanels = $screen->hSplitPanel($vPanels[1], [2,1]);
$screen->vSplitPanel($hPanels[1], [1,4]);
//$screen->vSplitPanel('left', 'left1', 'right1');
//list($topLeft, $bottomLeft) = $screen->hSplitPanel('left', 'leftTop', 'leftBottom');
//list($bottomLeftLeft, $bottomLeftRight) = $screen->vSplitPanel('leftBottom', 'leftBottomLeft', 'rightBottomLeft');



//$screen->addPanel('leftTop', ['panel' => $topLeft]);
//$screen->addPanel('leftBottom', ['panel' => $bottomLeft]);
//
//list($rightTopLeft, $rightBottomLeft) = $right->hSplit(0.25);
//$screen->addPanel('rightTop', ['panel' => $rightTopLeft]);
//$screen->addPanel('rightBottom', ['panel' => $rightBottomLeft]);

//$main->getMaxYX($y, $x);
//$window1 = new \Kurses\Panel($y - 2, ($x / 2), 1, 1);
//$window2 = new \Kurses\Panel($y - 2 , ($x / 2) - 2, 1, ($x / 2) + 2);
//
//$main->border();
//$window1->border();
//$window2->border();
//
//$main->setTitle('JimmyBot');
//
//$window2->setTitle("hello world");
//$window2->addText(['hello', 'how are you', 'x: '.$window2->getMaxX(),'y: '.$window2->getMaxY(),]);
//$window1->addText(['window 1', 'x: '.$window1->getMaxX(),'y: '.$window1->getMaxY(),]);

$screen->refresh();

while (true) {}



