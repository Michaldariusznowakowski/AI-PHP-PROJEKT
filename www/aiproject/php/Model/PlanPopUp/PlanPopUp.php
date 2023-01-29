<?php
require_once 'php/Model/Scrapper/Scrapper.php';
class PlanPopUp implements functions_for_model {
    public function getViewParams($post) {


// <h2>Rodzaj pomieszczenia:</h2>
// <p> <?php echo $HTML_ROOM["TYPE"];</p>
// echo "<h2>Rodzaj pomieszczenia:</h2>";
// echo "<p>" . $HTML_ROOM["TYPE"] . "</p>";
// echo "<h2> Informacje o pomieszczeniu: </h2>";
// echo "<p>" . $HTML_ROOM["INFO"] . "</p>";
// if($HTML_ROOM["TYPE"] == "Gabinet") {
// // Get lenght of [TEACHER] array
// $len = count($HTML_ROOM["TEACHER"]);
// // If there is more than one teacher
// for($i = 0; $i < $len; $i++) {
// echo "<h2>Pracownik:</h2>";
// echo "<p>" . $HTML_ROOM["TEACHER"][$i] . "</p>";
// echo "<h2>Plan zajęć pracownika:</h2>";
// echo "<a href='$HTML_ROOM[TEACHER_SCHEDULE][$i]'>Link do planu zajęć</a>";
// echo "<h2>Obecne zajęcia pracownika:</h2>";
// echo "<p>" . $HTML_ROOM["TEACHER_CURRENT_LESSON"][$i] . "</p>";
// echo "<h2>Najbliższe zajęcia pracownika:</h2>";
// echo "<p>" . $HTML_ROOM["TEACHER_NEXT_LESSON"][$i] . "</p>";
// echo "<h2>Gdzie najczęściej pracownik się znajduje:</h2>";
// foreach($HTML_ROOM["TEACHER_FAVOURITE_ROOMS"][$i] as $room) {
//     echo "<p> Pokój " . $room . "</p>";
// }
// }
// }

        $numerBudynku = $post['numerBudynku'];
        $numerPietra = $post['numerPietra'];
        $numerPomieszczenia = $post['numerPokoju'];

        $output = array();
        $output['pageName'] = "PlanPopUp";
        $output['HTML_ROOM'] = $this->getRoomInfo($numerBudynku, $numerPietra, $numerPomieszczenia);

        return $output;
        
    }
    private function getRoomInfo($numerBudynku, $numerPietra, $numerPomieszczenia) {
        // Temporary function
        $output = array();
        $output['TYPE'] = "Gabinet";
        $output['INFO'] = "Gabinet informatyczny";
        $name = "Anna";
        $surname = "Barcz";
        $name2 = "Włodzimierz";
        $surname2 = "Chocianowicz";
        $output['TEACHER'] = array($name . " " . $surname, $name2 . " " . $surname2);
        $url = "http://www.google.com";
        $plan = $this->getSchedule($name, $surname);
        $plan2 = $this->getSchedule($name2, $surname2);
        $output['TEACHER_SCHEDULE'] = array($url, $url);
        $output['TEACHER_CURRENT_LESSON'] = array($plan['TEACHER_CURRENT_LESSON'], $plan2['TEACHER_CURRENT_LESSON']);
        $output['TEACHER_NEXT_LESSON'] = array($plan['TEACHER_NEXT_LESSON'], $plan2['TEACHER_NEXT_LESSON']);
        $output['TEACHER_FAVOURITE_ROOMS'] = array(array("A1", "A2"), array("B1", "B2"));
        return $output;
    }
    private function getSchedule($name, $surname) {
        $currentTime= new DateTime();
        $currentTime->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $today = $currentTime->format(DateTime::ATOM);
        $maxLastDate =  new DateTime();
        $maxLastDate->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $maxLastDate->add(new DateInterval('P20D'));
        $end = $maxLastDate->format(DateTime::ATOM);
        $plan = Scrapper::getSchedule($name, $surname, $today, $end);
        // $plan for each
        $output = array();
        $output['TEACHER_CURRENT_LESSON'] = "Brak zajęć w tym momencie.";
        $output['TEACHER_NEXT_LESSON'] = "Brak zajęć w przeciągu najbliższych 20 dni.";
        if($plan != null) {
            if (is_array($plan) || is_object($plan)) {
                if ($plan[0]["end"] < $currentTime->format(DateTime::ATOM)) { // Obecne zajęcia
                    $output['TEACHER_CURRENT_LESSON'] = $plan[0]["title"] + "\n" + $plan[0]["room"];
                }
            if (count($plan) > 1) {
                $humanDateFormat = new DateTime($plan[1]["start"]);
                $humanDateFormat->setTimezone(new DateTimeZone('Europe/Warsaw'));
                $output['TEACHER_NEXT_LESSON'] = $plan[1]["title"]."\n".$plan[1]["room"]."\n".$humanDateFormat->format('d.m.Y H:i')."\n";
            }
        }
        return $output;
    }
}
}
