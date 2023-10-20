<footer class="bg-primary-gradient">
		<div class="container py-4">
			<div class="text-muted d-flex justify-content-center">
				<p class="mb-0 sombra"><span class="fw-bold">Web Electro</span>&nbsp;© 2023<a class="m-1" href="/login.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cloud-fill"><path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"></path></svg></a></p>
				<a data-bs-toggle="tooltip" data-bss-tooltip="" class="sombra" href="https://www.pexcreative.com/desarrollo-de-apps/" target="_blank" rel="license" title="Desarrollo profesional 🏆">Desarrollo web por&nbsp;<span class="fw-semibold text-primary">Pex Creative</span></a>
            </div>
        </div>
    </footer>

<div class="d-inline justify-content-center align-items-center boton-buscar bg-warning p-3 rounded-circle producto-relacionado py-3 px-4 bg-dark text-white" data-bs-toggle="modal" data-bs-target="#buscar"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg></div>
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
			<input class="form-control" required type="text" name="s" id="s" onkeypress="return runScript(event)" autofocus onkeyup="setInfo(this);" autocomplete="off">
			<button class="btn btn-primary search-image" type="submit" id="search-image"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-search me-1"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg></button>
		</div>

        <ul class="list-group d-none" id="containerSuggest"></ul>

      </div>
    </div>
  </div>
</div>
	
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/aos.js"></script>
    <script src="/assets/js/bs-init.js"></script>
    <script src="/assets/js/bold-and-bright.js"></script>
	<script src="/assets/js/lightbox-plus-jquery.min.js"></script>
	
	<script>
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
				url: 'server/',
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
	</script>

<script src='https://app.pexsell.com/js/486fe5ffbd1f01ba5d424c22be70ea3d.js'></script>
	
</body>

</html>