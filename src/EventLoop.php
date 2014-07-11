<?php
/**
 * EventLoop.php
 * @author ciaran
 * @date 11/07/14 07:50
 *
 */

namespace Kurses;


interface EventLoop {
    public function every(callable $callback, $delay);
    public function attachStreamHandler($stream, callable $callback);
    public function start();
} 