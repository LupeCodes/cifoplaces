<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar foto</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Editar foto en <?= APP_NAME ?>">
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
		<?= $template->header('Editar ', $photo->name) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    $place->name => '/Place/show/$vpicture->placename',
		    $photo->name => NULL
		    //'Detalles del libro' => 'Libro/show'
		]); ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar foto</h2>
			
			<section class="flex-container gap2">
			
    			<form method="POST" action="/Photo/update" class="flex2 no-border no-shadow"
    				enctype="multipart/form-data">
    			     <!-- input oculto que contiene el id del lugar a actualizar -->
    				 <input type="hidden" name="id" value="<?= $photo->id ?>">
    			
    				<div class="flex2">
            			<label>Nombre</label>
            			<input type="text" name="name" value="<?= old('name', $photo->name) ?>">
            			<br>
            			<label>Descripcion</label>
            			<textarea name="description"><?= old('description', $photo->description) ?></textarea>
            			<br>
            			<label>Alt</label>
            			<textarea name="alt"><?= old('alt', $photo->alt) ?></textarea>
            			<br>
            			<label>Fecha</label>
            			<input type="date" name="date" value="<?= old('date', $photo->date) ?>">
            			<br>
            			<label>Hora</label>
            			<input type="time" name="time" value="<?= old('time', $photo->time) ?>">
            			<br>
            			
            		
            			
            			<div class="centered mt2">
            				<input type="submit" class="button" name="actualizar" value="Actualizar">
            				<input type="reset" class="button"  value="Reset">
            			</div>
            		</div>
				</form>
				
				
			
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