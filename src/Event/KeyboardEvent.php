<?php
/**
 * KeyboardEvent.php
 * @author ciaran
 * @date 11/07/14 11:26
 *
 */

namespace Kurses\Event;


class KeyboardEvent {

    public $keycode;

    function __construct($keycode)
    {
        $this->keycode = $keycode;
    }
}