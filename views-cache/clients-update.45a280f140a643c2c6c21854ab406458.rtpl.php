<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo htmlspecialchars( $client["desfantasia"], ENT_COMPAT, 'UTF-8', FALSE ); ?>

  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Cliente</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/clients/<?php echo htmlspecialchars( $client["idclient"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desfantasia">Fantasia</label>
              <input type="text" class="form-control" id="desfantasia" name="desfantasia" placeholder="Digite o nome fantasia" value="<?php echo htmlspecialchars( $client["desfantasia"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="desrazsoc">Razão social</label>
              <input type="text" class="form-control" id="desrazsoc" name="desrazsoc" placeholder="Digite a razão social"  value="<?php echo htmlspecialchars( $client["desrazsoc"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
                <label for="descnpj">CNPJ</label>
                <input type="text" class="form-control" id="descnpj" name="descnpj" placeholder="Digite o CNPJ"  value="<?php echo htmlspecialchars( $client["descnpj"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
              </div>
            <div class="form-group">
              <label for="desnrphone">Telefone</label>
              <input type="text" class="form-control" id="desnrphone" name="desnrphone" placeholder="Digite o telefone"  value="<?php echo htmlspecialchars( $client["desnrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
            <div class="form-group">
              <label for="desemail">Email</label>
              <input type="email" class="form-control" id="desemail" name="desemail" placeholder="Digite o e-mail" value="<?php echo htmlspecialchars( $client["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->