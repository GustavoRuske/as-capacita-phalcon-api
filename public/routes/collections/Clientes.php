<?php
return call_user_func(
    function () {
        $cliCollection = new \Phalcon\Mvc\Micro\Collection();

        $cliCollection
            ->setPrefix('/v1/clientes')
            ->setHandler('\App\Oficina\Controllers\ClientesController')
            ->setLazy(true);

        $cliCollection->get('/', 'getClientes');
        $cliCollection->get('/{id:\d+}', 'getCliente');

        $cliCollection->post('/', 'addCliente');

        $cliCollection->put('/{id:\d+}', 'editaCliente');

        $cliCollection->delete('/{id:\d+}', 'deletaCliente');

        return $cliCollection;
    }
);
