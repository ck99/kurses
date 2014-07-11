<?php
/**
 * Screen.php
 * @author ciaran
 * @date 10/07/14 18:47
 *
 */

namespace Kurses;

use Kurses\InputHandler\Keyboard;
use Kurses\InputHandler\Mouse;

class Screen
{
    /** @var array|Panel[]  */
    protected $panels;

    public $cursor;

    /** @var \Kurses\EventLoop  */
    private $loop;

    public function __construct(EventLoop $loop)
    {
        $this->loop = $loop;
        ncurses_init();
        ncurses_cbreak();
        ncurses_noecho();
        $this->panels = [];
        if (ncurses_has_colors()) {
            ncurses_start_color();
        }

        $this->cursor   = new Cursor(null, null, false);


        $this->loop->every([$this, 'refresh'], 200);
        stream_set_blocking(STDIN, FALSE);
        $this->loop->attachStreamHandler(STDIN, [$this, 'handleStdIn']);


    }

    public function handleStdIn()
    {
        $k = ncurses_getch();
        $this->panels[0]->setTitle("KeyPressed: ".$k);
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

    /**
     * @param Panel $panel
     * @param array $panelRatios
     * @return Panel[]
     */
    public function vSplitPanel(Panel $panel, $panelRatios = [1,1])
    {
        $newPanels = $panel->vSplit($panelRatios);
        foreach ($newPanels as $newPanel) {
            $this->addPanel(['panel' => $newPanel]);
        }

        return $newPanels;
    }

    /**
     * @param Panel $panel
     * @param array $panelRatios
     * @return Panel[]
     */
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

    public function replacePanelWithType($panel, $type)
    {
        $i = -1;
        foreach($this->panels as $index => $livePanel) {
            if($livePanel === $panel) {
                $i = $index;
                break;
            }
        }

        $replaceThis = $this->panels[$i];
        $newPanel = new $type($replaceThis->rows, $replaceThis->cols, $replaceThis->y, $replaceThis->x);
        unset($this->panels[$i]);
        $this->panels[] = $newPanel;
        return $newPanel;
    }

    public function __destruct()
    {
        ncurses_end();
    }
}