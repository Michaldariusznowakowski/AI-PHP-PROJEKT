<?php 
echo "<h2>Rodzaj pomieszczenia:</h2>";
echo "<p>" . $HTML_ROOM["TYPE"] . "</p>";
echo "<h2>Informacje o pomieszczeniu:</h2>";
echo "<p>" . $HTML_ROOM["INFO"] . "</p>";
if($HTML_ROOM["TYPE"] == "Gabinet") {
    // Get lenght of [TEACHER] array
    $len = count($HTML_ROOM["TEACHER"]);
    // If there is more than one teacher
    for($i = 0; $i < $len; $i++) {
        echo "<h2>Pracownik:</h2>";
        echo "<p>" . $HTML_ROOM["TEACHER"][$i] . "</p>";
        echo "<h2>Plan zajęć pracownika:</h2>";
        echo "<a href=".$HTML_ROOM["TEACHER_SCHEDULE"][$i].">Link do planu zajęć</a>";
        echo "<h2>Obecne zajęcia pracownika:</h2>";
        echo "<p>" . $HTML_ROOM["TEACHER_CURRENT_LESSON"][$i] . "</p>";
        echo "<h2>Najbliższe zajęcia pracownika:</h2>";
        echo "<p>" . $HTML_ROOM["TEACHER_NEXT_LESSON"][$i] . "</p>";
        echo "<h2>Gdzie najczęściej pracownik się znajduje:</h2>";
        foreach($HTML_ROOM["TEACHER_FAVOURITE_ROOMS"][$i] as $room) {
            echo "<p> Pokój " . $room . "</p>";
        }
    }
}
?>