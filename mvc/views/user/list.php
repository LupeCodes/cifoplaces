<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de usuarios en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de usuarios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuarios' => 'Usuario/list'
		]) ?>
		<?= $template->messages() ?>
		
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista de usuarios</h2>
			
			<?php //dd($users);?>
			<?php //esto es una prueba, y vamos viendo 
			//foreach($user->roles as $valor){
			  //  echo "$valor"
			//}?>
			
			<?php if($users){ ?>
				<table class="table w100">
					<tr>
						<th>Foto</th>
						<th>ID</th>
						<th>Nombre</th>
						<th>eMail</th>
						<th>Telefono</th>
						<th>Roles</th>
						<th>Operaciones</th>
					</tr>
					
					<?php foreach($users as $user){?>
						<tr>
							<td><img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
        								class="table-image"></td>
							<td><?= $user->id ?></td>
							<td><?= $user->displayname ?></td>
							<td><?= $user->email ?></td>
							<td><?= $user->phone ?></td>
							<td><?php foreach($user->roles as $valor){
							    echo $valor.' ';
							} ?></td>
							<td><a href='/User/show/<?=$user->id?>'>Ver</a>
								<a href='/User/edit/<?=$user->id?>'>Editar</a>
							</td>
						</tr>
					<?php } ?>
				
				</table>
				
			<?php }else{?>
				<div class="danger p2">
					<p>No hay usuarios que mostrar.</p>
				</div>
			<?php } ?>
			
			<div class="centered">
				<a class="button" onclick="history.back()">Atrás</a>
			</div>
		
		</main>	
		<?= $template->footer() ?>	
	</body>
</html>