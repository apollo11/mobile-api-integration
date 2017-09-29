<?php
namespace App\Http\Traits;

trait ProfileTrait
{
    public function userDetailsOutput($output, $count)
    {
        $availability[] = [
                'day' => null,
                'start_time' => null,
                'end_time' => null
        ];

        $data = [
            'id' => $output->id,
            'profile_id' => $output->profile_id,
            'name' => $output->userName,
            'mobile_no' => $output->userMobile,
            'nric_no' => $output->nric_no,
            'email' => $output->userEmail,
            'profile_photo' => $output->profile_photo,
            'school' => is_null($output->school) ? $output->userSchool : $output->school,
            'additional_info' => [
                'birthdate' => $output->birthdate,
                'nationality' => null,
                'language' => $output->language,
                'religion' => $output->religion,
                'address' => $output->address,
                'school_pass_expiry_date' => $output->school_pass_expiry_date,
                'gender' => $output->gender,
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
                'availabilities' => $availability,
            ],
            'created_at' => $output->created_at,
            'updated_at' => $output->updated_at,
            'employee_status' => $output->employee_status,
            'schedule_count' => $count,
            'is_uploaded' => is_null($output->is_uploaded) ? 0 : $output->is_uploaded,
            'money_earned' => 0,
        ];

        return $data;
    }

}