<?php
namespace App\Http\Traits;

trait JobDetailsOutputTrait
{
    public function jobDetailsoutput($output)
    {
        $assigned = is_null($output->schedule_status) ? 'available' : $output->schedule_status;

        $details = [
            'schedule_id' => $output->schedule_id,
            'job' => [
                'id' => $output->id,
                'job_title' => $output->job_title,
                'employer' => [
                    'id' => $output->employer_id,
                    'image_url' => $output->profile_image_path,
                    'name' => $output->company_name,
                    'description' => $output->company_description,
                    'hourly_rate' => $output->employer_rate
                ],
                'industry' => [
                    'id' => $output->industry_id,
                    'name' => $output->industry
                ],
                'location' => [
                    'id' => $output->id,
                    'name' => is_null($output->geolocation_address) ? '10 Bayfront Ave, Singapore 018956' : $output->geolocation_address,
                    'latitude' => is_null($output->latitude) ? 1.2836402 : $output->latitude,
                    'longitude' => is_null($output->longitude) ? 103.8603731 : $output->longitude,
                ],
                'working_details' => [
                    'check_in' =>[
                        'datetime' => $this->dateFormat($output->checkin_datetime),
                        'location' => $output->checkin_location
                    ],
                    'check_out' => [
                        'datetime' => $this->dateFormat($output->checkout_datetime),
                        'location' => $output->checkout_location
                    ],
                    'working_time_in_minutes' => $output->working_hours,
                    'job_salary' => round($output->job_salary,'2'),
                    'processed_date' => $output->process_date,
                    'payment_method' => $output->payment_methods
                ],
                'created_date' => $this->dateFormat($output->created_at),
                'start_date' => $this->dateFormat($output->start_date),
                'end_date' => $this->dateFormat($output->end_date),
                'contact_person' => $output->contact_person,
                'contact_no' => $output->contact_no,
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
                'payment_status' => $output->payment_status,
                'is_assigned' => is_null($output->is_assigned) ? 0 : $output->is_assigned,
                'cancellation_fee' => 25,
                'cancellation_charge' => 0
            ]
        ];

        return $details;
    }

    public function dateFormat($date)
    {
        if (is_null($date)) {

            $return = null;
        } else {

            $format = date_create($date, timezone_open('UTC'));
            $return = date_format($format, 'Y-m-d H:i:sO');

        }

        return $return;

    }



}