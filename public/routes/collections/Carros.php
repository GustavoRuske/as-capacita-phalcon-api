<?php
return call_user_func(
    function () {
        $carroCollection = new \Phalcon\Mvc\Micro\Collection();

        $carroCollection
            ->setPrefix('/v1/carros')
            ->setHandler('\App\Oficina\Controllers\CarrosController')
            ->setLazy(true);

        $carroCollection->get('/', 'getCarros');
        $carroCollection->get('/{id:\d+}', 'getCarro');

        $carroCollection->post('/', 'addCarro');

        $carroCollection->put('/{id:\d+}', 'editaCarro');

        $carroCollection->delete('/{id:\d+}', 'deletaCarro');

        return $carroCollection;
    }
);
