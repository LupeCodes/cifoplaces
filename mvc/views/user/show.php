<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del usuario</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="detalle de usuario <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del usuario ', $user->displayname) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuarios' => '/User/list',
		    $user->displayname => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section id="detalles" class="flex-container gap2">
				<div class="flex2">
    				<h2><?= $user->displayname ?></h2>
    				
    				<p><b>ID:</b>					<?=$user->id?></p>
            		<p><b>eMail:</b>				<?=$user->email?></p>
            		<p><b>Telefono:</b>				<?=$user->phone?></p>
            		<p><b>Roles:</b>				<?php foreach($user->roles as $valor){
                        							          echo $valor.' ';
                        							} ?></p>
            		<p><b>Fecha de alta:</b>		<?=$user->created_at?></p>	
            	</div>
            	
            	<figure class="flex1 centrado p2">
            		<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
            			class="cover enlarge-image"
            			alt="Foto del socio <?=$socio->nombre?>">
            		<figcaption>Foto de <?= "$socio->nombre $socio->apellidos" ?></figcaption>	
            	</figure>
        		
			</section>
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/user/list">Lista de usuarios</a>
				<a class="button" href="/user/edit/<?= $user->id ?>">Editar</a>
				<a class="button" href="/user/delete/<?= $user->id ?>">Borrar</a>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>