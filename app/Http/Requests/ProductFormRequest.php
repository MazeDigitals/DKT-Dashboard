<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class ProductFormRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->all();
        // $id = '';
        // if( isset($data['product_id']) ){
        //     $id = $data['product_id'];
        // }
        return [
            'name' => ['required','max:150','min:3'],
            'price' => ['required','numeric','max:10000000','min:3'],
            'url_krave' => ['nullable'],
            'url_daraz' => ['nullable'],
            'url_dvago' => ['nullable'],
            'short_desc' => ['nullable','max:255'],
            'specification' => ['nullable','max:1000'],
            'image' => ['nullable'],
        ];
    }

    protected function getValidatorInstance() {
        $data = $this->all();

        if( isset($data['status']) && ($data['status']=='finished') ){
            unset($data['status']);
        } else if( isset($data['status']) ){
            $data['status'] = Product::STATUS_ACTIVE;
        } else {
            $data['status'] = Product::STATUS_PENDING;
        }

        $this->getInputSource()->replace($data);

        /** modify data before send to validator */
        return parent::getValidatorInstance();
    }

}
