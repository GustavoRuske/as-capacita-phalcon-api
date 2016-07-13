<?php
namespace App\Oficina\Controllers;

use App\Controllers\RESTController;
use App\Oficina\Models\Orcamentos;
use App\Oficina\Models\Clientes;
use App\Oficina\Models\Carros;

class OrcamentosController extends RESTController
{
    //Retorna os orçamentos com os dados do Cliente e do Carro
    public function getOrcamentos()
    {
        try {
            $query = new \Phalcon\Mvc\Model\Query\Builder();
            $query->addFrom('\App\Oficina\Models\Orcamentos', 'Orc')
                ->columns(
                    [
                        'Orc.iOrcId',
                        'Orc.iOrcValor',
                        'Orc.sOrcDes',
                        'Cli.iCliId',
                        'Cli.sCliNome',
                        'Cli.iCliCpf',
                        'Cli.sCliEmail',
                        'Car.iCarId',
                        'Car.sCarNome',
                        'Car.sCarMarca',
                    ]
                )
                ->InnerJoin('\App\Oficina\Models\Clientes', 'Cli.iCliId = Orc.iCliId', 'Cli')
                ->InnerJoin('\App\Oficina\Models\Carros', 'Car.iCarId = Orc.iCarId', 'Car')
                ->where('true');

            return $query
                ->getQuery()
                ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Retorna Orçamento com os dados do cliente e do carro por condicao
    public function getOrcamento($iOrcId)
    {
try {
            $query = new \Phalcon\Mvc\Model\Query\Builder();
            $query->addFrom('\App\Oficina\Models\Orcamentos', 'Orc')
                ->columns(
                    [
                        'Orc.iOrcId',
                        'Orc.iOrcValor',
                        'Orc.sOrcDes',
                        'Cli.iCliId',
                        'Cli.sCliNome',
                        'Cli.iCliCpf',
                        'Cli.sCliEmail',
                        'Car.iCarId',
                        'Car.sCarNome',
                        'Car.sCarMarca',
                    ]
                )
                ->InnerJoin('\App\Oficina\Models\Clientes', 'Cli.iCliId = Orc.iCliId', 'Cli')
                ->InnerJoin('\App\Oficina\Models\Carros', 'Car.iCarId = Orc.iCarId', 'Car')
                ->where("Orc.iOrcId = '$iOrcId'");

            return $query
                ->getQuery()
                ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Adiciona um Orçamento
    public function addOrcamento()
    {
        $mensagemValidacao = "";
        try {
            $orc = new Orcamentos();
            $orc->iOrcValor = $this->di->get('request')->getPost('iOrcValor');
            $orc->sOrcDes = $this->di->get('request')->getPost('sOrcDes');

            //Verifica se o cliente está cadastrado na base
            $cliente = (new Clientes())->findFirst($this->di->get('request')->getPost('iCliId'));
            if (false === $cliente) {
                $mensagemValidacao = is_null($mensagemValidacao) ? "Cliente não encontrado" : $mensagemValidacao ." , " . "Cliente não encontrado";
            }
            $orc->iCliId = $this->di->get('request')->getPost('iCliId');


            //Verifica se o carro está cadastrado na base
            $carro = (new Carros())->findFirst($this->di->get('request')->getPost('iCarId'));
            if (false === $carro) {
                $mensagemValidacao =  is_null($mensagemValidacao) ? "Carro não encontrado" : $mensagemValidacao ." , " . "Carro não encontrado";
            }
            $orc->iCarId = $this->di->get('request')->getPost('iCarId');

            if ( !is_null($mensagemValidacao)) {
               throw new \Exception($mensagemValidacao, 200);
            }

            $orc->saveDB();

            return $orc;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    
    //Editar um Orçamento.  
    public function editaOrcamento($iOrcId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $orc = (new Orcamentos())->findFirst($iOrcId);

            if (false === $orc) {
                throw new \Exception("Orçamento não encontrado", 200);
            }

            $orc->iOrcValor = isset($put['iOrcValor']) ? $put['iOrcValor'] : $orc->iOrcValor;
            $orc->sOrcDes = isset($put['sOrcDes']) ? $put['sOrcDes'] : $orc->sOrcDes;
            $orc->iCliId = isset($put['iCliId']) ? $put['iCliId'] : $orc->iCliId;
            $orc->iCarId = isset($put['iCarId']) ? $put['iCarId'] : $orc->iCarId;

            $orc->saveDB();

            return $orc;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Remove um Orçamento
    public function deletaOrcamento($iOrcId)
    {
        try {
            $orc = (new Orcamentos())->findFirst($iOrcId);

            if (false === $orc) {
                throw new \Exception("Orçamento não encontrado", 200);
            }

            return ['success' => $orc->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
