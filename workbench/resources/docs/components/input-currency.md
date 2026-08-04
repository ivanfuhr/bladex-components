Formatted currency display aligned with Laravel [`Number::currency`](https://laravel.com/docs/helpers#method-number-currency). The visible field shows locale-aware formatting; a hidden input submits a decimal string your backend can cast to `float` (for example `(float) $request->input('amount')`). Default `mode` is `cents` (digit mask). Requires the `intl` PHP extension. `stencil:add input-currency` copies `input-currency.js` and patches your Vite entry.

```blade
<x-ui::field name="amount">
    <x-ui::field.label>Amount</x-ui::field.label>
    <x-ui::input.currency
        name="amount"
        :value="old('amount', $product->price)"
        currency="BRL"
        locale="pt_BR"
        :precision="2"
        placeholder="0,00"
    />
    <x-ui::field.errors name="amount" />
</x-ui::field>
```

<br>
