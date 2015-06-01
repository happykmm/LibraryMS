$(document).ready(function() {

	//请求所有书籍列表
	$.post("/ajax/get_book", {offset:0, limit:50}, function(result){
		if (result.code != 0)
			return;
		$.each(result.desc, function(i, item){
			appendBook(item);
		});
	}, "json");

	//渲染页面
	function appendBook(item) {
		var isbn   = $("<td class='isbn'></td>").text(item.isbn);
		var cate   = $("<td class='cate'></td>").text(item.category);
		var name   = $("<td class='name'></td>").text(item.name);
		var press  = $("<td class='press'></td>").text(item.press);
		var year   = $("<td class='year'></td>").text(item.year);
		var author = $("<td class='author'></td>").text(item.author);
		var price  = $("<td class='price'></td>").text(item.price);
		var amount = $("<td class='amount'></td>").text(item.amount);
		var outstore = parseInt(item.outstore);
		if (isNaN(outstore))  outstore = 0;
		//console.log("name="+item.name+" amount="+item.amount+" outstore="+outstore);
		var instore= $("<td class='instore'></td>").text(parseInt(item.amount) - outstore);
		var opt = "";
		if (instore.text() != 0) {
			opt = $('<a class="btn btn-default" href="javascript:void(0)"></a>').text("借阅");
			opt.click(opt_borrow);
		} else { //库存为零，查看最近归还时间
			opt = $('<a class="btn btn-default" href="javascript:void(0)"></a>').text("查看");
			opt.click(opt_detail);
		}
		opt.data("isbn", item.isbn);
		opt = $("<td></td>").append(opt);
		var tr = $("<tr class='result-item'></tr>").append(isbn,cate,name,press,year,author,price,amount,instore,opt);
		$("#tbody-import").append(tr);
	}

	//查书
	function searchBook(isAlert) {
		var data = {
			"isbn"      : $("#search-isbn").val(),
			"category"  : $("#search-cate").val(),
			"name"      : $("#search-name").val(),
			"press"	    : $("#search-press").val(),
			"year_from" : $("#search-year-from").val(),
			"year_to"   : $("#search-year-to").val(),
			"author"    : $("#search-author").val(),
			"price_from": $("#search-price-from").val(),
			"price_to"  : $("#search-price-to").val(),
			"offset" : 0,
			"limit"  : 50
		}
		$.post("/ajax/search_book", data, function(result){
			$("#tbody-import tr").remove(".result-item");
			if (result.code != 0) {
				console.log(result.desc);
				if (isAlert)  alert("查询失败："+result.desc);
				return;
			}
			$.each(result.desc, function(i, item){
				appendBook(item);
			});
			if (isAlert)  alert("查询成功：共"+result.desc.length+"条记录");
		}, "json");
	}

	//查书按钮
	$("#search-button").click(function(){
		searchBook(true);
	});


	//借书按钮
	function opt_borrow() {
		var sibling = $(this).parent().parent();
		var isbn   = sibling.find(".isbn").text();
		var name   = sibling.find(".name").text();
		var press  = sibling.find(".press").text();
		var author = sibling.find(".author").text();
		$("#myModal .isbn").text(isbn);
		$("#myModal .name").text(name);
		$("#myModal .press").text(press);
		$("#myModal .author").text(author);
		$("#myModal .uid").val("");
		$("#myModal .msgbox").text("");
		$("#myModal").modal('show');
	}

	//库存为零，查看最近归还时间
	function opt_detail() {
		var sibling = $(this).parent().parent();
		var isbn   = sibling.find(".isbn").text();
		var name   = sibling.find(".name").text();
		var press  = sibling.find(".press").text();
		var author = sibling.find(".author").text();
		var instore = sibling.find(".instore").text();
		$("#detailModal .isbn").text(isbn);
		$("#detailModal .name").text(name);
		$("#detailModal .press").text(press);
		$("#detailModal .author").text(author);
		$("#detailModal .instore").text(instore);
		if (instore == 0) {
			$.post("/ajax/search_record", {"isbn" : isbn}, function(result){
				console.log(result);
				var arr = result.desc.map(function(o){
					return new Date(o.borrow_time).getTime();
				});
				var min = Math.min.apply(Math, arr);
				min = new Date(min);
				min.setDate(min.getDate() + 30);
				min = min.toLocaleString();
				$("#detailModal .firstreturn").text(min);
				$("#detailModal .firstreturn").show();
				$("#detailModal").modal('show');
			},"json");
		} else {
			$("#detailModal .firstreturn").hide();
			$("#detailModal").modal('show');
		}

	}

	//借书对话框
	$("#myModal .submit").click(function() {
		var data = {
			"isbn" : $("#myModal .isbn").text(),
			"uid"  : $("#myModal .uid").val()
		}
		$.post("/ajax/borrow", data, function(result){
			if (result.code == 0) {
				$("#myModal .msgbox.label-success").text("借阅成功");
				setTimeout(function(){
					$("#myModal").modal('hide');
					searchBook();
				}, 500);
			} else {
				$("#myModal .msgbox.label-important").text("借阅失败： "+result.desc);
				setTimeout(function(){
					$("#myModal .msgbox.label-important").text("");
				}, 1000);
			}
		},"json");


	});

});