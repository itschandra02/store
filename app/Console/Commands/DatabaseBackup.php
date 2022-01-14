<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Backup the database';

    protected $process;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $_host =    config('database.connections.mysql.host');
            $_username =    config('database.connections.mysql.username');
            $_passwd =    config('database.connections.mysql.password');
            $_db =    config('database.connections.mysql.database');
            $_filename =   storage_path("backups/" . $_db . '_' . date('Y-m-d_H-i-s') . '.sql');
            $_cmds = join(" ", [
                "mysqldump",
                '-h"' . $_host . '"',
                '-u' . $_username . '',
                '-p"' . $_passwd . '"',
                $_db,
                '>',
                $_filename
            ]);
            exec($_cmds);
            $this->info('The backup was successful!');
            $this->info('The backup file is located at: ' . $_filename);
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error($exception->getMessage());
            $this->error('The backup process has been failed.');
        }
    }
}
