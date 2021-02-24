<?php

namespace AndreaMarelli\ModularForms\Helpers;

use AndreaMarelli\ModularForms\Helpers\File\File;

class Template
{

    private const DOCS_PATH = 'docs';

    /**
     * Return an icon (FontAwesome) tag
     *
     * @param $icon
     * @param string $color
     * @param string $size
     * @param string $other
     * @return string
     */
    public static function icon($icon, $color = '', $size = '', $other = ''): string
    {
        $color = $color ?? '';
        $size  = $size != '' ? 'style="font-size: ' . $size . '"' : '';
        return '<span class="fas fa-fw fa-' . $icon . ' ' . $other . ' ' . $color . '" ' . $size . ' ></span>';
    }

    /**
     * Return a flag (lipis/flag-icon-css) tag
     *
     * @param $iso2
     * @param string $tooltip
     * @return string
     */
    public static function flag($iso2, $tooltip = ''): string
    {
        $iso2    = strtolower($iso2);
        $iso2    = ($iso2 == 'en') ? 'gb' : $iso2;
        $iso2    = ($iso2 == 'sp') ? 'es' : $iso2;
        $tooltip = $tooltip != '' ? ' data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"' : '';
        return '<span ' . $tooltip . ' class="flag-icon flag-icon-' . $iso2 . '"></span>';
    }

    /**
     * Get file link (with icon)
     *
     * @param $relativePath
     * @param $fileName
     * @param string $label
     * @return string
     */
    public static function fileLink($relativePath, $fileName, $label = ''): string
    {
        $file_extension = strtolower(strrchr($fileName, '.'));
        if ($file_extension == '.doc' || $file_extension == '.docx') {
            $icon = Template::icon('file-word', 'contextual_primary');
        } elseif ($file_extension == '.xls' || $file_extension == '.xlsx') {
            $icon = Template::icon('file-excel', 'contextual_success');
        } elseif ($file_extension == '.ppt' || $file_extension == '.pptx' || $file_extension == '.pps' || $file_extension == '.ppsx') {
            $icon = Template::icon('file-powerpoint', 'contextual_warning');
        } elseif ($file_extension == '.pdf') {
            $icon = Template::icon('file-pdf', 'red');
        } elseif ($file_extension == '.txt' || $file_extension == '.csv') {
            $icon = Template::icon('file-alt');
        } elseif ($file_extension == '.zip' || $file_extension == '.rar' || $file_extension == '.7z' || $file_extension == '.gzip'
            || $file_extension == '.gzip' || $file_extension == '.bzip2' || $file_extension == '.tar' || $file_extension == '.ace') {
            $icon = Template::icon('file-archive');
        } elseif ($file_extension == '.png' || $file_extension == '.gif' || $file_extension == '.jpeg' || $file_extension == '.jpg'
            || $file_extension == '.tif' || $file_extension == '.tiff') {
            $icon = Template::icon('file-image', 'contextual_primary');
        } elseif ($file_extension == '.xml') {
            $icon = Template::icon('file-code');
        } else {
            $icon = Template::icon('file');
        }

        if ($label == null) {
            $label = '';
        }
        if ($label == '') {
            $label = $fileName;
        }

        if (substr($relativePath, 0, 1) != '/') {
            $relativePath = '/' . $relativePath;
        }
        return '<a target="_blank" href="' . asset(Template::DOCS_PATH) . $relativePath . $fileName . '">
                    ' . $icon . '&nbsp;
                    ' . $label . '
                </a>';
    }

    /**
     * Get file link (with icon and size)
     *
     * @param $relativePath
     * @param $fileName
     * @param string $label
     * @return string
     */
    public static function fileLinkWithSize($relativePath, $fileName, $label = ''): string
    {
        if (substr($relativePath, -1, 1) != '/') {
            $relativePath .= '/';
        }
        return Template::fileLink($relativePath, $fileName, $label) . '
                <small>(' . File::readableBytes(
                filesize(public_path() . '/' . Template::DOCS_PATH . '/' . $relativePath . $fileName),
                1
            ) . ')</small>';
    }

    /**
     * Encode an email address to display on your website
     *
     * @param $email
     * @return string
     */
    public static function encodeEmailAddress($email): string
    {
        $output = '';
        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#' . ord($email[$i]) . ';';
        }
        return $output;
    }

}
