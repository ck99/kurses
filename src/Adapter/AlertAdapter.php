<?php
/**
 * AlertAdapter.php
 * @author ciaran
 * @date 11/07/14 07:51
 *
 */

namespace Kurses\Adapter;

use Alert\Reactor;
use Kurses\EventLoop;

class AlertAdapter implements EventLoop {

    protected $loop;
    public function __construct(Reactor $loop)
    {
        $this->loop = $loop;
    }

    public function every(callable $callback, $delay)
    {
        $this->loop->repeat($callback, $delay);
    }

    public function attachStreamHandler($stream, callable $callback)
    {
        $this->loop->onReadable($stream, $callback);
    }

    public function start()
    {
        $this->loop->run();
    }
} 