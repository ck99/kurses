<?php
/**
 * ScrollingList.php
 * @author ciaran
 * @date 11/07/14 08:27
 *
 */

namespace Kurses;


class ScrollingList extends Panel {
    protected $lines;

    public function __construct($rows = 0, $cols = 0, $y = 0, $x = 0)
    {
        parent::__construct($rows, $cols, $y, $x);
        $this->clear();
        $this->lines = [];
        $this->refresh();
    }

    public function addLine($line) {
        $this->scrollIfNecessary();

        $this->lines[] = $line;
    }

    protected function scrollIfNecessary()
    {
        if(
            (count($this->lines) == ($this->getMaxY()-2)) ||
            ($this->maxLines > 0 && count($this->lines) == $this->maxLines)
        ) {
            array_shift($this->lines);
        }
    }

    public function refresh()
    {
        $this->addText($this->lines);
        parent::refresh();
    }
} 