
// //Nova
// var limiteDisponivel;
// function buscar() {
// 	msg = [];
// 	const
// 		obj = {},
// 		dthj = new Date(Date.now()),
// 		moneyFormat = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 }),
// 		urls = [
// 			`fetch.php?f=fornecedor`,
// 			`fetch.php?f=operacoes`,
// 			`fetch.php?f=baixadas`,
// 			`fetch.php?f=taxas`,
// 			`fetch.php?f=feriados&data=${dthj.getFullYear()}-${dthj.getMonth() + 1}-${dthj.getDate()}`,
// 			`fetch.php?f=fornecedortotalUsado`,
// 		]
// 		;
// 	let
// 		valorOriginal = 0,
// 		valorJuros = 0,
// 		valorTaxas = 0,
// 		antecipadas = 0,
// 		btns = true
// 		;

// 	Promise.all(urls.map(u => fetch(u)))
// 		.then(responses => Promise.all(responses.map(res => res.json())))
// 		.then(jsons => {
// 			obj.fornecedor = jsons[0];
// 			obj.fornecedor.operacoes = jsons[1];
// 			obj.fornecedor.postergadas = [];
// 			obj.fornecedor.novasOperacoes = [];
// 			obj.fornecedor.baixadas = jsons[2];
// 			obj.taxas = jsons[3];
// 			obj.feriado = jsons[4];
// 			obj.fornecedortotalUsado = jsons[5];
// 		}).finally(() => montaHtml()).catch(() => console.log('erro'));

// 	function montaHtml() {
// 		document.querySelector('#operacao-data').innerHTML = new Date(Date.now()).toLocaleDateString('pt-BR');
// 		document.querySelector('#fornecedor').innerHTML = obj.fornecedor.razao;

// 		const tableOperacoes = document.querySelector('#table-operacoes');
// 		tableOperacoes.innerHTML = '';
// 		console.log(obj.fornecedortotalUsado);
// 		let
// 			limite = obj.fornecedor.limite,
// 			disponivel = 0,
// 			limiteTomado = 0
// 			;
// 		if (obj.fornecedor.operacoes.length > 0) {
// 			obj.fornecedor.operacoes.forEach((op, i) => {
// 				disponivel += parseFloat(op.valor);
// 				console.log('over OP', op)
// 				const
// 					nf = op.nota.split('/'),
// 					dt = new Date(`${op.vencimento} 15:00:00`),
// 					juros = (parseFloat(obj.fornecedor.juros) === 0) ? 2.5 : parseFloat(obj.fornecedor.juros),
// 					diasMes = new Date(dthj.getFullYear(), dthj.getMonth() + 1, 0).getDate(),
// 					diaSem = dt.getDay()
// 					;
// 				let diasAd = 1;
// 				switch (diaSem) {
// 					case 0: diasAd += 1; break;
// 					case 5: diasAd += 3; break;
// 					case 6: diasAd += 2; break;
// 				}
// 				const dias = Math.floor((dt - dthj) / (1000 * 60 * 60 * 24)) + diasAd;
// 				op.dias = dias;
// 				op.jurosDia = parseFloat(juros / diasMes).toFixed(2);
// 				op.valorDesconto = parseFloat((parseFloat(op.valor) * (op.jurosDia / 100)) * dias).toFixed(2);

// 				const checkAntecipar = `<input data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Selecionar" class="form-check-input operacoes-check validarUser"  type="checkbox" onclick="validarUser()" data-attr="${i}" />`;
// 				console.log('monta operacao', dt)
// 				const tr = document.createElement('tr');
// tr.innerHTML = `
// 	<td>
// 		<div class="form-check form-check-custom form-check-solid">
// 			${checkAntecipar}
// 		</div>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7">nota fiscal</span>
// 		<span class="text-dark fw-bolder d-block fs-5">${nf[0]}</span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7">parcela</span>
// 		<span class="text-dark fw-bolder d-block fs-5">${nf[1]}</span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7">a receber</span>
// 		<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(op.valor)}</span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7">vencimento</span>
// 		<span class="text-dark fw-bolder d-block fs-5">${dt.toLocaleDateString('pt-BR')}</span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7">juros/mês</span>
// 		<span class="text-dark fw-bolder d-block fs-5">${juros}%</span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7"></span>
// 		<span class="text-dark fw-bolder d-block fs-5"></span>
// 	</td>
// 	<td>
// 		<span class="text-muted fw-bold d-block fs-7"></span>
// 		<span class="text-dark fw-bolder d-block fs-5"></span>
// 	</td>
// 	<td style="width:50px;">
// 		<span class="d-block fs-7">&nbsp;</span>
// 	</td>
// `;
// 				tableOperacoes.appendChild(tr);
// 				execTooltips();
// 			});
// 		} else {
// 			tableOperacoes.innerHTML = '';
// 			atualizaAntecipacao();
// 		}
// 		if (obj.fornecedor.baixadas.length > 0) {
// 			obj.fornecedor.baixadas.forEach((bx, i) => { limiteTomado += parseFloat(bx.valor); });
// 		}
// 		document.querySelector('#limiteDisponivel').innerHTML = moneyFormat.format(limite - limiteTomado);
// 		document.querySelector('#disponivel').innerHTML = moneyFormat.format(disponivel);
// 		document.querySelector('#limiteTomado').innerHTML = moneyFormat.format(limiteTomado);
// 		limiteDisponivel = limite - limiteTomado;
// 		//observaBtnsPostergar();
// 		observaCheckboxes();
// 	}

// 	function observaCheckboxes() {
// 		const checkboxes = document.querySelectorAll('.operacoes-check');
// 		checkboxes.forEach(c => {
// 			c.addEventListener('click', () => {
// 				const index = c.getAttribute('data-attr');
// 				if (c.checked) { obj.fornecedor.postergadas.push(index); } else { obj.fornecedor.postergadas.splice(obj.fornecedor.postergadas.indexOf(index), 1); }
// 				obj.fornecedor.operacoes[index].antecipar = (c.checked) ? true : false;
// 				atualizaAntecipacao();
// 			});
// 		});
// 	}

// 	function observaBtnsPostergar() {
// 		const postergarBtns = document.querySelectorAll('.efetuar-postergacao');
// 		postergarBtns.forEach(b => b.addEventListener('click', () => exibeModalPostergacao(b.getAttribute('data-attr'))));
// 	}

// 	function exibeModalPostergacao(n) {
// 		const ope = obj.fornecedor.operacoes[n];

// 		document.querySelector('#post-valor-original').innerHTML = moneyFormat.format(ope.valor);
// 		document.querySelector('#post-vencimento-original').innerHTML = (new Date(ope.vencimento)).toLocaleDateString('pt-BR');

// 		$("#post-vencimento-datepicker").daterangepicker({
// 			"locale": {
// 				"format": "DD/MM/YYYY",
// 				"separator": " - ",
// 				"applyLabel": "Selecionar",
// 				"cancelLabel": "Cancelar",
// 				"fromLabel": "From",
// 				"toLabel": "To",
// 				"customRangeLabel": "Custom",
// 				"weekLabel": "S",
// 				"daysOfWeek": [
// 					"Dom",
// 					"Seg",
// 					"Ter",
// 					"Qua",
// 					"Qui",
// 					"Sex",
// 					"Sab"
// 				],
// 				"monthNames": [
// 					"Janeiro",
// 					"Fevereiro",
// 					"Março",
// 					"Abril",
// 					"Maio",
// 					"Junho",
// 					"Julho",
// 					"Agosto",
// 					"Setembro",
// 					"Outubro",
// 					"Novembro",
// 					"Dezembro"
// 				],
// 			},
// 			singleDatePicker: true,
// 			autoApply: true,
// 			minDate: moment(ope.vencimento).subtract(1, 'd').add(15, "d"),
// 			maxDate: moment(ope.vencimento).subtract(1, 'd').add(30, 'd'),
// 		});

// 		$('#post-vencimento-datepicker').on('apply.daterangepicker', function (ev, picker) {
// 			calculaNovosValores(ope, n);
// 		});

// 		calculaNovosValores(ope, n);

// 		const modal = document.querySelector('#trigger-modal-postergacao');
// 		const fecha = document.querySelectorAll('.fecha-modal-postergacao');
// 		fecha.forEach(f => f.addEventListener('click', () => {
// 			modal.style.display = 'none'; // Por exemplo, ocultar o modal
// 		}));


// 		const proxima = document.querySelector('#proxima-modal-postergacao');
// 		const confirma = document.querySelector('#confirma-modal-postergacao');
// 		let idx = obj.fornecedor.postergadas.indexOf(n);

// 		if (idx < obj.fornecedor.postergadas.length - 1) {
// 			confirma.style.display = 'none';
// 			proxima.style.display = 'block';

// 			proxima.addEventListener('click', () => {
// 				fecha[0].click();
// 				setTimeout(() => {
// 					exibeModalPostergacao(obj.fornecedor.postergadas[(idx + 1)]);
// 				}, 200);
// 			});
// 		} else {
// 			proxima.style.display = 'none';
// 			confirma.addEventListener('click', () => {
// 				fecha[0].click();
// 				enviaPostergacao();
// 			});
// 			confirma.style.display = 'block';
// 		}

// 		modal.click();
// 	}


// 	function calculaNovosValores(ope, n) {
// 		function fdata(d) { let dd = d.split('/'); return dd[2] + '-' + dd[1] + '-' + dd[0]; }
// 		const
// 			dt = moment(ope.vencimento),
// 			dtn = moment(fdata(document.querySelector('#post-vencimento-datepicker').value)),
// 			juros = (parseFloat(obj.fornecedor.juros) === 0) ? 2.5 : parseFloat(obj.fornecedor.juros),
// 			dias = Math.floor((dtn - dt) / (1000 * 60 * 60 * 24)) + 1,
// 			diasMes = 30; //new Date(dtn.getFullYear(), dtn.getMonth() + 1, 0).getDate(),
// 		jurosDia = parseFloat(juros / diasMes).toFixed(2),
// 			valorJuros = parseFloat((parseFloat(ope.valor) * (jurosDia / 100)) * dias).toFixed(2),
// 			txBoleto = (parseFloat(obj.fornecedor.boleto) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'BOLETO').valor) : parseFloat(obj.fornecedor.boleto),
// 			txTac = ((parseFloat(obj.fornecedor.tac) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'TAC').valor) : parseFloat(obj.fornecedor.tac) / antecipadas),
// 			valorTaxas = parseFloat(txBoleto) + parseFloat(txTac)
// 		valorNovo = (parseFloat(ope.valor) + parseFloat(valorJuros) + parseFloat(valorTaxas)).toFixed(2)
// 			;

// 		document.querySelector('#post-juros-mes').innerHTML = juros + '%';
// 		document.querySelector('#post-acrescimo-dias').innerHTML = dias;
// 		document.querySelector('#post-valor-novo').innerHTML = moneyFormat.format(valorNovo);
// 		document.querySelector('#post-vencimento-novo').innerHTML = (new Date(dtn)).toLocaleDateString('pt-BR');
// 		document.querySelector('#post-acrescimo-juros').innerHTML = moneyFormat.format(valorJuros);
// 		document.querySelector('#post-acrescimo-taxas').innerHTML = moneyFormat.format(valorTaxas);
// 		let novaOpe = {
// 			vencimento: new Date(dtn),
// 			valor: valorNovo,
// 			valorOriginal: ope.valor,
// 			dataOPE: new Date(),
// 			taxa: valorTaxas,
// 			juros: valorJuros,
// 			status: 0
// 		}
// 		obj.fornecedor.novasOperacoes[n] = novaOpe;
// 	}

// 	async function enviaPostergacao() {
// 		const prcts = [parseFloat((30 / obj.fornecedor.postergadas.length)).toFixed(2), 25, 45];
// 		const efetuando = document.querySelector('#antecipadas-efetuando');
// 		const porcentagem = document.querySelector('#antecipadas-porcentagem');
// 		const progressbar = document.querySelector('#antecipadas-progressbar');
// 		const mensagem = document.querySelector('#antecipadas-modal-msg');
// 		const titulo = document.querySelector('#antecipadas-titulo');
// 		titulo.innerHTML = 'Efetuando Postergação…';
// 		let pcent = 0;

// 		const data_post = {
// 			metodo: 'nova_postergacao'
// 		}

// 		const postergacao_id = await fetch('fetch.php', {
// 			method: 'POST',
// 			headers: {
// 				'Accept': 'application/json, text/plain, */*',
// 				'Content-Type': 'application/json'
// 			},
// 			body: JSON.stringify(data_post)
// 		})
// 		const posterg_id = await postergacao_id.json()
// 		console.log('POSTERGACAO id RESULT', posterg_id)
// 		// return
// 		exibeModal();

// 		const nosData = [];
// 		const idsNovasOperacoes = [];
// 		obj.fornecedor.postergadas.forEach((el, idx) => {
// 			const operacao = obj.fornecedor.operacoes[el];
// 			const novaOperacao = obj.fornecedor.novasOperacoes[idx];
// 			efetuando.innerHTML = 'Efetuando postergação nota fiscal ' + operacao.nota + '…';
// 			porcentagem.innerHTML = pcent + '%';
// 			const data = {
// 				metodo: 'postergada',
// 				id: operacao.id,
// 				fornecedor: operacao.cnpj,
// 				nota: operacao.nota,
// 				valorOriginal: novaOperacao.valorOriginal,
// 				vencimento: novaOperacao.vencimento.toISOString().split('T')[0],
// 				valor: parseFloat(novaOperacao.valor),
// 				status: novaOperacao.status,
// 				taxas: novaOperacao.taxa,
// 				juros: novaOperacao.juros,
// 				postergacao_id: posterg_id
// 			}
// 			nosData.push(data);
// 		});
// 		Promise.all(nosData.map(async (d) => {
// 			efetuando.innerHTML = 'Efetuando postergação nota fiscal ' + d.nota + '…';
// 			porcentagem.innerHTML = parseFloat(pcent) + '%';
// 			await fetch('fetch.php', {
// 				method: 'POST',
// 				headers: {
// 					'Accept': 'application/json, text/plain, */*',
// 					'Content-Type': 'application/json'
// 				},
// 				body: JSON.stringify(d)
// 			})
// 				.then(res => res.text())
// 				.then(res => {
// 					idsNovasOperacoes.push(parseInt(res, 10));
// 					pcent += parseFloat(prcts[0]);
// 					porcentagem.innerHTML = pcent + '%';
// 					progressbar.setAttribute('aria-valuenow', pcent);
// 					progressbar.style.width = parseInt(pcent, 10) + '%';
// 					mensagem.innerHTML += '✔ Operação com nota fiscal ' + d.nota + ' postergada.<br>'; // ✖ ✔
// 				})
// 		})).then(() => {
// 			setTimeout(function () {
// 				efetuando.innerHTML = 'Redigindo contrato para a operações…';
// 				fetch('contrato.php', {
// 					method: 'POST',
// 					headers: {
// 						'Accept': 'application/json, text/plain, */*',
// 						'Content-Type': 'application/json'
// 					},
// 					body: JSON.stringify({ id: idsNovasOperacoes.join(',') })
// 				}).then(res => res.text()).then(json => {
// 					console.log(json);
// 					json = JSON.parse(json);
// 					if (json.criado === true) {
// 						pcent += parseFloat(prcts[1]);
// 						porcentagem.innerHTML = pcent + '%';
// 						progressbar.setAttribute('aria-valuenow', pcent);
// 						progressbar.style.width = pcent + '%';
// 						mensagem.innerHTML += '✔ Contrato criado: <a target="_blank" href="../' + json.nome + '">' + json.nome + '</a>.<br>';
// 						efetuando.innerHTML = 'Enviando contrato para assinaturas…';
// 						fetch('autentique.php', {
// 							method: 'POST',
// 							headers: {
// 								'Accept': 'application/json, text/plain, */*',
// 								'Content-Type': 'application/json'
// 							},
// 							body: JSON.stringify({ emailEmpresa: json.emailEmpresa, arquivo: json.nome, id_operacao: json.id_operacao })
// 						}).then(res => res.text()).then(res => {
// 							res = JSON.parse(res);
// 							console.log(res);
// 							if (Array.isArray(res)) {
// 								pcent += prcts[2];
// 								efetuando.innerHTML = '';
// 								porcentagem.innerHTML = pcent + '%';
// 								progressbar.setAttribute('aria-valuenow', pcent);
// 								progressbar.style.width = pcent + '%';
// 								mensagem.innerHTML += '✔ Contrato enviado para assinaturas.';
// 								titulo.innerHTML = 'Postergação Concluída!';
// 								Swal.fire({
// 									position: "top-end",
// 									icon: "success",
// 									title: "Postergação Concluída!",
// 									showConfirmButton: false,
// 									timer: 2500
// 								});
// 							} else {
// 								efetuando.innerHTML = '';
// 								porcentagem.innerHTML = '100%';
// 								progressbar.setAttribute('aria-valuenow', 100);
// 								progressbar.style.width = '100%';
// 								mensagem.innerHTML += '✖ Erro ao enviar contrato para assinatura. Erro: ' + res;
// 								titulo.innerHTML = 'Postergação Concluída!';

// 							}
// 						});
// 					} else {
// 						efetuando.innerHTML = '';
// 						porcentagem.innerHTML = '100%';
// 						progressbar.setAttribute('aria-valuenow', 100);
// 						progressbar.style.width = '100%';
// 						mensagem.innerHTML += '✖ Erro ao gerar contrato para operação ' + id + '.';
// 						titulo.innerHTML = 'Postergação Concluída!';

// 					}
// 				});
// 			}, 250);
// 		});
// 	}

// 	function atualizaAntecipacao() {
// 		valorOriginal = 0,
// 			valorJuros = 0,
// 			valorTaxas = 0,
// 			antecipadas = 0,
// 			txBoleto = 0,
// 			txTed = 0,
// 			txTac = 0;
// 		btns = true;

// 		obj.fornecedor.operacoes.forEach(op => {
// 			if (op.antecipar === true) {
// 				valorOriginal += parseFloat(op.valor);
// 				valorJuros += parseFloat(op.valorDesconto);
// 				if (op.tipo == 'cliente') { btns = false; }
// 				antecipadas++;
// 			}
// 		});
// 		if (valorOriginal > limiteDisponivel) {
// 			Swal.fire({
// 				icon: "error",
// 				title: "Oops...",
// 				confirmButtonText: "OK",
// 				text: "Seu Limite não permite Operar!",
// 				footer: '<a href="#">Entre em contato com o Ancora.</a>'
// 			  }).then((result) => {
// 				/* Read more about isConfirmed, isDenied below */
// 				if (result.isConfirmed) {
// 					window.location.reload();
// 				} 
// 			});
// 		}
// 		txBoleto = (parseFloat(obj.fornecedor.boleto) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'BOLETO').valor) : parseFloat(obj.fornecedor.boleto);
// 		txTed = (parseFloat(obj.fornecedor.ted) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'TED').valor) : parseFloat(obj.fornecedor.ted);
// 		txTac = (parseFloat(obj.fornecedor.tac) === 0) ? parseFloat(obj.taxas.find(v => v.titulo === 'TAC').valor) : parseFloat(obj.fornecedor.tac);
// 		valorTaxas += (txBoleto * antecipadas) + txTed + txTac;
// 		//obj.taxas.forEach(tx => {
// 		//	valorTaxas += (tx.titulo === 'BOLETO') ? parseFloat(tx.valor) * antecipadas : parseFloat(tx.valor);
// 		//});
// 		const footerOperacoes = document.querySelector('#footer-operacoes');
// 		const tr = document.createElement('tr');
// 		let btn = '', btn2 = '';
// 		// if (dthj.getDay() === 0 || dthj.getDay() === 6 || obj.feriado !== 'false') { btn = '<span class="d-block fs-7">&nbsp;</span>'; } 
// 		// else { 
// 		// 	btn = `
// 		// 	<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Antecipar" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
// 		// 		<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr016.svg-->
// 		// 		<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
// 		// 		<path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black"/>
// 		// 		<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black"/>
// 		// 		</svg></span>
// 		// 		<!--end::Svg Icon-->
// 		// 	</button>
// 		// 	`;
// 		btn2 = `
// 			<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Postergar" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;float:right;" id="efetuar-postergadas">
// 				<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/arrows/arr030.svg-->
// 				<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
// 				<path d="M18.4 18H16C15.7 18 15.5 17.9 15.3 17.7L12.5 14.9C12.1 14.5 12.1 13.9 12.5 13.5C12.9 13.1 13.5 13.1 13.9 13.5L16.4 16H18.4V18ZM16 6C15.7 6 15.5 6.09999 15.3 6.29999L11 10.6L6.70001 6.29999C6.50001 6.09999 6.3 6 6 6H3C2.4 6 2 6.4 2 7C2 7.6 2.4 8 3 8H5.60001L9.60001 12L5.60001 16H3C2.4 16 2 16.4 2 17C2 17.6 2.4 18 3 18H6C6.3 18 6.50001 17.9 6.70001 17.7L16.4 8H18.4V6H16Z" fill="currentColor"/>
// 				<path opacity="0.3" d="M21.7 6.29999C22.1 6.69999 22.1 7.30001 21.7 7.70001L18.4 11V3L21.7 6.29999ZM18.4 13V21L21.7 17.7C22.1 17.3 22.1 16.7 21.7 16.3L18.4 13Z" fill="currentColor"/>
// 				</svg>
// 				</span>
// 				<!--end::Svg Icon-->
// 			</button>
// 			`;
// 		// }
// 		footerOperacoes.innerHTML = '';
// 		if (antecipadas > 0) {
// 			let btnHtml = (!btns) ? btn2 : btn + '' + btn2;
// 			tr.innerHTML = `
// 			<td>
// 				<span class="text-muted fw-bold d-block"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7">valor original</span>
// 				<span class="text-dark fw-bolder d-block fs-5">${moneyFormat.format(valorOriginal.toFixed(2))}</span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td style="width:100px; text-align:center;">
// 				${btnHtml}
// 			</td>
// 		`;
// 		} else {
// 			tr.innerHTML = `
// 			<td>
// 				<span class="text-muted fw-bold d-block"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td>
// 				<span class="text-muted fw-bold d-block fs-7"></span>
// 				<span class="text-dark fw-bolder d-block fs-5"></span>
// 			</td>
// 			<td style="width:100px;">
// 				<span class="d-block fs-7">&nbsp;</span>
// 			</td>
// 		`;
// 		}
// 		footerOperacoes.appendChild(tr);
// 		execTooltips();
// 		let id = null;
// 		if (antecipadas > 0) {
// 			document.querySelector('#efetuar-postergadas').addEventListener('click', () => {
// 				const swalWithBootstrapButtons = Swal.mixin({
// 					customClass: {
// 						confirmButton: "btn btn-success",
// 						cancelButton: "btn btn-danger"
// 					},
// 					buttonsStyling: false
// 				});
// 				swalWithBootstrapButtons.fire({
// 					title: "Deseja realmente fazer a operação?",
// 					text: "",
// 					icon: "warning",
// 					showCancelButton: true,
// 					confirmButtonText: "Sim",
// 					cancelButtonText: "Não",
// 					reverseButtons: true
// 				}).then((result) => {
// 					if (result.isConfirmed) {
// 						if (obj.fornecedor.postergadas.length > 0) { exibeModalPostergacao(obj.fornecedor.postergadas[0]); }
// 					} else if (
// 						/* Read more about handling dismissals below */
// 						result.dismiss === Swal.DismissReason.cancel
// 					) {
// 						swalWithBootstrapButtons.fire({
// 							title: "Cancelado",
// 							text: "A operação não foi Finalizada.",
// 							icon: "error"
// 						});
// 					}
// 				});
// 			});
// 		}
// 	}
// }

// function exibeModal() {
// 	const modal = document.querySelector('#trigger-modal');
// 	const fecha = document.querySelectorAll('.fecha-modal');
// 	// fecha.forEach(f => f.addEventListener('click', () => buscar()));
// 	modal.click();
// }

// function execTooltips() {
// 	var createBootstrapTooltip = function (el, options) {
// 		if (el.getAttribute("data-kt-initialized") === "1") { return; }
// 		var delay = {};
// 		// Handle delay options
// 		if (el.hasAttribute('data-bs-delay-hide')) { delay['hide'] = el.getAttribute('data-bs-delay-hide'); }
// 		if (el.hasAttribute('data-bs-delay-show')) { delay['show'] = el.getAttribute('data-bs-delay-show'); }
// 		if (delay) { options['delay'] = delay; }
// 		// Check dismiss options
// 		if (el.hasAttribute('data-bs-dismiss') && el.getAttribute('data-bs-dismiss') == 'click') { options['dismiss'] = 'click'; }
// 		// Initialize popover
// 		var tp = new bootstrap.Tooltip(el, options);
// 		// Handle dismiss
// 		if (options['dismiss'] && options['dismiss'] === 'click') {
// 			// Hide popover on element click
// 			el.addEventListener("click", function (e) { tp.hide(); });
// 		}
// 		el.setAttribute("data-kt-initialized", "1");
// 		return tp;
// 	}
// 	//tooltips
// 	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
// 	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
// 		createBootstrapTooltip(tooltipTriggerEl, {});
// 	});
// }

// buscar();
var limiteDisponivel;

function buscar() {
	const currentDate = new Date(Date.now());
	const formattedDate = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
	const urls = [
		`fetch.php?f=fornecedor`,
		`fetch.php?f=operacoes`,
		`fetch.php?f=baixadas`,
		`fetch.php?f=taxas`,
		`fetch.php?f=feriados&data=${formattedDate}`,
		`fetch.php?f=fornecedortotalUsado`,
	];

	let obj = {};

	return new Promise((resolve, reject) => {
		Promise.all(urls.map(u => fetch(u)))
			.then(responses => Promise.all(responses.map(res => res.json())))
			.then(jsons => {
				obj.fornecedor = jsons[0];
				obj.fornecedor.operacoes = jsons[1];
				obj.fornecedor.postergadas = [];
				obj.fornecedor.novasOperacoes = [];
				obj.fornecedor.baixadas = jsons[2];
				obj.taxas = jsons[3];
				obj.feriado = jsons[4];
				obj.fornecedortotalUsado = jsons[5];
				resolve(obj); // Resolve the Promise with the fetched data
			})
			.catch(error => {
				console.error('Error fetching data:', error);
				reject(error); // Reject the Promise if there's an error
			});
	});
}



function montaHtml(obj) {
	// Populate date and supplier information
	document.querySelector('#operacao-data').innerHTML = new Date(Date.now()).toLocaleDateString('pt-BR');
	document.querySelector('#fornecedor').innerHTML = obj.fornecedor.razao;

	// Populate operations table
	populateOperationsTable(obj);

	// Calculate and update limits and availability
	updateLimitsAndAvailability(obj);

	// Observe checkboxes for further actions
	observaCheckboxes();
}

function populateOperationsTable(obj) {
	const tableOperacoes = document.querySelector('#table-operacoes');
	tableOperacoes.innerHTML = '';

	if (obj.fornecedor.operacoes.operations.length > 0) {
		obj.fornecedor.operacoes.operations.length.operations.forEach((op, i) => {
			const tr = createTableRowOperacao(op, i);
			tableOperacoes.appendChild(tr);
			execTooltips();
		});
	} else {
		// Handle empty operations
		tableOperacoes.innerHTML = '';
		// atualizaAntecipacao();
	}
}

function createTableRowOperacao(operation, index) {
	console.log(operation);
	// Create elements for table row
	const tr = document.createElement('tr');
	tr.innerHTML = `
					<td>
						<div class="form-check form-check-custom form-check-solid">
							<input data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Selecionar" class="form-check-input operacoes-check validarUser"  type="checkbox" onclick="validarUser()" data-attr="${index}" />
						</div>
					</td>
					
					<td>
						<div class="form-check form-check-custom form-check-solid">
							${checkAntecipar}
						</div>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7">nota fiscal</span>
						<span class="text-dark fw-bolder d-block fs-5">${operation.nota}</span>
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
						<span class="text-muted fw-bold d-block fs-7"></span>
						<span class="text-dark fw-bolder d-block fs-5"></span>
					</td>
					<td>
						<span class="text-muted fw-bold d-block fs-7"></span>
						<span class="text-dark fw-bolder d-block fs-5"></span>
					</td>
					<td style="width:50px;">
						<span class="d-block fs-7">&nbsp;</span>
					</td>
    `;
	return tr;
}

function updateLimitsAndAvailability(obj) {
	let limite = obj.fornecedor.limite;
	let disponivel = 0;
	let limiteTomado = 0;

	// Calculate disponivel and limiteTomado
	obj.fornecedor.operacoes.forEach((op) => {
		disponivel += parseFloat(op.valor);
	});

	obj.fornecedor.baixadas.forEach((bx) => {
		limiteTomado += parseFloat(bx.valor);
	});

	// Update HTML elements with calculated values
	document.querySelector('#limiteDisponivel').innerHTML = moneyFormat.format(limite - limiteTomado);
	document.querySelector('#disponivel').innerHTML = moneyFormat.format(disponivel);
	document.querySelector('#limiteTomado').innerHTML = moneyFormat.format(limiteTomado);
	limiteDisponivel = limite - limiteTomado;
}



function atualizaAntecipacao() {
	const checks = document.querySelectorAll('.operacoes-check');
	let valorTotal = 0;

	checks.forEach(check => {
		if (check.checked) {
			const index = check.getAttribute('data-attr');
			valorTotal += parseFloat(obj.operacoes[index].valor);
		}
	});

	document.getElementById('valorTotalAntecipacao').textContent = valorTotal.toFixed(2);
}


function execTooltips() {
	var createBootstrapTooltip = function (el, options) {
		if (el.getAttribute("data-kt-initialized") === "1") { return; }
		var delay = {};
		// Handle delay options
		if (el.hasAttribute('data-bs-delay-hide')) { delay['hide'] = el.getAttribute('data-bs-delay-hide'); }
		if (el.hasAttribute('data-bs-delay-show')) { delay['show'] = el.getAttribute('data-bs-delay-show'); }
		if (delay) { options['delay'] = delay; }
		// Check dismiss options
		if (el.hasAttribute('data-bs-dismiss') && el.getAttribute('data-bs-dismiss') == 'click') { options['dismiss'] = 'click'; }
		// Initialize popover
		var tp = new bootstrap.Tooltip(el, options);
		// Handle dismiss
		if (options['dismiss'] && options['dismiss'] === 'click') {
			// Hide popover on element click
			el.addEventListener("click", function (e) { tp.hide(); });
		}
		el.setAttribute("data-kt-initialized", "1");
		return tp;
	}
	//tooltips
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		createBootstrapTooltip(tooltipTriggerEl, {});
	});
}

// Add other functions as needed

// Entry point
buscar()
	.then(obj => {
		montaHtml(obj);
	})
	.catch(error => {
		console.error('Error fetching data:', error);
	});

