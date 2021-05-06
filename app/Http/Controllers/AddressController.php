<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function viewAddress ()
    {
        return view('view-address');
    }

    public function viewConfirm()
    {
        return view('view-confirm');
    }

    public function requestCep ($cep) {
        
        $addressMapped = [];
        $url = "https://viacep.com.br/ws/{$cep}/json/"; 
        $curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$address = curl_exec($curl);
		curl_close($curl);
        $address = json_decode($address);

        if (!$address) {
            $url = "https://api.postmon.com.br/v1/cep/{$cep}"; 
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $address = curl_exec($curl);
            curl_close($curl);
            $address = json_decode($address);

            $addressMapped = [
                'cep' => $address->cep,
                'rua' => $address->logradouro,
                'bairro' => $address->bairro,
                'cidade' => $address->cidade,
                'estado' => $address->estado,
            ];
        } else {
            $addressMapped = [
                'cep' => $address->cep,
                'rua' => $address->logradouro,
                'bairro' => $address->bairro,
                'cidade' => $address->localidade,
                'estado' => $address->uf,
            ];
        }

        return response()->json([
            'address' => $addressMapped,
        ]);
    }

}
