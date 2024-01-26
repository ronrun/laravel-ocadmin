<?php

namespace App\Repositories\Common;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Taxonomy;
use App\Models\Common\TaxonomyMeta;

class TaxonomyMetaRepository extends Repository
{
    public $modelName = "\App\Models\Common\TaxonomyMeta";
}