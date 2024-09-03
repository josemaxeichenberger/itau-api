function buscar() {
	msg = [];
	const obj = {};
	const dthj = new Date(Date.now());
	const urls = [
		`fetch.php?f=fornecedor`,
		`fetch.php?f=operacoes`,
		`fetch.php?f=baixadas`,
		`fetch.php?f=taxas`,
		`fetch.php?f=feriados&data=${dthj.getFullYear()}-${dthj.getMonth()+1}-${dthj.getDate()}`
	]
	const moneyFormat = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 });
	let valorOriginal = 0,
		valorJuros = 0,
		valorTaxas = 0,
		antecipadas = 0;

	Promise.all(urls.map(u => fetch(u)))
		.then(responses => Promise.all(responses.map(res => res.json())))
		.then(jsons => {
			obj.fornecedor = jsons[0];
			obj.fornecedor.operacoes = jsons[1];
			obj.fornecedor.baixadas = jsons[2];
			obj.taxas = jsons[3];
			obj.feriado = jsons[4];
		}).finally(() => montaHtml()).catch(() => console.log('erro'));

	function montaHtml() {
    document.querySelector('#operacao-data').innerHTML = new Date(Date.now()).toLocaleDateString('pt-BR');
		document.querySelector('#fornecedor').innerHTML = obj.fornecedor.razao;

		const tableOperacoes = document.querySelector('#table-operacoes');
		tableOperacoes.innerHTML = '';
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
					case 0: diasAd += 1; break;
					case 5: diasAd += 3; break;
					case 6: diasAd += 2; break;
				}
				const dias = Math.floor((dt - dthj) / (1000 * 60 * 60 * 24)) + diasAd;
				op.dias = dias;
				op.jurosDia = parseFloat(juros / diasMes).toFixed(2);
				op.valorDesconto = parseFloat((parseFloat(op.valor) * (op.jurosDia / 100)) * dias).toFixed(2);
				const tr = document.createElement('tr');
				tr.innerHTML = `
					<td>
						<div class="form-check form-check-custom form-check-solid">
							<input class="form-check-input operacoes-check" type="checkbox" data-attr="${i}" />
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
				tableOperacoes.appendChild(tr);
			});
		} else {
			tableOperacoes.innerHTML = '';
			atualizaAntecipacao();
		}
		if (obj.fornecedor.baixadas.length > 0) {
			obj.fornecedor.baixadas.forEach((bx, i) => { limiteTomado += parseFloat(bx.valor); });
		}
		document.querySelector('#limiteDisponivel').innerHTML = moneyFormat.format(limite - limiteTomado);
		document.querySelector('#disponivel').innerHTML = moneyFormat.format(disponivel);
		document.querySelector('#limiteTomado').innerHTML = moneyFormat.format(limiteTomado);
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
		if (dthj.getDay() === 0 || dthj.getDay() === 6 || obj.feriado !== 'false') { btn = '<span class="d-block fs-7">&nbsp;</span>'; } 
		else { 
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
				fetch('fetch.php', {
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
							porcentagem.innerHTML = pcent+'%';
							fetch('fetch.php', {
								method: 'POST',
								headers: {
									'Accept': 'application/json, text/plain, */*',
									'Content-Type': 'application/json'
								},
								body: JSON.stringify(d)
							}).then(res => res.text()).then(res => {
								pcent += prcts[0];
								porcentagem.innerHTML = pcent+'%';
								progressbar.setAttribute('aria-valuenow', pcent);
								progressbar.style.width = pcent+'%';
								mensagem.innerHTML += '✔ Operação com nota fiscal ' + d.nota + ' antecipada.<br>'; // ✖ ✔
							});
						})).then(() => {
							setTimeout(function() { 
								efetuando.innerHTML = 'Redigindo contrato para a operação '+id+'…';
								fetch('contrato.php', {
									method: 'POST',
									headers: {
										'Accept': 'application/json, text/plain, */*',
										'Content-Type': 'application/json'
									},
									body: JSON.stringify({id: id})
								}).then(res => res.text()).then(json => {
									json = JSON.parse(json);
									if (json.criado === true) {
										pcent += prcts[1];
										porcentagem.innerHTML = pcent + '%';
										progressbar.setAttribute('aria-valuenow', pcent);
										progressbar.style.width = pcent + '%';
										mensagem.innerHTML += '✔ Contrato criado: <a target="_blank" href="' + json.nome + '">' + json.nome +'</a>.<br>';
										efetuando.innerHTML = 'Enviando contrato para assinaturas…';
										fetch('autentique.php', {
											method: 'POST',
											headers: {
												'Accept': 'application/json, text/plain, */*',
												'Content-Type': 'application/json'
											},
											body: JSON.stringify({ emailEmpresa: json.emailEmpresa, arquivo: json.nome })
										}).then(res => res.text()).then(res => {
											res = JSON.parse(res);
											console.log(res);
											if (Array.isArray(res)) {
												if (res.length == 4) {
													let ret = JSON.parse(res[3]);
													pcent += prcts[2];
													efetuando.innerHTML = '';
													porcentagem.innerHTML = pcent + '%';
													progressbar.setAttribute('aria-valuenow', pcent);
													progressbar.style.width = pcent + '%';
													mensagem.innerHTML += '✔ Contrato enviado para assinaturas. Id autentique: ' + ret.data.createDocument.id;
													titulo.innerHTML = 'Antecipação Concluída!';
												} else {
													efetuando.innerHTML = '';
													porcentagem.innerHTML = '100%';
													progressbar.setAttribute('aria-valuenow', 100);
													progressbar.style.width = '100%';
													mensagem.innerHTML += '✖ Erro ao enviar contrato para assinatura.Erro: '+res;
													titulo.innerHTML = 'Antecipação Concluída!';
												}
											} else {
												efetuando.innerHTML = '';
												porcentagem.innerHTML = '100%';
												progressbar.setAttribute('aria-valuenow', 100);
												progressbar.style.width = '100%';
												mensagem.innerHTML += '✖ Erro ao enviar contrato para assinatura. Erro: '+res;
												titulo.innerHTML = 'Antecipação Concluída!';
											}										
										});
									} else {
										efetuando.innerHTML = '';
										porcentagem.innerHTML = '100%';
										progressbar.setAttribute('aria-valuenow', 100);
										progressbar.style.width = '100%';
										mensagem.innerHTML += '✖ Erro ao gerar contrato para operação '+id+'.';
										titulo.innerHTML = 'Antecipação Concluída!';
									}
								});
							}, 250);
						});
					});
			});
		}
	}
}

function exibeModal() {
	const modal = document.querySelector('#trigger-modal');
	const fecha = document.querySelectorAll('.fecha-modal');
	fecha.forEach(f => f.addEventListener('click', () => buscar()));
	modal.click();
}

buscar();