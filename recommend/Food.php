<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 04/02/2018
 * Time: 17:52
 */

class Order {
    private $foodId;
    private $foodCategory;
    private $foodName;
    private $isAvailable;
    private $price;
    private $discount;
    private $discountEffectDate;
    private $discountExpireDate;
    private $remark;


    public function __construct($foodId, $foodCategory, $foodName, $isAvailable, $price,
                                $discount, $discountEffectDate, $discountExpireDate, $remark)
    {
        $this->userID 				= $foodId;
        $this->foodCategory 		= $foodCategory;
        $this->foodName			    = $foodName;
        $this->isAvailable 			= $isAvailable;
        $this->price				= $price;
        $this->discount				= $discount;
        $this->discountEffectDate	= $discountEffectDate;
        $this->discountExpireDate 	= $discountExpireDate;
        $this->remark 			    = $remark;

    }

    public function getfoodId() {
        return $this->foodId;
    }

    public function getfoodCategory() {
        return $this->foodCategory;
    }

    public function getIsAvailable() {
        return $this->isAvailable;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDiscount() {
        return $this->discount;
    }

    public function getDiscountEffectDate() {
        return $this->discountEffectDate;
    }

    public function getDiscountExpireDate() {
        return $this->discountExpireDate;
    }

}

?>