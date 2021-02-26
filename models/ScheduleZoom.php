<?php

    class ScheduleZoom
    {
        public static function getOnlineInfo($idLesson, $week) 
        {
            $sql = "SELECT `code` FROM `" . SCHEDULE_ONLINE_TABLE . "` WHERE `id_item` = :id AND `week` = :week";
            return DbSchedule::dbQuery($sql, [
                'id' => $idLesson,
                'week' => $week,
                ])->fetch();
        }

        // TODO Закончить функцию парсинга
        public static function parseZoomInfo(string $zoomInfo) 
        {
            // 000 000 0000

            // https://us02web.zoom.us/j/89872806673?pwd=QkZlRVA0YkI5ckNGdTBGSm5lS25JQT09

            // SecurityКод доступа 9n95Au

            $result  = [];
            $infoArr = [];
            // $zoomArrInfo = explode(' ', $zoomInfo);

            preg_match('/\d{3}\s\d{3}\s\d{4}/', $zoomInfo, $infoArr['zoom_id'], PREG_OFFSET_CAPTURE);
            if($infoArr['zoom_id']) {
                $result['zoom_id'] = $infoArr['zoom_id'][0][0];
            }
            
            preg_match('/SecurityКод\sдоступа\s(.*)/', $zoomInfo, $infoArr['zoom_pass'], PREG_OFFSET_CAPTURE);
            if($infoArr['zoom_pass']) {
                $infoArr['zoom_pass'][0][0] =  preg_replace("/\s{2,}/",' ', $infoArr['zoom_pass'][0][0]);
                $zoomPassArr = explode(' ', trim($infoArr['zoom_pass'][0][0]));
                $result['zoom_pass'] = $zoomPassArr[array_search('доступа', $zoomPassArr) + 1];
            }

            preg_match('/https:(.*)/', $zoomInfo, $infoArr['zoom_link'], PREG_OFFSET_CAPTURE);
            if($infoArr['zoom_link']) {
                $result['zoom_link'] = str_replace('\/', '/', $infoArr['zoom_link'][0][0]);
            }

            return $result;
        }
    }