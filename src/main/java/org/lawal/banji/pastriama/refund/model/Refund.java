package org.lawal.banji.pastriama.refund.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.creditCard.CreditCard;
import org.lawal.banji.pastriama.returns.model.ReturnItem;

import java.time.LocalDateTime;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class Refund {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NotNull
    LocalDateTime issueDate;

    @OneToOne
    @JoinColumn(name = "return_item_id", nullable = false)
    private ReturnItem returnItem;

    @ManyToOne
    @JoinColumn(name = "credit_card_id", nullable = false)
    private CreditCard creditCard;
}