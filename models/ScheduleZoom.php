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

        public static function parseZoomInfo(string $zoomInfo) 
        {
            // 000 000 0000

            // https://us02web.zoom.us/j/89872806673?pwd=QkZlRVA0YkI5ckNGdTBGSm5lS25JQT09

            // SecurityКод доступа 9n95Au

            $result = [];
            // $zoomArrInfo = explode(' ', $zoomInfo);

            preg_match('/\d{3}\s\d{3}\s\d{4}/', $zoomInfo, $result['zoom_id'], PREG_OFFSET_CAPTURE);
            $result['zoom_id'] = $result['zoom_id'][0][0];
            
            preg_match('/https:(.*)/', $zoomInfo, $result['zoom_link'], PREG_OFFSET_CAPTURE);
            $result['zoom_link'] = str_replace('\/', '/', $result['zoom_link'][0][0]);

            return $result;
        }
    }