<?php

    class ScheduleCore
    {
        // Return html code from file, insert all variables from $vars
        public static function template(string $path, array $vars = []) : string{
            // Длинное название, чтобы не пересекалась с переменными view
            $systemTemplateRenererIntoFullPath = "views/$path.php"; 

            // Извлекает переменные 
            extract($vars);

            // Открывает запись в буфер
            ob_start();

            // Записывает результат includeв буфер
            include($systemTemplateRenererIntoFullPath);

            // Очищает буфер и возвращает содержимое в виде строки
            return ob_get_clean();
        }

        // Just debug function... 
        public static function debug($data)
        {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        
    }