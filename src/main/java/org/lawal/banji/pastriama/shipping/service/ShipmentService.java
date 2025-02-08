package org.lawal.banji.pastriama.shipping.service;

import org.lawal.banji.pastriama.shipping.repo.ShipmentRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ShipmentService {

    private ShipmentRepo shipmentRepo;

    @Autowired
    public ShipmentService(ShipmentRepo shipmentRepo) {
        this.shipmentRepo = shipmentRepo;
    }
}