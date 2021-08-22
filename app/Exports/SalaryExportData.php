<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class SalaryExportData implements FromCollection, WithHeadings
{
    public function collection()
    {

       return $results = $this->periodAndBasicPaymentDates();
    }

    public function headings(): array {
        return [
            "Period", "Basic Pay Date", "Bonus Pay Date"
        ];
    }

    public function periodAndBasicPaymentDates()
	{
		$lastDatesOfMonths = [];
		$paymentDates = [];

		$date = Carbon::parse(Carbon::now('UTC'))->format('Y-m-d'); //Carbon parsed is used each time format is requred, format converts it to string, functions cannot be used on a string

		for ($x = 0; $x <= 11; $x++) { //loop 11 times 
			if($x > 0) { //Skip first iteration 
		   		$date = Carbon::parse($date)->addMonthsNoOverflow(1)->endOfMonth(); //Get next month of date, then convert it to the last day of the month.
				
			} else {
				$date = Carbon::parse($date)->endOfMonth();
			}

			$date = Carbon::parse($date)->format('Y-m-d'); //Converting to string date format from Carbon

			$lastDatesOfMonths[] = $date; //Push date to array
		}

		foreach($lastDatesOfMonths as $lastWeekDay) { //Iterate through array that dates were added to
			$loopStopper = 0;

			$lastWeekDay = Carbon::parse($lastWeekDay); //Convert back to Carbon

			while($loopStopper === 0) { //Keep looping until condition changes
				if($lastWeekDay->dayOfWeek === Carbon::SUNDAY) { //If date is a Sunday, remove a day
					$lastWeekDay->subDays(1);
				} else if ($lastWeekDay->dayOfWeek === Carbon::SATURDAY) { //If date is a Saturday, remove a day
					$lastWeekDay->subDays(1);
				} else { //Once the date is a working day push in to a new array

					$obj = new \stdClass();

					$obj->periodDate = $lastWeekDay->format('m-Y'); //add period dates
					$obj->basicPayDate = $lastWeekDay->format('Y-m-d'); //add basic payment dates
					array_push($paymentDates, $obj);
					$loopStopper = 1; //Stop loop for each iteration
				}
			}
		}

		$results = $this->bonusPaymentDates($paymentDates);
        return $results;
	}

	public function bonusPaymentDates($paymentDates)
	{

		//This function is fairly similar to periodAndBasicPaymentDates()

		date_default_timezone_set('Europe/London'); //set timezone

		$lastDatesOfMonths = [];

		$date = Carbon::parse('10th' . date('M'))->format('Y-m-d');


		for ($x = 0; $x <= 11; $x++) { 
			if($x > 0) { 
		   		$date = Carbon::parse($date)->addMonthsNoOverflow(1); 
				
			} else {
				$date = Carbon::parse($date);
			}

			$date = Carbon::parse($date)->format('Y-m-d'); 

			$lastDatesOfMonths[] = $date; 

			foreach($lastDatesOfMonths as $lastWeekDay) { //add days after 10th if it is a weekend
				$loopStopper = 0;

				$lastWeekDay = Carbon::parse($lastWeekDay); 

				while($loopStopper === 0) {
					if($lastWeekDay->dayOfWeek === Carbon::SUNDAY) {
						$lastWeekDay->addDays(1); 
					} else if ($lastWeekDay->dayOfWeek === Carbon::SATURDAY) {
						$lastWeekDay->addDays(1);
					} else { 

						$paymentDates[$x]->bonusPayDate = $lastWeekDay->format('Y-m-d'); //add bonus payments

						$loopStopper = 1; 
					}
				}
			}
		}

        return collect($paymentDates);
	}
}