<style>

</style>
<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="" id="tituloModal"></h2>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12">
                            <h4>Descripcion</h4>
                        </div>
                        <div class="col-12">
                            <p id='descripcion'></p>
                        </div>
                        <div class="col-12">
                            <h4>Fecha</h4>
                        </div>
                        <div class="col-12">
                            <p id='fecha'></p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div id="mapa" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('scriptCustom')
    <script>
        function abrirModal(evento) {

            document.getElementById('tituloModal').innerText = evento.titulo;
            document.getElementById('descripcion').innerText = evento.descripcion;
            document.getElementById('fecha').innerText = evento.fecha;
            const [lat, lng] = evento.long_lat.split(',');
            const mapa = document.getElementById('mapa');
            mapa.innerHTML = `
                <iframe
                width="100%"
                height="100%"
                frameborder="0"
                style="border:0"
                referrerpolicy="no-referrer-when-downgrade"
                
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAcVeZ7UhhDoPoMZWIYc-6GCB6JoZ9OvBs&q=${lat},${lng}&zoom=15"
                allowfullscreen>
                </iframe>
            `;

            // Mostrar el modal con Bootstrap
            var myModal = new bootstrap.Modal(document.getElementById('modalInfo'));
            myModal.show();
        }
    </script>
@endsection
