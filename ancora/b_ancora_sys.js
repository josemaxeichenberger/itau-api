function buscar(cnpj) {

	msg = [];
	const obj = {};
	const dthj = new Date(Date.now());
	const urls = [
		`getDiscont.php?f=fornecedor&cnpj=${cnpj}`,
		`getDiscont.php?f=operacoes&cnpj=${cnpj}`,
		`getDiscont.php?f=baixadas&cnpj=${cnpj}`,
		`getDiscont.php?f=taxas&cnpj=${cnpj}`,
		`getDiscont.php?f=feriados&data=${dthj.getFullYear()}-${dthj.getMonth() + 1}-${dthj.getDate()}&cnpj=${cnpj}`,
		`getDiscont.php?f=PercentualLimiteUsado&cnpj=${cnpj}`
	]
	const moneyFormat = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 });
	let valorOriginal = 0,
		valorJuros = 0,
		valorTaxas = 0,
		antecipadas = 0;


	Promise.all(urls.map(u => fetch(u)))
		.then(responses => {
			console.log(responses);

			// Verifica se houve algum erro nas respostas das requisições
			const erroResponse = responses.find(response => !response.ok);
			if (erroResponse) {
				throw new Error(`Erro na requisição: ${erroResponse.status} - ${erroResponse.statusText}`);
			}

			return Promise.all(responses.map(res => res.json()));
		})
		.then(jsons => {
			// Check if the responses contain valid JSON
			const invalidJson = jsons.find(json => typeof json !== 'object');
			if (invalidJson) {
				throw new Error(`Resposta inválida: ${JSON.stringify(invalidJson)}`);
			}

			obj.fornecedor = jsons[0];
			obj.fornecedor.operacoes = jsons[1];
			obj.fornecedor.baixadas = jsons[2];
			obj.taxas = jsons[3];
			obj.feriado = jsons[4];
			obj.percentualUsado = jsons[5];
		})
		.then(() => montaHtml())
		.catch(error => console.error('Erro:', error));

	function montaHtml() {
		console.log(obj.fornecedor);
		document.querySelector('#operacao-data').innerHTML = new Date(Date.now()).toLocaleDateString('pt-BR');
		// document.querySelector('#fornecedor').innerHTML = obj.fornecedor.razao;

		const tableOperacoes = document.querySelector('#table-operacoes');
		const dadosCliente = document.querySelector('#dadosCliente');
		tableOperacoes.innerHTML = '';
		dadosCliente.innerHTML = '';
		let limite = obj.fornecedor.limite,
			disponivel = 0,
			limiteTomado = 0;
		if (obj.fornecedor.operacoes.length > 0) {
			obj.fornecedor.operacoes.forEach((op, i) => {
				disponivel += parseFloat(op.valor);
				const nf = op.nota.split('/');
				const dt = new Date(op.vencimento);
				const juros = (parseFloat(obj.fornecedor.juros) === 0) ? 2.5 : parseFloat(obj.fornecedor.juros);
				const diasMes = new Date(dthj.getFullYear(), dthj.getMonth() + 1, 0).getDate();
				const diaSem = dt.getDay();
				let diasAd = 1;
				switch (diaSem) {
					case 0: diasAd += 2; break;
					case 5: diasAd += 3; break;
					case 6: diasAd += 3; break;
				}
				const dias = Math.floor((dt - dthj) / (1000 * 60 * 60 * 24)) + diasAd;
				op.dias = dias;
				op.jurosDia = parseFloat(juros / diasMes).toFixed(2);
				op.valorDesconto = parseFloat((parseFloat(op.valor) * (op.jurosDia / 100)) * dias).toFixed(2);
				const tr = document.createElement('tr');
				if (obj.fornecedor.conta != '' && obj.fornecedor.agencia != '' && obj.fornecedor.banco != '') {

					tr.innerHTML = `
					<td>
						<div class="form-check form-check-custom form-check-solid">
							<input class="form-check-input operacoes-check" type="checkbox"  data-attr="${i}" />
						</div>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">nota fiscal</span>
						<span class="text-dark fw-bolder d-block fs-5">${nf[0]}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">parcela</span>
						<span class="text-dark fw-bolder d-block fs-5">${nf[1]}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">a receber</span>
						<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(op.valor)}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">vencimento</span>
						<span class="text-dark fw-bolder d-block fs-5">${dt.toLocaleDateString('pt-BR')}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">juros/mês</span>
						<span class="text-dark fw-bolder d-block fs-5">${juros}%</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">dias</span>
						<span class="text-dark fw-bolder d-block fs-5">${op.dias}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">descontos</span>
						<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(parseFloat(op.valorDesconto).toFixed(2))}*</span>
					</td>
					<td style="width:50px;">
						<span class="d-block fs-7">&nbsp;</span>
					</td>
				`;
				} else {
					tr.innerHTML = `
					<td>
						<div class="form-check form-check-custom form-check-solid">
						Sem Dados Bancários
						</div>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">nota fiscal</span>
						<span class="text-dark fw-bolder d-block fs-5">${nf[0]}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">parcela</span>
						<span class="text-dark fw-bolder d-block fs-5">${nf[1]}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">a receber</span>
						<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(op.valor)}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">vencimento</span>
						<span class="text-dark fw-bolder d-block fs-5">${dt.toLocaleDateString('pt-BR')}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">juros/mês</span>
						<span class="text-dark fw-bolder d-block fs-5">${juros}%</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">dias</span>
						<span class="text-dark fw-bolder d-block fs-5">${op.dias}</span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">descontos</span>
						<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(parseFloat(op.valorDesconto).toFixed(2))}*</span>
					</td>
					<td style="width:50px;">
						<span class="d-block fs-7">&nbsp;</span>
					</td>
				`;
				}
				tableOperacoes.appendChild(tr);



			});
		} else {
			tableOperacoes.innerHTML = '';
			atualizaAntecipacao();
		}
		if (obj.fornecedor.baixadas.length > 0) {
			obj.fornecedor.baixadas.forEach((bx, i) => { limiteTomado += parseFloat(bx.valor); });
		}
		const divC = document.createElement('div');
		divC.innerHTML = '<div class="row g-5 g-xl-8">' +
			'<div class="col-xl-12">' +
			'<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">' +
			'<div class="card-header cursor-pointer">' +
			'<div class="card-title m-0">' +
			'<h3 class="fw-bolder m-0">Detalhes do Cliente</h3>' +
			'</div>' +
			'<a href="#" onClick="abre_dados(' + obj.fornecedor.id + ');" class="btn btn-primary align-self-center">Editar Dados</a>' +
			'</div>' +
			'<div class="card-body p-9">' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Tipo de Registro:</label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">' + obj.fornecedor.tipo + '</span>' +
			'</div>' +
			'</div>' +

			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Razão Social:</label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">' + obj.fornecedor.razao + '</span>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">CNPJ</label>' +
			'<div class="col-lg-8 fv-row">' +
			'<span class="fw-bold text-gray-800 fs-6">' + obj.fornecedor.cnpj + '</span>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Telefone' +
			'<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Phone number must be active" aria-label="Phone number must be active"></i></label>' +
			'<div class="col-lg-8 d-flex align-items-center">' +
			'<span class="fw-bolder fs-6 text-gray-800 me-2">' + obj.fornecedor.telefone + '</span>' +
			'<span class="badge badge-success">Verified</span>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">E-mail</label>' +
			'<div class="col-lg-8">' +
			'<a href="#" class="fw-bold fs-6 text-gray-800 text-hover-primary">' + obj.fornecedor.email + '</a>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Endereço' +
			'<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Country of origination" aria-label="Country of origination"></i></label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">' + obj.fornecedor.rua + ', ' + obj.fornecedor.numero + ',' + obj.fornecedor.bairro + ', ' + obj.fornecedor.cidade + ' - ' + obj.fornecedor.estado + ' / ' + obj.fornecedor.cep + '</span>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Representante</label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">' + obj.fornecedor.representante + ' <small>' + obj.fornecedor.cpf + '</small></span>' +
			'</div>' +
			'</div>' +

			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Taxas:</label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">Juros: ' + obj.fornecedor.juros + ' | TAC: ' + obj.fornecedor.tac + ' | Boleto: ' + obj.fornecedor.boleto + ' | TED: ' + obj.fornecedor.ted + '</span>' +
			'</div>' +
			'</div>' +
			'<div class="row mb-7">' +
			'<label class="col-lg-4 fw-bold text-muted">Dados Bancários:</label>' +
			'<div class="col-lg-8">' +
			'<span class="fw-bolder fs-6 text-gray-800">Banco: ' + obj.fornecedor.banco + '| Agência: ' + obj.fornecedor.agencia + ' | Conta: ' + obj.fornecedor.conta + '</span>' +
			'</div>' +
			'</div>' +

			'</div>' +
			'<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">' +
			'<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">' +
			'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">' +
			'<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>' +
			'<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>' +
			'<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>' +
			'</svg>' +
			'</span>' +
			'<div class="d-flex flex-stack flex-grow-1">' +
			'<div class="fw-bold">' +
			'<h4 class="text-gray-900 fw-bolder">Atenção</h4>' +
			'<div class="fs-6 text-gray-700">Cliente já utilizou mais de ' + obj.percentualUsado + '% do limite disponível.</div>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';
		dadosCliente.appendChild(divC);
		// document.querySelector('#limiteDisponivel').innerHTML = moneyFormat.format(limite - limiteTomado);
		// document.querySelector('#disponivel').innerHTML = moneyFormat.format(disponivel);
		// document.querySelector('#limiteTomado').innerHTML = moneyFormat.format(limiteTomado);
		observaCheckboxes();
	}

	function observaCheckboxes() {
		const checkboxes = document.querySelectorAll('.operacoes-check');
		checkboxes.forEach(c => {
			c.addEventListener('click', () => {
				const index = c.getAttribute('data-attr');
				obj.fornecedor.operacoes[index].antecipar = (c.checked) ? true : false;
				atualizaAntecipacao();
			});
		});
	}

	function atualizaAntecipacao() {
		valorOriginal = 0,
			valorJuros = 0,
			valorTaxas = 0,
			antecipadas = 0,
			txBoleto = 0,
			txTed = 0,
			txTac = 0;
		if (obj.fornecedor.operacoes.length > 0) {
			obj.fornecedor.operacoes.forEach(op => {
				if (op.antecipar === true) {
					valorOriginal += parseFloat(op.valor);
					valorJuros += parseFloat(op.valorDesconto);
					antecipadas++;
				}
			});
			txBoleto = (parseFloat(obj.fornecedor.boleto) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'BOLETO').valor) : parseFloat(obj.fornecedor.boleto);
			txTed = (parseFloat(obj.fornecedor.ted) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'TED').valor) : parseFloat(obj.fornecedor.ted);
			txTac = (parseFloat(obj.fornecedor.tac) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'TAC').valor) : parseFloat(obj.fornecedor.tac);
			valorTaxas += (txBoleto * antecipadas) + txTed + txTac;
			//obj.taxas.forEach(tx => {
			//	valorTaxas += (tx.titulo === 'BOLETO') ? parseFloat(tx.valor) * antecipadas : parseFloat(tx.valor);
			//});
			const footerOperacoes = document.querySelector('#footer-operacoes');
			const tr = document.createElement('tr');
			let btn = '';
			if (dthj.getDay() === 0 || dthj.getDay() === 6 || obj.feriado !== 'false') {
				btn = `
			<button class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
				<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr016.svg-->
				<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black"/>
				<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black"/>
				</svg></span>
				<!--end::Svg Icon-->
			</button>
			`;
			}
			else {
				btn = '<span class="d-block fs-7">&nbsp;</span>';
			}
			footerOperacoes.innerHTML = '';
			if (antecipadas > 0) {
				tr.innerHTML = `
			<td>
				<span class="text-muted fw-bold d-block"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7"></span>
				<span class="text-dark fw-bolder d-block fs-5"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7"></span>
				<span class="text-dark fw-bolder d-block fs-5"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">valor original</span>
				<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(valorOriginal.toFixed(2))}</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">vencimento</span>
				<span class="text-dark fw-bolder d-block fs-5">${dthj.toLocaleDateString('pt-BR')}</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">desconto juros</span>
				<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(valorJuros.toFixed(2))}</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">desconto taxas</span>
				<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(valorTaxas.toFixed(2))}</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">valor antecipação</span>
				<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(parseFloat(valorOriginal - (valorJuros + valorTaxas)).toFixed(2))}*</span>
			</td>
			<td style="width:50px; text-align:center;">
				${btn}
			</td>
		`;
			} else {
				tr.innerHTML = `
			<td>
				<span class="text-muted fw-bold d-block"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7"></span>
				<span class="text-dark fw-bolder d-block fs-5"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7"></span>
				<span class="text-dark fw-bolder d-block fs-5"></span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">valor original</span>
				<span class="text-dark fw-bolder d-block fs-5">R$ 0,00</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">vencimento</span>
				<span class="text-dark fw-bolder d-block fs-5">--/--/----</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">desconto juros</span>
				<span class="text-dark fw-bolder d-block fs-5">R$ 0,00</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">desconto taxas</span>
				<span class="text-dark fw-bolder d-block fs-5">R$ 0,00</span>
			</td>
			<td>
				<span class="text-muted fw-bold d-block fs-7">valor antecipação</span>
				<span class="text-dark fw-bolder d-block fs-5">R$ 0,00*</span>
			</td>
			<td style="width:50px;">
				<span class="d-block fs-7">&nbsp;</span>
			</td>
		`;
			}
			footerOperacoes.appendChild(tr);
			let id = null;
			if (antecipadas > 0) {

				document.querySelector('#efetuar-antecipadas').addEventListener('click', () => {
					const swalWithBootstrapButtons = Swal.mixin({
						customClass: {
							confirmButton: "btn btn-success",
							cancelButton: "btn btn-danger"
						},
						buttonsStyling: false
					});
					swalWithBootstrapButtons.fire({
						title: "Deseja realmente fazer a operação?",
						text: "",
						icon: "warning",
						showCancelButton: true,
						confirmButtonText: "Sim",
						cancelButtonText: "Não",
						reverseButtons: true
					}).then((result) => {
						if (result.isConfirmed) {
							//ini
							const prcts = [parseFloat((30 / antecipadas).toFixed(2)), 25, 45];
							const efetuando = document.querySelector('#antecipadas-efetuando');
							const porcentagem = document.querySelector('#antecipadas-porcentagem');
							const progressbar = document.querySelector('#antecipadas-progressbar');
							const mensagem = document.querySelector('#antecipadas-modal-msg');
							const titulo = document.querySelector('#antecipadas-titulo');
							let pcent = 0;
							exibeModal();
							const data = {
								metodo: 'antecipadas',
								fornecedor: obj.fornecedor.id,
								data: dthj.toISOString().split('T')[0],
								valorOriginal: valorOriginal,
								descontoJuros: valorJuros,
								descontoTaxas: valorTaxas,
								valor: valorOriginal - (valorJuros + valorTaxas),
								status: 0
							}
							fetch('fetchBycnpj.php', {
								method: 'POST',
								headers: {
									'Accept': 'application/json, text/plain, */*',
									'Content-Type': 'application/json'
								},
								body: JSON.stringify(data)
							})
								.then(res => res.text())
								.then(res => {
									id = parseInt(res, 10);
									const paraAntecipar = obj.fornecedor.operacoes.filter((op) => { return op.antecipar === true; });
									const dataFetches = [];
									paraAntecipar.forEach(a => {
										const dataOp = {
											metodo: 'detalhes',
											antecipada: id,
											operacao: a.id,
											nota: a.nota,
											data: dthj.toISOString().split('T')[0],
											valorOriginal: parseFloat(a.valor),
											descontoJuros: a.valorDesconto,
											valor: a.valor - a.valorDesconto
										}
										dataFetches.push(dataOp);
									});
									Promise.all(dataFetches.map(d => {
										efetuando.innerHTML = 'Efetuando antecipação nota fiscal ' + d.nota + '…';
										porcentagem.innerHTML = pcent + '%';
										fetch('fetchBycnpj.php', {
											method: 'POST',
											headers: {
												'Accept': 'application/json, text/plain, */*',
												'Content-Type': 'application/json'
											},
											body: JSON.stringify(d)
										}).then(res => res.text()).then(res => {
											pcent += prcts[0];
											porcentagem.innerHTML = pcent + '%';
											progressbar.setAttribute('aria-valuenow', pcent);
											progressbar.style.width = pcent + '%';
											mensagem.innerHTML += '✔ Operação com nota fiscal ' + d.nota + ' antecipada.<br>'; // ✖ ✔
										});
									})).then(() => {
										setTimeout(function () {
											// Define uma mensagem de progresso
											efetuando.innerHTML = 'Redigindo contrato para a operação ' + id + '…';
											const data = {
												id: id,
												cnpj: obj.fornecedor.cnpj

											}
											// Realiza uma solicitação POST para 'contrato.php' com dados em formato JSON
											fetch('contrato.php', {
												method: 'POST',
												headers: {
													'Accept': 'application/json, text/plain, */*',
													'Content-Type': 'application/json'
												},
												body: JSON.stringify(data)
											}).then(res => res.text()).then(json => {
												// Analisa a resposta JSON
												json = JSON.parse(json);
												console.log(json);
												if (json.criado === true) {
													// Atualiza a porcentagem de progresso e a barra de progresso
													pcent += prcts[1];
													porcentagem.innerHTML = pcent + '%';
													progressbar.setAttribute('aria-valuenow', pcent);
													progressbar.style.width = pcent + '%';

													// Exibe uma mensagem de sucesso com um link para o contrato criado
													mensagem.innerHTML += '✔ Contrato criado: <a target="_blank" href="' + json.nome + '">' + json.nome + '</a>.<br>';
													efetuando.innerHTML = 'Enviando contrato para assinaturas…';

													// Realiza uma solicitação POST para 'autentique.php' com dados em formato JSON
													fetch('autentique.php', {
														method: 'POST',
														headers: {
															'Accept': 'application/json, text/plain, */*',
															'Content-Type': 'application/json'
														},
														body: JSON.stringify({ emailEmpresa: json.emailEmpresa, arquivo: json.nome, id_operacao: json.id_operacao })
													}).then(res => res.text()).then(res => {
														// Analisa a resposta JSON
														result = JSON.parse(res);
														res = JSON.parse(result);
														console.log(res);

														// if (Array.isArray(res)) {
														if (res.list) {
															// Atualiza a porcentagem de progresso e a mensagem
															let ret = res.list.request_signature_key;
															pcent += prcts[2];
															efetuando.innerHTML = '';
															porcentagem.innerHTML = pcent + '%';
															progressbar.setAttribute('aria-valuenow', pcent);
															progressbar.style.width = pcent + '%';
															mensagem.innerHTML += '✔ Contrato enviado para assinaturas. Id autentique: ' + ret;
															titulo.innerHTML = 'Antecipação Concluída!';
															Swal.fire({
																position: "top-end",
																icon: "success",
																title: "Antecipação Concluída!",
																showConfirmButton: false,
																timer: 2500
															});
															// } else {
															// 	// Exibe uma mensagem de erro
															// 	efetuando.innerHTML = '';
															// 	porcentagem.innerHTML = '100%';
															// 	progressbar.setAttribute('aria-valuenow', 100);
															// 	progressbar.style.width = '100%';
															// 	mensagem.innerHTML += '✖ Erro ao enviar contrato para assinatura. Erro: ' + res;
															// 	titulo.innerHTML = 'Antecipação Concluída!';
															// }
														} else {
															// Exibe uma mensagem de erro
															efetuando.innerHTML = '';
															porcentagem.innerHTML = '100%';
															progressbar.setAttribute('aria-valuenow', 100);
															progressbar.style.width = '100%';
															mensagem.innerHTML += '✖ Erro ao enviar contrato para assinatura. Erro: ' + res;
															titulo.innerHTML = 'Antecipação Concluída!';
															
														}
													});
												} else {
													// Exibe uma mensagem de erro
													efetuando.innerHTML = '';
													porcentagem.innerHTML = '100%';
													progressbar.setAttribute('aria-valuenow', 100);
													progressbar.style.width = '100%';
													mensagem.innerHTML += '✖ Erro ao gerar contrato para operação ' + id + '.';
													titulo.innerHTML = 'Antecipação Concluída!';
											
												}
											});
										}, 250);

									});
								});
							// fim
						} else if (
							/* Read more about handling dismissals below */
							result.dismiss === Swal.DismissReason.cancel
						) {
							swalWithBootstrapButtons.fire({
								title: "Cancelado",
								text: "A operação não foi Finalizada.",
								icon: "error"
							});
						}
					});
				});
			}
		}
	}
}

function exibeModal() {
	const modal = document.querySelector('#trigger-modal');
	const fecha = document.querySelectorAll('.fecha-modal');
	fecha.forEach(f => f.addEventListener('click', () => buscar()));
	modal.click();
}
