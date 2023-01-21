<?php
$imageSrc = "";
?>
<h1>Mapa</h1>
<!--
    TODO: Add leaflet map
-->
<p>Który budynek?</p>
<!--
    TODO: Add image containing 2 buildings
 -->
<form action="index.php" method="post">
    <input type="hidden" name="page" value="Plan">
    <input type="hidden" name="numerBudynku" value="WI1">
<input type="submit" value="Budynek 1">
<form action="index.php" method="post">
    <input type="hidden" name="page" value="Plan">
    <input type="hidden" name="numerBudynku" value="WI2">
<input type="submit" value="Budynek 2">