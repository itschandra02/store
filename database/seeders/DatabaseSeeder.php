<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('admins')->insert([
            'username'  =>  'admin',
            'email'     =>  'arisawali2020@gmail.com',
            'password'  =>  Hash::make('password'),
            'profile_pic' => "https://avatars.githubusercontent.com/u/31904944?v=4",
        ]);
        DB::table('products')->insert([
            [
                'name'      => 'Mobile Legends',
                'subtitle'  => 'Proses Otomatis',
                'description' => '<p>Top Up Diamond Mobile Legends <ol><li>Masukkan <b>ID (SERVER)
                </b></li><li>Pilih <b>Nominal </b>Diamond
                </li><li>Pilih <b>Metode Pembayaran</b>
                </li><li>Tulis <b>nomor WhatsApp</b> yg benar!
                </li><li>Klik <b>Beli </b>&amp; lakukan Pembayaran
                </li><li><b>Tunggu 1 Menit</b> diamond masuk otomatis ke akun Anda.</li></ol><p style="text-align: center; "><font size="3" color="#ff9c00"><b>Top Up Buka 24 Jam</b></font></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p></p>
                
            ',
                'thumbnail' => 'https://play-lh.googleusercontent.com/ha1vofCWS5lFhVe0gabwIetwjT4fUY5d6iDOP10KWRwnXci8lWI3ClxrqjoRuPZidg=s180-rw',
                'slug'      => 'mobile-legends',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Free Fire',
                'subtitle'  => 'Proses Otomatis',
                'description' => '<p>Top Up Diamond Free Fire
                <ol><li>Masukkan <b>ID 
                </b></li><li>Pilih <b>Nominal </b>Diamond
                </li><li>Pilih <b>Metode Pembayaran</b>
                </li><li>Tulis <b>nomor WhatsApp</b> yg benar!
                </li><li>Klik <b>Beli </b>&amp; lakukan Pembayaran
                </li><li><b>Tunggu 1 Menit</b> diamond masuk otomatis ke akun Anda.</li></ol><p style="text-align: center; "><font size="3" color="#ff9c00"><b>Top Up Buka 24 Jam</b></font></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p></p>
                
            ',
                'thumbnail' => 'https://play-lh.googleusercontent.com/cw0x8EiZYDwL6x4XKKXDmfQsFDYKO4Q6xIfiyPOvgIjHCpe41QAM_rl4y0dLu0SJOdM=s180-rw',
                'slug'      => 'free-fire',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Call of Duty Mobile',
                'subtitle'  => 'CODM Point',
                'description' => '<div>Layanan Ini Aktif 24 Jam dan Pengiriman Otomatis<ol><li>Masukkan <b>Open ID</b> akun Call Of Duty Mobile Anda</li><li>Pilih <b>Nominal Top Up</b></li><li>Pilih <b>Metode Pembayaran</b></li><li>Masukkan <b>Nomor WhatsApp</b> untuk notifikasi</li><li>Pilih <b>Beli Sekarang</b></li><li>Lakukan Pembayaran <b>sesuai yang dipilih</b></li><li>Pilihan Top Up Anda akan masuk secara otomatis</li></ol></div>',
                'thumbnail' => 'https://telegra.ph/file/b5b87817a98a77e3fd0f7.png',
                'slug'      => 'call-of-duty-mobile-codm-point',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Arena of Valor',
                'subtitle'  => 'AOV Voucher',
                'description' => '<div>Layanan Ini Aktif 24 Jam dan Pengiriman Otomatis<ol><li>Masukkan <b>Open ID</b> akun AOV Anda</li><li>Pilih <b>Nominal Top Up</b></li><li>Pilih <b>Metode Pembayaran</b></li><li>Masukkan <b>Nomor WhatsApp</b> untuk notifikasi</li><li>Pilih <b>Beli Sekarang</b></li><li>Lakukan Pembayaran <b>sesuai yang dipilih</b></li><li>Pilihan Top Up Anda akan masuk secara otomatis</li></ol></div>',
                'thumbnail' => 'https://telegra.ph/file/02b7a12e572e3d0e931fa.jpg',
                'slug'      => 'arena-of-valor-aov-voucher',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Sausage Man',
                'subtitle'  => 'Candys',
                'description' => '<ol><li>Masukkan <b>ID</b></li><li>Pilih <b>Nominal Candy</b></li><li>Pilih Metode Pembayaran</li><li>Masukan Nomor <b>WhatsApp </b>Kamu</li><li>Lakukan <b>Pembayaran</b></li><li>Tunggu 5-15 Menit Candy Akan Masuk Otomatis Di Akun Anda.</li></ol>',
                'thumbnail' => 'https://play-lh.googleusercontent.com/uaYRQaiLtmPJyQuyDcBqxL5pSGSaEPr4REmqlHrQDv4jubDai4uX2JQwiwaWLu2gYvk=s180-rw',
                'slug'      => 'sausage-man-candys',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Steam Voucher',
                'subtitle'  => 'Voucher murah!',
                'description' => '<p>Voucher murah!</p>',
                'thumbnail' => 'https://telegra.ph/file/25ad3f672487fee6f784d.png',
                'slug'      => 'steam-voucher-voucher-murah',
                'active'    => 1,
                'use_input' => 1,
            ],
            [
                'name'      => 'Netflix',
                'subtitle'  => 'Akun Neflix shared premium',
                'description' => '<p>Akun Neflix shared premium</p>',
                'thumbnail' => 'https://telegra.ph/file/ef932b8846d7851221e43.jpg',
                'slug'      => 'netflix-akun-neflix-shared-premium',
                'active'    => 1,
                'use_input' => 1,
            ],
        ]);

        DB::table('form_inputs')->insert([
            [
                "product_id"    => 1,
                "name"  => "userId",
                "value" => "User ID",
                "type"  => "number",
                "placeholder"  => "Masukkan User ID",
            ],
            [
                "product_id"    => 1,
                "name"  => "serverid",
                "value" => "Server ID",
                "type"  => "number",
                "placeholder"  => "Masukkan Server ID",
            ],
            [
                "product_id"    => 2,
                "name"  => "userId",
                "value" => "User ID",
                "type"  => "number",
                "placeholder"  => "Masukkan User ID",
            ],
            [
                "product_id"    => 3,
                "name"  => "userId",
                "value" => "User ID",
                "type"  => "text",
                "placeholder"  => "Masukkan User ID",
            ],
        ]);
        DB::table('product_data')->insert([
            [
                "product_id"    =>  1,
                "name"          =>  "86 Diamonds",
                "price"         =>  17000,
                "discount"      =>  0,
                "layanan"       =>  "86",
            ],
            [
                "product_id"    =>  1,
                "name"          =>  "172 Diamonds",
                "price"         =>  34500,
                "discount"      =>  0,
                "layanan"       =>  "172",
            ],
        ]);

        DB::table('settings')->insert([
            [
                "name"      => "app_name",
                "val"       => "AriStore"
            ],
            [
                "name"      => "logo",
                "val"       => "app/TfoCRv9cKy3XigvYXCNb8Ave1eXwy7Ko5pBFOOhq.png"
            ],
            [
                "name"      => "favicon",
                "val"       => "app/x9158LFKKbpGXfqX77em5FmkTBgNiJoUaFWCr5aS.png"
            ],
            [
                "name"      => "description",
                "val"       => "Tempat top up game termurah, tercepat, dan terpercaya di Indonesia. Proses Otomatis gak sampai 1 menit membuat Anda betah Top Up disini. Tersedia berbagai macam pembayaran Transfer Bank, E-Wallet, Scan QR, Alfamart, & Indomart yg pasti memudahkan anda untuk bertransaksi.

                "
            ],
            [
                "name"      => "company_name",
                "val"       => "AriSoft"
            ]
        ]);
        // Example for BCA
        DB::table('paygate')->insert(
            [
                "payment"   => "bca",
                "name"      => "MUHAMAD ARI SAWALI",
                "norek"     => "",
                "username"  => "",
                "password"  => "",
                "image"     => "https://cdnlogo.com/logos/b/32/bca-bank-central-asia.svg"
            ]
        );
        // User Type
        DB::table('usertype')->insert([
            [
                "type"    => "member",
                "discount" => 0,
            ],
            [
                "type"    => "reseller",
                "discount" => 0,
            ]
        ]);

        DB::table('users')->insert([
            [
                'name'      => "Ari Sawali",
                'username'  => 'arisawali2014',
                'email'     => 'arisawali2020@gmail.com',
                'number'    => '6289651157752',
                'password'  =>  Hash::make("password")
            ]
        ]);
        DB::table('invoices')->insert([
            [
                'invoice_number'    => 68576792717,
                'payment_ref'       => '',
                'user'              =>  1,
                'product_data_id'   =>  1,
                'product_data_name' =>  '86 Diamonds',
                'product_id'        =>  1,
                'product_name'      =>  'Mobile Legends',
                'price'             =>  17000,
                'fee'               =>  860,
                'user_input'        =>  '[{"name":"userId","value":"30723382"},{"name":"serverid","value":"2043"}]',
                'payment_method'    =>  'bca',
                'status'            =>  'DONE'
            ]
        ]);
    }
}
