<?php
/**
 * EventLoopFactory.php
 * @author ciaran
 * @author Fabian 'zetaron' Stegemann
 * @date 31.10.2014 19:16
 */

namespace Kurses;

class EventLoopFactory {
    /**
     * @var boolean
     */
    public static function hasAmpReactor() {
      return class_exists('Amp\ReactorFactory');
    }

    /**
     * @return \Kurses\EventLoop
     */
    public static function select() {
        /**
         * @var \Kurses\EventLoop
         */
        $adapter = null;

        if ( self::hasAmpReactor() ) {
          $reactor = \Amp\ReactorFactory::select();
          $adapter = new Adapter\AmpAdapter($reactor);
        }

        return $adapter;
    }
}
