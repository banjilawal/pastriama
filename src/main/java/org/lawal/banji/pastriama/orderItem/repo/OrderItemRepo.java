package org.lawal.banji.pastriama.orderItem.repo;

import jdk.jfr.Registered;
import org.lawal.banji.pastriama.orderItem.model.OrderItem;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface OrderItemRepo extends JpaRepository<OrderItem, Long> {
}