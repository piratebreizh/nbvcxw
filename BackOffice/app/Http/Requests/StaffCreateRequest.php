<?php namespace App\Http\Requests;

class StaffCreateRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'staff_last_name' => 'required',
			'staff_first_name' => 'required',
			'staff_first_email' => 'required|email',
			'contract_number' => 'required'			
		];
	}

}