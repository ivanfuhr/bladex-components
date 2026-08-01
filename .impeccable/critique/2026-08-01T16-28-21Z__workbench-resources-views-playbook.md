---
target: Stencil playbook UX coherence
total_score: 22
max_score: 40
na_heuristics: 
p0_count: 0
p1_count: 3
p2_count: 3
timestamp: 2026-08-01T16-28-21Z
slug: workbench-resources-views-playbook
---
# Critique — Stencil Playbook (UX Coherence)

**Method:** dual-agent
**Target:** workbench/resources/views/playbook
**Mode:** Operate (dev tooling / component demo)

## Design Health Score

| # | Heuristic | Score | Key Issue |
|---|-----------|-------|-----------|
| 1 | Visibility of System Status | 2 | “Updating preview…” / Copy ok; falhas de preview/clipboard silenciosas |
| 2 | Match System / Real World | 3 | Tom de dev ok; marca BX, copy “package namespace”, mundos de demo misturados |
| 3 | User Control and Freedom | 3 | ← Catalog funciona; sem prev/next; Showcase sem estado “current” |
| 4 | Consistency and Standards | 2 | Shell show compartilhado vs IA, wayfinding, narrativas e vocabulário fraturados |
| 5 | Error Prevention | 2 | Selects limitam props; refresh falho deixa HTML stale sem guardrail |
| 6 | Recognition Rather Than Recall | 2 | 42 itens sem categorias/busca; localizar slug exige scroll/memória |
| 7 | Flexibility and Efficiency | 2 | Sem filtro/atalhos; power user sofre no catálogo flat |
| 8 | Aesthetic and Minimalist Design | 3 | Zinc Operate contido; catálogo longo + preview abaixo da dobra desperdiça atenção |
| 9 | Error Recovery | 1 | Falhas silenciosas; Alert Icon não mapeia warning/danger |
| 10 | Help and Documentation | 2 | Blurbs + Code ajudam; “Requires…” irregular; media/README sem link no chrome |
| **Total** | | **22/40** | **Acceptable** |

## Design Specificity Verdict

**LLM:** Parcialmente autoral (shell show + Event Studio), parcialmente intercambiável (grid shadcn-like flat, marca BX, demos multi-produto). Coerência de sistema mais forte no showcase do que no catálogo.

**Detector CLI:** 0 findings em 129 Blade (exit 0) — detector pouco sensível a fontes Blade PHP; não contradiz a revisão.

**Overlays (browser):** 4 findings no index — undersized “Workbench” (10px), low-contrast ×2, overused-font Inter. Inter e badge micro são provavelmente FP/intencionais; contraste de muted text reforça hierarquia fraca no catálogo.

## Overall Impression

O playbook tem um shell de playground previsível e um showcase (Event Studio) que prova vocabulário de produto. A coerência quebra no catálogo flat de 42 pares, wayfinding entre superfícies, e narrativas de demo que não falam o mesmo “produto”.

## What's Working

1. Shell show uniforme: Properties + Live preview + Code em todos os componentes.
2. Event Studio como prova de composição coerente.
3. Chrome Operate contido (zinc, mono `x-ui::`, badge Workbench).

## Priority Issues

### [P1] Catálogo IA: parede de 42 peers indiferenciados
**Why:** Carga cognitiva alta; recognition falha; Operate scanability quebrada.
**Fix:** Agrupar por categoria (forms, overlays, feedback, nav, media) e/ou busca/filtro leve.
**Suggested command:** $impeccable distill / $impeccable layout

### [P1] Hierarquia do show enterra o artefato; max-w-md aperta demos largas
**Why:** Em viewports < lg, Properties dominam o 1º viewport; table/wide demos parecem clipadas.
**Fix:** Priorizar canvas no first viewport; relaxar max-w-md por componente/wide mode.
**Suggested command:** $impeccable layout

### [P1] Wayfinding cross-surface inconsistente
**Why:** ← Catalog vs breadcrumb Showcase; header Showcase nunca “current”; /playbook/media órfão.
**Fix:** Estado ativo no nav; links media↔playground; prev/next opcional.
**Suggested command:** $impeccable clarify / $impeccable polish

### [P2] Narrativa/copy de demos não é um sistema de produto
**Why:** Event Studio vs shipping FAQ vs invoices vs account settings — mesmo shell, mundos diferentes.
**Fix:** Alinhar samples a um domínio (Northwind/Event Studio) ou rotular claramente “sample domain”.
**Suggested command:** $impeccable clarify

### [P2] Chrome vs componente + marca BX
**Why:** Checkboxes/selects nativos azuis vs Stencil zinc; “BX” vs Stencil Playbook.
**Fix:** Trocar marca para S/Stencil; alinhar controles do painel ao vocabulário Stencil (ou aceitar nativo conscientemente com visual neutro).
**Suggested command:** $impeccable polish / $impeccable colorize

### [P2] Estados de erro/feedback silenciosos e controles que mintem
**Why:** Preview/copy fail silent; Alert Icon sem efeito em warning/danger.
**Fix:** Toast/inline error no refresh; desabilitar ou documentar controles inaplicáveis.
**Suggested command:** $impeccable harden

## Cognitive Load

6/8 checklist fails → high. Catálogo 42 opções; Variant button 7 opções; sem nav persistente de siblings.

## Persona Red Flags

**Alex:** Sem busca/filtro/atalhos; sem prev/next; state não URL-addressable; copy fail silent.
**Jordan:** Marca BX; preview abaixo da dobra; “Requires.js” sem where; Showcase actions inertes parecem reais.
**Riley:** Stale preview silencioso; Alert Icon/Toast Position podem discordar do resultado; media só por URL.

## Per-section notes (resumo)

- Layout chrome: estável mas sem current-route; BX.
- Index: Scenario CTA forte; cards iguais sem grouping.
- Show: padrão previsível; labels PROPERTIES vs Live preview inconsistentes em casing.
- Forms/Overlays/Feedback/Nav/Media: shell igual; demos e densidade de Properties divergem.
- Showcase: melhor ilha de coerência; toast on load; tabs estilo ≠ playground.
- Media routes: terceiro modo de preview, invisível na IA.

## Minor Observations

- Button description menciona grouped layouts sem control.
- 22/42 “Requires…” com phrasing não padronizado.
- Dark preview é tema global, não só canvas.
- Detector Inter = FP esperado.

## Questions to Consider

1. Se Event Studio prova o sistema, por que o catálogo não espelha essas categorias de uso?
2. Live preview deveria ser o first viewport?
3. BX é leftover — qual a marca canônica do playbook?
4. Um domínio de demo vs multi-domain consciente?
5. Media vs playground: qual é o mental model canônico e por que não estão linkados?
