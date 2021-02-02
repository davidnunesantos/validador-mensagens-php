/**
 * @file Este arquivo é o controlador de todo o funcionamento da página web
 * @author David Nunes dos Santos <david_nunesantos@hotmail.com>
 */

$(function() {
	$('#uploadFileForm').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: "/src/classes/UploadFile.php",
			type: 'POST',
			data: new FormData(this),
			processData: false,
			contentType: false,
			beforeSend: () => {
				clearAll();
				showLoading(true);
				showResults(true);
				disableForm(true);
			},
			success: function (data, status)
			{
				var result = $.parseJSON(data);

				if (result.status) {
					showInHTML(result.valid, result.blocked);
				} else {
					noticeMessage(true, result.erro);
					showResults(false);
				}

				showLoading(false);
				disableForm(false);
			},
			error: function (xhr, desc, err)
			{
				noticeMessage(true, 'Hove um erro ao enviar o arquivo, tente novamente mais tarde');
				showLoading(false);
				disableForm(false);
				showResults(false);
			}
		});
	});
});

/**
 * Reseta os componentes da página para o status inicial
 */
function clearAll() {
	disableForm(false);
	noticeMessage(false);
	showResults(false);
	clearResults();
}

/**
 * Habilita ou desabilita o campo de mensagem de aviso
 * @param {boolean} enable Indica se a mensagem deve ser exibida ou não
 * @param {?string} message Mensagem a ser exibida
 */
function noticeMessage(enable, message = '') {
	$('#alertBlock').find('.alert').html(message);
	$('#alertBlock').toggleClass('d-none', !enable);
}

/**
 * Mostra ou esconde o bloco de resultados
 * @param {boolean} show Indica se o bloco de resultados deve ser exibido ou não
 */
function showResults(show) {
	$('.resultados').toggleClass('d-none', !show);
}

/**
 * Habilita ou desabilita os spinners de carregamento
 * @param {boolean} show Indica se os spinners de carregamento devem ser exibidos ou não
 */
function showLoading(show) {
	$('.loading').toggleClass('d-none', !show);
	$('.loading').toggleClass('d-flex', show);
	$('#table-blocked').toggleClass('d-none', show);
}

/**
 * Remove os dados dos blocos de validos e bloqueados
 */
function clearResults() {
	$('#validos').find('#conteudo').empty();
	$('#bloqueados').find('#table-blocked').find('tbody').empty();
}

/**
 * Desabilita ou habilita os campos do formulário
 * @param {boolean} disable Indica se os campos do formulário devem ser desabilitados ou não
 */
function disableForm(disable) {
	$('#submit_button').prop('disabled', disable);
	$('#arquivo').prop('disabled', disable);
}

 /**
  * Percorre as mensagens válidas e bloqueadas e manda seus dados para o HTML
  * @param {Object.<string, Object<string, any>>} valid
  * @param {Object.<number, Object<string, any>>} blocked
  */
function showInHTML(valid, blocked) {
	Object.keys(valid).forEach((chave) => {
		addValidLine(valid[chave]);
	});

	Object.keys(blocked).forEach((chave) => {
		addBlockedLine(blocked[chave]);
	});
}

/**
 * Adiciona uma nova linha ao bloco de dados válidos
 * @param {Object<string, any>} data_send Dados de uma mensagem
 */
function addValidLine(data_send) {
	$('#validos').find('#conteudo').append($('<div />').addClass('col-12').html(data_send.idmensagem + ';' + data_send.broker_id));
}

/**
 * Adiciona uma nova linha a tabela de dados bloqueados
 * @param {Object<string, any>} data_send Dados de uma mensagem
 */
function addBlockedLine(data_send) {
	$('#bloqueados').find('#table-blocked').find('tbody').append(
		$('<tr />').append(
			$('<td />').html(data_send.idmensagem)
		).append(
			$('<td />').html(data_send.ddd)
		).append(
			$('<td />').html(data_send.celular)
		).append(
			$('<td />').html(data_send.operadora)
		).append(
			$('<td />').html(data_send.horario_envio)
		).append(
			$('<td />').html(data_send.mensagem)
		).append(
			$('<td />').html(data_send.motivo_bloqueio)
		)
	);
}