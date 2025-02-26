<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CronJobs extends CustomModel {
    use HasFactory;

    protected $table = 'cron_jobs';

    public $timestamps = false;

    protected $guarded = [];

    public function __construct() {
        $this->table = config('table.cron_jobs');
    }

    public static function create_job($params) {
        $record = [];
        $record[config('table.name')] = $params[config('table.name')];
        $record[config('table.w_name')] = config('app.url');
        $record[config('table.status')] = $params[config('table.status')];
        $record[config('table.starts_at')] = Carbon::now();

        debug_logs($record);
        $id = self::create($record);
        debug_logs($id);

        return $id;
    }

    public static function update_job($cron, $params) {
        $record = [];
        $record[config('table.ends_at')] = $params[config('table.ends_at')];

        if (! empty($params[config('table.message')])) {
            $record[config('table.message')] = $params[config('table.message')];
        }

        if ($params[config('table.status')]) {
            $record[config('table.status')] = $params[config('table.status')];
        }

        debug_logs($record);
        debug_logs($cron->id);
        debug_logs($params);

        return CronJobs::where(config('table.primary_key'), $cron->id)->update($record);
    }
}
