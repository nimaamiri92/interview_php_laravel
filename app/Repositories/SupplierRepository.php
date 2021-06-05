<?php


namespace App\Repositories;


use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function calculateTotalHoursSuppliersWork()
    {
        $rawSuppliers = $this->getRawSuppliers();
        $convertedRawSuppliersToPhpArray = convertJsonToArray($rawSuppliers, false);

        $allSuppliers = $this->getAllSuppliers($convertedRawSuppliersToPhpArray);
        $sumOfSupplierWorkingHours = 0;
        $weakDays = [
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'sun',
        ];
        foreach ($allSuppliers as $supplier){
            foreach ($weakDays as $day) {
                $day = Str::after($supplier->{$day},': ');

                //get a day periods
                $allDayPeriods = explode(',',$day);
                $sumOfSupplierWorkingHours += $this->getSingleDayWorkingTimeInHour($allDayPeriods);
            }
        }

        return $sumOfSupplierWorkingHours;
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

    /**
     * @param $allDayPeriods
     */
    private function getSingleDayWorkingTimeInHour($allDayPeriods)
    {
        $singleDayWorkingHour = 0;
        foreach ($allDayPeriods as $period) {
            $startTime = Carbon::parse(explode('-', $period)[0]);
            $endTime = Carbon::parse(explode('-', $period)[1]);

            $singleDayWorkingHour += $startTime->diffInHours($endTime);
        }

        return $singleDayWorkingHour;
    }
}