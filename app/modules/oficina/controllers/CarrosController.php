<?php
namespace App\Oficina\Controllers;

use App\Controllers\RESTController;
use App\Oficina\Models\Carros;

class CarrosController extends RESTController
{
    //Retorna todos os carros
    public function getCarros()
    {
        try { 
            $carros = (new Carros())->find(
            [
                'conditions' => 'true ' . $this->getConditions(),
                'columns' => $this->partialFields,
                'limit' => $this->limit
            ]
            );
            return $carros;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Retorna carro por condicao
    public function getCarro($iCarId)
    {
        try {
            $carros = (new Carros())->findFirst(
                [
                    'conditions' => "iCarId = '$iCarId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $carros;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Adiciona um carro
    public function addCarro()
    {
        try {
            $carro = new Carros();
            $carro->sCarNome = $this->di->get('request')->getPost('sCarNome');
            $carro->sCarMarca = $this->di->get('request')->getPost('sCarMarca');

            $carro->saveDB();

            return $carro;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    
    //Editar um Carro.  
    public function editaCarro($iCarId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $carro = (new Carros())->findFirst($iCarId);

            if (false === $carro) {
                throw new \Exception("Carro não encontrado", 200);
            }

            $carro->sCarNome = isset($put['sCarNome']) ? $put['sCarNome'] : $carro->sCarNome;
            $carro->sCarMarca = isset($put['sCarMarca']) ? $put['sCarMarca'] : $carro->sCarMarca;

            $carro->saveDB();

            return $carro;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    //Remove um carro
    public function deletaCarro($iCarId)
    {
        try {
            $carro = (new Carros())->findFirst($iCarId);

            if (false === $carro) {
                throw new \Exception("Carro não encontrado", 200);
            }

            return ['success' => $carro->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
