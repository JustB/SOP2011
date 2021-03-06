<?php
require_once 'config.php';
require_once 'DB.php';
require_once 'PuntoDiControllo.php';
$pageTitle = "Inserisci nuovo percorso";

$pdc = PuntoDiControllo::findAll();

$aggiungiUrl = ACTION_URL . '/percorso/aggiungi.php';
?>
<?php include HELPERS_DIR . '/testata.php'; ?>

<h1><?php echo $pageTitle ?></h1>

<div id="info"></div>
<div id="costruisciPercorso">
	<div id="pdc">
		<h2>Punti di controllo</h2>
		<select id="luoghi" size="10">
			<?php foreach ($pdc as $luogo): ?>
				<option value="<?php echo $luogo['latitudine'] . ',' . $luogo['longitudine'] . ',' . $luogo['codicePC']; ?>"><?php
				echo trim(ucwords($luogo['nomeCliente'])." - ".ucwords($luogo['indirizzo']));
			?></option>
			<?php endforeach; ?>
			</select>
		</div>
		<div id="percorsoWrap">
			<h2>Percorso</h2>
			<table id="percorso">
				<thead>
					<tr>
						<th>Indirizzo</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

			<form id="salvaPercorso" action="<?php echo $aggiungiUrl; ?>" method="post">
				<p><input type="submit" value="Salva Percorso" name="salvaPercorso" /></p>
			</form>

		</div>
	</div>	
	<div id="map"></div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="<?php echo PUBLIC_URL; ?>/js/percorsi/creaPercorso.js"></script>
        <p><a href="../percorsi/">Indietro</a></p>
<?php include HELPERS_DIR . '/piepagina.php'; ?>