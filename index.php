<?php
    
    // Matrix has you
    // Точка входа
    
    require_once 'init.php';
    
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if(isset($_GET['id'])) {
            
            $scheduleCalendar = ScheduleCalendar::get($_GET['id'], $_GET['month'] ?? '', $_GET['year'] ?? '');
        }
        else {
            $scheduleCalendar = ScheduleCore::template('template', [
                'main' => ScheduleCore::template('404'),
            ]);
        }
        echo $scheduleCalendar;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if(isset($_POST['idGroup']) && isset($_POST['week'])) 
        {
            echo json_encode(ScheduleCalendar::getZoomInfo($_POST['idGroup'], $_POST['week']));
        }
    }
