<?php
/**
 * Mouse.php
 * @author ciaran
 * @date 11/07/14 09:28
 *
 */

namespace Kurses\InputHandler;


use Kurses\Event\MouseEvent;

class Mouse
{
    private $callback;

    function __construct(callable $eventCallback)
    {
        ncurses_mousemask(NCURSES_ALL_MOUSE_EVENTS, $oldMask);
        if(!is_callable($eventCallback)) {
            throw new \Exception("Mouse handler cannot be constructed without a valid callback");
        }

        $this->callback = $eventCallback;
    }

    public function handle($keystroke)
    {
        if($keystroke !== NCURSES_KEY_MOUSE) return;
        call_user_func($this->callback, $this->getMouseEvent());
    }

    private function getMouseEvent()
    {
        ncurses_getmouse($mevent);
        return new MouseEvent($mevent);
    }
} 