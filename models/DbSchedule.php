<?php

    class DbSchedule 
    {
        protected static $dbConnection = null;

        // Синглтон - единое соединение с базой данных
        // Испрользовать этот метод чтобы пролучить соединение DbSchedule::instance()
        public static function instance() : PDO
        {
            if (self::$dbConnection === null)
            {
                self::$dbConnection = new PDO('mysql:host=' . SCHEDULE_DB_HOST . ';dbname=' . SCHEDULE_DB_NAME, SCHEDULE_DB_USER, SCHEDULE_DB_PASS, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                self::$dbConnection->exec('SET NAMES UTF8');
            }
            return self::$dbConnection;
        }

        // Подставляет переменные в запрос, выполняет его, и возвращает ответ от бд
        public static function dbQuery(string $sql, array $params = []) : PDOStatement
        {
            $db = self::instance();
            $query = $db->prepare($sql);
            $query->execute($params);
            self::dbCheckError($query);
            return $query;
        }
    
        // Если ошибка - прервать выполнение
        protected static function dbCheckError(PDOStatement $query) : bool
        {
            $errInfo = $query->errorInfo();
            if($errInfo[0] !== PDO::ERR_NONE){
                // TODO Throw exception
                echo $errInfo[2];
                exit();
            }
            return true;
        }
    }