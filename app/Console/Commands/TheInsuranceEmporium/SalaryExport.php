<?php

namespace App\Console\Commands\TheInsuranceEmporium;

use Illuminate\Console\Command;
use App\Exports\SalaryExportData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class SalaryExport extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'salary:export';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Exports a CSV file of employee salaries';

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
		$this->export();
		// $this->can_store_salary_export_data_export();
	}

	public function export() 
	{

		$filename = 'exports/salary-export-' . Carbon::now()->format('Y-m-d') . '.csv';

		return Excel::store(new SalaryExportData, $filename);
	}

	/**
* @test
*/
	
}
