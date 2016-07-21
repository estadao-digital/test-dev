<?php require_once('url.php') ?>
<!DOCTYPE html>
<html lang="en">
<?php include("apoio/head.php");?>
<body>
	<section id="header-v1-banner">
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="blue">Cadastro</h1>
					<h1 class="red">de Carros</h1>
				</div>
			</div>
		</div>
	</section>
	<?php 
		include $pasta.'/'.$pagina.'.php'; ?>
	<script src="js/jquery.min.js"></script> <!-- jQuery JS -->
	<script src="js/bootstrap.min.js"></script> <!-- BootStrap JS -->
	<script src="js/wow.js"></script> <!-- WOW JS -->
	<script src="js/isotope.pkgd.min.js"></script> <!-- iSotope JS -->
	<script src="js/owl.carousel.min.js"></script> <!-- OWL Carousle JS -->
	<script src="js/jquery.themepunch.tools.min.js"></script> <!-- Revolution Slider Tools -->
	<script src="js/jquery.themepunch.revolution.min.js"></script> <!-- Revolution Slider -->
	<script src="js/jquery.fancybox.pack.js"></script> <!-- FancyBox -->
	<script src="js/validate.js"></script> <!-- Form Validator JS -->
	<script src="js/jquery.easing.min.js"></script> <!-- jquery easing JS -->
	<script src="js/custom.js"></script> <!-- Custom JS -->

</body>
</html>