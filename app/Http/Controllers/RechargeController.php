<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RechargeController extends Controller
{
    public function getRecharge(Request $request) {
   	
    	return redirect(env('LEDGER_DOMAIN'));
    }
}
