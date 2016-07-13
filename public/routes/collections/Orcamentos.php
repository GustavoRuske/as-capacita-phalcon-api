<?php
return call_user_func(
    function () {
        $orcCollection = new \Phalcon\Mvc\Micro\Collection();

        $orcCollection
            ->setPrefix('/v1/orcamentos')
            ->setHandler('\App\Oficina\Controllers\OrcamentosController')
            ->setLazy(true);

        $orcCollection->get('/', 'getOrcamentos');
        $orcCollection->get('/{id:\d+}', 'getOrcamento');

        $orcCollection->post('/', 'addOrcamento');

        $orcCollection->put('/{id:\d+}', 'editaOrcamento');

        $orcCollection->delete('/{id:\d+}', 'deletaOrcamento');

        return $orcCollection;
    }
);
