package org.lawal.banji.pastriama.wish;

import jakarta.persistence.*;
import jakarta.validation.constraints.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.item.model.StoreItem;
import org.lawal.banji.pastriama.people.Customer;

import java.time.LocalDateTime;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class Wish {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NotNull
    LocalDateTime time;

    @ManyToOne
    @JoinColumn(name = "store_item_id", nullable = false, unique = true)
    private StoreItem storeItem;

    @ManyToOne
    @JoinColumn(name = "customer_id", nullable = false)
    private Customer customer;
}