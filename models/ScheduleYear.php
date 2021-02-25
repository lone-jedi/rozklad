<?php

    class ScheduleYear
    {
        public static function checkYear($year, $month)
        {
            if(is_numeric($year))
            {
                if(SEMESTR == 2)
                {
                    if($year == date('Y'))
                    {
                        return true;
                    }
                }
                else {
                    if($year == date('Y'))
                    {
                        return true;
                    }
                    else if($year == (int)date('Y') - 1 && $month == 1)
                    {
                        return true;
                    }
                }
            }

            return false;
        } 
    }