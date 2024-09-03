const fs = require('fs');
const schedule = require('node-schedule');
const { exec } = require('child_process');

// Função para executar um script PHP
function runPhpScript(scriptName) {
    return new Promise((resolve, reject) => {
        const command = `php ${scriptName}`;
        exec(command, (error, stdout, stderr) => {
            if (error) {
                console.error(`Erro ao executar script PHP '${scriptName}':`, stderr);
                reject(error);
            } else {
                console.log(`Script PHP '${scriptName}' executado com sucesso.`);
                resolve(stdout);
            }
        });
    });
}

// Agendar a execução dos scripts PHP
async function schedulePhpScripts() {
    try {
        console.log("Iniciando execução dos scripts PHP...");

        // Execute cada script PHP individualmente
        await runPhpScript('FilaMailService.php');
        // await runPhpScript('restClientesDuplicatas.php');

        console.log("Scripts PHP concluídos com sucesso.");

    } catch (error) {
        console.error("Erro durante a execução dos scripts PHP:", error);
    }
}

// Agendar a execução dos scripts a cada 5 minutos
schedule.scheduleJob('*/10 * * * * *', schedulePhpScripts);

// Executar imediatamente ao iniciar o script
schedulePhpScripts();
