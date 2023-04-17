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
        <form method="post" class="form-inline"  id="searchForm" @submit.prevent="getPurchaseChalanRecord">
            <div class="form-group">
				<label>Chalan</label>
				<v-select v-bind:options="chalans" v-model="selectedChalan" label="display_text"></v-select>
			</div>
			<div class="form-group">
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
		<table class="table table-bordered table-sm" style="margin-top: 5px;">
			<thead>
				<tr>
					<th>SL</th>
					<th>Chalan date</th>
					<th>Chalan no</th>
					<th>Supplier name</th>
					<th>Supplier Phone</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(record , sl) in records">
					<td>{{ sl+1 }}</td>
					<td>{{record.chalan_date }}</td>
					<td>{{record.invoice }}</td>
					<td>{{record.supplier_name }}</td>
					<td>{{record.supplier_phone }}</td>
					<td>{{record.total }}</td>
					<td>
						<?php if($this->session->userdata('accountType') != 'u'){?>
							<a href="" title="Edit Purchase chalan" target="_blank" v-bind:href="`/purchase_chalan/${record.id}`"><i class="fa fa-edit"></i></a>
							<a href="" title="Delete Purchase chalan" @click.prevent="deletePurchaseChalan(record.id)"><i class="fa fa-trash"></i></a>
						<?php }?>
					</td>
				</tr>
			</tbody>
		</table>
    </div>
    <div class="col-md-12" v-if="searchType == 'with_details' && records.length > 0 ">
		<table class="table table-bordered table-sm" style="margin-top: 5px;">
			<thead>
				<tr>
					<th>SL</th>
					<th>Chalan date</th>
					<th>Chalan no</th>
					<th>Supplier name</th>
					<th>Supplier Phone</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>Qty</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<template v-for="(record , sl) in records">
					<tr>
						<td>{{ sl+1 }}</td>
						<td>{{record.chalan_date }}</td>
						<td>{{record.invoice }}</td>
						<td>{{record.supplier_name }}</td>
						<td>{{record.supplier_phone }}</td>
						<td>{{ record.details[0].product_name }}</td>
						<td>{{ record.details[0].purchase_rate }}</td>
						<td>{{ record.details[0].qty }}</td>
						<td>{{ record.details[0].qty * record.details[0].purchase_rate }}</td>
						<td>
							<?php if($this->session->userdata('accountType') != 'u'){?>
								<a href="" title="Edit Purchase chalan" target="_blank" v-bind:href="`/purchase_chalan/${record.id}`"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Purchase chalan" @click.prevent="deletePurchaseChalan(record.id)"><i class="fa fa-trash"></i></a>
							<?php }?>
						</td>
					</tr>
					<tr v-for="child in record.details.slice(1)">
						<td colspan="5"></td>
						<td>{{ child.product_name }}</td>
						<td>{{ child.purchase_rate }}</td>
						<td>{{ child.qty }}</td>
						<td>{{ child.qty * child.purchase_rate }}</td>
						<td></td>
					</tr>
				</template>
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
                chalans: [],
				selectedChalan: null,
				searchType: "without_details",
				dateFrom: moment().format("YYYY-MM-DD"),
				dateTo: moment().format("YYYY-MM-DD"),
				records: []
				
            }
		},
		created(){
            this.getPurchaseInvoices();
		},
		methods:{
			onChangeSearch(){
				this.records = [];
			},
            getPurchaseInvoices(){
                axios.get("/get_purchase_chalans").then(res => {
                    this.chalans = res.data;
                })
            },
			getPurchaseChalanRecord(){
				let query = {
					chalan_id: this.selectedChalan == null ? null : this.selectedChalan.chalan_id,
					searchType: this.searchType,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}
				let url = "/get_purchase_chalan_without_details";

				if(this.searchType  == "with_details"){
					url = "/get_purchase_chalan_with_details";
				}

				axios.post(url, query).then(res=>{
					this.records = res.data;
				})
			},
			deletePurchaseChalan(id){
				let conf = confirm("Are you sure ?");
				if(conf){
					axios.post("/delete_purchase_chalan", {id: id}).then(res => {
						let r =res.data;
						alert(r.message);
						this.getPurchaseChalanRecord();
					})
				}
			}
        }
	})
</script>