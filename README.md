# The Insurance Emporium Task

## Installation (PHP and Composer Required - ensure these are installed)

- May need to enable gd extension for PHP.

### Git Clone
```bash
git clone https://github.com/CanisCyril/the-insurance-emporium-task.git
```
## Setup Instructions

1. Run terminal as administrator (may potentially cause issues if not ran as admin).
2. Path to project folder.
3. Run the command: composer install
4. Run the command: npm install

## Commands

Command to export salary CSV: php artisan salary:export
Command to test salary export: php artisan test

## Files that I have written/editted.

I realised a little too late that Git was having issues tracking changes (unit testing changes were tracked)
so I have included a list below of relivant files that I have written.

- app\Console\Commands\TheInsuranceEmporium\SalaryExport.php
- app\Exports\SalaryExportData.php
- tests\Unit\SalaryExportTest.php

## Packages Used

### Laravel Excel
```bash
https://docs.laravel-excel.com/3.1/getting-started/
```

### Carbon (Pre-installed within Laravel)
```bash
https://carbon.nesbot.com/docs/
```

