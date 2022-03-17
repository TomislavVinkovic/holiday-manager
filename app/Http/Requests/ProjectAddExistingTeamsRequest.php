<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectAddExistingTeamsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::check()) {
            return false;
        }
        return true;
    }
    public function rules()
    {
        return [
            'project_id' => ['required', 'integer'],
            'teams' => ['required', 'integer_array'] //integer_array je custom validation pravilo
        ];
    }
}
