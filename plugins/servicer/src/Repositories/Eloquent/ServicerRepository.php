<?php

namespace Botble\Servicer\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Servicer\Repositories\Interfaces\ServicerInterface;

class ServicerRepository extends RepositoriesAbstract implements ServicerInterface
{
	/**
	 * @param array $select
	 * @return Collection
	 */
	public function getRoomTypesApartments(array $select = ['*'])
	{
	    $data = $this->model->where('status', '=', 1)
	    				->whereIn('format_type', [APARTMENT_MODULE_SCREEN_NAME, ROOM_TYPE_MODULE_SCREEN_NAME])
					    ->select($select)
					    ->orderBy('servicers.order', 'desc');

	    $data = apply_filters(BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM, $data, $this->model, SERVICER_MODULE_SCREEN_NAME)->get();

	    $this->resetModel();
	    return $data;
	}
}
