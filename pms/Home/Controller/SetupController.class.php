<?php
namespace Home\Controller;
use Think\Controller;
class SetupController extends Controller{
	public function randomName(){
		$nameLib = ' 邦福歌国和康澜民宁平然顺翔晏宜怡易志昂然昂雄宾白宾鸿宾实彬彬彬炳彬郁斌斌斌蔚滨海波光波鸿波峻波涛博瀚博超博达博厚博简博明博容博赡博涉博实博涛博文博学博雅博延博艺博易博裕博远才捷才才艺才英才哲才俊成和成弘成化成济成礼成龙成仁成双成天成文成业成益成荫成周承承弼承德承恩承福承基承教承平承嗣承天承望承宣承颜承业承悦承允承运承载承泽承志德本德海德厚德华德辉德惠德容德润德寿德水德馨德曜德业德义德庸德佑德宇德元德运德泽德明昂白飙掣尘沉驰光翰航翮鸿虎捷龙鸾鸣鹏扬文翔星翼';
		$nameLibNum = (int) strlen($nameLib)/3;

		$m = M('People');
		$havePeople = $m->count(1);
		while ($havePeople >= 0) {
			$havePeople--;
			if($havePeople<0) break;
			$namePos[0] = mb_strcut($nameLib, rand(0,$nameLibNum), 3 ,'utf-8');
			$namePos[1] = mb_strcut($nameLib, rand(0,$nameLibNum), 3 ,'utf-8');
			$namePos[2] = mb_strcut($nameLib, rand(0,$nameLibNum), 3 ,'utf-8');

			$newName = $namePos[0] . $namePos[1] . $namePos[2];
			$origin = $m 
						-> limit($havePeople,1) 
						// ->fetchSql()
						-> field('name,pid') 
						-> select();
			dump($origin);

			$originName = $origin[0]['name'];
			$where['pid'] = $origin[0]['pid'];

			$result = $m 
					-> where($where) 
					// -> fetchSql()
					-> setField('name',$newName);
			// dump($result);

			echo "$originName -> $newName ";
			if($result === 1){
				echo "OK <br> \n";
			} else {
				echo "X <br> \n";
			}
			
		}
	}

	public function randomId(){
		$p          = M('People');
		$e          = M('Education');
		$t          = M('Title');
		$trans      = M('Transfer');
		$last       = 'X0123456789X';
		$havePeople = $p->count(1);
		set_time_limit(0);
		while ($havePeople >= 0) {

		if($havePeople%10 == 0){
			sleep(0.2);
			ob_flush();
		}

		$havePeople--;
		if($havePeople<0) break;
		$rHead = rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
		$rLast = rand(0,9) . rand(0,9) . rand(0,9) . $last[rand(0,11)];

		$pid = $p
				->limit($havePeople,1)
				->field('pid')
				->select();
		$pid = $pid[0]['pid'];

		$newId = $rHead . substr($pid, 6, 8) . $rLast;
		// dump($newId);
		$where['pid'] = $pid;
		$resultP= $p
				// ->fetchSql()
				->where($where)
				->setField('pid',$newId);

		$resultE = $e
				// ->fetchSql()
				->where($where)
				->setField('pid',$newId);

		$resultT = $t
				// ->fetchSql()
				->where($where)
				->setField('pid',$newId);

		$resultTrans = $trans
					// ->fetchSql()
					->where($where)
					->setField('pid',$newId);
		// dump($resultP);

		echo "[{$havePeople}] ID: $pid -> $newId ,People:{$resultP} ,Education:{$resultE}, Title:{$resultT}, Transfer:{$resultTrans}. <br>\n";

		flush();
		}

	}
}