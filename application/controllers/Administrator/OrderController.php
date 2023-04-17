<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderController extends CI_Controller {
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
        $data['title'] = "Order Entry";
        $data['content'] = $this->load->view('Administrator/order/order', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function deleteOrder(){
        $res = new stdClass();
        $data = json_decode($this->input->raw_input_stream);
        try{
            $order = $this->db->where('id', $data->id)->get("tbl_order")->row();
            $this->db->where('id', $data->id)->delete('tbl_order');
            
            $this->db->query("
                update tbl_currentinventory 
                set sales_quantity = sales_quantity - ? 
                where product_id = ?
                and branch_id = ?
            ", [$order->qty, $order->product_id, $this->session->userdata('BRANCHid')]);

            $res->message = "Product deleted successfully";
            $res->status = 200;
        }catch(Exception $e){
            $res->message = "Product deleted fail";
            $res->status = 402;
        }
        echo json_encode($res);
    }

    public function saveOrder(){
        $res = new stdClass();
        $data = json_decode($this->input->raw_input_stream);
        try{
            $currentOrder = $this->db->where("customer_id", $data[0]->customer_id)->get("tbl_order")->result();
            $this->db->query("delete from tbl_order where customer_id = ?", $data[0]->customer_id);

            $invoiceNumber = rand(11111, 99999);
            
            foreach($currentOrder as $product){
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_quantity = sales_quantity - ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$product->qty, $product->product_id, $this->session->userdata('BRANCHid')]);
            }

            foreach($data as $cart){
                $orderArray = [
                    'entry_date' => $cart->entry_date,
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $cart->customer_id,
                    'employee_id' => $cart->employee_id,
                    'product_id' => $cart->product_id,
                    'purchase_rate' => $cart->purchase_rate,
                    'sale_rate' => $cart->sale_rate,
                    'qty' => $cart->qty,
                    'total_amount' => $cart->total_amount,
                    'branch_id' => $this->branchId,
                    'created_by' => $this->userId,
                    'created_at' => $cart->created_at,
                ];

                $this->db->insert("tbl_order", $orderArray);
                $orderId = $this->db->insert_id();
                $this->db->query("
                    update tbl_currentinventory 
                    set sales_quantity = sales_quantity + ? 
                    where product_id = ?
                    and branch_id = ?
                ", [$cart->qty, $cart->product_id, $this->session->userdata('BRANCHid')]);
            }

            $res->message = "Order save successfully";
            $res->status = 200;
            $res->orderId = $invoiceNumber;

        }catch(Exception $e){
            $res->message = "Order save fail";
            $res->status = 402;
            $res->orderId = 0;
        }
        
        echo json_encode($res);
    }
    public function getOrder(){
        $data = json_decode($this->input->raw_input_stream);
        // $orders = $this->db->where('customer_id', $data->customerId)->get("tbl_order")->result();
        $orders = $this->db->query("
            select
                o.*,
                p.Product_Name as product_name

            from tbl_order as o
            join tbl_product as p on p.Product_SlNo = o.product_id
            where o.customer_id = '$data->customerId'
            and o.branch_id = '$this->branchId'
        ")->result();
        echo json_encode($orders);
    }
    public function convertOrderToSale(){
        $res = new stdClass;
        $data = json_decode($this->input->raw_input_stream);

        $orders = $this->db->where('customer_id', $data->customerId)->get('tbl_order')->result();
        $clauses = " and c.Customer_SlNo = '$data->customerId'";
        $customerPreviousDue = $this->mt->customerDue($clauses);
        try{
            $invoice = $this->mt->generateSalesInvoice();
            $saleDetailsBatch = [];
            $total = 0;
            foreach($orders as $order){
                $total += $order->total_amount;
                $saleDetails = array(
                    'SaleMaster_IDNo' => 0,
                    'Product_IDNo' => $order->product_id,
                    'SaleDetails_TotalQuantity' => $order->qty,
                    'Purchase_Rate' => $order->purchase_rate,
                    'SaleDetails_Rate' => $order->sale_rate,
                    'SaleDetails_Tax' => 0,
                    'SaleDetails_TotalAmount' => $order->total_amount,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => $order->created_at,
                    'SaleDetails_BranchId' => $this->session->userdata('BRANCHid')
                );

                array_push($saleDetailsBatch, $saleDetails);
            }

            // sale master
            $saleMaster = array(
                'SaleMaster_InvoiceNo' => $invoice,
                'SalseCustomer_IDNo' => $data->customerId,
                'employee_id' => $orders[0]->employee_id,
                'SaleMaster_SaleDate' => $data->date,
                'SaleMaster_SaleType' => 'retail',
                'SaleMaster_TotalSaleAmount' => $total,
                'SaleMaster_TotalDiscountAmount' => 0,
                'SaleMaster_TaxAmount' => 0,
                'SaleMaster_Freight' => 0,
                'SaleMaster_SubTotalAmount' => $total,
                'SaleMaster_PaidAmount' => 0,
                'SaleMaster_DueAmount' => $total,
                'SaleMaster_Previous_Due' => $customerPreviousDue[0]->dueAmount,
                'Status' => 'a',
                'is_service' => false,
                "AddBy" => $this->session->userdata("FullName"),
                'AddTime' => date("Y-m-d H:i:s"),
                'SaleMaster_branchid' => $this->session->userdata("BRANCHid")
            );

            $this->db->insert("tbl_salesmaster", $saleMaster);
            $saleId = $this->db->insert_id();

            $saleDetailsBatch = array_map(function($detail) use($saleId){
                $detail['SaleMaster_IDNo'] = $saleId;
                return $detail;
            }, $saleDetailsBatch);

            $this->db->insert_batch('tbl_saledetails', $saleDetailsBatch);
            $this->db->where('customer_id', $data->customerId)->delete("tbl_order");

            $res->message = "Convert successfully";
            $res->status = 200;
    
        }catch(Exception $e){
            $res->message = "Convert fail";
            $res->status = 402;
        }
       
        
        echo json_encode($res);
    }
    public function orderRecord()  {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Order Entry";
        $data['content'] = $this->load->view('Administrator/order/order_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function getOrderWithoutDetails(){
        $data = json_decode($this->input->raw_input_stream);
        $clause = "";
        if(isset($data->customerId) && $data->customerId != "" && $data->customerId != null){
            $clause .=" and o.customer_id = '$data->customerId'";
        }
        if(isset($data->dateFrom) && $data->dateFrom != "" && isset($data->dateTo) && $data->dateTo != null){
            $clause .=" and o.entry_date between '$data->dateFrom' and '$data->dateTo'";
        }
        $orders = $this->db->query("
            select
                p.Product_Name as product_name,
                c.Customer_Name as customer_name,
                c.Customer_Mobile as customer_phone,
                ifnull(sum(o.qty),0) as total_qty,
                ifnull(sum(o.total_amount),0) as total_amount,
                o.customer_id,
                o.entry_date

            from tbl_order as o
            join tbl_product as p on p.Product_SlNo = o.product_id
            join tbl_customer as c on c.Customer_SlNo = o.customer_id
            where o.branch_id = '$this->branchId'
            $clause
            group by o.customer_id,o.entry_date
        ")->result();
        echo json_encode($orders);
    }

    public function orderInvoicePrint($orderNumber)
    {
        $orders = $this->db->query("
            SELECT
                o.*,
                c.Customer_Name as customer_name,
                c.Customer_Code as customer_code,
                c.Customer_Mobile as customer_mobile,
                p.*

            FROM tbl_order as o
            LEFT JOIN tbl_customer as c on c.Customer_SlNo = o.customer_id
            left join tbl_product as p on p.Product_SlNo = o.product_id
            WHERE o.invoice_number = '$orderNumber'
        ")->result();

        $data['orders'] = $orders;
        $data['title'] = "Order invoice";
        $data['content'] = $this->load->view('Administrator/order/order_invoice_print', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
}
