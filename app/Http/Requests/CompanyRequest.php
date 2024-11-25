<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true to allow all users by default
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check if the 'company' ID exists in the route (i.e., update request)
        if ($this->route('id')) {
            // Update request validation rules
            return [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:companies,email,' . $this->route('id'), // Ignore the current company’s email
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional logo for updates
                'website' => 'nullable|url|max:255',
            ];
        }

        // Store request validation rules (for creating a new company)
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email', // Email must be unique for a new company
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional logo for creation
            'website' => 'nullable|url|max:255',
        ];
    }
}
