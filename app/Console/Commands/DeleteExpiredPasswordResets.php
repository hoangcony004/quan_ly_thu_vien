<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteExpiredPasswordResets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password_resets:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa các bản ghi đặt lại mật khẩu đã hết hạn sau 15 phút';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Xóa các bản ghi trong bảng password_reset_tokens cũ hơn 15 phút
        DB::table('password_reset_tokens')
            ->where('created_at', '<', Carbon::now()->subMinutes(15))
            ->delete();

        $this->info('Đã xóa các bản ghi đặt lại mật khẩu hết hạn.');
    }
}
