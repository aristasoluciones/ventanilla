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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"  id="content-lista">
            </div>
        </div>
    </div><!--/. container-fluid -->
</section>
<script type="text/javascript">
    window.onload = function() {
        parent.cargar_listado_manifestacion(1, 1)
    }
</script>
