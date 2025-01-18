const nodemailer = require('nodemailer');

const transport = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 465,
    secure: true,
    auth: {
        user: 'rian.ssrb@gmail.com',
        pass: 'lhvqwckoxiypbzdn'
    }
});

transport.sendMail({
    from: 'rian.ssrb@gmail.com',
    to: 'leandroadegas2@gmail.com',
    subject: 'Enviando email com Nodemailer',
    html: '<h1> Anão Bombado!</h1> <p>Esse email foi enviado usando o Nodemailer </p>',
    text: 'Mama nois'
})

.then(() => console.log('Email enviado com sucesso!'))
.catch((err) => console.log('Erro ao enviar o email: ', err))