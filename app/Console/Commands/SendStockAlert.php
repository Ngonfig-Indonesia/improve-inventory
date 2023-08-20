<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockBarang;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendStockAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-stock-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $data = item::with('item_details')->get();
        $data = item::with('item_details')->whereHas('item_details', function ($query) {
            $query->where('qty', '<', DB::raw('min_qty'));
        })->get();

        Mail::to(['rifky.8000@gmail.com', 'ngonfigid@gmail.com'])->send(new StockBarang($data));

        dd('Kirim email Sukses');
    }
}
