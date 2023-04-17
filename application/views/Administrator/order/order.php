<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#branchDropdown .vs__actions button{
		display:none;
	}
	#branchDropdown .vs__actions .open-indicator{
		height:15px;
		margin-top:7px;
	}
    .customer-area{
        margin-top: 5px;
        border: 1px solid #ddd;
        padding: 7px;
        box-shadow: 0 6px 6px -6px #777;
        position: relative;
    }
    .customer-area p{
        position: absolute;
        margin-top: -18px;
        background: #fff;
        font-weight: bold;
    }
    .product-area{
        margin-top: 25px;
        border: 1px solid #ddd;
        padding: 7px;
        box-shadow: 0 6px 6px -6px #777;
        position: relative;
    }
    .product-area p{
        position: absolute;
        margin-top: -18px;
        background: #fff;
        font-weight: bold;
    }
    .cart-area{
        margin-top: 25px;
        border: 1px solid #ddd;
        padding: 7px;
        box-shadow: 0 6px 6px -6px #777;
        position: relative;
    }
    .cart-area p{
        position: absolute;
        margin-top: -18px;
        background: #fff;
        font-weight: bold;
    }
</style>
<?php 
    $userAccessQuery = $this->db->query("select * from tbl_user_access where user_id = ?", $this->session->userdata('userId'));
    $access = [];
    if ($userAccessQuery->num_rows() != 0) {
        $userAccess = $userAccessQuery->row();
        $access = json_decode($userAccess->access);
    }
?>
<div id="order">
    <div class="row customer-area">
        <p>Customer Info</p>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Customer </label>
                <div class="col-sm-7">
                    <v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name" @input="getOrders()"></v-select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Name </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" v-model="selectedCustomer.Customer_Name" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Address </label>
                <div class="col-sm-7">
                    <textarea cols="30" rows="2" class="form-control" v-model="selectedCustomer.Customer_Address" readonly></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Phone </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" v-model="selectedCustomer.Customer_Mobile" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Entry Date </label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" v-model="entry_date">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Employee </label>
                <div class="col-sm-7">
                    <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name" placeholder="Select Employee"></v-select>
                </div>
            </div>
        </div>
    </div>
    <div class="row product-area">
        <p>Product Info</p>
        <div class="col-md-12" style="margin-top: 11px;height: 88px;">
            <form method="post" @submit.prevent="addToCart">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"> Name </label>
                        <div class="col-sm-10">
                            <v-select v-bind:options="products" v-model="selectedProduct" label="display_text" @input="checkStock()"></v-select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"> Rate </label>
                        <div class="col-sm-10">
                            <?php if($this->session->userdata('accountType') == 'm' || array_search("userChangeRate", $access) > -1){?>
                                <input type="text" class="form-control" v-model="selectedProduct.Product_SellingPrice" @input="calculation">
                            <?php }else{?>
                                <input type="text" class="form-control" v-model="selectedProduct.Product_SellingPrice" readonly>
                            <?php }?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Qty </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="selectedProduct.qty" @input="calculation">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right" style="padding: 0;"> Amount </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" v-model="selectedProduct.total_amount" readonly>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary pull-right">Add To Cart</button>
            </form>
        </div>
        <div class="col-md-2" style="border: 1px dashed red;text-align: center;margin-left: 38px;margin-top: -36px;">
            <span style="font-weight: bold;">Stock :</span> {{stock_qty}}
        </div>
    </div>
    <div class="row cart-area">
        <p>Cart Info</p>
        <div class="col-md-12" style="margin-top: 11px;">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Product name</th>
                        <!-- <th>Purchase rate</th> -->
                        <th>Sale rate</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="cart.length > 0">
                    <tr v-for="(product, sl) in cart">
                        <td>{{ sl+1 }}</td>
                        <td>{{ product.entry_date }}</td>
                        <td>{{ product.product_name }}</td>
                        <?php if($this->session->userdata('accountType') == 'm') { ?>
                            <!-- <td>{{ product.purchase_rate }}</td> -->
                        <?php } ?>
                        <td>{{ product.sale_rate }}</td>
                        <td>{{ product.qty }}</td>
                        <td>
                            <button @click.prevent="removeProduct(product, sl)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-sm btn-success pull-right" @click.prevent="saveOrder()">save</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#order',
		data(){
			return{
                customers: [],
                selectedCustomer: {
                    Customer_SlNo: '',
                    Customer_Code: '',
                    Customer_Name: '',
                    Customer_Mobile: '',
                    display_name: ''
                },
                products: [],
                selectedProduct: {
                    Product_SlNo: '',
                    Product_Name: '',
                    display_text: '',
                    Product_SellingPrice: '',
                    qty:0,
                    total_amount: 0
                },
                entry_date: moment().format("YYYY-MM-DD"),
                stock_qty: 0,
                cart: [],
                employees: [],
                selectedEmployee: null,
            }
		},
		async created(){
            this.getCustomers();
            this.getProducts();
            this.getEmployees();
		},
        methods: {
            getEmployees(){
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
            checkStock(){
                axios.post('/get_product_stock', {productId: this.selectedProduct.Product_SlNo}).then(res => {
					this.stock_qty = res.data;
				})
            },
            getCustomers(){
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
            getProducts(){
                axios.get('/get_products').then(res=>{
                    this.products = res.data;
                })
            },
            calculation(){
                this.selectedProduct.total_amount = (parseInt(this.selectedProduct.qty) * parseFloat(this.selectedProduct.Product_SellingPrice));
            },
            addToCart(){
                if(parseInt(this.stock_qty) < parseInt(this.selectedProduct.qty)){
                    alert("Stock not available, current stock is "+ this.stock_qty);
                    return;
                }
                if(this.selectedCustomer.Customer_SlNo == '' || this.selectedCustomer.Customer_SlNo == 0){
                    alert("Please select customer first.before add to cart");
                    return
                }
                if(this.selectedEmployee == null || this.selectedEmployee == "" || this.selectedEmployee.Employee_SlNo == 0){
                    alert("Please select employee first.before add to cart");
                    return
                }
                if(this.selectedProduct.Product_SlNo == ''){
                    alert("Select Product");
                    return
                }
                if(this.selectedProduct.qty == '' || this.selectedProduct.qty == 0){
                    alert("Enter qty");
                    return
                }

                let product = {
                    id: 0,
                    employee_id: this.selectedEmployee.Employee_SlNo,
                    product_id: this.selectedProduct.Product_SlNo,
                    product_name: this.selectedProduct.Product_Name,
                    purchase_rate: this.selectedProduct.Product_Purchase_Rate,
                    sale_rate: this.selectedProduct.Product_SellingPrice,
                    qty: this.selectedProduct.qty,
                    total_amount: this.selectedProduct.total_amount,
                    customer_id: this.selectedCustomer.Customer_SlNo,
                    entry_date: this.entry_date,
                    created_at: moment().format("YYYY-MM-DD h:m:s")
                }
                this.cart.push(product);
                this.clearProduct();
            },
            removeProduct(product, sl){
                if(product.id == 0){
                    this.cart.splice(sl, 1);
                }else{
                    axios.post("/delete_order", {id: product.id}).then(res =>{
                        let r =res.data;
                        alert(r.message);
                        if(r.status == 200){
                            this.cart.splice(sl, 1);
                        }
                    })
                }
            },
            saveOrder(){
                if(this.selectedCustomer.Customer_SlNo == '' || this.selectedCustomer.Customer_SlNo == 0){
                    alert("Select Customer");
                    return;
                }
                if(this.cart.length == 0){
                    alert("Cart is empty");
                    return;
                }
                axios.post("/save_order", this.cart).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if(r.status==200){
                        if(confirm("You want to see invoice")){
                            window.open('/order_invoice_print/'+r.orderId); 
                        }
                        
                        location.reload();
                    }
                })
            },
            async getOrders(){
                if(this.selectedCustomer.Customer_SlNo == 0 || this.selectedCustomer.Customer_SlNo == "") return;
                await axios.post("/get_order", {customerId: this.selectedCustomer.Customer_SlNo }).then(res =>{
                    this.cart = res.data;
                });

                this.selectedEmployee = this.employees.find(emp => emp.Employee_SlNo == this.cart[0].employee_id);
            },
            clearProduct(){
                this.selectedProduct= {
                    Product_SlNo: '',
                    Product_Name: '',
                    display_text: '',
                    Product_SellingPrice: '',
                    qty:0,
                    total_amount: 0
                }
            }
        }
	})
</script>