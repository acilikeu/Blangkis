<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\UserModel;

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');

        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang.');
        return redirect()->to(base_url('/keranjang'));
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_checkout', $data);
    }

    public function getLocation()
    {
        //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50',
            [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    {
        //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

        //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST',
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function buy()
    {
        if ($this->request->getPost()) {
            $file = $this->request->getFile('bukti');
            $buktiName = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $buktiName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/bukti/', $buktiName);
            }

            $dataForm = [
                'username'     => $this->request->getPost('username'),
                'total_harga'  => $this->request->getPost('total_harga'),
                'alamat'       => $this->request->getPost('alamat'),
                'ongkir'       => $this->request->getPost('ongkir'),
                'status'       => 'Pesanan Diproses',
                'bukti_transfer'  => $buktiName,
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s")
            ];

            $this->transaction->insert($dataForm);
            $last_insert_id = $this->transaction->getInsertID();

            foreach ($this->cart->contents() as $item) {
                $this->transaction_detail->insert([
                    'transaction_id' => $last_insert_id,
                    'product_id'     => $item['id'],
                    'jumlah'         => $item['qty'],
                    'subtotal_harga' => $item['qty'] * $item['price'],
                    'diskon'         => 0,
                    'created_at'     => date("Y-m-d H:i:s"),
                    'updated_at'     => date("Y-m-d H:i:s")
                ]);
            }

            $this->cart->destroy();

            return redirect()->to(base_url('/'))->with('success', 'Pesanan berhasil dibuat.');
        }
    }
    public function kelolaKonsumen()
    {
        $model = new UserModel();

        $data = [
            'user' => $model->select('id, username, email')->findAll()
        ];

        return view('v_order', $data);
    }

    public function cetak_invoice($id)
    {
        $transaksi = $this->transaction->find($id);
        $detail = $this->transaction_detail
            ->select('transaction_detail.*, product.nama, product.harga')
            ->join('product', 'product.id = transaction_detail.product_id')
            ->where('transaction_id', $id)
            ->findAll();

        $data = [
            'transaksi' => $transaksi,
            'detail' => $detail
        ];

        $html = view('v_invoice', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function uploadBukti($id)
    {
        $file = $this->request->getFile('bukti');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/bukti', $newName);

            $this->transaction->update($id, [
                'bukti_transfer' => $newName
            ]);
            session()->setFlashdata('success', 'Bukti transfer berhasil diupload.');
        } else {
            session()->setFlashdata('failed', 'Upload gagal, coba lagi.');
        }
        return redirect()->to(base_url('profile'));
    }
    // Kirim oleh admin
    public function kirim($id)
    {
        $this->transaction->update($id, ['status' => 'Dikirim']);
        return redirect()->back()->with('success', 'Pesanan telah dikirim.');
    }

    // Member menerima pesanan
    public function selesai($id)
    {
        $this->transaction->update($id, ['status' => 'Selesai']);
        return redirect()->back()->with('success', 'Pesanan telah diterima.');
    }
    public function updateStatus($id)
    {
        $newStatus = $this->request->getPost('status');
        $model = new TransactionModel();

        $model->update($id, ['status' => $newStatus]);

        session()->setFlashdata('success', 'Status berhasil diperbarui');
        return redirect()->to(base_url('admin/orders'));
    }
    public function laporan()
    {
        $model = new \App\Models\TransactionModel();
        $detailModel = new \App\Models\TransactionDetailModel();

        // Default: global
        $data['buy'] = $model->findAll();

        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        if ($start && $end) {
            $data['buy'] = $model->where('DATE(created_at) >=', $start)
                ->where('DATE(created_at) <=', $end)
                ->findAll();
        }

        // Gabungkan dengan detail + nama produk
        $details = $detailModel
            ->select('transaction_detail.*, product.nama AS nama_produk')
            ->join('product', 'product.id = transaction_detail.product_id')
            ->findAll();

        $groupedDetail = [];
        foreach ($details as $item) {
            $groupedDetail[$item['transaction_id']][] = $item;
        }

        $data['detail'] = $groupedDetail;

        return view('v_laporan', $data);
    }
    public function exportPeriodikPDF()
    {
        $transaction = new \App\Models\TransactionModel();
        $transactionDetail = new \App\Models\TransactionDetailModel();

        $transaksi = $transaction->findAll();
        $detail = $transactionDetail
            ->select('transaction_detail.*, product.nama AS nama_produk')
            ->join('product', 'product.id = transaction_detail.product_id')
            ->findAll();

        $grouped = [];
        foreach ($detail as $item) {
            $grouped[$item['transaction_id']][] = $item;
        }

        $totalPendapatan = 0;
        foreach ($transaksi as $row) {
            $totalPendapatan += $row['total_harga'];
        }

        $data = [
            'transaksi' => $transaksi,
            'detail' => $grouped,
            'totalPendapatan' => $totalPendapatan
        ];

        $html = view('export/exportPeriodik_pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function exportPeriodikExcel()
    {
        $transactionModel = new \App\Models\TransactionModel();
        $detailModel = new \App\Models\TransactionDetailModel();

        $transaksi = $transactionModel->findAll();
        $detail = $detailModel
            ->select('transaction_detail.*, product.nama AS nama_produk')
            ->join('product', 'product.id = transaction_detail.product_id')
            ->findAll();

        // Group detail by transaction_id
        $grouped = [];
        foreach ($detail as $item) {
            $grouped[$item['transaction_id']][] = $item;
        }

        // Create spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Penjualan');

        // Header
        $sheet->setCellValue('A1', 'ID Transaksi');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Total Harga');
        $sheet->setCellValue('E1', 'Tanggal');

        // Isi data
        $rowNum = 2;
        $totalPendapatan = 0;

        foreach ($transaksi as $trx) {
            $id = $trx['id'];
            if (isset($grouped[$id])) {
                foreach ($grouped[$id] as $d) {
                    $sheet->setCellValue("A$rowNum", $id);
                    $sheet->setCellValue("B$rowNum", $d['nama_produk']);
                    $sheet->setCellValue("C$rowNum", $d['jumlah']);
                    $sheet->setCellValue("D$rowNum", $trx['total_harga']);
                    $sheet->setCellValue("E$rowNum", date('d-m-Y', strtotime($trx['created_at'])));
                    $rowNum++;
                    $totalPendapatan += $trx['total_harga'];
                }
            }
        }

        // Tambah total pendapatan
        $sheet->setCellValue("C$rowNum", "Total Pendapatan:");
        $sheet->setCellValue("D$rowNum", $totalPendapatan);

        // Download file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Penjualan_Periodik.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }
}
