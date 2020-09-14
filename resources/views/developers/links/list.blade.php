@php
    $parameters = [
        [
            'name' => 'search',
            'type' => 0,
            'format' => 'string',
            'description' => __('The search query.')
        ], [
            'name' => 'by',
            'type' => 0,
            'format' => 'string',
            'description' => __('Search by.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>title</code>', 'name' => '<span class="font-weight-medium">'.__('Title').'</span>']),
                    __(':value for :name', ['value' => '<code>alias</code>', 'name' => '<span class="font-weight-medium">'.__('Alias').'</span>']),
                    __(':value for :name', ['value' => '<code>url</code>', 'name' => '<span class="font-weight-medium">'.__('URL').'</span>'])
                    ])
                ])
        ], [
            'name' => 'status',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by status.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>0</code>', 'name' => '<span class="font-weight-medium">'.__('All').'</span>']),
                    __(':value for :name', ['value' => '<code>1</code>', 'name' => '<span class="font-weight-medium">'.__('Active').'</span>']),
                    __(':value for :name', ['value' => '<code>2</code>', 'name' => '<span class="font-weight-medium">'.__('Expired').'</span>']),
                    __(':value for :name', ['value' => '<code>3</code>', 'name' => '<span class="font-weight-medium">'.__('Disabled').'</span>'])
                    ])
                ])
        ], [
            'name' => 'space',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by space id.')
        ], [
            'name' => 'domain',
            'type' => 0,
            'format' => 'integer',
            'description' => __('Filter by domain id.')
        ], [
            'name' => 'sort',
            'type' => 0,
            'format' => 'string',
            'description' => __('Sort by.') . ' ' . __('Possible values are: :values.', [
                'values' => implode(', ', [
                    __(':value for :name', ['value' => '<code>desc</code>', 'name' => '<span class="font-weight-medium">'.__('Descending').'</span>']),
                    __(':value for :name', ['value' => '<code>asc</code>', 'name' => '<span class="font-weight-medium">'.__('Ascending').'</span>']),
                    __(':value for :name', ['value' => '<code>max</code>', 'name' => '<span class="font-weight-medium">'.__('Best performing').'</span>']),
                    __(':value for :name', ['value' => '<code>min</code>', 'name' => '<span class="font-weight-medium">'.__('Least performing').'</span>'])
                    ])
                ])
        ],
    ];
@endphp

@include('developers.parameters')