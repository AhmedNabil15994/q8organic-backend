<?php

namespace Modules\Wrapping\Repositories\Dashboard;

use Modules\Wrapping\Entities\Card;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class CardRepository
{
    use SyncRelationModel;

    protected $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $cards = $this->card->orderBy($order, $sort)->get();
        return $cards;
    }

    public function findById($id)
    {
        $card = $this->card->withDeleted()->find($id);
        return $card;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $card = $this->card->create([
                'image' => $request->image ? path_without_domain($request->image) : url(config('setting.logo')),
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                "size" => $request->size,
                "title"=> $request->title

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
        $card = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($card) : null;


        try {
            $card->update([
                'image' => $request->image ? path_without_domain($request->image) : $card->image,
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                "size" => $request->size,
                "title"=> $request->title
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
        $query = $this->card->query();

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
