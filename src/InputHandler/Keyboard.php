<?php
/**
 * Keyboard.php
 * @author ciaran
 * @date 11/07/14 09:23
 *
 */

namespace Kurses\InputHandler;

use Kurses\Event\KeyboardEvent;

class Keyboard {

    private $callback;

    function __construct(callable $eventCallback)
    {
        if(!is_callable($eventCallback)) {
            throw new \Exception("Keyboard handler cannot be constructed without a valid callback");
        }

        $this->callback = $eventCallback;
    }

    public function handle($keystroke)
    {
        if($keystroke == NCURSES_KEY_MOUSE) return; //ignore mouse actions
        call_user_func($this->callback, $this->getKeyboardEvent($keystroke));
    }

    private function getKeyboardEvent($keystroke)
    {
        return new KeyboardEvent($keystroke);
    }
} 