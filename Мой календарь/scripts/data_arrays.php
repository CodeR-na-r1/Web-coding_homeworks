<?php

include_once 'Database.php';

$types = Database::exec("SELECT * FROM `types`");

$durations =  Database::exec("SELECT * FROM `durations`");
    
$statuses =  Database::exec("SELECT * FROM `statuses`");

$data_relevance = false;

$data = null;

$message = null;

$now_editing_task_id = -1;
$now_editing_task_status = null;

// Коллекции с данными для фильтров

$status_filter = array(
    'nothing' => 'Все задачи',
    'now' => 'Текущие задачи',
    'over' => 'Просроченные задачи',
    'completed' => 'Выполненные задачи',
);

$date_filter = array(
    'all' => 'Все',
    'this_week' => 'Эта неделя',
    'next_week' => 'След. неделя',
    'this_month' => 'Этот месяц',
    'next_month' => 'След. месяц',
);

?>