<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Creacion de eventos</title>
</head>



<div class="container mt-5">
    <h3>Agregar Evento</h3>

    <body>


        <form id="eventoForm">
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre" placeholder="Digite el nombre del evento"
                    required>
            </div>
            <div class="mb-3">
                <input type="datetime-local" class="form-control" name="fecha" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="ubicacion" placeholder="Ubicación">
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="numboletos" placeholder="BoletosTotales" required>
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="precio" placeholder="Precio">
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
             <a href="{{route('mostrarEventos')}}" class="btn btn-danger" role="button">cancelar</a>
        </form>
</div>
</div>

<script>
    const API_URL = 'http://localhost:8000/api/eventos';
    const REDIRECT_URL='welcome.blade.php?success=true';

    document.getElementById('eventoForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(API_URL, {
            method: 'POST',
            body: formData
        }).then(() => {
            window.location.href = REDIRECT_URL;
            // this.reset();
            // fetchEventos();
        }).catch(error =>{
            alert('Error al crear el evento' + error.message);
        });
    });

    fetchEventos();//acceso a canales HTTP

</script>
</body>

</html>