<div id="orderInvoice">
    <div class="col-xs-12">
        <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
    </div>
	<div class="row" id="invoiceContent">
		<div class="col-md-8 col-md-offset-2">
            <p style="padding: 5px; background: #ddd;text-align:center;font-weight: bold"> Order </p>
            <div class="row">
                <div class="col-md-6">
                    <table style="float: left;">
                        <tr>
                            <td style="width: 60%;">Customer name</td>
                            <td style="width: 5%;">:</td>
                            <td><?= $orders[0]->customer_name ?></td>
                        </tr>
                        <tr>
                            <td style="width: 60%;">Customer code</td>
                            <td style="width: 5%;">:</td>
                            <td><?= $orders[0]->customer_code ?></td>
                        </tr>
                        <tr>
                            <td>Customer Mobile</td>
                            <td>:</td>
                            <td><?= $orders[0]->customer_mobile ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;margin-top: 5px">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Description</th>
                            <th>Rate</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $key=>$order){ ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td><?= $order->Product_Name;?></td>
                            <td><?= $order->qty;?></td>
                            <td><?= $order->sale_rate;?></td>
                            <td><?= $order->qty*$order->sale_rate;?></td>
                        </tr>
                        <?php } ?>
                        <tr style="font-weight: bold;">
                            <td colspan="4" style="text-align: right">Total</td>
                            <td>
                                <?php 
                                    echo array_reduce($orders, function($prev, $curr){
                                        return $prev += ($curr->qty * $curr->sale_rate);
                                    });
                                
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
	new Vue({
		el: '#orderInvoice',
        data: {
            return() {
                companyProfile: null
            }
        },
        created(){
            this.getCompanyProfile();
        },
		methods: {
            getCompanyProfile(){
                axios.get('/get_company_profile').then(res => {
                    this.companyProfile = res.data;
                })
            },
            async print(){
                let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
                let printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}, left=0, top=0`);
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Invoice</title>
                        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                        <style>
                            body, table{
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-2"><img src="/uploads/company_profile_thum/${this.companyProfile.Company_Logo_thum}" alt="Logo" style="height:80px;" /></div>
                                <div class="col-xs-10" style="padding-top:20px;">
                                    <strong style="font-size:18px;">${this.companyProfile.Company_Name}</strong><br>
                                    ${this.companyProfile.Repot_Heading}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    ${invoiceContent}
                                </div>
                            </div>
                        </div>
                        <div class="container" style="position:fixed;bottom:15px;width:100%;">
                            <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:5px;padding-bottom:6px;">
                                <div class="col-xs-6">
                                    ** THANK YOU FOR YOUR BUSINESS **
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span style="text-decoration:overline;">Authorized Signature</span>
                                </div>
                            </div>

                            <div class="row" style="font-size:12px;">
                                <div class="col-xs-6">
                                    Print Date: ${moment().format('DD-MM-YYYY h:mm a')}
                                </div>
                                <div class="col-xs-6 text-right">
                                    Developed by: Link-Up Technology, Contact no: 01911978897
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>
                `);

                printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            }
        },
	})
</script>


