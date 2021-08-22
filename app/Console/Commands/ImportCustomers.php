<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Import\ImportCustomerService;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customer {nationality=au} {limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from api';

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
     * @return mixed
     */
    public function handle()
    {
        $customerImportService = app(ImportCustomerService::class);
        $customerImportService->import($this->argument('nationality'), $this->argument('limit'));
    }
}
