<?php
namespace SmartyStudio\GalleryCrud\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'            => 'required|min:5|max:255',
            'slug'             => 'unique:galleries,slug,'.\Request::get('id'),
            'body'             => 'min:5',
            'images.*'         => 'in:0,1',
            'status'           => 'required|in:0,1',
        ];
    }
}
