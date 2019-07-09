<?php
declare(strict_types=1);

if (!function_exists('getDanishMonthNameByMonthNo')) {
    /**
     * Get danish month name by month no.
     *
     * @param  int  $monthNo
     * @param  bool $short
     * @return string|null
     */
    function getDanishMonthNameByMonthNo(int $monthNo, $short = false): ?string
    {
        switch ($monthNo) {
            case 1:
                return $short ? 'jan' : 'januar';
                break;
            case 2:
                return $short ? 'feb' : 'februar';
                break;
            case 3:
                return $short ? 'mar' : 'marts';
                break;
            case 4:
                return $short ? 'apr' : 'april';
                break;
            case 5:
                return 'maj';
                break;
            case 6:
                return $short ? 'jun' : 'juni';
                break;
            case 7:
                return $short ? 'jul' : 'juli';
                break;
            case 8:
                return $short ? 'aug' : 'august';
                break;
            case 9:
                return $short ? 'sep' : 'september';
                break;
            case 10:
                return $short ? 'okt' : 'oktober';
                break;
            case 11:
                return $short ? 'nov' : 'november';
                break;
            case 12:
                return $short ? 'dec' : 'december';
                break;
            default:
                return null;
        }
    }
}