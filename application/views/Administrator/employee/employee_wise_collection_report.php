<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select.open .dropdown-toggle{
		border-bottom: 1px solid #ccc;
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
	#customerPayment label{
		font-size:13px;
	}
	#customerPayment select{
		border-radius: 3px;
		padding: 0;
	}
	#customerPayment .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#customerPayment .add-button:hover{
		background-color: #41add6;
		color: white;
	}

    .dropdown.v-select.single.searchable{
        margin-left: 81px;
        margin-top: -21px;
        width: 164px;
    }
</style>
<div id="app">
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" v-on:submit.prevent="getTransactions" >
                <div class="form-group">
                    <label> Employee </label>
                    <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name" placeholder="Select Employee"></v-select>
                </div>

                <div class="form-group">
                    <label> Date from </label>
                    <input type="date" class="form-control" v-model="dateFrom">
                    <label> to </label>
                    <input type="date" class="form-control" v-model="dateTo">
                </div>

                <div class="form-group" style="margin-top: -5px;">
                    <div class="col-sm-1">
                        <input type="submit" value="Show">
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
		<a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print()">
			<i class="fa fa-print"></i> Print
		</a>
        <div class="table-responsive" id="reportTable">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align:center">Date</th>
							<th style="text-align:center">Description</th>
							<th style="text-align:center">Bill</th>
							<th style="text-align:center">Paid</th>
							<th style="text-align:center">Discount</th>
							<th style="text-align:center">Inv.Due</th>
							<th style="text-align:center">Returned</th>
							<th style="text-align:center">Paid to customer</th>
							<th style="text-align:center">Due</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td style="text-align:left;">Previous Balance</td>
							<td colspan="6"></td>
							<td style="text-align:right;">{{ parseFloat(previousBalance).toFixed(2) }}</td>
						</tr>
						<tr v-for="payment in payments">
							<td>{{ payment.date }}</td>
							<td style="text-align:left;">{{ payment.description }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.bill).toFixed(2) }}</td>
							<td style="text-align:right;">{{ (parseFloat(payment.paid) - parseFloat(payment.discount_amount)).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.discount_amount).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.due).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.returned).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.paid_out).toFixed(2) }}</td>
							<td style="text-align:right;">{{ parseFloat(payment.balance).toFixed(2) }}</td>
						</tr>
					</tbody>
					<tfoot style="font-weight: bold;"  v-if="payments.length > 0">
						<tr>
							<td colspan="2" style="text-align: right;">Total</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + parseFloat(c.bill) }, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + (parseFloat(c.paid) - parseFloat(c.discount_amount))}, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + parseFloat(c.discount_amount) }, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + parseFloat(c.due) }, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + parseFloat(c.returned) }, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments.reduce((p, c) => { return p + parseFloat(c.paid_out) }, 0).toFixed(2) }}</td>
							<td style="text-align: right;">{{ payments[payments.length - 1].balance.toFixed(2) }}</td>
						</tr>
					</tfoot>
				</table>

				<table v-if="payments.length == 0">
					<tbody>
						<tr>
							<td>No records found</td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/js/vue/vue.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
	Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: "#app",
        data: () => ({
            payments: [],
            employees: [],
            selectedEmployee: null,
            previousBalance: 0,
            dateFrom: moment().format('YYYY-MM-DD'),
            dateTo: moment().format('YYYY-MM-DD')
        }),
        created() {
            this.getEmployees();
        },
        methods: {
            getEmployees: function() {
                axios.get("/get_employees").then(res => {
                    this.employees = res.data;
                })
            },
            
            getTransactions: function() {
				if(this.selectedEmployee == "" || this.selectedEmployee == null) {
					alert("Select Employee");
					return;
				}
                let employeeId = this.selectedEmployee == null ? null : this.selectedEmployee.Employee_SlNo;
                axios.post("/get_employee_wise_collection", {employeeId: employeeId,dateFrom: this.dateFrom, dateTo: this.dateTo}).then(res => {
                    this.payments = res.data.payments;
                    this.previousBalance = res.data.previousBalance;
                })
            },
			async print(){
				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

				var mywindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				mywindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				mywindow.document.body.innerHTML += reportContent;

				mywindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				mywindow.print();
				mywindow.close();
			}
        },
    })
</script>