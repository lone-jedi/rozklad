<?php

    class ScheduleWeek 
    {
        // Прим.: $weeks['week_end'] указыкает на ВС
        protected static array $weeks = [];

        public static function getWeekFromDate($date) {
            foreach(self::$weeks as $weekNum => $week) {
                if(new DateTime($week['week_begin']) <= $date && new DateTime($week['week_end']) > $date)
                {
                    return $weekNum;
                }
            }
        }

        public static function getWeeks() 
        {
            return self::$weeks;
        }

        public static function setAllWeeks() 
        {
            $sql = "SELECT * FROM `" . SCHEDULE_WEEKS_TABLE . "`";
            self::$weeks = self::processWeeks(DbSchedule::dbQuery($sql)->fetchAll());
        }

        public static function processWeeks($weeks) 
        {
            $result = [];

            foreach ($weeks as $key => $week) {
                $result[$week['week_num']] = [
                    'week_begin' => $week['week_begin'],
                    'week_end' => $week['week_end'],
                ];
            }

            return $result;
        }

        // Day: 1-ПН, 2-ВТ, 3-СР, 4-ЧТ, 5-ПТ, 6-СБ. ВС - недопустимо
        public static function addDayToWeek($week, $day) {
            return self::weekBeginToDate($week)->add(new DateInterval('P' . ($day-1) .'D'));
        }

        public static function weekBeginToDate($week) {
            return new DateTime($week['week_begin']);
        }

        public static function weekEndToDate($week) {
            return new DateTime($week['week_end']);
        }

        public static function dayToString($day) {
            $days = [1 => 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
            return $days[$day] ?? 0;
        }
    }