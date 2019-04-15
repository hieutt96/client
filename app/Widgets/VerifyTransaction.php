<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Cookie;
use App\Libs\RequestAPI;
use AppException;
use App\User;
use Session;

class VerifyTransaction extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'verify_by' => 'p',
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets.verify_transaction', [
            'verifyBy' => $this->config['verify_by'],
        ]);
        
    }
}
