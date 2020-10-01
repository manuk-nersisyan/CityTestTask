<?php

namespace App\Http\Controllers;

use App\CitiesStatus;
use App\CitiesV1;
use App\CitiesV2;
use App\Http\Requests\SearchCityRequest;

class CitiesController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $citiesStatus = CitiesStatus::query()->first('is_active');

        if ($citiesStatus ->is_active == 'CitiesV1'){
            $city = CitiesV1::query()
                ->findOrFail($id);

            $nearCities = CitiesV1::query()
                ->select('name','latitude','longitude')
                ->where('latitude','LIKE','%'.intval($city->latitude).'%')
                ->where('longitude','LIKE','%'.intval($city->longitude).'%')
                ->limit(20)
                ->get();
        }
        else{
            $city = CitiesV2::query()
                ->findOrFail($id);

            $nearCities = CitiesV2::query()->select('name','latitude','longitude')
                       ->where('latitude','LIKE','%'.intval($city->latitude).'%')
                       ->where('longitude','LIKE','%'.intval($city->longitude).'%')
                       ->limit(20)
                       ->get();

        }

        $forJsArray = [];
        foreach ($nearCities as $nearCity){
            $nearCitiesForMap=[];
            $nearCitiesForMap[] = $nearCity->name;
            $nearCitiesForMap[] = $nearCity->latitude;
            $nearCitiesForMap[] = $nearCity->longitude;
            array_push($forJsArray,$nearCitiesForMap);
            }

        array_push($forJsArray,[$city->name,$city->latitude,$city->longitude ]);
        return view('city')->with(['city'=>$city, 'nearCitiesForJS'=> $forJsArray, 'nearCities'=>$nearCities]);
    }


    /**
     * @param SearchCityRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(SearchCityRequest $request){

        $citiesStatus = CitiesStatus::query()->first('is_active');

        if ($citiesStatus ->is_active == 'CitiesV1'){
          $cities = CitiesV1::query()->select('id','name')->where('name', 'like', $request->get('city').'%')->limit(10)->get();
        }
        else{
            $cities = CitiesV2::query()->
            select('id','name')->where('name', 'like', $request->get('city').'%')
                ->limit(10)
                ->get();
        }

        return view('index')->with( ['cities' => $cities] );
    }
}
