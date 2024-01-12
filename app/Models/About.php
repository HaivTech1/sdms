<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    const TABLE = 'website_about';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'input_type',
        'column_name',
        'value',
        'input_option',
        'group_type',
        'required',
        'model',
    ];

    public  function column()
    {
        $inputTypes  =
        [
            [
                "name" => "Text",
                "id" => "1"
            ],
            [
                "name" => "Textarea",
                "id" => "2"
            ],
            [
                "name" => "Select",
                "id" => "3"
            ],
            [
                "name" => "Radio",
                "id" => "4"
            ],
            [
                "name" => "Checkbox",
                "id" => "5"
            ],
            [
                "name" => "File",
                "id" => "6"
            ],
        ];

        $option  =
            [
                [
                    "name" => "Yes",
                    "id" => 1
                ],
                [
                    "name" => "No",
                    "id" => 0
                ]
            ]
        ;

        $modelTypes = [
            [
                "name" => "About",
                "id" => "about"
            ],
            [
                "name" => "Home",
                "id" => "home"
            ]
        ];

        $column = [
            "name" => [
                "name" => "Name",
                "description" => "Name of the column ",
                "column_name" => "name",
                "input_type" => "1",
                "required" => "required",
                "value" => "",
            ],
            "column_name" => [
                "name" => "Column Name",
                "description" => "This is the key to select the row.",
                "column_name" => "column_name",
                "input_type" => "1",
                "required" => "required",
                "value" => "",
            ],
            "description" => [
                "name" => "Description",
                "description" => "This is for the about title",
                "column_name" => "description",
                "input_type" => "1",
                "value" => "",
                "required" => "required",
            ],
            "input_type" => [
                "name" => "Input Type",
                "description" => "Select the input type",
                "column_name" => "input_type",
                "input_type" => "3",
                "required" => "required",
                "value" => "",
                "option" => $inputTypes,
            ],
            "required" => [
                "name" => "Required",
                "description" => "Select if the row is required",
                "column_name" => "required",
                "input_type" => "3",
                "required" => "required",
                "value" => "",
                "option" => $option,
            ],
            "model" => [
                "name" => "Model",
                "description" => "Enter the model",
                "column_name" => "model",
                "input_type" => "3",
                "required" => "required",
                "value" => "",
                "option" => $modelTypes,
            ],
            "value" => [
                "name" => "Value",
                "description" => "Enter the value",
                "column_name" => "value",
                "input_type" => "1",
                "required" => "required",
                "value" => "",
            ],
            // "value" => [
            //     "name" => "Image",
            //     "description" => "Select an image",
            //     "column_name" => "image",
            //     "input_type" => "6",
            //     "required" => "",
            //     "value" => "",
            // ],
        ];
        return json_decode(json_encode($column));
    }
}
