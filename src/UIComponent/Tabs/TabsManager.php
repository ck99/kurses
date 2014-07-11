<?php
/**
 * TabsManager.php
 * @author ciaran
 * @date 11/07/14 16:22
 *
 */

namespace Kurses\UIComponent\Tabs;

use Kurses\Event\KeyboardEvent;
use Kurses\Panel;
use Kurses\ScrollingList;
use Kurses\Window;

class TabsManager {
    protected $tabs;
    protected $screen;

    protected $rows;
    protected $cols;
    protected $window;

    protected $active = 1;

    public function __construct($window)
    {
        $this->window = $window;
        ncurses_getmaxyx($this->window, $y, $x);
        $this->rows = $y-1;
        $this->cols = $x;
        $this->tabs = [];
    }

    public function onKeyboardEvent(KeyboardEvent $event)
    {
        $tabMap = [
            NCURSES_KEY_F1,
            NCURSES_KEY_F2,
            NCURSES_KEY_F3,
            NCURSES_KEY_F4,
            NCURSES_KEY_F5,
            NCURSES_KEY_F6,
            NCURSES_KEY_F7,
            NCURSES_KEY_F8,
            NCURSES_KEY_F9,
            NCURSES_KEY_F10,
            NCURSES_KEY_F11,
            NCURSES_KEY_F12,
        ];
        $tab = array_search($event->keycode, $tabMap);
        if(is_int($tab) && $tab < count($this->tabs)) {
            $this->active = $tab;
            return;
        }

        if($event->keycode == 9) {
            $this->active++;
            $this->active = $this->active % count($this->tabs);
        }

        $this->tabs[$this->active]->onKeyboardEvent($event);

        $this->draw();
    }

    public function draw()
    {
        $start = 3;

        foreach($this->tabs as $i => $tab) {
            $attrs = NCURSES_A_UNDERLINE;
            ncurses_wmove($this->window, 0, $start);
//            ncurses_wvline($this->window, NCURSES_A_NORMAL, 1);
            if ( $i === $this->active ) $attrs += NCURSES_A_REVERSE;
            if($tab->hasAlert()) ncurses_wcolor_set($this->window, 0);
            if ( $attrs ) ncurses_wattron( $this->window, $attrs );
            $tabName = sprintf("[F%d] %s", $i+1, $tab->name);
            ncurses_mvwaddstr($this->window, 0, ($start+1), $tabName);
            if ($attrs) ncurses_wattroff( $this->window, $attrs );
//            ncurses_wvline($this->window, NCURSES_A_NORMAL, 1);
            $start += (strlen($tabName) + 3);

            if($i === $this->active) {
                $tab->draw();
                ncurses_top_panel($tab->panel->panel);
            }
        }
    }

    public function addTab($name)
    {
        $tab = new \Kurses\UIComponent\Tabs\Tab($name);
        $this->createTabWindow($tab);
        return $tab;
    }

    /**
     * @param Tab $tab
     */
    private function createTabWindow(Tab $tab)
    {
        $panel = new ScrollingList($this->rows - 1, $this->cols - 1, 1, 1);
        $panel->border();
        $tab->setPanel($panel);
        $this->tabs[] = $tab;
    }
} 