<?php
namespace Koodoo\laravelTraitUpdatedBy;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
		static::saving(function ($model) 
        {
        	$user = \Auth::user();
            $model->updated_by = $user->id;
            $model->company = $company->id;
        });
    }
}
