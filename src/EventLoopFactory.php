<?php
/**
 * EventLoopFactory.php
 * @author ciaran
 * @date 11/07/14 23:21
 *
 */

namespace Kurses;


class EventLoopFactory {
    private $hasAlertReactor;

    public function __construct() {
        $this->hasAlertReactor = class_exists('Alert\ReactorFactory');
    }

    public function __invoke() {
        return $this->select();
    }

    /**
     * @return \Kurses\EventLoop
     */
    public function select() {
        if ($this->hasAlertReactor) {
            $reactor = (new \Alert\ReactorFactory())->select();
            $adapter = (new \Kurses\Adapter\AlertAdapter($reactor));
        }

        return $adapter;
    }
} 