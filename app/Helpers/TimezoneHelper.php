<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimezoneHelper
{
    /**
     * Get current time in WIB timezone
     */
    public static function now()
    {
        return Carbon::now('Asia/Jakarta');
    }

    /**
     * Format date to Indonesian format
     */
    public static function formatIndonesian($date, $format = 'd F Y H:i')
    {
        return Carbon::parse($date)
            ->setTimezone('Asia/Jakarta')
            ->locale('id')
            ->format($format);
    }

    /**
     * Get relative time in Indonesian
     */
    public static function diffForHumans($date)
    {
        return Carbon::parse($date)
            ->setTimezone('Asia/Jakarta')
            ->locale('id')
            ->diffForHumans();
    }

    /**
     * Format date for display in dashboard
     */
    public static function formatForDashboard($date)
    {
        return Carbon::parse($date)
            ->setTimezone('Asia/Jakarta')
            ->locale('id')
            ->format('d M Y, H:i') . ' WIB';
    }
}
