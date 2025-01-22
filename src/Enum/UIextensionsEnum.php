<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Enum;

enum UIextensionsEnum
{
    // Labels
    public const EDIT_PRODUCT_HEADER_POSITION_LABEL = 'Edit Product Header';
    public const EDIT_ROOT_PRODUCT_MODEL_HEADER_POSITION_LABEL = 'Edit Root Product Model Header';
    public const EDIT_SUB_PRODUCT_MODEL_HEADER_POSITION_LABEL = 'Edit Sub Product Model Header';
    public const EDIT_PRODUCT_TAB_POSITION_LABEL = 'Edit Product Tab';
    public const EDIT_CATEGORY_TAB_POSITION_LABEL = 'Edit Category Tab';
    public const PRODUCT_GRID_QUICK_ACTION_POSITION_LABEL = 'Product Grid Quick Action';

    // Values
    public const EDIT_PRODUCT_HEADER_POSITION = 'pim.product.header';
    public const EDIT_ROOT_PRODUCT_MODEL_HEADER_POSITION = 'pim.product-model.header';
    public const EDIT_SUB_PRODUCT_MODEL_HEADER_POSITION = 'pim.product-variant.header';
    public const EDIT_PRODUCT_TAB_POSITION = 'pim.product.tab';
    public const EDIT_CATEGORY_TAB_POSITION = 'pim.category.tab';
    public const PRODUCT_GRID_QUICK_ACTION_POSITION = 'pim.product-grid.action-bar';

    // Combined Choices
    public const POSITIONS_FORM_OPTIONS = [
        self::EDIT_PRODUCT_HEADER_POSITION_LABEL => self::EDIT_PRODUCT_HEADER_POSITION,
        self::EDIT_ROOT_PRODUCT_MODEL_HEADER_POSITION_LABEL => self::EDIT_ROOT_PRODUCT_MODEL_HEADER_POSITION,
        self::EDIT_SUB_PRODUCT_MODEL_HEADER_POSITION_LABEL => self::EDIT_SUB_PRODUCT_MODEL_HEADER_POSITION,
        self::EDIT_PRODUCT_TAB_POSITION_LABEL => self::EDIT_PRODUCT_TAB_POSITION,
        self::EDIT_CATEGORY_TAB_POSITION_LABEL => self::EDIT_CATEGORY_TAB_POSITION,
        self::PRODUCT_GRID_QUICK_ACTION_POSITION_LABEL => self::PRODUCT_GRID_QUICK_ACTION_POSITION,
    ];

    public const AVAILABLE_UI_LOCALES = [
        'Catalan (Spain)' => 'ca_ES',
        'German (Germany)' => 'de_DE',
        'English (United Kingdom)' => 'en_GB',
        'English (United States)' => 'en_US',
        'Spanish (Spain)' => 'es_ES',
        'French (France)' => 'fr_FR',
        'Italian (Italy)' => 'it_IT',
        'Japanese (Japan)' => 'ja_JP',
        'Korean (South Korea)' => 'ko_KR',
        'Dutch (Netherlands)' => 'nl_NL',
        'Polish (Poland)' => 'pl_PL',
        'Portuguese (Portugal)' => 'pt_PT',
        'Chinese (China)' => 'zh_CN',
    ];
}
