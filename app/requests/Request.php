<?php

namespace app\requests;


use AllowDynamicProperties;
use app\enums\RequestStatus;
use app\enums\Resource;
use app\enums\Service;
use app\interfaces\adapters\GetId;

#[AllowDynamicProperties] abstract class Request implements GetId {
    private int $id;
    private Resource $resource;
    private Service $service;
    private RequestStatus $status;
    private string|array $fields;

    /**
     * @param int $id
     * @param Resource $resource
     * @param Service $service
     * @param array|string $fields
     */
    public function __construct (int $id, Resource $resource, Service $service, array|string $fields) {
        $this->id = $id;
        $this->resource = $resource;
        $this->service = $service;
        $this->fields = $fields;
        $this->requestStatus = RequestStatus::NOT_HANDLEDD;
    }

    public function getId (): int {
        return $this->id;
    }

    public function getResource (): Resource {
        return $this->resource;
    }

    public function getService (): Service {
        return $this->service;
    }

    public function getFields (): array|string {
        return $this->fields;
    }

    public function getStatus (): RequestStatus {
        return $this->status;
    }

    public function setStatus (RequestStatus $status): void {
        $this->status = $status;
    }


    public function __toString (): string {
        $string = $this->service->name . ' ' . $this->resource->name . ' ' . $this->status->name;
        foreach ($this->fields as $key => $value) {
            $string .= $key . ':' . $value;
        }
        return $string;
    }
}