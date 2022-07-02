<?php

include 'src\Curler\Curler.php';

use Curler\Curler;

define('UA','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:99.0) Gecko/20100101 Firefox/99.0');

$methodlist = ['GET','POST','PUT','HEAD','DELETE','OPTIONS','HEAD'];

$url = $_REQUEST['url'] ?? '';
$method = $_REQUEST['method'] ?? $methodlist[0] ?? 'GET';
$params = $_REQUEST['params'] ?? '';


?>
<!doctype html>
<html>
<head>
	<style>
#divided {
	white-space: nowrap !important;
	width: 97.5%;
}
#divided fieldset {
	vertical-align: top !important;
	display: inline-block !important;
	/*height: 160px;*/
	margin: 0;
}
#divided fieldset.s20 {
	min-width: 17.5% !important;
	max-width: 17.5% !important;
}
#divided fieldset.s40 {
	min-width: 40% !important;
	max-width: 40% !important;
}
#logbelow textarea {
	width: 97vw !important;
	height: 57vh !important;
}
.autosiz {
	overflow-x: scroll !important;
	overflow-y: scroll !important;
}

	</style>
	<script>
function showside(sel)
{
	let pd = sel.options[sel.selectedIndex].getAttribute('datapack');
	let display = document.getElementById('showsider');
	display.innerHTML = pd;
}
	</script>
</head>
<body>
<hr>
<div id="divided">
	<fieldset>
		<form action="./" method="post">
			<p>
				<label for="method">Method</label><br>
				<select name="method" id="method">
<?php
//
foreach ($methodlist as $item)
{
	?>					<option value="<?=($item)?>"><?=($item)?></option><?=("\r\n")?><?php
}
//
?>				</select>
			</p>
			<p>
				<label for="url">URL</label><br>
				<input type="text" id="url" name="url" value="" size="60" />
			</p>
			<p>
				<label for="url">Params</label><br>
				<textarea type="text" id="params" name="params" rows="6" cols="60"></textarea>
			</p>
			<p>
				<input type="submit" value="Test it">
			</p>
		</form>
	</fieldset>
</div>
<hr>
<div id="logbelow" class="autosiz">
	<textarea class="autosiz">
<?php

################################################################
####	my own practice workspace, also serves as example	####
################################################################

if ($url)
{
	$curl = new Curler();
	$curl->setUrl($url);
	$curl->setOptions([
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_BINARYTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_USERAGENT => UA,
	]);
	$result = $curl->execute()->getResult();
	$errors = $curl->getErrors();
	//
	$data = [
		'url' => $url,
		'method' => $method,
		'params' => $params,
		'errors' => $errors,
		'result' => $result,
	];
	//
	echo print_r($data, true);
	//
}
else
{
	echo 'Give a non-blank URL to work with.';
}



?>
	</textarea>
</div>
</body>
</html>
