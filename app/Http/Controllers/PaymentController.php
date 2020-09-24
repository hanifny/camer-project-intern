<?php

namespace App\Http\Controllers;

use App\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Meter;

class PaymentController extends Controller
{
    public function store(Request $request) {
        $pemakaian_air = Meter::where('bulan_tahun', date('m Y'))->sum('pemakaian_air') * 1035.78;
        $pemakaian_listrik = Meter::where('bulan_tahun', date('m Y'))->sum('pemakaian_listrik') * 1050;
        $payment = Payment::create([
            'amount' => round($pemakaian_air + $pemakaian_listrik),
            'method' => 'bca',
            'user_id' => auth()->user()->id
        ]);

        $uuid4 = Uuid::uuid4()->toString();
        $payment->payment_id = $uuid4;
        $payment->save();

        // insert to midtrans
        $response_midtrans = $this->midtrans_store($payment);

        return response()->json([
            'response_code' => '00',
            'response_msg' => 'success',
            'data' => $response_midtrans
        ]);
    }

    public function midtrans_store(Payment $payment) {
        $server_key = base64_encode(config('app.midtrans.server_key'));
        $base_uri = config('app.midtrans.base_uri');
        $client = new Client([
            'base_uri' => $base_uri
        ]);

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . $server_key,
            'Content-Type' => 'application/json'
        ];

        switch ($payment->method) {
            case 'bca':
                $body = [
                    "payment_type" => "bank_transfer",
                    "transaction_details" => [
                        "order_id" => $payment->payment_id,
                        "gross_amount" => $payment->amount
                    ],
                    "bank_transfer" => [
                        "bank" => "bca"
                    ]
                ];
                break;
            
            case 'permata' : 
                $body = [
                    "payment_type" => "permata",
                    "transaction_details" => [
                        "order_id" => $payment->payment_id,
                        "gross_amount" => $payment->amount
                    ]
                ];
            default:
                $body = [];
                break;
        }

        $res = $client->post('/v2/charge', [
            'headers' => $headers,
            'body' => json_encode($body)
        ]); 

        return json_decode($res->getBody());
    }
}
