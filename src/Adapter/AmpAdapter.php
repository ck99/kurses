<?php
/**
 * AmpAdapter.php
 * @author Fabian 'zetaron' Stegemann
 * @date 31.10.2014 18:49
 */

namespace Kurses\Adapter;

use Amp\Reactor;
use Kurses\EventLoop;

class AmpAdapter implements EventLoop {

    protected $loop;

    public function __construct(Reactor $loop) {
        $this->loop = $loop;
    }

    public function every(callable $callback, $delay) {
        $this->loop->repeat($callback, $delay);
    }

    public function attachStreamHandler($stream, callable $callback) {
        $this->loop->onReadable($stream, $callback);
    }

    public function start() {
        $this->loop->run();
    }
}
