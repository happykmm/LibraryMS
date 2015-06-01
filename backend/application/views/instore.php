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
  <link rel="stylesheet" href="/css/nicefileinput.css">
	<link rel="stylesheet" href="/css/console.css" >
  <link rel="stylesheet" href="/css/instore.css">
</head>
<body>
	<?php include("console.php") ?>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="row">
        <h3>图书入库</h3>
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
                </tr>
              </thead>
              <tbody id="tbody-import">
                <tr>
                  <td><input id="add-isbn" class="form-control" type="text"></td>
                  <td><input id="add-cate" class="form-control" type="text"></td>
                  <td><input id="add-name" class="form-control" type="text"></td>
                  <td><input id="add-press" class="form-control" type="text"></td>
                  <td><input id="add-year" class="form-control" type="text"></td>
                  <td><input id="add-author" class="form-control" type="text"></td>
                  <td><input id="add-price" class="form-control" type="text"></td>
                  <td><input id="add-amount" class="form-control" type="text"></td>
                </tr>
              </tbody>
            </table>
        </div>
        <a id="add-button" class="btn btn-default" href="javascript:void(0)" role="button">添加</a>
      </div>
      <div id="plrk" class="row">
        <h3>批量入库</h3>
        <div id="upload-file-wrap">
          <input id="upload-file"  type="file" class="nice">
        </div>
        <div id="upload-button-wrap">
          <a id="upload-button" class="btn btn-default" href="javascript:void(0)" role="button">上传</a>
        </div>
        <div class="notice">
          <p>注：支持UTF-8编码的文本文件</p>
        </div>
        
      </div>
    </div>
    
	  <script src="/js/jquery.js"></script>
    <script src="/js/jquery.nicefileinput.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    	var active = '<?= basename(__FILE__,".php") ?>';
    </script>
    <script src="/js/console.js"></script>
    <script src="/js/instore.js"></script>
</body>
</html>