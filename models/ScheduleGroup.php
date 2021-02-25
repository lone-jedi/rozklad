<?php

    class ScheduleGroup
    {
        public static function get($idGroup)
        {
            $sql = "SELECT * FROM `" . SCHEDULE_GROUPS_TABLE . "` WHERE id_groups=:id";
            return DbSchedule::dbQuery($sql, ['id' => $idGroup])->fetch();
        }
    }