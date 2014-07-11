<?php
/**
 * main.php
 * @author ciaran
 * @date 10/07/14 18:46
 *
 */

require_once './vendor/autoload.php';


$eventLoop = new \Kurses\Adapter\AlertAdapter((new \Alert\ReactorFactory())->select());

$screen  = new \Kurses\Screen($eventLoop);
$main    = $screen->addPanel([]);
$hPanels = $screen->hSplitPanel($main, [1,10]);
$vPanels = $screen->vSplitPanel($hPanels[0], [2,2,1]);

/** @var \Kurses\ScrollingList $scroller */
$scroller = $screen->replacePanelWithType($vPanels[1], 'Kurses\ScrollingList');
$scroller->border();
$scroller->setTitle('Scroller');
$eventLoop->every(function()use($scroller) {
        $scroller->addLine(sprintf("[%03d] %s",mt_rand(0,100),time()));
    }, 1200);

/** @var \Kurses\ScrollingList $scroller */
$fastScroller = $screen->replacePanelWithType($vPanels[2], 'Kurses\ScrollingList');
$fastScroller->border();
$fastScroller->setTitle('FastScroller');
$eventLoop->every(function()use($fastScroller) {
        $fastScroller->addLine(sprintf("[%03d] %s",mt_rand(0,100),time()));
    }, 200);

/** @var \Kurses\ScrollingList $scroller */
$reallyFastScroller = $screen->replacePanelWithType($vPanels[0], 'Kurses\ScrollingList');
$reallyFastScroller->border();
$reallyFastScroller->setTitle('ReallyFastScroller');
$eventLoop->every(function()use($reallyFastScroller) {
        $reallyFastScroller->addLine(sprintf("[%03d] %s",mt_rand(0,100),time()));
    }, 20);

//$main->border();
//$main->setTitle('Main Screen');
//
//$vPanels = $screen->vSplitPanel($main, [4,1]);


//$hPanels = $screen->hSplitPanel($vPanels[1], [1,1,1,1,1,1,1,1]);


$eventLoop->start();

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



