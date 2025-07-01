<?php

namespace App\Controllers;

use App\Models\TransactionModel;

class AdminController extends BaseController
{
public function order()
{
    $model = new \App\Models\TransactionModel();

    $query = $model->select('username, alamat')
                   ->groupBy('username, alamat') // Ambil unik
                   ->findAll();

    $data = [
        'username' => session()->get('username'),
        'buy' => $query
    ];

    return view('admin/v_order', $data);
}

    public function kelolaKonsumen()
    {
        $model = new \App\Models\TransactionModel();
        $query = $model->select('username, alamat')
                   ->groupBy('username, alamat') // Ambil unik
                   ->findAll();
    $data = [
        'username' => session()->get('username'),
        'buy' => $query];
    }
    public function kelolaOrder()
    {
        $model = new TransactionModel();
        $data['orders'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('v_order', $data);
    }
    public function updateStatus($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $status = $this->request->getPost('status');
            $model = new TransactionModel();
            $model->update($id, ['status' => $status]);

            return redirect()->to(base_url('admin/kelola-order'))->with('success', 'Status berhasil diperbarui.');
        }
    }
}
