<?php

namespace RefinedDigital\Team\Module\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    /**
     * Determine if the service is authorized to make this request.
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

        $config = config('team');

        $args = [
            'name'                => ['required' => 'required'],
            'content'             => ['required' => 'required'],
            'image'               => ['required' => 'required'],
        ];

        if (isset($config['fields']) && is_array($config['fields']) && sizeof($config['fields'])) {
            foreach ($config['fields'] as $key => $field) {
                if (isset($field['required']) && !$field['required'] && isset($args[$key])) {
                    unset($args[$key]);
                }
            }
        }

        if (isset($config['content']) && !$config['content'] && isset($args['content'])) {
            unset($args['content']);
        }

        // return the results to set for validation
        return $args;
    }
}
