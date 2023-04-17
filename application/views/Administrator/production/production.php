<style>
    .v-select {
        margin-top: -2.5px;
        float: right;
        min-width: 180px;
        width: 100%;
        margin-left: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 25px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }
</style>
<div id="production">
    <div class="row">
        <div class="com-xs-12">
            <div class="form-group">
                <!-- <label class="col-sm-1 control-label">Batch No</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Batch no" v-model="production.batch_no" required>
                </div> -->
                <!-- <label class="col-sm-1 control-label text-right">Date</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" v-model="production.date">
                </div> -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Materials</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="materialForm" v-on:submit.prevent="addToCart">
                                    <div class="form-group clearfix clearfix">
                                        <label class="col-sm-4 control-label">
                                            Material
                                        </label>
                                        <div class="col-sm-8">
                                            <v-select label="display_text" v-bind:options="materials" v-model="selectedMaterial" placeholder="Select Material" v-on:input="setFocus();getMaterialStock()"></v-select>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix clearfix">
                                        <label class="col-sm-4 control-label">
                                            Quantity <span v-if="selectedMaterial.material_id != ''" style="display:none;" v-bind:style="{display: selectedMaterial.material_id != '' ? '' : 'none'}">({{ selectedMaterial.unit_name }})</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" ref="quantity" required class="form-control" placeholder="Quantity" v-model="selectedMaterial.quantity" @input="calculateMaterialTotal" />
                                        </div>
                                        <div class="col-sm-4" v-if="selectedMaterial.material_id != ''" style="padding-top:3px;display:none;" v-bind:style="{display: selectedMaterial.material_id != 'none' ? '' : ''}">
                                            Stock: {{ stock_quantity }}
                                        </div>
                                    </div>


                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">
                                            Price
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" required class="form-control" placeholder="Pur. Rate" v-model="selectedMaterial.purchase_rate" @input="calculateMaterialTotal" />
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" required class="form-control" placeholder="Total" v-model="selectedMaterial.total" disabled />
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:4%;color:#000;">SL</th>
                                <th style="width:20%;color:#000;">Material Name</th>
                                <th style="width:13%;color:#000;">Category</th>
                                <th style="width:13%;color:#000;">S. Qty</th>
                                <th style="width:5%;color:#000;">Qty</th>
                                <th style="width:5%;color:#000;">P. Rate</th>
                                <th style="width:5%;color:#000;">Amount</th>
                                <th style="width:5%;color:#000;">#</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                            <tr v-for="(material, sl) in cart">
                                <td>{{ sl + 1}}</td>
                                <td>{{ material.name }}</td>
                                <td>{{ material.category_name }}</td>
                                <td>{{ parseFloat(material.sQty).toFixed(2) }}</td>
                                <td>{{ material.quantity }} {{ material.unit_name }}</td>
                                <td>{{ material.purchase_rate }}</td>
                                <td>{{ parseFloat(material.total).toFixed(2) }}</td>
                                <td><a href="" v-on:click.prevent="removeFromCart(material)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: 600;">
                                <td colspan="6" style="text-align: right;">Total</td>
                                <td>{{ (cart.reduce((prev,curr) => {return +prev + +curr.total},0)).toFixed(2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-4">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Finish Products</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="productForm" v-on:submit.prevent="addToProductCart">
                                    <div class="form-group clearfix" style="margin-bottom: 3px;">
                                        <label class="col-sm-4 control-label">Recipe</label>
                                        <div class="col-sm-8">
                                            <v-select label="recipe_name" v-bind:options="recipes" v-model="selectedRecipe" @input="onChangeRecipe"></v-select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Product</label>
                                        <div class="col-sm-8">
                                            <v-select label="display_text" v-bind:options="products" v-model="selectedProduct" placeholder="Select Product" @input="onChangeProduct"></v-select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label" id="convert">Convert</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-5 no-padding-right">
                                                    <input type="number" min="0" step="0.01" class="form-control" :placeholder="selectedProduct.convert_name" ref="productCarton" id="convert" v-model="selectedProduct.convert_qty" required @input="calculateProductTotal">
                                                </div>
                                                <label class="col-sm-2 control-label no-padding-right">Qty</label>
                                                <div class="col-sm-5 no-padding-left">
                                                    <input type="number" min="0" step="0.01" class="form-control" placeholder="Qty" ref="productQuantity" v-model="selectedProduct.p_quantity" required @input="calculateProductTotal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Quantity</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Quantity" ref="productQuantity" v-model="selectedProduct.quantity" required @input="calculateProductTotal">
                                        </div>
                                    </div> -->
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" v-model="selectedProduct.Product_Purchase_Rate" @input="calculateProductTotal">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" v-model="selectedProduct.total" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:4%;color:#000;">SL</th>
                                <th style="width:20%;color:#000;">Product Name</th>
                                <th style="width:5%;color:#000;">Qty</th>
                                <th style="width:5%;color:#000;">Price</th>
                                <th style="width:5%;color:#000;">Amount</th>
                                <th style="width:5%;color:#000;">#</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cartProducts.length > 0 ? '' : 'none'}">
                            <tr v-for="(product, sl) in cartProducts">
                                <td>{{ sl + 1}}</td>
                                <td>{{ product.name }}</td>
                                <td style="padding: 0;">
                                    <input type="text" v-model.number="product.quantity" v-on:input="calculateAll(sl)" style="width: 60px;padding: 0px;border: none;text-align: center;vertical-align: -webkit-baseline-middle;">
                                    {{ product.unit_name }}
                                </td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.total }}</td>
                                <td><a href="" v-on:click.prevent="removeFromProductCart(product)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: 600;">
                                <td colspan="4" style="text-align: right;">Total</td>
                                <td>{{ (cartProducts.reduce((prev,curr) => {return +prev + +curr.total},0)).toFixed(2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-3">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Production</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form v-on:submit.prevent="saveProduction">
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Batch No</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Batch no" v-model="production.batch_no" required>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Production Id</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Production Id" v-model="production.production_sl" readonly>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Incharge</label>
                                <div class="col-sm-12">
                                    <v-select label="display_name" v-bind:options="employees" v-model="selectedEmployee" placeholder="Select Incharge"></v-select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Shift</label>
                                <div class="col-sm-12">
                                    <select class="form-control" v-model="production.shift" style="padding:0px 3px;" required>
                                        <option value="">Select Shift</option>
                                        <option v-for="shift in shifts" v-bind:value="shift.name">{{ shift.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Labour Cost</label>
                                <div class="col-sm-12">
                                    <input type="number" min="0" class="form-control" v-model="production.labour_cost" v-on:input="calculateTotal">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Material Cost</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.material_cost" disabled>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Other Cost</label>
                                <div class="col-sm-12">
                                    <input type="number" min="0" class="form-control" v-model="production.other_cost" v-on:input="calculateTotal">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label"><strong>Total Cost</strong></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.total_cost" readonly>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Note</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" placeholder="Note" v-model="production.note"></textarea>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-sm-7 col-sm-offset-5">
                                    <button type="submit" class="btn btn-success pull-right" v-bind:disabled="productionInProgress ? true : false">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#production',
        data() {
            return {
                production: {
                    production_id: parseInt('<?php echo $production_id; ?>'),
                    production_sl: '<?php echo $productionSl; ?>',
                    date: '',
                    incharge_id: '',
                    shift: '',
                    note: '',
                    labour_cost: 0.00,
                    material_cost: 0.00,
                    other_cost: 0.00,
                    total_cost: 0.00,
                    batch_no: '',
                },
                employees: [],
                shifts: [],
                products: [],
                materials: [],
                selectedEmployee: null,
                selectedProduct: {
                    Product_SlNo: '',
                    Product_Name: '',
                    display_text: 'Select Product',
                    convert_qty: 0,
                    p_quantity: 0,
                    Product_Purchase_Rate: 0.00,
                    total: 0,
                },
                selectedMaterial: {
                    material_id: '',
                    name: 'Select Material',
                    purchase_rate: 0.00,
                    quantity: '',
                    total: 0,
                },
                cart: [],
                stock_quantity: 0,
                cartProducts: [],
                productionInProgress: false,

                recipes: [],
                selectedRecipe: {
                    recipe_id: '',
                    recipe_name: 'Select'
                },
            }
        },
        created() {
            this.getRecipes();
            this.getEmployees();
            this.getShifts();
            this.getProducts();
            this.getMaterials();
            this.production.date = moment().format('YYYY-MM-DD');

            if (this.production.production_id != 0) {
                this.getProduction();
            }
        },
        methods: {
            getRecipes() {
                axios.post('/get_recipes').then(res => {
                    this.recipes = res.data;
                })
            },
            getEmployees() {
                axios.get('/get_employees')
                    .then(res => {
                        this.employees = res.data;
                    })
            },
            getShifts() {
                axios.get('/get_shifts')
                    .then(res => {
                        this.shifts = res.data;
                    })
            },
            getProducts() {
                axios.get('/get_products')
                    .then(res => {
                        this.products = res.data;
                    })
            },
            getMaterials() {
                axios.get('/get_materials')
                    .then(res => {
                        this.materials = res.data;
                    })
            },
            getMaterialStock() {
                if (this.selectedMaterial.material_id == '') {
                    return;
                }
                axios.post('/get_material_stock', {
                        material_id: this.selectedMaterial.material_id
                    })
                    .then(res => {
                        this.stock_quantity = res.data[0].stock_quantity;
                    })
            },
            calculateMaterialTotal() {
                this.selectedMaterial.total = this.selectedMaterial.quantity * this.selectedMaterial.purchase_rate;
            },
            async calculateAll(sl) {

                this.cartProducts[sl].total = (parseFloat(this.cartProducts[sl].price) * this.cartProducts[sl].quantity).toFixed(2)

                let mainProduct = this.recipes.find(p => p.recipe_id == this.selectedRecipe.recipe_id)

                let original_difference = mainProduct.product[0].quantity / this.cartProducts[sl].quantity;

                this.cart.map((p, i) => {
                    let mainMaterial = mainProduct.materials.find(m => m.material_id == p.material_id)
                    let newQty = parseFloat(mainMaterial.quantity) / original_difference
                    p.quantity = newQty;
                    p.total = parseFloat(newQty) * parseFloat(p.purchase_rate);
                })

                this.calculateTotal()

            },
            setFocus() {
                this.$refs.quantity.focus();
            },
            addToCart() {
                let ind = this.cart.findIndex(m => m.material_id == this.selectedMaterial.material_id);
                if (ind > -1) {
                    this.cart[ind].quantity = parseFloat(this.cart[ind].quantity) + parseFloat(this.selectedMaterial.quantity);
                } else {
                    this.cart.push(this.selectedMaterial);
                }
                this.clearMaterial();
                this.calculateTotal();
            },
            removeFromCart(material) {
                let ind = this.cart.findIndex(m => m.material_id == material.material_id);
                if (ind > -1) {
                    this.cart.splice(ind, 1);
                    this.calculateTotal();
                }

            },
            clearMaterial() {
                this.selectedMaterial = {
                    material_id: '',
                    name: '',
                    purchase_rate: 0.00,
                    quantity: ''
                }
            },
            async onChangeRecipe() {
                // console.log(this.selectedRecipe);

                if (this.selectedRecipe.recipe_id == '') {
                    return
                }

                // this.production = this.selectedRecipe;
                // this.selectedEmployee = {
                //     Employee_SlNo: this.selectedRecipe.incharge_id,
                //     display_name: this.selectedRecipe.incharge_name + ' - ' + this.selectedRecipe.incharge_id,
                // }

                this.cart = [];
                this.selectedRecipe.materials.map(async item => {

                    let stockQty = 0;
                    await axios.post('/get_material_stock', {
                            material_id: item.material_id
                        })
                        .then(res => {
                            stockQty = res.data[0].stock_quantity;
                        })

                    let material = {
                        material_id: item.material_id,
                        name: item.name,
                        category_name: item.ProductCategory_Name,
                        purchase_rate: item.purchase_rate,
                        quantity: item.quantity,
                        total: item.total,
                        sQty: stockQty,

                    }
                    this.cart.push(material);
                });

                this.cartProducts = [];
                this.selectedRecipe.product.map(item => {
                    let prod = {
                        product_id: item.product_id,
                        name: item.Product_Name,
                        quantity: item.quantity,
                        price: item.price,
                        total: item.total,
                    }
                    this.cartProducts.push(prod);
                });

                // this.calculateTotal();

                // this.cart = this.selectedRecipe.materials;
                // this.cartProducts = this.selectedRecipe.product;

                // this.production.production_id = 0;
                // this.production.recipe_name = '';

            },
            onChangeProduct() {
                if (this.selectedProduct.Product_SlNo == '') {
                    return
                }
                document.getElementById("convert").innerHTML = this.selectedProduct.convert_name
                this.selectedProduct.convert_qty = 0;
                this.selectedProduct.p_quantity = 0;
                this.$refs.productQuantity.focus();
            },
            calculateProductTotal() {
                let convertQty = this.selectedProduct.convert_qty;
                let PlusQty = this.selectedProduct.p_quantity;
                let totalQty = parseFloat((+convertQty * +this.selectedProduct.quantity) + +PlusQty)
                this.selectedProduct.total_quantity = totalQty;

                // console.log(totalQty);

                this.selectedProduct.Product_Purchase_Rate = (this.production.total_cost / totalQty).toFixed(2);
                this.selectedProduct.total = (totalQty * this.selectedProduct.Product_Purchase_Rate).toFixed(2);
            },
            addToProductCart() {
                if (this.selectedProduct == null || this.selectedProduct.Product_SlNo == '') {
                    alert('Select product');
                    return;
                }
                if (this.selectedProduct.total_quantity == 0) {
                    alert('Product quantity is required');
                    return;
                }
                if (this.cartProducts.length > 0) {
                    alert('You can only one product add to cart');
                    return;
                }
                // if (this.production.batch_no == '') {
                //     alert('Batch Name is required!');
                //     return;
                // }

                let ind = this.cartProducts.findIndex(p => p.product_id == this.selectedProduct.Product_SlNo);
                if (ind > -1) {
                    this.cartProducts[ind].quantity = parseFloat(this.cartProducts[ind].quantity) + parseFloat(this.selectedProduct.total_quantity);
                } else {
                    let product = {
                        product_id: this.selectedProduct.Product_SlNo,
                        name: this.selectedProduct.Product_Name,
                        category_name: this.selectedProduct.ProductCategory_Name,
                        quantity: this.selectedProduct.total_quantity,
                        price: this.selectedProduct.Product_Purchase_Rate,
                        total: this.selectedProduct.total,
                    }
                    this.cartProducts.push(product);
                }

                this.clearProduct();
            },
            removeFromProductCart(product) {
                let ind = this.cartProducts.findIndex(p => p.product_id == product.product_id);
                if (ind > -1) {
                    this.cartProducts.splice(ind, 1);
                }
            },
            clearProduct() {
                this.selectedProduct = {
                    Product_SlNo: '',
                    Product_Name: '',
                    display_text: 'Select Product',
                    convert_qty: 0,
                    p_quantity: 0,
                    Product_Purchase_Rate: 0.00,
                }
            },
            calculateTotal() {

                this.production.material_cost = (this.cart.reduce((p, c) => {
                    return +p + +c.total
                }, 0)).toFixed(2);


                let l_cost = this.production.labour_cost == '' ? 0 : this.production.labour_cost;
                let O_cost = this.production.other_cost == '' ? 0 : this.production.other_cost;

                this.production.total_cost =
                    (+l_cost + parseFloat(this.production.material_cost) + +O_cost);

                this.cartProducts[0].total = this.production.total_cost;
                this.cartProducts[0].price = parseFloat(this.production.total_cost / this.cartProducts[0].quantity).toFixed(2);
            },
            saveProduction() {
                if (this.selectedEmployee == null) {
                    alert('Select production incharge');
                    return;
                }
                if (this.cart.length == 0) {
                    alert('Material cart is empty');
                    return;
                }
                if (this.cartProducts.length == 0) {
                    alert('Product cart is empty');
                    return;
                }

                this.production.incharge_id = this.selectedEmployee.Employee_SlNo;

                let url = '/add_production';
                if (this.production.production_id != 0) {
                    url = '/update_production';
                }

                let data = {
                    production: this.production,
                    materials: this.cart,
                    products: this.cartProducts
                }

                // console.log(url, data);
                // return

                this.productionInProgress = true;
                axios.post(url, data).then(async res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        let conf = confirm('Production success, Do you want to view invoice?');
                        if (conf) {
                            window.open('/production_invoice/' + r.productionId, '_blank');
                            await new Promise(r => setTimeout(r, 1000));
                        }
                        window.location = '/production';
                    }
                })
            },
            async getProduction() {
                await axios.post('/get_productions', {
                        production_id: this.production.production_id
                    })
                    .then(res => {
                        this.production = res.data[0];
                        this.selectedEmployee = {
                            Employee_SlNo: this.production.incharge_id,
                            display_name: this.production.incharge_name + ' - ' + this.production.incharge_id,
                        }
                    })
                await axios.post('/get_production_details', {
                        production_id: this.production.production_id
                    })
                    .then(res => {
                        this.cart = res.data;
                    })

                await axios.post('/get_production_products', {
                        production_id: this.production.production_id
                    })
                    .then(res => {
                        this.cartProducts = res.data;
                    })
            }
        }
    })
</script>