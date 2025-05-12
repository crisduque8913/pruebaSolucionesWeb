<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Lista de Eventos</h2>

        <!-- Mostrar tabla de eventos -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nombre evento</th>
                    <th>Fecha</th>
                    <th>Ubicación</th>
                    <th>Boletos</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="eventosTableBody"></tbody>
        </table>


        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control mb-2" name="nombre" placeholder="Nombre">
                            <label for="fecha">Fecha</label>
                            <input type="datetime" class="form-control mb-2" name="fecha">
                            <label for="ubicacion">Ubicacion</label>
                            <input type="text" class="form-control mb-2" name="ubicacion" placeholder="Ubicacion">
                            <label for="numboletos">Numero de boletos</label>
                            <input type="number" class="form-control mb-2" name="numboletos"
                                placeholder="Numero boletos">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control mb-2" name="precio" placeholder="Precio">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <a href="{{route('mostrarformulario')}}" class="btn btn-primary" role="button">Agregar</a>


        <h4 class="mt-5">Eventos comprados</h4>
            <ul id="eventosComprados" class="list-group"></ul>



        
        <script>
            
            const API_URL = 'http://localhost:8000/api/eventos'; // url API
            const params = new URLSearchParams(window.location.search);

            if(params.has('success') && params.get('success') ==='true'){
                document.getElementById('mensaje').innerHTML = '<div class="alert alert-success">Evento creado</div>';
            }

            // Mostrar eventos
            function fetchEventos() {
                fetch(API_URL)
                    .then(res => res.json())
                    .then(data => {
                        const body = document.getElementById('eventosTableBody');
                        body.innerHTML = '';
                        data.forEach(evento => {
                            body.innerHTML += `
                    <tr>
                        <td>${evento.nombre}</td>
                        <td>${evento.fecha}</td>
                        <td>${evento.ubicacion}</td>
                        <td>${evento.numboletos}</td>
                        <td>${evento.precio}</td>
                        <td style="text-align: center; vertical-align: middle;">
                            <button class="btn btn-warning btn-sm" onclick='openEditModal(${JSON.stringify(evento)})'>Editar</button>
                            <button class="btn btn-danger btn-sm" onclick='eliminarEvento(${evento.id})'>Eliminar</button>
                            <button class="btn btn-success btn-sm" onclick='comprarboleto(${JSON.stringify(evento)})'>Comprar</button>

                        </td>
                    </tr>
                `;
                        });
                    });
            }


            //eliminacion del evento
            function eliminarEvento(id) {
                fetch(`${API_URL}/${id}`, {
                    method: 'DELETE'
                }).then(() => fetchEventos());
            }

            //compra de boletos
            function comprarboleto(evento) {
                if(evento.numboletos <=0){
                    alert("No hay boletos disponibles");
                    return;
                }

                const formData = new FormData();
                formData.append("nombre",evento.nombre);
                formData.append("fecha",evento.fecha);
                formData.append("ubicacion",evento.ubicacion);
                formData.append("numboletos",evento.numboletos -1);
                formData.append("precio",evento.precio);

                fetch(`${API_URL}/${evento.id}`,{
                    method: 'POST',
                    headers:{'X-HTTP-Method-override': 'PUT'},
                    body:formData
                }).then(response =>{
                    if(response.ok){
                        const lista  = document.getElementById('eventosComprados');
                        const item = document.createElement('li');
                        item.className = "list-group-item";
                        item.style.color="green";
                        item.textContent = `${evento.nombre} - ${evento.fecha} -${evento.ubicacion}`;
                        lista.appendChild(item);

                        fetchEventos();
                    }
                })

            }

            // modal bootsrap para edicion del evento
            function openEditModal(evento) {
                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                const form = document.getElementById('editForm');
                form.id.value = evento.id;
                form.nombre.value = evento.nombre;
                form.fecha.value = evento.fecha;
                form.ubicacion.value = evento.ubicacion;
                form.numboletos.value = evento.numboletos;
                form.precio.value = evento.precio;
                modal.show();
            }

            //Actualizar el evento
            document.getElementById('editForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const id = this.id.value;
                const formData = new FormData(this);
                fetch(`${API_URL}/${id}`, {
                    method: 'POST',
                    headers: { 'X-HTTP-Method-Override': 'PUT' },
                    body: formData
                }).then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    fetchEventos();
                });
            });

            fetchEventos();
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>