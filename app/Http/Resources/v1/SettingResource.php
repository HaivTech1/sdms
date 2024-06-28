<?php

namespace App\Http\Resources\v1;

use App\Models\Term;
use App\Models\Period;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => application('name'),
            'alias' => application('alias'),
            'motto' => application('motto'),
            'slogan' => application('slogan'),
            'address' => application('address'),
            'phone_number' => application('line1'),
            'website' => application('website'),
            'logo' => application('image'),
            'term' => new TermResource(Term::where('status', true)->first()),
            'session' => new SessionResource(Period::where('status', true)->first()),
            'exam_remark' => get_settings('exam_remark'),
            'exam_remark_junior' => get_settings('exam_remark_jun'),
            'exam_grade' => get_settings('exam_grade'),
            'exam_grade_junior' => get_settings('exam_grade_jun'),
            'score_color_ten' => get_settings('over_ten'),
            'score_color_twenty' => get_settings('over_twenty'),
            'score_color_fourty' => get_settings('over_fourty'),
            'score_color_sixty' => get_settings('over_sixty'),
            'score_color_100' => get_settings('over_hundred'),
        ];
    }
}
