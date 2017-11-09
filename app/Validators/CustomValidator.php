<?php

namespace App\Validators;

use App\Models\Meal\Meal;
use App\Models\Pivot\BmiPhysiquePlanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomValidator
{

    /**
     * Validation rule for checking timestamp that need to be equal or after specified timestamp
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function existsWith($message, $attribute, $rule, $parameters)
    {
        $count = DB::table($rule[0])->where($rule[1], $attribute)->where($rule[2], $rule[3])->count();

        if (!$count) {
            return false;
        }

        return true;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function existsWithReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Key " . $parameters[1] . " must exists in combination with " . $parameters[2] . ".";

        return $message;
    }
}
