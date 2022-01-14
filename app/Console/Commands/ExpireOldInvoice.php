<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireOldInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change expired invoice every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::table('invoices')
            ->where("status", "PENDING")
            ->where('expired_at', '<', date('Y-m-d H:i:s'))
            ->update([
                "status" => "EXPIRED"
            ]);
        DB::table('invoices')
            ->where("status", "UNPAID")
            ->where('expired_at', '<', date('Y-m-d H:i:s'))
            ->update([
                "status" => "EXPIRED"
            ]);
        // $date = strtotime("+7 day");
        // DB::table('users')
        //     ->where('balance', '>=', 500000)
        //     ->update([
        //         'status' => "reseller",
        //         'expire_seller_at' => date('Y-m-d H:i:s', $date)
        //     ]);
        // DB::table('users')
        //     ->where('balance', '<', 500000)
        //     ->where('status', 'reseller')
        //     ->where('expire_seller_at', '<', date('Y-m-d H:i:s'))
        //     ->update([
        //         'status' => "member"
        //     ]);
        $this->info("Success updating invoices");
    }
}
