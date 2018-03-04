<!doctype html>
<?php
setcookie('cmd_sort',$_GET['sort'],time()+600);
?>
<html>
<head>
<meta charset="utf-8">
<title>商品展示</title>
<style>
* {
	margin: 0;
	padding: 0;
	
}
	body{
		position: relative;
		background-color:rgb(246,246,246);
	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
var curPage = 1; //当前页码
var total,pageSize,totalPage;
//获取数据
function getData(page){ 
	$.ajax({
		url: 'pages.php',
		type: 'POST',
		data: {'pageNum':page-1},
		dataType:'json',
		beforeSend:function(){
			$("#list ul").append("<li id='loading'>loading...</li>");
		},
		success:function(json){
			$("#list ul").empty();
			total = json.total; //总记录数
			pageSize = json.pageSize; //每页显示条数
			curPage = page; //当前页
			totalPage = json.totalPage; //总页数
			var li = "";
			var list = json.list;
			$.each(list,function(index,array){ //遍历json数据列
				li += "<div style=\"float:left;margin:10px\"><a href='commodity_detail?cmd_id="+array['commodity_id']+"'><img src='"+array['image_url']+"' width=\"300px\" height=\"400px\">"+"<br/>"+array['commodity_name']+"</a><br/> ￥"+array['commodity_price']+"</div>";
			});
			$("#list ul").append(li);
		},
		complete:function(){ //生成分页条
			getPageBar();
		},
		error:function(){
			alert("数据加载失败");
		}
	});
}

//获取分页条
function getPageBar(){
	//页码大于最大页数
	if(curPage>totalPage) curPage=totalPage;
	//页码小于1
	if(curPage<1) curPage=1;
	pageStr = "<span>共"+total+"条</span><span>"+curPage+"/"+totalPage+"</span>";
	
	//如果是第一页
	if(curPage==1){
		pageStr += "<span>首页</span><span>上一页</span>";
	}else{
		pageStr += "<span><a href='javascript:void(0)' rel='1'>首页</a></span><span><a href='javascript:void(0)' rel='"+(curPage-1)+"'>上一页</a></span>";
	}
	
	//如果是最后页
	if(curPage>=totalPage){
		pageStr += "<span>下一页</span><span>尾页</span>";
	}else{
		pageStr += "<span><a href='javascript:void(0)' rel='"+(parseInt(curPage)+1)+"'>下一页</a></span><span><a href='javascript:void(0)' rel='"+totalPage+"'>尾页</a></span>";
	}
		
	$("#pagecount").html(pageStr);
}

$(function(){
	getData(1);
	$("#pagecount span a").live('click',function(){
		var rel = $(this).attr("rel");
		if(rel){
			getData(rel);
		}
	});
});
</script>
</head>

<body>
	
<div id="main" style="height: 200px;z-index: 1;"><!--此处为分页栏 数据加载成功后显示 还没加css美化-->
	<div id="list"><ul></ul></div>
	<div id="pagecount" style="clear:both;"></div>
</div>
</body>
</html>
