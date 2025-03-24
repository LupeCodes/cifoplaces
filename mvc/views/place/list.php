<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de lugares</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de lugares en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de lugares') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares' => 'Place/list'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de lugares</h2>
			<!-- FILTRO DE BUSQUEDA -->
				<?php 
				//si hay filtro guardado en sesion...
				if($filtro){
				    //pone el formulario de "quitar filtro"
				    //el metodo removeFilterForm necesita conocer el filtro
				    //y la ruta a la q se envia el formulario
				    echo $template->removeFilterForm($filtro, '/Place/list');
				//y si no hay filtro guardado en sesion...    
				}else{
				    //pone el formulario de nuevo filtro
				    echo $template->filterForm(
				    
				        //lista de campos para el desplegable buscar en
				         [
				            'Nombre'        => 'name',
				            'Localizacion'  => 'location',
				            'Tipo'          => 'type'
				        ],
				        //lista de campos para el plesplegable ordenado por 
    				    [
    				        'Nombre'        => 'name',
    				        'Localizacion'  => 'location',
    				        'Tipo'          => 'type'
    				    ],
    				    //valor por defecto para buscar en
    				    'Nombre',
    				    //valor por defecto para ordenado por
    				    'Nombre'
				    );
				}
				?>
			<?php if ($places){ ?>
				
			
				<!-- Enlaces creados por el paginator -->
				<div class="right">
					<?= $paginator->stats() ?>
				</div>
        		<table class="table w100">
        			<tr>
        				<th>Foto Principal</th><th>Nombre</th><th>Tipo</th>
        				<th>Localizacion</th>
        				
        			</tr>
        			<?php foreach($places as $place){?>
        				<tr>
        					<td class="centrado">
        						<a href='/Place/show/<?=$place->id?>'>
        							<img src="<?=PLACE_IMAGE_FOLDER.'/'.$place->mainpicture?>"
        								class="table-image"
        								title="Portada de <?=$place->mainpicture?>">
        						</a>
        					</td>
        					<td><a href='/Place/show/<?=$place->id?>'><?=$place->name?></a></td>
        					<td><?=$place->type?></td>
        					<td><?=$place->location?></td>
        					    
        					
        				</tr>
        			<?php } ?>
        		</table>
        		<?= $paginator->ellipsisLinks() ?>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay lugares que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>