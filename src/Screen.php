<?php
/**
 * Screen.php
 * @author ciaran
 * @date 10/07/14 18:47
 *
 */

namespace Kurses;

class Screen
{
    /** @var array|Panel[]  */
    protected $panels;

    public $cursor;

    public function __construct()
    {
        ncurses_init();
        ncurses_cbreak();
        ncurses_noecho();
        $this->panels = [];
        if (ncurses_has_colors()) {
            ncurses_start_color();
        }

        $this->cursor = new Cursor(null, null, false);
    }

    public function addPanel($options = [])
    {
        $defaultOptions = [
            'rows'  => 0,
            'cols'  => 0,
            'x'     => 0,
            'y'     => 0,
            'title' => '',
            'border' => true,
            'panel' => null,
        ];

        $options = array_merge($defaultOptions, $options);

        if(isset($options['panel'])) {
            $panel = $options['panel'];
        } else {
            $panel = new Panel($options['rows'], $options['cols'], $options['y'], $options['x']);
        }

        if(isset($options['border']) && $options['border']) {
            $panel->border();
        }

        if(isset($options['title']) && strlen($options['title']) > 0) {
            $panel->setTitle(' '.$options['title'].' ');
        }

        $this->panels[] = $panel;
        return $panel;
    }

    public function vSplitPanel(Panel $panel, $panelRatios = [1,1])
    {
        $newPanels = $panel->vSplit($panelRatios);
        foreach ($newPanels as $newPanel) {
            $this->addPanel(['panel' => $newPanel]);
        }

        return $newPanels;
    }

    public function hSplitPanel(Panel $panel, $panelRatios = [1,1])
    {
        $newPanels = $panel->hSplit($panelRatios);
        foreach ($newPanels as $newPanel) {
            $this->addPanel(['panel' => $newPanel]);
        }

        return $newPanels;
    }

    public function getPanel($name)
    {
        return $this->panels[$name];
    }

    public function refresh()
    {
        foreach($this->panels as $panel) {
            $panel->refresh();
        }
        ncurses_update_panels();
        ncurses_doupdate();
    }

    public function __destruct()
    {
        ncurses_end();
    }
}