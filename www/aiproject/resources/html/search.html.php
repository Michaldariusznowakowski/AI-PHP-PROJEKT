<?php
$title = "Wyszukaj";
$scriptSrc = "..resources/js/script.js";
/** @todo add in css display:none as a default value for building-form fieldset*/
?>

<h1><?= $title ?></h1>
<form action="">
<form id="searchTypeForm">
    <legend>Pracownik czy pomieszczenie?</legend>
    <input type="radio" id="room" name="searchData" value="room" checked>
    <label for="room">Pomieszczenie</label><br>

    <input type="radio" id="employee" name="searchData" value="employee">
    <label for="employee">Pracownik</label><br>
</form>

<fieldset id="buildingForm">
    <legend>Który budynek?</legend>
    <label for="room_num">Numer pokoju:</label>
    <input type="text" id="room_num"><br>
    <label for="building">Budynek:</label>
    <select id="building" name="building">
        <option value="WI1" selected>WI1</option>
        <option value="WI2">WI2</option>
    </select>
    <input type="submit" value="Szukaj">
</fieldset>

<fieldset id="employeeForm">
    <legend>Kto?</legend>
    <label for="name">Imie:</label>
    <input type="text" id="name"><br>
    <label for="surname">Nazwisko:</label>
    <input type="text" id="surname"><br>
    <label for="current-time">Kiedy?</label>
    <button id="current-time">Ustaw na teraz</button><br>
    <label for="hour">O godzinie:</label>
    <input type="time" id="hour"><br>
    <label for="date">W dniu:</label>
    <input type="date" id="date"><br>
    <input type="submit" value="Szukaj">
</fieldset>
</form>
<script src=<?= $scriptSrc?>></script>