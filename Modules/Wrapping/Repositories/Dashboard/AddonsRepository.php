<?php

namespace Modules\Wrapping\Repositories\Dashboard;

use Modules\Wrapping\Entities\WrappingAddons;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class AddonsRepository
{
    use SyncRelationModel;

    protected $addons;

    public function __construct(WrappingAddons $addons)
    {
        $this->addons = $addons;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $addons = $this->addons->orderBy($order, $sort)->get();
        return $addons;
    }

    public function findById($id)
    {
        $addons = $this->addons->withDeleted()->find($id);
        return $addons;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $addons = $this->addons->create([
                'image' => $request->image ? path_without_domain($request->image) : url(config('setting.logo')),
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                "title"=>$request->title
            ]);

          

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        $addons = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($addons) : null;


        try {
            $addons->update([
                'image' => $request->image ? path_without_domain($request->image) : $addons->image,
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                "title"=>$request->title
            ]);

         

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        return $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
        }
        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete(); else:
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->addons->query();

        $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }
}
