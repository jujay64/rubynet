<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}

	protected function showAll(Collection $collection, $code = 200)
	{
		if($collection->isempty()){
			return $this->successResponse($collection, $code);
		}

		$transformer = $collection->first()->transformer;

		$collection = $this->sortData($collection, $transformer);
        $collection = $this->filterBirthday($collection,$transformer);
		$collection = $this->filterData($collection, $transformer);
        $collection = $this->limitData($collection);
		$collection = $this->paginate($collection);
		$collection = $this->transformData($collection, $transformer);
		$collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $model, $code = 200)
	{
		$transformer = $model->transformer;

		$model = $this->transformData($model, $transformer);

		return $this->successResponse($model, $code);
	}

	protected function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
	}

	protected function sortData(Collection $collection, $transformer)
	{
		if(request()->has('sort_by') && request()->has('descending') && request()->descending === 'true'){
			$attribute = $transformer::originalAttribute(request()->sort_by);
            if(request()->sort_by == 'dateOfBirth')
			     $collection = $collection->sortByDesc(function($item) use($attribute){
                    return Carbon::parse(data_get($item, $attribute))->day;
                }); 
            else
                $collection = $collection->sortByDesc->{$attribute};
        }
        elseif(request()->has('sort_by')){
            $attribute = $transformer::originalAttribute(request()->sort_by);
            if(request()->sort_by == 'dateOfBirth')
                 $collection = $collection->sortBy(function($item) use ($attribute){
                    return Carbon::parse(data_get($item, $attribute))->day;
                }); 
            else
                $collection = $collection->sortBy->{$attribute};
        }

		return $collection;
	}

	public function transformData($data, $transformer)
	{

        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function filterData(Collection $collection, $transformer)
    {
    	foreach(request()->query() as $query => $value){
            if(request()->has('dateOfBirth'))
                continue;
    		$attribute = $transformer::originalAttribute($query);
    		if(isset($value, $attribute)){
    			$collection = $collection->where($attribute, $value);
    		}
    	}
    	return $collection;
    }

    protected function filterBirthday(Collection $collection, $transformer)
    {
        if(request()->has('dateOfBirth')){
            $attribute = $transformer::originalAttribute('dateOfBirth');
            $now = Carbon::now();
            $this_month = $now->month;
            $this_week = $now->weekOfYear;
            if(request()->dateOfBirth == 'month')      
                $collection = $collection->where($attribute, '!=', NULL)
                                         ->filter(function ($item) use ($this_month, $attribute) {
                    return (Carbon::parse(data_get($item, $attribute))->month == $this_month);
                    });
            elseif(request()->dateOfBirth == 'week')      
                $collection = $collection->where($attribute, '!=', NULL)
                                         ->filter(function ($item) use ($this_week, $attribute) {
                    return (Carbon::parse(data_get($item, $attribute))->weekOfYear == $this_week);
                    });
        }
        return $collection;
    }

    protected function limitData(Collection $collection)
    {
        if(request()->has('limit')){
                $collection = $collection->take(request()->limit);
         }
        
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
    	$rules=[
    		'per_page' => 'integer|min:2|max:50'
    	];

    	Validator::validate(request()->all(), $rules);

    	$page = LengthAwarePaginator::resolveCurrentPage();

    	$perPage = 15;
    	if(request()->has('per_page')){
    		$perPage = (int)request()->per_page;
    	}
    	$results = $collection->slice(($page - 1)* $perPage, $perPage)->values();

    	$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
    		'path' => LengthAwarePaginator::resolveCurrentPath(),
    	]);

    	$paginated->appends(request()->all());

    	return $paginated;

    }

    protected function cacheResponse($data)
    {
    	$url = request()->url();
    	$queryParameters = request()->query();

    	ksort($queryParameters);

    	$queryString = http_build_query($queryParameters);

    	$fullUrl = "{$url}?{$queryString}";

    	return Cache::remember($fullUrl, 30/60, function() use($data) {
    		return $data;
    	});
    }

}