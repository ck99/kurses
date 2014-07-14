<?php
/**
 * UpTime.php
 * @author ciaran
 * @date 14/07/14 06:34
 *
 */

namespace Kurses\UIComponent\StatusBar;


use Kurses\UIComponent\StatusBarMessage;

class UpTime implements StatusBarMessage{

    private $startTime;

    function __construct()
    {
        $this->startTime = time();
    }

    public function getStatusMessage()
    {
        return "T: ". $this->getFormattedTime();
    }

    /**
     * @return string
     */
    private function getFormattedTime()
    {
        return $this->secondsToWords(time() - $this->startTime);
    }

    /**
     *
     * @convert seconds to hours minutes and seconds
     *
     * @param int $seconds The number of seconds
     *
     * @return string
     *
     */
    private function secondsToWords($seconds)
    {
        /*** return value ***/
        $ret = [
            'weeks'   => 0,
            'days'    => 0,
            'hours'   => 0,
            'minutes' => 0,
            'seconds' => 0,
        ];
        
        /*** get the weeks ***/
        $ret['weeks'] = (intval($seconds) / (60*60*24*7));

        /*** get the days ***/
        $ret['days'] = bcmod((intval($seconds) / (60*60*24)), 7);

        /*** get the hours ***/
        $ret['hours'] = bcmod((intval($seconds) / 3600), 60);
        if($ret['hours'] >= 24) {
            $ret['hours'] = bcmod($ret['hours'], 24);
        }

        /*** get the minutes ***/
        $ret['minutes'] = bcmod((intval($seconds) / 60),60);

        /*** get the seconds ***/
        $ret['seconds'] = bcmod(intval($seconds),60);

        $daysString = "";

        if($ret['weeks'] >= 1) {
            $daysString = sprintf("%d week%s ", $ret['weeks'],($ret['weeks'] >= 2)?'s':'');
//            $ret['days'] = bcmod($ret['days'], 7);
        }

        if($ret['days'] > 0) {
            $daysString = sprintf("%s%d day%s ",$daysString, $ret['days'],($ret['days'] > 1)?'s':'');
        }


        return sprintf("%s%02d:%02d:%02d", $daysString, $ret['hours'], $ret['minutes'], $ret['seconds']);
    }

}