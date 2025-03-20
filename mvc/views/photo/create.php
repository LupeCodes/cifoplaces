<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo lugar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="nuevo foto en <?= APP_NAME ?>">
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
		<?= $template->header('Nueva foto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares'     => '/Place/list',
		    $place->name  => '/Place/show/'.$place->id,
		    'Crear foto'  => NULL
		    
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nueva foto</h2>
			
			<form method="POST" enctype="multipart/form-data" 
				action="/Photo/store" class="flex-container gap2">
				<input type="hidden" name="idplace" value="<?= $place->id ?>">
			
				<div class="flex2">
        			<label>Nombre</label>
        			<input type="text" name="name" value="<?= old('name') ?>">
        			<br>
        			<label>Imagen</label>
        			<input type="file" name="file" accept="image/*"  id="file-with-preview">
        			<br>
        			<label>Descripcion</label>
        			<textarea name="description"><?= old('description') ?></textarea>
        			<br>
        			<label>Alt</label>
        			<textarea name="alt"><?= old('alt') ?></textarea>
        			<br>
        			<label>Fecha</label>
        			<input type="date" name="date" value="<?= old('date') ?>">
        			<br>
        			<label>Hora</label>
        			<input type="time" name="time" value="<?= old('time') ?>">
        			<br>
        			
        			
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>	
    			
    			<figure class="flex2 centrado p2">
            		<img src="<?=PHOTO_IMAGE_FOLDER.'/'.DEFAULT_PHOTO_IMAGE?>"
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