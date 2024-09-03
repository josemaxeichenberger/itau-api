<?php
include("controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'fornecedor') {
    header("Location: pagina_de_acesso_nao_autorizado.php");
    exit();
}
function my_autoload($pClassName)
{
	include('Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload");
$id = $_POST["id"];

$busca_fornnecedores = new fornecedores();
$busca_fornnecedores->setId($id);
$busca_fornnecedores = $busca_fornnecedores->SelectID();
[$nome, $sobrenome] = explode(" ", $busca_fornnecedores["representante"]);

?>



<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel"><?php echo $busca_fornnecedores["razao"]; ?></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" id="kt_modal_new_card_cancel" aria-label="Close"></button>
</div>
<div class="modal-body">

	<form method="post" action="#" id="kt_modal_new_card_form" enctype="multipart/form-data">
		<input type="hidden" name="idF" id="idF" value="<?php echo $id ?>">
		
		<div class="row">
			<div class="col-md-6 col-6">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">Nome do Representante:</label>
					<input type="text" class="form-control form-control-solid" name="representante_nome" id="representante" value="<?php echo $nome ?>">
				</div>
			</div>

			<div class="col-md-6 col-6">
				<div class="form-group d-flex flex-column mb-8 fv-row">
				<label class="fs-6 fw-bold mb-2" for="titulo">Sobrenome do Representante:</label>

					<input type="text" class="form-control form-control-solid" name="representante_sobrenome" id="representante2" value="<?php echo $sobrenome ?>">
				</div>
			</div>
		</div>
		<div class="form-group d-flex flex-column mb-8 fv-row">
			<label class="fs-6 fw-bold mb-2" for="titulo">CPF:</label>
			<input type="text" class="form-control form-control-solid" name="cpf" id="cpf" value="<?php echo $busca_fornnecedores["cpf"]; ?>">
		</div>

		<div class="form-group d-flex flex-column mb-8 fv-row">
			<label class="fs-6 fw-bold mb-2" for="titulo">Telefone:</label>
			<input type="text" class="form-control form-control-solid" name="telefone" id="telefone" value="<?php echo $busca_fornnecedores["telefone"]; ?>">
		</div>

		<div class="form-group d-flex flex-column mb-8 fv-row">
			<label class="fs-6 fw-bold mb-2" for="titulo">E-mail:</label>
			<input type="email" class="form-control form-control-solid" name="email" id="email" value="<?php echo $busca_fornnecedores["email"]; ?>">
		</div>

		<div class="row">
			<div class="col-md-9 col-9">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">Rua:</label>
					<input type="text" class="form-control form-control-solid" name="rua" id="rua" value="<?php echo $busca_fornnecedores["rua"]; ?>">
				</div>
			</div>

			<div class="col-md-3 col-3">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">N:</label>
					<input type="text" class="form-control form-control-solid" name="numero" id="numero" value="<?php echo $busca_fornnecedores["numero"]; ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">Bairro:</label>
					<input type="text" class="form-control form-control-solid" name="bairro" id="bairro" value="<?php echo $busca_fornnecedores["bairro"]; ?>">
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">Cidade:</label>
					<input type="text" class="form-control form-control-solid" name="cidade" id="cidade" value="<?php echo $busca_fornnecedores["cidade"]; ?>">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="titulo">UF:</label>
					<input type="text" class="form-control form-control-solid" name="estado" id="estado" value="<?php echo $busca_fornnecedores["estado"]; ?>">
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-4">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="valor">Banco: </label>
					<input type="text" step="any" class="form-control form-control-solid" name="banco" id="bancoF" value="<?php echo $busca_fornnecedores["banco"]; ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="valor">Agencia: </label>
					<input type="text" step="any" class="form-control form-control-solid" name="agencia" id="agenciaF" value="<?php echo $busca_fornnecedores["agencia"]; ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group d-flex flex-column mb-8 fv-row">
					<label class="fs-6 fw-bold mb-2" for="valor">Conta: </label>
					<input type="text" step="any" class="form-control form-control-solid" name="conta" id="contaF" value="<?php echo $busca_fornnecedores["conta"]; ?>">
				</div>
			</div>
		</div>


		<div class="form-group d-flex flex-column mb-8">
			<!-- <button type="submit" class="btn btn-danger" id="kt_modal_new_card_submit">Salvar</button>  -->
			<button type="submit" id="kt_modal_new_card_submit" class="btn btn-danger">
				<span class="indicator-label">Salvar</span>
				<span class="indicator-progress">Aguarde...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			</button>
		</div>

	</form>
</div>