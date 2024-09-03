(() => {
    'use strict';

    // Seleciona o primeiro formulário com o ID 'formAncora'
    const form = document.querySelector('.needs');

    // Adiciona um evento de envio ao formulário
    form.addEventListener('submit', event => {
        // Previne o envio do formulário se ele não for válido
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Adiciona a classe 'was-validated' ao formulário para aplicar os estilos de validação
        form.classList.add('was-validated');

        // Se o formulário for válido, envie via AJAX
        if (form.checkValidity()) {
            event.preventDefault(); // Previne o envio padrão do formulário

            // Obtenha os dados do formulário
            const formData = new FormData(form);
            
            // Envie os dados do formulário via AJAX
            $.ajax({
                type: 'POST', // O método HTTP a ser utilizado
                url: '../Controllers/AncoraController.php', // URL para enviar o formulário
                data: formData, // Dados do formulário
                processData: false, // Não processar os dados automaticamente
                contentType: false, // Não definir um tipo de conteúdo específico
                success: function(data) {
                    // Manipular a resposta de sucesso do servidor aqui
                        console.log(data);
                        Swal.fire({
                            icon: "success",
                            title: "Sucesso!",
                            text: "Formulário enviado com sucesso!"
                        });
                   
                    // Adicione ações adicionais com base na resposta do servidor
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manipular erros de envio aqui
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Erro ao enviar o formulário!"
                    });
                    console.error('Erro ao enviar o formulário:', textStatus, errorThrown);
                    // Adicione ações adicionais em caso de erro
                }
            });
        }
    }, false);
})();