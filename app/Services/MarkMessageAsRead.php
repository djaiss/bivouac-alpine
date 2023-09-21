<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MarkMessageAsRead extends BaseService
{
    public function execute(int $messageId): void
    {
        $count = DB::table('message_read_status')
            ->where('message_id', $messageId)
            ->where('user_id', auth()->user()->id)
            ->count();

        if ($count > 0) {
            return;
        }

        DB::table('message_read_status')->insert([
            'message_id' => $messageId,
            'user_id' => auth()->user()->id,
            'created_at' => Carbon::now(),
        ]);
    }
}
