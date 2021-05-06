<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>

    <div class="container">            
            <div class="row mt-5">

                <div class="mb-3 col-md-4">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep" onblur="getCep(event)">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="cep" class="form-label">UF</label>
                    <input type="text" class="form-control" id="uf" readonly>
                </div>

                <div class="mb-3 col-md-4">
                    <label for="cep" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" readonly>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="logradouro" class="form-label">Rua</label>
                    <input type="text" class="form-control" id="rua" readonly>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="cep" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="complemento" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="cep" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" readonly>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="cep" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" readonly>
                </div>

                <div class="col-md-12">
                    <button id="btn-submit" class="btn btn-primary mb-3 me-3" 
                    onclick="validateSubmit()">Submit</button>

                    <button id="btn-clear" class="btn btn-danger mb-3 me-3" onclick="clearInput()">Clear</button>
                </div>
            </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script>

    function getCep() {
        let cep = $('#cep').val();
        
        $.ajax({
            url: '/api/requisicao/'+cep,
            method: 'GET',
            data: {},
            success(resp) {
                $('#uf').val(resp.address.estado);
                $('#rua').val(resp.address.rua);
                $('#bairro').val(resp.address.bairro);
                $('#cidade').val(resp.address.cidade);

                if (!$('#uf').val()) {
                    $('#uf').removeAttr('readonly');
                    $('#uf').addClass('mod');
                }
                if (!$('#numero').val()) {
                    $('#numero').removeAttr('readonly');
                    $('#numero').addClass('mod');
                }
                if (!$('#rua').val()) {
                    $('#rua').removeAttr('readonly');
                    $('#rua').addClass('mod');
                }
                if (!$('#complemento').val()) {
                    $('#complemento').removeAttr('readonly');
                    $('#complemento').addClass('mod');
                }
                if (!$('#bairro').val()) {
                    $('#bairro').removeAttr('readonly');
                    $('#bairro').addClass('mod');
                }
                if (!$('#cidade').val()) {
                    $('#cidade').removeAttr('readonly');
                    $('#cidade').addClass('mod');
                }

            },
            error(erro) {
                alert('Erro, tente novamente mais tarde');
                $('#btn-submit').attr('disabled', true);
            }
        });
    }

    function clearInput() {
        $('#cep').val('');

        $('#uf').val('');
        $('#uf').attr('readonly', true);

        $('#numero').val('');
        $('#numero').attr('readonly', true);

        $('#rua').val('');
        $('#rua').attr('readonly', true);

        $('#complemento').val('');
        $('#complemento').attr('readonly', true);

        $('#bairro').val('');
        $('#bairro').attr('readonly', true);

        $('#cidade').val('');
        $('#cidade').attr('readonly', true);
    }

    function validateSubmit() {
        let cep = $('#cep').val();

        $.ajax({
            url: '/api/requisicao/'+cep,
            method: 'GET',
            data: {},
            success(resp) {
                let validation = [];
                let validate = true;

                validation['cep'] = $('#cep').val();

                if ( !$('#rua').hasClass('mod') ) {
                    validation['rua'] = $('#rua').val();
                }
                if ( !$('#bairro').hasClass('mod') ) {
                    validation['bairro'] = $('#bairro').val();
                }
                if ( !$('#cidade').hasClass('mod') ) {
                    validation['cidade'] = $('#cidade').val();
                }
                if ( !$('#estado').hasClass('mod') ) {
                    validation['estado'] = $('#uf').val();
                }

                
                if ( resp.address.cep !== validation['cep'] ) {
                    validate = false;
                }

                if ( resp.address.rua !== validation['rua'] ) {
                    validate = false;
                }

                if ( resp.address.bairro !== validation['bairro'] ) {
                    validate = false;
                }

                if ( resp.address.cidade !== validation['cidade'] ) {
                    validate = false;
                }

                if ( resp.address.estado !== validation['estado'] ) {
                    validate = false;
                }

                
    
                if (validate) {
                    window.location.href = '/pedido';
                } else {
                    alert('Não foi possivel validar seu endereço!')
                    $('#btn-submit').attr('disabled', true);
                }

            },
        });
    }

    </script>
</body>
</html>