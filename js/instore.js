$(document).ready(function(){
	console.log('instore.js is ready');

	$("#upload-file").nicefileinput({
		label : '选择文件：' 
	});

	//批量入库
	$("#upload-button").click(function() {
		var file = $("#upload-file")[0].files[0];
		readFile(file);
	});

	function readFile(file) {
		var reader = new FileReader();
		reader.onload = function(event) {
			var text = event.target.result;
			var arr = text.split("\n");
			var msg = [];
			$.each(arr, function(index, item){
				msg[index] = "第"+(index+1)+"行：";
				var tuple = $.trim(item).split(/,/);
				if (tuple.length != 8) {
					msg[index] += "格式不符合要求！";
					return;
				}
				for (i=0; i<tuple.length; i++) {
					tuple[i] =  $.trim(tuple[i]);
				}
				var data = {
					"isbn"     : tuple[0],
					"category" : tuple[1],
					"name"     : tuple[2],
					"press"    : tuple[3],
					"year"     : tuple[4],
					"author"   : tuple[5],
					"price"    : tuple[6],
					"amount"   : tuple[7]
				};
				$.post("/ajax/add_book", data, function(result){
					if (result.code == 0)
						msg[index] += "插入成功！";
					else
						msg[index] += result.desc;
					if (index == arr.length-1) {
						msg = msg.join("\n");
						msg = "批量入库结果：\n" + msg;
						alert(msg);
					}
				},"json");
			});
			
		}
		reader.readAsText(file, "UTF-8");
	}


	//单本入库
	$("#add-button").click(function() {
		var data = {
			"isbn"     : $("#add-isbn").val(),
			"category" : $("#add-cate").val(),
			"name"     : $("#add-name").val(),
			"press"    : $("#add-press").val(),
			"year"     : $("#add-year").val(),
			"author"   : $("#add-author").val(),
			"price"    : $("#add-price").val(),
			"amount"   : $("#add-amount").val()
		};
		$.post("/ajax/add_book", data, function(result){
			if (result.code == 0) {
				alert("插入成功！");
				$("#add-isbn").val("");
				$("#add-cate").val("");
				$("#add-name").val("");
				$("#add-press").val("");
				$("#add-year").val("");
				$("#add-author").val("");
				$("#add-price").val("");
				$("#add-amount").val("");
			}
			else
				alert("插入失败：" + result.desc);
		},"json");
	});

});