<?php
/**
 * Tab.php
 * @author ciaran
 * @date 11/07/14 13:22
 *
 */

namespace Kurses\UIComponent\Tabs;


use Kurses\Event\KeyboardEvent;
use Kurses\Panel;
use Kurses\ScrollingList;

class Tab {
    public $name;

    /** @var  ScrollingList */
    public $panel;


    public function __construct($name)
    {
        $this->name = $name;
//        $this->lines = new ScrollingList();
    }

    public function setPanel(Panel $panel)
    {
        $this->panel = $panel;
    }

    public function draw()
    {
        $this->panel->refresh();
    }

    public function onKeyboardEvent(KeyboardEvent $event)
    {
        $this->panel->addLine("KeyPress: ".$event->keycode);
    }

    public function hasAlert()
    {
        return true;
    }
}