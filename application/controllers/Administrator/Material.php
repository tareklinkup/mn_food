<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
    }
    public function materials()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = 'Materials';
        $materialCode = 'M0001';
        $materialQuery = $this->db->query("select material_id from tbl_materials order by material_id desc limit 1");
        if ($materialQuery->num_rows() > 0) {
            $materialId = $materialQuery->row()->material_id + 1;
            $zeros = array('0', '00', '000');
            $idLenth = strlen($materialId);
            $materialCode = 'M' . ($idLenth > 3 ? $materialId : $zeros[count($zeros) - $idLenth] . $materialId);
        }
        $data['materialCode'] = $materialCode;
        $data['content'] = $this->load->view('Administrator/materials/materials', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getMaterials()
    {
        $materials = $this->db->query("
            select 
            m.*, 
            concat(m.name, ' - ', m.code) as display_text,
            c.ProductCategory_Name as category_name, 
            u.Unit_Name as unit_name,
            case
                when m.status = 1 then 'Active'
                when m.status = 0 then 'Inactive'
            end as status_text
            from tbl_materials m
            left join tbl_productcategory c on c.ProductCategory_SlNo = m.category_id
            left join tbl_unit u on u.Unit_SlNo = m.unit_id
            where m.status = 1
            and m.branch_id = ?
        ", $this->brunch)->result();
        echo json_encode($materials);
    }
    public function getMaterialsName()
    {
        $allMaterials = $this->db->query("SELECT material_id, name FROM tbl_materials WHERE status = 1")->result();
        echo json_encode($allMaterials);
    }

    public function addMaterial()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $nameQuery = $this->db->query("select * from tbl_materials where name = '$data->name'");
            $nameCount = $nameQuery->num_rows();
            if ($nameCount != 0) {
                $res = ['success' => false, 'message' => 'Duplicate material name ' . $data->name];
                echo json_encode($res);
                exit;
            }

            $codeQuery = $this->db->query("select * from tbl_materials where code = '$data->code'");
            $codeCount = $codeQuery->num_rows();
            if ($codeCount != 0) {
                $res = ['success' => false, 'message' => 'Duplicate material code ' . $data->code];
                echo json_encode($res);
                exit;
            }

            $material = array(
                "code" => $data->code,
                "name" => $data->name,
                "category_id" => $data->category_id,
                "reorder_level" => $data->reorder_level,
                "purchase_rate" => $data->purchase_rate,
                "unit_id" => $data->unit_id,
                "branch_id" => $this->brunch
            );
            $this->db->insert('tbl_materials', $material);
            //$lastId = $this->db->insert_id();
            //$lastMaterial = $this->db->query("select * from tbl_materials where material_id = '$lastId'")->row();
            $res = ['success' => true, 'message' => 'Material added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function updateMaterial()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $nameQuery = $this->db->query("select * from tbl_materials where name = '$data->name' and material_id != '$data->material_id'");
            $nameCount = $nameQuery->num_rows();
            if ($nameCount != 0) {
                $res = ['success' => false, 'message' => 'Duplicate material name ' . $data->name];
                echo json_encode($res);
                exit;
            }

            $codeQuery = $this->db->query("select * from tbl_materials where code = '$data->code' and material_id != '$data->material_id'");
            $codeCount = $codeQuery->num_rows();
            if ($codeCount != 0) {
                $res = ['success' => false, 'message' => 'Duplicate material code ' . $data->code];
                echo json_encode($res);
                exit;
            }

            $material = array(
                "code" => $data->code,
                "name" => $data->name,
                "category_id" => $data->category_id,
                "reorder_level" => $data->reorder_level,
                "purchase_rate" => $data->purchase_rate,
                "unit_id" => $data->unit_id
            );
            $this->db->where('material_id', $data->material_id);
            $this->db->set($material);
            $this->db->update('tbl_materials');
            $res = ['success' => true, 'message' => 'Material updated successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function changeMaterialStatus()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $status = $data->status == 1 ? 0 : 1;
            $this->db->where('material_id', $data->material_id);
            $this->db->set('status', $status);
            $this->db->update('tbl_materials');
            $res = ['success' => true, 'message' => 'Status changed successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function materialStock()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = 'Material Stock';
        $data['content'] = $this->load->view('Administrator/materials/material_stock', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function getMaterialStock()
    {
        $data = json_decode($this->input->raw_input_stream);

        $Clause = "";
        if (isset($data->material_id) && $data->material_id != null) {
            $Clause = "where m.material_id = '$data->material_id'";
        }
        if (isset($data->Category_id) && $data->Category_id != null) {
            $Clause = "where m.category_id = '$data->Category_id'";
        }

        $stock = $this->db->query("
            select
                m.*,
                pc.ProductCategory_Name as category_name,
                u.Unit_Name as unit_name,
                ifnull((select sum(quantity) from tbl_material_purchase_details where material_id = m.material_id and status = 'a'), 0.00) as purchased_quantity,
                ifnull((select sum(quantity) from tbl_production_details where material_id = m.material_id and status = 'a'), 0.00) as production_quantity,
                ifnull((select sum(damage_quantity) from tbl_material_damage_details where material_id = m.material_id and status = 'a'), 0.00) as damage_quantity,
                (select purchased_quantity - (production_quantity + damage_quantity)) as stock_quantity

            from
            tbl_materials m
            join tbl_productcategory pc on pc.ProductCategory_SlNo = m.category_id
            join tbl_unit u on u.Unit_SlNo = m.unit_id and m.status = 1
            $Clause
        ")->result();

        echo json_encode($stock);
    }

    public function materialDamage()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = 'Material Damage Entry';
        $data['damageCode'] = $this->mt->generateMaterialDamageCode();
        $data['content'] = $this->load->view('Administrator/materials/material_damage', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function addMaterialDamage()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $damage = array(
                'invoice' => $data->invoice,
                'damage_date' => $data->damage_date,
                'description' => $data->description,
                'status' => 'a',
                'added_by' => $this->session->userdata('userId'),
                'added_datetime' => date('Y-m-d H:i:s')
            );

            $this->db->insert('tbl_material_damage', $damage);
            $damageId = $this->db->insert_id();

            $damageDetails = array(
                'damage_id' => $damageId,
                'material_id' => $data->material_id,
                'damage_quantity' => $data->damage_quantity,
                'damage_amount' => $data->damage_amount,
                'status' => 'a'
            );

            $this->db->insert('tbl_material_damage_details', $damageDetails);

            $res = ['success' => true, 'message' => 'Damage added successfully', 'newCode' => $this->mt->generateMaterialDamageCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateMaterialDamage()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $damage = array(
                'invoice' => $data->invoice,
                'damage_date' => $data->damage_date,
                'description' => $data->description,
                'updated_by' => $this->session->userdata('userId'),
                'updated_datetime' => date('Y-m-d H:i:s')
            );

            $this->db->where('damage_id', $data->damage_id)->update('tbl_material_damage', $damage);

            $damageDetails = array(
                'material_id' => $data->material_id,
                'damage_quantity' => $data->damage_quantity,
                'damage_amount' => $data->damage_amount
            );

            $this->db->where('damage_id', $data->damage_id)->update('tbl_material_damage_details', $damageDetails);

            $res = ['success' => true, 'message' => 'Damage updated successfully', 'newCode' => $this->mt->generateMaterialDamageCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteMaterialDamage()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status' => 'd'])->where('damage_id', $data->damageId)->update('tbl_material_damage');
            $this->db->set(['status' => 'd'])->where('damage_id', $data->damageId)->update('tbl_material_damage_details');

            $res = ['success' => true, 'message' => 'Damage deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getMaterialDamage()
    {
        $damages = $this->db->query("
            select
                mdd.*,
                md.invoice,
                md.damage_date,
                md.description,
                m.code as material_code,
                m.name as material_name
            from tbl_material_damage_details mdd
            join tbl_material_damage md on md.damage_id = mdd.damage_id
            join tbl_materials m on m.material_id = mdd.material_id
            where mdd.status = 'a'
        ")->result();

        echo json_encode($damages);
    }

    public function materialLedger()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = 'Material Ledger';
        $data['content'] = $this->load->view('Administrator/materials/material_ledger', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getMaterialLedger()
    {
        $data = json_decode($this->input->raw_input_stream);
        // echo json_encode($data);

        $result = $this->db->query("
        SELECT 'a' as sequence, mp.purchase_date as date, concat('Purchase - ', m.name,' - ',m.code) as description, mpd.purchase_rate as rate, mpd.quantity as in_qty, 0 as out_qty
        FROM tbl_material_purchase mp
        JOIN tbl_material_purchase_details mpd on mpd.purchase_id = mp.purchase_id
        JOIN tbl_materials m on m.material_id = mpd.material_id
        WHERE mp.status = 'a' and m.material_id = '$data->materialId'
        
        UNION
        
        SELECT 'b' as sequence, tp.date as date, concat('Production - ',m.name,' - ', m.code) as description,
        pd.purchase_rate as rate, 0 as in_qty, pd.quantity as out_qty
        FROM tbl_productions tp
        JOIN tbl_production_details pd on pd.production_id = tp.production_id
        JOIN tbl_materials m on m.material_id = pd.material_id
        WHERE tp.status = 'a' and pd.material_id = '$data->materialId'

        UNION

        SELECT 'c' as sequence, md.damage_date as date, concat('Damage - ',m.name,' - ', m.code)as description,mdd.damage_amount as rate, 0 as in_qty, mdd.damage_quantity as out_qty
        FROM tbl_material_damage md
        JOIN tbl_material_damage_details mdd on mdd.damage_id = md.damage_id
        JOIN tbl_materials m on m.material_id = mdd.material_id
        WHERE md.status = 'a' and mdd.material_id = '$data->materialId'
        
        ORDER by date,sequence")->result();

        $prev_qty = 0;
        $ledger = [];
        $total = 0;
        foreach ($result as $key => $value) {
            if ($value->date < $data->dateFrom) {
                $prev_qty = $prev_qty + $value->in_qty - $value->out_qty;
                $total = $prev_qty;
            } else if ($value->date >= $data->dateFrom && $value->date <= $data->dateTo) {

                $total = $total + $value->in_qty - $value->out_qty;
                $value->balance = $total;
                array_push($ledger, $value);
            }
        }

        echo json_encode(['ledger' => $ledger, 'prev_qty' => $prev_qty]);
    }
}