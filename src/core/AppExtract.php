<?php

namespace src\core;

class AppExtract
{
    private array $uri = [];
    private string $controller = 'Home';

    //esse metodo vai pegar a requisicao feita e criar um array com a rota acessada (usando o explode '/')
    //o primeiro nome apos a barra (que vai estar na posicao uri[0]) sera o controller a ser acessado 
    //(por exemplo "/products"); usando a funcao ucfirst para forçar a primeira letra do nome pra ficar maiuscula
    //sera criado um namespace do controller com base no nome informado na requisicao, e se existir 
    //uma classe com esse namespace+controller, ela ira ser retornada; caso contrario retorna o padrao Home
    public function controller(): string
    {
        $this->uri = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

        if(isset($this->uri[0]) and $this->uri[0] !== ''){
            $this->controller = ucfirst($this->uri[0]);
        }

        $namespaceAndController = "src\\controllers\\".$this->controller;

        if(class_exists($namespaceAndController)){
            $this->controller = $namespaceAndController;
        }

        return $this->controller;
    }

    public function method()
    {

    }

    public function params()
    {

    }
}