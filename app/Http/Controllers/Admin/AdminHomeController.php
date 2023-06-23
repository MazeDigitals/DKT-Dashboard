<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;
use DB;
use App\Models\Role;
use App\Models\User;
use App\Http\Common\ProductBidWinnerHelper;

class AdminHomeController extends Controller
{
    public function index() {

        $data['total_users'] = User::where('role_id',3)->count('id');

        return view('admin.home',$data);
    }

    public function processProductBidWinnerCronjob(){
        \Log::info("Process Product Bid Winner Job triggered from url.");
        $productBidWinnerJob = new ProductBidWinnerHelper();
        $productBidWinnerJob->processProductBidWinner();
        return 1;
    }

}
