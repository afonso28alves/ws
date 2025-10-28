(async () => { //função anonima
	const db = require("./database");
	const users = await db.selectUsers(); //todas as funções que nos mandam esperar temos de invocar 
	console.log(users);
	const clientes = await db.selectClientes(); 
	console.log(clientes);
	
	const serverRequest = require("./processRequest");
	const aplicacao = serverRequest(1234);
	
	aplicacao.get('/user', async function(req,res){
		const users = await db.selectUsers();
		res.write(JSON.stringify(users));
		res.end();
	});
	
	aplicacao.get('/cliente', function(req,res){
		res.write(JSON.stringify(clientes));
		res.end();
	});
	
	aplicacao.post('/user', function(req,res){
		// data -> info(via form)
		// nome=sergio&email=sant@pt&idade=23
		req.on('data', info => {
		/* split->separar
		   pop()-> ultima parte de um array */
			const base = info.toString().split("&");
			let n = (base[0].split("=")).pop();
			let e = (base[1].split("=")).pop();
			let i = (base[2].split("=")).pop();
			
			const result = db.insertUsers({
				nome: n,
				email: e,
				idade: i
			});
		});
		res.end();
	});
})(); //os ultimos parenteses sao para invocar a função, pq não tinhamos como chamar 