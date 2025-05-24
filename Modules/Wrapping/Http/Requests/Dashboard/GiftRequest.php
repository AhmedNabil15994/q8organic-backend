<?php

namespace Modules\Wrapping\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GiftRequest extends FormRequest {
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */

    public function rules() {
        switch ( $this->getMethod() ) {

            // handle creates
            case 'post':
            case 'POST':

            return [
                'title.*'             => 'required',
                'price'               => 'required|numeric|min:1',
                'qty'                 => 'required|integer|min:1',
                'sku'                 => 'nullable',
                'size.width'          => 'required|numeric',
                'size.length'         => 'required|numeric',
                'size.height'         => 'required|numeric',
                'size.weight'         => 'nullable|numeric',
            ];

            //handle updates
            case 'put':
            case 'PUT':
            return [
                'title.*'             => 'required',
                'price'               => 'required|numeric|min:1',
                'qty'                 => 'required|integer|min:1',
                'sku'                 => 'nullable',
                'size.width'          => 'required|numeric',
                'size.length'         => 'required|numeric',
                'size.height'         => 'required|numeric',
                'size.weight'         => 'nullable|numeric',
            ];
        }
    }

    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */

    public function authorize() {
        return true;
    }

    public function messages() {
        $v = [
            'price.required'                => __( 'wrapping::dashboard.gifts.validation.price.required' ),
            'vendor_id.required'            => __( 'wrapping::dashboard.gifts.validation.vendor_id.required' ),
            'qty.required'                  => __( 'wrapping::dashboard.gifts.validation.qty.required' ),
            'qty.integer'                   => __( 'wrapping::dashboard.gifts.validation.qty.numeric' ),
            'price.numeric'                 => __( 'wrapping::dashboard.gifts.validation.price.numeric' ),
            'sku.required'                  => __( 'wrapping::dashboard.gifts.validation.sku.required' ),
            'qty.numeric'                   => __( 'wrapping::dashboard.gifts.validation.qty.numeric' ),

            'size.width.required'=> __( 'wrapping::dashboard.gifts.validation.width.required' ),
            'size.width.numeric'=> __( 'wrapping::dashboard.gifts.validation.width.numeric' ),
            'size.length.required'=> __( 'wrapping::dashboard.gifts.validation.length.required' ),
            'size.length.numeric'=> __( 'wrapping::dashboard.gifts.validation.length.numeric' ),
            'size.height.required'=> __( 'wrapping::dashboard.gifts.validation.height.required' ),
            'size.height.numeric'=> __( 'wrapping::dashboard.gifts.validation.height.numeric' ),
            'size.weight.numeric'=> __( 'wrapping::dashboard.gifts.validation.weight.numeric' ),
        ];

        foreach ( config( 'laravellocalization.supportedLocales' ) as $key => $value ) {

            $v['title.'.$key.'.required']  = __( 'wrapping::dashboard.gifts.validation.title.required' ).' - '.$value['native'].'';

        }

        return $v;

    }
}
