<?php

namespace App\Console\Commands;

use App\Models\AuditTrail;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupAuditTrails extends Command
{
    protected $signature = 'audit:cleanup
                            {--days=365 : Number of days to keep audit records}
                            {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Clean up old audit trail records to maintain performance';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $dryRun = $this->option('dry-run');

        $cutoffDate = Carbon::now()->subDays($days);

        $query = AuditTrail::where('created_at', '<', $cutoffDate);
        $count = $query->count();

        if ($count === 0) {
            $this->info('No audit trail records found older than ' . $days . ' days.');
            return self::SUCCESS;
        }

        $this->info("Found {$count} audit trail records older than {$days} days (before {$cutoffDate->format('Y-m-d')})");

        if ($dryRun) {
            $this->warn('DRY RUN: Would delete ' . $count . ' records');

            // Show breakdown by model
            $breakdown = $query->selectRaw('model_type, COUNT(*) as count')
                ->groupBy('model_type')
                ->get();

            $this->table(['Model Type', 'Records'], $breakdown->map(function ($item) {
                return [class_basename($item->model_type), $item->count];
            }));

            return self::SUCCESS;
        }

        if (!$this->confirm("Are you sure you want to delete {$count} audit trail records?")) {
            $this->info('Cleanup cancelled.');
            return self::SUCCESS;
        }

        $deleted = $query->delete();
        $this->info("Successfully deleted {$deleted} audit trail records.");

        return self::SUCCESS;
    }
}