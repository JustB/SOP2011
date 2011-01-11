<?php
require_once 'config.php';
require_once 'Sorvegliante.php';
require_once 'Validator.php';
require_once 'Redirect.php';

$pageTitle = 'Elimina sorvegliante';

$v = new Validator($_GET);
$v->isNotEmpty('matricola');
$v->isNumeric('matricola');

$e = $v->getError();
if(!empty($e)){
	$r = new Redirect(PUBLIC_URL . '/error.php');
	$r->doRedirect();
}

$clean = $v->getClean();
$clean['matricola'] = urldecode($clean['matricola']);
$s = Sorvegliante::find_by_id($clean['matricola']);
$eliminaUrl = ACTION_URL . '/sorvegliante/elimina.php';
?>
<?php include HELPERS_DIR . '/testata.php'; ?>
		<h1><?php echo $pageTitle; ?></h1>
		<p>Sei sicuro di voler cancellare il sorvegliante "<?php echo $s; ?>"?</p>
		<form action="<?php echo $eliminaUrl; ?>" method="post">
			<p><input type="radio" name="elimina" id="eliminaSI" value="SI" />Si</p>
			<p><input type="radio" name="elimina" id="eliminaNO" value="NO" checked="checked" />No</p>
			<p>
				<input id="submit" name="submit" type="submit" value="Invia" />
				<input type="hidden" name="matricola" value="<?php echo $s->getMatricola(); ?>" />
			</p>
		</form>
<?php include HELPERS_DIR . '/piepagina.php'; ?>