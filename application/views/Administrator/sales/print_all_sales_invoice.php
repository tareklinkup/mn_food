<style>
	#new-invoice {
		width: 70%;
	}
</style>
<button onclick="printContent()">Print</button>
<div class="row" id="printContext">
<style>
	 div[_h098asdh]{
		font-weight: bold;
		font-size:15px;
		margin-bottom:15px;
		padding: 5px;
		border-top: 1px dotted black;
		border-bottom: 1px dotted black;
	}
	div[_d9283dsc]{
		padding-bottom:25px;
		border-bottom: 1px solid black;
		margin-bottom: 15px;
	}
	table[_a584de]{
		width: 100%;
		text-align:center;
	}
	table[_a584de] thead{
		font-weight:bold;
	}
	table[_a584de] td{
		padding: 3px;
		border: 1px solid black;
	}
	table[_t92sadbc2]{
		width: 100%;
	}
	table[_t92sadbc2] td{
		padding: 2px;
	}
	
	@media print {
		.ft-size{
			font-size: 11px !important;
		}
		.ft-size strong {
			font-size: 11px !important;
		}

		table[_a584de] thead{
			font-weight: 600;
			font-size: 13px !important;
		}
	}
</style>
	<?php foreach($sales as $sale){ ?>
	<div id="new-invoice" style="padding: 5px">
		<?php 
			$branchId = $this->session->userdata('BRANCHid');
			$companyInfo = $this->Billing_model->company_branch_profile($branchId);
		?>
		<div class="row">
			<div class="col-xs-2"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $companyInfo->Company_Logo_org; ?>" alt="Logo" style="height:80px;" /></div>
			<div class="col-xs-10" style="padding-top:20px;">
				<strong style="font-size:18px;"><?php echo $companyInfo->Company_Name; ?></strong><br>
				<p style="white-space: pre-line;"><?php echo $companyInfo->Repot_Heading; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div style="border-bottom: 4px double #454545;margin-top:7px;margin-bottom:7px;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<div _h098asdh>
					Sales Invoice
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-7 ft-size">
				<strong>Customer Id:</strong> <?= $sale->Customer_Code?><br>
				<strong>Customer Name:</strong> <?= $sale->Customer_Name?><br>
				<strong>Customer Address:</strong> <?= $sale->Customer_Address?><br>
				<strong>Customer Mobile:</strong> - <?= $sale->Customer_Mobile?>
			</div>
			<div class="col-xs-5 text-right ft-size">
				<strong>Sales by:</strong> <?= $sale->AddBy?> <br>
				<strong>Invoice No.:</strong> <?= $sale->SaleMaster_InvoiceNo?> <br>
				<strong>Sales Date:</strong> <?= date_format(date_create($sale->AddTime), 'd-m-Y h:i a') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div style="border-bottom: 1px solid #454545;margin-top:7px;margin-bottom:7px;"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<table _a584de>
					<thead>
						<tr>
							<td>Sl.</td>
							<td>Description</td>
							<td>Qty</td>
							<td>Unit Price</td>
							<td>Total</td>
						</tr>
					</thead>
					<tbody>
					<?php foreach($sale->details as $key=>$detail) { ?>
						<tr>
							<td><?= $key+1?></td>
							<td><?= $detail->Product_Name ?></td>
							<td><?= $detail->SaleDetails_TotalQuantity ?> <?= $detail->Unit_Name ?></td>
							<td><?= $detail->SaleDetails_Rate ?></td>
							<td><?= $detail->SaleDetails_TotalAmount ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-8">
			    <br>
				<table class="pull-left">
					<tr>
						<td><strong>Previous Due:</strong></td>
						
						<td style="text-align:right">
							<?php echo $sale->SaleMaster_Previous_Due; ?>
						</td>
					</tr>
					<tr>
						<td><strong>Current Due:</strong></td>
						
						<td style="text-align:right">
							<?php echo $sale->SaleMaster_DueAmount; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-bottom: 1px solid black;"></td>
					</tr>
					<tr>
						<td><strong>Total Due:</strong></td>
						
						<td style="text-align:right">
							<?php echo number_format( $sale->SaleMaster_Previous_Due + $sale->SaleMaster_DueAmount, 2, '.', '') ;?>
						
						</td>
					</tr>
				</table>
			</div>
			<div class="col-xs-4">
				<table style="width: 100%">
					<tr>
						<td><strong>Sub Total:</strong></td>
						<td style="text-align:right"> <?= $sale->SaleMaster_SubTotalAmount ?> </td>
					</tr>
					<tr>
						<td><strong>VAT:</strong></td>
						<td style="text-align:right"> <?= $sale->SaleMaster_TaxAmount ?> </td>
					</tr>
					<tr>
						<td><strong>Discount:</strong></td>
						<td style="text-align:right"> <?= $sale->SaleMaster_TotalDiscountAmount ?> </td>
					</tr>
					<tr>
						<td><strong>Transport Cost:</strong></td>
						<td style="text-align:right">  <?= $sale->SaleMaster_Freight ?> </td>
					</tr>
					<tr><td colspan="2" style="border-bottom: 1px solid black"></td></tr>
					<tr>
						<td><strong>Total:</strong></td>
						<td style="text-align:right"> <?= $sale->SaleMaster_TotalSaleAmount ?> </td>
					</tr>
					<tr>
						<td><strong>Paid:</strong></td>
						<td style="text-align:right"> <?= $sale->SaleMaster_PaidAmount ?> </td>
					</tr>
					<tr><td colspan="2" style="border-bottom: 1px solid black"></td></tr>
					<tr>
						<td><strong>Due:</strong></td>
						<td style="text-align:right"><?= $sale->SaleMaster_DueAmount ?> </td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<strong>In Word: </strong> <?php echo numberTowords($sale->SaleMaster_TotalSaleAmount); ?><br><br>
				<strong>Note: </strong>
				<p style="white-space: pre-line"><?= $sale->SaleMaster_Description ?></p>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php 
function numberTowords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
  $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
  while( $x < $count_length ) {
       $get_divider = ($x == 2) ? 10 : 100;
       $amount = floor($num % $get_divider);
       $num = floor($num / $get_divider);
       $x += $get_divider == 10 ? 1 : 2;
       if ($amount) {
         $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
         $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
         $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
         '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
         '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
         }else $string[] = null;
       }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Taka' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Taka ' : '') . $get_paise;
}


?>
<script>
	function printContent() {
		let printArea = document.getElementById("printContext").innerHTML;
		var originalData = document.body.innerHTML;
		document.body.innerHTML =`<html><head><title></title>
			<style>
				html, body{
					width:500px !important;
					float: left !important;
				}
				body, table{
					font-size: 13px;
				}
				#new-invoice{
					page-break-before: always;
				}
				
			</style>
			</head>
		<body>${printArea}</body>`;
		window.print();
		document.body.innerHTML = originalData;
	}
</script>