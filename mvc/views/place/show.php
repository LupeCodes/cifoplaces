<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del lugar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Detalles del lugar en <?= APP_NAME ?>">
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
		<?= $template->header('Detalles del lugar ', $place->name) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares' => '/Place/list',
		    $place->name => null
		    
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section id="detalles" class="flex-container gap2">
				<figure class="flex1 centrado p2">
            		<img src="<?=PLACE_IMAGE_FOLDER.'/'.($place->mainpicture ?? DEFAULT_PLACE_IMAGE)?>"
            			class="cover enlarge-image">
            		<figcaption>Imagen principal de <?= "$place->name" ?></figcaption>	
            	</figure>
            	
            	<div class="flex2">
    				<h2><?= $place->name ?></h2>
    				
    				<p><b>Nombre:</b>			<?=$place->name?></p>
            		<p><b>Tipo:</b>				<?=$place->type?></p>
            		<p><b>Descripcion:</b>		<?=$place->description?></p>
            		<p><b>Localizacion:</b>		<?=$place->location?></p>
            		<p><b>Latitud:</b>			<?=$place->latitude?></p>
            		<p><b>Longitud:</b>			<?=$place->longitude?></p>
            		<p><b>Creado:</b>			<?=$place->created_at?></p>
            		<p><b>Actualizado:</b>		<?=$place->updated_at ?? '--'?></p>
            		
            	</div>
            		
			</section>
			
			<!--
			<section>
				<h2>Descripcion</h2>
				<p><?=$place->description ? paragraph($place->description) : 'SIN DETALLES'?></p>
			</section>
			-->
			<section>
				<h2>Fotos de <?=$place->name?></h2>
				<?php 
				if(!$photos){
				    echo "<div class='warning p2'><p>Aún no hay más fotos.</p></div>";
				}else{?>
				
    				<div class="gallery w75 cetered-block my2">
    					
    				<?php foreach($photos as $photo){ ?>
          				<figure class="small card pointer">
          					<a href="/Photo/show/<?= $photo->id ?>">
          						<img src="<?=PHOTO_IMAGE_FOLDER.'/'.$photo->file?>">
          					</a>	
          					<figcaption><?= $photo->name?></figcaption>
          				</figure>
					<?php } ?>	
						
    				</div>
    				
    			<?php } ?>	
			</section>
			
			<section>
				<h3>Comentarios en <b><?=$place->name?></b></h3>
				
        			<?php foreach($comments as $comment){?>
        				<div class="border">
        					<p>
        						<img src="<?=PLACE_IMAGE_FOLDER.'/'.$place->mainpicture?>"
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