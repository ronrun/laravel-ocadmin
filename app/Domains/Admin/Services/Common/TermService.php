<?php

namespace App\Domains\Admin\Services\Common;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Common\TermRepository;
use App\Repositories\Common\TermMetaRepository;
use App\Services\Service;
use App\Helpers\Classes\DataHelper;

class TermService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\Common\Term";

    public function __construct(private TermRepository $TermRepository, private TermMetaRepository $TermMetaRepository)
    {
        $this->repository = $TermRepository;
    }

    public function getTerms($data, $debug = 0)
    {
        return $this->repository->getTerms($data, $debug);
    }

    public function addTaxonomies($data, $debug = 0)
    {

    }

    public function save($post_data)
    {
        try {
            //save term
            $result = $this->repository->save($post_data['term_id'], $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            $term = $result['data'];
            
            //save translation meta
            $result = null;
            if(!empty($post_data['translations'])){
                $result = $this->TermMetaRepository->saveMetaTranslations($term, $post_data['translations']);
            }
            
            return ['data' => ['term_id' => $term->id]];

        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $json['error'] = $msg;
            return $json;
        }
    }

    public function removeAdmin($term_id)
    {
        //$this->TermMetaRepository->removeAdmin($term_id);
    }
}