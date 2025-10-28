(async () => {
    const db = require('./database');
    const listaUsers = await db.selectUsers();
    console.log(listaUsers);
    const listaClientes = await db.selectClientes();
    console.log(listaClientes);

    const serverRequest = require('./proRequest');
    const aplicacao = serverRequest(1234);

    //Browser: localhost:1234/users
    aplicacao.get('/users', function(req, res){
        res.write(JSON.stringify());
        res.end();
    });

    aplicacao.get('/clientes', function(req, res){
        res.write(JSON.stringify());
        res.end();
    });
})();