<?php
class Scrapper {
    public static $url_ = "https://plan.zut.edu.pl/schedule_student.php?teacher={name}%20{surname}&start={start}T00:00:00+01:00&end={end}T00:00:00+01:00";
    public static function getSchedule($name, $surname, $start, $end) {
        if ($name == null || $surname == null || $start == null || $end == null) {
            return null;
        }
        $url = Scrapper::$url_;
        $url = str_replace('{name}', $name, $url);
        $url = str_replace('{surname}', $surname, $url);
        $url = str_replace('{start}', $start, $url);
        $url = str_replace('{end}', $end, $url);
        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'timeout' => 60
            )
        );
        $context  = stream_context_create($opts);
        $output = file_get_contents($url, false, $context);
        $json = JSON_decode($output, true);
        array_shift($json);
        return $json;
    }
    # Disable constructor
    private function __construct() {}
}