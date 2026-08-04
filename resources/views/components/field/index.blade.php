<div {{
    $attributes->class($resolvedRootClasses)->merge([
        'data-field' => true,
        'data-field-orientation' => $resolvedIsInline ? 'inline' : 'block',
        'data-invalid' => $resolvedFieldInvalid ? 'true' : 'false',
    ])
}}>
    {{
        $slot->withAttributes([
            'fieldInvalid' => $resolvedFieldInvalid,
            'controlId' => $resolvedControlId,
            'name' => $resolvedName ?? null,
            'descriptionId' => $resolvedDescriptionId,
            'errorId' => $resolvedErrorId,
            'describedBy' => $resolvedDescribedBy,
        ])
    }}
</div>
