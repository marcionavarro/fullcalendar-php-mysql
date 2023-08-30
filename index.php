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
                    <h4 class="modal-title" id="modelTitleId">Dados do evento</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" method="post">
                            <div class="mb-3 visually-hidden">
                                <label for="id" class="form-label">ID:</label>
                                <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId"
                                       placeholder="ID:"/>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Título:</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       aria-describedby="helpId" placeholder="Título:"/>
                            </div>

                            <div class="mb-3 visually-hidden">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="text" class="form-control" name="fecha" id="fecha"
                                       aria-describedby="helpId" placeholder="Fecha:"/>
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-label">Horario do Evento:</label>
                                <input type="time" class="form-control" name="hora" id="hora" aria-describedby="helpId"
                                       placeholder="Hora:"/>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição:</label>
                                <textarea class="form-control" name="description" id="description" rows="3"
                                          placeholder="Descrição:"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Cor:</label>
                                <input type="color" class="form-control" name="color" id="color"
                                       aria-describedby="helpId"
                                       placeholder="color:"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="delEvent()" class="btn btn-danger" id="btnDeletar"
                            data-bs-dismiss="modal">deletar
                    </button>
                    <button type="button" onclick="addEvent()" class="btn btn-primary" id="btnSalvar">Salvar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

<script>
    var modalEvent;
    var calendar;

    modalEvent = new bootstrap.Modal(document.getElementById('modalEvent'), {keyboard: false});

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            //initialView: 'dayGridMonth',
            locale: "pt",
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dateClick: function (information) {
                clearForm(information.dateStr);
                modalEvent.show();
            },
            eventClick: function (information) {
                modalEvent.show();
                recoverDataEvent(information.event);
            },
            events: "api.php"
        });
        calendar.render();
    });
</script>
<script>
    function recoverDataEvent(event) {
        clearErrors()

        var fecha = event.startStr.split("T");
        var hora = fecha[1].split(":")

        document.getElementById('id').value = event.id;
        document.getElementById('title').value = event.title;
        document.getElementById('description').value = event.extendedProps.description;
        document.getElementById('color').value = event.backgroundColor;
        document.getElementById('fecha').value = fecha[0];
        document.getElementById('hora').value = hora[0] + ':' + hora[1];

        document.getElementById('btnDeletar').removeAttribute('disabled','');
        document.getElementById('btnSalvar').removeAttribute('disabled','');
    }

    function delEvent() {
        sendDataApi('delete');
    }

    function addEvent() {
        if(document.getElementById('title').value==""){
            document.getElementById('title').classList.add('is-invalid');
            return true;
        }

        var action = (document.getElementById('id').value == 0) ? 'create' : 'update';
        console.log(action);
        sendDataApi(action);
    }

    function sendDataApi(action) {
        fetch("api.php?action=" + action, {
            method: "POST",
            body: reconnectData()
        }).then(data => {
            calendar.refetchEvents();
            modalEvent.hide();
        }).catch(error => console.log(error));
    }

    function reconnectData() {
        var event = new FormData();
        event.append("id", document.getElementById('id').value);
        event.append("title", document.getElementById('title').value);
        event.append("fecha", document.getElementById('fecha').value);
        event.append("hora", document.getElementById('hora').value);
        event.append("description", document.getElementById('description').value);
        event.append("color", document.getElementById('color').value);
        return event;
    }

    function clearForm(fecha) {
        clearErrors();
        document.getElementById('id').value = "";
        document.getElementById('title').value = "";
        document.getElementById('fecha').value = fecha;
        document.getElementById('hora').value = "12:00";
        document.getElementById('description').value = "";
        document.getElementById('color').value = "";
        document.getElementById('btnDeletar').setAttribute('disabled','disabled');
    }

    function clearErrors(){
        document.getElementById('title').classList.remove('is-invalid');
    }
</script>

</body>
</html>
