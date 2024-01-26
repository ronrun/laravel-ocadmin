<?php

namespace App\Domains\Admin\Services\Common;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Common\TaxonomyRepository;
use App\Repositories\Common\TaxonomyMetaRepository;
use App\Services\Service;
use App\Helpers\Classes\DataHelper;


class TaxonomyService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\Common\Taxonomy";

    public function __construct(private TaxonomyRepository $TaxonomyRepository, private TaxonomyMetaRepository $TaxonomyMetaRepository)
    {
        $this->repository = $TaxonomyRepository;
    }

    public function getTaxonomies($data, $debug = 0)
    {
        return $this->repository->getTaxonomies($data, $debug);
    }

    public function addTaxonomies($data, $debug = 0)
    {

    }

    public function save($post_data)
    {
        try {
            //save taxonomy
            $result = $this->repository->save($post_data['taxonomy_id'], $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            $taxonomy = $result['data'];
            
            //save translation meta
            $result = null;
            if(!empty($post_data['translations'])){
                $result = $this->TaxonomyMetaRepository->saveMetaTranslations($taxonomy, $post_data['translations']);
            }
            
            return ['data' => ['taxonomy_id' => $taxonomy->id]];

        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $json['error'] = $msg;
            return $json;
        }
    }

    public function removeAdmin($taxonomy_id)
    {
        //$this->TaxonomyMetaRepository->removeAdmin($taxonomy_id);
    }
}