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
	<h2>Dodaj pracownika</h2>
	<br />
	<form action="index.php" method="post">
		Tytul: <input type="text" name="tytul"><br />
		Imie: <input type="text" name="imie"><br />
		Nazwisko: <input type="text" name="nazwisko"><br />
		<input type="submit" name="dodaj_pracownika" value="dodaj">
	</form>

</div>
<div class="col-6">
	<h2>Formularz Dodania Pliku</h2>
	<form action="index.php" method="post">
		<label> Dodaj / Usuń plik </label>
		<input type="submit" name="page" value="Formularz Plików">
	</form>
</div>
