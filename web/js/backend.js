let csv = []
let csvRow = []
let csvHeader = []
let reportHeaders = [
        { name: "DateTime" },
        { name: "Router IP" },
        { name: "User" },
        { name: "Protocol" },
        { name: "Mac" },
        { name: "Src IP" },
        { name: "Port" },
        { name: "Destination IP" },
        { name: "Port" },
        { name: "NAT IP" },
        { name: "Port" }
    ];

let limit = 50;
let offset = 0;
let reportType = '';

//document.addEventListener('contextmenu', event => event.preventDefault());

$(document).ready(function(){
	const queryString = window.location.search;
	
	if(queryString.includes('syslog/index')){
	   generateLogData();
	}
	
	if(queryString.includes('dashboard/index') || queryString.includes('dashboard%2Findex')){
	   getUserCount();
	}
	
    $(".js_limit_change").change(function(){
		limit = $(this).val();
		offset = 0;
		$(".js_page_no").val(offset);
		generateLogData();
	});
	
	$(".js_router_change").change(function(){
		generateLogData();
	});
	
	$('.js_search_btn').click(function(){
	    commonSearch('search');
	});
	
	$(".js_searching").keyup(function(){
		var search_value = $(this).val();
		if(search_value.length > 2 || search_value.length === 0){
		   generateLogData();
		}
	});
	
    $('.js_report_csv').click(function(){
		reportType = 'csv';
		commonSearch('csv');
	});
	
    $('.js_report_excel').click(function(){
		reportType = 'xlsx';
		commonSearch('xlsx');
	});
	
	
	$('.js_report_pdf').click(function(){
		reportType = 'pdf';
		commonSearch('pdf');
	});
	
	
	
	
	$(".global_search").keypress(function(event){
		if (event.key === "Enter") {
			// Cancel the default action, if needed
			event.preventDefault();
			var search_value = $(this).val();
			if(search_value.length > 2){
		        window.location = base_url+'/?r=syslog/index&search='+search_value;
			}else{
				alert('Please enter at least 3 characters');
			}
	    }
	});
	
	$(".global_search_btn").click(function(){
		var search_value = $('.global_search').val();
		if(search_value.length > 2){
			window.location = base_url+'/?r=syslog/index&search='+search_value;
			//window.location = 'http://localhost/logserver/?r=syslog/index&search='+search_value;
		}else{
			alert('Please enter at least 3 characters');
		}
	});
	
	$(".remove").click(function(){
		var id = $(this).data('id');
		if(id){
			if (confirm("Are you sure you want to delete this user?") == true) {
			    window.location = base_url+'/?r=users/delete&id='+id;
			}
		}
	});
	
	$(".delete_download_file").click(function(){
		var id = $(this).data('id');
		if(id){
			if (confirm("Are you sure you want to delete this download request file?") == true) {
			    window.location = base_url+'/?r=report-backup%2Fdelete&id='+id;
			}
		}
	});
	
	$(".close-alert").click(function(){
		$("#myModal-alert").hide();
	});
	
	$(".js_pagination").click(function(){
		let action = $(this).data('action');
		
		if(action == 'next'){
		   offset = parseInt(offset)+ parseInt(1);
		}else{
		   offset = parseInt(offset) - parseInt(1);
		}
		$(".js_page_no").val(offset);
		generateLogData();
	});
	
	$(".js_page_no").change(function(){
		offset = $(this).val();
		limitCount= 10;
		generateLogData();
	});
	
	
	
	$('.js_voter_search').click(function(){
		reportType = 'pdf';
		generateVoterData('pdf');
	});
});


function commonSearch(type)
{
	var long_date_start = $('.js_date_start').val();
	var long_date_end = $('.js_date_end').val();
	
	
	if(long_date_start && long_date_end){
	
		var dateStartMyArray1 = long_date_start.split("T");
		var dateStartMyArray2 = dateStartMyArray1[1].split(":");
		
		var date_start = dateStartMyArray1[0];
		var from_hours = dateStartMyArray2[0];
		var from_mins = dateStartMyArray2[1];
		
		
		var dateEndMyArray1 = long_date_end.split("T");
		var dateEndMyArray2 = dateEndMyArray1[1].split(":");
		
		var date_end = dateEndMyArray1[0];
		var to_hours = dateEndMyArray2[0];
		var to_mins = dateEndMyArray2[1];
		
		if(long_date_start && long_date_end && date_start && date_end && from_hours && from_mins && to_hours && to_mins){
			
			var user = $('.user').val();
			var mac = $('.mac').val();
			var src_ip = $('.srcip').val();
			var dst_ip = $('.dstip').val();
			var nat_ip = $('.natip').val();			
			let user_validation = true;
			let mac_validation = true;
			let src_validation = true;
			let dst_validation = true;
			let nat_validation = true;
			
			if(mac){
				if (mac.includes(':')) { 
					let mac_count = mac.split(':').length - 1;
					if(mac_count === 5){
						mac_validation = true;
				    }else{
						mac_validation = false;
						alert("Please search by valid Mac address");
					}
				}else{
					mac_validation = false;
				    alert("Please search by valid Mac address");
				}
			}
			/*
			if(src_ip){
				if (src_ip.includes('.')) { 
					let IP_count = src_ip.split('.').length - 1;
					if(IP_count === 3){
						src_validation = true;
				    }else{
						src_validation = false;
						alert("Please search by valid src ip");
					}
				}else{
					src_validation = false;
				    alert("Please search by valid src ip");
				}
			}
			
			if(dst_ip){
				if (dst_ip.includes('.')) { 
					let IP_count = dst_ip.split('.').length - 1;
					if(IP_count === 3){
						dst_validation = true;
				    }else{
						dst_validation = false;
						alert("Please search by valid dst ip");
					}
				}else{
					dst_validation = false;
				    alert("Please search by valid dst ip");
				}
			}
			*/
			
			if(nat_ip){
				if (nat_ip.includes('.')) { 
					let IP_count = nat_ip.split('.').length - 1;
					if(IP_count === 3){
						nat_validation = true;
				    }else{
						nat_validation = false;
						alert("Please search by valid nat ip");
					}
				}else{
					nat_validation = false;
				    alert("Please search by valid nat ip");
				}
			}
			
			//if(user){
				//if (user.includes(':') || user.includes('.')) {
					//user_validation = false;
				    //alert("Please search by valid user");
				//}
			//}
			
			
			
			if(user_validation && mac_validation && src_validation && dst_validation && nat_validation){
				if(type === 'search'){
					generateLogData();
				}else{
					var day_duration = days_between(long_date_start, long_date_end);
					if(type == 'pdf'){
						if(day_duration['diffDays'] == 0 && day_duration['diffHrs']  <= 5){
							generateLogData(type);
						}else{
							alert('You can able to download PDF report for maximum 5 hours');
						}
					}else{
						if(day_duration['diffDays']  <= 1){
							generateLogData(type);
						}else{
							alert('You can able to download CSV/Excel report for maximum 24 hours');
						}
					}
				}
		    }
		}else{
			alert('Please select From Date-Time and To Date-Time');
		}
	}else{
		alert('Please select From Date-Time and To Date-Time');
	}
}


function days_between1(date1, date2) {

    var date1 = new Date(date1); 
    var date2 = new Date(date2); 
      
    // To calculate the time difference of two dates 
    var Difference_In_Time = date2.getTime() - date1.getTime(); 
      
    // To calculate the no. of days between two dates 
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
	
	return Difference_In_Days;

}


function days_between(date1, date2)
{
	var date1 = new Date(date1); 
    var date2 = new Date(date2);
	var diffMs = (date2 - date1); // milliseconds between now & Christmas
	var diffDays = Math.floor(diffMs / 86400000); // days
	var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
	var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
	
	var days_duration = [];
	days_duration['diffDays'] = diffDays;
	days_duration['diffHrs'] = diffHrs;
	
	return days_duration;
}

function getPostParams()
{
	var search_value = $('.js_searching').val();

	var long_date_start = $('.js_date_start').val();
	var long_date_end = $('.js_date_end').val();
	
	var date_start = '';
	var from_hours = '';
	var from_mins = '';
	
	var date_end = '';
	var to_hours = '';
	var to_mins = '';
	if(long_date_start && long_date_end){
		var dateStartMyArray1 = long_date_start.split("T");
		var dateStartMyArray2 = dateStartMyArray1[1].split(":");
		
		date_start = dateStartMyArray1[0];
		from_hours = dateStartMyArray2[0];
		from_mins = dateStartMyArray2[1];
		
		var dateEndMyArray1 = long_date_end.split("T");
		var dateEndMyArray2 = dateEndMyArray1[1].split(":");
		
		date_end = dateEndMyArray1[0];
		to_hours = dateEndMyArray2[0];
		to_mins = dateEndMyArray2[1];
	}
	
	var user = $('.user').val();
	var mac = $('.mac').val();
	var src_ip = $('.srcip').val();
	var dst_ip = $('.dstip').val();
	var nat_ip = $('.natip').val();
	
	var src_port = $('.srcport').val();
	var dst_port = $('.dstport').val();
	var nat_port = $('.natport').val();
	
	var router = $('.js_router').val();
	var page_name = $('.js_page_name').val();

	return {page_name:page_name, report_type:reportType, offset:offset, limit:limit, search:search_value, from_date:date_start, to_date:date_end, from_hours:from_hours, from_mins:from_mins, to_hours:to_hours, to_mins:to_mins, router:router, user:user, mac:mac, src_ip:src_ip, dst_ip:dst_ip, nat_ip:nat_ip, src_port:src_port, dst_port:dst_port, nat_port:nat_port};
}

function generateVoterData(type=false)
{
	$('.data-render').html('<tr><td style="color:#FF0000">Loading......</td></tr>');
	if(type){
	    $('.js-report-loading').html('<tr><td style="color:#FF0000; font-size:21px;">Loading......</td></tr>');
	}
	$.ajax({  
		url: base_url+'/?r=api/get',
		type: 'POST',
        dataType: 'JSON',
        data:{page:'home'},		
		success: function(response) {   
			if(response.voters && response.voters.length > 0){
				pdfPrintVote(response.voters);
			}else{
				alert('No data found!');
			}				
		}  
	});  
	
}

function generateLogData(type=false)
{
	$('.data-render').html('<tr><td style="color:#FF0000">Loading......</td></tr>');
	if(type){
	    $('.js-report-loading').html('<tr><td style="color:#FF0000; font-size:21px;">Loading......</td></tr>');
	}
	$.ajax({  
		url: base_url+'/?r=elastic/get',
		type: 'POST',
        dataType: 'JSON',
        data:getPostParams(),		
		success: function(response) {   
            console.log(response.data.length);
			if(response.data && response.data.length > 0){
				let tr = '';
				$.each( response.data, function( key, value ) {
					if(value['status']){
						tr += '<tr>'+
									'<td class="digits">'+value['datetime']+'</td>'+
									'<td class="digits">'+value['host']+'</td>'+
									'<td class="digits">'+value['user']+'</td>'+
									'<td class="digits">'+value['protocol']+'</td>'+
									'<td class="digits">'+value['mac']+'</td>'+
									'<td class="digits">'+value['src_ip']+'</td>'+
									'<td class="digits">'+value['src_port']+'</td>'+
									'<td class="digits">'+value['destination_ip']+'</td>'+
									'<td class="digits">'+value['destination_port']+'</td>'+
									'<td class="digits">'+value['nat_ip']+'</td>'+
									'<td class="digits">'+value['nat_port']+'</td>'+
								'</tr>';
					}
				});
			
				if(tr){
					$('.data-render').html(tr);
				}else{
					$('.data-render').html('<tr><td style="color:#FF0000">No data found!</td></tr>');
					if(type){
					    $('.js-report-loading').html('');
					}
				}
				
				if((type == 'csv') || (type == 'xlsx') || (type == 'pdf')){
					if(response.report_status || (response.data.length > 3000)){
						$('.js-report-loading').html('');
						
						if(response.process == 'yes'){
						   alert('Your report generate data limitation have already exceed. So, Need some time to generate report. You will get it later in download report page.');
						}else{
							alert('You have already a pending/processing request. So please try again later for further request.');
						}
					}else{
						if(type == 'csv'){
							generateReport(response.data);
						}else if(type == 'xlsx'){
							excelReport(response.data);
						}else if(type == 'pdf'){
							pdfPrint(response.data);
						}
					}
				}else{
					/*if(response.data.length === 10000){
						alert('Your searching data limitation have already exceed. So, Please add any one filtering option (Mac, Src IP, User, NAT, DST IP).');
					}*/
				}
			}else{
				alert('No data found!');
                $('.data-render').html('<tr><td style="color:#FF0000">No data found!</td></tr>');
				if((type == 'csv') || (type == 'xlsx') || (type == 'pdf')){
					$('.js-report-loading').html('');
				}
			}				
		}  
	});  
	
}



function generateReport(data){
	
	var date_start = $('.js_date_start').val();
	var date_end = $('.js_date_end').val();
	
	
	csvTitle = [];
	csvTitle.push(company_name+' Log Report');
	csv.push(csvTitle.join(","));
	
	csvTitle = [];
	csvTitle.push('License Number: '+license_number);
	csv.push(csvTitle.join(","));
	
	csvTitle = [];
	csvTitle.push('Address: '+company_address);
	csv.push(csvTitle.join(","));
	
	csvTitle = [];
	csvTitle.push('Phone Number: '+company_phone);
	csv.push(csvTitle.join(","));
	
	csvTitle = [];
	
	if(date_start && date_end){
	    csvTitle.push('Log Report: '+date_start+' to '+date_end);
	}else{
		csvTitle.push('Log Report:');
	}
	csv.push(csvTitle.join(","));
	
	if(csvHeader.length == 0){
		reportHeaders.forEach((header) => {
			csvHeader.push(header.name);
		});
		csv.push(csvHeader.join(","));
	}
	
    csvTitle = [];
	csvTitle.push(' ');
	csv.push(csvTitle.join(","));
	
	
	$.each( data, function( key, value ) {
		//csvRow.push(key+1);
		csvRow.push(value['datetime']);
		csvRow.push(value['host']);
		csvRow.push(value['user']);
		csvRow.push(value['protocol']);
		csvRow.push(value['mac']);
		csvRow.push(value['src_ip']);
		csvRow.push(value['src_port']);
		csvRow.push(value['destination_ip']);
		csvRow.push(value['destination_port']);
		csvRow.push(value['nat_ip']);
		csvRow.push(value['nat_port']);
		
		csv.push(csvRow.map(str => `"${str}"`).join(","));
		csvRow = []
	});
	$('.js-report-loading').html('');
	let blob = new Blob([csv.join("\n")],{type:"text/csv"})
	let download = document.createElement("a")
	var date = new Date().toLocaleString('en-US')+'-'+Math.floor(Math.random() * 100000);
	download.download = company_name+"_LogReport_" + date;
	download.href = URL.createObjectURL(blob);
	download.click();
	csv = [];
	csvRow = [];
	csvHeader = [];  
}


function pdfPrintVote(pdfData) {
	
	let tr = '';
	$.each(pdfData, function( key, value ) {
		tr += '<tr>'+
					'<td class="digits">'+value['company']+'</td>'+
					'<td class="digits">'+value['name']+'</td>'+
					'<td class="digits">'+value['ispab_member']+'</td>'+
					'<td class="digits">'+value['mobile1']+'</td>'+
					'<td class="digits">'+value['email']+'</td>'+
					'<td class="digits">'+value['thana']+'</td>'+
					'<td class="digits">'+value['district']+'</td>'+
					'<td class="digits">'+value['address']+'</td>'+
				'</tr>';
	});
	
	var pdfBodyContent = '<style type="text/css" media="print">@page { size: landscape; }</style>'+
								'<table class="table table-bordernone">'+
									'<thead>'+
										'<tr>'+
											'<th scope="col">DateTime</th>'+
											'<th scope="col">Router IP</th>'+
											'<th scope="col">User</th>'+
											'<th scope="col">Protocol</th>'+
											'<th scope="col">Mac</th>'+
											'<th scope="col">Src IP</th>'+
											'<th scope="col">Port</th>'+
											'<th scope="col">Dst IP</th>'+
										'</tr>'+
									'</thead>'+
									'<tbody class="data-render2">'+tr+'</tbody>'+
								'</table>';
	
	
				 //document.getElementById("table-data").innerHTML = pdfBodyContent;
				
	var date_start = $('.js_date_start').val();
	var date_end = $('.js_date_end').val();
	
	//var divContents = document.getElementById("table-data").innerHTML;
	var a = window.open('', '');
	a.document.write('<html><style>table{border-collapse: collapse;} table, td, th{border:1px solid #000000 !important; padding:2px !important;}</style>');
	a.document.write('<body ><h1>'+company_name+' Log Report</h1><br>');
	a.document.write('<p>License Number: '+license_number+'</p>');
	a.document.write('<p>Address: '+company_address+'</p>');
	a.document.write('<p>Phone Number: '+company_phone+'</p>');
	if(date_start && date_end){
	    a.document.write('<p>Log Report: '+date_start+' to '+date_end+'</p>');
	}else{
		a.document.write('<p>Log Report:</p>');
	}
	a.document.write('<br>');
	a.document.write(pdfBodyContent);
	a.document.write('</body></html>');
	a.document.close();
	$('.js-report-loading').html('');
	a.print();
}



function pdfPrint(pdfData) {
	
	let tr = '';
	$.each(pdfData, function( key, value ) {
		tr += '<tr>'+
					'<td class="digits">'+value['datetime']+'</td>'+
					'<td class="digits">'+value['host']+'</td>'+
					'<td class="digits">'+value['user']+'</td>'+
					'<td class="digits">'+value['protocol']+'</td>'+
					'<td class="digits">'+value['mac']+'</td>'+
					'<td class="digits">'+value['src_ip']+'</td>'+
					'<td class="digits">'+value['src_port']+'</td>'+
					'<td class="digits">'+value['destination_ip']+'</td>'+
					'<td class="digits">'+value['destination_port']+'</td>'+
					'<td class="digits">'+value['nat_ip']+'</td>'+
					'<td class="digits">'+value['nat_port']+'</td>'+
				'</tr>';
	});
	
	var pdfBodyContent = '<style type="text/css" media="print">@page { size: landscape; }</style>'+
								'<table class="table table-bordernone">'+
									'<thead>'+
										'<tr>'+
											'<th scope="col">DateTime</th>'+
											'<th scope="col">Router IP</th>'+
											'<th scope="col">User</th>'+
											'<th scope="col">Protocol</th>'+
											'<th scope="col">Mac</th>'+
											'<th scope="col">Src IP</th>'+
											'<th scope="col">Port</th>'+
											'<th scope="col">Dst IP</th>'+
											'<th scope="col">Port</th>'+
											'<th scope="col">NAT IP</th>'+
											'<th scope="col">Port</th>'+
										'</tr>'+
									'</thead>'+
									'<tbody class="data-render2">'+tr+'</tbody>'+
								'</table>';
	
	
				 //document.getElementById("table-data").innerHTML = pdfBodyContent;
				
	var date_start = $('.js_date_start').val();
	var date_end = $('.js_date_end').val();
	
	//var divContents = document.getElementById("table-data").innerHTML;
	var a = window.open('', '');
	a.document.write('<html><style>table{border-collapse: collapse;} table, td, th{border:1px solid #000000 !important; padding:2px !important;}</style>');
	a.document.write('<body ><h1>'+company_name+' Log Report</h1><br>');
	a.document.write('<p>License Number: '+license_number+'</p>');
	a.document.write('<p>Address: '+company_address+'</p>');
	a.document.write('<p>Phone Number: '+company_phone+'</p>');
	if(date_start && date_end){
	    a.document.write('<p>Log Report: '+date_start+' to '+date_end+'</p>');
	}else{
		a.document.write('<p>Log Report:</p>');
	}
	a.document.write('<br>');
	a.document.write(pdfBodyContent);
	a.document.write('</body></html>');
	a.document.close();
	$('.js-report-loading').html('');
	a.print();
}


function excelReport(data) {
	final_data = [];
	excelRow = [];
	excelHeader = [];
	
	var date_start = $('.js_date_start').val();
	var date_end = $('.js_date_end').val();
	
	
	csvTitle = [];
	csvTitle.push(company_name+' Log Report');
	final_data.push(csvTitle);
	
	csvTitle = [];
	csvTitle.push('License Number: '+license_number);
	final_data.push(csvTitle);
	
	csvTitle = [];
	csvTitle.push('Address: '+company_address);
	final_data.push(csvTitle);
	
	csvTitle = [];
	csvTitle.push('Phone Number: '+company_phone);
	final_data.push(csvTitle);
	
	csvTitle = [];
	
	if(date_start && date_end){
	    csvTitle.push('Log Report: '+date_start+' to '+date_end);
	}else{
		csvTitle.push('Log Report:');
	}
	final_data.push(csvTitle);
	
	csvTitle = [];
	csvTitle.push(' ');
	final_data.push(csvTitle);
	
	
	
	
	if(excelHeader.length == 0){
		reportHeaders.forEach((header) => {
			excelHeader.push(header.name);
		});
		final_data.push(excelHeader);
	}
	
	$.each( data, function( key, value ) {
		//excelRow.push(key+1);
		excelRow.push(value['datetime']);
		excelRow.push(value['host']);
		excelRow.push(value['user']);
		excelRow.push(value['protocol']);
		excelRow.push(value['mac']);
		excelRow.push(value['src_ip']);
		excelRow.push(value['src_port']);
		excelRow.push(value['destination_ip']);
		excelRow.push(value['destination_port']);
		excelRow.push(value['nat_ip']);
		excelRow.push(value['nat_port']);
		final_data.push(excelRow);
		excelRow = []
	});
	$('.js-report-loading').html('');				
	  // (C2) CREATE NEW EXCEL "FILE"
	var workbook = XLSX.utils.book_new(),
	worksheet = XLSX.utils.aoa_to_sheet(final_data);
	workbook.SheetNames.push("First");
	workbook.Sheets["First"] = worksheet;

	  // (C3) "FORCE DOWNLOAD" XLSX FILE
	var date = new Date().toLocaleString('en-US')+'-'+Math.floor(Math.random() * 100000);
	XLSX.writeFile(workbook, company_name+"_LogReport_" + date +".xlsx");
}



function getUserCount()
{
	$.ajax({  
		url: base_url+'/?r=api/user',
		type: 'POST',
        dataType: 'JSON',
        data:{page:'dashboard'},		
		success: function(response) { 
		    $(".js-user-counter").text(response.active_user_count);
			if(response.alert){
			    $(".alert-msg").html(response.alert_msg);
			    $("#myModal-alert").show();
			}
		}  
	});  
	
}