<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles de la foto</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Detalles de la foto <?= APP_NAME ?>">
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
		<?= $template->header('Detalles de la foto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares' => '/Place/list',
		    $place->name => '/Place/show/'.$place->id,
		    $photo->name => NULL
		    
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			
			<?php //dd($user) ?>
			
			<section id="detalles" class="flex-container gap2">
				<!--  -->
				
				<figure class="flex1 centrado p2 x-large">
            		<img src="<?=PHOTO_IMAGE_FOLDER.'/'.$photo->file?>"
            			class="cover enlarge-image" alt=<?= "$photo->alt" ?>>
            		<figcaption><?= "$photo->name" ?></figcaption>	
            	</figure>
            	
            	<div class="flex2">
    				<h2><?= $photo->name ?></h2>
    				
    				<p><b>Nombre:</b>			<?=$photo->name?></p>
            		<p><b>Descripcion:</b>		<?=$photo->description?></p>
            		<p><b>Fecha:</b>			<?=$photo->date?></p>
            		<p><b>Hora:</b>				<?=$photo->time?></p>
            		<p><b>Autor:</b>			<?=$user->displayname?></p>
            		<p><b>Creado:</b>			<?=$photo->created_at?></p>
            		<p><b>Actualizado:</b>		<?=$photo->updated_at ?? '--'?></p>
            		
            	</div>
            		
			</section>
			
			<!--
			<section>
				<h2>Descripcion</h2>
				<p><?=$place->description ? paragraph($place->description) : 'SIN DETALLES'?></p>
			</section>
			-->
			
			
			<section>
				<h3>Comentarios en <b><?=$photo->name?></b></h3>
				
        			<?php foreach($comments as $comment){?>
        				<div class="border">
        					<p>
        						<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>"
        								class="table-image">
        						<b>Autor:</b><?=$comment->username?>
        					</p>
        					<p><?=$comment->text?></p>
        					<p><?=$comment->created_at?></p>
        					<?php if(Login::role('ROLE_ADMIN')){?>
        						<a href='/Comment/destroy/<?=$comment->id?>'>Borrar</a>
        					<?php } ?>
        				</div>
        			<?php } ?>
        		</table>
			</section>
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
				<?php if(Login::role('ROLE_ADMIN')){?>
    				<a class="button" href="/Place/edit/<?= $place->id ?>">Editar</a>
    				<a class="button" href="/Place/delete/<?= $place->id ?>">Borrar</a>
    			<?php } ?>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>