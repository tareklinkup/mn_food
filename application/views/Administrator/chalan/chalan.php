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
</style>

<div class="row" id="chalan">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Invoice </label>
                    <div class="col-sm-7">
                        <v-select v-bind:options="purchases" v-model="selectedPurchase" label="PurchaseMaster_InvoiceNo" @input="getPurchaseWithChalan"></v-select>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 3px;">
                    <label class="col-sm-3 control-label no-padding-right"> Chalan No </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" v-model="chalan.invoice" readonly style="height:26px;"/>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 3px;">
                    <label class="col-sm-3 control-label no-padding-right"> Supplier Name </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" v-model="selectedPurchase.Supplier_Name" readonly style="height:26px;"/>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 3px;">
                    <label class="col-sm-3 control-label no-padding-right"> Phone </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" v-model="selectedPurchase.Supplier_Mobile" readonly style="height:26px;"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="margin-top: 3px;">
                    <label class="col-sm-3 control-label no-padding-right"> Invoice date </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" v-model="selectedPurchase.PurchaseMaster_OrderDate" readonly style="height:26px;"/>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 3px;">
                    <label class="col-sm-3 control-label no-padding-right"> Date </label>
                    <div class="col-sm-7">
                        <input type="date" class="form-control" v-model="chalan.chalan_date" style="height:26px;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered" style="display: none;" :style="{display: products.length > 0 ? '' : 'none' }">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Order Qty</th>
                    <th>Already Received</th>
                    <th v-if="chalan_id == 0">Due</th>
                    <th style="width: 100px;">Receive</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, sl) in products">
                    <td>{{ sl+1 }}</td>
                    <td>{{ product.product_code }}</td>
                    <td>{{ product.product_name }}</td>
                    <td>{{ product.purchase_qty }}</td>
                    <td>{{ product.total_chalan }}</td>
                    <td v-if="chalan_id == 0">{{ product.due }}</td>
                    <td>
                        <input type="text" class="form-control" v-model="product.receive" @input="onChangeQty(product)">
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;font-weight: bold;margin-top: 20px" v-if="products.length == 0">
            No product found
        </p>
        <button @click.prevent="saveChalan()" class="btn btn-sm btn-primary pull-right" v-if="products.length > 0">Save</button>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#chalan',
		data(){
			return{
                purchases: [],
                products: [],
                selectedPurchase: {
                    Supplier_Name: '',
                    PurchaseMaster_SlNo: '',
                    PurchaseMaster_InvoiceNo: ''
                },
                chalan: {
                    id: 0,
                    invoice: '',
                    supplier_id: '',
                    chalan_date: moment().format("YYYY-MM-DD"),
                    total: 0,
                },
                chalan_id: "<?php echo $chalan_id;?>"
            }
		},
		async created(){
            await this.getPurchases();
            if(this.chalan_id > 0){
                await this.getChalan();
            }else{
                this.getChalanInvoice();
            }
		},
		methods:{
            async getChalan(){
                if(this.chalan_id > 0){
                    await axios.post("/get_purchase_chalan_with_details", {chalan_id: this.chalan_id}).then(res => {
                        let r = res.data[0];
                        console.log(r)
                        this.products = res.data[0].details;
                        
                        this.chalan.id = r.id;
                        this.chalan.purchase_id = r.purchase_id;
                        this.chalan.supplier_id = r.supplier_id;
                        this.selectedPurchase.Supplier_Name = r.supplier_name;
                        this.selectedPurchase.Supplier_Mobile = r.supplier_phone;
                        this.selectedPurchase.PurchaseMaster_OrderDate = r.purchase_date;
                        this.chalan.invoice = r.invoice;
                        this.chalan.total = r.total;

                        this.products.map(product => {
                           product.due = parseInt(product.purchase_qty) - parseInt(product.total_chalan);
                           return product;
                       });
                    });
                }
            },
            async getPurchases(){
                await axios.post("/get_purchases", {purchaseType: 'pending'}).then(res=> {
                    this.purchases = res.data.purchases;
                })
            },
            getChalanInvoice(){
                axios.get("/get_chalan_invoice").then(res => {
                    this.chalan.invoice = res.data;
                })
            },
            getPurchaseWithChalan(){
                if(event == undefined)
                    return

                if(this.selectedPurchase.PurchaseMaster_SlNo == "" || this.selectedPurchase.PurchaseMaster_SlNo == 0){
                    alert("Select invoice");
                    return
                }
                axios.post("/get_purchase_with_chalan", {purchaseId: this.selectedPurchase.PurchaseMaster_SlNo}).then(res=> {
                    this.products = res.data;
                })
            },
            onChangeQty(product){
                let total = parseFloat(product.total_chalan) + parseFloat(product.receive);
                if(this.chalan_id == 0 && (total > parseFloat(product.purchase_qty))){
                    alert("Receive qty is bigger than purchase qty");
                    product.receive = 0;
                }
                product.due = (parseFloat(product.purchase_qty) - parseFloat(product.total_chalan)) - parseFloat(product.receive);
            },
            saveChalan(){
                if(this.products.length == 0){
                    alert("Chalan is empty");
                    return;
                }

                if( this.chalan_id ==0 && (this.selectedPurchase.PurchaseMaster_SlNo == 0  || this.selectedPurchase.PurchaseMaster_SlNo == '')){
                    alert("Select invoice");
                    return;
                }
                this.chalan.supplier_id = this.selectedPurchase.Supplier_SlNo;
                if(this.chalan_id == 0)
                    this.chalan.purchase_id = this.selectedPurchase.PurchaseMaster_SlNo;
                    
                this.chalan.total = this.products.reduce((prev, curr) => prev+ (+curr.purchase_rate * curr.receive),0);
                let chalan = {
                    chalan: this.chalan,
                    products: this.products
                }
                let url = "/save_purchase_chalan";
                if(this.chalan_id > 0){
                    url = "/update_purchase_chalan";
                }

                axios.post(url, chalan).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if(r.status == 200){
                        location.reload();
                    }
                })
            }
        }
	})
</script>