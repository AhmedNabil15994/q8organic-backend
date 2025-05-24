<?php

namespace Modules\Order\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;
use Cart;
use Modules\Attribute\Traits\AttributeTrait;

class CreateOrderRequest extends FormRequest
{
    use AttributeTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->address_type == 'unknown_address') {
            $rules = [
                'receiver_name' => 'required|max:255',
                'receiver_mobile' => 'required|max:20',
            ];
        } elseif ($this->address_type == 'known_address') {
            $rules = [
                'mobile' => 'required|string',
            ];
        } elseif ($this->address_type == 'selected_address') {
            $rules = [
                'selected_address_id' => 'required',
            ];
        } else {
            $rules = [
                'address_type' => 'required|in:unknown_address,known_address,selected_address',
            ];
        }

        $rules['payment'] = 'required';
        $rules['shipping_company.id'] = 'nullable';
        $rules['shipping_company.day'] = 'nullable';

        if(auth()->check()){

            $this->validationWithAttributes($this->request, $rules, 'checkout');
        }else{

            $this->validationWithAttributes($this->request, $rules, ['addresses','checkout']);
        }
       
        return $this->rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'address_type.required' => __('catalog::frontend.checkout.address.validation.address_type.required'),
            'address_type.in' => __('catalog::frontend.checkout.address.validation.address_type.in'),
            'receiver_name.required' => __('catalog::frontend.checkout.address.validation.receiver_name.required'),
            'receiver_name.max' => __('catalog::frontend.checkout.address.validation.receiver_name.max'),
            'receiver_mobile.required' => __('catalog::frontend.checkout.address.validation.receiver_mobile.required'),
            'receiver_mobile.max' => __('catalog::frontend.checkout.address.validation.receiver_mobile.max'),

            'selected_address_id.required' => __('catalog::frontend.checkout.address.validation.selected_address_id.required'),

            'state_id.required' => __('user::frontend.addresses.validations.state_id.required'),
            'state_id.numeric' => __('user::frontend.addresses.validations.state_id.numeric'),
            'mobile.required' => __('user::frontend.addresses.validations.mobile.required'),
            'mobile.numeric' => __('user::frontend.addresses.validations.mobile.numeric'),
            'mobile.digits_between' => __('user::frontend.addresses.validations.mobile.digits_between'),
            'mobile.min' => __('user::frontend.addresses.validations.mobile.min'),
            'mobile.max' => __('user::frontend.addresses.validations.mobile.max'),
            'address.required' => __('user::frontend.addresses.validations.address.required'),
            'address.string' => __('user::frontend.addresses.validations.address.string'),
            'address.min' => __('user::frontend.addresses.validations.address.min'),
            'block.required' => __('user::frontend.addresses.validations.block.required'),
            'block.string' => __('user::frontend.addresses.validations.block.string'),
            'street.required' => __('user::frontend.addresses.validations.street.required'),
            'street.string' => __('user::frontend.addresses.validations.street.string'),
            'building.required' => __('user::frontend.addresses.validations.building.required'),
            'building.string' => __('user::frontend.addresses.validations.building.string'),

            'payment.required' => __('order::frontend.orders.validations.payment.required'),
//            'payment.in' => __('order::frontend.orders.validations.payment.in'),

            'shipping_company.id.required' => __('catalog::frontend.checkout.validation.vendor_company.required'),
            'shipping_company.day.required' => __('catalog::frontend.checkout.validation.vendor_company_day.required'),

        ];

        /*if (count($this->vendors_ids) > 0) {
            foreach ($this->vendors_ids as $k => $vendorId) {
                $v['vendor_company.' . $vendorId . '.required'] = __('catalog::frontend.checkout.validation.vendor_company.required');
            }
            foreach ($this->vendor_company as $vendorId => $companyId) {
                $v['vendor_company_day.' . $vendorId . '.' . $companyId . '.required'] = __('catalog::frontend.checkout.validation.vendor_company_day.required');
            }
        }*/

        return $v;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (!in_array($this->payment, config('setting.other.supported_payments',[])) && !count(config("setting.payment_gateway.{$this->payment}",[]))) {
                return $validator->errors()->add(
                    'payment', __('order::frontend.orders.index.alerts.payment_not_supported_now')
                );
            }
        });
        return true;
    }
}
