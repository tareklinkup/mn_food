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
<div id="recipe">
    <div class="row">
        <div class="col-sm-5">
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
                                <form id="materialForm" v-on:submit.prevent="addToCartMaterial">
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
                                            <button type="submit" class="btn btn-default pull-right" style="border: none;background: #438eb9 !important;">Add to Cart</button>
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
                                <th style="width:10%;color:#000;">Qty</th>
                                <th style="width:5%;color:#000;">Amount</th>
                                <th style="width:10%;color:#000;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                            <tr v-for="(material, sl) in cart">
                                <td>{{ sl + 1}}</td>
                                <td>{{ material.name }}</td>
                                <td>{{ material.category_name }}</td>
                                <td>{{ material.quantity }} {{ material.unit_name }}</td>
                                <td>{{ parseFloat(material.total).toFixed(2) }}</td>
                                <td><a href="" v-on:click.prevent="removeFromCart(material)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: 600;">
                                <td style="text-align: right;" colspan="4">Total</td>
                                <td>{{ (cart.reduce((prev,curr) => {return +prev + +curr.total},0)).toFixed(2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-sm-4">
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
                                    <div class="form-group clearfix">
                                        <label class="col-sm-3 control-label">Product</label>
                                        <div class="col-sm-9">
                                            <v-select label="display_text" v-bind:options="products" v-model="selectedProduct" placeholder="Select Product" @input="onChangeProduct"></v-select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-3 control-label" id="convert">Convert</label>
                                        <div class="col-sm-9">
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
                                    <div class="form-group clearfix">
                                        <label class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-5 no-padding-right">
                                                    <input type="text" class="form-control" v-model="selectedProduct.Product_Purchase_Rate" @input="calculateProductTotal">
                                                </div>
                                                <label class="col-sm-2 control-label no-padding text-right">Total</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" v-model="selectedProduct.total" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-default pull-right" style="border: none;background: #438eb9 !important;">Add to Cart</button>
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
                                <th style="width:10%;color:#000;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cartProducts.length > 0 ? '' : 'none'}">
                            <tr v-for="(product, sl) in cartProducts">
                                <td>{{ sl + 1}}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.quantity }} {{ product.unit_name }}</td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.total }}</td>
                                <td><a href="" v-on:click.prevent="removeFromProductCart(product)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: 600;">
                                <td style="text-align: right;" colspan="2">Total</td>
                                <td>{{ cartProducts.reduce((prev,curr) => {return +prev + +curr.quantity},0) }}</td>
                                <td>{{ cartProducts.reduce((prev,curr) => {return +prev + +curr.price},0) }}</td>
                                <td>{{ cartProducts.reduce((prev,curr) => {return +prev + +curr.total},0) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Details</h4>
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
                                <div class="form-group clearfix">
                                    <label class="control-label">Recipe Name</label>
                                    <input type="text" class="form-control" v-model="inputField.recipe_name" placeholder="Recipe name">
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label">Date</label>
                                    <input type="date" class="form-control" v-model="inputField.date" readonly>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label">User</label>
                                    <input type="text" class="form-control" v-model="userName" readonly>
                                </div>
                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-default pull-right" style="border: none;background: rgb(255 0 0) !important;" @click.prevent="saveRecipe" :disabled="isProcess">Save Recipe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Table</h4>
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
                        <div class="col-sm-12 form-inline no-padding">
                            <div class="form-group">
                                <label for="filter" class="sr-only">Filter</label>
                                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <datatable :columns="columns" :data="recipes" :filter-by="filter">
                                        <template scope="{ row }">
                                            <tr>
                                                <td>{{ row.recipe_id }}</td>
                                                <td>{{ row.recipe_name }}</td>
                                                <td>
                                                    <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                                        <button type="button" class="edit" @click="editItem(row)">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button" class="button" @click="deleteItem(row.recipe_id)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </template>
                                    </datatable>
                                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#recipe',
        data() {
            return {
                inputField: {
                    recipe_id: parseInt('<?php echo $recipe_id; ?>'),
                    recipe_name: '',
                    date: '',
                },
                total_cost: 0,
                userName: '<?= $this->session->userdata("FullName"); ?>',
                products: [],
                selectedProduct: {
                    Product_SlNo: '',
                    Product_Name: '',
                    display_text: 'Select Product',
                    convert_qty: 0,
                    p_quantity: 0,
                    Product_Purchase_Rate: 0.00,
                    total: 0,
                },
                materials: [],
                selectedMaterial: {
                    material_id: '',
                    display_text: 'Select Material',
                    purchase_rate: 0.00,
                    quantity: '',
                    total: 0,
                },
                cart: [],
                stock_quantity: 0,
                cartProducts: [],
                isProcess: false,

                recipes: [],


                columns: [{
                        label: 'Recipe Id',
                        field: 'recipe_id',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Recipe Name',
                        field: 'recipe_name',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created() {
            this.getRecipes();
            this.getProducts();
            this.getMaterials();
            this.inputField.date = moment().format('YYYY-MM-DD');

            if (this.inputField.recipe_id != 0) {
                this.getRecipe();
            }
        },
        methods: {
            getRecipes() {
                axios.get('/get_recipes')
                    .then(res => {
                        this.recipes = res.data;
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
            setFocus() {
                this.$refs.quantity.focus();
            },
            addToCartMaterial() {
                let ind = this.cart.findIndex(m => m.material_id == this.selectedMaterial.material_id);
                if (ind > -1) {
                    this.cart.splice(ind, 1);
                    // this.cart[ind].quantity = parseFloat(this.cart[ind].quantity) + parseFloat(this.selectedMaterial.quantity);
                    this.cart.push(this.selectedMaterial);
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
            calculateTotal() {
                this.total_cost = this.cart.reduce((p, c) => {
                    return +p + +c.total
                }, 0);

            },
            clearMaterial() {
                this.selectedMaterial = {
                    material_id: '',
                    display_text: 'Select Material',
                    purchase_rate: 0.00,
                    quantity: '',
                    total: 0,
                }
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
                let totalQty = parseFloat((parseFloat(convertQty) * parseFloat(this.selectedProduct.quantity)) + +PlusQty)
                this.selectedProduct.total_quantity = totalQty;

                this.selectedProduct.Product_Purchase_Rate = (this.total_cost / totalQty).toFixed(2);
                // console.log(this.selectedProduct);
                // console.log(this.total_cost);
                // return

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
            saveRecipe() {
                if (this.cart.length == 0) {
                    alert('Material cart is empty');
                    return;
                }
                if (this.cartProducts.length == 0) {
                    alert('Product cart is empty');
                    return;
                }
                if (this.inputField.recipe_name == '') {
                    alert('Recipe Name is Empty!');
                    return
                }


                let url = '/add_recipe';
                if (this.inputField.recipe_id != 0) {
                    url = '/update_recipe';
                }

                let data = {
                    recipe: this.inputField,
                    materials: this.cart,
                    products: this.cartProducts
                }

                // console.log(url, data);
                // return

                this.isProcess = true;

                let ind = this.recipes.findIndex(p => p.recipe_name == this.inputField.recipe_name);
                if (this.inputField.recipe_id != 0) {
                    ind = this.recipes.findIndex(p => p.recipe_name == this.inputField.recipe_name && p.recipe_id != this.inputField.recipe_id);
                }
                if (ind > -1) {
                    alert('Recipe name already exist');
                    this.isProcess = false;
                    return;
                } else {
                    axios.post(url, data).then(async res => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            window.location = '/recipe_entry';
                        }
                    })
                }
            },

            editItem(data) {
                this.inputField.recipe_id = data.recipe_id;
                this.inputField.recipe_name = data.recipe_name;
                this.inputField.date = data.date;

                this.cart = [];

                data.materials.map(item => {
                    let material = {
                        material_id: item.material_id,
                        name: item.name,
                        category_name: item.ProductCategory_Name,
                        purchase_rate: item.purchase_rate,
                        quantity: item.quantity,
                        total: item.total,
                    }
                    this.cart.push(material);
                });

                this.cartProducts = [];
                data.product.map(item => {
                    let product = {
                        product_id: item.product_id,
                        name: item.Product_Name,
                        quantity: item.quantity,
                        price: item.price,
                        total: item.total,
                    }
                    this.cartProducts.push(product);
                });

                this.calculateTotal();
            },
            deleteItem(id) {
                let conf = confirm('Are you sure to delete recipe?')
                if (!conf) {
                    return
                }

                axios.post("/delete_recipe", {
                    recipeId: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getRecipes();
                    }
                })
            }
        }
    })
</script>