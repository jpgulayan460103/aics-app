<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regular_holidays = [
            [
                "holiday_date" => date("Y-m-d",strtotime("January 1, ".date("Y"))),
                "name" => "New Year’s Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("April 9, ".date("Y"))),
                "name" => "Maundy Thursday",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("April 14, ".date("Y"))),
                "name" => "Good Friday",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("April 15, ".date("Y"))),
                "name" => "Araw ng Kagitingan",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("May 1, ".date("Y"))),
                "name" => "Labor Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("June 12, ".date("Y"))),
                "name" => "Independence Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("August 29, ".date("Y"))),
                "name" => "National Heroes Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("November 30, ".date("Y"))),
                "name" => "Bonifacio Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("December 25, ".date("Y"))),
                "name" => "Christmas Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d",strtotime("December 30, ".date("Y"))),
                "name" => "Rizal Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("February 25, ".date("Y"))),
                "name" => "EDSA People Power Revolution Anniversary",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("April 8, ".date("Y"))),
                "name" => "Black Saturday",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("August 21, ".date("Y"))),
                "name" => "Ninoy Aquino Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("November 1, ".date("Y"))),
                "name" => "All Saints’ Day",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("December 8, ".date("Y"))),
                "name" => "Feast of the Immaculate Conception of Mary",
                "is_working_day" => 0,
            ],
            [
                "holiday_date" => date("Y-m-d", strtotime("December 31, ".date("Y"))),
                "name" => "Last Day of the Year",
                "is_working_day" => 0,
            ],

        ];

        foreach ($regular_holidays as $regular_holiday) {
            $created_holiday = Holiday::create($regular_holiday);
            echo "created psgc: $created_holiday->holiday_date - $created_holiday->name \n";
        }
    }
}
