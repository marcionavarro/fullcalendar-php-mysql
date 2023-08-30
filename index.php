<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda FullCalendar 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/locales-all.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-md-12">
        <div id='calendar'></div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalEvent">
        Launch
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelTitleId">Modal Title</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" method="post">
                           <div class="mb-3">
                               <label for="id" class="form-label">ID:</label>
                               <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="ID:" />
                           </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título:" />
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="text" class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha:" />
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-label">Horario do Evento:</label>
                                <input type="time" class="form-control" name="hora" id="hora" aria-describedby="helpId" placeholder="Hora:" />
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição:</label>
                                <textarea class="form-control" name="descricao" id="descricao" rows="3" placeholder="descição:"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="cor" class="form-label">Cor:</label>
                                <input type="color" class="form-control" name="cor" id="cor" aria-describedby="helpId" placeholder="cor:" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button"  onclick="addEvent()" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

<script>
    var modalEvent
    modalEvent = new bootstrap.Modal(document.getElementById('modalEvent'), {keyboard: false})

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            //initialView: 'dayGridMonth',
            locale: "pt",
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dateClick: function (information) {
                alert("Pressionado " + information.dateStr);
                modalEvent.show();
            },
            events: "api.php"
        });
        calendar.render();
    });
</script>
<script>
    function addEvent(){
        var event = new FormData();
        event.append("id", document.getElementById('id').value);
        event.append("titulo", document.getElementById('titulo').value);
        event.append("fecha", document.getElementById('fecha').value);
        event.append("hora", document.getElementById('hora').value);
        event.append("descricao", document.getElementById('descricao').value);
        event.append("cor", document.getElementById('cor').value);

        for(var value of event.values()){
            console.log(value)
        }

    }
</script>

</body>
</html>
