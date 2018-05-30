<?php
    include 'DiLi_db.php';
    header("Content-Type:text/html;charset=UTF-8");  
    class Crawler
    {
        private $setopt;
        private $data;
        function __construct($url)
        {
            $this->setopt = array
            (
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => True,
                CURLOPT_FOLLOWLOCATION => True
            );
        }
        function exec()
        {
            $ch = curl_init();
            curl_setopt_array($ch,$this->setopt);
            $this->data = curl_exec($ch);
            curl_close($ch);
            return $this->data;
        }
    }
    class Preg
    {
        private $data;
        private $result;
        function __construct($data)
        {
            $this->data = $data;
            $this->result = array();
        }
        function match($ptn,$i = 0)
        {
            preg_match($ptn,$this->data,$this->result);
            return $this->result[$i];
        }
        function match_all($ptn)
        {
            preg_match_all($ptn,$this->data,$this->result,PREG_PATTERN_ORDER);
            return $this->result;
        }
    }
  
    $url = 'http://www.dilidili.wang/tvdh/';
    $prefix = 'http://www.dilidili.wang';
    $anime_ptn = '/<div class="anime_list"([\s\S]+)/';
    $div_ptn = '/<dt><a href="\/.+\/"><img src="http[\s\S]+?<\/dl>/';
    $img_ptn = '/<img src="(.+)"\/>/';
    $name_ptn = '/<h3><a href=[^>]+>(.+)<\/a>/';
    $url_ptn = '/<h3><a href="(.+)">/';
    $info_ptn = '/<p><b>简介：<\/b>(.+)<\/p>/';
    //初始化并抓取url页面
    $crawl = new Crawler($url);
    $data = $crawl->exec();
    //下面匹配番剧列表模块
    $preg = new Preg($data);
    $data = $preg->match($anime_ptn,1);
    //下面匹配列表中的每一部番的模块
    $preg = new Preg($data);
    $result = $preg->match_all($div_ptn);
    //提取每一部番模块的各项信息并入库
    $servername = 'localhost';
    $username = 'root';
    $password = '0424';
    $db_name = 'DiLi';
    $sql = new DiLi_DB($servername,$username,$password);
    $link = $sql->link($db_name);
    $cnt=0;
    foreach ($result[0] as $res)
    {
        $cnt++;
        $preg = new Preg($res);
        $img_result = $preg->match($img_ptn,1);
        $name_result = $preg->match($name_ptn,1);
        $info_result = $preg->match($info_ptn,1);
        $url_result = $prefix.$preg->match($url_ptn,1);
        $sql->insert($link,$name_result,$img_result,$info_result,$url_result);
        //echo $img_result.'<br/>'.$name_result.'<br/>'.$info_result.'<br/>'.$url_result.'<br/>';
    }
    echo '爬取入库结束,共'.$cnt.'项';
?>