<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Libs\RequestJWT;
use App\Libs\RequestAPI;

class vat extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $jwt = RequestJWT::encodeJWT();
        $services = RequestAPI::requestStore('GET', '/api/services/list', [
            'query' => [
                'jwt' => $jwt,
            ],
        ]);
        // dd($services);
        return view('widgets.vat', [
            'services' => $services->data,
        ]);
    }
}
