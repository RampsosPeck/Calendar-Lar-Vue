<?php

namespace Calendarlarvue;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    

    //protected $guarded = [];
    protected $fillable = ['event_name','start_date','end_date'];
}
