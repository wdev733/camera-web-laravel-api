<?php

namespace App\Rules;

use App\Site;
use Illuminate\Contracts\Validation\Rule;

class UniqueSiteNameWithinTeam implements Rule
{
    public $site_id;
    /**
     * Create a new rule instance.
     *
     * @param null|mixed $site_id
     * @return void
     */
    public function __construct($site_id = null)
    {
        $this->site_id = $site_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! request('team') && auth('api')->user()) {
            $team = auth('api')->user()->current_team_id;
        } else {
            $team = request('team');
        }
        if (is_null($this->site_id)) {
            $matches = Site::where('name', request('name'))
                ->where('team_id', $team)
                ->count();
        } else {
            $matches = Site::where('name', request('name'))
                ->where('team_id', $team)
                ->where('id', '!=', $this->site_id)
                ->count();
        }

        return $matches === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Site name within a team should be unique.';
    }
}
