
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/css/bootstrap.css?v=v1.113.22"/>
    
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/css/font-awesome.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/css/bootstrap-theme.css?v=v1.113.22"/>
    
    
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/extensions/Responsive/css/responsive.bootstrap.min.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/media/css/dataTables.bootstrap.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/media/css/jquery.dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/css/dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/croppie/croppie.min.css?v=v1.113.22"/>

    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/extensions/ColReorder/css/colReorder.dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/extensions/Colvis/css/dataTables.Colvis.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/dataTables/extensions/ColResize/css/dataTables.colResize.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="/blog/public/assets/adm/css/quizplus_form.css?v=v1.113.22"/>    

    
    
    <script type="text/javascript" src="/blog/public/assets/js/jquery-1.11.3.js?v=v1.113.22"></script>

    <script type="text/javascript" src="/blog/public/assets/js/bootstrap.js?v=v1.113.22"></script>

    <script type="text/javascript" src="/blog/public/assets/adm/js/quizplus_form.js?v=v1.113.22"></script>

    <script type="text/javascript" src="/blog/public/assets/dataTables/media/js/jquery.dataTables.js?v=v1.113.22"></script>
    <script type="text/javascript" src="/blog/public/assets/dataTables/media/js/dataTables.bootstrap.js?v=v1.113.22"></script>
    <script type="text/javascript" src="/blog/public/assets/dataTables/extensions/Responsive/js/dataTables.responsive.min.js?v=v1.113.22"></script>
    <script type="text/javascript" src="/blog/public/assets/dataTables/extensions/ColReorder/js/dataTables.colReorder.js?v=v1.113.22"></script>
    <script type="text/javascript" src="/blog/public/assets/dataTables/extensions/Colvis/js/dataTables.Colvis.js?v=v1.113.22"></script>
    <script type="text/javascript" src="/blog/public/assets/dataTables/extensions/ColResize/js/dataTables.colResize-modificado.js?v=v1.113.22"></script>



<div class="adm-box col-md-10 hg100">
    <div id="quiz-content">
        <div class="content-box quiz_create template-content">


            <?php echo isset($menucreate) ? $menucreate : NULL; ?>
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="relat panel-heading">
                    <div class=" "><h2>Carros</h2></div>
                    <div class="clearfix"></div>
            </div>

                <div class="panel-body">
                    
                    <br>

                    <div class="clearfix"></div>
                    <div class="gaph"></div>
                    <div class="row">
                        <div class="col-md-12 pattern-btn">
                            <button type="button" class="btn btn-question btn-warning" onclick="add_class()" id="add-drop">Adicione Carro
                            </button>
                        </div>
                    </div>
                    <br><br>
                    <table id="table-quiz" class="table">
                        <thead>
                        <tr>
                            <th width="12" data-id="checkbox">&nbsp;</th>
                            
                            <th class="namecolumn" data-id="name">Marca</th>
                            <th class="namecolumn" data-id="instructor_name">Modelo</th>
                            <th data-id="presencial">Ano</th>
                            <th width="200" data-id="action">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($output['carros'] as $row):  ?>
                            <tr>
                                <td>
                                </td>
                                
                                <td><?php echo $row["marca"] ?></td>
                                <td><?php echo $row["modelo"] ?></td>
                                <td><?php echo $row["ano"] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a title="Alterar Carro" onclick="update_carro('<?php echo $row["id"] ?>')" class="btn btn-default"> <i class="fa fa-edit"></i></a>
                                        <a title="Deletar Carro" onclick="delete_carro('<?php echo $row["id"] ?>')" class="btn btn-default"> <i class="fa fa-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br>
            <div class="modal fade post-statistic-modal template-content" tabindex="-1" role="dialog" id="post-statistic-modal"
                 aria-labelledby="post-statistic-modal"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Adicionar / Alterar Carro</h4>
                        </div>
                        <div id="content-modal">

                        </div>

                        <form action="aspodifj" method="post">
                            
							<input type="hidden" name="id" id="id" value="<?php echo bin2hex(random_bytes(16)); ?>">
                            <div class="modal-body">
                                <i class="fa fa-refresh fa-spin fa-3x fa-fw load"></i>
                                <div class="statistic-content">

                                    
									<div class="clearfix"></div>
                                    <div class="gap"></div>
<br>
									
									<div class="row">
                                        <div class=" title-quiz col-xs-12">

                                            <label for="input-title" class="label_title">Modelo</label>
                                            <input type="text" class="form-control input-title" value="" name="modelo"
                                                   id="modelo" required>
                                        </div>
                                    </div>
									
									<div class="clearfix"></div>
                                    <div class="gap"></div>
<br>
									
									<div class="row">
                                        <div class=" title-quiz col-xs-12">

                                            <label for="input-title" class="label_title">Ano</label>
                                            <input type="text" class="form-control input-title" value="" name="ano"
                                                   id="ano" required>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="gap"></div>


                                    <div class="row">
                                        <div class=" col-xs-12">
                                            <bR>
                                            <label for="input-post" class="label_post">Marca</label>
                                            <div class="input-group super-filter">
                                                <select class="form-control" name="marca" id="marca" data-placeholder="Nenhum participante cadastrado"
                                                        id="input-instructor">
														<option name=""></option>
														<option name="Renault">Renault</option>
														<option name="Peugeot">Peugeot</option>
														<option name="GM">GM</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>


                                <div class="modal-footer">
                                    <div class="fright">
                                        <button type="submit" class="btn btn-send">Salvar</button>
                                    </div>
                                    <div class="fright">
                                        <button type="button" class="btn cancel-but btn-gray" data-dismiss="modal">Cancelar</button>
                                    </div>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fright">
<!--                <button type="button" onclick="move_quizplus()" class="btn btn-send">Concluir</button>-->
            </div>

        </div>
    </div>
</div>

