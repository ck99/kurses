<?php
/**
 * Application.php
 * @author ciaran
 * @date 11/07/14 11:09
 *
 */

namespace Kurses;

use Kurses\Event\KeyboardEvent;
use Kurses\Event\MouseEvent;
use Kurses\InputHandler\Keyboard;
use Kurses\InputHandler\Mouse;
use Kurses\UIComponent\Screen;

class Application {
    /** @var Screen  */
    protected $screen;

    public $cursor;

    /** @var EventLoop  */
    private $loop;

    /** @var Keyboard  */
    private $keyboard;

    /** @var Mouse  */
    private $mouse;

    const COL_RED_ON_BLACK    = 1;
    const COL_GREEN_ON_BLACK  = 2;
    const COL_YELLOW_ON_BLACK = 3;
    const COL_BLUE_ON_BLACK   = 4;

    public function __construct(EventLoop $loop = null)
    {
        if($loop === null) {
            $loop = (new \Kurses\EventLoopFactory())->select();
        }
        $this->loop = $loop;
        ncurses_init();
        ncurses_cbreak();
        ncurses_noecho();
        $this->panels = [];
        if (ncurses_has_colors()) {
            ncurses_start_color();
            ncurses_init_pair(self::COL_RED_ON_BLACK, NCURSES_COLOR_RED, NCURSES_COLOR_BLACK);
            ncurses_init_pair(self::COL_GREEN_ON_BLACK, NCURSES_COLOR_GREEN, NCURSES_COLOR_BLACK);
            ncurses_init_pair(self::COL_YELLOW_ON_BLACK, NCURSES_COLOR_YELLOW, NCURSES_COLOR_BLACK);
            ncurses_init_pair(self::COL_BLUE_ON_BLACK, NCURSES_COLOR_BLUE, NCURSES_COLOR_BLACK);
        }

        $this->cursor   = new Cursor(null, null, false);
        $this->screen   = new Screen();

        $onKeyboardEvent = function (KeyboardEvent $keyboardEvent) {
            $this->handleKeyboardEvent($keyboardEvent);
        };

        $onMouseEvent = function (MouseEvent $mouseEvent) {
            $this->handleMouseEvent($mouseEvent);
        };

        $refreshScreen = function () {
            $this->refreshScreen();
        };

        $this->keyboard = new Keyboard($onKeyboardEvent);
        $this->mouse    = new Mouse($onMouseEvent);
        $this->loop->every($refreshScreen, 200);


        stream_set_blocking(STDIN, FALSE);
        $this->loop->attachStreamHandler(STDIN, function(){
                $this->handleStdIn();
            });
    }

    public function getEventLoop()
    {
        return $this->loop;
    }

    /**
     * @return Screen
     */
    public function getScreen()
    {
        return $this->screen;
    }

    private function refreshScreen()
    {
        $this->screen->beforeRefresh();
        ncurses_update_panels();
        ncurses_doupdate();
    }

    private function handleStdIn()
    {
        $k = ncurses_getch();
        $this->keyboard->handle($k);
        $this->mouse->handle($k);
    }

    private function handleKeyboardEvent(KeyboardEvent $keyboardEvent)
    {
        $this->screen->onKeyboardEvent($keyboardEvent);
    }

    private function handleMouseEvent(MouseEvent $mouseEvent)
    {
        echo $mouseEvent;
    }

    public function __destruct()
    {
//        ncurses_end();
    }
} 