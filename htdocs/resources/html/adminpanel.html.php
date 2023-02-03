<div class="col-12">
	<h1>Panel Administratora</h1>
</div>
<div class="col-6">

	<h2>Lista pracowników</h2>

	<br />

	<table>

		<tr>
			<th>Tytul</th>
			<th>Imie</th>
			<th>Nazwisko</th>
			<th>Akcja</th>
		</tr>
		<?php 
		
		foreach($HTML_PRACOWNICY as $pracownik):
		
		?>
		<tr>
			<td>		
				<?=$pracownik['Tytul']?>	
			</td>
			<td>
				<?=$pracownik['Imie']?>
			</td>
			<td>
				<?=$pracownik['Nazwisko']?>
			</td>
			<td>
				<form action="" method="post">
					<input type="hidden" name="idPracownik" value="<?=$pracownik['idPracownicy']?>">
					<input type="hidden" name="page" value="Admin Panel">
					<input type="submit" name="usun_pracownika" value="usun">
				</form>
			</td>
		</tr>
		<?php
		
		endforeach;
		
		?>
</table>	
	
</div>


<div class="col-6">
	<h2>Formularz Dodania Pliku</h2>
	<form action="index.php" method="post">
		<label> Dodaj / Usuń plik </label>
		<input type="submit" name="page" value="Formularz Plików">
	</form>
</div>


<div class="col-6">

	<h2>Lista budynków</h2>

	<br />

	<table>

		<tr>
			<th>Numer budynku</th>
			<th>Adres budynku</th>
			<th>Opis</th>
			<th>Lat</th>
			<th>Lng</th>
			<th>Akcja</th>
		</tr>
		<?php 
		
		foreach($HTML_BUDYNKI as $budynek):
		
		?>
		<tr>
			<td>		
				<?=$budynek['NumerBudynku']?>	
			</td>
			<td>
				<?=$budynek['AdresBudynku']?>
			</td>
			<td>
				<?=$budynek['OpisDodatkowy']?>
			</td>
			<td>
				<?=$budynek['SzerokoscGeo']?>
			</td>
			<td>
				<?=$budynek['DlugoscGeo']?>
			</td>
			<td>
				<form action="index.php" method="post">
					<input type="hidden" name="idBudynki" value="<?=$budynek['idBudynki']?>">
					<input type="hidden" name="page" value="Admin Panel">
					<input type="submit" name="usun_budynek" value="usun">
				</form>
			</td>
		</tr>
		<?php
		
		endforeach;
		
		?>
</table>	
	
</div>


<div class="col-6">

	<h2>Lista pięter</h2>

	<br />

	<table>

		<tr>
			<th>Numer pietra</th>
			<th>Id Budynek</th>
			<th>Opis</th>
		
		</tr>
		<?php 
		
		foreach($HTML_PIETRA as $pietro):
		
		?>
		<tr>
			<td>		
				<?=$pietro['NumerPietra']?>	
			</td>
			<td>
				<?=$pietro['Budynki_idBudynki']?>	<?php //$HTML_BUDYNKI[$pietro['Budynki_idBudynki']-1]['OpisDodatkowy'];?>
			</td>
			<td>
				<?=$pietro['PhotoUrl']?>
			</td>
			<td>
				<form action="index.php" method="post">
					<input type="hidden" name="idPietra" value="<?=$pietro['idPietra']?>">
					<input type="hidden" name="page" value="Admin Panel">
					<input type="submit" name="usun_pietro" value="usun">
				</form>
			</td>
		</tr>
		<?php
		
		endforeach;
		
		?>
</table>	
	
</div>

<div class="col-6">

	<h2>Lista pomieszczeń</h2>

	<br />

	<table>

		<tr>
			<th>Numer Pokoju</th>
			<th>Typ Pokoju</th>
			<th>id Pietra</th>
		
		</tr>
		<?php 
		
		foreach($HTML_POKOJE as $pomieszczenie):
		
		?>
		<tr>
			<td>		
				<?=$pomieszczenie['NumerPokoju']?>	
			</td>
			<td>
				<?=$pomieszczenie['TypPokoju']?>	
			</td>
			<td>
				<?=$pomieszczenie['Pietra_idPietra']?>
			</td>
			<td>
				<form action="index.php" method="post">
					<input type="hidden" name="idPokoje" value="<?=$pomieszczenie['idPokoje']?>">
					<input type="hidden" name="page" value="Admin Panel">
					<input type="submit" name="usun_pokoj" value="usun">
				</form>
			</td>
		</tr>
		<?php
		
		endforeach;
		
		?>
</table>	
	
</div>



<div class="col-6">
	<h2>Dodaj pracownika</h2>
	<br />
	<form action="index.php" method="post">
		Tytul: <input type="text" name="tytul"><br />
		Imie: <input type="text" name="imie"><br />
		Nazwisko: <input type="text" name="nazwisko"><br />
		<input type="hidden" name="page" value="Admin Panel">
		<input type="submit" name="dodaj_pracownika" value="dodaj">
	</form>

</div>
<div class="col-6">
	<h2>Dodaj budynek</h2>
	<br />
	<form action="index.php" method="post">
		Numer budynku: <input type="number"  name="NumerBudynku"><br />
		Adres budynku: <input type="text" name="AdresBudynku"><br />
		Opis: <input type="text" name="OpisDodatkowy"><br />
		Lat: <input type="number" step=any name="SzerokoscGeo"><br />
		Lng: <input type="number" step=any name="DlugoscGeo"><br />
		<input type="hidden" name="page" value="Admin Panel">
		<input type="submit" name="dodaj_budynek" value="dodaj">
	</form>

</div>
<div class="col-6">
	<h2>Dodaj pietro</h2>
	<br />
	<form action="index.php" method="post">
		Numer pietra: <input type="number"  name="NumerPietra"><br />
		
		Budynek:<select name="Budynki_idBudynki">
		<?php 
		foreach($HTML_BUDYNKI as $budynek):
		?>
		<option value="<?=$budynek['idBudynki']?>"><?=$budynek['OpisDodatkowy']?></option>
		
		<?php
		
		endforeach;
		
		?>
		</select><br />
		
		<input type="hidden" name="page" value="Admin Panel">
		<input type="submit" name="dodaj_pietro" value="dodaj">
	</form>

</div>
<div class="col-6">
	<h2>Dodaj pomieszczenie</h2>
	<br />
	<form action="index.php" method="post">
		Numer Pokoju: <input type="text"  name="NumerPokoju"><br />
		
		Typ pomieszczenia:<select name="TypPokoju">
		<option value="1">1</option>
		<option value="2">2</option>
		
		</select><br />
		
		Pietro:<select name="Pietra_idPietra">
		<?php 
		foreach($HTML_PIETRA as $pietro):
		?>
		<option value="<?=$pietro['idPietra']?>"><?=$pietro['NumerPietra']?> (Budynek Id:<?=$pietro['Budynki_idBudynki']?>)</option>
		
		<?php
		
		endforeach;
		
		?>
		</select><br />
		
		<input type="hidden" name="page" value="Admin Panel">
		<input type="submit" name="dodaj_pokoj" value="dodaj">
	</form>

</div>
