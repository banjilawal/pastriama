package org.lawal.banji.pastriama.order.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

import org.lawal.banji.pastriama.orderItem.model.OrderItem;
import org.lawal.banji.pastriama.people.Customer;
import org.lawal.banji.pastriama.billing.model.Bill;
import org.lawal.banji.pastriama.shipping.model.Shipment;

import java.util.HashSet;
import java.util.Set;

@Data
@Entity
public class Order {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private long id;

    @NotNull
    @ManyToOne
    @JoinColumn(name =  "customer_id", nullable = false)
    private Customer customer;

    @OneToOne
    @JoinColumn(name = "payment_id", nullable = false)
    private Bill bill;

    @OneToOne
    @JoinColumn(name = "shipping_id", nullable = false, unique = true)
    Shipment shipment;

    @OneToMany(mappedBy="order", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    Set<OrderItem> items = new HashSet<>();
}