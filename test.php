<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2017-05-31 10:15:40
 * @version $Id$
 */
	$t1   = microtime();//当前 Unix 时间戳的微秒数：
	$name = "info.html";
	if (file_exists($name)) {
		$content    = file_get_contents($name);
		$test_time  = time();//返回当前时间的 Unix 时间戳
		$cache_time = file_get_contents('info_time.txt');
		$sjc		= $test_time - $cache_time;
		if ($sjc < 10) {
			echo $content;
		}else{
			create_cache();
		}//end ifelse
	}else{
		create_cache();
	}//end ifesle

	function create_cache(){
		ob_start();//打开缓冲区,当打开了缓冲区，echo后面的字符不会输出到浏览器，而是保留在服务器，直到你使用 flush或者ob_end_flush才会输出
		for ($i=0; $i < 10000; $i++) { 
			echo $i."\n";
		}
		$info      = ob_get_contents();//得到缓存区的内容并且赋值给$info
		$file      = fopen('info.html','w');//打开info.html
		$cachetime = fopen('info_time.txt','w');//"w"	写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
		fwrite($cachetime,time());
		fwrite($file,$info);//写入信息到info.txt
		fclose($cachetime);
		fclose($file);//关闭info.html
		ob_end_flush();//输出全部内容到浏览器
	}//end create_cahce

	$t2 = microtime();
	$t = $t2-$t1;
	echo "<br/><br/>".$t;