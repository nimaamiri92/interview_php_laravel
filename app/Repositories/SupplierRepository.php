<?php


namespace App\Repositories;


use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }


    public function getSupplier($id)
    {
        $rawSuppliers = $this->getRawSuppliers();
        $convertedRawSuppliersToPhpArray = convertJsonToArray($rawSuppliers, false);
        return $this->getSupplierById($convertedRawSuppliersToPhpArray, $id);
    }

    public function getSupplierByName(string $name){
        return $this->findOneBy(['name' => $name]);
    }


    private function getRawSuppliers()
    {
        return file_get_contents(resource_path('data/suppliers.json'));
    }

    /**
     * @param $convertedRawSuppliersToPhpArray
     * @return mixed
     */
    private function getAllSuppliers($convertedRawSuppliersToPhpArray)
    {
        $allSuppliers = $convertedRawSuppliersToPhpArray->data->suppliers;
        return $allSuppliers;
    }

    /**
     * @param $convertedRawSuppliersToPhpArray
     * @param $id
     */
    private function getSupplierById($convertedRawSuppliersToPhpArray, $id)
    {
        $allSuppliers = $this->getAllSuppliers($convertedRawSuppliersToPhpArray);

        if (empty($allSuppliers[$id])){
            return new \stdClass();
        }

        return $allSuppliers[$id];
    }
}