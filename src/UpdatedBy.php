<?php
namespace Koodoo\laravelTraitUpdatedBy;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        static::saving(function ($model)
        {
            if(!\Auth::guest())
            {
                $model->updated_by = \Auth::user()->id;
                $model->company_id = \Auth::user()->company_id;
            }
            else {
                // set the updated by if the model has not previously been
                // updated by a real person.
                if (!$model->updated_by) {
                    $model->updated_by = '1';
                }
                if (!$model->company_id) {
                    $model->company_id = '1';
                }
            }
        });
    }
}
