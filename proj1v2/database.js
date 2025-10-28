async function connect(){
	if(global.connection && global.connection.state !== 'disconnected')
		return global.connection;
	const mysql = require("mysql2/promise");
	/*mysql2-> createConnection()-> ligação à BD, este metodo é assincrono, 
	como tal callback que transforma a nossa função sync/w/await, deste modo a operação apenas executa após criação da ligação */
	
	const connection = await mysql.createConnection("mysql://root@localhost:3306/webservice_prog23");
	console.log("ligação ON");
	global.connection = connection;
	return connection;
}

async function selectUsers(){
	const conn = await connect();
	// query-> devolve um array com várias propriedade, no entanto o unico importante é a propriedade rows(a consulta em si)
	const [rows] = await conn.query('SELECT * FROM user');
	return rows;
}

async function selectClientes(){
	const conn = await connect();
	// query-> devolve um array com várias propriedade, no entanto o unico importante é a propriedade rows(a consulta em si)
	const [rows] = await conn.query('SELECT * FROM cliente');
	return rows;
}

async function insertUsers(user){
	const conn = await connect();
	await conn.query('INSERT INTO user(nome,email,idade) VALUES (?,?,?);', [user.nome,user.email,user.idade]);
}

module.exports = {selectUsers, selectClientes, insertUsers};