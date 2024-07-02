<?php

/**
 * Filter tainacan/faceted-search block metadata to set custom defaults
 *
 * @param array  $metadata The block metadata from block.json
 * @return string Modified block metadata.
 */
if ( defined ('TAINACAN_VERSION') && !function_exists('cne_filter_tainacan_faceted_search_block_defaults') ) {
    function cne_filter_tainacan_faceted_search_block_defaults( $metadata ) {
        if ( 'tainacan/faceted-search' === $metadata['name'] ) {
            $metadata['attributes']["secondaryColor"] = array(
                'type' => 'string',
                'default' => 'var(--theme-palette-color-1)'
            );
            $metadata['attributes']["primaryColor"] = array(
                'type' => 'string',
                'default' => 'var(--theme-palette-color-6)'
            );
            $metadata['attributes']["backgroundColor"] = array(
                'type' => 'string',
                'default' => 'var(--theme-palette-color-7)'
            );
            $metadata['attributes']["itemBackgroundColor"] = array(
                'type' => 'string',
                'default' => 'vvar(--theme-palette-color-7)'
            );
            // $metadata['attributes']["itemHoverBackgroundColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--background)'
            // );
            // $metadata['attributes']["itemHeadingHoverBackgroundColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--background)'
            // );
            // $metadata['attributes']["headingColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--foreground)'
            // );
            // $metadata['attributes']["labelColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--foreground)'
            // );
            // $metadata['attributes']["infoColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--foreground)'
            // );
            // $metadata['attributes']["inputColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--foreground)'
            // );
            // $metadata['attributes']["inputBorderColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--background-alt)'
            // );
            // $metadata['attributes']["inputBackgroundColor"] = array(
            //     'type' => 'string',
            //     'default' => 'var(--wp--preset--color--background)'
            // );
            $metadata['attributes']['defaultViewMode'] = array(
                'type' => 'string',
                'default' => 'records'
            );
            $metadata['attributes']['collectionDefaultViewMode'] = array(
                'type' => 'string',
                'default' => 'records'
            );
            $metadata['attributes']['hideHideFiltersButton'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideAdvancedSearch'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideSortingArea'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideSortByButton'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideExposersButton'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideGoToPageButton'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['showFiltersButtonInsideSearchControl'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['defaultItemsPerPage'] = array(
                'type' => 'number',
                'default' => 24
            );
            $metadata['attributes']['shouldNotHideFiltersOnMobile'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['displayFiltersHorizontally'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['hideFilterCollapses'] = array(
                'type' => 'boolean',
                'default' => true
            );
            $metadata['attributes']['filtersInlineWidth'] = array(
                'type' => 'number',
                'default' => 250
            );
        }
        return $metadata;
    };
    add_filter( 'block_type_metadata', 'cne_filter_tainacan_faceted_search_block_defaults' );
}
