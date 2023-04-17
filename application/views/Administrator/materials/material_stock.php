<div class="row" style="margin:15px">
    <div class="col-sm-12">
        <h2 class="text-center" style="margin: 0px;border-bottom:1px solid #ccc">Material Stock</h2>
    </div>
</div>
<div id="materialStock">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label style="padding-left: 0px;padding-right: 0px;text-align: right;padding-top: 4px;" class="col-md-1"> Select Type </label>
                <div class="col-md-2">
                    <select v-model="selectType" id="" class="form-control" style="height: 28px;" v-on:change="getData()">
                        <option value="" disabled selected>Select==</option>
                        <option value="all">All</option>
                        <option value="material">By Material</option>
                        <option value="category">By Category</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="display: none;" :style="{display: selectType == 'material' ? 'block' : 'none'}">
                <label style="padding-left: 0px;padding-right: 0px;text-align: right;padding-top: 4px;" class="col-md-1"> Select Material </label>
                <div class="col-md-2">
                    <select v-model="Material" id="" class="form-control" style="height: 28px;">
                        <option value="" disabled selected>Select Material==</option>
                        <option v-for="(item,index) in allMaterials" :key="index" :value="item.material_id">{{item.name}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="display: none;" :style="{display: selectType == 'category' ? 'block' : 'none'}">
                <label style="padding-left: 0px;padding-right: 0px;text-align: right;padding-top: 4px;" class="col-md-1"> Select Category </label>
                <div class="col-md-2">
                    <select v-model="Category" id="" class="form-control" style="height: 28px;">
                        <option value="" disabled selected>Select Category==</option>
                        <option v-for="(item,index) in allCategories" :key="index" :value="item.ProductCategory_SlNo">{{item.ProductCategory_Name}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2">
                    <input type="button" class="btn btn-primary" v-on:click="getMaterialStock()" value="Show Report" style="height: 28px; padding: 0px 8px;">
                </div>
            </div>
        </div>
    </div>
    <div class="row" style=" margin-top:10px;">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Material Name</th>
                            <th>Category</th>
                            <th>Total Purchased</th>
                            <th>Used in Production</th>
                            <th>Damaged</th>
                            <th>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody style="display: none;" :style="{display: isEmptyStock ? '' : 'none'}">
                        <tr>
                            <td colspan="7" style="padding: 15px;color:red;">No Record Found</td>
                        </tr>
                    </tbody>
                    <tbody style="display:none;" v-bind:style="{display:stock.length > 0 ? '' : 'none'}">
                        <tr v-for="(material, sl) in stock">
                            <td>{{ sl+1 }}</td>
                            <td>{{ material.name }}</td>
                            <td>{{ material.category_name }}</td>
                            <td>{{ material.purchased_quantity }} {{ material.unit_name}}</td>
                            <td>{{ material.production_quantity }} {{ material.unit_name}}</td>
                            <td>{{ material.damage_quantity }} {{ material.unit_name}}</td>
                            <td>{{ material.stock_quantity }} {{ material.unit_name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script>
    new Vue({
        el: '#materialStock',
        data() {
            return {
                stock: [],
                allMaterials: [],
                allCategories: [],
                selectType: "",
                Material: '',
                Category: '',

                isEmptyStock: false,
            }

        },
        created() {
            // this.getMaterialStock();
        },
        methods: {
            getData() {
                if (this.selectType == 'all') {
                    this.Material = '';
                    this.Category = '';
                }
                if (this.selectType == 'material') {
                    axios.get('get_all_materials').then(res => {
                        this.allMaterials = res.data;
                    });
                }
                if (this.selectType == 'category') {
                    axios.get('get_categories').then(res => {
                        this.allCategories = res.data;
                    });
                }
            },
            getMaterialStock() {
                if (this.selectType == 'category' && this.Category == '') {
                    alert('Select a Category');
                    return;
                }
                if (this.selectType == 'material' && this.Material == '') {
                    alert('Select a Material');
                    return;
                }
                let data = {
                    material_id: this.selectType == 'material' ? this.Material : '',
                    Category_id: this.selectType == 'category' ? this.Category : '',
                }
                if (this.selectType != '') {
                    this.isEmptyStock = false;
                    axios.post('/get_material_stock', data)
                        .then(res => {
                            this.stock = res.data;
                            if (this.stock.length == 0) {
                                this.isEmptyStock = true;
                            }
                        })
                }
            },

        }
    })
</script>