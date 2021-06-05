<?php


namespace App\Services;


use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use App\Tools\CustomValidationError;
use Illuminate\Database\Eloquent\Model;

class SupplierService extends BaseService
{
    const SELECTED_SUPPLIER = 1;
    /**
     * @var SupplierRepository
     */
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository,Supplier $supplier)
    {
        parent::__construct($supplier);
        $this->supplierRepository = $supplierRepository;
    }


    public function store()
    {
        $firstSupplier = $this->supplierRepository->getSupplier(self::SELECTED_SUPPLIER);

        $existedSupplier = $this->supplierRepository->getSupplierByName($firstSupplier->name);
        if (!empty($existedSupplier->name)){
            (new CustomValidationError)->setError('name',123)->throwErrors();
        }

        $supplier = $this->model;
        $supplier->name = $firstSupplier->name;
        $supplier->info = $firstSupplier->info;
        $supplier->rules = $firstSupplier->rules;
        $supplier->district = $firstSupplier->district;
        $supplier->url = $firstSupplier->url;
        $supplier->save();

        return $supplier;
    }
}