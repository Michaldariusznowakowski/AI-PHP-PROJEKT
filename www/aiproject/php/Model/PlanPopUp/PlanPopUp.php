<?php
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
        $output['TEACHER'] = array("Jan Kowalski", "Jan Nowak");
        $output['TEACHER_SCHEDULE'] = array("http://www.google.com", "http://www.google.com");
        $output['TEACHER_CURRENT_LESSON'] = array("Informatyka 1", "Informatyka 2");
        $output['TEACHER_NEXT_LESSON'] = array("Informatyka 1", "Informatyka 2");
        $output['TEACHER_FAVOURITE_ROOMS'] = array(array("Gabinet 1", "Gabinet 2"), array("Gabinet 1", "Gabinet 2"));
        return $output;
    }
}
