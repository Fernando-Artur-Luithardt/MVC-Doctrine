<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Scrips -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="container rounded overflow-auto overflow-x-hidden tittle-agendamentos">Altere horários dias futuros</div>
        </div>
        <div class="col-1"></div>
        <div class="col-1"></div>
        <div class="col-10">
            <div class="container container-funcionamento rounded overflow-auto overflow-x-hidden">
                <div class="accordion">

                </div>
            </div>
            <div class="container" style="margin-top: 12px;">
                <button type="button" class="btn btn-success {{$cron['valor'] ? 'd-none' : ''}}" id="gerarNovaPessoa">Nova pessoa</button>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        function getHorariosFuturos(){
            $.getJSON(`/getPessoas`, function(dados){
                $('.row-horario-futuros').remove()

                if(Object.keys(dados).length === 0){
                    $('.accordion').append(`
                        <div class="accordion-item row-horario-futuros text-center" style="margin: 8px;">
                            Defina horários em configurações e serviços para cada barbeiro
                        </div>
                    `)
                }
                for (var data in dados) {
                    let item = dados[data];

                    if($(document).find(`.row-horario-futuros [idPessoa="${item.id}"]`)[0] == undefined){
                        $('.accordion').append(`
                            <div class="accordion-item row-horario-futuros" idPessoa="${item.id}" loaded="0">
                                <h2 class="accordion-header" id="panelsStayOpen-heading-${item.id}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-${item.id}" aria-expanded="false" aria-controls="panelsStayOpen-${item.id}">
                                        ${item.nome}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-${item.id}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-${item.id}">
                                    <div class="accordion-body">
                                        <button type="button" class="btn btn-info novo-contato" style="margin-bottom: 14px;">Novo contato</button>
                                        <button type="button" class="btn btn-danger remover-pessoa" style="margin-bottom: 14px;">Remover pessoa</button>
                                        <div class="contatos-pessoa overflow-auto overflow-y-hidden container" style="max-height: 20vh;">
                                            <div class="row turno-dia" style="position: sticky; top: 0;">
                                                <div class="col-6">
                                                    Tipo
                                                </div>
                                                <div class="col-6">
                                                    Contato
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    }
                }
                let contador = 0;
                $(document).find('.accordion-item').each(function() {
                    if (contador < 3) {
                        getContatos($(this));
                        contador++;
                    }
                })
            })
        }
        getHorariosFuturos()

        $(document).on('click', '.accordion-item', function(){getAgendamentos($(this))})
        function getContatos(row){
            let idPessoa = row.attr('idPessoa')
            if(row.attr('loaded') == 0){
                $.getJSON(`/getContatos?idPessoa=${idPessoa}`, function(data){
                    data?.forEach(function(item){
                        row.find('.contatos-pessoa').append(`
                            <div class="row contatos-salvos" style="margin-top: 8px;" contatoId="${item.id}">
                                <div class="col-6">
                                    <select class="form-control tipo-contato">
                                        <option value="0">Telefone</option>
                                        <option value="1">Email</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input value="${item.descricao}" class="descricao-contato form-control"></input>
                                </div>
                            </div>
                        `)
                    })

                    $(document).find(`[contatoId="${item.id}"]`)
                    if(data.length == 0){
                        row.find('.contatos-pessoa').append(`
                            <div class="row contatos-salvos ignore" style="margin-top: 8px;">
                                <div class="col-12 text-center" style="margin-top: 16px;">
                                    Nenhum contato encontrado
                                </div>
                            </div>
                        `)
                    }
                    row.attr('loaded', '1')
                })
            }
        }
    })
</script>