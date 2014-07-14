<?php
/**
 * MemoryUsage.php
 * @author ciaran
 * @date 14/07/14 06:33
 *
 */

namespace Kurses\UIComponent\StatusBar;

use Kurses\UIComponent\StatusBarMessage;

class MemoryUsage implements StatusBarMessage{
    public function getStatusMessage()
    {
        return sprintf('M:%s', $this->getFormattedMemoryUsage());
    }

    /**
     * @return int
     */
    private function getFormattedMemoryUsage()
    {
        $usageNum = memory_get_usage();
        $order = 0;
        while(($usageNum / pow(1024,$order)) > 1024) {
            $order++;
        }
        $units = ['b','Kb','Mb','Gb','Tb','Pb'];
        return sprintf("%.2f %s", ($usageNum / (pow(1024, $order))), $units[$order]);
    }
} 