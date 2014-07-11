<?php
/**
 * MouseEvent.php
 * @author ciaran
 * @date 11/07/14 11:23
 *
 */

namespace Kurses\Event;


class MouseEvent {
    public $id;
    public $x;
    public $y;
    public $z;
    public $mmask;

    function __construct($eventDataArray = [])
    {
        $fields = ['id','x','y','z','mmask'];
        foreach($fields as $field) {
            if(array_key_exists($field, $eventDataArray)) {
                $this->{$field} = $eventDataArray[$field];
            }
        }
    }

    function __toString()
    {
        return $this->decodeMouseMask();
    }

    protected $mouseMap = [
        NCURSES_BUTTON1_CLICKED         => 'NCURSES_BUTTON1_CLICKED',
        NCURSES_BUTTON1_RELEASED        => 'NCURSES_BUTTON1_RELEASED',
        NCURSES_BUTTON1_CLICKED         => 'NCURSES_BUTTON1_CLICKED',
        NCURSES_BUTTON1_DOUBLE_CLICKED  => 'NCURSES_BUTTON1_DOUBLE_CLICKED',
        NCURSES_BUTTON1_TRIPLE_CLICKED  => 'NCURSES_BUTTON1_TRIPLE_CLICKED',
        NCURSES_BUTTON2_PRESSED         => 'NCURSES_BUTTON2_PRESSED',
        NCURSES_BUTTON2_RELEASED        => 'NCURSES_BUTTON2_RELEASED',
        NCURSES_BUTTON2_CLICKED         => 'NCURSES_BUTTON2_CLICKED',
        NCURSES_BUTTON2_DOUBLE_CLICKED  => 'NCURSES_BUTTON2_DOUBLE_CLICKED',
        NCURSES_BUTTON2_TRIPLE_CLICKED  => 'NCURSES_BUTTON2_TRIPLE_CLICKED',
        NCURSES_BUTTON3_PRESSED         => 'NCURSES_BUTTON3_PRESSED',
        NCURSES_BUTTON3_RELEASED        => 'NCURSES_BUTTON3_RELEASED',
        NCURSES_BUTTON3_CLICKED         => 'NCURSES_BUTTON3_CLICKED',
        NCURSES_BUTTON3_DOUBLE_CLICKED  => 'NCURSES_BUTTON3_DOUBLE_CLICKED',
        NCURSES_BUTTON3_TRIPLE_CLICKED  => 'NCURSES_BUTTON3_TRIPLE_CLICKED',
        NCURSES_BUTTON4_PRESSED         => 'NCURSES_BUTTON4_PRESSED',
        NCURSES_BUTTON4_RELEASED        => 'NCURSES_BUTTON4_RELEASED',
        NCURSES_BUTTON4_CLICKED         => 'NCURSES_BUTTON4_CLICKED',
        NCURSES_BUTTON4_DOUBLE_CLICKED  => 'NCURSES_BUTTON4_DOUBLE_CLICKED',
        NCURSES_BUTTON4_TRIPLE_CLICKED  => 'NCURSES_BUTTON4_TRIPLE_CLICKED',
        NCURSES_BUTTON_SHIFT            => 'NCURSES_BUTTON_SHIFT',
        NCURSES_BUTTON_CTRL             => 'NCURSES_BUTTON_CTRL',
        NCURSES_BUTTON_ALT              => 'NCURSES_BUTTON_ALT',
    ];

    protected function decodeMouseMask()
    {
        $decoded = "unknown";
        if(array_key_exists($this->mmask, $this->mouseMap)) {
            $decoded = $this->mouseMap[$this->mmask];
        }

        return $decoded;
    }
} 