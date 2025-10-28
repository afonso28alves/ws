async function connect(){
    if(global.connection && global.connection.state !== 'disconnected')
        return global.connection;
    const mysql = require("mysql2/promise");
    /*
    mysql2 -> createConnection() -> ligação a BD, este metodo é assincrono,
    como tal callback que transforma a nossa funcao sync/wait, deste modo
    a operaçao apenas executa apos criação da ligação
    */
   const connection = await mysql.createConnection("mysql://root@localhost:3306/webservice_prog23");
    console.log("Server ON, port:3306");
    global.connection = connection;
    return global.connection;
}

async function selectUsers(){
    const conn = await connect();
    //query -> devolve um array com varias porps., no entanto a unica importante é a prop. rows(a consulta em si)
    
    const [rows] = await conn.query('SELECT * FROM user'); 
    return rows;
}

async function selectClientes(){
    const conn = await connect();    
    const [rows] = await conn.query('SELECT * FROM cliente'); 
    return rows;
}

module.exports = {selectUsers, selectClientes};
