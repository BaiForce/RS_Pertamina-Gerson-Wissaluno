<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Sepeda;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Total Admins
        // $totalAdmins = User::where('role', 'admin')->count();
        // $totalStaffs = User::where('role', 'staff')->count();

        // Total Bikes Borrowed
        // $totalSepedaTersedia = Sepeda::where('status', 1)->count();

        // // Total Bikes Returned
        // $totalSepedaTidakTersedia = Sepeda::where('status', 2)->count();

        // Chart Data - Example
        // $chartData = [
        //     'labels' => ['Staffs', 'Total Sepeda Tersedia', 'Total Sepeda Tidak Tersedia'],
        //     'data' => [$totalStaffs, $totalSepedaTersedia, $totalSepedaTidakTersedia]
        // ];

        return view('home', [
            'type_menu' => 'dashboard'
        ]);
    }
}
