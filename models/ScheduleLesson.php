<?php

    class ScheduleLesson
    {
        public static function getAllLessons($id, $month, $year)
        {
            // Получаем начало и конец месяца
            $startDt = ScheduleMonth::getStartOfMount($month, $year);
            $endDt = ScheduleMonth::getEndOfMount($month, $year);

            // Два запроса - установка переменных для избежания дублирования SELECT
            // в главном запросе
            DbSchedule::dbQuery("SET @minWeek = (SELECT MIN(week_num) FROM " . SCHEDULE_WEEKS_TABLE . " WHERE `week_end` > :startDt AND `week_begin` <= :endDt)", ['startDt' => $startDt, 'endDt' => $endDt]);
            DbSchedule::dbQuery("SET @maxWeek = (SELECT MAX(week_num) FROM " . SCHEDULE_WEEKS_TABLE . " WHERE `week_end` > :startDt AND `week_begin` <= :endDt)", ['startDt' => $startDt, 'endDt' => $endDt]);
            $sql = "
                SELECT @minWeek, @maxWeek, " . SCHEDULE_TABLE . ".*, planes.name_subject, planes.short_subject, teacher.familia, teacher.imya, teacher.otchestvo, room.box, room.nomber_room
                FROM `" . SCHEDULE_TABLE . "`
                JOIN planes ON planes.id_subject = " . SCHEDULE_TABLE . ".subject_id
                JOIN teacher ON teacher.id_teacher = " . SCHEDULE_TABLE . ".teacher_id
                JOIN room ON room.id_room = " . SCHEDULE_TABLE . ".room_id
                WHERE `group_id` = :id AND ((begin >= @minWeek AND begin <= @maxWeek) OR (end >= @minWeek AND end <= @maxWeek) OR (begin <= @minWeek AND end >= @maxWeek))            
                ";

            return DbSchedule::dbQuery($sql, [
                'id' => $id,
                ])->fetchAll();
        }

        // СТРАШНАЯ ФУНКЦИЯ !
        // Обрабатывает данные занятий из базы и переводит их в календарный вид
        public static function processMounthLessons($lessons) 
        {
            $result = [];

            // Берем минимальную неделю месяца из ответа бд
            $minWeek = $lessons[0]['@minWeek'];

            // Берем максимальную неделю месяца из ответа бд
            $maxWeek = $lessons[0]['@maxWeek'];

            // Расчитываем дату (ВС) последней недели месяца
            $endDate = ScheduleWeek::weekEndToDate(ScheduleWeek::getWeeks()[$maxWeek]);

            // Заполняем пустой массив
            // Необходимо заполнить его пустыми значениями прежде чем 
            // перезаписать в него существующие занятия
            $currentDate = ScheduleWeek::weekBeginToDate(ScheduleWeek::getWeeks()[$minWeek]);
            while($currentDate < $endDate) {
                if($currentDate->format('D') != 'Sun')
                    {
                        $currentNumDate = (int) $currentDate->format('d');
                        for($i = 1; $i <= 9; $i++) {
                            $result[$currentNumDate]['classes'][$i] = [
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
           
            

            // Заполняем массив данными
            foreach ( $lessons as $key => $lesson) {
                // Устанавливает текущую дату в начало месяца первой недели месяца (ПН)
                // Необходимо перезаписывать его после каждого завершения цикла while 
                $currentDate = ScheduleWeek::weekBeginToDate(ScheduleWeek::getWeeks()[$minWeek]);
                
                // Берем все возможные даты проведения занятия в текущем месяце
                $dates = ScheduleDates::getDates($minWeek, $maxWeek, $lesson['day'], '***');
                
                // Берем все даты текущего занятия 
                $lessonDates = ScheduleDates::getDates($lesson['begin'], $lesson['end'], $lesson['day'], $lesson['stars']);

                // Пересечение множества всех дат месяца и всех дат занятия
                $intersection = ScheduleDates::intersectDatesInArr($dates, $lessonDates);
                
                // Цикл проходит по всем датам текущего месяца
                while($currentDate < $endDate) {
                    // Если не воскресенье
                    if($currentDate->format('D') != 'Sun')
                    {
                        // Берем число из даты
                        $currentNumDate = (int) $currentDate->format('d');

                        // Это сегодня?
                        $result[$currentNumDate]['isCurrent'] = strcmp((new DateTime('now'))->format('Y-m-d'), $currentDate->format('Y-m-d'));
                        
                        // Название дня недели 
                        $result[$currentNumDate]['day'] = ScheduleWeek::dayToString($currentDate->format('N'));
                        
                        // Если в пересечении дата соответствует текущей 
                        // -> заполнить ее в массив в соответствующий день недели
                        if(in_array($currentDate, $intersection))
                        {
                            $result[$currentNumDate]['classes'][$lesson['lesson']] = [
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
            return $result;
        }
    }