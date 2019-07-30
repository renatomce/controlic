<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Usuários
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="/admin/clients">Clientes</a></li>
    <li class="active"><a href="/admin/clients/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Cliente</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/admin/clients/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desfantasia">Fantasia</label>
              <input type="text" class="form-control" id="desfantasia" name="desfantasia" placeholder="Digite o nome fantasia">
            </div>
            <div class="form-group">
              <label for="desrazsoc">Razão social</label>
              <input type="text" class="form-control" id="desrazsoc" name="desrazsoc" placeholder="Digite a razão social">
            </div>
            <div class="form-group">
                <label for="descnpj">CNPJ</label>
                <input type="number" class="form-control" id="descnpj" name="descnpj" placeholder="Digite o CNPJ">
              </div>
            <div class="form-group">
              <label for="desnrphone">Telefone</label>
              <input type="number" class="form-control" id="desnrphone" name="desnrphone" placeholder="Digite o telefone">
            </div>
            <div class="form-group">
              <label for="desemail">Email</label>
              <input type="email" class="form-control" id="desemail" name="desemail" placeholder="Digite o e-mail">
            </div>
            <div class="form-group">
                <label for="deslicexpires">Licença expira em</label>
                <input type="datetime-local" class="form-control" id="deslicexpires" name="deslicexpires">
              </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->