<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChalanController extends CI_Controller {
    private $branchId;
    private $userId;
    public function __construct() {

        parent::__construct();
        $this->branchId = $this->session->userdata('BRANCHid');

        $this->userId = $this->session->userdata('userId');
         if($this->userId  == ''){
            redirect("Login");
        }  
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }

    public function index()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Chalan Entry";
        $data['chalan_id'] = 0;
        $data['productCode'] = $this->mt->generateProductCode();
        $data['content'] = $this->load->view('Administrator/chalan/chalan', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    } 
    public function purchaseChalanEdit($id)  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Chalan Entry";
        $data['chalan_id'] = $id;
        $data['productCode'] = $this->mt->generateProductCode();
        $data['content'] = $this->load->view('Administrator/chalan/chalan', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    } 
    
    public function getPurchaseWithChalan(){
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";

        if(isset($data->purchaseId) && $data->purchaseId != ""){
            $clause .= " and pd.PurchaseMaster_IDNo = '$data->purchaseId'";
        }

        $products = $this->db->query("
            SELECT 
                p.Product_SlNo as product_id,
                p.Product_Name as product_name,
                p.Product_Code as product_code,
                p.Product_SellingPrice as sale_rate,
                pd.PurchaseMaster_IDNo as purchase_id,
                pd.PurchaseDetails_Rate as purchase_rate,
                pd.PurchaseDetails_TotalQuantity as purchase_qty,
                ifnull((SELECT SUM(qty) FROM tbl_chalan_details WHERE product_id = pd.Product_IDNo AND purchase_id = pd.PurchaseMaster_IDNo AND status='a'),0) as total_chalan,
                (SELECT purchase_qty - total_chalan) as due,
                0 as receive 

            FROM tbl_purchasedetails as pd
            JOIN tbl_product as p on p.Product_SlNo = pd.Product_IDNo
            WHERE pd.Status ='a'            
            AND pd.PurchaseDetails_branchID = '$this->branchId'
            $clause
        ")->result();

        echo json_encode($products);
    }

    public function getChalanInvoice(){
        $invoice = $this->mt->chalanInvoice();
        echo json_encode($invoice);
    }

    public function savePurchaseChalan(){
        $res = new stdClass;
        $data = json_decode($this->input->raw_input_stream);
        $products = $data->products;
        $chalan = $data->chalan;
        $invoice = $this->mt->chalanInvoice();

        $this->db->trans_begin();


        // chalan master
        $chalanMaster = [
            'invoice' => $invoice,
            'chalan_date' => $chalan->chalan_date,
            'purchase_id' => $chalan->purchase_id,
            'total' => $chalan->total,
            'branch_id' => $this->branchId,
            'added_by' => $this->userId,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $this->db->insert("tbl_chalan", $chalanMaster);
        $chalanMasterId = $this->db->insert_id();
        
        $chalanDetailArray = [];
        $updateStatus = false;
        foreach($products as $product){
            if(($product->total_chalan+$product->receive) == $product->purchase_qty)
                $updateStatus = true;
            else
                $updateStatus = false;

            if($product->receive > 0){
                $detail = [
                    'purchase_id' => $chalan->purchase_id,
                    'chalan_id' => $chalanMasterId,
                    'product_id' => $product->product_id,
                    'purchase_rate' => $product->purchase_rate,
                    'qty' => $product->receive,
                    'chalan_date' => $chalan->chalan_date,
                    'branch_id' => $this->branchId,
                    'created_by' => $this->userId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                array_push($chalanDetailArray, $detail);

                $inventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$product->product_id, $this->branchId])->num_rows();
                if($inventoryCount == 0){
                    $inventory = array(
                        'product_id' => $product->product_id,
                        'purchase_quantity' => $product->receive,
                        'branch_id' => $this->branchId
                    );

                    $this->db->insert('tbl_currentinventory', $inventory);
                } else {
                    $this->db->query("
                        update tbl_currentinventory 
                        set purchase_quantity = purchase_quantity + ? 
                        where product_id = ? 
                        and branch_id = ?
                    ", [$product->receive, $product->product_id, $this->branchId]);
                }

                $this->db->query("update tbl_product set Product_Purchase_Rate = ?, Product_SellingPrice = ? where Product_SlNo = ?", [$product->purchase_rate, $product->sale_rate, $product->product_id]);
            }
        }

        $this->db->insert_batch("tbl_chalan_details", $chalanDetailArray);
        // echo $updateStatus;exit;
        if($updateStatus == true){
            $this->db->where('PurchaseMaster_SlNo', $chalan->purchase_id)->update('tbl_purchasemaster', ['purchase_type' => 'delivered']);
        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $res->message = "Chalan added fail";
            $res->status = 402;
        }
        else{
            $this->db->trans_commit();
            $res->message = "Chalan added successfully";
            $res->status = 200;
        }
        echo json_encode($res);
    }

    public function purchaseChalanRecord(){
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Chalan Record";
        $data['content'] = $this->load->view('Administrator/chalan/chalan_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getPurchaseChalans(){
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";
        if(isset($data->chalan_id) && $data->chalan_id != null && $data->chalan_id != ""){
            $clause .= " and ch.id = '$data->chalan_id'" ;
        }
        $chalans = $this->db->query("
            SELECT
                ch.id as chalan_id,
                ch.chalan_date,
                ch.purchase_id,
                ch.total as chalan_total_amount,
                ch.invoice,
                s.Supplier_Name as supplier_name,
                s.Supplier_SlNo as supplier_id,
                CONCAT(ch.invoice, ' - ', s.Supplier_Name, ' - ', s.Supplier_Mobile) as display_text
            
            FROM tbl_chalan as ch
            JOIN tbl_purchasemaster as pm on pm.PurchaseMaster_SlNo = ch.purchase_id
            JOIN tbl_supplier as s ON s.Supplier_SlNo = pm.Supplier_SlNo
            WHERE ch.status ='a'
            AND ch.branch_id = '$this->branchId'
            $clause
        ")->result();
        echo json_encode($chalans);
    }

    public function getPurchaseChalanWithoutDetails(){
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";
        if(isset($data->chalan_id) && $data->chalan_id !=""){
            $clause .=" and c.id = '$data->chalan_id'";
        }
        if(isset($data->dateFrom) && $data->dateFrom != "" && isset($data->dateTo) && $data->dateTo !=""){
            $clause .=" AND c.chalan_date BETWEEN '$data->dateFrom' and '$data->dateTo'";
        }

        $chalans = $this->db->query("
            SELECT
                c.*,
                s.Supplier_Name as supplier_name,
                s.Supplier_Mobile as supplier_phone,
                s.Supplier_SlNo as supplier_id

            FROM tbl_chalan as c
            JOIN tbl_purchasemaster as pm on pm.PurchaseMaster_SlNo = c.purchase_id
            JOIN tbl_supplier as s on s.Supplier_SlNo = pm.Supplier_SlNo
            WHERE c.status ='a'
            AND c.branch_id = '$this->branchId'
            $clause
        ")->result();
        echo json_encode($chalans);
    }
    
    public function getPurchaseChalanWithDetails(){
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";
        if(isset($data->chalan_id) && $data->chalan_id !=""){
            $clause .=" and c.id = '$data->chalan_id'";
        }
        if(isset($data->dateFrom) && $data->dateFrom != "" && isset($data->dateTo) && $data->dateTo !=""){
            $clause .=" AND c.chalan_date BETWEEN '$data->dateFrom' and '$data->dateTo'";
        }

        $chalans = $this->db->query("
            SELECT
                c.*,
                s.Supplier_Name as supplier_name,
                s.Supplier_Mobile as supplier_phone,
                s.Supplier_SlNo as supplier_id,
                pm.PurchaseMaster_OrderDate as purchase_date

            FROM tbl_chalan as c
            JOIN tbl_purchasemaster as pm on pm.PurchaseMaster_SlNo = c.purchase_id
            JOIN tbl_supplier as s on s.Supplier_SlNo = pm.Supplier_SlNo
            WHERE c.status ='a'
            AND c.branch_id = '$this->branchId'
            $clause
        ")->result();
        

        $chalans  = array_map(function($chalan){
            $chalan->details = $this->db->query("
            select 
                cd.*,
                p.Product_Name as product_name,
                p.Product_Code as product_code,
                (
                    SELECT PurchaseDetails_TotalQuantity FROM tbl_purchasedetails WHERE PurchaseMaster_IDNo = cd.purchase_id AND Product_IDNo = cd.product_id
                ) as purchase_qty,
                ifnull((SELECT SUM(qty) FROM tbl_chalan_details WHERE product_id = cd.product_id AND purchase_id = cd.purchase_id AND status='a'),0) as total_chalan,
                cd.qty as receive,
                cd.qty as old_qty

            from tbl_chalan_details as cd 
            JOIN tbl_product AS p ON p.Product_SlNo = cd.product_id
            where cd.chalan_id = '$chalan->id' and cd.status='a'
            GROUP BY cd.chalan_id,cd.product_id
            ")->result();
            // echo $this->db->last_query();exit;
            return $chalan;
        }, $chalans);

        echo json_encode($chalans);
    }
    
    public function deletePurchaseChalan(){
        $res = new stdClass;
        $data = json_decode($this->input->raw_input_stream);
        try{
            $this->db->where('id', $data->id)->update('tbl_chalan', ['status'=>'d']);
            $this->db->where('chalan_id', $data->id)->update('tbl_chalan_details', ['status'=>'d']);
            $res->message = "Chalan was deleted successfully";
            $res->status = 200;
        }catch(Exception $e){
            $res->message = "Chalan was deleted fail";
            $res->status = 402;
        }

        echo json_encode($res);
    }

    public function updatePurchaseChalan(){
        $res = new stdClass;
        $data = json_decode($this->input->raw_input_stream);
        $products = $data->products;
        $chalan = $data->chalan;
        try{
            // chalan master
            $chalanMaster = [
                'chalan_date' => $chalan->chalan_date,
                'purchase_id' => $chalan->purchase_id,
                'total' => $chalan->total,
                'updated_by' => $this->userId,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id', $chalan->id)->update("tbl_chalan", $chalanMaster);
            $updateStatus = false;
            foreach($products as $product){
                if(($product->total_chalan+$product->receive) == $product->purchase_qty)
                    $updateStatus = true;
                else
                    $updateStatus = false;
                    
                if($product->receive > 0){
                    $detail = [
                        'purchase_id' => $chalan->purchase_id,
                        'chalan_id' => $chalan->id,
                        'product_id' => $product->product_id,
                        'purchase_rate' => $product->purchase_rate,
                        'qty' => $product->receive,
                        'chalan_date' => $chalan->chalan_date,
                        'branch_id' => $this->branchId,
                        'created_by' => $this->userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if($product->id > 0){
                        unset($detail['created_by']);
                        unset($detail['created_at']);
                        $detail['updated_by'] = $this->userId;
                        $detail['updated_at'] = date('Y-m-d H:i:s');

                        $this->db->where('id', $product->id)  ->update('tbl_chalan_details', $detail);

                        $this->db->query("
                            update tbl_currentinventory 
                            set purchase_quantity = purchase_quantity - ? 
                            where product_id = ?
                            and branch_id = ?
                        ", [$product->old_qty, $product->product_id, $this->session->userdata('BRANCHid')]);

                    }else{
                        $this->db->insert('tbl_chalan_details', $detail);
                    }

                    $inventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$product->product_id, $this->branchId])->num_rows();
                    if($inventoryCount == 0){
                        $inventory = array(
                            'product_id' => $product->product_id,
                            'purchase_quantity' => $product->receive,
                            'branch_id' => $this->branchId
                        );

                        $this->db->insert('tbl_currentinventory', $inventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory 
                            set purchase_quantity = purchase_quantity + ? 
                            where product_id = ? 
                            and branch_id = ?
                        ", [$product->receive, $product->product_id, $this->branchId]);
                    }
                }
            }
            if($updateStatus == true){
                $this->db->where('PurchaseMaster_SlNo', $chalan->purchase_id)->update('tbl_purchasemaster', ['purchase_type' => 'delivered']);
            }
            $res->message = "Chalan updated successfully";
            $res->status = 200;
        }catch(Exception $e){
            $res->message = "Chalan updated faill";
            $res->status = 402;
        }
        echo json_encode($res);
    }
}
