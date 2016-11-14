<?php namespace App\Http\Requests;

class StaffUpdateRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->staff->id;
		return $rules = [
			'staff_last_name' => 'required|max:50', 
			'staff_first_name' => 'required|max:50',
			'staff_first_email' => 'required|email',
			'contract_number' => 'required|max:50'
		];
	}

}
