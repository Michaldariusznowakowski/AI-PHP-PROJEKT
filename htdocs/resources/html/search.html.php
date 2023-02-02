<?php
$title = "Wyszukaj";
$scriptSrc = "resources/js/script.js";
?>

<h1><?= $title ?></h1>

<form id="searchTypeForm">
    <legend>Pracownik czy pomieszczenie?</legend>
    <input type="radio" id="room" name="searchData" value="room" checked>
    <label for="room">Pomieszczenie</label><br>
    <input type="radio" id="employee" name="searchData" value="employee">
    <label for="employee">Pracownik</label><br>
</form>

<fieldset id="buildingForm">
    <form action="index.php" method="post">
    <input type="hidden" name="page" value="Szukaj">
    <legend>Który budynek?</legend>
    <label for="room_num">Numer pokoju:</label>
    <input type="text" id="room_num" name="numerPokoju"><br>
    <label for="building">Budynek:</label>
    <select id="building" name="numerBudynku">
        <?php
        foreach($HTML_BUILDINGS_LIST as $building) {
            echo "<option value='$building'>$building</option>";
        } 
        ?>
    </select>
    <input type="submit" value="Szukaj">
    </form>
</fieldset>

<fieldset id="employeeForm">
    <form action="index.php" method="post">
    <input type="hidden" name="page" value="Szukaj">
    <legend>Kto?</legend>
    <label for="name">Imie:</label>
    <input type="text" id="name" name="imie"><br>
    <label for="surname">Nazwisko:</label>
    <input type="text" id="surname" name="nazwisko"><br>
    <input type="submit" value="Szukaj">
    </form>
</fieldset>
<?php if (isset($HTML_SEARCH_RESULT)) {
    echo "<h1>Wynik wyszukiwania</h1>";
    if($HTML_SEARCH_RESULT["FOUND"] == false) {
        echo "<p> Brak wyników </p>";
    } else {
        echo "<p> Znaleziono: </p>";
        
        $len_results = count($HTML_SEARCH_RESULT["RESULT"]);
        for($i = 0; $i < $len_results; $i++) {
            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' name='page' value='Plan'>";
            echo "<input type='hidden' name='numerBudynku' value='" . $HTML_SEARCH_RESULT["RESULT"][$i]["BUILDING_NUMBER"] . "'>";
            echo "<input type='hidden' name='numerPietro' value='" . $HTML_SEARCH_RESULT["RESULT"][$i]["FLOOR_NUMBER"] . "'>";
            echo "<input type='hidden' name='numerPokoju' value='" . $HTML_SEARCH_RESULT["RESULT"][$i]["ROOM_NUMBER"] . "'>";
            echo "<p> Budynek: " . $HTML_SEARCH_RESULT["RESULT"][$i]["BUILDING_NUMBER"] . "</p>";
            echo "<p> Piętro: " . $HTML_SEARCH_RESULT["RESULT"][$i]["FLOOR_NUMBER"] . "</p>";
            echo "<p> Pokój: " . $HTML_SEARCH_RESULT["RESULT"][$i]["ROOM_NUMBER"] . "</p>";
            echo "<input type='submit' value='Zobacz'>";
            echo "</form>";
        }
        
    }

}   ?>
</form>
<script src=<?= $scriptSrc?>></script>