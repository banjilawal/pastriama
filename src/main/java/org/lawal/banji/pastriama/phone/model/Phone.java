package org.lawal.banji.pastriama.phone.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import lombok.NonNull;
import org.lawal.banji.pastriama.people.Customer;


@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class Phone {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @NonNull
    @NotBlank(message = "")
    private String number;

    @ManyToOne
    @JoinColumn(name = "customer_id")
    private Customer customer;
}