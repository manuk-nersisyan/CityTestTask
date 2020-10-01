<?php

namespace App\Jobs;

use App\CitiesStatus;
use App\CitiesV1;
use App\CitiesV2;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use function Composer\Autoload\includeFile;

class UpdateCitiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $checkData;


    public function __construct($checkData)
    {
        $this->checkData = $checkData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $checkStatus = $this->checkData;
        $model = 'CitiesV1';
        $is_active = '';
        if (isset($checkStatus->is_active)){
            $is_active = $checkStatus->is_active;
            if ($checkStatus->is_active == 'CitiesV1'){
                $model = 'CitiesV2';
            }
        }

        $file_changes = date("Y-m-d H:i:s",filemtime(public_path("RU.txt")));
        if (!isset($checkStat->change_cities) || $checkStatus->change_cities !== $file_changes){

            $file = fopen(public_path("RU.txt"), "r") or exit("Unable to open file!");
            $i = 0;
            $data = [];
            while(!feof($file)) {
                $statements = explode("\t", str_replace("\n","",fgets($file)) );
                $i++;
                $data[] = [
                    'geo_name_id' => !empty($statements[0])? $statements[0] : null,
                    'name' => !empty($statements[1]) ? $statements[1] : null,
                    'ascii_name'=> !empty($statements[2]) ? $statements[2] : null,
                    'alternate_names' => !empty($statements[3]) ? $statements[3] : null,
                    'latitude' => !empty($statements[4]) ? $statements[4] : null,
                    'longitude'=> !empty($statements[5]) ? $statements[5] : null,
                    'feature_class' => !empty($statements[6]) ? $statements[6] : null,
                    'feature_code' => !empty($statements[7]) ? $statements[7] : null,
                    'country_code'=> !empty($statements[8]) ? $statements[8] : null,
                    'cc2' => !empty($statements[9]) ? $statements[9] : null,
                    'admin1' => !empty($statements[10]) ? $statements[10] : null,
                    'admin2' => !empty($statements[11]) ? $statements[11] : null,
                    'admin3' => !empty($statements[12]) ? $statements[12] : null,
                    'admin4' => !empty($statements[13]) ? $statements[13] : null,
                    'population' => !empty($statements[14]) ? $statements[14] : null,
                    'elevation' => !empty($statements[15]) ? $statements[15] : null,
                    'dem' => !empty($statements[16]) ? $statements[16] : null,
                    'timezone' => !empty($statements[17]) ? $statements[17] : null,
                    'modification_date' => !empty($statements[18]) ? $statements[18] : null
                ];

                if ($i % 1000 == 0 ){
                    $this->createCities($model,$data);
                    $data = [];
                }
            }
            if (!empty($file)) {
                $this->createCities($model, $data);
            }
            fclose($file);
            $this->citiesStatus($is_active, $model, $file_changes);
            $this->deleteCities($is_active);

        }

    }

    private function createCities($model, $data){
        if($model == 'CitiesV1'){
            CitiesV1::query()->insert($data);
        }else{
            CitiesV2::query()->insert($data);
        }


    }

    private function citiesStatus($is_active ,$model, $file_changes){

        if ($is_active == '') {
            CitiesStatus::query()
                ->create(['is_active'=> $model, 'change_cities' => $file_changes]);
        }else{
            CitiesStatus::query()
                ->update(['is_active'=> $model, 'change_cities' => $file_changes]);

        }
    }

    private function deleteCities($is_active){
        if ($is_active != ''){
           if($is_active == 'CitiesV1'){
               CitiesV1::query()->truncate();
           }else{
               CitiesV2::query()->truncate();
           }
        }
    }
}
