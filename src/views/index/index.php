<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos</title>

    <!-- Fontes -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Scripts -->
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
        <div class="col-5">
            <div class="container rounded overflow-auto overflow-x-hidden tittle-agendamentos" style="margin-top: 10px;">
                <span>Pesquisar</span>
                <input class="form-control" id="find-pessoa" style="margin-bottom: 22px; margin-top: 16px;"></input>
            </div>
        </div>
        <div class="col-6"></div>
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
        function getPessoas(){
            $.getJSON(`/pessoas/getPessoas?filter=${$('#find-pessoa').val()}`, function(dados){
                $('.row-pessoa').remove()

                if(dados.length === 0){
                    $('.accordion').append(`
                        <div class="accordion-item row-pessoa text-center" style="margin: 10px;">
                            Nenhum contato disponível
                        </div>
                    `)
                }
                for (let data in dados) {
                    generatePessoa(dados[data])
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
        getPessoas()
        $(document).on('keyup', '#find-pessoa', () => {getPessoas()})

        $(document).on('click', '.accordion-item', function(){getContatos($(this))})
        function getContatos(row){
            let idPessoa = row.attr('idPessoa')
            if(row.attr('loaded') == 0){
                $.getJSON(`/contatos/getContatos?idPessoa=${idPessoa}`, function(data){
                    row.find('.contatos-salvos').remove()
                    data?.forEach(function(item){
                        generateContato(row, item)
                    })

                    if(data.length == 0){
                        row.find('.contatos-pessoa').append(`
                            <div class="row contatos-salvos ignore" style="margin-top: 10px;">
                                <div class="col-12 text-center" style="margin-top: 16px;">
                                    Nenhum contato encontrado
                                </div>
                            </div>
                        `)
                    }
                    row.attr('loaded', '1')
                }).fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao carregar contatos',
                    })
                })
            }
        }

        $(document).on('click', '.novo-contato', function(){
            const row = $(this).parents('.row-pessoa')
            generateContato(row, row)

        })
        function generateContato(row, item){
            row.find('.contatos-salvos.ignore').remove()
            row.find('.contatos-pessoa').append(`
                <div class="row contatos-salvos row-contato" style="margin-top: 10px;" contatoId="${item?.id}" ${item?.id ? '' : 'isNew'}>
                    <div class="col-5">
                        <select class="form-control tipo-contato">
                            <option value="0">Telefone</option>
                            <option value="1">Email</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <input value="${item?.descricao || ''}" class="descricao-contato form-control"></input>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remover-contato">Remover</button>
                    </div>
                </div>
            `)
            if(item?.id){
                $(document).find(`[contatoId="${item?.id}"] .tipo-contato`).val(item?.tipo)
            }
        }

        function generatePessoa(item){
            if($(document).find(`.row-pessoa [idPessoa="${item?.id}"]`)[0] == undefined){
                $('.accordion').append(`
                    <div class="accordion-item row-pessoa" idPessoa="${item?.id  || ''}" nomePessoa="${item?.nome  || ''}" loaded="0">
                        <h2 class="accordion-header" id="panelsStayOpen-heading-${item?.id || ''}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-${item?.id || ''}" aria-expanded="false" aria-controls="panelsStayOpen-${item?.id || ''}">
                                <div style="min-width: 60%;">
                                    <input value="${item?.nome || ''}" class="form-control nome-pessoa"></input>
                                </div>
                                <div style="margin-left: 18px;">
                                    CPF: ${item?.cpf || ''}
                                </div>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-${item?.id || ''}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-${item?.id || ''}">
                            <div class="accordion-body">
                                <button type="button" class="btn btn-info novo-contato" style="margin-bottom: 14px;">Novo contato</button>
                                <button type="button" class="btn btn-danger remover-pessoa" style="margin-bottom: 14px;">Remover pessoa</button>
                                <div class="contatos-pessoa overflow-auto overflow-y-hidden container" style="max-height: 24vh;">
                                    <div class="row turno-dia" style="position: sticky; top: 0; margin-bottom: 12px;">
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

        $(document).on('click', '#gerarNovaPessoa', function(){
            Swal.fire({
            html: `
                <form id="formNovaPessoa">
                    <span>Nome</span>
                    <input value="" class="form-control" id="new-pessoa-nome" required></input>
                    <span>Cpf</span>
                    <input value="" class="form-control" id="new-pessoa-cpf" required></input>
                </form>
            `,
            title: `Nova pessoa`,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Salvar',
            denyButtonText: `Cancelar`,
            allowEscapeKey: false,
            preConfirm: () => {
                if($('#new-pessoa-cpf').val().length < 14){
                    $('#new-pessoa-cpf').val('')
                }
                validateForm($(document).find('#formNovaPessoa'))
                if(!validateForm($(document).find('#formNovaPessoa'))){
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: '/pessoas/insertPessoa',
                        data: {
                            nome: $(document).find('#new-pessoa-nome').val(),
                            cpf: $(document).find('#new-pessoa-cpf').val()
                        },
                        success: function(data){
                            if(data.message == 'SUCCESS'){
                                Swal.close();
                                Swal.fire(
                                    `Nova pessoa criada`,
                                    '',
                                    'success'
                                )
                            }else{
                                Swal.close();
                                Swal.fire(
                                    `${data.message}`,
                                    '',
                                    'warning'
                                )
                            }
                            getPessoas()
                            return true
                        },
                        dataType: 'json'
                    });
                }
                return false;
            }})
            $('#new-pessoa-cpf').mask('000.000.000-00', {reverse: true});
        })

        $(document).on('click', '.remover-pessoa', function(){
            const row = $(this).parents('.row-pessoa')
            Swal.fire({
                title: `Deseja excluir pessoa ${row.attr('nomePessoa')}`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.getJSON(`/pessoas/removerPessoa?idPessoa=${row.attr('idPessoa')}`)
                        .done(function() {
                            Swal.fire('Salvo!', '', 'success')
                            row.remove()
                        })
                        .fail(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao excluir pessoa',
                            })
                        })
                }
            })
        })

        $(document).on('click', '.remover-contato', function(){
            const row = $(this).parents('.row-contato')
            Swal.fire({
                title: `Deseja excluir contato: ${row.find('.descricao-contato').val()}`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.getJSON(`/contatos/removerContato?contatoId=${row.attr('contatoId')}`)
                        .done(function() {
                            Swal.fire('Salvo!', '', 'success')
                            row.remove()
                        })
                        .fail(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao excluir contato',
                            })
                        })
                }
            })
        })

        $(document).on('click', '.nome-pessoa', function(event) {
            event.stopPropagation();
        });

        $(document).on('focusout', '.nome-pessoa',function() {
            const row = $(this).parents('.row-pessoa');
            $.ajax({
                type: "POST",
                url: '/pessoas/editPessoa',
                data: {
                    nome: row.find('.nome-pessoa').val(),
                    id: row.attr('idPessoa')
                },
                success: function(data){
                    if(data.message == 'SUCCESS'){
                        Swal.close();
                        Swal.fire(
                            `Alterações salvas!`,
                            '',
                            'success'
                        )
                    }else{
                        Swal.close();
                        Swal.fire(
                            `${data.message}`,
                            '',
                            'warning'
                        )
                    }
                    getDataHorarios()
                    return true
                },
                dataType: 'json'
            });
        })

        function validateForm(form) {
            const firstInvalidField = form.find(":invalid")[0];
            if (firstInvalidField) {
                if (form.find(":invalid").first().prop("required")) {
                    firstInvalidField.setCustomValidity("Preencha este campo.");
                    $(firstInvalidField).one("input", function () {
                        firstInvalidField.setCustomValidity("");
                    });
                }

                form[0].reportValidity();
                return false;
            }
            return true;
        }

        function saveContato(row){
            const descricao = row.find('.descricao-contato').val()
            const tipo = row.find('.tipo-contato').val()
            const idPessoa = row.parents('.row-pessoa').attr('idPessoa')
            const id = row.attr('contatoId')

            if(descricao !== '' && tipo !== ''){
                if(row.attr('isNew') !== undefined){
                    $.ajax({
                        type: "POST",
                        url: '/contatos/insertContato',
                        data: {
                            descricao: descricao,
                            tipo: tipo,
                            idPessoa: idPessoa,
                        },
                        success: function(data){
                            if(data.message == 'SUCCESS'){
                                Swal.close();
                                Swal.fire(
                                    `Novo contato criado`,
                                    '',
                                    'success'
                                )
                            }else{
                                Swal.close();
                                Swal.fire(
                                    `${data.message}`,
                                    '',
                                    'warning'
                                )
                            }
                            row.parents('.accordion-item').attr('loaded', '0')
                            getContatos(row.parents('.accordion-item'))
                            return true
                        },
                        dataType: 'json'
                    });
                }else{
                    $.ajax({
                        type: "POST",
                        url: '/contatos/editContato',
                        data: {
                            descricao: descricao,
                            tipo: tipo,
                            idPessoa: idPessoa,
                            id: id
                        },
                        success: function(data){
                            if(data.message == 'SUCCESS'){
                                Swal.close();
                                Swal.fire(
                                    `Alterações salvas!`,
                                    '',
                                    'success'
                                )
                            }else{
                                Swal.close();
                                Swal.fire(
                                    `${data.message}`,
                                    '',
                                    'warning'
                                )
                            }
                            getContatos(row.parents('.accordion-item'))
                            return true
                        },
                        dataType: 'json'
                    });
                }
            }
        }

        $(document).on('focusout', '.tipo-contato, .descricao-contato', function(){
            saveContato($(this).parents('.contatos-salvos'))
        })
    })
</script>
<style>
    body {
        background-color: #f1f1f1;
    }
</style>