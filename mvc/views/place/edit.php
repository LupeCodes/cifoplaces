<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar lugar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Editar lugar en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>
		<script src="/js/Preview.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Editar ', $place->name) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    $place->name => '/Place/show/$place->id',
		    'Editar lugar' => NULL
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar lugar</h2>
			
			<section class="flex-container gap2">
			
    			<form method="POST" action="/Place/update" class="flex2 no-border no-shadow"
    				enctype="multipart/form-data">
    			     <!-- input oculto que contiene el id del lugar a actualizar -->
    				 <input type="hidden" name="id" value="<?= $place->id ?>">
    			
    				<div class="flex2">
            			<label>Nombre</label>
            			<input type="text" name="name" value="<?= old('name', $place->name) ?>">
            			<br>
            			<label>Tipo</label>
            			<input type="text" name="type" value="<?= old('type', $place->type) ?>">
            			<br>
            			<label>Localizacion</label>
            			<input type="text" name="location" value="<?= old('location', $place->location) ?>">
            			<br>
            			<label>Imagen</label>
            			<input type="file" name="mainpicture" accept="image/*"  id="file-with-preview">
            			<br>
            			<label>Descripcion</label>
            			<textarea name="description"><?= old('description', $place->description) ?></textarea>
            			<br>
            			<label>Latitud</label>
            			<input type="number" name="latitude" value="<?= old('latitude', $place->latitude) ?>">
            			<br>
            			<label>Longitud</label>
            			<input type="number" name="longitude" value="<?= old('longitude', $place->longitude) ?>">
            			<br>
            			
            		
            			
            			<div class="centered mt2">
            				<input type="submit" class="button" name="actualizar" value="Actualizar">
            				<input type="reset" class="button"  value="Reset">
            			</div>
            		</div>
				</form>
				
				<figure class="flex1 centrado no-shadow">
					<img src="<?=PLACE_IMAGE_FOLDER.'/'.$place->mainpicture?>"
						class="cover enlarge-image" alt="Imagen de <?= $place->name ?>"
						id="preview-image">
					<figcaption>Foto de <?="$place->name" ?></figcaption>
					
					
				</figure>
			
			</section>
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
				<a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>