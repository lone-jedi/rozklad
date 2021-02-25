<?php

    // Переменные и константы для конфигурации 

    define('SCHEDULE_DB_NAME', 'rozklad');
    define('SCHEDULE_DB_USER', 'root');
    define('SCHEDULE_DB_PASS', '');
    define('SCHEDULE_DB_HOST', 'localhost');

    define('SCHEDULE_HOST', 'http://localhost/learning/rozklad/index.php');

    // Определяет какой сейчас семестр
    define('SEMESTR', (int) date('m') > 7 ? '1' : '2');

    // Осторожно! Константы для смены таблиц
    // Содержимое констант вставляется конкатенацией и не экранируется!
    define('SCHEDULE_TABLE', 'tt_2020_2021_1');
    define('SCHEDULE_WEEKS_TABLE', 'weeks_2020_2021_1');
    define('SCHEDULE_ONLINE_TABLE', 'online_2020_2021_2');
    define('SCHEDULE_GROUPS_TABLE', 'grp_2020_2021_1');