<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Blogs;

class BlogFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category' => 'required|in:Josh,Dkt,Okay,Heer,Dhanak',
            'image' => 'required|image',
            'content' => 'required',
            'title' => 'required'
        ];
    }

    protected function getValidatorInstance() {
        $data = $this->all();

        
        if( isset($data['status']) ){
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $this->getInputSource()->replace($data);
        /** modify data before send to validator */
        return parent::getValidatorInstance();
    }

}
