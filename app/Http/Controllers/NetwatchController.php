<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RouterosService;

class NetwatchController extends Controller
{
    private RouterosService $routeros;

    public function __construct(RouterosService $routeros)
    {
        $this->routeros = $routeros;
    }

    public function netwatch()
    {
        $host = session()->get('host');
        $username = session()->get('username');
        $password = session()->get('password');
        if ($this->routeros->connect($host, $username, $password)) {

            $data = $this->routeros->fetchDashboardData();

            // Tampilkan halaman dengan data netwatch
            return view('netwatch', $data);
        } else {
            return redirect('failed');
        }
    }

    public function connect(Request $request)
    {
    $request->validate([
        'host' => 'required',
        'username' => 'required',
    ]);

    $host = $request->post('host');
    $username = $request->post('username');
    $password = $request->post('password');
    $keepPassword = $request->has('keep_password');

    $data = [
        'host' => $host,
        'username' => $username,
        'password' => $password,
    ];

    // Simpan data ke dalam session
    $request->session()->put($data);

    // Jika "Keep Password" dicentang, simpan juga statusnya
    if ($keepPassword) {
        $request->session()->put('keep_password', true);
    } else {
        // Jika tidak dicentang, hapus status "Keep Password" dari session
        $request->session()->forget('keep_password');
    }

    if ($request->has('saveButton')) {
        // If 'Save' button is clicked, redirect to the form save page
        return redirect('/login#savedModal');
    } else {
        // If 'Connect' button is clicked, redirect to the netwatch page
        return redirect('/netwatch');
    }

    // return redirect('netwatch');
    }

    public function disconnect(Request $request)
    {
        // Tutup koneksi ke RouterOS jika masih terbuka
        $this->routeros->disconnect();

        // Hapus semua data terkait login dari session
        $request->session()->forget(['host', 'username', 'password', 'keep_password']);

        return redirect('/home');
    }
}
