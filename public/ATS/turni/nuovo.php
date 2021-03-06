<?php
session_start();
require_once 'config.php';
require_once 'DB.php';
require_once 'Squadra.php';
require_once 'Percorso.php';

$pageTitle = "Aggiungi Turno";
$aggiungiUrl = ACTION_URL . '/turno/aggiungi.php';
$selected = 'selected="selected"';
$checked = 'checked="checked"';
$db = DB::getInstance();

$squadre = Squadra::findAll();
$percorsi = Percorso::findAll();

//il codice squadra di default è 1
$default = array('data' => '', 'codiceTurno' => '', 'codiceSquadra' => 1, 'codicePercorso' => '');

if (isset($_SESSION['errors'])) {
	$e = $_SESSION['errors'];
	$c = $_SESSION['clean'];

	$default = array_merge($default, $c);

	unset($_SESSION['errors']);
	unset($_SESSION['clean']);
}
?>
<?php include HELPERS_DIR . '/testata.php'; ?>
<h1>Aggiungi nuovo turno</h1>

<?php if (isset($e)) : ?>
	<ul class="errorList">
	<?php foreach ($e as $error) : ?>
		<li><?php echo $error; ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
<p><a href="../turni/">Indietro</a></p>
<form id="nuovoTurno" action="<?php echo $aggiungiUrl; ?>" method="post">
	<p>
		<label for="data">Data</label>
		<input id="data" name="data" type="text" value="<?php echo $default['data']; ?>" />
	</p>
	<p>
		<label for="codiceSquadra">Squadra</label>
		<select id="codiceSquadra" name="codiceSquadra">
		<?php foreach ($squadre as $s) : ?>
			<option value="<?php echo $s['codiceSquadra']; ?>"
			<?php if ($default['codiceSquadra'] == $s['codiceSquadra'])
			echo $selected; ?>><?php echo $s['nomeSquadra']; ?></option>
		<?php endforeach; ?>
		</select>
	</p>
	<fieldset id="percorsiWrapper">
		<div id="labelPercorsi">
			<?php foreach ($percorsi as $p): ?>
						<p><input name="codiciPercorsi[]"
								  id="percorso<?php echo $p['codicePercorso']; ?>"
								  type="checkbox"
								  class="checkboxPercorso"
								  value="<?php echo $p['codicePercorso']; ?>"
					  <?php if ($default['codicePercorso'] == $p['codicePercorso'])
							echo $checked; ?> />
  				<label for="percorso<?php echo $p['codicePercorso']; ?>">Percorso <?php echo $p['codicePercorso']; ?></label></p>
			<?php endforeach; ?>
		</div>
		<div id="map"></div>
		<div id="panel"></div>
	</fieldset>
	<p>
		<input id="submit" name="submit" type="submit" value="Salva Turno" />
	</p>
</form>
			
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/lib/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=it"></script>
<script type="text/javascript" src="<?php echo PUBLIC_URL; ?>/js/turni/recuperaPercorsoHover.js"></script>

<?php include HELPERS_DIR . '/piepagina.php'; ?>