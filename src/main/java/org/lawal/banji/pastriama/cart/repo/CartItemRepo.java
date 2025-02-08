package org.lawal.banji.pastriama.cart.repo;

import org.lawal.banji.pastriama.cart.model.CartItem;
import org.springframework.data.jpa.repository.JpaRepository;

public interface CartItemRepo extends JpaRepository<CartItem, Long> {
}