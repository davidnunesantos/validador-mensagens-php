<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./src/public/images/logo_pgmais.jpg" type="image/x-icon">
    <title>PGMais - Teste Dev</title>

    <!-- JQuery -->
    <script type="text/javascript" src="./src/public/library/jquery/jquery-3.5.1.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2&display=swap">

    <!-- FontAwesome -->
    <link rel="stylesheet" type="text/css" href="./src/public/library/fontawesome/css/all.css">
    <script defer type="text/javascript" src="./src/public/library/fontawesome/js/all.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="./src/public/library/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="./src/public/library/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom -->
    <script src="./src/public/js/pgmais.js?v=1"></script>
</head>
<body class="bg-light mx-xl-5">
    <div class="container text-body">
        <div class="row text-center mt-3">
            <div class="col">
                <h1 class="display">PG Mais - Teste Dev</h1>
            </div>
        </div>
        <hr>
        <div class="row d-none" id="alertBlock">
            <div class="col-12">
                <div class="alert alert-danger" role="alert"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="uploadFileForm" mathod="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="arquivo">Faça o upload de um arquivo para realizar a validação dos dados</label>
                        <input type="file" class="form-control-file" id="arquivo" name="arquivo">
                    </div>
                    <button type="submit" name="submit_button" id="submit_button" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading_csv">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#exemplo_csv" aria-expanded="true" aria-controls="exemplo_csv">
                                    Exemplo de estrutura com arquivo CSV
                                </button>
                            </h5>
                        </div>
                        <div id="exemplo_csv" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body table-responsive">
                                <table class="table table-hover table-sm text-nowrap table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col"></th>
                                            <th scope="col">A</th>
                                            <th scope="col">B</th>
                                            <th scope="col">C</th>
                                            <th scope="col">D</th>
                                            <th scope="col">E</th>
                                            <th scope="col">F</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>bff58d7b-8b4a-456a-b852-5a3e000c0e63</td>
                                            <td>12</td>
                                            <td>996958849</td>
                                            <td>NEXTEL</td>
                                            <td>21:24:03</td>
                                            <td>sapien sapien non mi integer ac neque duis bibendum</td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>b7e2af69-ce52-4812-adf1-395c8875ad30</td>
                                            <td>46</td>
                                            <td>950816645</td>
                                            <td>CLARO</td>
                                            <td>19:05:21</td>
                                            <td>justo lacinia eget tincidunt eget</td>
                                        </tr>
                                        <tr>
                                            <th>3</th>
                                            <td>e7b87f43-9aa8-414b-9cec-f28e653ac25e</td>
                                            <td>34</td>
                                            <td>990171682</td>
                                            <td>VIVO</td>
                                            <td>18:35:20</td>
                                            <td>dui luctus rutrum nulla tellus in sagittis dui</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading_txt">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#exemplo_txt" aria-expanded="true" aria-controls="exemplo_txt">
                                    Exemplo de estrutura com arquivo TXT
                                </button>
                            </h5>
                        </div>
                        <div id="exemplo_txt" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                bff58d7b-8b4a-456a-b852-5a3e000c0e63;12;996958849;NEXTEL;21:24:03;sapien sapien non mi integer ac neque duis bibendum<br>
                                b7e2af69-ce52-4812-adf1-395c8875ad30;46;950816645;CLARO;19:05:21;justo lacinia eget tincidunt eget<br>
                                e7b87f43-9aa8-414b-9cec-f28e653ac25e;34;990171682;VIVO;18:35:20;dui luctus rutrum nulla tellus in sagittis dui<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none resultados">
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="tabs-resultados" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" id="tab-validos" data-toggle="tab" href="#validos" role="tab" aria-controls="validos" aria-selected="true"><h3>Válidos</h3></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-body" id="tab-bloqueados" data-toggle="tab" href="#bloqueados" role="tab" aria-controls="bloqueados" aria-selected="false"><h3>Bloqueados</h3></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content d-none resultados">
            <div class="tab-pane fade show active" id="validos" role="tabpanel" aria-labelledby="home-tab">
                <div class="p-3 p-xl-5 border rounded-bottom bg-white shadow">
                    <div class="row">
                        <div class="loading col-12 d-flex justify-content-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <div class="col-12" id="conteudo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bloqueados" role="tabpanel" aria-labelledby="profile-tab">
                <div class="p-3 p-xl-5 border rounded-bottom bg-white shadow">
                    <div class="row">
                        <div class="loading col-12 d-flex justify-content-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <div class="col-12 table-responsive">
                            <table class="table table-hover text-nowrap table-sm" id="table-blocked">
                                <thead>
                                    <tr>
                                        <th scope="col">ID da mensagem</th>
                                        <th scope="col">DDD</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Operadora</th>
                                        <th scope="col">Hora de envio</th>
                                        <th scope="col">Mensagem</th>
                                        <th scope="col">Motivo do bloqueio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>