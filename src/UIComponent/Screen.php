<?php
/**
 * Screen.php
 * @author ciaran
 * @date 11/07/14 13:11
 *
 */

namespace Kurses\UIComponent;


use Kurses\Event\KeyboardEvent;
use Kurses\UIComponent\Tabs\TabsManager;
use Kurses\Window;

class Screen {
    private $window;
    private $panel;

    private $rows;
    private $cols;

    protected $tabPanels;
    protected $tabHeadingLength;

    protected $manager;

    private $statusBarNotices;

    public function __construct()
    {
        $this->tabPanels = [];
        $this->statusBarNotices = [];
        $this->tabHeadingLength = 0;
        $this->getPanel();

        $this->manager = new TabsManager($this->window);
    }

    public function onKeyboardEvent(KeyboardEvent $event)
    {
        $this->manager->onKeyboardEvent($event);
    }

    public function beforeRefresh()
    {
        $notices = [];
        foreach($this->statusBarNotices as $notifier) {
            if($notifier instanceof StatusBarMessage) {
                $notices[] = $notifier->getStatusMessage();
            } elseif(is_callable($notifier)) {
                $notices[] = call_user_func($notifier);
            }
        }
        $noticeBar = implode(', ', $notices);
        ncurses_mvwaddstr($this->window, $this->rows-1, 2, str_repeat(' ', $this->cols));
        ncurses_mvwaddstr($this->window, $this->rows-1, 2, $noticeBar);
        $this->manager->draw();
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getPanel()
    {
        if(!$this->panel) {
            $this->panel = ncurses_new_panel($this->getWindow());
        }

        return $this->panel;
    }

    public function getWindow()
    {
        if(!$this->window) {
            $this->window = ncurses_newwin(0, 0, 0, 0);
            ncurses_getmaxyx($this->window, $y, $x);
            $this->rows = $y;
            $this->cols = $x;
        }

        return $this->window;
    }

    public function setWindow(Window $window)
    {
        $this->window = $window->getWindow();
    }

    public function addStatusBarNotifier($notifier)
    {
        $this->statusBarNotices[] = $notifier;
    }
} 