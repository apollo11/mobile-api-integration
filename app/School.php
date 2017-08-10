<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function university()
    {
        $school = [
            "schools" => [
                "Digipen"
                , "EDHEC Risk Institute-Asia"
                , "ESSEC Business School(Singapore)"
                , "GIST-TUM Asia"
                , "INSEAD, Singapore"
                , "Institute of Technical Education, Singapore"
                , "LaSalle College of the Arts"
                , "Nanyang Academy of Fine Arts"
                , "Nanyang Technological University"
                , "National University of Singapore"
                , "New York University Tisch School of the Arts, Asia"
                , "Ngee Ann Polytechnic"
                , "Republic Polytechnic"
                , "S P Jain School of Global Management Singapore"
                , "SIM University"
                , "Singapore Institute of Technology"
                , "Singapore Management University"
                , "Singapore Polytechnic"
                , "Singapore University of Technology and Design"
                , "Sorbonne-Assas International Law school"
                , "Temasek Polytechnic"
                , "The University of Chicago Booth School of Business"
                , "University of Nevada, Las Vegas(Singapore)"

            ],
        ];

        return $school;
    }
}
