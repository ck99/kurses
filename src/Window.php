<?php
/**
 * Window.php
 * @author ciaran
 * @date 10/07/14 18:44
 *
 */
namespace Kurses;

use Kurses\Formatter\NcursesOutputFormatter;

class Window
{
    protected  $window = null;

    public $rows;
    public $cols;
    public $x;
    public $y;

    public $maxLines;
    const START_ROW = 2;
    const START_COL = 2;

    /** @var NcursesOutputFormatter  */
    protected $formatter = null;

    /**
     * Create window
     *
     * @param int $rows
     * @param int $cols
     * @param int $y
     * @param int $x
     * @return void
     */
    public function __construct($rows = 0, $cols = 0, $y = 0, $x = 0)
    {
        $this->window = ncurses_newwin($rows, $cols, $y, $x);
        $this->cols = $this->getMaxX();
        $this->rows = $this->getMaxY();
        $this->x = $x;
        $this->y = $y;

        $this->maxLines = (($this->getMaxY() - $y)-2);
    }

    public function getWindow()
    {
        return $this->window;
    }

    public function getMaxYX(&$y, &$x)
    {
        ncurses_getmaxyx($this->window, $y, $x);
    }

    public function getMaxX()
    {
        $x = $y = null;
        $this->getMaxYX($y, $x);
        return $x;
    }

    public function getMaxY()
    {
        $x = $y = null;
        $this->getMaxYX($y, $x);
        return $y;
    }

    public function border($left = 0, $right = 0, $top = 0, $bottom = 0, $tl_corner = 0,
        $tr_corner = 0, $bl_corner = 0, $br_corner = 0)
    {
        return ncurses_wborder($this->window, $left, $right, $top, $bottom,
            $tl_corner, $tr_corner, $bl_corner, $br_corner);
    }

    /**
     * Refresh (redraw) window
     */
    public function refresh()
    {
        ncurses_wrefresh($this->window);
    }

    public function setTitle($title)
    {
        $this->border();
        ncurses_wattron($this->getWindow(), NCURSES_A_REVERSE);
        ncurses_mvwaddstr($this->window, 0, 2, $title);
        ncurses_wattroff($this->getWindow(), NCURSES_A_REVERSE);
    }

    public function addText($text)
    {
        if(!is_array($text)) {
            $text = [$text];
        }

        for ($j=0; $j<count($text); $j++) {
            $this->writeLineToScreen($j, $text);
        }
    }

    public function clear()
    {
        for ($j=0; $j<$this->rows; $j++) {
            ncurses_mvwaddstr($this->window, $j, 0, str_repeat(' ', $this->cols));
        }
    }

    /**
     * @param $row
     * @param $text
     */
    public function writeLineToScreen($row, $text)
    {
        if($this->formatter) {
            $this->writeFormattedLineToScreen($row, $text);
        }
        else {
            ncurses_mvwaddstr($this->window, self::START_ROW + $row, self::START_COL, str_pad($text[$row], ($this->cols - 3), ' '));
        }
    }

    public function writeFormattedLineToScreen($row, $text)
    {
//        $this->formatter->writeFormattedLine($row, self::START_COL, $text);
        $this->formatter->writeFormattedLine($this->window, $row, self::START_COL, $text);
    }

    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }
}