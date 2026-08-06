Formatted currency display aligned with Laravel [`Number::currency`](https://laravel.com/docs/helpers#method-number-currency). The visible field shows locale-aware formatting; a hidden input submits a decimal string your backend can cast to `float` (for example `(float) $request->input('amount')`). Default `mode` is `cents` (digit mask). Requires the `intl` PHP extension. Included in `@stdScripts`.

```blade
<x-std::field name="amount">
    <x-std::field.label>Amount</x-std::field.label>
    <x-std::input.currency
        name="amount"
        :value="old('amount', $product->price)"
        currency="BRL"
        locale="pt_BR"
        :precision="2"
        placeholder="0,00"
    />
    <x-std::field.errors name="amount" />
</x-std::field>
```

<br>
