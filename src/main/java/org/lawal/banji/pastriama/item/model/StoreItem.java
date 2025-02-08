package org.lawal.banji.pastriama.item.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.PositiveOrZero;

import lombok.*;

import org.lawal.banji.pastriama.orderItem.model.OrderItem;
import org.lawal.banji.pastriama.review.Review;
import org.lawal.banji.pastriama.wish.Wish;

import java.util.HashSet;
import java.util.Set;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class StoreItem {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Setter(AccessLevel.NONE)
    private Long id;

    @Column(nullable = false)
    @NotBlank(message = "")
    private String name;

    @Column(nullable = false)
    @NotBlank(message = "")
    private String description;

    @Column(nullable = false)
    @PositiveOrZero
    private Double price;

    @Column(nullable = false)
    @PositiveOrZero
    private Long reorderLevel;

    @Column(nullable = false)
    @PositiveOrZero
    private Long quantityInStock;

    @OneToMany(mappedBy="storeItem", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<OrderItem> orderItems = new HashSet<>();

    @OneToMany(mappedBy="storeItem", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<Review> reviews = new HashSet<>();

    @OneToMany(mappedBy="storeItem", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<Wish> wishes;
}