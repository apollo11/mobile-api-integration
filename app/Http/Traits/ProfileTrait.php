<?php
namespace App\Http\Traits;

trait ProfileTrait
{
    public function userDetailsOutput($output, $count)
    {
        $data = [
            'id' => $output->id,
            'profile_id' => $output->profile_id,
            'name' => $output->userName,
            'mobile_no' => $output->userMobile,
            'nric_no' => $output->nric_no,
            'email' => $output->userEmail,
            'school' => $output->userScool,
            'additional_info' => [
                'birthdate' => $output->birthdate,
                'nationality' => $output->nationality,
                'language' => $output->language,
                'religion' => $output->religion,
                'address' => $output->religion,
                'school_pass_expiry_date' => $output->school_pass_expiry_date,
                'emergency_contact' => [
                    'name' => $output->emergency_name,
                    'contact_no' => $output->emergency_contact_no,
                    'relationship' => $output->emergency_relationship,
                    'address' => $output->address,
                ],
                'contact_method' => $output->contact_method,
                'criminal_record' => [
                    'has_record' => null,
                    'reason' => $output->criminal_record,
                ],
                'medical_condition' => [
                    'has_medical_condition' => null,
                    'condition' => $output->medication
                ],
                'availability' => [
                    'day' => null,
                    'start_time' => null,
                    'end_time' => null
                ],
            ],
            'created_at' => $output->created_at,
            'updated_at' => $output->updated_at,
            'employee_status' => $output->employee_status,
            'schedule_count' => $count
        ];

        return $data;
    }

}