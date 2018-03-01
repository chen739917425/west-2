<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商品浏览</title>
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
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
var curPage = 1; //当前页码
var total,pageSize,totalPage;
//获取数据
function getData(page){ 
	$.ajax({
		type: 'POST',
		url: 'pages.php',
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
				li += "<li><a href='#'><img src='"+array['pic']+"'>"+array['title']+"</a></li>";
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
<div id="front" style="width: 100%;background-color: rgba(243,215,161,0.55);height: 65px;border-bottom-style:solid;border-bottom-color: rgba(255,184,0,0.3)"> <span style="color: rgba(232,113,35,1.00);font-size: 30px;font-family:微软雅黑;line-height: 65px;">Online Shopping.</span> </div>
<div id="ShowIdPart" style="font-size: 14px;color: orange;float: right;margin-right: 10px;margin-top: 6px;"><img src="account.png" alt="" width="20px"/><span>登陆的用户名  |</span><a style="font-size: 14px;color: orange;" href="">注销</a><span>  |  </span><a href="" style="font-size: 14px;color: orange;"><img src="cart.png" alt="" width="20px">购物车</a>
</div>
	
<div id="DivPages"><!--此处为分页栏 数据加载成功后显示 还没加css美化-->
	<div id="list"><ul></ul></div>
	<div id="pagecount"></div>
</div>
	
<div id="GoodsShow">
	<div id="card" style="margin-top:15px;margin-right:15px;color: gray;font-family: 微软雅黑;width: 200px;background: rgba(248,248,245,1.00);height: 260px;border: 1px solid #BFBFBF;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border-top-left-radius: 20px;border-top-right-radius: 20px;box-shadow: 2px 2px 3px #aaaaaa;float: left"><div style="width:66px;height: 66px;border-radius: 50%;background-color:rgba(189,163,113,1.00);margin: 20px auto;">里面放商品图片</div><div style="clear: both;border-left: 2px solid gray;margin:5px 0px;padding-left: 5px;float: left;font-size: 14px;color: gray;">商品名称<span style="padding: 40px;">example</span></div><div style="clear: both;border-left: 2px solid gray;margin:5px 0px;padding-left: 5px;float: left;font-size: 14px;color: gray;">商品价格<span style="padding: 40px;">example</span></div><div style="clear: both;border-left: 2px solid gray;margin:5px 0px;padding-left: 5px;float: left;font-size: 14px;color: gray;">      <a href="" style="padding: 40px;">加入购物车</a></div></div>	
</div>

</body>
</html>
