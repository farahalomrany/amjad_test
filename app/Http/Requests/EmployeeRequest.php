<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true to allow the request by default
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // If an ID exists in the route, it's an update operation
        if ($this->route('id')) {
            return [
                'first_name' => 'sometimes|required|string|max:255',
                'last_name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:employees,email,' . $this->route('id'), // Ignore the current employee's email
                'phone' => 'nullable|string|max:15',
                'company_id' => 'nullable|exists:companies,id',
            ];
        }

        // If no ID, it's a store (create) request
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:15',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}
