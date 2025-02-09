package org.lawal.banji.pastriama.people;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.lawal.banji.pastriama.address.Address;
import org.lawal.banji.pastriama.cartItem.model.CartItem;
import org.lawal.banji.pastriama.order.model.Order;
import org.lawal.banji.pastriama.creditCard.CreditCard;
import org.lawal.banji.pastriama.phone.model.Phone;
import org.lawal.banji.pastriama.wish.Wish;

import java.util.List;
import java.util.Set;

@Data
@Entity
@NoArgsConstructor
@AllArgsConstructor
public class Customer {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Long id;

    @Column(nullable = false)
    @NotBlank(message = "")
    private String email;

    @Column(nullable = false)
    @NotBlank(message = "")
    private String firstname;

    @Column(nullable = false)
    @NotBlank(message = "")
    private String lastname;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<Phone> phones;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<Address> addresses;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<CreditCard> creditCards;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<Order> orders;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private List<Wish> wishes;

    @OneToMany(mappedBy="customer", cascade = CascadeType.ALL, orphanRemoval = true, fetch = FetchType.EAGER)
    private Set<CartItem> cart;
}