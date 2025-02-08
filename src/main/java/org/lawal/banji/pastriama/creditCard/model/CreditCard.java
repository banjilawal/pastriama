package org.lawal.banji.pastriama.creditCard;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import lombok.NonNull;
import org.lawal.banji.pastriama.billing.model.Bill;
import org.lawal.banji.pastriama.people.Customer;
import org.lawal.banji.pastriama.refund.model.Refund;

import java.time.LocalDateTime;
import java.util.Set;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class CreditCard {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NonNull
    @NotBlank
    private String cvn;

    @NonNull
    @NotBlank
    String number;

    @NonNull
    LocalDateTime expirationDate;

    @ManyToOne
    @JoinColumn(name = "customer_id")
    private Customer customer;

    @OneToMany(mappedBy="creditCard", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    Set<Bill> bills;

    @OneToMany(mappedBy="creditCard", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    Set<Refund> refunds;
}