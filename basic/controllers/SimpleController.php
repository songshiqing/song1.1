<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\Number;
use yii\data\Pagination;

class SimpleController extends Controller
{
    public $enableCsrfValidation = false;
	//非法登录
	public function init(){
        parent::init();
        $session =\YII::$app->session;
        if(empty($session->has('name'))){
			// echo "存在name";die;
	      $this->redirect(array('/site/index'));
        }
    }
    //首页展示
    public function actionShow()
    {
        return $this->renderPartial('index.html');
    }
    //添加
    public function actionAdd()
    {
        return $this->renderPartial('compose.html');
    }
    //增add
	public function actionAdd2(){
		$request=\YII::$app->request;
		$name=$request->post('name');
		$pass=$request->post('pass');
		$content=$request->post('content');
		$db=\Yii::$app->db;
		$arr=$db->createCommand()->insert('number', [
               'number' => $name,
               'pass' => md5($pass),
               'content'=> $content,
         ])->execute();
		 // $number=new Number;
		 // $number->validate();
		 // if($number->hasErrors()){
			
			if($arr){
			 $this->redirect(array('/simple/list'));
		    }else{
		     echo "<script>alert('添加失败');window.history.go(-1);</script>";
		    }
		 // }else{
		   // echo "<script>alert('data is error');window.history.go(-1);</script>"; 
		 // }
		 
	}
	//列表
	public function actionList(){
		// echo "list";die;
		$query = Number::find();

        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $query->count(),
        ]);

        $lst = $query->orderBy('number')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->renderPartial('list', [
            'lst' => $lst,
            'pagination' => $pagination,
        ]);
	}
	//删除
	public function actionDelete(){
		// echo 'delete';die;
		$id = \Yii::$app->request->get('id');
        $re = \Yii::$app->db->createCommand()->delete('number', "id = $id")->execute();
        if($re){
			 $this->redirect(array('/simple/list'));
        }else{
            echo "<script>alert('删除失败');window.history.go(-1);</script>";
        }
	}
	//修改 action1
	public function actionUpdate(){
		$id = \Yii::$app->request->get('id');
        $arr = \Yii::$app->db->createCommand("SELECT * FROM `number` WHERE id=$id")->queryOne();
        return $this->renderPartial('update',['arr'=>$arr]);
  
	}
	//修改 action2
	public function actionUpdate_pro(){
		echo "1234";die;
		// $id = \Yii::$app->request->post('id');
        // $user_name = \Yii::$app->request->post('a_name');
        // $user_pwd = \Yii::$app->request->post('a_pwd');
        // $user_pwd = \Yii::$app->request->post('a_pwd');
        // $re = \Yii::$app->db->createCommand()->update('number', ['number' => $user_name,'pass'=> $user_pwd],'content'=> $content], "id = $id")->execute();
        // if($re){
           
        // }else{

        // }
    }
}


