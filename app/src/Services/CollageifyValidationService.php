<?php
namespace Collageify\Services;

class CollageifyValidationService
{
    /**
     * Validate the timespan string
     *
     * Valid timespans are:
     *  - short_term
     *  - medium_term
     *  - long_term
     *
     * @param  string $timespan
     * @return string
     */
    public static function validateTimeSpan($timespan = "short_term")
    {
        $valid_timespans = ['short_term', 'medium_term', 'long_term'];

        if (in_array($timespan, $valid_timespans)) {
            return $timespan;
        } else {
            return "short_term";
        }
    }

     /**
     * Validate and return the correct value for the collage size
     *
     * Valid timespans are:
     *  - 3x3 (9)
     *  - 4x4 (16)
     *  - 5x5 (25)
     *
     * @param  string $collage_size
     * @return int
     */
    public static function validateCollageSize($collage_size = "3x3")
    {
        $valid_sizes = ['3x3' => 9, '4x4' => 16, '5x5' => 25];

        if (array_key_exists($collage_size, $valid_sizes)) {
            return $valid_sizes[$collage_size];
        } else {
            return 9;
        }
    }
}
