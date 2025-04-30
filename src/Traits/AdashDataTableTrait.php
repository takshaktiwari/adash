<?php

namespace Takshak\Adash\Traits;

trait AdashDataTableTrait
{
    public function rawButtonActionUrl(string $url, bool $confirm = false): string
    {
        $html = '';
        if ($confirm) {
            $html .= "
                if(!confirm('Are you sure?')) {
                    return false;
                }
            ";
        }

        $html .= "
            let selectedValues = [];
            $('.selected_items:checked').each(function() {
                selectedValues.push($(this).val());
            });

            if(!selectedValues.length) {
                alert('Please select at least one item.');
                return false;
            }

            let baseUrl = '" . $url . "';
            let params = selectedValues.map(value => `item_ids[]=`+value).join('&');
            let fullUrl = baseUrl+`?`+params;

            window.location.href = fullUrl;
        ";

        return $html;
    }
}
