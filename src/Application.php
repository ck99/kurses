<?php
/**
 * Application.php
 * @author ciaran
 * @author Fabian 'zetaron' Stegemann
 * @date 31.10.2014 19:31
 *
 */

namespace Kurses;

use Kurses\Event\KeyboardEvent;
use Kurses\Event\MouseEvent;
use Kurses\InputHandler\Keyboard;
use Kurses\InputHandler\Mouse;
use Kurses\UIComponent\Screen;

class Application {
    /**
     * @var Screen
     */
    protected $screen;

    public $cursor;

    /**
     * @var EventLoop
     */
    private $loop;

    /**
     * @var Keyboard
     */
    private $keyboard;

    /**
     * @var Mouse
     */
    private $mouse;

    public function __construct(EventLoop $loop = null)
    {
        if($loop === null) {
            $loop = \Kurses\EventLoopFactory::select();
        }
        $this->loop = $loop;
        ncurses_init();
        ncurses_cbreak();
        ncurses_noecho();
        $this->panels = [];
        if (ncurses_has_colors()) {
            ncurses_start_color();
            ncurses_init_pair(1, NCURSES_COLOR_RED, NCURSES_COLOR_BLACK);
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

    /**
     * @return EventLoop
     */
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
        ncurses_end();
    }
}
