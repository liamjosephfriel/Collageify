<?php
namespace Collageify\Services;

class CollageifyValidationService
{   
    public static function validateTimeSpan($timespan = "short_term")
    {
        $valid_timespans = ['short_term', 'medium_term', 'long_term'];
        
        if (in_array($timespan, $valid_timespans)) {
            return $timespan;
        } else {
            return "short_term";
        }
    }
}