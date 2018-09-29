<?php
/*
快递查询类
@author：leafrainy
@2018年09月29日
@notice：ickd.cn家的非官方接口 
@食用方式：

@接口方式
$g = new kuaiDiApi();
$g->getContent("快递单号");

@自我发挥方式
使用下面的链接自行编写
https://biz.trace.ickd.cn/auto/快递单号
*/

namespace kuaiDi;

class kuaiDiApi{

	//快递单号
	private $no = "";


	public function __consruct($no){
		$this->no = $no;
	}


	//TODO 加持html
	public function getContent($no){
		$data = $this->getData($no);

		return $data;
	}


	//返回结果
	private function getData($no){
		$data =  $this->get("https://biz.trace.ickd.cn/auto/".$no);
		$dataArr = json_decode($data,true);

		if($dataArr['status'] == 3 && $dataArr['errCode'] == 0 ){
			$info['name'] = $dataArr['expTextName'];
			$info['mailNo'] = $dataArr['mailNo'];
			$info['tel'] = $dataArr['tel'];
			$info['content'] = array_reverse($dataArr['data']);
			$info['code'] = 1;

		}else{
			$info['content'] = "暂未查到信息，请稍后再试";
			$info['code'] = 0;
		}
			return $info;
	}


	//get请求数据
	private function get($url, $timeoutMs = 3000) {
        $options = array(
            CURLOPT_URL                 => $url,
            CURLOPT_RETURNTRANSFER      => TRUE,
            CURLOPT_HEADER              => 0,
            CURLOPT_CONNECTTIMEOUT_MS   => $timeoutMs,
        );
        $ch = curl_init();
        curl_setopt_array( $ch, $options);
        $rs = curl_exec($ch);
        curl_close($ch);
        return $rs;
    }

}

?>