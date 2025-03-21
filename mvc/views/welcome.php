<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Portada') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1>Disfruta y comparte</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
			  incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
			  ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    		<section>
    			<h2>Últimas fotos publicadas</h2>
    			
    			<div class="gallery w75 centered-block my2">
    				<?php foreach($photos as $photo){ ?>
          				<figure class="medium card pointer">
          					<a href="/Photo/show/<?= $photo->id ?>">
          						<img src="<?=PHOTO_IMAGE_FOLDER.'/'.$photo->file?>">
          					</a>	
          					<figcaption><?= $photo->placename?>
          					
          					</figcaption>
          				</figure>
					<?php } ?>	
						
    				</div>
        	</section>
		   	</div>   
		</main>
		
		<!-- este mapa web solamente se muestra en pantallas grandes -->
		<nav class="web-map pc">  
		<h2>Links</h2>
		
    	<ul class="flex-container">   		
    		<li class="flex1"><a href="#">Recursos</a>
    			<ul>
	    			<li><a href="https://github.com/robertsallent/fastlight">GitHub</a></li>
	    			<li><a href="#">Docs (TODO)</a></li>
	    			<li><a href="#">API (TODO)</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="/example">Maquetación</a>
    			<ul>
	    			<li><a href="/example/buttons">Buttons</a></li>
	    			<li><a href="/example/forms">Forms</a></li>
	    			<li><a href="/example/modals">Modals</a></li>
	    			<li><a href="/example">...</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Ejemplos de clase</a>
    			<ul>
	    			<li><a href="https://larabikes8.robertsallent.com">Larabikes <code>(Laravel)</code></a></li>
	    			<li><a href="https://symfofilms.robertsallent.com">SymfoFilms <code>(Symfony)</code></a></li>
	    			<li><a href="https://biblio24.robertsallent.com">Biblio24 <code>(FastLight)</code></a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Otros proyectos</a>
    			<ul>
	    			<li><a href="https://juegayestudia.com">Juega y Estudia</a></li>
    			</ul>
    		</li>
    		
    		
    	</ul>
    </nav>
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

