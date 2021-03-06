<?php
namespace App\Services;
/**
* this class will return summary of all election result
*/
trait Summary
{
	
	public function result()
	{
		$p_pdp = 0;
		$p_apc = 0;
		$p_other = 0;
		$p_invalid = 0;
		$s_pdp = 0;
		$s_apc = 0;
		$s_other = 0;
		$s_invalid = 0;
		$r_pdp = 0;
		$r_apc = 0;
		$r_other = 0;
		$r_invalid = 0;
		foreach ($this->wards as $ward) {
			foreach ($ward->pollingUnits as $pollingUnit) {
				foreach ($pollingUnit->results as $result) {
					switch ($result->type_id) {
						case '1':
							$p_pdp = $p_pdp + $result->pdp;
							$p_apc = $p_apc + $result->apc;
							$p_other = $p_other + $result->other;
							$p_invalid = $p_invalid + $result->invalid_vote;
							break;
						case '2':
							$s_pdp = $s_pdp + $result->pdp;
							$s_apc = $s_apc + $result->apc;
							$s_other = $s_other + $result->other;
							$s_invalid = $s_invalid + $result->invalid_vote;
							break;
						
						default:
							$r_pdp = $r_pdp + $result->pdp;
							$r_apc = $r_apc + $result->apc;
							$r_other = $r_other + $result->other;
							$r_invalid = $r_invalid + $result->invalid_vote;
							break;
					}
				}
			}

			return [
                    'presidential' => [ 
                    	'apc' => $p_apc,
                    	'pdp' => $p_pdp,
                    	'other' => $p_other,
                    	'invalid' => $p_invalid
                    ],
                    'senatorial' => [ 
                    	'apc' => $s_apc,
                    	'pdp' => $s_pdp,
                    	'other' => $s_other,
                    	'invalid' => $s_invalid
                    ],
                    'representative' => [ 
                    	'apc' => $r_apc,
                    	'pdp' => $r_pdp,
                    	'other' => $r_other,
                    	'invalid' => $r_invalid
                    ]
			];
		}
	}

	public function registered()
    {
        $registered = 0;
        foreach ($this->wards as $ward) {
            foreach ($ward->pollingUnits as $pollingUnit) {
                $registered = $registered + $pollingUnit->registered;
            }
        }
        return $registered;
    }
    
    public function acredited()
    {
        $acredited = 0;
        foreach ($this->wards as $ward) {
            foreach ($ward->pollingUnits as $pollingUnit) {
                $acredited = $acredited + $pollingUnit->acredited;
            }
        }
        return $acredited;
    }
}