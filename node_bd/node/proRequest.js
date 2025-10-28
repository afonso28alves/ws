var http = require('http'); //server modulo do protocolo http
var criarProcessRequest = function(porta){
    var entrada = {}; //api de rotas
    var caminhos = {}; //rotas de caminho para pedidos
    var metodos = ['GET', 'POST'];
    metodos.forEach(function(metodo){
        caminhos[metodo] = {};
        entrada[metodo.toLocaleLowerCase()] = function(path, fn){
            caminhos[metodo][path] = fn;
        };
    });
    http.createServer(function(req, res){
        res.setHeader('Acess-Control-Allow-Origin', '*');
        if(!caminhos[req.method][req.url]){
            res.statusCode = 404;
            return res.end();
        }
        caminhos[req.method][req.url](req,res);
    }).listen(porta);
    return entrada;
};

module.exports = criarProcessRequest;