<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use frontend\models\OrderPay;
use frontend\models\OrderPs;
use yii\db\Exception;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $addresses = Address::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        $goods = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        //配送方式
        $pss = OrderPs::find()->all();
        //支付方式
        $pays = OrderPay::find()->all();
        return $this->render('index',['addresses'=>$addresses,'goods'=>$goods,'pss'=>$pss,'pays'=>$pays]);
    }

    //添加订单
    public function actionAdd(){
        $order = new Order();
        if($order->load(\Yii::$app->request->post()) ){
            $address = Address::findOne(['id'=>$order->address]);
//            var_dump($order->address);exit;
            $order->member_id=\Yii::$app->user->id;
            $order->name=$address->name;
            $order->province_name=$address->province;
            $order->city_name=$address->city;
            $order->area_name=$address->area;
            $order->detail_address=$address->site;
            $order->tel=$address->tel;
            if($order->validate()){
                $order->delivery_name=Order::$method[$order->delivery_id]['name'];
                $order->delivery_price=Order::$method[$order->delivery_id]['price'];

                $order->pay_type_name = Order::$pays[$order->pay_type_id]['name'];
                $order->trode_no=(string)rand(100000,999999);
                $order->status=1;
                $order->create_time=time();
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $order->save();
                    //var_dump($order->getErrors());exit;
                    $carts = Cart::find()->where(['member_id' => $order->member_id])->all();
                    foreach ($carts as $cart) {
                        $detail = new OrderDetail();
                        $detail->order_info_id = $order->id;
                        $detail->goods_id = $cart->goods_id;
                        $detail->goods_name = $cart->goodson->name;
                        $detail->logo = $cart->goodson->logo;
                        $detail->price = $cart->goodson->shop_price;
                        $detail->amount = $cart->amount;
                        $detail->total_price = $detail->price * $detail->amount;
                        if($cart->amount > $cart->goodson->stock){
                            throw new Exception('商品'.$cart->goodson->name.'的库存不足');
                        }
                        $detail->save();
                        //var_dump($detail->getErrors());exit;
                        $goods = Goods::find()->where(['goods_category_id'=>$detail->goods_id])->all();
                        var_dump($goods);exit;
                    }
                    $transaction->commit();
                }catch (Exception $e){
                    \Yii::$app->session->setFlash('danger',$e);
                    $transaction->rollBack();
//                    var_dump($e);exit;
                }
            }
            return $this->redirect(['/shop/index']);
        }
        return $this->render('add',['order'=>$order]);
    }

}
