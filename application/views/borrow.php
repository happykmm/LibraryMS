<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="#">

	<title>图书管理系统</title>
	<link rel="stylesheet" href="/css/init.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css" >
	<link rel="stylesheet" href="/css/console.css" >
	<link rel="stylesheet" href="/css/borrow.css">

</head>
<body>
	<?php include("console.php") ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        
      	<div class="table-responsive">
            <table class="table table-striped">
				<thead>
					<tr>
					  <th>ISBN</th>
					  <th>类别</th>
					  <th>书名</th>
					  <th>出版社</th>
					  <th>出版年份</th>
					  <th>作者</th>
					  <th>价格</th>
					  <th>总量</th>
					  <th>库存</th>
					  <th>操作</th>
					</tr>
				</thead>
				<tbody id="tbody-import">
					<tr id="search-wrap">
					  <td><input id="search-isbn" class="form-control" type="text"></td>
					  <td><input id="search-cate" class="form-control" type="text"></td>
					  <td><input id="search-name" class="form-control" type="text"></td>
					  <td><input id="search-press" class="form-control" type="text"></td>
					  <td><input id="search-year-from" class="form-control" type="text">~
					  	<input id="search-year-to" class="form-control" type="text">
					  </td>
					  <td><input id="search-author" class="form-control" type="text"></td>
					  <td><input id="search-price-from" class="form-control" type="text">~
						<input id="search-price-to" class="form-control" type="text">
					  </td>
					  <td></td>
					  <td></td>
					  <td><a id="search-button" class="btn btn-default" href="javascript:void(0)" role="button">查询</a></td>
					</tr>
				</tbody>
            </table>
        </div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">借书单确认</h4>
					</div>
					<div class="modal-body">
						<table class="table table-striped">
							<tbody>
								<tr>
									<td>ISBN</td>
									<td class="isbn"></td>
								</tr>
								<tr>
									<td>书名</td>
									<td class="name"></td>
								</tr>
								<tr>
									<td>出版社</td>
									<td class="press"></td>
								</tr>
								<tr>
									<td>作者</td>
									<td class="author"></td>
								</tr>
								<tr>
									<td>借书证号</td>
									<td><input class="form-control uid" type="text" placeholder="请输入借书证号"></td>
								</tr>
							</tbody>
						</table>
						<div>
							<span class="msgbox label label-important"></span>
							<span class="msgbox label label-success"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary submit">提交</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="detailModalLabel">书籍详情</h4>
					</div>
					<div class="modal-body">
						<table class="table table-striped">
							<tbody>
								<tr>
									<td>ISBN</td>
									<td class="isbn"></td>
								</tr>
								<tr>
									<td>书名</td>
									<td class="name"></td>
								</tr>
								<tr>
									<td>出版社</td>
									<td class="press"></td>
								</tr>
								<tr>
									<td>作者</td>
									<td class="author"></td>
								</tr>
								<tr>
									<td>库存</td>
									<td class="instore"></td>
								</tr>
								<tr>
									<td>最早归还时间</td>
									<td class="firstreturn"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
					</div>
				</div>
			</div>
		</div>

    </div>

	<script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    	var active = '<?= basename(__FILE__,".php") ?>';
    </script>
    <script src="/js/console.js"></script>
    <script src="/js/borrow.js"></script>
</body>
</html>