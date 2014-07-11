<?php
/**
 * Window.php
 * @author ciaran
 * @date 10/07/14 18:44
 *
 */
namespace Kurses;

class Window
{
    protected  $window = null;

    const BORDER_STYLE_SOLID    = 1; // ┐
    const BORDER_STYLE_DOUBLE   = 2; // ╗
    const BORDER_STYLE_BLOCK    = 3; // ■

    public $rows;
    public $cols;
    public $x;
    public $y;

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
        $this->cols = $cols;
        $this->rows = $rows;
        $this->x = $x;
        $this->y = $y;
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

    public function borderStyle($style)
    {
        if ($style == self::BORDER_STYLE_SOLID)
        {
            $this->border();
        }
        elseif($style == self::BORDER_STYLE_DOUBLE)
        {
            $this->border(226, 186, 205, 205, 201, 187, 200, 188);
//            $this->border(ord('║'), ord('║'), ord('═'), ord('═'), ord('╔'), ord('╗'), ord('╚'), ord('╝'));
        }
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
        ncurses_mvwaddstr($this->window, 0, 2, $title);
    }

    public function addText($text)
    {
        if(!is_array($text)) {
            $text = [$text];
        }
        for ($j=0; $j<count($text); $j++) {
            ncurses_mvwaddstr($this->window, 2+$j, 2, $text[$j]);
        }
    }
}