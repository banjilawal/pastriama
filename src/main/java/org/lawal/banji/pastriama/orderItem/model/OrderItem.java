package org.lawal.banji.pastriama.orderItem.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.Positive;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.item.model.StoreItem;
import org.lawal.banji.pastriama.order.model.Order;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class OrderItem {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private long id;

    @ManyToOne
    @JoinColumn(name="item_id", nullable=false, unique=true)
    StoreItem storeItem;

    @ManyToOne
    @JoinColumn(name="order_id", nullable=false, unique=true)
    Order order;

    @Column(nullable=false)
    @Positive
    private int quantity;

    public Double getPrice() { return storeItem.getPrice() * quantity; }
}