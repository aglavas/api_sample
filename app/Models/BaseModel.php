<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BaseModel extends Model
{
    /**
     * Return registered locale
     *
     * @return mixed
     */
    public function getLocale()
    {
        return App::getLocale();
    }
}
