<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Exports\SalaryExportData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class SalaryExportTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_salary_export()
    {
        $filename = 'exports/salary-export-' . Carbon::now()->format('Y-m-d') . '.csv';

		Excel::fake(); //faking execution for testing

		Excel::store(new SalaryExportData, $filename); //this will not actually store the file

		Excel::assertStored($filename, function(SalaryExportData $export) {

			$data = $export->collection(); //creating data from export

            $hasDate = $data->contains(function ($payType, $key) { //function to check if correct values have been exported 

                return $payType->periodDate == $payType->periodDate && $payType->basicPayDate == $payType->basicPayDate && $payType->bonusPayDate == $payType->bonusPayDate;
            });

			return  $hasDate; //return results
		});
    }
}
