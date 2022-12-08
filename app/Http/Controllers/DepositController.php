<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller{
    public function store(Request $request) {
        $deposit = new Deposit;
        $deposit->user_id = $request->user_id;
        $deposit->deposit_weight = $request->deposit_weight; 
        $deposit->amount = $request->amount; 

        $deposit_request = Validator::make($request->all(), [
            "user_id" => "required",
            "deposit_weight" => "required",
            "amount" => "required",
        ], [
            "required" => "Atleast one attribute should be edited!"
        ]);

        if ($deposit_request->fails()) {
            return $this->sendError($deposit_request->errors(), "Unprocessable content", 422);
        }

        $validated = $deposit_request->validated();

        foreach ($validated as $key => $value) {
            $deposit->$key = $value;
        }

        $deposit->save();
 
        return $this->sendResponse([
            "message" => "Deposit succesfully saved"
        ]);
    }
 
}
