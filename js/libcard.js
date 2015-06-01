$(document).ready(function() {
	console.log('libcard.js is ready');

	var appendCard = function(item) {
		var id = $("<td></td>").text(item.id);
		var name = $("<td></td>").text(item.name);
		var dept = $("<td></td>").text(item.department);
		var posi = $("<td></td>").text(item.position);
		var isdel = $("<td></td>");
		var opt = $('<a class="btn btn-default" href="javascript:void(0)"></a>');
		if (item.is_del == "1") {
			isdel.text("不可用");
			opt.text("恢复");
			opt.addClass("opt-enable");
			opt.click(opt_enable);
		} else {
			isdel.text("可用");
			opt.text("删除");
			opt.addClass("opt-disable");
			opt.click(opt_disable);
		}
		opt.data("id", item.id);
		opt = $("<td></td>").append(opt);
		var tr = $("<tr></tr>").append(id,name,dept,posi,isdel,opt);
		$("#tbody-import").append(tr);
	}

	$.post("/ajax/get_libcard", {offset:0, limit:20}, function(result){
		if (result.code != 0)
			return;
		$.each(result.desc, function(i, item){
			appendCard(item);
		});
	}, "json");


	$(".opt-add").click(function() {
		var name = $("#add-name").val();
		var dept = $("#add-dept").val();
		var posi = $("#add-posi").val();
		var data = {"name":name, "dept":dept, "posi":posi};
		$.post("/ajax/add_libcard", data, function(result){
			if (result.code == 0) {
				alert("添加成功！");
				location.reload();
			} else {
				alert("添加失败：" + result.desc);
			}
		},"json");
	});

	function opt_disable(){
		var id = $(this).data("id");
		var data = {"id":id};
		$.post("/ajax/del_libcard", data, function(result){
			if (result.code == 0) {
				alert("删除成功！");
				location.reload();
			} else {
				alert("删除失败：" + result.desc);
			}
		}, "json");
	}

	function opt_enable() {
		var id = $(this).data("id");
		var data = {"id":id};
		$.post("/ajax/rec_libcard", data, function(result){
			if (result.code == 0) {
				alert("恢复成功！");
				location.reload();
			} else {
				alert("恢复失败：" + result.desc);
			}
		}, "json");
	}


});

