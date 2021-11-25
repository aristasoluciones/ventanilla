<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Bienvenido <?= $vUsuario['nombre'] ?> </h5>
            </div>
        </div>
    </div>
</div><!--.page-content-header-->
<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info" id="card_denuncia">
                    <div class="card-header">
                        <h3 class="card-title">Quejas</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="listado" class="table table-bordered table-striped">
                            <thead>
                                <th>Folio</th>
                                <th>Nombre</th>
                                <th>Etapa</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        administrar_listado(1);
    }
</script>

<!-- /.content -->
