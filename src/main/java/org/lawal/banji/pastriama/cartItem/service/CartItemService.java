package org.lawal.banji.pastriama.cartItem.service;

import org.lawal.banji.pastriama.cartItem.repo.CartItemRepo;
import org.springframework.beans.factory.annotation.Autowired;

public class CartItemService {

    private CartItemRepo cartItemRepo;

    @Autowired
    public CartItemService(CartItemRepo cartItemRepo) {
        this.cartItemRepo = cartItemRepo;
    }
}