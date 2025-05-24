<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Constants\Product;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Catalog\Imports\ProductImportCollection;

class ImportProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'title_ar' => 'required',
            'price' => 'required',
            "file_status.*" => 'in:on,off|nullable',
            "file_qty.*" => 'nullable|integer',
            "file_price.*" => 'required|numeric|min:0',
            "file_offer_price.*" => 'nullable|numeric|min:0',
            "file_offer_start_at.*" => 'nullable|date_format:Y-m-d',
            "file_offer_end_at.*" => 'nullable|date_format:Y-m-d',
            "file_title_ar.*" => 'required',
            "file_offer_price.*" => 'nullable|numeric|min:0',
            "file_sku.*" => 'nullable',
            "file_international_code.*" => 'nullable|unique:products,international_code',
        ];
    }


    public function validationData()
    {
        $rows = Excel::toArray(new ProductImportCollection, $this->file('excel_file'));

        if (is_array($rows) && count($rows)) {

            $keys = $this->requestInitializing($this->request->all());
            $requestData = $keys[1];
            $keys = $keys[0];
            
            foreach ($rows[0] as $row) {
                foreach ($row as $key => $val) {

                    $key && isset($requestData[$keys[$key]]) ? array_push($requestData[$keys[$key]], $val) : null;
                }
            }

            $this->merge($requestData);
        }

        return $this->all();
    }


    private function requestInitializing($oldRequest)
    {

        $response = [];
        $requestData = [];
        foreach (Product::IMPORT_PRODUCT_COLS as $key) {
            $result = str_replace(' ', '_', strtolower($oldRequest[$key]));
            $response[($result ?? 'not_found')] = "file_{$key}";
            $requestData["file_{$key}"] = [];
        }

        return [$response, $requestData];
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
            'price.required' => __('catalog::dashboard.products.validation.price.required'),
            'price.numeric' => __('catalog::dashboard.products.validation.price.numeric'),
            'sku.required' => __('catalog::dashboard.products.validation.sku.required'),
            'variation_price.*.required' => __('catalog::dashboard.products.validation.variation_price.required'),
            'variation_qty.*.required' => __('catalog::dashboard.products.validation.variation_qty.required'),
            'variation_status.*.required' => __('catalog::dashboard.products.validation.variation_status.required'),
            'variation_sku.*.required' => __('catalog::dashboard.products.validation.variation_sku.required'),

            'qty.required' => __('catalog::dashboard.products.validation.qty.required'),
            'qty.integer' => __('catalog::dashboard.products.validation.qty.integer'),
            'qty.numeric' => __('catalog::dashboard.products.validation.qty.numeric'),
            'qty.min' => __('catalog::dashboard.products.validation.qty.min') . ' 0',

            'category_id.required' => __('catalog::dashboard.products.validation.category_id.required'),

            '_variation_price.*.required' => __('catalog::dashboard.products.validation.variation_price.required'),
            '_variation_qty.*.required' => __('catalog::dashboard.products.validation.variation_qty.required'),
            '_variation_status.*.required' => __('catalog::dashboard.products.validation.variation_status.required'),
            '_variation_sku.*.required' => __('catalog::dashboard.products.validation.variation_sku.required'),

            'offer_type.required' => __('catalog::dashboard.products.validation.offer_type.required'),
            'offer_type.in' => __('catalog::dashboard.products.validation.offer_type.in') . ' : amount,percentage',
            'offer_price.required_if' => __('catalog::dashboard.products.validation.offer_price.required'),
            'offer_price.numeric' => __('catalog::dashboard.products.validation.offer_price.numeric'),
            'offer_percentage.required_if' => __('catalog::dashboard.products.validation.offer_percentage.required'),
            'offer_percentage.numeric' => __('catalog::dashboard.products.validation.offer_percentage.numeric'),

            'start_at.required_if' => __('catalog::dashboard.products.validation.start_at.required'),
            'start_at.date' => __('catalog::dashboard.products.validation.start_at.date'),
            'end_at.required_if' => __('catalog::dashboard.products.validation.end_at.required'),
            'end_at.date' => __('catalog::dashboard.products.validation.end_at.date'),

            'v_offers.*.offer_price.numeric' => __('catalog::dashboard.products.validation.offer_price.numeric'),
            'v_offers.*.offer_price.required_if' => __('catalog::dashboard.products.validation.offer_price.required'),
            'v_offers.*.start_at.required_if' => __('catalog::dashboard.products.validation.start_at.required'),
            'v_offers.*.start_at.date' => __('catalog::dashboard.products.validation.start_at.date'),
            'v_offers.*.end_at.required_if' => __('catalog::dashboard.products.validation.end_at.required'),
            'v_offers.*.end_at.date' => __('catalog::dashboard.products.validation.end_at.date'),

            '_v_offers.*.offer_price.numeric' => __('catalog::dashboard.products.validation.offer_price.numeric'),
            '_v_offers.*.offer_price.required_if' => __('catalog::dashboard.products.validation.offer_price.required'),
            '_v_offers.*.start_at.required_if' => __('catalog::dashboard.products.validation.start_at.required'),
            '_v_offers.*.start_at.date' => __('catalog::dashboard.products.validation.start_at.date'),
            '_v_offers.*.end_at.required_if' => __('catalog::dashboard.products.validation.end_at.required'),
            '_v_offers.*.end_at.date' => __('catalog::dashboard.products.validation.end_at.date'),


            'shipment.width.required' => __('catalog::dashboard.products.validation.width.required'),
            'shipment.width.numeric' => __('catalog::dashboard.products.validation.width.numeric'),
            'shipment.length.required' => __('catalog::dashboard.products.validation.length.required'),
            'shipment.length.numeric' => __('catalog::dashboard.products.validation.length.numeric'),
            'shipment.weight.required' => __('catalog::dashboard.products.validation.weight.required'),
            'shipment.weight.numeric' => __('catalog::dashboard.products.validation.weight.numeric'),
            'shipment.height.required' => __('catalog::dashboard.products.validation.height.required'),
            'shipment.height.numeric' => __('catalog::dashboard.products.validation.height.numeric'),
            'vshipment.*.width.required' => __('catalog::dashboard.products.validation.width.required'),
            'vshipment.*.width.numeric' => __('catalog::dashboard.products.validation.width.numeric'),
            'vshipment.*.length.required' => __('catalog::dashboard.products.validation.length.required'),
            'vshipment.*.length.numeric' => __('catalog::dashboard.products.validation.length.numeric'),
            'vshipment.*.weight.required' => __('catalog::dashboard.products.validation.weight.required'),
            'vshipment.*.weight.numeric' => __('catalog::dashboard.products.validation.weight.numeric'),
            'vshipment.*.height.required' => __('catalog::dashboard.products.validation.height.required'),
            'vshipment.*.height.numeric' => __('catalog::dashboard.products.validation.height.numeric'),

            '_vshipment.*.width.required' => __('catalog::dashboard.products.validation.width.required'),
            '_vshipment.*.width.numeric' => __('catalog::dashboard.products.validation.width.numeric'),
            '_vshipment.*.length.required' => __('catalog::dashboard.products.validation.length.required'),
            '_vshipment.*.length.numeric' => __('catalog::dashboard.products.validation.length.numeric'),
            '_vshipment.*.weight.required' => __('catalog::dashboard.products.validation.weight.required'),
            '_vshipment.*.weight.numeric' => __('catalog::dashboard.products.validation.weight.numeric'),
            '_vshipment.*.height.required' => __('catalog::dashboard.products.validation.height.required'),
            '_vshipment.*.height.numeric' => __('catalog::dashboard.products.validation.height.numeric'),

            'image.required' => __('catalog::dashboard.products.validation.image.required'),
            'image.image' => __('catalog::dashboard.products.validation.image.image'),
            'image.mimes' => __('catalog::dashboard.products.validation.image.mimes'),
            'image.max' => __('catalog::dashboard.products.validation.image.max'),

            'v_images.*.image' => __('catalog::dashboard.products.validation.image.image'),
            'v_images.*.mimes' => __('catalog::dashboard.products.validation.image.mimes'),
            'v_images.*.max' => __('catalog::dashboard.products.validation.image.max'),
            '_v_images.*.image' => __('catalog::dashboard.products.validation.image.image'),
            '_v_images.*.mimes' => __('catalog::dashboard.products.validation.image.mimes'),
            '_v_images.*.max' => __('catalog::dashboard.products.validation.image.max'),

            'tags.array' => __('catalog::dashboard.products.validation.tags.array'),
            'search_keywords.array' => __('catalog::dashboard.products.validation.search_keywords.array'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['title.' . $key . '.required'] = __('catalog::dashboard.products.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique"] = __('catalog::dashboard.products.validation.title.unique') . ' - ' . $value['native'] . '';
        }

        if (isset($this->images) && !empty($this->images)) {
            foreach ($this->images as $k => $img) {
                $v['images.' . $k . '.mimes'] = __('catalog::dashboard.products.validation.images.mimes');
                $v['images.' . $k . '.max'] = __('catalog::dashboard.products.validation.images.max');
            }
        }

        return $v;
    }
}
