<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Phnom_Penh');

    }
    public static function convert($date, $format = 'Y-m-d')
    {
        if ($date) {
            $date = str_replace('/', '-', $date);
            $dt = new Carbon($date);
            $date = $dt->translatedFormat($format);
        }
        return $date;
    }

    public static function daysOfMonth($year = null, $month = null)
    {
        if (!$year) {
            $year = Carbon::now()->year;
        }
        if (!$month) {
            $month = Carbon::now()->month;
        }

        $date = Carbon::createFromDate($year, $month);
        return ($date->daysInMonth);
    }



    public static  function weekOfMonth($year = null, $month = null)
    {

        if (!$year) {
            $year = Carbon::now()->year;
        }
        if (!$month) {
            $month = Carbon::now()->month;
        }

        $date = Carbon::createFromDate($year, $month);
        $numberOfWeeks = floor($date->daysInMonth / Carbon::DAYS_PER_WEEK);
        $result = [];
        $j = 1;
        for ($i = 1; $i <= $date->daysInMonth; $i++) {
            $result[] =  array(
                'start' => Carbon::createFromDate($year, $month, $i)->startOfWeek()->format('d'),
                'end' => Carbon::createFromDate($year, $month, $i)->endOfweek()->format('d'),
            );
            $i += 7;
            $j++;
        }

        return $result;
    }

    public static  function dayOfWeek($date = null)
    {
        if($date == null){
            $date = date('Y-m-d');
        }

        $c = new Carbon($date);
        return array(
            'date' => $c->day,
            'day' => $c->englishDayOfWeek,
        );
    }

    public static  function dateOfMonth($year = null, $month = null , $date = null)
    {
        if ($year == null) {
            $year = Carbon::now()->year;
        }
        if ($month == null) {
            $month = Carbon::now()->month;
        }
        $dt = Carbon::createFromDate($year, $month);
        $result = [];
        for ($i = 1; $i <= $dt->daysInMonth; $i++) {

            if (Carbon::createFromDate($year, $month, $i)->is($date)) {
                $result[$i] = array(
                    'id' => null,
                    'day' => Translator::day($date),
                    'date' => $i,
                    'description' => Translator::day($date)
                );
            }
        }
        return $result;
    }

    public static function getDate($date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        return new Carbon($date);
    }
}
