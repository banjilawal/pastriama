package org.lawal.banji.pastriama.cartItem.model;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import lombok.NonNull;
import org.lawal.banji.pastriama.item.model.StoreItem;
import org.lawal.banji.pastriama.people.Customer;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class CartItem {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    Long id;

    @NonNull
    Integer quantity;

    @ManyToOne
    @JoinColumn(name = "store_iem_id", nullable = false)
    private StoreItem storeItem;

    @ManyToOne
    @JoinColumn(name = "customer_id")
    Customer customer;

}