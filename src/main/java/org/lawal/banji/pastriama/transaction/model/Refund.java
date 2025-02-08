package org.lawal.banji.pastriama.transaction.model;

import jakarta.persistence.*;
import lombok.NonNull;
import org.lawal.banji.pastriama.creditCard.CreditCard;
import org.lawal.banji.pastriama.orderItem.model.OrderItem;

import java.time.LocalDateTime;

public class Refund {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NonNull
    private LocalDateTime timestamp;

    @OneToOne
    @JoinColumn(name = "order_item_id", nullable = false)
    private OrderItem orderItem;

    @OneToOne
    @JoinColumn(name = "card_id", nullable = false)
    private CreditCard creditCard;
}