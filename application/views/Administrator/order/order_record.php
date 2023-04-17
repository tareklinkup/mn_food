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
	#searchForm select{
		padding:0;
		border-radius: 4px;
	}
	#searchForm .form-group{
		margin-right: 5px;
	}
	#searchForm *{
		font-size: 13px;
	}
	.dropdown.v-select.single.searchable{
		margin-left: 51px;
		margin-top: -24px;
		width: 247px;
	}
	
</style>

<div class="row" id="chalan" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
    <div class="col-md-12">
        <form method="post" class="form-inline"  id="searchForm" @submit.prevent="getOrder">
            <div class="form-group">
				<label>Chalan</label>
				<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
			</div>
			<div class="form-group" style="display: none;">
				<select class="form-control" v-model="searchType" @change="onChangeSearch">
					<option value="with_details">With details</option>
					<option value="without_details">Without details</option>
				</select>
			</div>
			<div class="form-group">
				<input type="date" class="form-control" v-model="dateFrom">
			</div>

			<div class="form-group">
				<input type="date" class="form-control" v-model="dateTo">
			</div>
			<div class="form-group" style="margin-top: -5px;">
				<input type="submit" value="Search">
			</div>
        </form>
    </div>
    <div class="col-md-12" v-if="searchType == 'without_details' && records.length > 0 ">
		<p class="text-right">
			<button @click.prevent="allChecked" class="btn btn-xs btn-primary">Select All</button>
			<button class="btn btn-xs btn-success" @click.prevent="orderToConvert()">Convert Sale</button>
		</p>
		<table class="table table-bordered table-sm" style="margin-top: 5px;">
			<thead>
				<tr>
                    <th>SL</th>
                    <th>Date</th>
					<th>Customer name</th>
					<th>Customer phone</th>
					<th>Total qty</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(record , sl) in records">
					<td>{{ sl+1 }}</td>
					<td>{{ record.entry_date }}</td>
					<td>{{ record.customer_name }}</td>
					<td>{{ record.customer_phone }}</td>
					<td>{{ record.total_qty }}</td>
                    <td>{{ record.total_qty }}</td>
                    <td>
						<input type="checkbox" v-model="record.is_checked">
                        <!-- <button @click.prevent="orderToConvert(record)">Convert Sale</button> -->
                    </td>
				</tr>
			</tbody>
		</table>
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
                customers: [],
                selectedCustomer: null,
				searchType: "without_details",
				dateFrom: moment().format("YYYY-MM-DD"),
				dateTo: moment().format("YYYY-MM-DD"),
				records: []
            }
		},
		created(){
            this.getCustomers();
		},
		methods:{
			allChecked() {
				this.records = this.records.map(order => {
					order.is_checked = true;
					return order;
				})
			},
            orderToConvert(){
				let counter = 0;
				this.records.filter(f => f.is_checked == true).forEach(order => {

					axios.post('/order_to_sale_convert', {customerId: order.customer_id, date: order.entry_date})
					.then(res => {
                        let r = res.data;
                        if(r.status){
                            counter ++;
                        }
                    })  

				});

				alert("Sales Convert successfully");
				this.getOrder();
            },
            getCustomers(){
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
            onChangeSearch(){
                this.records = [];
            },
            getOrder(){
                let query = {
					customerId: this.selectedCustomer == null ? null : this.selectedCustomer.Customer_SlNo,
					searchType: this.searchType,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}
				let url = "/get_order_without_details";

				if(this.searchType  == "with_details"){
					url = "/get_order_with_details";
				}

				axios.post(url, query).then(res=>{
					this.records = res.data.map(order => {
						order.is_checked = false;
						return order;
					});
				})
            }

        }
	})
</script>