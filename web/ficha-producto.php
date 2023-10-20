<?php 
	@require_once "convertImageTmp.php";
	if($id_producto){
		$urlTmp = "producto/".sannedStr($titulo)."-".substr($id_producto, 3);
	?>
	<div class="row list-group">
		<div class="col-md-8 mx-auto p-0 list-group-item shadow-1 rounded" data-aos="fade-up" data-aos-duration="250" onclick="location.href = &#39;item.html&#39;">
			<div class="text-center p-2">
				<div class="row">
					<div class="col-md-3"><a class="list-product" href="#"><img data-bss-hover-animate="tada" class="producto list-product rounded" src="<?php echo $imagen_principal;?>" alt="titulo" height="160" width="160" alt="<?php echo $titulo;?>"></a></div>
					<div class="col text-start pt-3"><a href="<?php echo $urlTmp; ?>">
							<h2 class="text-capitalize fs-5 text-primary"><?php echo $titulo;?></h2>
						</a>
						<p class="fs-5 sombra mb-0">$<?php echo number_format($precio,0,",",".");?> <?php echo $currency_id;?></p>
						<?php if($precio >= 10000){?>
						<p class="text-success mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-truck fs-5 me-1"><path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path></svg> Consulta por Envío gratis</p>
						<?php }?>
						<div data-aos="zoom-in-left" data-aos-duration="1500" data-aos-delay="350" class="my-3">
							<div class="btn-group botones" role="group"><a class="btn btn-primary rounded" role="button" href="<?php echo $urlTmp; ?>">Ver Detalles</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }?>