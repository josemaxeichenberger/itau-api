const fs = require('fs');
const schedule = require('node-schedule');
const { exec } = require('child_process');

// Função para executar um script PHP
function runPhpScript(scriptName) {
    return new Promise((resolve, reject) => {
        const command = `php ${scriptName}`;
        exec(command, (error, stdout, stderr) => {
            if (error) {
                reject(`Erro ao executar ${scriptName}: ${stderr}`);
            } else {
                resolve(`Executado ${scriptName} com sucesso: ${stdout}`);
            }
        });
    });
}

// Função para agendar e executar scripts PHP
async function scheduleAndRunPhpScripts() {
    try {
        console.log("Iniciando execução dos scripts PHP...");
        await runPhpScript('restFornecedoresDuplicatas.php');
        console.log("Scripts PHP concluídos com sucesso.");

    } catch (error) {
        console.error("Erro durante a execução dos scripts PHP:", error);
    }
}

// Agendar a execução dos scripts a cada 6 horas (4 vezes ao dia)
schedule.scheduleJob('0 */1 * * *', () => {
    console.log("Agendando execução dos scripts PHP...");
    scheduleAndRunPhpScripts();
});

// Executar imediatamente ao iniciar o script
scheduleAndRunPhpScripts();
