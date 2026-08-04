# Input Currency Audit

## Audit Health Score

| # | Dimension | Score | Key Finding |
|---|-----------|-------|-------------|
| 1 | Accessibility | 3 | — |
| 2 | Performance | 4 | — |
| 3 | Theming | 4 | — |
| 4 | Responsive | 3 | — |
| 5 | Anti-Patterns | 3 | — |
| **Total** | | **17/20** | **Good** |

## Executive Summary

- **Score:** 17/20 (Good)

- **Issues:** P1 decimal mode broken (fixed); P2 locale separators

## Fixes Applied

- resources/assets/js/input-currency.js
- src/View/Components/Input/Currency.php

## Positive Findings

- hidden input pattern, Intl formatting
