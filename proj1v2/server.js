(async () => {
	const fs = require('fs');
	const path = require('path');
	const db = require("./database");
	const serverRequest = require("./processRequest");

	const aplicacao = serverRequest(1234);
	console.log("Servidor iniciado em http://localhost:1234");

	// Rota: devolve JSON com users (útil para teste)
	aplicacao.get('/user', async function(req, res) {
		try {
			const users = await db.selectUsers();
			console.log('[GET /user] encontrados', users.length, 'users');
			res.setHeader('Content-Type', 'application/json');
			res.write(JSON.stringify(users));
			res.end();
		} catch (err) {
			console.error('[GET /user] erro:', err);
			res.statusCode = 500;
			res.end('Internal Server Error');
		}
	});

	// Rota principal: devolve HTML com tabela preenchida
	aplicacao.get('/', async function(req, res) {
		try {
			const users = await db.selectUsers();
			console.log('[GET /] Tabela tem', users.length, 'users');

			// caminho absoluto para o ficheiro HTML (evita problemas de working dir)
			const htmlPath = path.join(__dirname, 'form_tab.html');

			if (!fs.existsSync(htmlPath)) {
				console.error('[GET /] ficheiro não encontrado:', htmlPath);
				res.statusCode = 500;
				return res.end('HTML file not found on server');
			}

			let html = fs.readFileSync(htmlPath, 'utf8');

			// cria as linhas da tabela
			let linhas = users.map(u => `
				<tr>
					<td>${u.nome}</td>
					<td>${u.email}</td>
					<td>${u.idade}</td>
				</tr>
			`).join('');

			// substitui marcador (se não existir, adiciona as linhas antes de </tbody>)
			if (html.includes('<!--TABELA-->')) {
				html = html.replace('<!--TABELA-->', linhas);
			} else {
				// tentativa de fallback: inserir antes de </tbody>
				html = html.replace('</tbody>', linhas + '\n</tbody>');
			}

			res.setHeader('Content-Type', 'text/html');
			res.write(html);
			res.end();
		} catch (err) {
			console.error('[GET /] erro:', err);
			res.statusCode = 500;
			res.end('Internal Server Error');
		}
	});

	// Rota de inserção (form POST)
	aplicacao.post('/user', function(req, res) {
		try {
			req.on('data', async info => {
				try {
					const base = info.toString().split("&");
					let n = decodeURIComponent((base[0].split("=")).pop());
					let e = decodeURIComponent((base[1].split("=")).pop());
					let i = decodeURIComponent((base[2].split("=")).pop());

					await db.insertUsers({
						nome: n,
						email: e,
						idade: i
					});
					console.log('[POST /user] inserido:', { nome: n, email: e, idade: i });
				} catch (innerErr) {
					console.error('[POST /user] erro ao inserir:', innerErr);
				}
			});

			// redireciona para / para ver a tabela atualizada
			res.writeHead(302, { 'Location': '/' });
			res.end();
		} catch (err) {
			console.error('[POST /user] erro:', err);
			res.statusCode = 500;
			res.end('Internal Server Error');
		}
	});
})();
