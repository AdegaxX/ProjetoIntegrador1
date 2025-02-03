// agendarEmail.js
const nodemailer = require('nodemailer');
const cron = require('node-cron');

// Configuração do Nodemailer para enviar o email
const transport = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 465,
    secure: true,
    auth: {
        user: 'leandroadegas2@gmail.com', // Substitua pelo seu email
        pass: 'CreedBr007@' // Substitua pela sua senha de aplicativo
    }
});

// Função que envia o email com a quantidade de pessoas interessadas
const enviarEmail = () => {
    // Aqui você pode fazer a consulta para pegar o número de pessoas
    // Vou adicionar um valor fixo como exemplo
    const numeroDePessoas = 100; // Exemplo: número fixo de pessoas

    const mailOptions = {
        from: 'leandroadegas2@gmail.com', // Substitua pelo seu email
        to: 'creedbr007@gmail.com', // Substitua pelo email que receberá o resumo
        subject: 'Resumo de Demandas de Refeições',
        html: `<h1>Resumo de Demandas</h1><p>O número de pessoas interessadas nas refeições é: ${numeroDePessoas}</p>`,
        text: `O número de pessoas interessadas nas refeições é: ${numeroDePessoas}`
    };

    transport.sendMail(mailOptions)
        .then(() => {
            console.log('Email enviado com sucesso!');
        })
        .catch((err) => {
            console.log('Erro ao enviar o email: ', err);
        });
};

// Agendar o envio de email todos os dias às 21h, de domingo a sexta-feira
cron.schedule('25 20 * * 0-5', () => {
    console.log('Enviando email...');
    enviarEmail();
});
