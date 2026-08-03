<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Tailwind;

/**
 * Tailwind v4 scan surface for class strings that live in View/Components PHP maps.
 *
 * Prefer putting new component class maps in Support (Form/Button/etc.) when practical.
 * This file exists so scanners emit utilities without @source'ing all of View/Components
 * (which bloated CSS and risked cascade regressions).
 *
 * Keep in sync with src/View/Components — tests/Feature/TailwindSourceWiringTest.php enforces coverage.
 */
final class ComponentClassSources
{
    /**
     * Space/newline-separated utility candidates for @source scanning.
     */
    public const string CLASSES = <<<'CLASSES'
!pl-9
!pr-[4.5rem]
!pr-14
!pr-9
[&_[data-icon]]:text-zinc-500 dark:[&_[data-icon]]:text-zinc-400
[&_input]:flex-1
[&_svg:not([class*=text-])]:text-zinc-500 dark:[&_svg:not([class*=text-])]:text-zinc-400
[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4
[&[aria-selected=true]_[data-combobox-item-check]]:opacity-100
[&[aria-selected=true]_[data-select-item-check]]:opacity-100
[&>*:not(:first-child)]:rounded-l-none [&>*:not(:first-child)]:border-l-0 [&>*:not(:last-child)]:rounded-r-none
[&>*:not(:first-child)]:rounded-t-none [&>*:not(:first-child)]:border-t-0 [&>*:not(:last-child)]:rounded-b-none
[&>*]:focus-visible:relative [&>*]:focus-visible:z-10
[&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0
[&>svg]:size-4 [&>svg]:shrink-0
absolute inset-y-0 right-0 z-10 flex items-center justify-center
absolute right-3 top-2.5 z-10 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20
absolute right-4 top-4 inline-flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20
absolute top-1.5 right-1 flex aspect-square size-5 items-center justify-center rounded-md p-0 text-zinc-500 outline-none
absolute top-3.5 right-3 flex aspect-square size-5 items-center justify-center rounded-md p-0 text-zinc-500 outline-none
accordion-content-
accordion-item-
active:bg-zinc-100 active:text-zinc-950 disabled:pointer-events-none disabled:opacity-50
active:cursor-grabbing
after:absolute after:-inset-2 md:after:hidden
appearance-none
aria-expanded:border-zinc-300 aria-expanded:ring-2 aria-expanded:ring-zinc-950/10
aria-selected:font-medium
backdrop:bg-zinc-950/50 backdrop:backdrop-blur-[2px]
bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300
bg-amber-500 text-zinc-950
bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300
bg-blue-600 text-white
bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-300
bg-green-600 text-white
bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300
bg-indigo-600 text-white
bg-lime-100 text-lime-800 dark:bg-lime-950 dark:text-lime-300
bg-lime-500 text-zinc-950
bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-300
bg-orange-600 text-white
bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300
bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300
bg-rose-600 text-white
bg-transparent text-zinc-600 dark:text-zinc-300
bg-violet-100 text-violet-700 dark:bg-violet-950 dark:text-violet-300
bg-violet-600 text-white
bg-white shadow-[0_0_0_1px_rgb(228_228_231)] hover:bg-zinc-100 hover:text-zinc-950 hover:shadow-[0_0_0_1px_rgb(212_212_216)] dark:bg-zinc-950 dark:shadow-[0_0_0_1px_rgb(39_39_42)] dark:hover:bg-zinc-800 dark:hover:text-zinc-50
bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200
bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900
bg-zinc-900 text-zinc-50 dark:bg-zinc-50 dark:text-zinc-900
block min-w-0
block min-w-0 flex-1 truncate
block size-full min-h-[1.125rem] min-w-[1.125rem] rounded-[3px] ring-1 ring-inset ring-zinc-950/10 dark:ring-white/15
border border-transparent bg-zinc-100 shadow-none dark:bg-zinc-900
border border-zinc-200 bg-transparent shadow-none
border border-zinc-200 bg-transparent shadow-none dark:border-zinc-800
border border-zinc-200 bg-transparent shadow-sm
border border-zinc-200 bg-transparent text-zinc-700 dark:border-zinc-700 dark:text-zinc-200
border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950
border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-50
border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-50
border-b-2 border-transparent px-1 py-2 text-sm font-medium data-[state=active]:border-zinc-900 dark:data-[state=active]:border-zinc-100
border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950 dark:text-green-50
border-green-200 bg-green-50 text-green-950 dark:border-green-900 dark:bg-green-950/40 dark:text-green-50
border-l-0 first:border-l
border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950 dark:text-red-50
border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950/40 dark:text-red-50
border-red-500 dark:border-red-500
border-red-500 focus-visible:ring-red-500/20 dark:border-red-500
border-red-500 focus-within:ring-red-500/20 dark:border-red-500
border-sky-200 bg-sky-50 text-sky-950 dark:border-sky-900 dark:bg-sky-950/40 dark:text-sky-50
border-t-0 first:border-t
border-zinc-200 bg-white text-zinc-950 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50
border-zinc-200 bg-zinc-50 text-zinc-950 dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-50
bottom-0 left-0 right-0 top-auto h-auto max-h-[85dvh] w-full max-w-none translate-x-0 translate-y-0 rounded-t-2xl
bottom-4 left-1/2 -translate-x-1/2 items-center
bottom-4 left-4 items-start
bottom-4 right-4 items-end
bottom-center
bottom-left
bottom-right
checked:border-zinc-900
checked:border-zinc-900 checked:bg-zinc-900
collapsible-content-
color-picker__swatch-trigger
combobox relative min-w-0
combobox__chip-remove
command-group-
dark:active:bg-zinc-800 dark:data-[active=true]:bg-zinc-800 dark:data-[active=true]:text-zinc-50
dark:aria-expanded:border-zinc-600 dark:aria-expanded:ring-zinc-300/20
dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200
dark:border-zinc-700 dark:bg-zinc-950 dark:hover:border-zinc-500 dark:hover:bg-zinc-900
dark:border-zinc-800 dark:bg-zinc-900/80 dark:focus-visible:ring-zinc-300/20
dark:border-zinc-800 dark:bg-zinc-950 dark:focus-within:ring-zinc-300/20
dark:border-zinc-800 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
dark:checked:border-zinc-50
dark:checked:border-zinc-50 dark:checked:bg-zinc-50
dark:data-[active=true]:bg-zinc-800 dark:data-[active=true]:text-zinc-50
dark:data-[dragging=true]:border-zinc-50 dark:data-[dragging=true]:bg-zinc-900
dark:data-[state=on]:bg-zinc-800 dark:data-[state=on]:text-zinc-50
dark:ring-zinc-300/20 dark:active:bg-zinc-800 dark:active:text-zinc-50
dark:text-zinc-200 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20
dark:text-zinc-400 dark:ring-zinc-300/20
dark:text-zinc-400 dark:ring-zinc-300/20 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
dark:text-zinc-400 dark:ring-zinc-300/20 dark:peer-hover/menu-button:text-zinc-50 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
dark:text-zinc-50 dark:placeholder:text-zinc-400
dark:text-zinc-500 dark:hover:bg-zinc-800 dark:hover:text-zinc-200
data-[active=true]:bg-zinc-100 data-[active=true]:font-medium data-[active=true]:text-zinc-950
data-[active=true]:bg-zinc-100 data-[active=true]:text-zinc-950
data-[dragging=true]:border-zinc-900 data-[dragging=true]:bg-zinc-50
data-[state=on]:bg-zinc-100 data-[state=on]:text-zinc-900
data-placeholder:text-zinc-500 dark:data-placeholder:text-zinc-400
file-upload flex min-w-0 flex-col gap-3
file-upload__item-remove
first:rounded-l-md last:rounded-r-md
first:rounded-t-md last:rounded-b-md
fixed left-1/2 top-[12vh] z-50 w-[calc(100%-2rem)] max-w-lg -translate-x-1/2 overflow-hidden rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl
fixed z-50 border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl
flex flex-col gap-2
flex flex-col gap-3
flex flex-col gap-3 rounded-md border border-zinc-200 bg-white p-4 shadow-sm
flex h-11 w-full min-w-0 bg-transparent py-3 text-sm text-zinc-950 outline-none
flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 outline-none
flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-zinc-500 outline-none
flex min-w-0
flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-950 dark:bg-zinc-800 dark:text-zinc-50 [&_svg:not([class*='size-'])]:size-6
flex w-fit items-stretch
flex w-full flex-col overflow-hidden rounded-xl bg-white text-zinc-950
flex w-full min-w-0
flex w-full min-w-0 items-center gap-3 rounded-md border border-zinc-200 bg-white px-3 py-2 shadow-sm
flex-1
flex-col gap-1.5
flex-row
flex-row items-center gap-3
flex-wrap
focus-visible:outline-none focus-visible:ring-0
focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-zinc-950/10
focus-visible:ring-2 active:bg-zinc-100 active:text-zinc-950
focus-within:outline-none focus-within:ring-2 focus-within:ring-zinc-950/10 focus-within:ring-offset-0
focus:z-10 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-zinc-950/10
font-mono uppercase tracking-wide text-zinc-950 placeholder:text-zinc-500
gap-[length:var(--toggle-gap)]
group flex w-full min-w-0 !pr-9
group flex w-full min-w-0 items-center justify-between gap-2 text-left
group relative flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-md border border-dashed border-zinc-300 bg-white px-4 text-center shadow-sm transition-colors
group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0
group-data-[collapsible=icon]:hidden
group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2!
group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 peer-data-[active=true]/menu-button:text-zinc-950 md:opacity-0 dark:peer-data-[active=true]/menu-button:text-zinc-50
group-has-data-[sidebar=menu-action]/menu-item:pe-8
group/color-picker relative flex min-w-0
group/toggle-group flex w-fit items-center rounded-md
h-10 min-w-10 px-2.5 text-base
h-10 min-w-10 px-3 text-base
h-12 text-sm group-data-[collapsible=icon]:p-0!
h-2
h-3
h-7 text-xs
h-8 min-w-8 px-1.5 text-sm
h-8 min-w-8 px-2 text-sm
h-8 text-sm
h-9 min-w-9 px-2 text-sm
h-9 min-w-9 px-3 text-sm
h-auto min-h-9 py-1.5
has-[>[data-button-group]]:gap-2
hiddenValue
hover:bg-zinc-100 data-[highlighted]:bg-zinc-100 dark:hover:bg-zinc-800 dark:data-[highlighted]:bg-zinc-800
hover:bg-zinc-100 hover:text-zinc-700
hover:bg-zinc-100 hover:text-zinc-950 dark:hover:bg-zinc-800 dark:hover:text-zinc-50
hover:border-zinc-400 hover:bg-zinc-50
inline-flex items-center gap-1 font-medium whitespace-nowrap
inline-flex items-center gap-1 rounded-lg bg-zinc-100 p-1 dark:bg-zinc-800
inline-flex items-center gap-2
inline-flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-800
inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium
inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700
inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap font-medium
inline-flex shrink-0 items-center justify-center rounded-sm text-zinc-500 hover:text-zinc-900
inline-flex size-8 shrink-0 cursor-grab items-center justify-center rounded-md text-zinc-400 transition-colors
inline-flex size-8 shrink-0 items-center justify-center rounded-md text-zinc-500 transition-colors
inline-flex size-8 shrink-0 items-center justify-center self-end rounded-md text-zinc-500 transition-colors
inline-flex w-fit items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-900 shadow-sm transition-colors
input--with-affixes
input-otp flex min-w-0 items-center gap-2
input-otp-
left-0 right-auto top-0 translate-x-0 translate-y-0
left-1/2 top-1/2 w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 rounded-xl
left-1/2 top-4 -translate-x-1/2 items-center
left-4 top-4 items-start
left-auto right-0 top-0 translate-x-0 translate-y-0
m-0 h-dvh max-h-dvh w-full max-w-md rounded-none
max-h-[min(300px,50vh)] scroll-py-1 overflow-x-hidden overflow-y-auto p-1
max-w-lg
max-w-sm
min-h-12 py-2
min-h-16 flex-row gap-3 py-3
min-h-28 py-6
min-h-36 py-8
min-h-4 min-w-4
min-w-0 flex-1 border-0 bg-transparent shadow-none
min-w-0 truncate
motion-safe:transition-[opacity,transform] motion-safe:duration-200 motion-safe:ease-[cubic-bezier(0.16,1,0.3,1)]
opacity-0 motion-safe:scale-[0.98]
open:opacity-100 open:motion-safe:scale-100
p-4
p-6
peer-data-[size=default]/menu-button:top-1.5
peer-data-[size=lg]/menu-button:top-2.5
peer-data-[size=sm]/menu-button:top-1
peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-none
pillbox flex min-w-0 flex-col gap-2
pillbox__chip-remove
placeholder:text-zinc-500 dark:placeholder:text-zinc-400
placeholder:text-zinc-500 disabled:cursor-not-allowed disabled:opacity-50
pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center
pointer-events-none cursor-not-allowed opacity-50
pointer-events-none opacity-50
px-1.5 py-0 text-[10px]
px-2 pb-0.5 pt-1
px-2 py-0.5 text-xs
px-2 py-1.5 text-center text-sm text-zinc-500 dark:text-zinc-400
px-2.5 py-1 text-sm
py-6 text-center text-sm text-zinc-500 dark:text-zinc-400
rating flex min-w-0 items-center gap-1
relative flex max-h-[min(85dvh,calc(100dvh-2rem))] flex-col p-6
relative flex min-w-0 items-stretch overflow-visible
relative flex min-w-0 overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm transition-colors
relative flex shrink-0 items-center justify-center border-r border-zinc-200 bg-zinc-50 p-1.5
relative flex w-full cursor-default items-center gap-2 rounded-md px-2 py-1.5 text-sm outline-none select-none
relative z-10 w-full rounded-xl border border-zinc-200 bg-white p-0 text-zinc-950 shadow-xl
repeater flex min-w-0 flex-col gap-3
repeater-item-template-
resize-none overflow-hidden
right-4 top-4 items-end
ring-zinc-950/10 transition-[margin,opacity] duration-200 ease-out focus-visible:ring-2
ring-zinc-950/10 transition-[width,height,padding] duration-200 ease-out
ring-zinc-950/10 transition-transform hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2
ring-zinc-950/10 transition-transform peer-hover/menu-button:text-zinc-950 hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2
rounded-full px-3 py-1.5 text-sm font-medium data-[state=active]:bg-zinc-900 data-[state=active]:text-white dark:data-[state=active]:bg-zinc-100 dark:data-[state=active]:text-zinc-900
rounded-l-none border-l-0
rounded-lg
rounded-md px-3 py-1.5 text-sm font-medium data-[state=active]:bg-white data-[state=active]:text-zinc-950 data-[state=active]:shadow-sm dark:data-[state=active]:bg-zinc-950 dark:data-[state=active]:text-zinc-50
rounded-none
rounded-none border-l-0 border-r-0
rounded-none shadow-none
rounded-r-none border-r-0
select relative min-w-0
select__chip-remove
select-id
shadow-none focus-visible:z-10
sidebar__group-action
sidebar__group-label
size-10 text-sm
size-11 text-sm
size-12 sm:size-14 text-sm
size-12 text-base
size-12 text-sm
size-16 text-lg
size-3.5 shrink-0 opacity-50
size-4 shrink-0 opacity-50
size-6
size-6 text-[10px]
size-8 text-xs
size-9 text-sm
sr-only
switch-
text-center font-medium tabular-nums !px-0
text-emerald-700 dark:text-emerald-400
text-red-700 dark:text-red-400
text-red-950 dark:text-red-50
text-xs px-1.5 py-0
text-xs px-2 py-0.5
text-zinc-600 dark:text-zinc-300
text-zinc-700 ring-zinc-950/10 hover:bg-zinc-100 hover:text-zinc-950 focus-visible:ring-2
top-center
top-left
top-right
transition-colors outline-none
w-10
w-14
w-8
z-[200] flex w-[min(18rem,calc(100vw-1rem))] flex-col gap-3 rounded-md border border-zinc-200 bg-white p-3 shadow-md
CLASSES;
}
