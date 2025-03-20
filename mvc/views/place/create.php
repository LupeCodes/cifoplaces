<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo lugar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="nuevo lugar en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		<!-- JS -->
		<script src="/js/Preview.js"></script>
		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares' => '/Place/list',
		    'Nuevo Lugar' => null
		    
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo lugar</h2>
			
			<form method="POST" enctype="multipart/form-data" 
				action="/Place/store" class="flex-container gap2">
			
				<div class="flex2">
        			<label>Nombre</label>
        			<input type="text" name="name" value="<?= old('name') ?>">
        			<br>
        			<label>Tipo</label>
        			<input type="text" name="type" value="<?= old('type') ?>">
        			<br>
        			<label>Localizacion</label>
        			<input type="text" name="location" value="<?= old('location') ?>">
        			<br>
        			<label>Imagen</label>
        			<input type="file" name="mainpicture" accept="image/*"  id="file-with-preview">
        			<br>
        			<label>Descripcion</label>
        			<textarea name="description"><?= old('description') ?></textarea>
        			<br>
        			<label>Latitud</label>
        			<input type="number" name="latitude" value="<?= old('latitude') ?>">
        			<br>
        			<label>Longitud</label>
        			<input type="number" name="longitude" value="<?= old('longitude') ?>">
        			<br>
        			
        			
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>	
    			
    			<figure class="flex2 centrado p2">
            		<img src="<?=PLACE_IMAGE_FOLDER.'/'.DEFAULT_PLACE_IMAGE?>"
            			class="cover" id="preview-image" alt="previsualizacion de la foto"
            			alt="Foto de <?=$place->name?>">
            		<figcaption>Previsualización de la foto</figcaption>	
            	</figure>
            			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>