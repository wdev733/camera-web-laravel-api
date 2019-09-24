<?php

namespace App\Http\Requests\Teamwork;

use Mpociot\Teamwork\TeamworkTeam;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TeamStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $teamId = TeamworkTeam::where('id', '=', $this->id)->first();

        return [
            'name' => ['required', 'min:3', 'max:100', Rule::unique('teams', 'name')->ignore($teamId)],
        ];
    }
}
