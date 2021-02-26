<?php

    class ScheduleLesson
    {
        protected static $minWeek;
        protected static $maxWeek;

        public static function getAllLessons($id, $month, $year)
        {
            // Получаем начало и конец месяца
            $startDt = ScheduleMonth::getStartOfMount($month, $year);
            $endDt = ScheduleMonth::getEndOfMount($month, $year);

            // Два запроса - установка переменных для избежания дублирования SELECT 8 раз
            // в главном запросе

            // Берем минимальную неделю месяца из ответа бд
            self::$minWeek = DbSchedule::dbQuery("SELECT MIN(week_num) FROM " . SCHEDULE_WEEKS_TABLE . " WHERE `week_end` > :startDt AND `week_begin` <= :endDt", ['startDt' => $startDt, 'endDt' => $endDt])->fetch()['MIN(week_num)'];
            // Берем максимальную неделю месяца из ответа бд
            self::$maxWeek = DbSchedule::dbQuery("SELECT MAX(week_num) FROM " . SCHEDULE_WEEKS_TABLE . " WHERE `week_end` > :startDt AND `week_begin` <= :endDt", ['startDt' => $startDt, 'endDt' => $endDt])->fetch()['MAX(week_num)'];

            $sql = "
                SELECT " . SCHEDULE_TABLE . ".*, planes.name_subject, planes.short_subject, teacher.familia, teacher.imya, teacher.otchestvo, room.box, room.nomber_room
                FROM `" . SCHEDULE_TABLE . "`
                JOIN planes ON planes.id_subject = " . SCHEDULE_TABLE . ".subject_id
                JOIN teacher ON teacher.id_teacher = " . SCHEDULE_TABLE . ".teacher_id
                JOIN room ON room.id_room = " . SCHEDULE_TABLE . ".room_id
                WHERE `group_id` = :id AND ((begin >= :minWeek AND begin <= :maxWeek) OR (end >= :minWeek AND end <= :maxWeek) OR (begin <= :minWeek AND end >= :maxWeek))            
                ";

            return DbSchedule::dbQuery($sql, [
                'id'      => $id,
                'minWeek' => self::$minWeek,
                'maxWeek' => self::$maxWeek,
                ])->fetchAll();
        }

        // СТРАШНАЯ ФУНКЦИЯ !
        // Обрабатывает данные занятий из базы и переводит их в календарный вид
        public static function processMounthLessons($lessons) 
        {
            // Расчитываем дату (ВС) последней недели месяца
            $endDate = ScheduleWeek::weekEndToDate(ScheduleWeek::getWeeks()[self::$maxWeek]);

            $calendar = self::getEmptyCalendar();

            // Заполняем массив данными
            foreach ( $lessons as $key => $lesson) {
                // Устанавливает текущую дату в начало месяца первой недели месяца (ПН)
                // Необходимо перезаписывать его после каждого завершения цикла while 
                $currentDate = ScheduleWeek::weekBeginToDate(ScheduleWeek::getWeeks()[self::$minWeek]);
                
                // Берем все возможные даты проведения занятия в текущем месяце
                $dates = ScheduleDates::getDates(self::$minWeek, self::$maxWeek, $lesson['day'], '***');
                
                // Берем все даты текущего занятия 
                $lessonDates = ScheduleDates::getDates($lesson['begin'], $lesson['end'], $lesson['day'], $lesson['stars']);

                // Пересечение множества всех дат месяца и всех дат занятия
                $intersection = ScheduleDates::intersectDatesInArr($dates, $lessonDates);
                
                // Цикл проходит по всем датам текущего месяца
                while($currentDate <= $endDate) {
                    // Если не воскресенье
                    if($currentDate->format('D') != 'Sun')
                    {
                        // Переводим дату в строку
                        $currentStrDate = $currentDate->format('Y-m-d');

                        // Это сегодня?
                        $calendar[$currentStrDate]['isCurrent'] = strcmp((new DateTime('now'))->format('Y-m-d'), $currentDate->format('Y-m-d'));
                        
                        // Название дня недели 
                        $calendar[$currentStrDate]['day'] = ScheduleWeek::dayToString($currentDate->format('N'));
                        
                        // Если в пересечении дата соответствует текущей 
                        // -> заполнить ее в массив в соответствующий день недели
                        if(in_array($currentDate, $intersection))
                        {
                            $calendar[$currentStrDate]['classes'][$lesson['lesson']] = [
                                'id_item'       => $lesson['id_item'],
                                // Номер текущей недели
                                'week'          => ScheduleWeek::getWeekFromDate($currentDate),
                                // Тип занятий
                                'type'          => ScheduleTasktype::getTaskTypes()[$lesson['tasktype']] ?? '',
                                // Предмет
                                'name_subject'  => $lesson['name_subject'],
                                'short_subject' => $lesson['short_subject'],
                                // Преподователь
                                'familia'       => $lesson['familia'],
                                'imya'          => $lesson['imya'],
                                'otchestvo'     => $lesson['otchestvo'],
                                'short_teacher' => $lesson['familia'] . ' ' . mb_substr($lesson['imya'], 0, 1) . '. ' . mb_substr($lesson['otchestvo'], 0, 1) . '. ',
                                // Аудитория
                                'box'           => $lesson['box'],
                                'nomber_room'   => $lesson['nomber_room'],
                                'address'       => $lesson['box'] . '-' . $lesson['nomber_room'],
                            ];
                        }
                    }
                    // Счетчик цикла - увеличивает день на +1
                    $currentDate->add(new DateInterval('P1D'));
                }
            }
            return $calendar;
        }

        // Возвращает пустой каркас массива с пустым рассписанием на текущий месяц
        // Необходимо заполнить его пустыми значениями прежде чем 
        // перезаписать в него существующие занятия
        public static function getEmptyCalendar()
        {
            $calendar = [];

            $currentDate = ScheduleWeek::weekBeginToDate(ScheduleWeek::getWeeks()[self::$minWeek]);
            
            // Расчитываем дату (ВС) последней недели месяца
            $endDate = ScheduleWeek::weekEndToDate(ScheduleWeek::getWeeks()[self::$maxWeek]);

            while($currentDate <= $endDate) { 
                if($currentDate->format('D') != 'Sun')
                    {
                        // Переводим дату в строку
                        $currentStrDate = $currentDate->format('Y-m-d');

                        // Это сегодня?
                        $calendar[$currentStrDate]['isCurrent'] = strcmp((new DateTime('now'))->format('Y-m-d'), $currentDate->format('Y-m-d'));
                        
                        // Название дня недели 
                        $calendar[$currentStrDate]['day'] = ScheduleWeek::dayToString($currentDate->format('N'));

                        for($i = 1; $i <= 9; $i++) {
                            $calendar[$currentStrDate]['classes'][$i] = [
                                'id_item'       => '',
                                'week'          => '',
                                'name_subject'  => '',
                                'short_subject' => '',
                                'familia'       => '',
                                'imya'          => '',
                                'otchestvo'     => '',
                                'box'           => '',
                                'nomber_room'   => '',
                                'short_teacher' => '',
                            ];
                        }
                    }
                // Счетчик цикла - увеличивает день на +1
                $currentDate->add(new DateInterval('P1D'));
            }

            return $calendar;
        }
    }