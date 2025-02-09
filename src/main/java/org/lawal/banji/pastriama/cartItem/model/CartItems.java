package org.lawal.banji.pastriama.cartItem.model;

import java.util.HashSet;
import java.util.Iterator;
import java.util.List;
import java.util.Set;

public class CartItems {

    private Set<CartItem> cartItems;

    public CartItems() {
        this.cartItems = new HashSet<>();
    }

    public int size() { return cartItems.size(); }

    public Iterator<CartItem> iterator () { return cartItems.iterator(); }

    public boolean isEmpty() { return cartItems.isEmpty(); }

    public boolean contains(CartItem cartItem) {
        return cartItems.contains(cartItem);
    }

    public void clear() { cartItems.clear();}

    public List<CartItem> getCartItemList() { return List.copyOf(cartItems); }

    public void add(CartItem cartItem) {
        if (cartItem != null && !cartItems.contains(cartItem)) cartItems.add(cartItem);
    }

    public void remove(Long id) {
        if (id == null) return;
        CartItem cartItem = findById(id);
        if (cartItem != null)
            cartItems.remove(cartItem);
    }

    public CartItem findById(Long id) {
        for (CartItem cartItem : cartItems) {
            if (cartItem.getId().equals(id)) return cartItem;
        }
        return null;
    }
}