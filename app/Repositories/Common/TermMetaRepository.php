<?php

namespace App\Repositories\Common;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Term;
use App\Models\Common\TermMeta;

class TermMetaRepository extends Repository
{
    public $modelName = "\App\Models\Common\TermMeta";
}