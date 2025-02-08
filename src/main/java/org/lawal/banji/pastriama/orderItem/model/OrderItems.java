package org.lawal.banji.pastriama.orderItem.model;

import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.item.model.StoreItem;

import java.util.Set;

@NoArgsConstructor
public class OrderItems {

    private Set<OrderItem> orderItems;

    public Set<OrderItem> getOrderItems() {
        return orderItems;
    }

    public boolean add(OrderItem orderItem) {
        if (orderItems == null) { throw new IllegalArgumentException();}
        return orderItems.add(orderItem);
    }

    public boolean remove(Long id) {
        if (id == null) { throw new IllegalArgumentException(); }
        return false;
    }

    public OrderItem findById (Long id) {
        return null;
    }

    public OrderItem findByStoreItem (StoreItem storeItem) {
        return null;
    }
}