<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

	//加载登录页面
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
	//执行登录
    public function actionLogin()
    {
        $request=\YII::$app->request;
        $name=$request->post('username');
        $password=$request->post('p');
        $result=User::find()->where(array('u_name'=>$name,'u_pwd'=>md5($password)))->asArray()->all();
        // print_r($name);die;
        if($result){
                $session =\Yii::$app->session;
                $session->set('name',$name);
                //echo "success";die;
                $this->redirect(array('/simple/show'));
        }else{
            //echo '验证失败';
            $this->redirect(array('site/index'));
        }
    }
	//退出登录
    public function actionLogout()
    {
        $session =\Yii::$app->session;
        $name=$session->get('name');
        if($name){
            $session->remove('name');
            // $session->destroy();
            $this->redirect(array('site/index'));
        }else{
            $this->redirect(array('/simple/show'));
        }
    }

}


