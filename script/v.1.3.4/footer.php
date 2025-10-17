<footer class="bg-primary-gradient">
		<div class="container py-4">
			<div class="text-muted d-flex justify-content-center">
				<p class="mb-0 sombra"><span class="fw-bold"><?php echo $empresa;?></span>&nbsp;© 2023 <a data-bs-toggle="tooltip" data-bss-tooltip="" class="m-2" title="v.<?php echo $shopVersion; ?>" href="/login.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cloud-fill"><path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"></path></svg></a></p>
				<a data-bs-toggle="tooltip" data-bss-tooltip="" class="sombra" href="https://www.pexcreative.com/desarrollo-de-apps/" target="_blank" rel="license" title="Desarrollo profesional 🏆">Desarrollo web por&nbsp;<span class="fw-semibold text-primary">Pex Creative</span></a>
            </div>
        </div>
    </footer>

<div class="d-inline justify-content-center align-items-center boton-buscar bg-warning p-3 rounded-circle producto-relacionado py-3 px-4 bg-dark text-white" data-bs-toggle="modal" data-bs-target="#buscar"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg></div>
    <?php if($activeCart): ?>
        <div class="d-inline justify-content-center align-items-center btn-cart d-none bg-warning p-3 rounded-circle producto-relacionado py-3 px-4 bg-dark text-white" data-bs-toggle="modal" data-bs-target="#md-cart">
            <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px" viewBox="0 0 902.86 902.86" xml:space="preserve" stroke="#ffffff">

            <g id="SVGRepo_bgCarrier" stroke-width="0"/>

            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

            <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z"/> <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717 c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744 c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742 C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744 c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742 S619.162,694.432,619.162,716.897z"/> </g> </g> </g>

            </svg>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cantPr">
                
            </span>
        </div>

            

    <?php endif; ?>
<!-- Modal -->
<div class="modal fade" id="buscar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">¿Qué estás buscando?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<div class="input-group">
			<input class="form-control"  type="text" name="s" id="s" onkeypress="return runScript(event)" autofocus autocomplete="off">
			<button class="btn btn-primary search-image" type="submit" id="search-image"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search me-1"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg></button>
		</div>

        <ul class="list-group d-none" id="containerSuggest"></ul>

      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="mdMsg" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Información</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar ventana</button>
                </div>
            </div>
        </div>
    </div>

    <?php if($activeCart): ?>
        <div class="modal fade" id="md-cart" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Carrito de compra</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group"></ul>
                        <div class="text-end pt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir comprando</button>
                        <a class="btn btn-primary" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/comprar.php?b=1">Finaliza compra</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
	
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/aos.js"></script>
    <script src="/assets/js/bs-init.js"></script>
    <script src="/assets/js/bold-and-bright.js"></script>
	<script src="/assets/js/lightbox-plus-jquery.min.js"></script>
	
	<script>
        var mdMsg = new bootstrap.Modal(document.getElementById('mdMsg'));
        var pcrt = localStorage.getItem('pcrt');
        var prs = [];
        var total = 0;
        if(pcrt && pcrt != "") {
            prs = JSON.parse(pcrt);
            if(prs.length > 0) {
                $(".btn-cart").removeClass("d-none");
                var exist = false;
                var html = "";
                prs.forEach(function(pr) {
                    if(pr.p == $(".addToCart").attr("d-p")) {
                        exist = true;
                    }
                    var cl = pr.cl;
                    var tl = pr.tl;
                    html += `
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/producto/-${pr.p.substr(3)}">${pr.t} (${cl} ${tl})</a></div>
                            Precio: ${pr.pr}
                        </div>
                        <a href="javascript: void(0);" d-p="${pr.p}" onclick="removeItemCart(this);">x</a>
                    </li>
                    `;
                    total += parseFloat(pr.prc);
                });
                $("#md-cart .list-group").html(html);
                $("#cantPr").html(prs.length);
                $("#md-cart .text-end").html(`Total: $${total.toFixed(2)}`);
                if(exist) {
                    //$(".addToCart").text("QUITAR DEL CARRITO");
                }
            }
        }
        function removeItemCart(el) {
            $(el).closest("li").remove();
            var tmp = [];
            var found = false;
            prs.forEach(function(pr) {
                if(pr.p != $(el).attr("d-p")) {
                    tmp.push(pr);
                }
                else {
                    if(!found) {
                        found = true;
                        total -= parseFloat(pr.prc);
                    }
                    else {
                        tmp.push(pr);
                    }
                    /*if($(".addToCart").length > 0) {
                        if($(".addToCart").attr("data-p") == pr.p) {
                            $(".addToCart").text("AGREGAR AL CARRITO");
                        }
                    }*/
                    
                }
            });
            prs = tmp;
            $("#cantPr").html(prs.length);
            if(tmp.length == 0) {
                $(".btn-cart").addClass("d-none");
                $("#md-cart .btn-close").trigger("click");
                /*if($(".addToCart").length > 0) {
                    $(".addToCart").text("AGREGAR AL CARRITO");
                }*/
            }
            $("#md-cart.text-end").html(`Total: $${total.toFixed(2)}`);
            localStorage.setItem('pcrt', JSON.stringify(prs));
        }
        $(".addToCart").click(function(){
            /*if($(this).text() == "QUITAR DEL CARRITO") {
                removeItemCart(this);
                $(this).text("AÑADIR AL CARRITO");
            }
            else {*/
                //$(this).text("QUITAR DEL CARRITO");
                $(".btn-cart").removeClass("d-none");
                var tl = $(".talleArr").length > 0 ? $(".talleArr").val() : "";
                var cl = $(".colorsArr").length > 0 ? $(".colorsArr").val() : "";
                prs.push({
                    p: $(this).attr("d-p"),
                    t: $(this).attr("d-t"),
                    pr: $(this).attr("d-pr"),
                    prc: $(this).attr("d-prc"),
                    tl: tl,
                    cl: cl,
                    un: $(".unitsArr").length > 0 ? $(".unitsArr").val() : ""
                });
                localStorage.setItem('pcrt', JSON.stringify(prs));
                $("#md-cart .list-group").append(`
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/producto/-${$(this).attr("d-p").substr(3)}">${$(this).attr("d-t")} (${cl} ${tl})</a></div>
                            Precio: ${$(this).attr("d-pr")}
                        </div>
                        <a href="javascript: void(0);" d-p="${$(this).attr("d-p")}" onclick="removeItemCart(this);">x</a>
                    </li>
                `);
                total += parseFloat($(this).attr("d-prc"));
                $("#md-cart .text-end").html(`Total: $${total.toFixed(2)}`);
                $("#cantPr").html(prs.length);
            //}
        });
        function getURL() {
            $.ajax({
                type: 'POST',
                url: '/index.php',
                data: 's='+$("#s").val(),
                dataType: 'json',
                success: function(data) {
                    window.location.assign(`/productos/${data.k}/`);
                }
            });
        }

        function sK() {
            getAjax(uapp, 'GET', '&q='+getValue("s")+'&opt=query', function(result) {  });
        }

		function runScript(e) {
			if (e.keyCode == 13) {
                sK();
				getURL();
				return false;
			}
		}
		$(".search-image").click(function(e) {
            getURL();
		});
		function writeInput (e) {
			$("#containerSuggest").html("").addClass("d-none");
			$("#s").val(e);
            sK();
            getURL();
		}

		function setInfo (e) {
            if(e.value != "") {
                $.ajax({
                    type: 'POST',
                    url: '/index.php',
                    data: 's='+e.value,
                    dataType: 'json',
                    success: function(data) {
                        $("#containerSuggest").html("").addClass("d-none");
                        if(data.r && data.r != null) {
                            if(data.r.suggested_queries.length > 0) {
                                var html = '';
                                for(var i = 0; i < (data.r.suggested_queries.length > 7 ? 7 : data.r.suggested_queries); i++){
                                    html += `<li class="list-group-item" onclick="javascript: writeInput('${data.r.suggested_queries[i].q}');">${data.r.suggested_queries[i].q}</li>`;
                                }
                                /*data.r.suggested_queries.forEach(function(q) {
                                    html += `<a href="javascript: writeInput('${q.q}');"><div>${q.q}</div></a>`;
                                });*/
                                $("#containerSuggest").html(html).removeClass("d-none");
                            }
                        }
                    }
                });
            }
			else {
                $("#containerSuggest").html("").addClass("d-none");
            }
		}
        $( document ).ready(function() {
            console.log( "ready!" );

            $(document).on('input', '#s', function() {
                setInfo(this);
            });

            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
                });
        });
		function logout() {
			$(".session-user").remove();
			$('a[data-bs-target="#mdEdit"]').remove();
			$.ajax({
				type: 'POST',
				url: '/server/',
				data: 'o=4',
				dataType: 'json',
				success: function(data) {
					var title = $("#titleForm").val();
					var desc = $("#descForm").val();
					$(".titleLabel").html(title);
					$(".descLabel").html(desc);
					$("#saveInfo").attr("disabled", false);
					$("#saveInfo").removeClass("disabled");
					$(".closeModal").trigger("click");
					$("#titleForm").val(title).attr("placeholder", title);
					$("#descForm").val(desc).attr("placeholder", desc);
				}
			});
		}
        setInterval(() => {
            $.ajax({
                type: 'POST',
                url: '/server/',
                data: 'o=5',
                dataType: 'json',
                success: function(data) {
                    
                }
            });
        }, 300 * 1000);
        function upds() {
            $("#mdMsg .modal-body").html("Descargando datos y procesando, por favor espere, esta opcion podria demorar unos min, se le notificara cuando el proceso haya terminado");
            mdMsg.show();
            
            $.ajax({
                type: 'POST',
                url: '/server/',
                data: 'o=6',
                //dataType: 'json',
                success: function(data) {
                    $("#mdMsg .modal-body").html("El proceso ha terminado con exito, se recargara la pagina automaticamente luego de 10 segundos para cargar los nuevos cambios");
                    mdMsg.show();
                    setTimeout(() => {
                        window.location.reload();
                    }, 10000);
                }
            });
        }
	</script>

<script src='https://app.pexsell.com/js/<?php echo isset($cdn) ? $cdn : ""; ?>.js'></script>

    <?php if(isset($_REQUEST['b']) && $_REQUEST['b'] != ""): ?>
        <script>

            function sannedText(text) {
                let textWA = text.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                let textSanned = textWA.replace(/[^\w\s]/gi, "");
                return textSanned;
            }

            $("#enviar_compra").removeAttr("id").attr("id", "enviar_compra2");
            if (document.getElementById("enviar_compra2")) {
                document.getElementById("enviar_compra2").addEventListener("click", function(e) {
                    var sendForm = true;
                    document.querySelectorAll('input[required]').forEach(function(element) {
                        if (element.value == "") {
                            sendForm = false;
                        }
                    });
                    if (!isValidEmail(getValue("email"))) {
                        sendForm = false;
                        document.getElementById("ok").innerHTML = "Correo electronico invalido";
                        document.getElementById("ok").classList.add("error");
                    }
                    if (!verifyMessage()) {
                        sendForm = false;
                        e.preventDefault()
                    }
                    if (sendForm) {
                        e.preventDefault();
                        labelQuery = document.getElementById("enviar_compra2").value;
                        document.getElementById("enviar_compra2").value = "Procesando...";
                        document.getElementById("enviar_compra2").disabled = true;

                        var tmpArr = [];
                        prs.forEach(function(pr) {
                            pr.t = sannedText(pr.t);
                            tmpArr.push(pr);
                        });

                        getAjax(uapb, 'GET', '&name=' + getValue("nombre") + '&last_name=' + getValue("apellido") + '&email=' + getValue("email") + '&cantidad=' + getValue("cantidad") + '&message=' + getValue("mensaje") + '&entrecalle2=' + getValue("entrecalle2") + '&entrecalle1=' + getValue("entrecalle1") + '&product=' + skk + '&ref=' + getValue("ref") + '&price=' + getValue("pricep") + '&name_product=' + getValue("namep") + '&idpost=' + getValue("idpost") + "&conocio=" + getValue("conocio") + "&numb=" + getValue("tel") + "&city=" + getValue("ciudad") + "&code=" + getValue("cp") + "&street=" + getValue("calle") + "&strc=" + getValue("numerocasa") + "&method_pay=" + getValue("mediopago") + "&reff=" + window.location.hostname + '&idpp=' + idpp + `&prs=${JSON.stringify(tmpArr)}`, function(result) {
                            console.log(result);
                            if (document.getElementById("ok")) {
                                document.getElementById("ok").classList.remove("success");
                                document.getElementById("ok").classList.remove("error");
                                localStorage.removeItem("pcrt");
                            }
                            document.getElementById("enviar_compra2").disabled = false;
                            document.getElementById("enviar_compra2").value = labelQuery;
                            if (result.response.msg == "OK") {
                                if (document.getElementById("ok")) {
                                    document.getElementById("ok").innerHTML = "Gracias por tu compra, por favor revisa tu email.";
                                    document.getElementById("ok").classList.add("success");
                                    document.getElementById("form_compra").style.display = "none";
                                }
                                var inputs = document.getElementsByTagName('input');
                                for (index = 0; index < inputs.length; ++index) {
                                    inputs[index].value = "";
                                }
                                document.getElementById("mensaje").value = "";
                            } else {
                                if (document.getElementById("ok")) {
                                    document.getElementById("ok").innerHTML = result.response.msg;
                                    document.getElementById("ok").classList.add("error");
                                }
                            }
                            document.getElementById("enviar_compra2").value = labelQuery;
                        });
                    }
                }, false);
            }
        </script>
    <?php endif ?>

	
</body>

</html>