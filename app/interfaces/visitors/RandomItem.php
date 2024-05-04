<?php

namespace app\interfaces\visitors;


interface RandomItem {

    public function randomUser (Users $users): User;
    public function randomWish (Wishlist $wishes): Wish;
    public function randomOrder (Orders $orders): Order;
    public function randomProduct (Inventory $inventory): InventoryItem;
    public function randomCartItem (Cart $cart): CartItem;
    public function randomOrderItem (Order $order): OrderItem;
    public function randomCreditCard (CreditCards $creditCards): CreditCard;
}