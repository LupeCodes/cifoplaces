<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo usuario</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="nuevo usuario en <?= APP_NAME ?>">
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
		<?= $template->header('Nuevo Usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuarios' => '/Usuario/list',
		    'Nuevo Usuario' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			
			<section id="new-user">
    			<h2>Nuevo usuario</h2>
    			
    			<div class="flex-container">
    				<form method="POST" enctype="multipart/form-data" 
    					class="flex2 no-border" action="/User/update">
    					
    					<label>Nombre</label>
    					<input type="text" name="displayname" value="<?= $user->displayname ?>">
    					<br>
    					<label>Email</label>
    					<input type="email" name="email" id="inputEmail" value="<?= $user->email ?>">
    					<span id="comprobacion" class='info'></span>
    					<br>
    					<label>Telefono</label>
    					<input type="text" name="phone" value="<?= $user->phone ?>">
    					<br>
    					<label>Imagen de perfil</label>
    					<input type="file" name="picture" accept="image/*"
    							id="file-with-preview">
    					<br>
    					
    					<div class="centered mt3">
    						<input type="submit" class="button" name="guardar" value="Guardar">
    						<input type="reset" class="button" value="Reset">
    					</div>
    				</form>
    				
    				<figure class="flex1 centrado">
    					<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>" id="preview-image"
    							class="cover" alt="Previsualizacion de la imagen de perfil">
    					<figcaption>Previsualización de la imagen de perfil</figcaption>
    				</figure>
    				
    			</div>	
    				
    			<div>
    				<label>Añadir Rol</label>
    				<!-- 
    				   Este desplegable se genera a partir de la lista de
    				   roles indicados en el fichero config.php
    				   Añadid a esa lista el rol: 'Bibliotecario' => 'ROLE_LIBRARIAN'
    				   
    		
    				 -->
        				<select name="roles">
        				
        					<?php foreach(USER_ROLES as $roleName => $roleValue){?>
        				 		<option value="<?= $roleValue ?>"><?= $roleName ?></option>
        				 	<?php } ?>	
        				</select>
        				
    			</div>	
    				
    				
    			<div>
    				<table class="table w100">
        				<tr>
        					<th>ROL</th><th>Operaciones</th>
        				</tr>
        				<?php foreach($user->roles as $valor){?>
        				<tr>
        					<td><?=$valor?></td>
        					<td class="centrado">
        						<form method="POST" class="no-border" action="<?= $user->removeRole($valor) ?>">
        							<input type="hidden" name="rol" value="<?= $valor ?>">
        							<input type="submit" class="button-danger" name="removeRole" value="Borrar">
        						</form>
        					</td>
        				</tr>
        				<?php } ?>		
					</table>
    			</div> 
    					 
    					 
    				
    			
    				
    				
    			
		
			</section>	
		</main>
		<?= $template->footer() ?>
	</body>
</html>