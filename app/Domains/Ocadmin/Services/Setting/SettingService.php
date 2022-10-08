<?php

namespace App\Domains\Ocadmin\Services\Setting;

use App\Repositories\Eloquent\Setting\SettingRepository;

class SettingService
{
    private $modelName = "\App\Models\Setting\Setting";

	public function __construct(SettingRepository $settingRepository)
	{
		$this->model = new $this->modelName;
        $this->repository = $settingRepository;
	}

	public function getSettings($data)
	{
        $rows = $this->repository->getRows($data,'*');

		foreach($rows as $row){
			$key = $row['key'];
			$result[$key] = $row['value'];
		}
		
        return $result;
	}

	public function getSetting($data)
	{
        if(!empty($data['id'])){
            $setting = $this->repository->find($data['id'], '*');
        }else{
			$queries = [
				'filter_orgination_id' => $data['orgination_id'],
				'filter_group' => $data['group'],
				'filter_key' => $data['key'],
			];
            $setting = $this->repository->getRow($queries); // not yet
        }

        return $setting;
	}

	public function editSettings(array $allData, array $whereColumns, $updateColumns)
	{
		
		$this->repository->upsert($allData, $whereColumns, $updateColumns);
	}


	public function editSetting(array $where, array $update_date, $force = 0)
	{
		$success = null;

		$result = $this->repository->updateOrCreate($where, $update_date);
	}
}