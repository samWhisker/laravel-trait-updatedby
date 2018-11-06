<?php
namespace Koodoo\laravelTraitUpdatedBy;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        static::saving(function ($model)
        {
            // we want to check to see if anything has actually changed on the model first
            if (isset($model->ignore_updates) && $model->updated_by && $model->updated_by != 1) {
                $changes = $model->getDirty();
                $updated = [];
                foreach ($changes as $key => $value) {
                    if (!in_array($key, $model->ignore_updates)) {
                        if ($original = $model->getOriginal($key)) {
                            if ($original != $value) {
                                $updated[$key] = $value;
                            }
                        }
                    }
                }
                if (count($updated) == 0) {
                    return;
                }
            }

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
