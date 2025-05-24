<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => url($this->image),
            'status' => $this->status,
            'type' => is_null($this->category_id) ? 'main_category' : 'sub_category',
            'print_status' => $this->status ? __('apps::dashboard.datatable.active') :  __('apps::dashboard.datatable.unactive'),
            'print_type' => is_null($this->category_id) ? __('apps::dashboard.general.main_category') : __('apps::dashboard.general.sub_category'),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
