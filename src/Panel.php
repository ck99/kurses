<?php
/**
 * Panel.php
 * @author ciaran
 * @date 10/07/14 19:05
 *
 */

namespace Kurses;


class Panel extends Window {
    public $panel;

    public function __construct($rows = 0, $cols = 0, $y = 0, $x = 0)
    {
        parent::__construct($rows, $cols, $y, $x);
        $this->panel = ncurses_new_panel($this->getWindow());
        $rows = $this->getMaxY();
        $cols = $this->getMaxX();
        $this->addText(["R: $rows, C:$cols", "x:$x, y: $y"]);
    }

    /**
     * @param mixed $panelRatios
     * @return Panel[]
     */
    public function vSplit($panelRatios = [1,1])
    {
        $this->getMaxYX($maxY, $maxX);

        $maxX -= 2;

        $totalParts = array_reduce($panelRatios, function($v1,$v2){return $v1 + $v2;}, 0);
        $onePart = intval($maxX / $totalParts);
        $remainder = $maxX % $totalParts;

        $panels = [];

        $rows = $maxY - 2;
        $y = $this->y + 1;
        $x = $this->x + 1;
        foreach($panelRatios as $index => $panelSlice) {
            $cols = $onePart * $panelSlice;
            if($index == 0) $cols += $remainder;
            $panels[] = new Panel($rows, $cols, $y, $x);
            $x += ($cols);
        }

        return $panels;
    }

    /**
     * @param mixed $panelRatios
     * @return Panel[]
     */
    public function hSplit($panelRatios = [1,1])
    {
        $this->getMaxYX($maxY, $maxX);

        $maxY -= 2;

        $totalParts = array_reduce($panelRatios, function($v1,$v2){return $v1 + $v2;}, 0);
        $onePart = intval($maxY / $totalParts);
        $remainder = $maxY % $totalParts;

        $panels = [];

        $cols = $maxX - 2;
        $y = $this->y + 1;
        $x = $this->x + 1;
        foreach($panelRatios as $index => $panelSlice) {
            $rows = $onePart * $panelSlice;
            if($index == 0) $rows += $remainder;
            $panels[] = new Panel($rows, $cols, $y, $x);
            $y += ($rows);
        }

        return $panels;
    }

    public function refresh()
    {
        return;
    }

//    public function clear()
//    {
//        $this->addText(['']);
//    }

//    public function __construct(Window $window)
//    {
//        $this->window = $window;
//        $this->panel = ncurses_new_panel($window->getWindow());
//    }
}