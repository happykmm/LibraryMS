$(document).ready(function() {

	//渲染借书记录
	function appendRecord(item) {
		var isbn        = $("<td class='isbn'></td>").text(item.isbn);
		var uid         = $("<td class='uid'></td>").text(item.uid);
		var borrow_time = $("<td class='borrow_time'></td>").text(item.borrow_time);
		var opt = $('<a class="btn btn-default" href="javascript:void(0)"></a>').text("归还");
		opt.click(optGiveBack);
		opt.data("isbn", item.isbn);
		opt.data("uid", item.uid);
		opt = $("<td></td>").append(opt);
		var tr = $("<tr class='result-item'></tr>").append(isbn,uid,borrow_time,opt);
		$("#tbody-import").append(tr);
	}

	//查询所有借书记录
	$.post("/ajax/get_record", {}, function(result){
		if (result.code != 0)  return;
		$.each(result.desc, function(i, item){
			appendRecord(item);
		});
	},"json");


	//按条件查询借书记录
	function searchRecord(isAlert) {
		var data = {
			"isbn" : $("#isbn").val(),
			"uid"  : $("#uid").val()
		}
		console.log(data);
		$.post("/ajax/search_record", data, function(result){
			$(".result-item").remove();
			if (result.code != 0) {
				console.log(result);
				if (isAlert)
					alert("查询失败：无记录");
			} else {
				$.each(result.desc, function(i, item){
					appendRecord(item);
				});
				if (isAlert)
					alert("查询成功：共" + result.desc.length + "条记录");
			}
		}, "json");
	}


	$("#tbody-import .opt-search").click(function(){
		searchRecord(true);
	});


	//还书
	function optGiveBack() {
		var data = {
			"isbn" : $(this).data("isbn"),
			"uid"  : $(this).data("uid")
		}
		$.post("/ajax/give_back", data, function(result){
			if (result.code == 0) {
				alert("还书成功！");
				searchRecord();
			} else {
				alert("还书失败： " + result.desc);
			}
		}, "json");
	}



});
