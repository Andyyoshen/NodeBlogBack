<!DOCTYPE html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<style>
		table,
		th,
		td {
			border: 1px solid black;
		}
	</style>
</head>

<body>

	<h2 id="title">HTML Forms</h2>
    <a id="clickme" href="">me</a>
	<form id="myform" action="tests.php" method="post">
		<label for="fname">ISBN</label><br>
		<input type="text" id="IisbnValueId" name="IisbnValue"><br>
		<input type="submit" value="Submit">
	</form>

</body>

<script>
    $("#clickme").click(function(event){
        event.preventDefault();
        $("#title").html("hello word");
    })
	$("#myform").submit(function(event){
		// event.preventDefault();
		console.log("asd")
	})
	// $("document").ready(function () {
		
	// 	var ISBNid = decodeURI(getQueryVariable("ISBNid"))
	// 	var Versionid = decodeURI(getQueryVariable("Versionid"))
	// 	var BookNameid = decodeURI(getQueryVariable("BookNameid"))
	// 	var Authorid = decodeURI(getQueryVariable("Authorid"))
	// 	var Priceid = decodeURI(getQueryVariable("Priceid"))
	// 	var OutDateid = decodeURI(getQueryVariable("OutDateid"))
	// 	$("#IisbnValueSpan").text(ISBNid)
	// 	$("#IisbnValueId").val(ISBNid)
	// 	$("#VersionValueId").val(Versionid)
	// 	$("#BookNameValueId").val(BookNameid)
	// 	$("#AuthorValueId").val(Authorid)
	// 	$("#PriceValueId").val(Priceid)
	// 	$("#OutDateValueId").val(OutDateid)
	// })
</script>

</html>
<?php
@$BookSort = $_POST["IisbnValue"];
echo $BookSort;
?>