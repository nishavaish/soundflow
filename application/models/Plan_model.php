<?php
class Plan_model extends CI_Model {

    public function insert_plan($data, $features){
        $this->db->insert('plans', $data);
        $plan_id = $this->db->insert_id();

        if(!empty($features)){
            foreach($features as $feature){
                $this->db->insert('plan_features', [
                    'plan_id' => $plan_id,
                    'feature_name' => $feature,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return $plan_id;
    }

	  public function get_plans($limit, $start, $q = null){
		if($q){
			$this->db->like('name', $q);
		}

		$this->db->limit($limit, $start);
		$plans = $this->db->get('plans')->result();

		foreach($plans as $plan){
			$plan->features = $this->db
				->get_where('plan_features', ['plan_id'=>$plan->id])
				->result();
		}

		return $plans;
	}

	public function count_plans($q = null){
		if($q){
			$this->db->like('name', $q);
		}
		return $this->db->count_all_results('plans');
	}

   
	
	
	public function get_plan($id){
		$plan = $this->db->get_where('plans', ['id'=>$id])->row();

		if($plan){
			$plan->features = $this->db
				->get_where('plan_features', ['plan_id'=>$id])
				->result();
		}

		return $plan;
	}

    public function update_plan($id, $data, $features)
	{
		// update main plan
		$this->db->where('id', $id)->update('plans', $data);

		// delete old features
		$this->db->delete('plan_features', ['plan_id' => $id]);

		// insert new features
		if (!empty($features)) {
			foreach ($features as $feature) {
				if (trim($feature) != '') {
					$this->db->insert('plan_features', [
						'plan_id' => $id,
						'feature_name' => $feature
					]);
				}
			}
		}
	}
    public function delete_plan($id){
        $this->db->delete('plans', ['id'=>$id]);
    }
}


?>