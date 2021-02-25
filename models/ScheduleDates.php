<?php

    class ScheduleDates
    {
        // Возвращает множество дат(массив)
        public static function getDates($beginWeek, $endWeek, $day, $stars = '***') 
        {
            $dates       = [];
            $beginDate   = ScheduleWeek::addDayToWeek(ScheduleWeek::getWeeks()[$beginWeek], $day);
            $currentDate = $beginDate;
            $endDate     = ScheduleWeek::weekEndToDate(ScheduleWeek::getWeeks()[$endWeek]);
            
            $k = $stars === '***' ? 1 : 2;

            for($i = 0; $currentDate < $endDate; $i+=$k)
            {
                $dates[] = $currentDate;
                if(!isset(ScheduleWeek::getWeeks()[$beginWeek + $i]))
                {
                    break;   
                }
                $currentDate = ScheduleWeek::addDayToWeek(ScheduleWeek::getWeeks()[$beginWeek + $i], $day);
            }
            return $dates;
        }
        
        // Возвращает массив пересечения двух массивов дат
        public static function intersectDatesInArr($arr1, $arr2) {
            $result = [];
            foreach($arr1 as $k1 => $v1)
            {
                foreach($arr2 as $k2 => $v2)
                {
                    if($v1 == $v2)
                    {
                        $result[] = $v1;
                    }
                }
            }
            return $result;
        }
    }