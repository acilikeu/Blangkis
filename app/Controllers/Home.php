<?php

namespace App\Controllers;

use App\Database\Migrations\Product;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }
    public function index(): string
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home', $data);
    }

    public function profile()
    {
        $session = session();
        $username = $session->get('username');
        $role = $session->get('role');

        if ($role == 'admin') {
            $buy = $this->transaction->orderBy('created_at', 'DESC')->findAll(); // Semua transaksi
        } else {
            $buy = $this->transaction->where('username', $username)->orderBy('created_at', 'DESC')->findAll(); // Punya sendiri
        }

        $product = [];

        foreach ($buy as $item) {
            $detail = $this->transaction_detail
                ->select('transaction_detail.*, product.nama, product.harga, product.foto')
                ->join('product', 'transaction_detail.product_id=product.id')
                ->where('transaction_id', $item['id'])
                ->findAll();

            if (!empty($detail)) {
                $product[$item['id']] = $detail;
            }
        }

        $data['buy'] = $buy;
        $data['product'] = $product;
        $data['username'] = $username;
        $data['role'] = $role;

        return view('v_profile', $data);
    }
}
