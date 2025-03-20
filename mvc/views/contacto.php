<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Contacto</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Contacta con el admin en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Contacto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Contacto' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<div class="flex-container gap2">
				<section class="flex1">
					<h2>Contacto</h2>
					<p>Utiliza el formulario de contacto para enviar un mensaje
					al administrador de <?= APP_NAME ?>.</p>
					
					<form method="POST" action="/Contacto/send">
						<label>Email</label>
						<input type="email" name="email" required value="<?= old('email') ?>">
						<br>
						<label>Nombre</label>
						<input type="text" name="nombre" required value="<?= old('nombre') ?>">
						<br>
						<label>Asunto</label>
						<input type="text" name="asunto" required value="<?= old('asunto') ?>">
						<br>
						<label>Mensaje</label>
						<textarea name="mensaje" required><?= old('mensaje') ?></textarea>
						<div class="centered mt2">
							<input class="button" type="submit" name="enviar" value="Enviar">
						</div>
					
					</form>
				</section>
				
				<section class="flex1">
					<h2>Ubicación y mapa</h2>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5971.321923989072!2d2.05579800420538!3d41.55493755354365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a493650ae03931%3A0xee4ac6c8e8372532!2sCentre%20d&#39;Innovaci%C3%B3%20i%20Formaci%C3%B3%20Ocupacional%20(CIFO)%20de%20Sabadell!5e0!3m2!1ses!2ses!4v1741026731107!5m2!1ses!2ses"
						width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
						referrerpolicy="no-referrer-when-downgrade">
					</iframe>
					
					<h3>Datos</h3>
					<p><b>CIFO Sabadell</b> - Carretera Nacional 150 KM.15, 08227 Terrassa<br>
					Teléfono: 93 736 29 10<br>
					cifo_valles.soc@gencat.cat
					</p>
				</section>
			</div>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>