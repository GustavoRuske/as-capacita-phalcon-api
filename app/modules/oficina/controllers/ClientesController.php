<?php
namespace App\Oficina\Controllers;

use App\Controllers\RESTController;
use App\Oficina\Models\Clientes;

class ClientesController extends RESTController
{
    //Retorna todos os carros
    public function getClientes()
    {
        try { 
            $clientes = (new Clientes())->find(
            [
                'conditions' => 'true ' . $this->getConditions(),
                'columns' => $this->partialFields,
                'limit' => $this->limit
            ]
            );
            return $clientes;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Retorna carro por condicao
    public function getCliente($iCliId)
    {
        try {
            $clientes = (new Clientes())->findFirst(
                [
                    'conditions' => "iCliId = '$iCliId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $clientes;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Adiciona um carro
    public function addCliente()
    {
        try {
            $cliente = new Clientes();
            $cliente->sCliNome = $this->di->get('request')->getPost('sCliNome');
            if (is_int($this->di->get('request')->getPost('iCliCpf')) ) {
                throw new \Exception("CPf do cliente deve ser numerico", 200);
            }
            $cliente->iCliCpf = $this->di->get('request')->getPost('iCliCpf');
            $cliente->sCliEmail = $this->di->get('request')->getPost('sCliEmail');

            $cliente->saveDB();

            return $cliente;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    
    //Editar um Carro.  
    public function editaCliente($iCliId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $cliente = (new Clientes())->findFirst($iCliId);

            if (false === $cliente) {
                throw new \Exception("Cliente não encontrado", 200);
            }

            $cliente->sCliNome = isset($put['sCliNome']) ? $put['sCliNome'] : $cliente->sCliNome;
            $cliente->iCliCpf = isset($put['iCliCpf']) ? $put['iCliCpf'] : $cliente->iCliCpf;
            $cliente->sCliEmail = isset($put['sCliEmail']) ? $put['sCliEmail'] : $cliente->sCliEmail;

            $cliente->saveDB();

            return $cliente;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Remove um carro
    public function deletaCliente($iCliId)
    {
        try {
            $cliente = (new Clientes())->findFirst($iCliId);

            if (false === $cliente) {
                throw new \Exception("Cliente não encontrado", 200);
            }

            return ['success' => $cliente->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
