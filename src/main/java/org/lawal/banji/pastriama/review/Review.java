package org.lawal.banji.pastriama.review;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import org.lawal.banji.pastriama.item.model.StoreItem;
import org.lawal.banji.pastriama.people.Customer;

import java.time.LocalDateTime;

public class Review {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NotNull
    LocalDateTime timestamp;


    @NotNull
    @NotBlank(message = "")
    String comment;

    @ManyToOne
    @JoinColumn(name = "store_item_id", nullable = false, unique = true)
    private StoreItem storeItem;

    @ManyToOne
    @JoinColumn(name = "customer_id", nullable = false)
    private Customer customer;
}