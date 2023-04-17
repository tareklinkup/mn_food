<style>
    .v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 25px;
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
	.record-table{
		width: 100%;
		border-collapse: collapse;
	}
	.record-table thead{
		background-color: #0097df;
		color:white;
	}
	.record-table th, .record-table td{
		padding: 3px;
		border: 1px solid #454545;
	}
    .record-table th{
        text-align: center;
    }
</style>
<div id="app">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<v-select v-bind:options="branches" v-model="selectedBranch" label="Brunch_name"></v-select>
				</div>
				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-top: 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Brach</th>
                        <th>Total Sale</th>
                        <th>Total Paid</th>
                        <th>Total Due</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="report in reports" style="display: none;" :style="{display: reports.length>0 ? '' : 'none' }">
                        <td>{{ report.Brunch_name }}</td>
                        <td>{{ report.billAmount }}</td>
                        <td>{{ report.paidAmount }}</td>
                        <td>{{ report.dueAmount }}</td>
                    </tr>
                    <tr style="display: none;font-weight:bold" :style="{display: reports.length>0 ? '' : 'none' }">
                        <td>Total</td>
                        <td>
                            {{
                                reports.reduce((prev,curr) => prev + +curr.billAmount, 0).toFixed(2)
                            }}
                        </td>
                        <td>
                            {{
                                reports.reduce((prev,curr) => prev + +curr.paidAmount, 0).toFixed(2)
                            }}
                        </td>
                        <td>
                            {{
                                reports.reduce((prev,curr) => prev + +curr.dueAmount, 0).toFixed(2)
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
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
        el: "#app",
        data: () => ({
          reports: [],
          branches: [],
          selectedBranch: {
            brunch_id: 'All',
            Brunch_name: 'All Branch'
          }
        }),
        created(){
            this.getBranches();
        },
        methods: {
            getBranches: function(){
                axios.get("/get_branches").then(res => {
                    this.branches = res.data;
                    this.branches.unshift({
                        brunch_id: 'All',
                        Brunch_name: 'All Branch'
                    })
                })
            },
            getSearchResult(){
                let branchId = this.selectedBranch == null ?  null : this.selectedBranch.brunch_id;
                axios.post("/get_branch_wise_report", {branchId: branchId}).then(res => {
                    this.reports = res.data;
                })
            }
        }
    })
</script>