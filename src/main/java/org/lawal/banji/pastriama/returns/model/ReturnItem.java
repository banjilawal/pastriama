package org.lawal.banji.pastriama.returns.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Positive;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.orderItem.model.OrderItem;

import java.time.LocalDateTime;


@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class ReturnItem {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    Long id;

    @NotNull
    @Positive
    Integer quantity;

    @NotNull
    private LocalDateTime arrivalDate;

    @OneToOne
    @JoinColumn(name = "order_item_id", nullable = false)
    OrderItem orderItem;
}