<?php

    class ScheduleCalendar 
    {
        // Output -> HTML Page
        public static function get($idGroup, $month, $year) 
        {
            // Текущий месяц
            if($month == '') {
                $month = date('m');
            }
            
            // Текущий год
            if($year == '') {
                $year = date('Y');
            }
            
            // Не прошел проверку -> вернуть HTML 404 ошибки
            if(!is_numeric($idGroup)) {
                return ScheduleCore::template('template', [
                    'main' => ScheduleCore::template('404'),
                ]);
            }
            
            if(!ScheduleMonth::checkMonth($month)) {
                return ScheduleCore::template('template', [
                    'main' => ScheduleCore::template('404'),
                ]);
            }
            
            
            if(!ScheduleYear::checkYear($year, $month)) {
                return ScheduleCore::template('template', [
                    'main' => ScheduleCore::template('404'),
                ]);
            }

            
            // Получить недели из базы в массив ScheduleWeek::$weeks
            // Необходимо прописать перед вызовом ScheduleFunctions::processMounthLessons()
            ScheduleWeek::setAllWeeks();

            // Получить занятия из базы в массив с той же схемой
            $allMonthLessons = ScheduleLesson::getAllLessons($idGroup, $month, $year);
            
            if($allMonthLessons)
            {
                // Если есть занятия -> обработать их в календарный вид
                // Возвращает массив со всеми занятиями месяца отсортированными по дням
                $allMonthLessons = ScheduleLesson::processMounthLessons($allMonthLessons);
            }
            else {
                $allMonthLessons = ScheduleLesson::getEmptyCalendar();
            }

            // Берет все месяцы текущего семестра
            $semestrMonth = ScheduleMonth::getSemestrMonth();
            // Для распечатки в меню
            $allMonth = [];
            // Заполняет массим с месяцами для меню календаря
            foreach(ScheduleMonth::getAllMonth() as $num => $oneMonth) {
                if(in_array($num, $semestrMonth)) {
                    $allMonth[$num]['year'] = SEMESTR == 1 && $oneMonth != 1 && $num == 1 ? (int)date('Y') + 1 : date('Y');
                    $allMonth[$num]['name'] = $oneMonth;
                }
            }

            // Возвращает HTML шаблон со всеми подставленними данными
            return ScheduleCore::template('template', [
                'main' => ScheduleCore::template('CalendarView', [
                        'lessons' => $allMonthLessons,
                        'idGroup' => ScheduleGroup::get($idGroup),
                        'month'   => $allMonth,
                        'activeMonth' => $month,
                    ]),
                ]);
        }

        // Возвращает Zoom и другую информацию из таблицы online
        // Output -> array
        public static function getZoomInfo($idLesson, $week) {
            $response = [];

            if($idLesson == null || $week == null || !is_numeric($idLesson) || !is_numeric($week))
            {
                return ['error' => "Data [idLesson:$idLesson week:$week] processing error"];
            }

            // Берет информацию из таблицы online
            $onlineInfo = ScheduleZoom::getOnlineInfo((int) $idLesson, (int) $week);

            if($onlineInfo)
            {
                // Вытаскивает из строки $onlineInfo['code'] ZOOM информацию и возвращает массив
                // $zoomInfo = ScheduleZoom::parseZoomInfo($onlineInfo['code']);
                // if($zoomInfo)
                // {
                //     $response['zoomInfo'] = $zoomInfo;
                // }

                $response['onlineInfo'] = $onlineInfo['code'];
            }
            else {
                return ['error' => "Онлайн ідентифікаторів не знайдено"];
            }

            
            $response['error']      = '';

            return $response;
        }
    }