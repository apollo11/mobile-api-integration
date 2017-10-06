<?php
namespace App\Http\Traits;


trait JobDetailsOutputTrait
{
    public function jobDetailsoutput($output, $status)
    {
        $start_date = date_create($output->start_date, timezone_open('UTC'));
        $end_date = date_create($output->end_date, timezone_open('UTC'));
        $created =  date_create($output->created_at, timezone_open('UTC'));
        $assigned = is_null($output->schedule_status) ? 'available' : $output->schedule_status;

        $details = [
            'schedule_id' => $output->schedule_id,
            'job' => [
                'id' => $output->id,
                'job_title' => $output->job_title,
                'employer' => [
                    'image_url' => $output->profile_image_path,
                    'name' => $output->company_name,
                    'description' => $output->company_description
                ],
                'industry' => [
                    'id' => $output->industry_id,
                    'name' => $output->industry
                ],
                'location' => [
                    'id' => $output->location_id,
                    'name' => $output->location,
                    'latitude' => 1.2836402,
                    'longtitude' => 103.8603731,
                ],
                'working_details' => [
                    'check_in' =>[
                        'datetime' => $output->checkin_datetime,
                        'location' => $output->checkin_location
                    ],
                    'check_out' => [
                        'datetime' => $output->checkout_datetime,
                        'location' => $output->checkout_location
                    ],
                    'working_hours' => $output->working_hours,
                    'job_salary' => $output->job_salary,
                    'processed_date' => $output->process_date,
                    'payment_method' => $output->payment_methods
                ],
                'created_date' => date_format($created, 'Y-m-d H:i:sP'),
                'start_date' => date_format($start_date, 'Y-m-d H:i:sP'),
                'end_date' => date_format($end_date, 'Y-m-d H:i:sP'),
                'contact_no' => $output->contact_no,
                'rate' => $output->rate,
                'thumbnail_url' => $output->job_image_path,
                'nationality' => ucfirst($output->nationality),
                'description' => $output->description,
                'min_age' => $output->min_age,
                'max_age' => $output->max_age,
                'role' => $output->role,
                'remarks' => $output->notes,
                'language' => $output->language,
                'gender' => $output->gender,
                'job_requirements' => $output->job_requirements,
                'status' => $assigned,
                'payment_status' => strtolower(is_null($output->payment_status) ? $status : $output->payment_status),
                'is_assigned' => 0,
                'cancellation_fee' => 25,
                'cancellation_charge' => 0
            ]
        ];

        return $details;
    }



}