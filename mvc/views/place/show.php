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
            		<p><b>Autor:</b>			<?=$autor->displayname?></p>
            		<p><b>Descripcion:</b>		<?=$place->description?></p>
            		<p><b>Localizacion:</b>		<?=$place->location?></p>
            		<p><b>Latitud:</b>			<?=$place->latitude?></p>
            		<p><b>Longitud:</b>			<?=$place->longitude?></p>
            		<p><b>Creado:</b>			<?=$place->created_at?></p>
            		<p><b>Actualizado:</b>		<?=$place->updated_at ?? '--'?></p>
            		
            	</div>
            		
  	
			</section>
			
			<section>
			
			<!-- El script para borrar los lugares -->	
        				<script>
    					function confirmardos(id){
    						if(confirm('¿Seguro que deseas eliminar?'))
    							location.href = '/Place/destroy/'+id
    					}
    					</script>
				<?php if(Login::user()->id == $place->iduser){ ?>
    				<a class="button" href="/Place/edit/<?= $place->id ?>">Editar</a>
    			<?php } ?>	
    			<?php if(Login::user()->id == $place->iduser  || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){ ?>	
    				<a class="button" onclick="confirmardos(<?= $place->id ?>)" href="/Place/destroy/<?= $place->id ?>">Borrar</a>
    			<?php } ?>
			</section>
			
			
			
			<section>
				<h2>Fotos de <?=$place->name?></h2>
				
				<?php if(Login::user()){ ?>
				<a class="button" href="/Photo/create/<?= $place->id ?>">Nueva foto</a>
				<?php } ?>
				
				<?php 
				if(!$photos){
				    echo "<div class='warning p2'><p>Aún no hay más fotos.</p></div>";
				}else{?>
				
    				<div class="gallery w75 cetered-block my2">
        			
        			<!-- El script para borrar las fotos -->	
        				<script>
    					function confirmar(id){
    						if(confirm('¿Seguro que deseas eliminar?'))
    							location.href = '/Photo/destroy/'+id
    					}
    					</script>
        					
    				<?php foreach($photos as $photo){ ?>
          				<figure class="small card pointer">
          					<a href="/Photo/show/<?= $photo->id ?>">
          						<img src="<?=PHOTO_IMAGE_FOLDER.'/'.$photo->file?>">
          					</a>	
          					<figcaption><?= $photo->name?>
          					
          					<?php if(Login::user()->id == $photo->iduser){ ?>
          						<a href="/Photo/edit/<?= $photo->id ?>">
          							<img class="icon" src="/images/template/editar.png">
          						</a>
          					<?php } ?>	
          					<?php if(Login::user()->id == $photo->iduser || Login::user()->id == $place->iduser || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){ ?>
          						<a onclick="confirmar(<?= $photo->id ?>)" href="/Photo/destroy/<?= $photo->id ?>">
          							<img class="icon" src="/images/template/borrar.png">
          						</a>
          					<?php } ?>
          					</figcaption>
          				</figure>
					<?php } ?>	
						
    				</div>
    				
    			<?php } ?>	
			</section>
			
			<?php if(Login::user()){ ?>
			<section>
				<form method="POST" enctype="multipart/form-data" action="/Comment/store">
    				<input type="hidden"  name="idplace" value="<?= $place->id ?>">
    				<div class="flex2">
            			<h3>Deja tu comentario</h3>
        				<textarea name="text"><?= old('text') ?></textarea>
        			
            			<div class="centered mt2">
            				<input type="submit" class="button" name="guardar" value="Guardar">
            				<input type="reset" class="button"  value="Reset">
            			</div>
        			</div>			
				</form>
			</section>
			<?php } ?>
			<section>
				
				<h3>Comentarios en <b><?=$place->name?></b></h3>
				
				
        		<?php foreach($comments as $comment){?>
        			<?php $autor = User::find($comment->iduser)?>
        			<div class="border p1">
        				<p>
        				
        					<img src="<?=USER_IMAGE_FOLDER.'/'. ($autor->picture ?? DEFAULT_USER_IMAGE) ?>"
        								class="table-image">
        						<b>Autor:</b><?=$comment->username?>
        				</p>
        				<p><?=$comment->text?></p>
        				<p><?=$comment->created_at?></p>
        				
        				
        				<!-- El script para borrar los comentarios -->	
            			<script>
        					function confirmarcoment(id){
        						if(confirm('¿Seguro que deseas eliminar?'))
        							location.href = '/Comment/destroy/'+id
        					}
        				</script>
        					
          				<?php if(Login::user()->id == $comment->iduser || (Login::user()->id == $place->iduser || Login::user()->id == $photo->iduser) || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){ ?>
          					<a onclick="confirmarcoment(<?= $comment->id ?>)" href="/Comment/destroy/<?= $comment->id ?>">
          						<img class="icon" src="/images/template/borrar.png">
          					</a>
          				<?php } ?>
        			</div>
        			<br>
        		<?php } ?>
        		
			</section>
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
				<?php if(Login::user()->id == $place->iduser){ ?>
    				<a class="button" href="/Place/edit/<?= $place->id ?>">Editar</a>
    			<?php } ?>	
    			<?php if(Login::user()->id == $photo->iduser || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){ ?>	
    				<a class="button" href="/Place/delete/<?= $place->id ?>">Borrar</a>
    			<?php } ?>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>