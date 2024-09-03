<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
	<!--begin::Container-->
	<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-gray-700 fw-bold me-1"><?php echo date("Y"); ?>©</span>
			<a href="https://lawsecsa.com.br" target="_blank" class="text-gray-800 text-hover-primary">LAW SEC</a>
		</div>
		<!--end::Copyright-->
		<!--begin::Menu-->
		<ul class="menu menu-gray-700 menu-hover-primary fw-bold order-1">
			<li class="menu-item">
				<a href="#" target="_blank" class="menu-link px-2">Sobre</a>
			</li>
			<li class="menu-item">
				<a href="#" target="_blank" class="menu-link px-2">Suporte</a>
			</li>
		</ul>
		<!--end::Menu-->
	</div>
	<!--end::Container-->
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="AssinanteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="row g-3 needs-validation" novalidate action="createAssinante.php">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Configurar Assinatura</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">


					<div class="col-md-12">
						<label for="validationCustom04" class="form-label">Tipo de autenticação para realizar assinatura.</label>
						<select class="form-select" id="validationCustom04" name="type" required>
							<option selected disabled value="">Selecione</option>
							<option value="email">E-mail</option>
							<!-- <option value="sms">SMS</option> -->
							<option value="whatsapp">Whatsapp</option>
							<!-- <option value="pix">Pix</option> -->
							<option value="api">Api</option>
						</select>
						<div class="invalid-feedback">
							Campo obrigatório
						</div>
					</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="AssinanteModalClose" data-bs-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="AssinanteModal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="row g-3 needs-validation salveSecret" id="salveSecret" novalidate >
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Configurar Assinatura</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="liveAlertPlaceholder"></div>
					<h6>Dados para Auxiliar no prenchimento.</h6>
					<ol class="list-group list-group-numbered">
						<li class="list-group-item">Nome do operador: Gilberto Eichenberg </li>
						<li class="list-group-item">E-mail do operador: gilberto@lawfinancas.com.br</li>
						<li class="list-group-item">Empresa do operador: LAW FINANÇAS</li>
						<li class="list-group-item">Nome da conta: LAW FINANÇAS</li>
					</ol>
					<div class="mb-3">
						<label for="chave" class="form-label">Chave do signatário</label>
						<input type="text" class="form-control" id="chave" aria-describedby="emailHelp">

					</div>
					<div class="mb-3">
						<label for="secretRSA" class="form-label">Secret RSA</label>
						<textarea class="form-control" id="secretRSA" name="secretRSA" placeholder="" rows="5" required></textarea>
						<div class="invalid-feedback">
							Campo obrigatório
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="AssinanteModalClose" data-bs-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalAncora" tabindex="-1" aria-labelledby="ModalAncora" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="ModalAncoraTitle"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="needs" id="formAncora" action="../Controllers/AncoraController.php" method="POST" novalidate>

					<input type="hidden" name="id_ancora" id="id_ancora" value="">




					<h4 class="mb-3">Dados da Conta</h4>

					<div class="row g-3">
						<div class="col-sm-12">
							<label for="cnpj" class="form-label">CNPJ do CESSIONÁRIO</label>
							<input type="text" class="form-control" id="cnpj_ancora" name="cnpj_ancora" onblur="ValidaCnpj(this.value)" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="razao" class="form-label">Razão Social</label>
							<input type="text" class="form-control" id="razao" name="razao" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="nome_fantasia" class="form-label">Nome Fantasia</label>
							<input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="cep_ancora" class="form-label">Cep</label>
							<input type="text" class="form-control" id="cep_ancora" name="cep_ancora" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-7">
							<label for="rua_ancora" class="form-label">Rua</label>
							<input type="text" class="form-control" id="rua_ancora" name="rua_ancora" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-2">
							<label for="numero_ancora" class="form-label">Número</label>
							<input type="text" class="form-control" id="numero_ancora" name="numero_ancora" placeholder="">
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-6">
							<label for="bairro_ancora" class="form-label">Bairro</label>
							<input type="text" class="form-control" id="bairro_ancora" name="bairro_ancora" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="cidade_ancora" class="form-label">Cidade</label>
							<input type="text" class="form-control" id="cidade_ancora" name="cidade_ancora" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="estado_ancora" class="form-label">Estado</label>
							<input type="text" class="form-control" id="estado_ancora" name="estado_ancora" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>

						<div class="col-12">
							<label for="complemento" class="form-label">Complemento <span class="text-body-secondary">(Opcional)</span></label>
							<input type="text" class="form-control" id="complemento_ancora" name="complemento_ancora" placeholder="">
						</div>
						<hr class="my-4">
						<h4 class="mb-3">Dados do Representante</h4>
						<div class="col-sm-12">
							<label for="nome_representante" class="form-label">Nome Completo do Representante Legal</label>
							<input type="text" class="form-control" id="nome_representante" name="nome_representante" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="cpf" class="form-label">CPF do Representante Legal</label>
							<input type="text" class="form-control" id="cpf_representante" name="cpf_representante" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>

						<div class="col-sm-12">
							<label for="rg" class="form-label">RG do Representante Legal</label>
							<input type="text" class="form-control" id="rg_representante" name="rg_representante" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="rg" class="form-label">Data de Nascimento</label>
							<input type="date" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="rg" class="form-label">Estado civil</label>
							<select name="estado_civil" class="form-control" id="estado_civil" required>
								<option value="Solteiro">Solteiro</option>
								<option value="Casado">Casado</option>
								<option value="Divorciado">Divorciado</option>
								<option value="União Estável">União Estável</option>
								<option value="Separado">Separado</option>
								<option value="Viúvo">Viúvo</option>
							</select>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="nacionalidade" class="form-label">Nacionalidade</label>
							<input type="text" class="form-control" id="nacionalidade" name="nacionalidade" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-sm-12">
							<label for="profissao" class="form-label">Profissão</label>
							<input type="text" class="form-control" id="profissao" name="profissao" placeholder="" value="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-12">
							<label for="username" class="form-label">Nome de Usuário</label>
							<div class="input-group has-validation">

								<input type="text" class="form-control" id="username" name="username" disabled placeholder="Nome de Usuário ex: marcos" required>
								<span class="input-group-text">@lawsmart.com.br</span>
								<div class="invalid-feedback">
									Campo é obrigatório.
								</div>
							</div>
						</div>
						<div class="col-12">
							<label for="username" class="form-label">Senha de Usuário</label>
							<div class="input-group has-validation">

								<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha deve ter no minímo 8 caracteres" minlength="8" maxlength="30" required>

								<div class="invalid-feedback">
									Campo é obrigatório.
								</div>
							</div>
						</div>
						<div class="col-6">
							<label for="email_register" class="form-label">Email <span class="text-body-secondary">(Serve para
									assinatura)</span></label>
							<input type="email" class="form-control" id="email_register" name="email_register" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-6">
							<label for="telefone" class="form-label">Telefone</label>
							<input type="text" class="form-control" id="telefone_representante" name="telefone_representante" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="cep" class="form-label">Cep</label>
							<input type="text" class="form-control" id="cep_representante" onblur="pesquisacep(this.value);" name="cep" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-8">
							<label for="rua" class="form-label">Rua</label>
							<input type="text" class="form-control" id="rua_representante" name="rua_representante" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-1">
							<label for="numero" class="form-label">Número</label>
							<input type="text" class="form-control" id="numero_representante" name="numero_representante" placeholder="">
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-6">
							<label for="bairro" class="form-label">Bairro</label>
							<input type="text" class="form-control" id="bairro_representante" name="bairro_representante" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="cidade" class="form-label">Cidade</label>
							<input type="text" class="form-control" id="cidade_representante" name="cidade_representante" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>
						<div class="col-md-3">
							<label for="estado" class="form-label">Estado</label>
							<input type="text" class="form-control" id="estado_representante" name="estado_representante" placeholder="" required>
							<div class="invalid-feedback">
								Campo é obrigatório.
							</div>
						</div>

						<div class="col-12">
							<label for="complemento" class="form-label">Complemento <span class="text-body-secondary">(Opcional)</span></label>
							<input type="text" class="form-control" id="complemento_representante" name="complemento_representante" placeholder="">
						</div>




					</div>



					<hr class="my-4">

					<button class="w-100 btn btn-primary btn-lg" id="send" type="submit">Continuar</button>
				</form>
			</div>

		</div>
	</div>
</div>

<script>
	<?php
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$parsed_url = parse_url($url);
	$domain = $parsed_url['host'];
	?>

	function ModalAncora() {
		var id = '<?php echo $_SESSION["id"]; ?>';

		$.ajax({
			url: '../Controllers/AncoraController.php', // Endpoint to send the POST request to
			type: 'GET', // HTTP method
			data: {
				id: id
			},
			// dataType: 'json', // Expected data type of the response
			success: function(response) {
				let ancora = JSON.parse(response);

				console.log(ancora); // What to do on success
				$('#id_ancora').val(ancora.id);
				$('#cnpj_ancora').val(ancora.cnpj);
				$('#razao').val(ancora.razao);
				$('#nome_fantasia').val(ancora.nome_fantasia);
				$('#cep_ancora').val(ancora.cep_ancora);
				$('#rua_ancora').val(ancora.rua_ancora);
				$('#numero_ancora').val(ancora.numero_ancora);
				$('#bairro_ancora').val(ancora.bairro_ancora);
				$('#cidade_ancora').val(ancora.cidade_ancora);
				$('#estado_ancora').val(ancora.estado_ancora);
				$('#complemento_ancora').val(ancora.complemento_ancora);
				$('#nome_representante').val(ancora.nome_representante);
				$('#cpf_representante').val(ancora.cpf);
				$('#rg_representante').val(ancora.rg);
				$('#data_nascimento').val(ancora.data_nascimento);
				$('#nacionalidade').val(ancora.nacionalidade);
				$('#profissao').val(ancora.profissao);
				let email = ancora.email;

				// Extract the username part (before the '@')
				let username = email.split('@')[0];
				$('#username').val(username);
				$('#senha').val(ancora.senha);
				$('#email_register').val(ancora.email_resgiter);
				$('#telefone_representante').val(ancora.telefone);
				$('#cep_representante').val(ancora.cep);
				$('#rua_representante').val(ancora.rua);
				$('#numero_representante').val(ancora.numero);
				$('#bairro_representante').val(ancora.bairro);
				$('#cidade_representante').val(ancora.cidade);
				$('#estado_representante').val(ancora.estado);
				$('#complemento_representante').val(ancora.complemento);


				$('#ModalAncora').modal('show');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error('Error:', textStatus, errorThrown); // What to do on error
			}
		});




	}

	function Logout() {
		Swal.fire({
			title: "Deseja mesmo sair do sistema?",
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: "Sim",
			denyButtonText: "Não"
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				window.location.href = 'logout.php';
			}
		});
	}

	(() => {
		'use strict';

		// Função para lidar com a primeira modal
		function handleFirstModal() {
			const alertPlaceholder = document.getElementById('liveAlertPlaceholder');

			// Função para remover todos os alertas existentes do placeholder
			const clearAlerts = () => {
				while (alertPlaceholder.firstChild) {
					alertPlaceholder.removeChild(alertPlaceholder.firstChild);
				}
			};

			// Função para adicionar um alerta
			const appendAlert = (message, type) => {
				const existingAlerts = alertPlaceholder.querySelectorAll(`.alert.alert-${type}`);
				let alertExists = false;

				existingAlerts.forEach(alert => {
					const alertMessage = alert.querySelector('div').textContent.trim();
					if (alertMessage === message) {
						alertExists = true;
					}
				});

				if (!alertExists) {
					const wrapper = document.createElement('div');
					wrapper.innerHTML = `
                <div class="mt-3 alert alert-${type} alert-dismissible" role="alert">
                    <div>${message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <a class="btn btn-info w-80 mx-auto mt-3" target="_blank" href="https://app.clicksign.com/fluxia/dfa725d4-ad4a-4c45-877c-08871247c841">Abrir o Formulário</a>
                </div>`;
					alertPlaceholder.appendChild(wrapper);
				}
			};

			// Função para lidar com o fechamento da modal
			const handleModalClose = () => {
				clearAlerts();
			};

			const modalCloseButton = document.querySelector('button[data-bs-dismiss="modal"]');
			if (modalCloseButton) {
				modalCloseButton.addEventListener('click', handleModalClose);
			}

			const forms = document.querySelectorAll('.needs-validation');

			Array.from(forms).forEach(form => {
				form.addEventListener('submit', event => {
					event.preventDefault(); // Prevent form submission

					if (form.checkValidity()) {
						const formData = new FormData(form);

						fetch(form.action, {
								method: 'POST',
								body: formData
							})
							.then(response => {
								if (response.ok) {
									return response.json();
								} else {
									throw new Error('Failed to submit form');
								}
							})
							.then(data => {
								console.log(data.response);
								document.getElementById('chave').value = data.response.signer.key;

								const tipo = document.getElementById('validationCustom04').value;

								if (tipo === 'api') {
									const btnClose = document.getElementById('AssinanteModalClose');

									if (btnClose) {
										btnClose.click();
										const assinanteModal2 = new bootstrap.Modal(document.getElementById('AssinanteModal2'));
										assinanteModal2.show();
										appendAlert('Para a assinatura via API é necessário o preenchimento do formulário para gerar a sua Secret RSA', 'warning');
									}
								} else {
									const btnClose = document.getElementById('AssinanteModalClose');
									btnClose.click();
									Swal.fire({
										title: "Configurado com Sucesso",
										text: "Configuração do signatário foi realizada!",
										icon: "success"
									});
								}
							})
							.catch(error => {
								console.error('Error submitting form:', error);
								Swal.fire({
									title: "Erro",
									text: "Ocorreu um erro ao submeter o formulário",
									icon: "error"
								});
							});
					} else {
						form.classList.add('was-validated');
						event.stopPropagation();
					}
				}, false);
			});
		}

		// Função para lidar com a segunda modal
		function handleSecondModal() {
			const formModal2 = document.querySelector('#AssinanteModal2 form');

			formModal2.addEventListener('submit', function(event) {
				event.preventDefault(); // Evita o envio normal do formulário

				const formData = new FormData(formModal2);
				fetch(formModal2.action, {
						method: 'POST',
						body: formData
					})
					.then(response => {
						if (response.ok) {
							return response.json();
						} else {
							throw new Error('Falha ao submeter formulário');
						}
					})
					.then(data => {
						console.log(data);

						Swal.fire({
							title: "Salvo com Sucesso",
							text: "Os dados foram salvos com sucesso!",
							icon: "success"
						});

						const btnClose = document.querySelector('#AssinanteModal2 .btn-close');
						if (btnClose) {
							btnClose.click();
						}
					})
					.catch(error => {
						console.error('Erro ao submeter formulário:', error);
						Swal.fire({
							title: "Erro",
							text: "Ocorreu um erro ao submeter o formulário",
							icon: "error"
						});
					});
			});
		}

		// Chama as funções para lidar com as modais
		handleFirstModal();
		handleSecondModal();
	})();
	document.addEventListener('DOMContentLoaded', function() {
		// Código a ser executado assim que o documento estiver pronto
		// Adicione um event listener para executar minhaFuncao quando o documento estiver pronto
		document.addEventListener('DOMContentLoaded', minhaFuncao);
		// Chame a função desejada aqui
		minhaFuncao();
	});

	function minhaFuncao() {
		const url = 'checkAssinat.php';
		fetch(url, {
				method: 'GET' // Define o método como GET
			})
			.then(response => {
				// Verifique se a resposta foi bem-sucedida (status 200)
				if (response.ok) {
					// Converta a resposta para JSON
					return response.json();
				} else {
					// Se a resposta não for bem-sucedida, lance um erro
					throw new Error('Falha na requisição GET');
				}
			})
			.then(data => {
				// Trate os dados retornados

				if (data.status === 200) {
					updateNotificationCount(0)
				} else if (data.status === 404) {
					appendNotification();
					updateNotificationCount(1);
				}

				// Adicione seu código aqui para manipular os dados recebidos
			})
			.catch(error => {
				// Trate erros ocorridos durante a requisição ou manipulação dos dados
				console.error('Erro na requisição GET:', error);
			});

	}

	function updateNotificationCount(count) {
		// Seleciona o span pai com o ID 'notificationsSet'
		const notificationsSet = document.getElementById('notificationsSet');

		// Seleciona o span com o ID 'notificationsNumber'
		const notificationsNumber = document.getElementById('notificationsNumber');

		if (notificationsSet && notificationsNumber) {
			if (count > 0) {
				// Se houver notificações, atualiza o número e exibe o span pai
				notificationsNumber.textContent = count;
				notificationsSet.style.display = 'inline-block'; // Exibe o span pai
			} else {
				// Se não houver notificações, oculta o span pai
				notificationsSet.style.display = 'none';
			}
		}
	}

	function appendNotification() {
		// Seleciona o elemento com o ID 'iniNoti' onde você quer adicionar a notificação
		const iniNoti = document.getElementById('iniNoti');

		if (iniNoti) {
			// Cria o contêiner da notificação com a estrutura especificada
			const notificationContainer = document.createElement('div');
			notificationContainer.className = 'd-flex flex-stack py-4';

			// Cria o bloco interno
			const innerBlock = document.createElement('div');
			innerBlock.className = 'd-flex align-items-center';

			// Cria o símbolo
			const symbolDiv = document.createElement('div');
			symbolDiv.className = 'symbol symbol-35px me-4';

			const symbolLabel = document.createElement('span');
			symbolLabel.className = 'symbol-label bg-light-primary';

			const svgIcon = document.createElement('span');
			svgIcon.className = 'svg-icon svg-icon-2 svg-icon-primary';

			// Adiciona o ícone SVG ao símbolo
			svgIcon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-lg" viewBox="0 0 16 16">
                <path d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704zm.091-2.755a1.32 1.32 0 1 1-2.64 0 1.32 1.32 0 0 1 2.64 0" />
            </svg>
        `;

			symbolLabel.appendChild(svgIcon);
			symbolDiv.appendChild(symbolLabel);
			innerBlock.appendChild(symbolDiv);

			// Cria a div de conteúdo da notificação
			const contentDiv = document.createElement('div');
			contentDiv.className = 'mb-0 me-2';

			const contentLink = document.createElement('a');
			contentLink.href = '#';
			contentLink.className = 'fs-6 text-gray-800 text-hover-primary fw-bolder';
			contentLink.textContent = 'Configure o modo de Assinatura';

			const textDiv = document.createElement('div');
			textDiv.className = 'text-gray-400 fs-7';
			textDiv.textContent = ''; // Pode ser usado para adicionar uma mensagem adicional

			contentDiv.appendChild(contentLink);
			contentDiv.appendChild(textDiv);
			innerBlock.appendChild(contentDiv);

			// Cria o link com a badge
			const badgeLink = document.createElement('a');
			badgeLink.className = 'badge badge-light fs-8';
			badgeLink.href = '';

			// Adiciona o ícone SVG ao badge
			badgeLink.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
            </svg>
        `;

			notificationContainer.appendChild(innerBlock);
			// notificationContainer.appendChild(badgeLink);

			// Adiciona o contêiner da notificação ao elemento iniNoti
			iniNoti.appendChild(notificationContainer);
		}
	}
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

function limpa_formulário_cep() {
  //Limpa valores do formulário de cep.
  document.getElementById('cep').value = ("");
  document.getElementById('rua').value = ("");
  document.getElementById('bairro').value = ("");
  document.getElementById('cidade').value = ("");
  document.getElementById('estado').value = ("");
}

function meu_callback(conteudo) {
  if (!("erro" in conteudo)) {
	//Atualiza os campos com os valores.
	document.getElementById('rua').value = (conteudo.logradouro);
	document.getElementById('bairro').value = (conteudo.bairro);
	document.getElementById('cidade').value = (conteudo.localidade);
	document.getElementById('estado').value = (conteudo.uf);
	$('.needs-validation').removeClass('was-validated');
	$('#cep').removeClass('is-invalid');
  } //end if.
  else {
	//CEP não Encontrado.
	limpa_formulário_cep();
	$('#cep').addClass('is-invalid');

	$('.needs-validation').addClass('was-validated');
	// Exibe uma mensagem de erro para o usuário
	$('#cep').siblings('.invalid-feedback').text('CEP não encontrado.');
  }
}

function pesquisacep(valor) {

  //Nova variável "cep" somente com dígitos.
  var cep = valor.replace(/\D/g, '');

  //Verifica se campo cep possui valor informado.
  if (cep != "") {

	//Expressão regular para validar o CEP.
	var validacep = /^[0-9]{8}$/;

	//Valida o formato do CEP.
	if (validacep.test(cep)) {

	  //Preenche os campos com "..." enquanto consulta webservice.
	  document.getElementById('rua').value = "...";
	  document.getElementById('bairro').value = "...";
	  document.getElementById('cidade').value = "...";
	  document.getElementById('estado').value = "...";

	  //Cria um elemento javascript.
	  var script = document.createElement('script');

	  //Sincroniza com o callback.
	  script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

	  //Insere script no documento e carrega o conteúdo.
	  document.body.appendChild(script);

	} //end if.
	else {
	  //cep é inválido.
	  limpa_formulário_cep();
	  $('#cep').addClass('is-invalid');

	  $('.needs-validation').addClass('was-validated');
	  // Exibe uma mensagem de erro para o usuário
	  $('#cep').siblings('.invalid-feedback').text('Formato de CEP inválido.');
	}
  } //end if.
  else {
	//cep sem valor, limpa formulário.
	limpa_formulário_cep();
  }
};




$(document).ready(function() {

function limpa_formulário_cep() {
// Limpa valores do formulário de cep.
$("#rua").val("");
$("#bairro").val("");
$("#cidade").val("");
$("#uf").val("");
$("#ibge").val("");
}

//Quando o campo cep perde o foco.
$("#cep_ancora").blur(function() {

//Nova variável "cep" somente com dígitos.
var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
if (cep != "") {

	//Expressão regular para validar o CEP.
	var validacep = /^[0-9]{8}$/;

	//Valida o formato do CEP.
	if(validacep.test(cep)) {

		//Preenche os campos com "..." enquanto consulta webservice.
		$("#rua_ancora").val("...");
		$("#bairro_ancora").val("...");
		$("#cidade_ancora").val("...");
		$("#estado_ancora").val("...");
		;

		//Consulta o webservice viacep.com.br/
		$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

			if (!("erro" in dados)) {
				//Atualiza os campos com os valores da consulta.
				$("#rua_ancora").val(dados.logradouro);
				$("#bairro_ancora").val(dados.bairro);
				$("#cidade_ancora").val(dados.localidade);
				$("#estado_ancora").val(dados.uf);
				
			} //end if.
			else {
				//CEP pesquisado não foi encontrado.
				limpa_formulário_cep();
				alert("CEP não encontrado.");
			}
		});
	} //end if.
	else {
		//cep é inválido.
		limpa_formulário_cep();
		alert("Formato de CEP inválido.");
	}
} //end if.
else {
	//cep sem valor, limpa formulário.
	limpa_formulário_cep();
}
});
});

</script>
<script src="Ancora.js"></script>