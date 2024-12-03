<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Enum;

class EventPlatformEnum
{
    // App Events
    public const APP_DELETED_CODE = 'com.akeneo.pim.v1.app.deleted';
    public const APP_DELETED_LABEL = 'App Deleted';

    // Asset Events
    public const ASSET_CREATED_CODE = 'com.akeneo.pim.v1.asset.created';
    public const ASSET_CREATED_LABEL = 'Asset Created';

    public const ASSET_UPDATED_CODE = 'com.akeneo.pim.v1.asset.updated';
    public const ASSET_UPDATED_LABEL = 'Asset Updated';

    public const ASSET_DELETED_CODE = 'com.akeneo.pim.v1.asset.deleted';
    public const ASSET_DELETED_LABEL = 'Asset Deleted';

    // Attribute Events
    public const ATTRIBUTE_CREATED_CODE = 'com.akeneo.pim.v1.attribute.created';
    public const ATTRIBUTE_CREATED_LABEL = 'Attribute Created';

    public const ATTRIBUTE_UPDATED_CODE = 'com.akeneo.pim.v1.attribute.updated';
    public const ATTRIBUTE_UPDATED_LABEL = 'Attribute Updated';

    public const ATTRIBUTE_DELETED_CODE = 'com.akeneo.pim.v1.attribute.deleted';
    public const ATTRIBUTE_DELETED_LABEL = 'Attribute Deleted';

    // Attribute Group Events
    public const ATTRIBUTE_GROUP_CREATED_CODE = 'com.akeneo.pim.v1.attribute-group.created';
    public const ATTRIBUTE_GROUP_CREATED_LABEL = 'Attribute Group Created';

    public const ATTRIBUTE_GROUP_UPDATED_CODE = 'com.akeneo.pim.v1.attribute-group.updated';
    public const ATTRIBUTE_GROUP_UPDATED_LABEL = 'Attribute Group Updated';

    public const ATTRIBUTE_GROUP_DELETED_CODE = 'com.akeneo.pim.v1.attribute-group.deleted';
    public const ATTRIBUTE_GROUP_DELETED_LABEL = 'Attribute Group Deleted';

    // Attribute Option Events
    public const ATTRIBUTE_OPTION_CREATED_CODE = 'com.akeneo.pim.v1.attribute-option.created';
    public const ATTRIBUTE_OPTION_CREATED_LABEL = 'Attribute Option Created';

    public const ATTRIBUTE_OPTION_UPDATED_CODE = 'com.akeneo.pim.v1.attribute-option.updated';
    public const ATTRIBUTE_OPTION_UPDATED_LABEL = 'Attribute Option Updated';

    public const ATTRIBUTE_OPTION_DELETED_CODE = 'com.akeneo.pim.v1.attribute-option.deleted';
    public const ATTRIBUTE_OPTION_DELETED_LABEL = 'Attribute Option Deleted';

    // Category Events
    public const CATEGORY_CREATED_CODE = 'com.akeneo.pim.v1.category.created';
    public const CATEGORY_CREATED_LABEL = 'Category Created';

    public const CATEGORY_UPDATED_CODE = 'com.akeneo.pim.v1.category.updated';
    public const CATEGORY_UPDATED_LABEL = 'Category Updated';

    public const CATEGORY_DELETED_CODE = 'com.akeneo.pim.v1.category.deleted';
    public const CATEGORY_DELETED_LABEL = 'Category Deleted';

    // Connection Events
    public const CONNECTION_DELETED_CODE = 'com.akeneo.pim.v1.connection.deleted';
    public const CONNECTION_DELETED_LABEL = 'Connection Deleted';

    // Product Events
    public const PRODUCT_CREATED_CODE = 'com.akeneo.pim.v1.product.created';
    public const PRODUCT_CREATED_LABEL = 'Product Created';

    public const PRODUCT_UPDATED_CODE = 'com.akeneo.pim.v1.product.updated';
    public const PRODUCT_UPDATED_LABEL = 'Product Updated';

    public const PRODUCT_DELETED_CODE = 'com.akeneo.pim.v1.product.deleted';
    public const PRODUCT_DELETED_LABEL = 'Product Deleted';

    // Product Model Events
    public const PRODUCT_MODEL_CREATED_CODE = 'com.akeneo.pim.v1.product-model.created';
    public const PRODUCT_MODEL_CREATED_LABEL = 'Product Model Created';

    public const PRODUCT_MODEL_UPDATED_CODE = 'com.akeneo.pim.v1.product-model.updated';
    public const PRODUCT_MODEL_UPDATED_LABEL = 'Product Model Updated';

    public const PRODUCT_MODEL_DELETED_CODE = 'com.akeneo.pim.v1.product-model.deleted';
    public const PRODUCT_MODEL_DELETED_LABEL = 'Product Model Deleted';

    // Family Events
    public const FAMILY_CREATED_CODE = 'com.akeneo.pim.v1.family.created';
    public const FAMILY_CREATED_LABEL = 'Family Created';

    public const FAMILY_UPDATED_CODE = 'com.akeneo.pim.v1.family.updated';
    public const FAMILY_UPDATED_LABEL = 'Family Updated';

    public const FAMILY_DELETED_CODE = 'com.akeneo.pim.v1.family.deleted';
    public const FAMILY_DELETED_LABEL = 'Family Deleted';

    // Reference Entity Record Events
    public const REFERENCE_ENTITY_RECORD_CREATED_CODE = 'com.akeneo.pim.v1.reference-entity-record.created';
    public const REFERENCE_ENTITY_RECORD_CREATED_LABEL = 'Reference Entity Record Created';

    public const REFERENCE_ENTITY_RECORD_UPDATED_CODE = 'com.akeneo.pim.v1.reference-entity-record.updated';
    public const REFERENCE_ENTITY_RECORD_UPDATED_LABEL = 'Reference Entity Record Updated';

    public const REFERENCE_ENTITY_RECORD_DELETED_CODE = 'com.akeneo.pim.v1.reference-entity-record.deleted';
    public const REFERENCE_ENTITY_RECORD_DELETED_LABEL = 'Reference Entity Record Deleted';

    // Grouped array of events: labels as keys, codes as values
    public const EVENTS = [
        self::APP_DELETED_LABEL => self::APP_DELETED_CODE,
        self::ASSET_CREATED_LABEL => self::ASSET_CREATED_CODE,
        self::ASSET_UPDATED_LABEL => self::ASSET_UPDATED_CODE,
        self::ASSET_DELETED_LABEL => self::ASSET_DELETED_CODE,
        self::ATTRIBUTE_CREATED_LABEL => self::ATTRIBUTE_CREATED_CODE,
        self::ATTRIBUTE_UPDATED_LABEL => self::ATTRIBUTE_UPDATED_CODE,
        self::ATTRIBUTE_DELETED_LABEL => self::ATTRIBUTE_DELETED_CODE,
        self::ATTRIBUTE_GROUP_CREATED_LABEL => self::ATTRIBUTE_GROUP_CREATED_CODE,
        self::ATTRIBUTE_GROUP_UPDATED_LABEL => self::ATTRIBUTE_GROUP_UPDATED_CODE,
        self::ATTRIBUTE_GROUP_DELETED_LABEL => self::ATTRIBUTE_GROUP_DELETED_CODE,
        self::ATTRIBUTE_OPTION_CREATED_LABEL => self::ATTRIBUTE_OPTION_CREATED_CODE,
        self::ATTRIBUTE_OPTION_UPDATED_LABEL => self::ATTRIBUTE_OPTION_UPDATED_CODE,
        self::ATTRIBUTE_OPTION_DELETED_LABEL => self::ATTRIBUTE_OPTION_DELETED_CODE,
        self::CATEGORY_CREATED_LABEL => self::CATEGORY_CREATED_CODE,
        self::CATEGORY_UPDATED_LABEL => self::CATEGORY_UPDATED_CODE,
        self::CATEGORY_DELETED_LABEL => self::CATEGORY_DELETED_CODE,
        self::CONNECTION_DELETED_LABEL => self::CONNECTION_DELETED_CODE,
        self::PRODUCT_CREATED_LABEL => self::PRODUCT_CREATED_CODE,
        self::PRODUCT_UPDATED_LABEL => self::PRODUCT_UPDATED_CODE,
        self::PRODUCT_DELETED_LABEL => self::PRODUCT_DELETED_CODE,
        self::PRODUCT_MODEL_CREATED_LABEL => self::PRODUCT_MODEL_CREATED_CODE,
        self::PRODUCT_MODEL_UPDATED_LABEL => self::PRODUCT_MODEL_UPDATED_CODE,
        self::PRODUCT_MODEL_DELETED_LABEL => self::PRODUCT_MODEL_DELETED_CODE,
        self::FAMILY_CREATED_LABEL => self::FAMILY_CREATED_CODE,
        self::FAMILY_UPDATED_LABEL => self::FAMILY_UPDATED_CODE,
        self::FAMILY_DELETED_LABEL => self::FAMILY_DELETED_CODE,
        self::REFERENCE_ENTITY_RECORD_CREATED_LABEL => self::REFERENCE_ENTITY_RECORD_CREATED_CODE,
        self::REFERENCE_ENTITY_RECORD_UPDATED_LABEL => self::REFERENCE_ENTITY_RECORD_UPDATED_CODE,
        self::REFERENCE_ENTITY_RECORD_DELETED_LABEL => self::REFERENCE_ENTITY_RECORD_DELETED_CODE,
    ];
}
