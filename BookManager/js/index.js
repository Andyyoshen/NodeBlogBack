
	 function createCsvFile() {
			var table = $('tbody');
      var BookData = [];
      table.find('tr').each(function (i, el) {
        if (i != -1) {
          var $tds = $(this).find('td');
          var row = [];
          $tds.each(function (i, el) {
            if (i != 6) {
              if (i == 5) {
                row.push($(this).text())
              }
              else {
                row.push($(this).text());
              }
            }

          });
          BookData.push(row);
        }

      });
	  	var TodayDate = new Date();
		var fileName = `BooksManager${TodayDate.getFullYear()}-${TodayDate.getMonth()+1}-${TodayDate.getDate()}.csv`;//匯出的檔名
		var data = getRandomData(BookData);
		var blob = new Blob([data], {
			type: "application/octet-stream"
		});
		var href = URL.createObjectURL(blob);
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.href = href;
		link.download = fileName;
		link.click();
	}

	//隨機產生資料
	function getRandomData(BookData) {
		var header = "ISBN,出版社,書名,作者,定價,發行日\n";
		var data = "";
		for (var i = 0; i < BookData.length; i++) {
			for (var j = 0; j < BookData[i].length; j++) {
				if (j > 0) {
					data = data + ",";
				}
				data = data + BookData[i][j] ;
			}
			data = data + "\n";
		}
		return header + data;
	}
	$("document").ready(function () {
		// $(".DELBut2").on('click',function(event){
		// 	$("#DeleteDataId").val($(this).attr('data-id'))
		// 	$("#DeleteDataId").val($(this).parent().parent()[0].cells[0].innerHTML)
			
			$("#DeleteBookSortDataId").val(localStorage.getItem("BookSortDataId"))
			$("#DeleteSortDirectionDataId").val(localStorage.getItem("SortDirectionDataId"))
			if($("#flag").val()==""){
				$('#myForm').submit();
			}
			
			
			// })
		
		
		$('#BookSort').val(localStorage.getItem("BookSortDataId"))
		$('#SortDirection').val(localStorage.getItem("SortDirectionDataId"))
		
		$('#Bookexport').click(function () {
			createCsvFile();
		})
		$(".AddBut").click(function () {
			window.location = "http://localhost/BookManager/AddBook.php"
		})
		$(".EditBut").click(function () {
			var ISBNid = $(this).parent().parent()[0].cells[0].innerHTML
			var Versionid = $(this).parent().parent()[0].cells[1].innerHTML
			var BookNameid = $(this).parent().parent()[0].cells[2].innerHTML
			var Authorid = $(this).parent().parent()[0].cells[3].innerHTML
			var Priceid = $(this).parent().parent()[0].cells[4].innerHTML
			var OutDateid = $(this).parent().parent()[0].cells[5].innerHTML
			var BookSortid = localStorage.getItem("BookSortDataId");
			var SortDirectioiId	= localStorage.getItem("SortDirectionDataId")
			window.location = `http://localhost/BookManager/EditBook.php?
								ISBNid=${ISBNid}&
								Versionid=${Versionid}&
								BookNameid=${BookNameid}&
								Authorid=${Authorid}&
								Priceid=${Priceid}&
								OutDateid=${OutDateid}&
								BookSortid=${BookSortid}&
								SortDirectioiId=${SortDirectioiId}`
		})
		$(".DELBut").click(function () {
			 var yes = confirm('你確定要刪除嗎？');
			 if (yes) {
				$("#DeleteDataId").val($(this).parent().parent()[0].cells[0].innerHTML)
				console.log("1")
				$("#myForm").submit()
				// $("#BookSortDataId").val(localStorage.getItem("BookSortDataId"))
				// $("#SortDirectionDataId").val(localStorage.getItem("SortDirectionDataId"))
				// const SortFrom = $("#SortFrom");
				// SortFrom.submit()
			 } else {
			 	return false;
			 }		
		})
		$('#SortDirection').on('change', function () {
			var SortDirection = $('#SortDirection').val()
			var BookSort = $(this).parent().find('select[id="BookSort"]  option:selected').val()
			$("#SortDirectionDataId").val(SortDirection)
			$("#BookSortDataId").val(BookSort)
			localStorage.setItem("SortDirectionDataId", SortDirection)
			
			// localStorage.setItem("BookSortDataId", BookSort)
			const SortFrom = $("#SortFrom");
			SortFrom.submit()
		});

		$('#BookSort').on('change', function () {
			var SortDirection = $('#SortDirection').val()
			var BookSort = $(this).parent().find('select[id="BookSort"]  option:selected').val()
			$("#SortDirectionDataId").val(SortDirection)
			$("#BookSortDataId").val(BookSort)
			// localStorage.setItem("SortDirectionDataId", SortDirection)
			localStorage.setItem("BookSortDataId", BookSort)
			// console.log(localStorage.getItem("BookSortDataId"))
			const SortFrom = $("#SortFrom");
			SortFrom.submit()
		});
	})
