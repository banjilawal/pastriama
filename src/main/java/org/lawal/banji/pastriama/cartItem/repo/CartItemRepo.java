package org.lawal.banji.pastriama.cartItem.repo;

import org.lawal.banji.pastriama.cartItem.model.CartItem;
import org.springframework.data.jpa.repository.JpaRepository;

public interface CartItemRepo extends JpaRepository<CartItem, Long> {
}