function GetRowIsbn() {
	var table = $('tbody');
	var BookData = [];
	table.find('tr').each(function (i) {
		if (i != -1) {
			var $tds = $(this).find('td');
			$tds.each(function (i) {
				if (i == 1) {
					BookData.push($(this).text())
				}
				// if (i != 6) {
				// 	if (i == 5) {
				// 		row.push($(this).text())
				// 	}
				// 	else {
				// 		row.push($(this).text());
				// 	}
				// }
			});
			// BookData.push(row);
		}
	});
	return BookData;
}
document.write("<div id='tip' style='position:absolute; width:300px; z-index:1; background-color: #F1F1F1; border: 2px solid #000; overflow: visible;visibility: hidden;font-size:13px;padding:12px;'></div>")
$("document").ready(function () {
	$("tbody>tr").mouseover(function($event){
		$(this).css("background-color","#EEEEEE")
	})
	$("tbody>tr").mouseout(function($event){
		$(this).css("background-color","white")
	})
	$(".Version").mouseover(function ($event) {
		$(this).parent()[0].style.backgroundColor = "#EEEEEE"
	
		
		if ($(this).attr("data-phone") == "") {
			return false;
		}
		var x = $event.pageX+"px";
		var y = $event.pageY+"px";
		tip.innerHTML = $(this).attr("data-phone") + "<br>" + $(this).attr("data-address");
		tip.style.visibility = "visible";
		tip.style.left = x;
		tip.style.top = y;
	})
	$(".Version").mouseout(function () {
		$(this).parent()[0].style.backgroundColor = "#white"
		tip.style.innerHTML = ""
		tip.style.visibility = "hidden";
	})
	$('#LastPageAppear').mouseover(function ($event) {
		var x = $event.pageX + "px";
		var y = $event.pageY + "px";

		Pagetip.style.visibility = "visible";
		Pagetip.style.left = x;
		Pagetip.style.top = y;
	})
	$("#LastPageAppear").mouseout(function () {
		Pagetip.style.visibility = "hidden";
	})
	var ExporIsbnData = [];
	$(".CheckClass").change(function (event) {
		if (event.currentTarget.checked) {
			ExporIsbnData.push($(this).val())
			console.log(ExporIsbnData)
		}
		else {
			var index = ExporIsbnData.indexOf($(this).val());
			if (index > -1) {
				ExporIsbnData.splice(index, 1);
			}
			console.log(ExporIsbnData)
		}
	});
	$("#CheckAllId").change(function (event) {
		if (event.currentTarget.checked) {
			$('.CheckClass').prop('checked', true)
			ExporIsbnData = GetRowIsbn()
			console.log(ExporIsbnData)
			// console.log($(this).parent().parent()[0].cells[0].innerHTML)
			// console.log(ExporIsbnData)
			// alert("我被選到了");
		}
		else {
			$('.CheckClass').prop('checked', false);
			ExporIsbnData = []
			console.log(ExporIsbnData)
			// alert("我取消選取");
		}
	})
	// $('.SelectClass').on('change', function() {
	// 	alert( this.value );
	// });

	// $("#check01").change(function(event){
	// 	alert("dasdsad")
	// 	// if(event.currentTarget.checked){
	// 	// 	alert("大家好2")
	// 	// 	}
	// 	// 	else{
	// 	// 		alert("not check2")
	// 	// 	}

	// })
	$('#GoId').click(function () {
		$('#PageForm').submit()
	})



	$('#BookexportBut').click(function () {
		$('#ExportIsbnId').val(ExporIsbnData)
		$('#ExportWay').val($(".SelectClass").val())
		$('#myForm').attr("method", "post")
		$("#myForm").submit();
		$('#myForm').attr("method", "get")
	})



	$(".AddBut").click(function () {
		window.location = "AddBook.php"
	})
	$(".EditBut").click(function () {
		var ISBNid = $(this).val()
		window.location = `EditBook.php?
								ISBNid=${ISBNid}`
	})
	$(".DELBut").click(function () {
		var yes = confirm('你確定要刪除嗎？');
		if (yes) {
			// console.log($(this).parent().parent()[0].cells[1].innerHTML)
			// return false;
			$("#DeleteDataId").val($(this).parent().parent()[0].cells[1].innerHTML)
			$('#myForm').attr("method", "post")
			$("#myForm").submit();
			$('#myForm').attr("method", "get")
		} else {
			return false;
		}
	})
})
