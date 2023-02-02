<?php 
echo "<h2>Numer pokoju:</h2>";
echo "<p>" . $HTML_ROOM["NUMBER"] . "</p>";
echo "<h2>Rodzaj pomieszczenia:</h2>";
echo "<p>" . $HTML_ROOM["TYPE"] . "</p>";
if($HTML_ROOM["TYPE"] == "Gabinet") {
    // Get lenght of [TEACHER] array
    $len = count($HTML_ROOM["TEACHER-NAME"]);
    for($i = 0; $i < $len; $i++) {
        echo "<h2>Pracownik:</h2>";
        echo "<p>". $HTML_ROOM["TEACHER-ACADEMIC-TITLE"][$i] . " " . $HTML_ROOM["TEACHER-NAME"][$i] . " " . $HTML_ROOM["TEACHER-SURNAME"][$i] . "</p>";
        echo "<h2>Obecne zajęcia pracownika:</h2>";
        echo "<p>" . $HTML_ROOM["TEACHER-SCHEDULE"][$i]["TEACHER_CURRENT_LESSON"] . "</p>";
        echo "<h2>Najbliższe zajęcia pracownika:</h2>";
        echo "<p>" . $HTML_ROOM["TEACHER-SCHEDULE"][$i]["TEACHER_NEXT_LESSON"] . "</p>";
        echo "<h2>Gdzie najczęściej pracownik się znajduje:</h2>";
        foreach($HTML_ROOM["TEACHER-FAVORITE-ROOMS"][$i] as $room) {
            echo "<p> Pokój " . $room . "</p>";
        }
    }
}
?>
