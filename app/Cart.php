<?php

namespace App;

class Cart
{
    //
    public  $items;
    public $totalQty   = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {

      if($oldCart){
        $this->items      = $oldCart->items;
        $this->totalQty   = $oldCart->totalQty;
        $this->totalPrice = $oldCart->totalPrice;
      }
    }


    

    public function add($item,$id)
    {
      $storedItem = ['qty' => 0,'price' => $item->sales_price,'item'=>$item];

      if($this->items){
        if(array_key_exists($id,$this->items)){
          $storedItem =  $this->items[$id];
        }
      }
      $storedItem['qty']++;
      $storedItem['price'] =  $item->sales_price * $storedItem['qty'];
      $this->items[$id] = $storedItem;
      $this->totalQty++;
      $this->totalPrice += $item->sales_price;

    }



    public function decrease($item,$id)
    {
      $storedItem = ['qty' => 0,'price' => $item->sales_price,'item'=>$item];
      
      if($this->items){
        if(array_key_exists($id,$this->items)){
          $storedItem =  $this->items[$id];
        }
      }
      if ($storedItem['qty'] > 1) {
        $storedItem['qty']--;
        $storedItem['price'] =  $item->sales_price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty--;
        $this->totalPrice -= $item->sales_price;
      }
      

    }

    public function directUpdate($item,$id,$qty){
      $storedItem = ['qty' => $qty,'price' => $item->sales_price,'item'=>$item];
      $storedItem['price'] =  $item->sales_price * $storedItem['qty'];
      $this->items[$id] = $storedItem;
      $this->totalQty++;
      $this->totalPrice += $item->sales_price;
      
     

    }

    public function addToCartFromDetails($item,$id,$quantity)
    {
      $storedItem = ['qty' => 0,'price' => $item->sales_price,'item'=>$item];

      if($this->items){
        if(array_key_exists($id,$this->items)){
          $storedItem =  $this->items[$id];
        }
      }
      $storedItem['qty']+=$quantity;
      $storedItem['price'] =  $item->sales_price * $storedItem['qty'];
      $this->items[$id] = $storedItem;
      $this->totalQty+=$quantity;
      $this->totalPrice += $item->sales_price;

    }

}
