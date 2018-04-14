<?php

namespace Botble\Servicer\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface ServiceTypeInterface extends RepositoryInterface
{
	/**
     * @param array $condition
     * @return mixed
     * @author Anh Ngo
     */
    public function getHotels(array $select);
}