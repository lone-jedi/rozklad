<?php

    class ScheduleMonth
    {
        protected static $allMonth = [
            1 => ['january' => 'Січень'],
            2 => ['februar' => 'Лютий'],
            3 => ['march' => 'Березень'],
            4 => ['april' => 'Квітень'],
            5 => ['may' => 'Травень'],
            6 => ['june' => 'Червень'],
            7 => ['july' => 'Липень'],
            8 => ['august' => 'Серпень'],
            9 => ['september' => 'Вересень'],
            10 => [ 'october' => 'Жовтень'],
            11 => ['november' => 'Листопад'],
            12 => ['december' => 'Грудень'],
        ];

        public static function getAllMonth()
        {
            return self::$allMonth;
        }

        public static function getStartOfMount($month, $year)
        {
            return "$year-$month-01";
        }

        public static function getEndOfMount($month, $year)
        {
            $date = new DateTime(self::getStartOfMount($month, $year));
            $date->modify('last day of this month');
            return $date->format('Y-m-d');
        }

        public static function checkMonth($month)
        {
            if(is_numeric($month)){
                
                return in_array($month, self::getSemestrMonth());
            }
            return false;
        } 

        public static function getSemestrMonth()
        {
            if(SEMESTR == 2)
            {
                return [2, 3, 4, 5, 6, 7];
            }
            else {
                return [8, 9, 10, 11, 12, 1];
            }
        }
    }