<?php
class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
    }
    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Production";
        $data['production_id'] = 0;
        $data['productionSl'] = $this->mt->generateProductionCode();
        $data['content'] = $this->load->view('Administrator/production/production', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function edit($production_id = 0)
    {
        $data['title'] = "Production Edit";
        $data['production_id'] = $production_id;
        $production = $this->db->query("
            select * from tbl_productions
            where production_id = '$production_id'
        ")->result();
        $data['productionSl'] = $production[0]->production_sl;
        $data['content'] = $this->load->view('Administrator/production/production', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function addProduction()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $countProductionSl = $this->db->query("select * from tbl_productions where production_sl = ?", $data->production->production_sl)->num_rows();
            if ($countProductionSl > 0) {
                $data->production->production_sl = $this->mt->generateProductionCode();
            }
            $production = array(
                'production_sl' => $data->production->production_sl,
                'date'          => $data->production->date,
                'incharge_id'   => $data->production->incharge_id,
                'shift'         => $data->production->shift,
                'note'          => $data->production->note,
                'labour_cost'   => $data->production->labour_cost,
                'material_cost' => $data->production->material_cost,
                'other_cost'    => $data->production->other_cost,
                'total_cost'    => $data->production->total_cost,
                'batch_no'      => $data->production->batch_no,
                'status'        => 'a',
                'branch_id'     => $this->session->userdata('BRANCHid'),
            );

            $this->db->insert('tbl_productions', $production);
            $productionId = $this->db->insert_id();


            foreach ($data->materials as $material) {
                $material = array(
                    'production_id' => $productionId,
                    'material_id'   => $material->material_id,
                    'quantity'      => $material->quantity,
                    'purchase_rate' => $material->purchase_rate,
                    'total'         => $material->total,
                    'status'        => 'a',
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_production_details', $material);
            }

            foreach ($data->products as $product) {
                $productionProduct = array(
                    'production_id' => $productionId,
                    'product_id'    => $product->product_id,
                    'quantity'      => $product->quantity,
                    'price'         => $product->price,
                    'total'         => $product->total,
                    'status'        => 'a',
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_production_products', $productionProduct);

                $productInventoryCount = $this->db->query("select * from tbl_currentinventory ci where ci.product_id = ? and ci.branch_id = ?", [$product->product_id, $this->session->userdata('BRANCHid')])->num_rows();

                $previousStock = $this->mt->productStock($product->product_id);


                if ($productInventoryCount == 0) {
                    $inventory = array(
                        'product_id'          => $product->product_id,
                        'production_quantity' => $product->quantity,
                        'branch_id'           => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_currentinventory', $inventory);
                } else {
                    $this->db->query("update tbl_currentinventory set production_quantity = production_quantity + ? where product_id = ? and branch_id = ?", [$product->quantity, $product->product_id, $this->session->userdata('BRANCHid')]);
                }


                $this->db->query("UPDATE tbl_product SET Product_Purchase_Rate = (((Product_Purchase_Rate * ?) + ?) / ?)
                where Product_SlNo = ?
            ", [$previousStock, $product->total, ($previousStock + $product->quantity), $product->product_id]);
            }

            $res = ['success' => true, 'message' => 'Production entry success', 'productionId' => $productionId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateProduction()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $productionId = $data->production->production_id;
            $production = array(
                'production_sl' => $data->production->production_sl,
                'date'          => $data->production->date,
                'incharge_id'   => $data->production->incharge_id,
                'shift'         => $data->production->shift,
                'note'          => $data->production->note,
                'labour_cost'   => $data->production->labour_cost,
                'material_cost' => $data->production->material_cost,
                'other_cost'    => $data->production->other_cost,
                'total_cost'    => $data->production->total_cost,
                'batch_no'      => $data->production->batch_no,
            );

            $this->db->where('production_id', $productionId)->update('tbl_productions', $production);

            $this->db->delete('tbl_production_details', array('production_id' => $productionId));

            foreach ($data->materials as $material) {
                $material = array(
                    'production_id' => $productionId,
                    'material_id'   => $material->material_id,
                    'quantity'      => $material->quantity,
                    'purchase_rate' => $material->purchase_rate,
                    'total'         => $material->total,
                    'status'        => 'a',
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_production_details', $material);
            }

            $oldProducts = $this->db->query("select * from tbl_production_products where production_id = ?", $productionId)->result();

            $this->db->delete('tbl_production_products', array('production_id' => $productionId));

            foreach ($oldProducts as $oldProduct) {

                $previousStock = $this->mt->productStock($oldProduct->product_id);

                $this->db->query("update tbl_currentinventory set production_quantity = production_quantity - ? where product_id = ? and branch_id = ?", [$oldProduct->quantity, $oldProduct->product_id, $this->session->userdata('BRANCHid')]);

                $this->db->query("
                    update tbl_product set 
                    Product_Purchase_Rate = (((Product_Purchase_Rate * ?) - ?) / ?)
                    where Product_SlNo = ?
                ", [
                    $previousStock,
                    $oldProduct->total,
                    ($previousStock - $oldProduct->quantity),
                    $oldProduct->product_id
                ]);
            }

            foreach ($data->products as $product) {
                $productionProduct = array(
                    'production_id' => $productionId,
                    'product_id'    => $product->product_id,
                    'quantity'      => $product->quantity,
                    'price'         => $product->price,
                    'total'         => $product->total,
                    'status'        => 'a',
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );

                $this->db->insert('tbl_production_products', $productionProduct);

                $productInventoryCount = $this->db->query("select * from tbl_currentinventory ci where ci.product_id = ? and ci.branch_id = ?", [$product->product_id, $this->session->userdata('BRANCHid')])->num_rows();

                $previousStock = $this->mt->productStock($product->product_id);

                if ($productInventoryCount == 0) {
                    $inventory = array(
                        'product_id'          => $product->product_id,
                        'production_quantity' => $product->quantity,
                        'branch_id'           => $this->session->userdata('BRANCHid')
                    );

                    $this->db->insert('tbl_currentinventory', $inventory);
                } else {
                    $this->db->query("update tbl_currentinventory set production_quantity = production_quantity + ? where product_id = ? and branch_id = ?", [$product->quantity, $product->product_id, $this->session->userdata('BRANCHid')]);
                }


                $this->db->query("UPDATE tbl_product SET Product_Purchase_Rate = (((Product_Purchase_Rate * ?) + ?) / ?)
                where Product_SlNo = ?
            ", [$previousStock, $product->total, ($previousStock + $product->quantity), $product->product_id]);
            }

            $res = ['success' => true, 'message' => 'Production update success', 'productionId' => $productionId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function productions()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Production Record";
        $data['content'] = $this->load->view('Administrator/production/productions', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getProductions()
    {
        $options = json_decode($this->input->raw_input_stream);

        $idClause = '';
        $dateClause = '';


        if (isset($options->production_id) && $options->production_id != 0) {
            $idClause = " and pr.production_id = '$options->production_id'";
        }

        if (isset($options->dateFrom) && isset($options->dateTo) && $options->dateFrom != null && $options->dateTo != null) {
            $dateClause = " and pr.date between '$options->dateFrom' and '$options->dateTo'";
        }
        $productions = $this->db->query("
            select 
            pr.*,
            e.Employee_Name as incharge_name
            from tbl_productions pr
            join tbl_employee e on e.Employee_SlNo = pr.incharge_id
            where pr.status = 'a' $idClause $dateClause
        ")->result();
        echo json_encode($productions);
    }

    public function getProductionRecord()
    {
        $options = json_decode($this->input->raw_input_stream);

        $dateClause = '';

        if (isset($options->dateFrom) && isset($options->dateTo) && $options->dateFrom != null && $options->dateTo != null) {
            $dateClause = " and pr.date between '$options->dateFrom' and '$options->dateTo'";
        }
        $productions = $this->db->query("
            select 
            pr.*,
            e.Employee_Name as incharge_name
            from tbl_productions pr
            join tbl_employee e on e.Employee_SlNo = pr.incharge_id
            where pr.status = 'a' $dateClause
        ")->result();

        foreach ($productions as $production) {
            $production->products = $this->db->query("SELECT
                pp.*,
                p.Product_Code as product_code,
                p.Product_Name as name,
                p.ProductCategory_ID as category_id,
                pc.ProductCategory_Name as category_name,
                u.Unit_Name as unit_name
                from tbl_production_products pp
                join tbl_product p on p.Product_SlNo = pp.product_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                join tbl_unit u on u.Unit_SlNo = p.unit_id
                where pp.status = 'a'
                and pp.production_id = ?
            ", $production->production_id)->result();

            $production->materials = $this->db->query("SELECT
                pd.*,
                m.name,
                m.category_id,
                u.Unit_Name as unit_name,
                pc.ProductCategory_Name as category_name
                from tbl_production_details pd
                join tbl_materials m on m.material_id = pd.material_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = m.category_id
                join tbl_unit u on u.Unit_SlNo = m.unit_id
                where pd.status = 'a' 
                and pd.production_id = ?
            ", $production->production_id)->result();
        }
        echo json_encode($productions);
    }

    public function getProductionDetails()
    {
        $options = json_decode($this->input->raw_input_stream);
        $productionDetails = $this->db->query("
            select
            pd.*,
            m.name,
            m.category_id,
            u.Unit_Name as unit_name,
            pc.ProductCategory_Name as category_name
            from tbl_production_details pd
            join tbl_materials m on m.material_id = pd.material_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = m.category_id
            join tbl_unit u on u.Unit_SlNo = m.unit_id
            where pd.status = 'a' 
            and pd.production_id = '$options->production_id'
        ")->result();

        echo json_encode($productionDetails);
    }

    public function getProductionProducts()
    {
        $options = json_decode($this->input->raw_input_stream);
        $productionProducts = $this->db->query("
            select
                pp.*,
                p.Product_Code as product_code,
                p.Product_Name as name,
                p.ProductCategory_ID as category_id,
                pc.ProductCategory_Name as category_name,
                u.Unit_Name as unit_name
            from tbl_production_products pp
            join tbl_product p on p.Product_SlNo = pp.product_id
            join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
            join tbl_unit u on u.Unit_SlNo = p.unit_id
            where pp.status = 'a'
            and pp.production_id = '$options->production_id'
        ")->result();

        echo json_encode($productionProducts);
    }

    public function deleteProduction()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_productions set status = 'd' where production_id = ?", $data->productionId);
            $this->db->query("update tbl_production_details set status = 'd' where production_id = ?", $data->productionId);


            $allProductions = $this->db->query("select * from tbl_production_products where production_id = ?", $data->productionId)->result();
            $this->db->query("update tbl_production_products set status = 'd' where production_id = ?", $data->productionId);

            foreach ($allProductions as $key => $value) {

                $current_qty = $this->db->query("Select production_quantity from tbl_currentinventory where product_id = ? and branch_id = ?", [$value->product_id, $this->sbrunch])->row();

                $new_qty = $current_qty->production_quantity - $value->quantity;
                $previousStock = $this->mt->productStock($value->product_id);

                $this->db->query("update tbl_currentinventory set production_quantity = $new_qty where product_id = ? and branch_id = ?", [$value->product_id, $this->sbrunch]);


                $this->db->query("
                    update tbl_product set 
                    Product_Purchase_Rate = (((Product_Purchase_Rate * ?) - ?) / ?)
                    where Product_SlNo = ?
                ", [
                    $previousStock,
                    $value->total,
                    ($previousStock - $value->quantity),
                    $value->product_id
                ]);
            }

            $res = ['success' => true, 'message' => "Production delete Successfully"];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function productionInvoice($productionId)
    {
        $data['title'] = "Production Invoice";
        $data['productionId'] = $productionId;
        $data['content'] = $this->load->view("Administrator/production/production_invoice", $data, true);
        $this->load->view("Administrator/index", $data);
    }


    //Recipe
    public function recipeEntry()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Recipe Entry";
        $data['recipe_id'] = 0;
        $data['content'] = $this->load->view('Administrator/production/recipe_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getRecipes()
    {
        $data = json_decode($this->input->raw_input_stream);

        $recipes = $this->db->query("SELECT * FROM `tbl_recipe` WHERE `status` = 'a' and `branch_id` = ?", $this->session->userdata('BRANCHid'))->result();

        foreach ($recipes as $key => $value) {

            $value->materials = $this->db->query("SELECT
                rm.*,
                m.name,
                pc.ProductCategory_Name
                FROM tbl_recipe_materials rm
                left join tbl_materials m on m.material_id = rm.material_id
                left join tbl_productcategory pc on pc.ProductCategory_SlNo = m.category_id
                WHERE rm.status = 'a'
                and rm.recipe_id = ?
                and rm.branch_id = ?
             ", [$value->recipe_id, $this->session->userdata('BRANCHid')])->result();

            $value->product = $this->db->query("SELECT
                rp.*,
                p.Product_Name
                FROM tbl_recipe_product rp
                left join tbl_product p on p.Product_SlNo = rp.product_id
                WHERE rp.status = 'a'
                and rp.recipe_id = ?
                and rp.branch_id = ?
            ", [$value->recipe_id, $this->session->userdata('BRANCHid')])->result();
        }

        echo json_encode($recipes);
    }
    public function addRecipe()
    {
        $data = json_decode($this->input->raw_input_stream);

        try {

            $recipeData = (array)$data->recipe;
            unset($recipeData['recipe_id']);
            $recipeData['date']      = date('Y-m-d');
            $recipeData['status']    = 'a';
            $recipeData['AddBy']     = $this->session->userdata('userId');
            $recipeData['AddTime']   = date('Y-m-d H:i:s');
            $recipeData['branch_id'] = $this->session->userdata('BRANCHid');

            $this->db->insert('tbl_recipe', $recipeData);
            $recipeId = $this->db->insert_id();


            foreach ($data->materials as $material) {
                $material = array(
                    'recipe_id'     => $recipeId,
                    'material_id'   => $material->material_id,
                    'purchase_rate' => $material->purchase_rate,
                    'quantity'      => $material->quantity,
                    'total'         => $material->total,
                    'date'          => date('Y-m-d'),
                    'status'        => 'a',
                    'AddBy'         => $this->session->userdata('userId'),
                    'AddTime'       => date('Y-m-d H:i:s'),
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_recipe_materials', $material);
            }

            foreach ($data->products as $product) {
                $productionProduct = array(
                    'recipe_id'     => $recipeId,
                    'product_id'    => $product->product_id,
                    'price'         => $product->price,
                    'quantity'      => $product->quantity,
                    'total'         => $product->total,
                    'date'          => date('Y-m-d'),
                    'status'        => 'a',
                    'AddBy'         => $this->session->userdata('userId'),
                    'AddTime'       => date('Y-m-d H:i:s'),
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_recipe_product', $productionProduct);
            }

            $res = ['success' => true, 'message' => 'Recipe added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateRecipe()
    {
        $data = json_decode($this->input->raw_input_stream);
        $recipeId = $data->recipe->recipe_id;

        try {

            $recipeData = (array)$data->recipe;
            unset($recipeData['recipe_id']);
            $recipeData['UpdateBy']     = $this->session->userdata('userId');
            $recipeData['UpdateTime']   = date('Y-m-d H:i:s');
            $recipeData['branch_id'] = $this->session->userdata('BRANCHid');

            $this->db->where('recipe_id', $recipeId)->update('tbl_recipe', $recipeData);
            // $recipeId = $this->db->insert_id();


            $this->db->where('recipe_id', $recipeId)->delete('tbl_recipe_materials');
            foreach ($data->materials as $material) {
                $material = array(
                    'recipe_id'     => $recipeId,
                    'material_id'   => $material->material_id,
                    'purchase_rate' => $material->purchase_rate,
                    'quantity'      => $material->quantity,
                    'total'         => $material->total,
                    'date'          => date('Y-m-d'),
                    'status'        => 'a',
                    'AddBy'         => $this->session->userdata('userId'),
                    'AddTime'       => date('Y-m-d H:i:s'),
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_recipe_materials', $material);
            }

            $this->db->where('recipe_id', $recipeId)->delete('tbl_recipe_product');
            foreach ($data->products as $product) {
                $productionProduct = array(
                    'recipe_id'     => $recipeId,
                    'product_id'    => $product->product_id,
                    'price'         => $product->price,
                    'quantity'      => $product->quantity,
                    'total'         => $product->total,
                    'date'          => date('Y-m-d'),
                    'status'        => 'a',
                    'AddBy'         => $this->session->userdata('userId'),
                    'AddTime'       => date('Y-m-d H:i:s'),
                    'branch_id'     => $this->session->userdata('BRANCHid'),
                );
                $this->db->insert('tbl_recipe_product', $productionProduct);
            }

            $res = ['success' => true, 'message' => 'Recipe Updated successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteRecipe()
    {
        $data = json_decode($this->input->raw_input_stream);

        try {
            $this->db->where('recipe_id', $data->recipeId)->set('status', 'd')->update('tbl_recipe');
            $this->db->where('recipe_id', $data->recipeId)->set('status', 'd')->update('tbl_recipe_materials');
            $this->db->where('recipe_id', $data->recipeId)->set('status', 'd')->update('tbl_recipe_product');

            $res = ['success' => true, 'message' => 'Recipe Delete successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
}
