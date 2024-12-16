<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class PegawaiController extends BaseController
{
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function index()
    {
        $data['pegawai'] = $this->pegawaiModel->findAll();
        return view('pegawai/index', $data);
    }

    public function create()
    {
        return view('pegawai/create');
    }

    public function store()
    {
        $this->pegawaiModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'position' => $this->request->getPost('position'),
            'salary'   => $this->request->getPost('salary'),
        ]);

        return redirect()->to('/pegawai');
    }

    public function edit($id)
    {
        $data['pegawai'] = $this->pegawaiModel->find($id);
        return view('pegawai/edit', $data);
    }

    public function update($id)
    {
        $this->pegawaiModel->update($id, [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'position' => $this->request->getPost('position'),
            'salary'   => $this->request->getPost('salary'),
        ]);

        return redirect()->to('/pegawai');
    }

    public function delete($id)
    {
        $this->pegawaiModel->delete($id);
        return redirect()->to('/pegawai');
    }
    
}

