(() => {
  // resources/assets/js/accordion.js
  var ACCORDION_SELECTOR = "[data-accordion]";
  var ITEM_SELECTOR = "[data-accordion-item]";
  var TRIGGER_SELECTOR = "[data-accordion-trigger]";
  var CONTENT_SELECTOR = "[data-accordion-content]";
  var initialized = /* @__PURE__ */ new WeakSet();
  function initAccordions(root = document) {
    root.querySelectorAll(ACCORDION_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized.has(element)) {
        return;
      }
      initialized.add(element);
      bindAccordion(element);
    });
  }
  function bindAccordion(accordion) {
    syncItemWiring(accordion);
    accordion.addEventListener("click", (event) => {
      const trigger = event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR) : null;
      if (!(trigger instanceof HTMLButtonElement) || !accordion.contains(trigger)) {
        return;
      }
      if (trigger.disabled) {
        return;
      }
      const item = trigger.closest(ITEM_SELECTOR);
      if (!(item instanceof HTMLElement) || item.dataset.accordionDisabled === "true") {
        return;
      }
      event.preventDefault();
      toggleItem(accordion, item);
    });
  }
  function syncItemWiring(accordion) {
    accordion.querySelectorAll(ITEM_SELECTOR).forEach((item) => {
      if (!(item instanceof HTMLElement)) {
        return;
      }
      const trigger = item.querySelector(TRIGGER_SELECTOR);
      const content = item.querySelector(CONTENT_SELECTOR);
      if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
      }
      if (!trigger.id) {
        trigger.id = `accordion-trigger-${Math.random().toString(36).slice(2, 10)}`;
      }
      if (!content.id) {
        content.id = `accordion-content-${Math.random().toString(36).slice(2, 10)}`;
      }
      trigger.setAttribute("aria-controls", content.id);
      content.setAttribute("aria-labelledby", trigger.id);
      content.setAttribute("role", "region");
      applyItemState(item, item.dataset.state === "open");
    });
  }
  function toggleItem(accordion, item) {
    var _a5;
    const willOpen = item.dataset.state !== "open";
    const exclusive = accordion.dataset.accordionExclusive === "true";
    if (willOpen && exclusive) {
      accordion.querySelectorAll(ITEM_SELECTOR).forEach((other) => {
        if (other instanceof HTMLElement && other !== item) {
          applyItemState(other, false);
        }
      });
    }
    applyItemState(item, willOpen);
    accordion.dispatchEvent(
      new CustomEvent("stencil:accordion:change", {
        bubbles: true,
        detail: {
          value: (_a5 = item.dataset.accordionValue) != null ? _a5 : null,
          open: willOpen
        }
      })
    );
  }
  function applyItemState(item, open) {
    const trigger = item.querySelector(TRIGGER_SELECTOR);
    const content = item.querySelector(CONTENT_SELECTOR);
    const accordion = item.closest(ACCORDION_SELECTOR);
    const transition = accordion instanceof HTMLElement && accordion.dataset.accordionTransition === "true";
    item.dataset.state = open ? "open" : "closed";
    if (trigger instanceof HTMLElement) {
      trigger.setAttribute("aria-expanded", open ? "true" : "false");
    }
    if (!(content instanceof HTMLElement)) {
      return;
    }
    content.dataset.state = open ? "open" : "closed";
    if (transition) {
      content.classList.toggle("grid-rows-[1fr]", open);
      content.classList.toggle("opacity-100", open);
      content.classList.toggle("grid-rows-[0fr]", !open);
      content.classList.toggle("opacity-0", !open);
      content.classList.remove("hidden");
      content.hidden = false;
      if (open) {
        content.removeAttribute("inert");
        content.removeAttribute("aria-hidden");
      } else {
        content.setAttribute("inert", "");
        content.setAttribute("aria-hidden", "true");
      }
    } else if (open) {
      content.hidden = false;
      content.classList.remove("hidden");
      content.removeAttribute("inert");
      content.removeAttribute("aria-hidden");
    } else {
      content.hidden = true;
      content.classList.add("hidden");
      content.removeAttribute("inert");
      content.removeAttribute("aria-hidden");
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initAccordions(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initAccordions());
    } else {
      initAccordions();
    }
  }

  // resources/assets/js/avatar.js
  var AVATAR_SELECTOR = "[data-avatar]";
  var IMAGE_SELECTOR = "[data-avatar-image]";
  var FALLBACK_SELECTOR = "[data-avatar-fallback]";
  var initialized2 = /* @__PURE__ */ new WeakSet();
  function initAvatars(root = document) {
    root.querySelectorAll(AVATAR_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized2.has(element)) {
        return;
      }
      initialized2.add(element);
      bindAvatar(element);
    });
  }
  function bindAvatar(avatar) {
    const image = avatar.querySelector(IMAGE_SELECTOR);
    const fallback = avatar.querySelector(FALLBACK_SELECTOR);
    if (!(image instanceof HTMLImageElement) || !(fallback instanceof HTMLElement)) {
      return;
    }
    fallback.hidden = true;
    const hideImage = () => {
      image.hidden = true;
      image.classList.add("hidden");
      fallback.hidden = false;
      fallback.classList.remove("hidden");
    };
    if (image.complete && image.naturalWidth === 0) {
      hideImage();
      return;
    }
    image.addEventListener("error", hideImage, { once: true });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initAvatars(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initAvatars());
    } else {
      initAvatars();
    }
  }

  // resources/assets/js/shared/date-value.js
  var DateValue = class _DateValue {
    /**
     * @param {number} year
     * @param {number} month 1-12
     * @param {number} day
     */
    constructor(year, month, day = 1) {
      this._date = new Date(Date.UTC(year, month - 1, day));
    }
    /**
     * @param {DateValue | null} min
     * @param {DateValue | null} max
     */
    isBetween(min, max) {
      if (!min && !max) {
        return true;
      }
      if (!min) {
        return this._date <= max._date;
      }
      if (!max) {
        return this._date >= min._date;
      }
      return this._date >= min._date && this._date <= max._date;
    }
    /**
     * @param {DateValue | null} date
     */
    isSameDay(date) {
      if (!date) {
        return false;
      }
      return this._date.getUTCDate() === date._date.getUTCDate() && this._date.getUTCMonth() === date._date.getUTCMonth() && this._date.getUTCFullYear() === date._date.getUTCFullYear();
    }
    /**
     * @param {DateValue} date
     */
    isBefore(date) {
      return this._date < date._date;
    }
    /**
     * @param {DateValue} date
     */
    isAfter(date) {
      return this._date > date._date;
    }
    incrementDays(days) {
      const copy = this.getCopy();
      copy._date.setUTCDate(copy._date.getUTCDate() + days);
      return copy;
    }
    addMonths(months) {
      const copy = this.getCopy();
      copy._date.setUTCMonth(copy._date.getUTCMonth() + months);
      return copy;
    }
    addDays(days) {
      return this.incrementDays(days);
    }
    getYear() {
      return this._date.getUTCFullYear();
    }
    getMonth() {
      return this._date.getUTCMonth() + 1;
    }
    getPaddedMonth() {
      return String(this.getMonth()).padStart(2, "0");
    }
    getDay() {
      return this._date.getUTCDate();
    }
    getPaddedDay() {
      return String(this.getDay()).padStart(2, "0");
    }
    getDate() {
      return this._date;
    }
    getCopy() {
      return new _DateValue(this.getYear(), this.getMonth(), this.getDay());
    }
    getDayOfWeek() {
      return this._date.getUTCDay();
    }
    getDaysInMonth() {
      return new _DateValue(this.getYear(), this.getMonth() + 1, 0).getDay();
    }
    getFirstDayOfMonth() {
      return new _DateValue(this.getYear(), this.getMonth(), 1).getDayOfWeek();
    }
    toIsoDateString() {
      return [this.getYear(), this.getPaddedMonth(), this.getPaddedDay()].join("-");
    }
    /**
     * @param {string | null | undefined} isoString
     */
    static fromIsoDateString(isoString) {
      var _a5;
      if (!isoString) {
        return null;
      }
      const datePart = (_a5 = isoString.split("T")[0]) != null ? _a5 : "";
      const [year, month, day] = datePart.split("-").map(Number);
      if (!year || !month || !day) {
        return null;
      }
      return new _DateValue(year, month, day);
    }
    /**
     * @param {Date} date
     */
    static fromDate(date) {
      if (!date) {
        return null;
      }
      return new _DateValue(date.getFullYear(), date.getMonth() + 1, date.getDate());
    }
    static today() {
      return _DateValue.fromDate(/* @__PURE__ */ new Date());
    }
  };

  // resources/assets/js/shared/date-parse.js
  function toIsoDateTimeString(date) {
    const pad = (n) => String(n).padStart(2, "0");
    return `${date.getUTCFullYear()}-${pad(date.getUTCMonth() + 1)}-${pad(date.getUTCDate())}T${pad(date.getUTCHours())}:${pad(date.getUTCMinutes())}:${pad(date.getUTCSeconds())}Z`;
  }
  function parseRangeValue(rangeValue) {
    if (!rangeValue || !rangeValue.includes("/")) {
      return { start: null, end: null };
    }
    const [start, end] = rangeValue.split("/");
    return { start: start || null, end: end || null };
  }
  function formatRangeValue(start, end) {
    if (!start || !end) {
      return "";
    }
    return `${start}/${end}`;
  }

  // resources/assets/js/shared/date-timezone.js
  function todayInTimeZone(timeZone) {
    var _a5, _b, _c;
    const formatter = new Intl.DateTimeFormat("en-US", {
      timeZone,
      year: "numeric",
      month: "2-digit",
      day: "2-digit"
    });
    const parts = formatter.formatToParts(/* @__PURE__ */ new Date());
    const year = Number((_a5 = parts.find((p) => p.type === "year")) == null ? void 0 : _a5.value);
    const month = Number((_b = parts.find((p) => p.type === "month")) == null ? void 0 : _b.value);
    const day = Number((_c = parts.find((p) => p.type === "day")) == null ? void 0 : _c.value);
    return new DateValue(year, month, day);
  }
  function formatDateValue(dateValue, locale, options = {}) {
    return new Intl.DateTimeFormat(locale, {
      ...options,
      timeZone: "UTC"
    }).format(dateValue.getDate());
  }
  function formatDateLabel(isoDate, locale) {
    if (!isoDate) {
      return "";
    }
    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(isoDate);
    if (!match) {
      return isoDate;
    }
    const date = new Date(Date.UTC(Number(match[1]), Number(match[2]) - 1, Number(match[3])));
    return new Intl.DateTimeFormat(locale, {
      year: "numeric",
      month: "short",
      day: "numeric",
      timeZone: "UTC"
    }).format(date);
  }
  function formatDateTimeLabel(isoDatetime, locale, timeZone, withSeconds = false) {
    if (!isoDatetime) {
      return "";
    }
    const date = new Date(isoDatetime);
    if (Number.isNaN(date.getTime())) {
      return isoDatetime;
    }
    return new Intl.DateTimeFormat(locale, {
      year: "numeric",
      month: "short",
      day: "numeric",
      hour: "numeric",
      minute: "2-digit",
      second: withSeconds ? "2-digit" : void 0,
      timeZone
    }).format(date);
  }
  function formatTimeLabel(time, locale, _timeZone, withSeconds = false) {
    if (!time) {
      return "";
    }
    const [h, m, s] = time.split(":").map((v) => parseInt(v, 10) || 0);
    const date = new Date(Date.UTC(1970, 0, 1, h, m, s || 0));
    return new Intl.DateTimeFormat(locale, {
      hour: "numeric",
      minute: "2-digit",
      second: withSeconds ? "2-digit" : void 0,
      timeZone: "UTC"
    }).format(date);
  }

  // resources/assets/js/calendar.js
  var CALENDAR_SELECTOR = "[data-calendar]";
  var initialized3 = /* @__PURE__ */ new WeakSet();
  function initCalendars(root = document) {
    root.querySelectorAll(CALENDAR_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (element.closest("[data-date-picker], [data-datetime-picker]")) {
        return;
      }
      if (initialized3.has(element)) {
        return;
      }
      initialized3.add(element);
      bindCalendar(element);
    });
  }
  function bindCalendar(root) {
    var _a5;
    if (root.dataset.calendarBound === "true") {
      return {
        getValue: () => {
          var _a6;
          return (_a6 = root.dataset.calendarValue) != null ? _a6 : "";
        },
        setValue: () => {
        },
        confirm: () => {
        },
        render: () => {
        }
      };
    }
    root.dataset.calendarBound = "true";
    const config = readConfig(root);
    const state = createState(root, config);
    const initialValue = (_a5 = root.dataset.calendarValue) != null ? _a5 : "";
    const deferRender = root.closest("[data-date-picker-panel], [data-datetime-picker-panel]") !== null;
    const monthsEl = root.querySelector(":scope > [data-calendar-months-container]");
    const prevBtn = root.querySelector("[data-calendar-prev]");
    const nextBtn = root.querySelector("[data-calendar-next]");
    const todayBtn = root.querySelector("[data-calendar-today]");
    const monthLabel = root.querySelector("[data-calendar-month-label]");
    const headerEl = root.querySelector("[data-calendar-header]");
    if (monthsEl instanceof HTMLElement) {
      monthsEl.style.display = "flex";
      monthsEl.style.gap = "1rem";
    }
    if (headerEl instanceof HTMLElement) {
      headerEl.style.display = "flex";
      headerEl.style.alignItems = "center";
      headerEl.style.justifyContent = "space-between";
      headerEl.style.gap = "0.5rem";
      headerEl.style.marginBottom = "0.5rem";
    }
    function render() {
      if (!(monthsEl instanceof HTMLElement)) {
        return;
      }
      monthsEl.innerHTML = "";
      for (let i = 0; i < config.monthCount; i++) {
        const view = state.viewMonth.addMonths(i);
        monthsEl.appendChild(buildMonthTable(view, config, state));
      }
      if (monthLabel instanceof HTMLElement) {
        if (config.monthCount > 1) {
          monthLabel.textContent = "";
          monthLabel.style.display = "none";
        } else {
          monthLabel.style.display = "";
          const first = state.viewMonth;
          monthLabel.textContent = formatDateValue(first, config.locale, {
            month: "long",
            year: "numeric"
          });
        }
      }
      if (todayBtn instanceof HTMLElement) {
        const label = todayBtn.querySelector("[data-calendar-today-label]");
        if (label instanceof HTMLElement) {
          label.textContent = String(state.today.getDay());
        }
      }
      root.dispatchEvent(new CustomEvent("calendar:render", { bubbles: true }));
    }
    function commitSelection() {
      const value = serializeSelection(state, config.mode);
      root.dataset.calendarValue = value;
      root.dispatchEvent(
        new CustomEvent("calendar:change", {
          bubbles: true,
          detail: { value, state: { ...state.selection } }
        })
      );
    }
    function focusedDay() {
      var _a6, _b, _c;
      return (_c = (_b = (_a6 = state.selection.focus) != null ? _a6 : state.selection.start) != null ? _b : state.selection.end) != null ? _c : state.today;
    }
    function ensureFocusVisible(day) {
      const viewStart = new DateValue(state.viewMonth.getYear(), state.viewMonth.getMonth(), 1);
      const lastMonth = state.viewMonth.addMonths(config.monthCount - 1);
      const viewEnd = new DateValue(
        lastMonth.getYear(),
        lastMonth.getMonth(),
        lastMonth.getDaysInMonth()
      );
      if (day.isBefore(viewStart)) {
        state.viewMonth = new DateValue(day.getYear(), day.getMonth(), 1);
      } else if (day.isAfter(viewEnd)) {
        state.viewMonth = new DateValue(day.getYear(), day.getMonth(), 1).addMonths(
          -(config.monthCount - 1)
        );
      }
    }
    function focusActiveDayButton() {
      var _a6;
      const iso = focusedDay().toIsoDateString();
      const button = (_a6 = root.querySelector(`[data-calendar-day="${iso}"][tabindex="0"]`)) != null ? _a6 : root.querySelector(`[data-calendar-day="${iso}"]:not([disabled])`);
      if (button instanceof HTMLButtonElement) {
        button.focus();
      }
    }
    function moveFocusTo(day) {
      state.selection.focus = day;
      ensureFocusVisible(day);
      render();
      focusActiveDayButton();
    }
    prevBtn == null ? void 0 : prevBtn.addEventListener("click", () => {
      state.viewMonth = state.viewMonth.addMonths(-1);
      render();
    });
    nextBtn == null ? void 0 : nextBtn.addEventListener("click", () => {
      state.viewMonth = state.viewMonth.addMonths(1);
      render();
    });
    todayBtn == null ? void 0 : todayBtn.addEventListener("click", () => {
      if (state.today.isSameDay(state.viewMonth) === false) {
        state.viewMonth = state.today.getCopy();
        state.selection.focus = state.today.getCopy();
        render();
        focusActiveDayButton();
        return;
      }
      state.selection.focus = state.today.getCopy();
      selectDay(state.today, state, config);
      render();
      focusActiveDayButton();
      if (!config.withConfirmation && shouldCommitSelection(state, config)) {
        commitSelection();
      }
    });
    root.addEventListener("click", (event) => {
      const target = event.target instanceof Element ? event.target.closest("[data-calendar-day]") : null;
      if (!(target instanceof HTMLButtonElement) || target.disabled) {
        return;
      }
      const iso = target.dataset.calendarDay;
      if (!iso) {
        return;
      }
      const day = DateValue.fromIsoDateString(iso);
      if (!day) {
        return;
      }
      state.selection.focus = day;
      selectDay(day, state, config);
      render();
      focusActiveDayButton();
      if (!config.withConfirmation && shouldCommitSelection(state, config)) {
        commitSelection();
      }
    });
    root.addEventListener("keydown", (event) => {
      const dayTarget = event.target instanceof Element ? event.target.closest("[data-calendar-day]") : null;
      if (!dayTarget && event.target !== root) {
        return;
      }
      const navigationKeys = [
        "ArrowLeft",
        "ArrowRight",
        "ArrowUp",
        "ArrowDown",
        "Home",
        "End",
        "PageUp",
        "PageDown"
      ];
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        const day = focusedDay();
        if (!isSelectable(day, config, state.today)) {
          return;
        }
        selectDay(day, state, config);
        state.selection.focus = day;
        render();
        focusActiveDayButton();
        if (!config.withConfirmation && shouldCommitSelection(state, config)) {
          commitSelection();
        }
        return;
      }
      if (!navigationKeys.includes(event.key)) {
        return;
      }
      event.preventDefault();
      const base = focusedDay();
      let next = base;
      if (event.key === "ArrowLeft") {
        next = base.incrementDays(-1);
      } else if (event.key === "ArrowRight") {
        next = base.incrementDays(1);
      } else if (event.key === "ArrowUp") {
        next = base.incrementDays(-7);
      } else if (event.key === "ArrowDown") {
        next = base.incrementDays(7);
      } else if (event.key === "Home") {
        const offset = (base.getDayOfWeek() - config.startDay + 7) % 7;
        next = base.incrementDays(-offset);
      } else if (event.key === "End") {
        const offset = (base.getDayOfWeek() - config.startDay + 7) % 7;
        next = base.incrementDays(6 - offset);
      } else if (event.key === "PageUp") {
        next = base.addMonths(event.shiftKey ? -12 : -1);
      } else if (event.key === "PageDown") {
        next = base.addMonths(event.shiftKey ? 12 : 1);
      }
      moveFocusTo(next);
    });
    root.addEventListener("calendar:confirm", () => {
      commitSelection();
    });
    root.addEventListener("calendar:cancel", () => {
      var _a6;
      loadInitialSelection(state, config, (_a6 = root.dataset.calendarValue) != null ? _a6 : initialValue);
      render();
    });
    if (!deferRender) {
      render();
    }
    return {
      getValue: () => serializeSelection(state, config.mode),
      setValue: (value) => {
        loadValueIntoState(value, state, config.mode);
        render();
      },
      confirm: commitSelection,
      render
    };
  }
  function readConfig(root) {
    var _a5, _b, _c, _d, _e, _f, _g, _h;
    const mode = root.dataset.calendarMode === "range" ? "range" : "single";
    const monthCount = Math.max(1, parseInt((_a5 = root.dataset.calendarMonthCount) != null ? _a5 : "1", 10) || 1);
    return {
      mode,
      monthCount,
      locale: (_b = root.dataset.calendarLocale) != null ? _b : "en",
      timezone: (_c = root.dataset.calendarTimezone) != null ? _c : "UTC",
      startDay: parseInt((_d = root.dataset.calendarStartDay) != null ? _d : "0", 10) || 0,
      min: parseBound(root.dataset.calendarMin),
      max: parseBound(root.dataset.calendarMax),
      unavailable: ((_e = root.dataset.calendarUnavailable) != null ? _e : "").split(",").map((s) => s.trim()).filter(Boolean),
      minRange: parseInt((_f = root.dataset.calendarMinRange) != null ? _f : "", 10) || null,
      maxRange: parseInt((_g = root.dataset.calendarMaxRange) != null ? _g : "", 10) || null,
      withConfirmation: root.closest("[data-date-picker-with-confirmation]") !== null,
      sizeClass: (_h = root.dataset.calendarSizeClass) != null ? _h : "size-10 text-sm",
      weekNumbers: root.hasAttribute("data-calendar-week-numbers"),
      fixedWeeks: root.hasAttribute("data-calendar-fixed-weeks") || monthCount > 1
    };
  }
  function parseBound(bound) {
    if (!bound) {
      return null;
    }
    if (bound === "today") {
      return "today";
    }
    return DateValue.fromIsoDateString(bound);
  }
  function createState(root, config) {
    var _a5, _b;
    const today = todayInTimeZone(config.timezone);
    const openTo = DateValue.fromIsoDateString((_a5 = root.dataset.calendarOpenTo) != null ? _a5 : "");
    const initial = (_b = root.dataset.calendarValue) != null ? _b : "";
    const state = {
      today,
      viewMonth: openTo != null ? openTo : today,
      selection: {
        start: null,
        end: null,
        focus: null
      }
    };
    loadInitialSelection(state, config, initial);
    return state;
  }
  function loadInitialSelection(state, config, initial = "") {
    loadValueIntoState(initial || "", state, config.mode);
    if (state.selection.start) {
      state.viewMonth = state.selection.start.getCopy();
    }
  }
  function loadValueIntoState(value, state, mode) {
    var _a5, _b;
    state.selection.start = null;
    state.selection.end = null;
    state.selection.focus = null;
    if (!value) {
      return;
    }
    if (mode === "range") {
      const { start, end } = parseRangeValue(value);
      state.selection.start = DateValue.fromIsoDateString(start != null ? start : "");
      state.selection.end = DateValue.fromIsoDateString(end != null ? end : "");
      state.selection.focus = (_a5 = state.selection.end) != null ? _a5 : state.selection.start;
      return;
    }
    state.selection.start = DateValue.fromIsoDateString((_b = value.split(",")[0]) != null ? _b : value);
    state.selection.focus = state.selection.start;
  }
  function selectDay(day, state, config) {
    if (config.mode === "range") {
      if (!state.selection.start || state.selection.start && state.selection.end) {
        state.selection.start = day;
        state.selection.end = null;
      } else if (day.isBefore(state.selection.start)) {
        state.selection.end = state.selection.start;
        state.selection.start = day;
      } else {
        state.selection.end = day;
      }
      if (state.selection.start && state.selection.end && config.minRange) {
        const days = diffDays(state.selection.start, state.selection.end) + 1;
        if (days < config.minRange) {
          state.selection.end = null;
        }
      }
      return;
    }
    state.selection.start = day;
    state.selection.end = null;
  }
  function diffDays(a, b) {
    const ms = Math.abs(b.getDate().getTime() - a.getDate().getTime());
    return Math.floor(ms / (24 * 60 * 60 * 1e3));
  }
  function serializeSelection(state, mode) {
    var _a5, _b, _c, _d, _e, _f;
    if (mode === "range") {
      return formatRangeValue(
        (_b = (_a5 = state.selection.start) == null ? void 0 : _a5.toIsoDateString()) != null ? _b : null,
        (_d = (_c = state.selection.end) == null ? void 0 : _c.toIsoDateString()) != null ? _d : null
      );
    }
    return (_f = (_e = state.selection.start) == null ? void 0 : _e.toIsoDateString()) != null ? _f : "";
  }
  function buildMonthTable(viewMonth, config, state) {
    var _a5, _b, _c;
    const wrap = document.createElement("div");
    wrap.className = "calendar__month shrink-0";
    wrap.style.width = "17.5rem";
    wrap.style.flexShrink = "0";
    const focusDay = (_c = (_b = (_a5 = state.selection.focus) != null ? _a5 : state.selection.start) != null ? _b : state.selection.end) != null ? _c : state.today;
    if (config.monthCount > 1) {
      const monthTitle = document.createElement("div");
      monthTitle.className = "calendar__month-title mb-2 text-center text-sm font-medium leading-5 text-zinc-800 dark:text-zinc-50";
      monthTitle.textContent = formatDateValue(viewMonth, config.locale, {
        month: "long",
        year: "numeric"
      });
      wrap.appendChild(monthTitle);
    }
    const grid = document.createElement("div");
    grid.setAttribute("role", "grid");
    grid.className = "calendar__grid";
    grid.style.display = "grid";
    grid.style.gridTemplateColumns = "repeat(7, minmax(0, 1fr))";
    grid.style.gap = "2px";
    for (let i = 0; i < 7; i++) {
      const header = document.createElement("div");
      header.setAttribute("role", "columnheader");
      header.className = `flex ${config.sizeClass} items-center justify-center font-medium text-zinc-500`;
      const idx = (i + config.startDay) % 7;
      const date = new Date(2024, 0, 7 + idx);
      header.textContent = new Intl.DateTimeFormat(config.locale, { weekday: "narrow" }).format(
        date
      );
      grid.appendChild(header);
    }
    const first = new DateValue(viewMonth.getYear(), viewMonth.getMonth(), 1);
    let cursor = first.incrementDays(-((first.getDayOfWeek() - config.startDay + 7) % 7));
    const weeks = config.fixedWeeks ? 6 : weeksInMonth(viewMonth, config.startDay);
    for (let w = 0; w < weeks; w++) {
      for (let d = 0; d < 7; d++) {
        const cellDay = cursor;
        cursor = cursor.incrementDays(1);
        const cell = document.createElement("div");
        cell.className = "p-0";
        cell.setAttribute("role", "gridcell");
        const inMonth = cellDay.getMonth() === viewMonth.getMonth();
        const iso = cellDay.toIsoDateString();
        const disabled = !isSelectable(cellDay, config, state.today);
        const btn = document.createElement("button");
        btn.type = "button";
        btn.dataset.calendarDay = iso;
        btn.className = `flex ${config.sizeClass} w-full items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800`;
        btn.textContent = String(cellDay.getDay());
        btn.setAttribute(
          "aria-label",
          formatDateValue(cellDay, config.locale, {
            weekday: "long",
            month: "long",
            day: "numeric",
            year: "numeric"
          })
        );
        btn.setAttribute("aria-selected", isSelected(cellDay, state) ? "true" : "false");
        btn.tabIndex = !disabled && inMonth && cellDay.isSameDay(focusDay) ? 0 : -1;
        if (!inMonth) {
          btn.classList.add("opacity-40");
        }
        if (cellDay.isSameDay(state.today)) {
          btn.dataset.calendarToday = "true";
        }
        if (isInRange(cellDay, state)) {
          btn.dataset.calendarInRange = "true";
          btn.classList.add("bg-zinc-100", "dark:bg-zinc-800");
        }
        if (isSelected(cellDay, state)) {
          btn.classList.add(
            "bg-zinc-900",
            "text-white",
            "dark:bg-zinc-50",
            "dark:text-zinc-900"
          );
        }
        if (disabled) {
          btn.disabled = true;
        }
        cell.appendChild(btn);
        grid.appendChild(cell);
      }
    }
    wrap.appendChild(grid);
    return wrap;
  }
  function weeksInMonth(viewMonth, startDay) {
    const first = new DateValue(viewMonth.getYear(), viewMonth.getMonth(), 1);
    const padding = (first.getDayOfWeek() - startDay + 7) % 7;
    const total = padding + first.getDaysInMonth();
    return Math.ceil(total / 7);
  }
  function shouldCommitSelection(state, config) {
    if (config.mode === "range") {
      return !!(state.selection.start && state.selection.end);
    }
    return !!state.selection.start;
  }
  function isSelected(day, state) {
    if (state.selection.start && day.isSameDay(state.selection.start)) {
      return true;
    }
    return !!(state.selection.end && day.isSameDay(state.selection.end));
  }
  function isInRange(day, state) {
    if (!state.selection.start || !state.selection.end) {
      return false;
    }
    return day.isBetween(state.selection.start, state.selection.end);
  }
  function isSelectable(day, config, today) {
    let min = config.min;
    let max = config.max;
    if (min === "today") {
      min = today;
    }
    if (max === "today") {
      max = today;
    }
    if (min instanceof DateValue && day.isBefore(min)) {
      return false;
    }
    if (max instanceof DateValue && day.isAfter(max)) {
      return false;
    }
    if (config.unavailable.includes(day.toIsoDateString())) {
      return false;
    }
    return true;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initCalendars(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initCalendars());
    } else {
      initCalendars();
    }
  }

  // resources/assets/js/chart.js
  var ROOT_SELECTOR = "[data-chart]";
  var TEMPLATE_SELECTOR = "template[data-chart-template]";
  var SVG_NAMESPACE = "http://www.w3.org/2000/svg";
  var SVG_TAGS = /* @__PURE__ */ new Set(["svg", "path", "line", "circle", "g", "text", "rect"]);
  var initialized4 = /* @__PURE__ */ new WeakSet();
  var chartRuntimes = /* @__PURE__ */ new WeakMap();
  function isChartSvgElement(element) {
    return element instanceof SVGElement || element instanceof Element && SVG_TAGS.has(element.tagName.toLowerCase());
  }
  function cloneSvgElement(element) {
    if (element instanceof SVGElement) {
      return (
        /** @type {SVGElement} */
        element.cloneNode(true)
      );
    }
    const tag = element.tagName.toLowerCase();
    const svgElement = document.createElementNS(SVG_NAMESPACE, tag);
    for (const attr of element.attributes) {
      svgElement.setAttribute(attr.name, attr.value);
    }
    if (element.textContent) {
      svgElement.textContent = element.textContent;
    }
    return svgElement;
  }
  function initCharts(root = document) {
    root.querySelectorAll(ROOT_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      const hasRenderedSeries = element.querySelector(
        "[data-chart-series], [data-chart-bar], [data-chart-point]"
      );
      if (initialized4.has(element) && hasRenderedSeries) {
        return;
      }
      initialized4.add(element);
      bindChart(element);
    });
  }
  function bindChartKeyboard(root) {
    if (root.dataset.chartKeyboardBound === "true") {
      return;
    }
    root.dataset.chartKeyboardBound = "true";
    root.addEventListener("keydown", (event) => {
      const runtime = chartRuntimes.get(root);
      if (!runtime) {
        return;
      }
      const { state, setActive } = runtime;
      const current = runtime.activeIndex;
      let next = current;
      switch (event.key) {
        case "ArrowRight":
        case "ArrowUp":
          next = current < 0 ? 0 : Math.min(current + 1, state.data.length - 1);
          break;
        case "ArrowLeft":
        case "ArrowDown":
          next = current < 0 ? state.data.length - 1 : Math.max(current - 1, 0);
          break;
        case "Home":
          next = 0;
          break;
        case "End":
          next = state.data.length - 1;
          break;
        case "Escape":
          next = -1;
          break;
        default:
          return;
      }
      event.preventDefault();
      setActive(next);
    });
  }
  function bindChart(root) {
    let resizeObserver = null;
    let valueObserver = null;
    let activeIndex = -1;
    const render = () => {
      const state = buildChartState(root);
      if (!state) {
        return;
      }
      drawChart(root, state, activeIndex, (index) => {
        activeIndex = index;
      });
      bindChartKeyboard(root);
    };
    render();
    resizeObserver = new ResizeObserver(() => {
      render();
    });
    resizeObserver.observe(root);
    valueObserver = new MutationObserver(() => {
      render();
    });
    valueObserver.observe(root, {
      attributes: true,
      attributeFilter: ["data-chart-value"]
    });
  }
  function buildChartState(root) {
    var _a5, _b;
    const data = readChartData(root);
    if (data.length < 2) {
      return null;
    }
    const svgTemplate = root.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="svg"]`);
    if (!(svgTemplate instanceof HTMLTemplateElement)) {
      return null;
    }
    const svgSource = svgTemplate.content.querySelector("svg");
    if (!(svgSource instanceof SVGSVGElement)) {
      return null;
    }
    const gutter = parseGutter(svgTemplate.dataset.gutter);
    const axes = parseAxes(svgTemplate);
    const series = parseSeries(svgTemplate);
    const hasCursor = Boolean(
      svgTemplate.content.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`)
    );
    const hasZeroLine = Boolean(
      svgTemplate.content.querySelector(`${TEMPLATE_SELECTOR}[data-chart-template="zero-line"]`)
    );
    const xField = (_b = (_a5 = axes.x) == null ? void 0 : _a5.field) != null ? _b : "index";
    const yFields = collectYFields(series);
    if (yFields.length === 0) {
      yFields.push("value");
    }
    const tooltipEl = mountOverlay(root, "tooltip");
    const summaryEl = mountOverlay(root, "summary");
    return {
      data,
      svgTemplate,
      svgSource,
      gutter,
      axes,
      series,
      hasCursor,
      hasZeroLine,
      xField,
      yFields,
      tooltipEl,
      summaryEl,
      cursorConfig: readCursorConfig(svgTemplate)
    };
  }
  function readChartData(root) {
    var _a5;
    const raw = (_a5 = root.getAttribute("data-chart-value")) != null ? _a5 : root.getAttribute("value");
    if (!raw) {
      return [];
    }
    try {
      const parsed = JSON.parse(raw);
      return normalizeData(parsed);
    } catch (e) {
      return [];
    }
  }
  function normalizeData(value) {
    if (!Array.isArray(value) || value.length === 0) {
      return [];
    }
    if (typeof value[0] === "number") {
      return value.map((entry, index) => ({
        value: entry,
        index
      }));
    }
    return value.map((entry, index) => {
      var _a5;
      if (typeof entry !== "object" || entry === null) {
        return { value: entry, index };
      }
      return {
        ...entry,
        index: (_a5 = entry.index) != null ? _a5 : index
      };
    });
  }
  function parseGutter(gutter) {
    var _a5, _b, _c, _d;
    const parts = (gutter != null ? gutter : "28 36 32 40").trim().split(/\s+/).map((part) => Number.parseFloat(part)).filter((part) => Number.isFinite(part));
    if (parts.length === 1) {
      return { top: parts[0], right: parts[0], bottom: parts[0], left: parts[0] };
    }
    if (parts.length === 2) {
      return { top: parts[0], right: parts[1], bottom: parts[0], left: parts[1] };
    }
    if (parts.length === 3) {
      return { top: parts[0], right: parts[1], bottom: parts[2], left: parts[1] };
    }
    return {
      top: (_a5 = parts[0]) != null ? _a5 : 28,
      right: (_b = parts[1]) != null ? _b : 36,
      bottom: (_c = parts[2]) != null ? _c : 32,
      left: (_d = parts[3]) != null ? _d : 40
    };
  }
  function findAxisTemplate(svgTemplate, axis) {
    var _a5;
    return (_a5 = childChartTemplates(svgTemplate.content).find(
      (node) => node.dataset.chartTemplate === "axis" && (node.dataset.axis === axis || axis === "x" && node.dataset.axis !== "y")
    )) != null ? _a5 : null;
  }
  function findAxisPartTemplate(svgTemplate, axis, part) {
    var _a5;
    const axisTemplate = findAxisTemplate(svgTemplate, axis);
    if (!axisTemplate) {
      return null;
    }
    return (_a5 = childChartTemplates(axisTemplate.content).find(
      (node) => node.dataset.chartTemplate === part
    )) != null ? _a5 : null;
  }
  function parseAxes(svgTemplate) {
    const axes = {};
    childChartTemplates(svgTemplate.content).filter((template) => template.dataset.chartTemplate === "axis").forEach((template) => {
      var _a5, _b, _c, _d, _e;
      const axis = template.dataset.axis === "y" ? "y" : "x";
      const tickValues = parseTickValues(template.dataset.tickValues);
      axes[axis] = {
        field: (_a5 = template.dataset.field) != null ? _a5 : axis === "x" ? "date" : "value",
        format: (_b = template.dataset.format) != null ? _b : null,
        position: (_c = template.dataset.position) != null ? _c : null,
        tickValues,
        tickCount: parseOptionalNumber(template.dataset.tickCount),
        tickStart: parseOptionalNumber(template.dataset.tickStart),
        tickEnd: parseOptionalNumber(template.dataset.tickEnd),
        tickStep: parseOptionalNumber(template.dataset.tickStep),
        tickPrefix: (_d = template.dataset.tickPrefix) != null ? _d : null,
        tickSuffix: (_e = template.dataset.tickSuffix) != null ? _e : null,
        attrs: { ...template.dataset }
      };
    });
    return axes;
  }
  function parseTickValues(raw) {
    if (!raw) {
      return null;
    }
    try {
      const parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed.map(Number).filter(Number.isFinite) : null;
    } catch (e) {
      return null;
    }
  }
  function parseOptionalNumber(raw) {
    if (!raw) {
      return null;
    }
    const value = Number.parseFloat(raw);
    return Number.isFinite(value) ? value : null;
  }
  function childChartTemplates(parent) {
    if (parent instanceof DocumentFragment || parent instanceof Element) {
      return [...parent.children].filter(
        (node) => node instanceof HTMLTemplateElement && node.hasAttribute("data-chart-template")
      );
    }
    return [];
  }
  function parseSeries(svgTemplate) {
    const series = [];
    const walk = (parent, layout = "default", layoutWidth = null, layoutGap = null) => {
      childChartTemplates(parent).forEach((node) => {
        var _a5, _b, _c, _d, _e, _f, _g;
        const type = node.dataset.chartTemplate;
        if (type === "stack" || type === "group") {
          walk(node.content, type, (_a5 = node.dataset.width) != null ? _a5 : null, (_b = node.dataset.gap) != null ? _b : null);
          return;
        }
        if (!["line", "area", "bar", "point"].includes(type != null ? type : "")) {
          return;
        }
        const prototype = node.content.firstElementChild;
        if (!isChartSvgElement(prototype)) {
          return;
        }
        series.push({
          type: (
            /** @type {'line' | 'area' | 'bar' | 'point'} */
            type
          ),
          field: (_c = node.dataset.field) != null ? _c : "value",
          curve: (_d = node.dataset.curve) != null ? _d : null,
          width: (_e = node.dataset.width) != null ? _e : null,
          radius: (_f = node.dataset.radius) != null ? _f : null,
          minHeight: (_g = node.dataset.minHeight) != null ? _g : null,
          prototype,
          layout,
          layoutWidth,
          layoutGap
        });
      });
    };
    walk(svgTemplate.content);
    return series;
  }
  function collectYFields(series) {
    return [...new Set(series.map((entry) => entry.field))];
  }
  function readCursorConfig(svgTemplate) {
    var _a5, _b, _c;
    const template = svgTemplate.content.querySelector(
      `${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`
    );
    const path = template == null ? void 0 : template.content.querySelector("path");
    return {
      type: (_b = (_a5 = path == null ? void 0 : path.getAttribute("data-cursor-type")) != null ? _a5 : path == null ? void 0 : path.getAttribute("type")) != null ? _b : "line",
      radius: Number.parseFloat((_c = path == null ? void 0 : path.getAttribute("r")) != null ? _c : "0") || void 0
    };
  }
  function mountOverlay(root, kind) {
    var _a5;
    const selector = `${TEMPLATE_SELECTOR}[data-chart-template="${kind}"]`;
    const template = root.querySelector(selector);
    if (!(template instanceof HTMLTemplateElement)) {
      return null;
    }
    const key = `data-chart-mounted-${kind}`;
    let mounted = root.querySelector(`[${key}]`);
    if (!(mounted instanceof HTMLElement)) {
      mounted = (_a5 = template.content.firstElementChild) == null ? void 0 : _a5.cloneNode(true);
      if (!(mounted instanceof HTMLElement)) {
        return null;
      }
      mounted.setAttribute(key, "true");
      mounted.hidden = true;
      root.appendChild(mounted);
    }
    return mounted;
  }
  function drawChart(root, state, activeIndex, onActive) {
    let canvas = root.querySelector("[data-chart-canvas]");
    if (!(canvas instanceof HTMLElement)) {
      canvas = document.createElement("div");
      canvas.dataset.chartCanvas = "true";
      canvas.className = "absolute inset-0";
      root.appendChild(canvas);
    }
    canvas.replaceChildren();
    const width = Math.max(root.clientWidth, 1);
    const height = Math.max(root.clientHeight, 1);
    const plot = {
      x: state.gutter.left,
      y: state.gutter.top,
      width: Math.max(width - state.gutter.left - state.gutter.right, 1),
      height: Math.max(height - state.gutter.top - state.gutter.bottom, 1)
    };
    const svg = state.svgSource.cloneNode(true);
    svg.setAttribute("width", String(width));
    svg.setAttribute("height", String(height));
    svg.setAttribute("viewBox", `0 0 ${width} ${height}`);
    svg.setAttribute("aria-hidden", "true");
    svg.setAttribute("focusable", "false");
    svg.classList.add("size-full");
    const scales = createScales(state, plot);
    const layer = document.createElementNS("http://www.w3.org/2000/svg", "g");
    layer.setAttribute("data-chart-layer", "true");
    const setActive = (index) => {
      onActive(index);
      redrawActive(root, state, plot, scales, svg, layer, index);
    };
    chartRuntimes.set(root, {
      state,
      plot,
      scales,
      svg,
      layer,
      activeIndex,
      setActive
    });
    drawGrid(layer, state, plot, scales);
    drawZeroLine(layer, state, plot, scales);
    drawSeries(layer, state, plot, scales, activeIndex);
    drawAxes(layer, state, plot, scales);
    if (state.hasCursor) {
      drawCursor(layer, state, plot, scales, activeIndex);
    }
    svg.appendChild(layer);
    const overlay = document.createElementNS("http://www.w3.org/2000/svg", "rect");
    overlay.setAttribute("x", String(plot.x));
    overlay.setAttribute("y", String(plot.y));
    overlay.setAttribute("width", String(plot.width));
    overlay.setAttribute("height", String(plot.height));
    overlay.setAttribute("fill", "transparent");
    overlay.setAttribute("data-chart-overlay", "true");
    overlay.style.cursor = "crosshair";
    overlay.addEventListener("mousemove", (event) => {
      const rect = svg.getBoundingClientRect();
      const x = (event.clientX - rect.left) / rect.width * width;
      const index = nearestIndex(state, scales, x);
      setActive(index);
    });
    overlay.addEventListener("mouseleave", () => {
      setActive(-1);
    });
    svg.appendChild(overlay);
    canvas.appendChild(svg);
    updateOverlays(root, state, activeIndex, plot, scales);
  }
  function chartHasBars(state) {
    return state.series.some((entry) => entry.type === "bar");
  }
  function createScales(state, plot) {
    var _a5, _b, _c, _d, _e, _f, _g, _h;
    const xValues = state.data.map((row) => row[state.xField]);
    const xType = detectScaleType(xValues);
    const bandScale = chartHasBars(state);
    const numericX = xType === "time" ? xValues.map((value) => new Date(String(value)).getTime()) : xType === "linear" ? xValues.map(Number) : xValues.map((_, index) => index);
    const yNumbers = [];
    state.yFields.forEach((field) => {
      state.data.forEach((row) => {
        const value = Number(row[field]);
        if (Number.isFinite(value)) {
          yNumbers.push(value);
        }
      });
    });
    const yMin = (_b = (_a5 = state.axes.y) == null ? void 0 : _a5.tickStart) != null ? _b : Math.min(0, ...yNumbers);
    const yMax = (_d = (_c = state.axes.y) == null ? void 0 : _c.tickEnd) != null ? _d : Math.max(...yNumbers, yMin + 1);
    const yTicks = (_h = (_e = state.axes.y) == null ? void 0 : _e.tickValues) != null ? _h : niceTicks(yMin, yMax, (_g = (_f = state.axes.y) == null ? void 0 : _f.tickCount) != null ? _g : 5);
    return {
      xType,
      plot,
      xValues,
      numericX,
      bandScale,
      xScale: (index) => {
        if (state.data.length === 1) {
          return plot.x + plot.width / 2;
        }
        if (bandScale) {
          const slotWidth = plot.width / state.data.length;
          return plot.x + (index + 0.5) * slotWidth;
        }
        return plot.x + index / (state.data.length - 1) * plot.width;
      },
      yScale: (value) => {
        const range = yMax - yMin || 1;
        return plot.y + plot.height - (value - yMin) / range * plot.height;
      },
      yMin,
      yMax,
      yTicks
    };
  }
  function detectScaleType(values) {
    if (values.every((value) => isDateLike(value))) {
      return "time";
    }
    if (values.every(
      (value) => typeof value === "number" || typeof value === "string" && value !== "" && !Number.isNaN(Number(value))
    )) {
      return "linear";
    }
    return "categorical";
  }
  function isDateLike(value) {
    if (value instanceof Date) {
      return true;
    }
    if (typeof value !== "string") {
      return false;
    }
    return !Number.isNaN(Date.parse(value));
  }
  function niceTicks(min, max, count) {
    if (count <= 1) {
      return [min, max];
    }
    const span = max - min || 1;
    const rawStep = span / Math.max(count - 1, 1);
    const step = niceTickStep(rawStep);
    const start = Math.floor(min / step) * step;
    const end = Math.ceil(max / step) * step;
    const ticks = [];
    for (let tick = start; tick <= end + step * 1e-3; tick += step) {
      ticks.push(Number(tick.toFixed(6)));
      if (ticks.length > count + 2) {
        break;
      }
    }
    if (ticks.length < 2) {
      return [min, max];
    }
    return ticks;
  }
  function niceTickStep(value) {
    if (!Number.isFinite(value) || value <= 0) {
      return 1;
    }
    const exponent = Math.floor(Math.log10(value));
    const fraction = value / 10 ** exponent;
    let niceFraction = 10;
    if (fraction <= 1) {
      niceFraction = 1;
    } else if (fraction <= 2) {
      niceFraction = 2;
    } else if (fraction <= 5) {
      niceFraction = 5;
    }
    return niceFraction * 10 ** exponent;
  }
  function drawGrid(layer, state, plot, scales) {
    const yAxis = state.axes.y;
    const template = findAxisPartTemplate(state.svgTemplate, "y", "grid-line");
    if (!yAxis || !(template instanceof HTMLTemplateElement)) {
      return;
    }
    scales.yTicks.forEach((tick) => {
      const y = scales.yScale(tick);
      const line = cloneSvgElement(template.content.querySelector("line"));
      if (!(line instanceof SVGLineElement)) {
        return;
      }
      line.setAttribute("x1", String(plot.x));
      line.setAttribute("x2", String(plot.x + plot.width));
      line.setAttribute("y1", String(y));
      line.setAttribute("y2", String(y));
      layer.appendChild(line);
    });
  }
  function drawZeroLine(layer, state, plot, scales) {
    if (!state.hasZeroLine || scales.yMin > 0 || scales.yMax < 0) {
      return;
    }
    const template = state.svgTemplate.content.querySelector(
      `${TEMPLATE_SELECTOR}[data-chart-template="zero-line"]`
    );
    const source = template == null ? void 0 : template.content.querySelector("line");
    if (!isChartSvgElement(source)) {
      return;
    }
    const line = cloneSvgElement(source);
    const y = scales.yScale(0);
    if (line instanceof SVGLineElement) {
      line.setAttribute("x1", String(plot.x));
      line.setAttribute("x2", String(plot.x + plot.width));
      line.setAttribute("y1", String(y));
      line.setAttribute("y2", String(y));
      layer.appendChild(line);
    }
  }
  function drawSeries(layer, state, plot, scales, activeIndex) {
    const barSeries = state.series.filter((entry) => entry.type === "bar");
    state.series.forEach((series) => {
      if (series.type === "bar") {
        return;
      }
      if (series.type === "point") {
        drawPoints(layer, state, series, scales, activeIndex);
        return;
      }
      drawPathSeries(layer, state, series, scales);
    });
    drawBars(layer, state, barSeries, scales, activeIndex);
  }
  function drawPathSeries(layer, state, series, scales) {
    const points = state.data.map((row, index) => {
      const value = Number(row[series.field]);
      if (!Number.isFinite(value)) {
        return null;
      }
      return {
        x: scales.xScale(index),
        y: scales.yScale(value),
        index
      };
    }).filter((point) => point !== null);
    if (points.length < 2 && series.type !== "point") {
      return;
    }
    const smooth = series.curve !== "none";
    const pathData = series.type === "area" ? areaPath(points, scales, smooth) : linePath(points, smooth);
    if (series.type === "line" || series.type === "area") {
      const path = cloneSvgElement(series.prototype);
      if (path instanceof SVGPathElement && pathData) {
        path.setAttribute("d", pathData);
        path.setAttribute("data-chart-series", series.field);
        layer.appendChild(path);
      }
    }
  }
  function drawPoints(layer, state, series, scales, activeIndex) {
    state.data.forEach((row, index) => {
      const value = Number(row[series.field]);
      if (!Number.isFinite(value)) {
        return;
      }
      const circle = cloneSvgElement(series.prototype);
      if (!(circle instanceof SVGCircleElement)) {
        return;
      }
      circle.setAttribute("cx", String(scales.xScale(index)));
      circle.setAttribute("cy", String(scales.yScale(value)));
      circle.setAttribute("data-chart-point", series.field);
      if (index === activeIndex) {
        circle.setAttribute("data-active", "true");
      }
      layer.appendChild(circle);
    });
  }
  function linePath(points, smooth) {
    if (points.length === 0) {
      return "";
    }
    if (points.length === 1) {
      return `M ${points[0].x} ${points[0].y}`;
    }
    if (!smooth) {
      return `M ${points.map((point) => `${point.x} ${point.y}`).join(" L ")}`;
    }
    let path = `M ${points[0].x} ${points[0].y}`;
    for (let index = 1; index < points.length; index += 1) {
      const previous = points[index - 1];
      const current = points[index];
      const cx = (previous.x + current.x) / 2;
      path += ` C ${cx} ${previous.y}, ${cx} ${current.y}, ${current.x} ${current.y}`;
    }
    return path;
  }
  function areaPath(points, scales, smooth) {
    const baseline = scales.yScale(scales.yMin);
    const top = linePath(points, smooth);
    if (!top) {
      return "";
    }
    const first = points[0];
    const last = points[points.length - 1];
    return `${top} L ${last.x} ${baseline} L ${first.x} ${baseline} Z`;
  }
  function drawBars(layer, state, barSeries, scales, activeIndex) {
    var _a5, _b;
    if (barSeries.length === 0) {
      return;
    }
    const grouped = barSeries.some((series) => series.layout === "group");
    const stacked = barSeries.some((series) => series.layout === "stack");
    const count = state.data.length;
    const slotWidth = count > 0 ? scales.plot.width / count : scales.plot.width;
    const groupWidth = parsePercent((_a5 = barSeries[0]) == null ? void 0 : _a5.layoutWidth, slotWidth * 0.7);
    const gap = parsePercent((_b = barSeries[0]) == null ? void 0 : _b.layoutGap, 4);
    state.data.forEach((row, dataIndex) => {
      const centerX = scales.xScale(dataIndex);
      const slotX = centerX - slotWidth / 2;
      if (stacked) {
        let accumulator = 0;
        barSeries.forEach((series) => {
          const value = Number(row[series.field]) || 0;
          const y0 = scales.yScale(accumulator);
          accumulator += value;
          const y1 = scales.yScale(accumulator);
          appendBar(
            layer,
            series,
            slotX,
            Math.min(y0, y1),
            groupWidth,
            Math.abs(y1 - y0),
            dataIndex,
            activeIndex
          );
        });
        return;
      }
      barSeries.forEach((series, seriesIndex) => {
        const barWidth = grouped ? (groupWidth - gap * (barSeries.length - 1)) / barSeries.length : parsePercent(seriesWidth(series), slotWidth);
        const value = Number(row[series.field]) || 0;
        const y = scales.yScale(value);
        const baseline = scales.yScale(Math.min(0, scales.yMin));
        const x = grouped ? slotX + (slotWidth - groupWidth) / 2 + seriesIndex * (barWidth + gap) : slotX + (slotWidth - barWidth) / 2;
        const height = Math.max(Math.abs(baseline - y), parseLength(series.minHeight, 2));
        appendBar(
          layer,
          series,
          x,
          Math.min(y, baseline),
          barWidth,
          height,
          dataIndex,
          activeIndex
        );
      });
    });
  }
  function seriesWidth(series) {
    return series.width;
  }
  function parsePercent(raw, fallback) {
    if (!raw) {
      return fallback;
    }
    if (raw.endsWith("%")) {
      return fallback * (Number.parseFloat(raw) / 100);
    }
    const value = Number.parseFloat(raw);
    return Number.isFinite(value) ? value : fallback;
  }
  function parseLength(raw, fallback) {
    const value = Number.parseFloat(raw != null ? raw : "");
    return Number.isFinite(value) ? value : fallback;
  }
  function appendBar(layer, series, x, y, width, height, dataIndex, activeIndex) {
    const path = cloneSvgElement(series.prototype);
    if (!(path instanceof SVGPathElement)) {
      return;
    }
    const radius = parseLength(series.radius, 4);
    path.setAttribute("d", roundedRect(x, y, width, height, radius));
    path.setAttribute("data-chart-bar", series.field);
    if (dataIndex === activeIndex) {
      path.setAttribute("data-active", "true");
    }
    layer.appendChild(path);
  }
  function roundedRect(x, y, width, height, radius) {
    const r = Math.min(radius, width / 2, height / 2);
    return [
      `M ${x + r} ${y}`,
      `H ${x + width - r}`,
      `Q ${x + width} ${y} ${x + width} ${y + r}`,
      `V ${y + height}`,
      `H ${x}`,
      `V ${y + r}`,
      `Q ${x} ${y} ${x + r} ${y}`,
      "Z"
    ].join(" ");
  }
  function drawAxes(layer, state, plot, scales) {
    drawAxisLine(layer, state, plot, "x");
    drawAxisLine(layer, state, plot, "y");
    drawTickLabels(layer, state, plot, scales, "x");
    drawTickLabels(layer, state, plot, scales, "y");
  }
  function drawAxisLine(layer, state, plot, axis) {
    const template = findAxisPartTemplate(state.svgTemplate, axis, "axis-line");
    if (!(template instanceof HTMLTemplateElement)) {
      return;
    }
    const source = template.content.querySelector("line");
    if (!isChartSvgElement(source)) {
      return;
    }
    const line = cloneSvgElement(source);
    if (!(line instanceof SVGLineElement)) {
      return;
    }
    if (axis === "x") {
      const y = plot.y + plot.height;
      line.setAttribute("x1", String(plot.x));
      line.setAttribute("x2", String(plot.x + plot.width));
      line.setAttribute("y1", String(y));
      line.setAttribute("y2", String(y));
    } else {
      const x = plot.x;
      line.setAttribute("x1", String(x));
      line.setAttribute("x2", String(x));
      line.setAttribute("y1", String(plot.y));
      line.setAttribute("y2", String(plot.y + plot.height));
    }
    layer.appendChild(line);
  }
  function drawTickLabels(layer, state, plot, scales, axis) {
    const config = state.axes[axis];
    const template = findAxisPartTemplate(state.svgTemplate, axis, "tick-label");
    if (!config || !(template instanceof HTMLTemplateElement)) {
      return;
    }
    const xTicks = computeXTicks(state, config);
    const ticks = axis === "y" ? scales.yTicks : xTicks;
    ticks.forEach((tick, index) => {
      var _a5;
      const labelGroup = cloneSvgElement(template.content.querySelector("text"));
      if (!(labelGroup instanceof SVGTextElement)) {
        return;
      }
      const rawValue = axis === "x" ? (_a5 = state.data[typeof tick === "number" ? tick : index]) == null ? void 0 : _a5[config.field] : tick;
      const formatted = formatValue(
        rawValue != null ? rawValue : tick,
        config.format,
        config.tickPrefix,
        config.tickSuffix
      );
      if (axis === "x") {
        const dataIndex = typeof tick === "number" ? tick : index;
        const x = scales.xScale(dataIndex);
        const y = plot.y + plot.height;
        labelGroup.setAttribute("x", String(x));
        labelGroup.setAttribute("y", String(y));
      } else {
        const x = plot.x;
        const y = scales.yScale(Number(tick));
        labelGroup.setAttribute("x", String(x));
        labelGroup.setAttribute("y", String(y));
      }
      labelGroup.textContent = formatted;
      layer.appendChild(labelGroup);
    });
  }
  function computeXTicks(state, config) {
    var _a5;
    if (config.tickValues) {
      return config.tickValues;
    }
    if (chartHasBars(state)) {
      return state.data.map((_, index) => index);
    }
    const count = (_a5 = config.tickCount) != null ? _a5 : Math.min(state.data.length, 6);
    const maxIndex = Math.max(state.data.length - 1, 1);
    return Array.from(
      { length: count },
      (_, index) => Math.round(index / Math.max(count - 1, 1) * maxIndex)
    );
  }
  function formatValue(value, format, prefix = null, suffix = null) {
    const options = parseFormat(format);
    let formatted = String(value);
    if (options) {
      if (options.style === "percent") {
        formatted = new Intl.NumberFormat(void 0, options).format(Number(value));
      } else if (isDateLike(value)) {
        formatted = new Intl.DateTimeFormat(void 0, options).format(new Date(String(value)));
      } else {
        formatted = new Intl.NumberFormat(void 0, options).format(Number(value));
      }
    }
    return `${prefix != null ? prefix : ""}${formatted}${suffix != null ? suffix : ""}`;
  }
  function parseFormat(format) {
    if (!format) {
      return null;
    }
    try {
      return JSON.parse(format);
    } catch (e) {
      return null;
    }
  }
  function drawCursor(layer, state, plot, scales, activeIndex) {
    if (activeIndex < 0) {
      return;
    }
    const template = state.svgTemplate.content.querySelector(
      `${TEMPLATE_SELECTOR}[data-chart-template="cursor"]`
    );
    const source = template == null ? void 0 : template.content.querySelector("path");
    if (!isChartSvgElement(source)) {
      return;
    }
    const path = cloneSvgElement(source);
    if (!(path instanceof SVGPathElement)) {
      return;
    }
    const x = scales.xScale(activeIndex);
    if (state.cursorConfig.type === "area") {
      const slotWidth = state.data.length > 0 ? plot.width / state.data.length : plot.width;
      path.setAttribute(
        "d",
        `M ${x - slotWidth / 2} ${plot.y} H ${x + slotWidth / 2} V ${plot.y + plot.height} H ${x - slotWidth / 2} Z`
      );
      path.setAttribute("fill", "currentColor");
      path.setAttribute("opacity", "0.12");
      path.removeAttribute("stroke");
    } else {
      path.setAttribute("d", `M ${x} ${plot.y} V ${plot.y + plot.height}`);
    }
    path.setAttribute("data-chart-cursor", "true");
    layer.appendChild(path);
  }
  function nearestIndex(state, scales, x) {
    let closest = 0;
    let distance = Number.POSITIVE_INFINITY;
    state.data.forEach((_, index) => {
      const pointX = scales.xScale(index);
      const delta = Math.abs(pointX - x);
      if (delta < distance) {
        distance = delta;
        closest = index;
      }
    });
    return closest;
  }
  function redrawActive(root, state, plot, scales, svg, layer, activeIndex) {
    const runtime = chartRuntimes.get(root);
    if (runtime) {
      runtime.activeIndex = activeIndex;
    }
    layer.querySelectorAll("[data-active]").forEach((node) => node.removeAttribute("data-active"));
    layer.querySelectorAll("[data-chart-cursor]").forEach((node) => node.remove());
    state.series.filter((entry) => entry.type === "point").forEach((series) => {
      const row = state.data[activeIndex];
      if (!row) {
        return;
      }
      const value = Number(row[series.field]);
      if (!Number.isFinite(value)) {
        return;
      }
      const circle = cloneSvgElement(series.prototype);
      if (circle instanceof SVGCircleElement) {
        circle.setAttribute("cx", String(scales.xScale(activeIndex)));
        circle.setAttribute("cy", String(scales.yScale(value)));
        circle.setAttribute("data-chart-point", series.field);
        circle.setAttribute("data-active", "true");
        layer.appendChild(circle);
      }
    });
    if (state.hasCursor && activeIndex >= 0) {
      drawCursor(layer, state, plot, scales, activeIndex);
    }
    updateOverlays(root, state, activeIndex, plot, scales);
  }
  function updateOverlays(root, state, activeIndex, plot, scales) {
    const row = activeIndex >= 0 ? state.data[activeIndex] : null;
    [state.tooltipEl, state.summaryEl].forEach((overlay) => {
      if (!(overlay instanceof HTMLElement)) {
        return;
      }
      const isTooltip = overlay.hasAttribute("data-chart-mounted-tooltip");
      if (!row) {
        overlay.hidden = true;
        overlay.removeAttribute("data-active");
        overlay.style.opacity = "0";
        overlay.style.removeProperty("left");
        overlay.style.removeProperty("top");
        overlay.style.removeProperty("transform");
        return;
      }
      overlay.hidden = false;
      overlay.dataset.active = "true";
      overlay.style.opacity = "1";
      overlay.querySelectorAll("[data-chart-slot]").forEach((slot) => {
        var _a5, _b, _c, _d;
        if (!(slot instanceof HTMLElement)) {
          return;
        }
        const field = slot.dataset.field;
        const fallback = (_a5 = slot.dataset.fallback) != null ? _a5 : "";
        const raw = field ? row[field] : "";
        const formatted = raw === void 0 || raw === null || raw === "" ? fallback : formatValue(
          raw,
          (_b = slot.dataset.format) != null ? _b : null,
          (_c = slot.dataset.prefix) != null ? _c : null,
          (_d = slot.dataset.suffix) != null ? _d : null
        );
        slot.textContent = String(formatted);
      });
      if (isTooltip && plot && scales) {
        positionTooltip(root, overlay, plot, scales, state, activeIndex);
      }
    });
    updateChartAnnouncer(root, state, activeIndex);
  }
  function updateChartAnnouncer(root, state, activeIndex) {
    const announcer = root.querySelector("[data-chart-announcer]");
    if (!(announcer instanceof HTMLElement)) {
      return;
    }
    const row = activeIndex >= 0 ? state.data[activeIndex] : null;
    if (!row) {
      announcer.textContent = "";
      return;
    }
    const parts = [];
    root.querySelectorAll("[data-chart-mounted-tooltip] [data-chart-slot], [data-chart-mounted-summary] [data-chart-slot]").forEach((slot) => {
      var _a5, _b, _c, _d;
      if (!(slot instanceof HTMLElement)) {
        return;
      }
      const field = slot.dataset.field;
      const fallback = (_a5 = slot.dataset.fallback) != null ? _a5 : "";
      const raw = field ? row[field] : "";
      const formatted = raw === void 0 || raw === null || raw === "" ? fallback : formatValue(
        raw,
        (_b = slot.dataset.format) != null ? _b : null,
        (_c = slot.dataset.prefix) != null ? _c : null,
        (_d = slot.dataset.suffix) != null ? _d : null
      );
      if (formatted) {
        parts.push(String(formatted));
      }
    });
    announcer.textContent = parts.join(", ");
  }
  function positionTooltip(root, overlay, plot, scales, state, activeIndex) {
    const x = scales.xScale(activeIndex);
    const row = state.data[activeIndex];
    let anchorY = plot.y + plot.height;
    if (scales.bandScale) {
      anchorY = plot.y;
    } else {
      state.yFields.forEach((field) => {
        const value = Number(row == null ? void 0 : row[field]);
        if (Number.isFinite(value)) {
          anchorY = Math.min(anchorY, scales.yScale(value));
        }
      });
    }
    const gap = 10;
    overlay.style.left = `${x}px`;
    overlay.style.top = `${anchorY}px`;
    const tooltipWidth = overlay.offsetWidth || 120;
    const plotLeft = plot.x;
    const plotRight = plot.x + plot.width;
    let translateX = -tooltipWidth / 2;
    if (x + translateX < plotLeft) {
      translateX = plotLeft - x;
    } else if (x + translateX + tooltipWidth > plotRight) {
      translateX = plotRight - x - tooltipWidth;
    }
    overlay.style.transform = `translate(${translateX}px, calc(-100% - ${gap}px))`;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initCharts(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initCharts());
    } else {
      initCharts();
    }
  }

  // resources/assets/js/collapsible.js
  var COLLAPSIBLE_SELECTOR = "[data-collapsible]";
  var TRIGGER_SELECTOR2 = "[data-collapsible-trigger]";
  var CONTENT_SELECTOR2 = "[data-collapsible-content]";
  var initialized5 = /* @__PURE__ */ new WeakSet();
  function initCollapsibles(root = document) {
    root.querySelectorAll(COLLAPSIBLE_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized5.has(element)) {
        return;
      }
      initialized5.add(element);
      bindCollapsible(element);
    });
  }
  function bindCollapsible(root) {
    var _a5, _b;
    const trigger = root.querySelector(TRIGGER_SELECTOR2);
    const content = root.querySelector(CONTENT_SELECTOR2);
    if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
      return;
    }
    const triggerId = (_a5 = root.dataset.collapsibleTriggerId) != null ? _a5 : `collapsible-trigger-${Math.random().toString(36).slice(2, 10)}`;
    const contentId = (_b = root.dataset.collapsibleContentId) != null ? _b : `collapsible-content-${Math.random().toString(36).slice(2, 10)}`;
    const control = resolveControl(trigger);
    if (control instanceof HTMLElement) {
      if (!control.id) {
        control.id = triggerId;
      }
      control.setAttribute("aria-controls", contentId);
      control.setAttribute("aria-expanded", root.dataset.state === "open" ? "true" : "false");
    }
    if (!content.id) {
      content.id = contentId;
    }
    applyState(root, root.dataset.state === "open");
    const clickTarget = trigger.matches(TRIGGER_SELECTOR2) && trigger.tagName === "DIV" ? trigger : control != null ? control : trigger;
    clickTarget.addEventListener("click", (event) => {
      if (root.dataset.collapsibleDisabled === "true") {
        return;
      }
      if (control instanceof HTMLButtonElement && control.disabled) {
        return;
      }
      event.preventDefault();
      toggle(root);
    });
  }
  function resolveControl(trigger) {
    if (trigger.tagName === "BUTTON") {
      return trigger;
    }
    const nested = trigger.querySelector('button, [role="button"], a[href]');
    return nested instanceof HTMLElement ? nested : trigger;
  }
  function toggle(root) {
    const open = root.dataset.state !== "open";
    applyState(root, open);
    root.dispatchEvent(
      new CustomEvent("stencil:collapsible:change", {
        bubbles: true,
        detail: { open }
      })
    );
  }
  function applyState(root, open) {
    const trigger = root.querySelector(TRIGGER_SELECTOR2);
    const content = root.querySelector(CONTENT_SELECTOR2);
    const transition = root.dataset.collapsibleTransition === "true";
    const control = trigger instanceof HTMLElement ? resolveControl(trigger) : null;
    root.dataset.state = open ? "open" : "closed";
    if (control instanceof HTMLElement) {
      control.setAttribute("aria-expanded", open ? "true" : "false");
    }
    if (!(content instanceof HTMLElement)) {
      return;
    }
    content.dataset.state = open ? "open" : "closed";
    if (transition) {
      content.classList.toggle("grid-rows-[1fr]", open);
      content.classList.toggle("opacity-100", open);
      content.classList.toggle("grid-rows-[0fr]", !open);
      content.classList.toggle("opacity-0", !open);
      content.classList.remove("hidden");
      content.hidden = false;
      if (open) {
        content.removeAttribute("inert");
        content.removeAttribute("aria-hidden");
      } else {
        content.setAttribute("inert", "");
        content.setAttribute("aria-hidden", "true");
      }
    } else if (open) {
      content.hidden = false;
      content.classList.remove("hidden");
      content.removeAttribute("inert");
      content.removeAttribute("aria-hidden");
    } else {
      content.hidden = true;
      content.classList.add("hidden");
      content.removeAttribute("inert");
      content.removeAttribute("aria-hidden");
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initCollapsibles(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initCollapsibles());
    } else {
      initCollapsibles();
    }
  }

  // resources/assets/js/shared/lifecycle.js
  var controllers = /* @__PURE__ */ new WeakMap();
  function createBindSignal(root) {
    var _a5;
    (_a5 = controllers.get(root)) == null ? void 0 : _a5.abort();
    const controller = new AbortController();
    controllers.set(root, controller);
    const disconnectObserver = new MutationObserver(() => {
      if (!root.isConnected) {
        controller.abort();
      }
    });
    disconnectObserver.observe(document.documentElement, { childList: true, subtree: true });
    controller.signal.addEventListener(
      "abort",
      () => {
        disconnectObserver.disconnect();
        if (controllers.get(root) === controller) {
          controllers.delete(root);
        }
      },
      { once: true }
    );
    return controller.signal;
  }

  // resources/assets/js/color-picker.js
  var COLOR_PICKER_SELECTOR = "[data-color-picker]";
  var initialized6 = /* @__PURE__ */ new WeakSet();
  var HEX_PATTERN = /^#[0-9a-fA-F]{6}$/;
  function initColorPickers(root = document) {
    document.querySelectorAll("[data-color-picker-popover][data-color-picker-portaled]").forEach((popover) => {
      if (!(popover instanceof HTMLElement) || popover.closest("[data-color-picker]")) {
        return;
      }
      popover.remove();
    });
    root.querySelectorAll(COLOR_PICKER_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized6.has(element)) {
        return;
      }
      initialized6.add(element);
      bindColorPicker(element);
    });
  }
  function hexToRgb(hex) {
    const normalized = hex.replace("#", "");
    const value = Number.parseInt(normalized, 16);
    return {
      r: value >> 16 & 255,
      g: value >> 8 & 255,
      b: value & 255
    };
  }
  function rgbToHex(r, g, b) {
    const toHex = (channel) => channel.toString(16).padStart(2, "0");
    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
  }
  function rgbToHsv(r, g, b) {
    const red = r / 255;
    const green = g / 255;
    const blue = b / 255;
    const max = Math.max(red, green, blue);
    const min = Math.min(red, green, blue);
    const delta = max - min;
    let hue = 0;
    if (delta !== 0) {
      if (max === red) {
        hue = (green - blue) / delta % 6;
      } else if (max === green) {
        hue = (blue - red) / delta + 2;
      } else {
        hue = (red - green) / delta + 4;
      }
    }
    hue = Math.round(hue * 60);
    if (hue < 0) {
      hue += 360;
    }
    const saturation = max === 0 ? 0 : delta / max * 100;
    const value = max * 100;
    return { h: hue, s: saturation, v: value };
  }
  function hsvToRgb(h, s, v) {
    const saturation = s / 100;
    const value = v / 100;
    const chroma = value * saturation;
    const segment = h / 60 % 6;
    const x = chroma * (1 - Math.abs(segment % 2 - 1));
    const m = value - chroma;
    let red = 0;
    let green = 0;
    let blue = 0;
    if (segment >= 0 && segment < 1) {
      red = chroma;
      green = x;
    } else if (segment >= 1 && segment < 2) {
      red = x;
      green = chroma;
    } else if (segment >= 2 && segment < 3) {
      green = chroma;
      blue = x;
    } else if (segment >= 3 && segment < 4) {
      green = x;
      blue = chroma;
    } else if (segment >= 4 && segment < 5) {
      red = x;
      blue = chroma;
    } else {
      red = chroma;
      blue = x;
    }
    return {
      r: Math.round((red + m) * 255),
      g: Math.round((green + m) * 255),
      b: Math.round((blue + m) * 255)
    };
  }
  function hsvToHex(h, s, v) {
    const { r, g, b } = hsvToRgb(h, s, v);
    return rgbToHex(r, g, b);
  }
  function parseHexInput(raw) {
    var _a5;
    let value = raw.trim();
    if (value === "") {
      return null;
    }
    if (!value.startsWith("#")) {
      value = `#${value}`;
    }
    if (/^#[0-9a-fA-F]{3}$/.test(value)) {
      const [, r, g, b] = (_a5 = value.match(/^#(.)(.)(.)$/)) != null ? _a5 : [];
      if (r && g && b) {
        return `#${r}${r}${g}${g}${b}${b}`.toLowerCase();
      }
    }
    if (HEX_PATTERN.test(value)) {
      return value.toLowerCase();
    }
    return null;
  }
  function bindColorPicker(root) {
    const hiddenInput = root.querySelector("[data-color-picker-hidden-input]");
    const hexInput = root.querySelector("[data-color-picker-hex]");
    const swatchTrigger = root.querySelector("[data-color-picker-swatch-trigger]");
    const trigger = root.querySelector("[data-color-picker-trigger]");
    const popover = root.querySelector("[data-color-picker-popover]");
    const area = root.querySelector("[data-color-picker-area]");
    const areaBase = root.querySelector("[data-color-picker-area-base]");
    const areaThumb = root.querySelector("[data-color-picker-area-thumb]");
    const hueInput = root.querySelector("[data-color-picker-hue]");
    const dropperButton = root.querySelector("[data-color-picker-dropper]");
    const preview = root.querySelector("[data-color-picker-preview]");
    const disabled = root.hasAttribute("data-disabled");
    if (!(hiddenInput instanceof HTMLInputElement) || !(hexInput instanceof HTMLInputElement) || !(popover instanceof HTMLElement) || !(area instanceof HTMLElement) || !(areaBase instanceof HTMLElement) || !(areaThumb instanceof HTMLElement) || !(hueInput instanceof HTMLInputElement) || !(swatchTrigger instanceof HTMLButtonElement)) {
      return;
    }
    const portalMarker = document.createComment("stencil-color-picker-portal");
    let portalInserted = false;
    const signal = createBindSignal(root);
    let open = false;
    let draggingArea = false;
    let hue = 0;
    let saturation = 100;
    let brightness = 100;
    function dispatchChange(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function syncHsvFromHex(hex) {
      const { r, g, b } = hexToRgb(hex);
      const hsv = rgbToHsv(r, g, b);
      hue = hsv.h;
      saturation = hsv.s;
      brightness = hsv.v;
    }
    function renderPickerUi() {
      areaBase.style.backgroundColor = `hsl(${hue} 100% 50%)`;
      hueInput.value = String(hue);
      const thumbX = saturation / 100 * area.clientWidth;
      const thumbY = (1 - brightness / 100) * area.clientHeight;
      areaThumb.style.left = `${thumbX}px`;
      areaThumb.style.top = `${thumbY}px`;
    }
    function setValue(hex, options = {}) {
      const { syncPicker = true, dispatch = true } = options;
      if (!HEX_PATTERN.test(hex)) {
        return;
      }
      const normalized = hex.toLowerCase();
      hiddenInput.value = normalized;
      hexInput.value = normalized.toUpperCase();
      if (preview instanceof HTMLElement) {
        preview.style.backgroundColor = normalized;
      }
      if (syncPicker) {
        syncHsvFromHex(normalized);
        renderPickerUi();
      }
      root.querySelectorAll("[data-color-picker-swatch]").forEach((button) => {
        var _a5;
        if (!(button instanceof HTMLButtonElement)) {
          return;
        }
        const swatchValue = (_a5 = button.getAttribute("data-color-picker-swatch")) == null ? void 0 : _a5.toLowerCase();
        const selected = swatchValue === normalized;
        button.setAttribute("aria-selected", selected ? "true" : "false");
        button.dataset.selected = selected ? "true" : "false";
      });
      if (dispatch) {
        dispatchChange(hiddenInput);
      }
    }
    function ensurePortal() {
      if (root.closest("#readme-media") || popover.closest("#readme-media")) {
        return;
      }
      if (popover.parentElement === document.body) {
        return;
      }
      const parent = popover.parentElement;
      if (parent && !portalInserted) {
        parent.insertBefore(portalMarker, popover);
        portalInserted = true;
      }
      document.body.appendChild(popover);
      popover.dataset.colorPickerPortaled = "true";
    }
    function positionPopover() {
      ensurePortal();
      const anchor = trigger instanceof HTMLElement ? trigger : hexInput;
      const rect = anchor.getBoundingClientRect();
      const gap = 6;
      const viewportPadding = 8;
      if (root.closest("#readme-media")) {
        if (getComputedStyle(root).position === "static") {
          root.style.position = "relative";
        }
        const rootRect = root.getBoundingClientRect();
        popover.style.position = "absolute";
        popover.style.left = `${Math.max(0, rect.left - rootRect.left)}px`;
        popover.style.top = `${rect.bottom - rootRect.top + gap}px`;
        popover.style.width = `${Math.max(rect.width, 288)}px`;
        popover.style.zIndex = "200";
        popover.style.maxHeight = "";
        return;
      }
      popover.style.position = "fixed";
      popover.style.left = `${Math.max(viewportPadding, rect.left)}px`;
      popover.style.width = `${Math.max(rect.width, 288)}px`;
      popover.style.zIndex = "200";
      const wasHidden = popover.hidden;
      popover.hidden = false;
      popover.style.visibility = "hidden";
      popover.style.pointerEvents = "none";
      const panelHeight = popover.offsetHeight;
      popover.style.visibility = "";
      popover.style.pointerEvents = "";
      popover.hidden = wasHidden;
      let top = rect.bottom + gap;
      const maxBottom = window.innerHeight - viewportPadding;
      if (top + panelHeight > maxBottom) {
        const topAbove = rect.top - gap - panelHeight;
        if (topAbove >= viewportPadding) {
          top = topAbove;
        } else {
          popover.style.maxHeight = `${maxBottom - top}px`;
        }
      } else {
        popover.style.maxHeight = "";
      }
      popover.style.top = `${top}px`;
    }
    function setOpen(next) {
      open = next;
      swatchTrigger.setAttribute("aria-expanded", open ? "true" : "false");
      hexInput.setAttribute("aria-expanded", open ? "true" : "false");
      popover.hidden = !open;
      if (open) {
        syncHsvFromHex(hiddenInput.value || "#000000");
        renderPickerUi();
        positionPopover();
      }
    }
    function updateAreaFromPointer(clientX, clientY) {
      const rect = area.getBoundingClientRect();
      const x = Math.max(0, Math.min(rect.width, clientX - rect.left));
      const y = Math.max(0, Math.min(rect.height, clientY - rect.top));
      saturation = x / rect.width * 100;
      brightness = 100 - y / rect.height * 100;
      setValue(hsvToHex(hue, saturation, brightness), { syncPicker: false });
      renderPickerUi();
    }
    swatchTrigger.addEventListener("click", () => {
      if (disabled) {
        return;
      }
      setOpen(!open);
    });
    hexInput.addEventListener("input", () => {
      if (disabled) {
        return;
      }
      const parsed = parseHexInput(hexInput.value);
      if (parsed) {
        setValue(parsed);
      }
    });
    hexInput.addEventListener("blur", () => {
      if (disabled) {
        return;
      }
      const parsed = parseHexInput(hexInput.value);
      if (parsed) {
        setValue(parsed);
      } else {
        hexInput.value = hiddenInput.value.toUpperCase();
      }
    });
    hueInput.addEventListener("input", () => {
      if (disabled) {
        return;
      }
      hue = Number(hueInput.value);
      setValue(hsvToHex(hue, saturation, brightness), { syncPicker: false });
      renderPickerUi();
    });
    area.addEventListener("pointerdown", (event) => {
      if (disabled) {
        return;
      }
      draggingArea = true;
      area.setPointerCapture(event.pointerId);
      updateAreaFromPointer(event.clientX, event.clientY);
    });
    area.addEventListener("pointermove", (event) => {
      if (!draggingArea || disabled) {
        return;
      }
      updateAreaFromPointer(event.clientX, event.clientY);
    });
    area.addEventListener("pointerup", (event) => {
      draggingArea = false;
      if (area.hasPointerCapture(event.pointerId)) {
        area.releasePointerCapture(event.pointerId);
      }
    });
    area.addEventListener("pointercancel", () => {
      draggingArea = false;
    });
    root.querySelectorAll("[data-color-picker-swatch]").forEach((button) => {
      button.addEventListener("click", () => {
        if (disabled || !(button instanceof HTMLButtonElement)) {
          return;
        }
        const value = button.getAttribute("data-color-picker-swatch");
        if (value) {
          setValue(value);
        }
      });
    });
    if (dropperButton instanceof HTMLButtonElement && "EyeDropper" in window) {
      dropperButton.hidden = false;
      dropperButton.addEventListener("click", async () => {
        if (disabled) {
          return;
        }
        try {
          const eyeDropper = new window.EyeDropper();
          const result = await eyeDropper.open();
          const parsed = parseHexInput(result.sRGBHex);
          if (parsed) {
            setValue(parsed);
          }
        } catch (e) {
        }
      });
    }
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open || disabled) {
          return;
        }
        const target = event.target;
        if (!(target instanceof Node)) {
          return;
        }
        if (root.contains(target) || popover.contains(target)) {
          return;
        }
        setOpen(false);
      },
      { signal }
    );
    document.addEventListener(
      "keydown",
      (event) => {
        if (!open || disabled || event.key !== "Escape") {
          return;
        }
        setOpen(false);
        swatchTrigger.focus();
      },
      { signal }
    );
    window.addEventListener(
      "resize",
      () => {
        if (open) {
          positionPopover();
        }
      },
      { signal }
    );
    window.addEventListener(
      "scroll",
      () => {
        if (open) {
          positionPopover();
        }
      },
      { capture: true, signal }
    );
    const initial = hiddenInput.value || "#000000";
    if (HEX_PATTERN.test(initial)) {
      setValue(initial, { dispatch: false });
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initColorPickers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initColorPickers());
    } else {
      initColorPickers();
    }
  }

  // resources/assets/js/combobox.js
  var COMBOBOX_SELECTOR = "[data-combobox]";
  var initialized7 = /* @__PURE__ */ new WeakSet();
  function initComboboxes(root = document) {
    document.querySelectorAll("[data-combobox-content][data-combobox-portaled]").forEach((content) => {
      if (!(content instanceof HTMLElement) || content.closest("[data-combobox]")) {
        return;
      }
      content.remove();
    });
    root.querySelectorAll(COMBOBOX_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized7.has(element)) {
        return;
      }
      initialized7.add(element);
      bindCombobox(element);
    });
  }
  function bindCombobox(root) {
    var _a5, _b, _c, _d, _e;
    const isMultiple = root.hasAttribute("data-combobox-multiple");
    const displayMode = (_a5 = root.getAttribute("data-combobox-display")) != null ? _a5 : "count";
    const countTemplate = (_b = root.getAttribute("data-combobox-count-template")) != null ? _b : "{count} selected";
    const chipRemoveLabel = (_c = root.getAttribute("data-combobox-chip-remove-label")) != null ? _c : "Remove";
    const singleInput = root.querySelector("[data-combobox-input]");
    const filterInput = root.querySelector("[data-combobox-filter-input]");
    const input = isMultiple && filterInput instanceof HTMLInputElement ? filterInput : singleInput;
    const toggle2 = root.querySelector("[data-combobox-toggle]");
    const content = root.querySelector("[data-combobox-content]");
    const emptyEl = root.querySelector("[data-combobox-empty]");
    const singleHiddenInput = !isMultiple ? root.querySelector("[data-combobox-hidden-input]") : null;
    const hiddenInputsContainer = root.querySelector("[data-combobox-hidden-inputs]");
    const valueEl = root.querySelector("[data-combobox-value]");
    const chipsEl = root.querySelector("[data-combobox-chips]");
    const chipTemplate = root.querySelector("template[data-combobox-chip-template]");
    const chevron = root.querySelector("[data-combobox-chevron]");
    if (!(input instanceof HTMLInputElement) || !(content instanceof HTMLElement)) {
      return;
    }
    if (!isMultiple && !(singleHiddenInput instanceof HTMLInputElement)) {
      return;
    }
    if (isMultiple && !(hiddenInputsContainer instanceof HTMLElement)) {
      return;
    }
    const placeholderFromValueEl = valueEl instanceof HTMLElement ? (_d = valueEl.getAttribute("data-placeholder")) != null ? _d : "" : "";
    const placeholderFromChips = chipsEl instanceof HTMLElement ? (_e = chipsEl.getAttribute("data-placeholder")) != null ? _e : "" : "";
    const portalMarker = document.createComment("stencil-combobox-portal");
    let portalInserted = false;
    const signal = createBindSignal(root);
    const options = () => Array.from(content.querySelectorAll("[data-combobox-item]")).filter(
      (node) => node instanceof HTMLElement
    );
    const visibleEnabledOptions = () => options().filter((el) => !el.hidden && !el.hasAttribute("data-disabled"));
    let open = false;
    let activeIndex = -1;
    let committedLabel = "";
    function dispatchValueEvents(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function optionLabel(el) {
      var _a6, _b2, _c2, _d2;
      const label = el.querySelector("[data-combobox-item-label]");
      if (label instanceof HTMLElement) {
        return (_b2 = (_a6 = label.textContent) == null ? void 0 : _a6.trim()) != null ? _b2 : "";
      }
      return (_d2 = (_c2 = el.textContent) == null ? void 0 : _c2.trim()) != null ? _d2 : "";
    }
    function getSelectedValues() {
      if (!isMultiple) {
        return singleHiddenInput instanceof HTMLInputElement && singleHiddenInput.value !== "" ? [singleHiddenInput.value] : [];
      }
      return Array.from(hiddenInputsContainer.querySelectorAll("[data-combobox-hidden-input]")).filter((node) => node instanceof HTMLInputElement).map((node) => node.value).filter((value) => value !== "");
    }
    function setSelectedValues(values) {
      var _a6, _b2, _c2;
      const unique = [...new Set(values)];
      if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
        singleHiddenInput.value = (_a6 = unique[0]) != null ? _a6 : "";
        syncOptionSelection((_b2 = unique[0]) != null ? _b2 : "");
        renderTrigger();
        dispatchValueEvents(singleHiddenInput);
        return;
      }
      const fieldName = (_c2 = hiddenInputsContainer.getAttribute("data-combobox-field-name")) != null ? _c2 : "";
      hiddenInputsContainer.querySelectorAll("[data-combobox-hidden-input]").forEach((node) => node.remove());
      unique.forEach((value) => {
        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.value = value;
        hidden.setAttribute("data-combobox-hidden-input", "");
        if (fieldName !== "") {
          hidden.name = fieldName;
        }
        hiddenInputsContainer.appendChild(hidden);
      });
      syncOptionSelectionMulti(unique);
      renderTrigger();
      hiddenInputsContainer.querySelectorAll("[data-combobox-hidden-input]").forEach((node) => {
        if (node instanceof HTMLInputElement) {
          dispatchValueEvents(node);
        }
      });
    }
    function syncOptionSelection(value) {
      options().forEach((item) => {
        item.setAttribute(
          "aria-selected",
          item.getAttribute("data-value") === value ? "true" : "false"
        );
      });
    }
    function syncOptionSelectionMulti(values) {
      const set = new Set(values);
      options().forEach((item) => {
        var _a6;
        const itemValue = (_a6 = item.getAttribute("data-value")) != null ? _a6 : "";
        item.setAttribute("aria-selected", set.has(itemValue) ? "true" : "false");
      });
    }
    function createChipElement(value, label) {
      if (!(chipTemplate instanceof HTMLTemplateElement)) {
        return null;
      }
      const fragment = chipTemplate.content.cloneNode(true);
      const chip = fragment.querySelector("[data-combobox-chip]");
      if (!(chip instanceof HTMLElement)) {
        return null;
      }
      chip.setAttribute("data-value", value);
      const labelEl = chip.querySelector("[data-combobox-chip-label]");
      if (labelEl instanceof HTMLElement) {
        labelEl.textContent = label;
      }
      const remove = chip.querySelector("[data-combobox-chip-remove]");
      if (remove instanceof HTMLButtonElement) {
        remove.setAttribute("aria-label", `${chipRemoveLabel} ${label}`);
      }
      return chip;
    }
    function renderTrigger() {
      if (!isMultiple) {
        return;
      }
      const selected = getSelectedValues();
      if (displayMode === "count" && valueEl instanceof HTMLElement) {
        if (selected.length === 0) {
          const placeholder = placeholderFromValueEl || placeholderFromChips;
          if (placeholder !== "") {
            valueEl.textContent = placeholder;
            valueEl.setAttribute("data-placeholder", "true");
          } else {
            valueEl.textContent = "";
            valueEl.removeAttribute("data-placeholder");
          }
          return;
        }
        valueEl.textContent = countTemplate.replace("{count}", String(selected.length));
        valueEl.removeAttribute("data-placeholder");
        return;
      }
      if (displayMode === "chips" && chipsEl instanceof HTMLElement) {
        chipsEl.querySelectorAll("[data-combobox-chip]").forEach((chip) => chip.remove());
        if (selected.length === 0 && placeholderFromChips !== "") {
          const empty = document.createElement("span");
          empty.className = "text-sm text-zinc-500 dark:text-zinc-400";
          empty.setAttribute("data-combobox-chips-placeholder", "true");
          empty.textContent = placeholderFromChips;
          chipsEl.appendChild(empty);
          return;
        }
        chipsEl.querySelectorAll("[data-combobox-chips-placeholder]").forEach((node) => node.remove());
        selected.forEach((value) => {
          const match = options().find((el) => el.getAttribute("data-value") === value);
          const label = match ? optionLabel(match) : value;
          const chip = createChipElement(value, label);
          if (chip) {
            chipsEl.appendChild(chip);
          }
        });
      }
    }
    function removeValue(value) {
      setSelectedValues(getSelectedValues().filter((item) => item !== value));
    }
    function ensurePortal() {
      if (content.parentElement === document.body) {
        return;
      }
      const parent = content.parentElement;
      if (parent && !portalInserted) {
        parent.insertBefore(portalMarker, content);
        portalInserted = true;
      }
      document.body.appendChild(content);
      content.dataset.comboboxPortaled = "true";
    }
    function positionContent3() {
      ensurePortal();
      const wrap = root.querySelector("[data-combobox-input-wrap]");
      const anchor = wrap instanceof HTMLElement ? wrap : input;
      const rect = anchor.getBoundingClientRect();
      const gap = 6;
      const viewportPadding = 8;
      content.style.position = "fixed";
      content.style.left = `${Math.max(viewportPadding, rect.left)}px`;
      content.style.width = `${rect.width}px`;
      content.style.minWidth = `${rect.width}px`;
      content.style.zIndex = "200";
      const wasHidden = content.hidden;
      content.hidden = false;
      content.style.visibility = "hidden";
      content.style.pointerEvents = "none";
      const panelHeight = content.offsetHeight;
      content.style.visibility = "";
      content.style.pointerEvents = "";
      content.hidden = wasHidden;
      let top = rect.bottom + gap;
      const maxBottom = window.innerHeight - viewportPadding;
      if (top + panelHeight > maxBottom) {
        const topAbove = rect.top - gap - panelHeight;
        if (topAbove >= viewportPadding) {
          top = topAbove;
        } else {
          content.style.maxHeight = `${maxBottom - top}px`;
        }
      } else {
        content.style.maxHeight = "";
      }
      content.style.top = `${top}px`;
    }
    function applyFilter(query) {
      const q = query.trim().toLowerCase();
      let visibleCount = 0;
      options().forEach((el) => {
        const match = q === "" || optionLabel(el).toLowerCase().includes(q);
        el.hidden = !match;
        if (match) {
          visibleCount += 1;
        }
      });
      content.querySelectorAll("[data-combobox-group]").forEach((group) => {
        if (!(group instanceof HTMLElement)) {
          return;
        }
        const hasVisibleItem = Array.from(group.querySelectorAll("[data-combobox-item]")).some(
          (item) => item instanceof HTMLElement && !item.hidden
        );
        group.hidden = !hasVisibleItem;
      });
      content.querySelectorAll("[data-combobox-separator]").forEach((sep) => {
        if (!(sep instanceof HTMLElement)) {
          return;
        }
        sep.hidden = visibleCount === 0;
      });
      if (emptyEl instanceof HTMLElement) {
        emptyEl.hidden = visibleCount > 0;
      }
    }
    function clearHighlights() {
      options().forEach((el) => {
        el.removeAttribute("data-highlighted");
      });
      input.removeAttribute("aria-activedescendant");
    }
    function highlightActive() {
      clearHighlights();
      const list = visibleEnabledOptions();
      const el = list[activeIndex];
      if (el) {
        el.setAttribute("data-highlighted", "true");
        el.scrollIntoView({ block: "nearest" });
        const id = el.id;
        if (id) {
          input.setAttribute("aria-activedescendant", id);
        }
      }
    }
    function setOpen(next, opts = {}) {
      open = next;
      root.dataset.state = next ? "open" : "closed";
      input.setAttribute("aria-expanded", next ? "true" : "false");
      if (toggle2 instanceof HTMLButtonElement) {
        toggle2.setAttribute("aria-expanded", next ? "true" : "false");
      }
      if (chevron instanceof HTMLElement) {
        chevron.classList.toggle("rotate-180", next);
      }
      content.hidden = !next;
      if (next) {
        if (!opts.keepFilter) {
          applyFilter(input.value);
        }
        positionContent3();
        const list = visibleEnabledOptions();
        const selected = getSelectedValues();
        let index = 0;
        if (!isMultiple && selected.length > 0) {
          const found = list.findIndex((el) => el.getAttribute("data-value") === selected[0]);
          index = found >= 0 ? found : 0;
        } else if (isMultiple && selected.length > 0) {
          const found = list.findIndex(
            (el) => {
              var _a6;
              return selected.includes((_a6 = el.getAttribute("data-value")) != null ? _a6 : "");
            }
          );
          index = found >= 0 ? found : 0;
        }
        activeIndex = list.length > 0 ? index : -1;
        highlightActive();
      } else {
        clearHighlights();
        activeIndex = -1;
        applyFilter("");
        if (isMultiple) {
          input.value = "";
        }
        options().forEach((el) => {
          el.hidden = false;
        });
        content.querySelectorAll("[data-combobox-group], [data-combobox-separator]").forEach((node) => {
          if (node instanceof HTMLElement) {
            node.hidden = false;
          }
        });
        if (emptyEl instanceof HTMLElement) {
          emptyEl.hidden = true;
        }
      }
    }
    function selectOption(el) {
      var _a6;
      if (el.hasAttribute("data-disabled")) {
        return;
      }
      const value = (_a6 = el.getAttribute("data-value")) != null ? _a6 : "";
      const label = optionLabel(el);
      if (isMultiple) {
        const current = getSelectedValues();
        const next = current.includes(value) ? current.filter((item) => item !== value) : [...current, value];
        setSelectedValues(next);
        input.value = "";
        applyFilter("");
        positionContent3();
        input.focus();
        return;
      }
      if (!(singleHiddenInput instanceof HTMLInputElement)) {
        return;
      }
      singleHiddenInput.value = value;
      input.value = label;
      committedLabel = label;
      syncOptionSelection(value);
      dispatchValueEvents(singleHiddenInput);
      dispatchValueEvents(input);
      setOpen(false);
      input.focus();
    }
    function syncFromValue() {
      if (isMultiple) {
        syncOptionSelectionMulti(getSelectedValues());
        renderTrigger();
        return;
      }
      if (!(singleHiddenInput instanceof HTMLInputElement)) {
        return;
      }
      const value = singleHiddenInput.value;
      if (value === "") {
        committedLabel = "";
        syncOptionSelection("");
        return;
      }
      const match = options().find((el) => el.getAttribute("data-value") === value);
      if (match) {
        const label = optionLabel(match);
        input.value = label;
        committedLabel = label;
        syncOptionSelection(value);
      }
    }
    function containsTarget(target) {
      return target instanceof Node && (root.contains(target) || content.contains(target));
    }
    if (chipsEl instanceof HTMLElement) {
      chipsEl.addEventListener("click", (event) => {
        var _a6;
        const remove = event.target instanceof Element ? event.target.closest("[data-combobox-chip-remove]") : null;
        if (remove instanceof HTMLElement) {
          event.preventDefault();
          const chip = remove.closest("[data-combobox-chip]");
          if (chip instanceof HTMLElement) {
            const value = (_a6 = chip.getAttribute("data-value")) != null ? _a6 : "";
            removeValue(value);
          }
        }
      });
    }
    input.addEventListener("focus", () => {
      if (input.disabled) {
        return;
      }
      if (!open) {
        setOpen(true);
      }
    });
    input.addEventListener("input", () => {
      if (input.disabled) {
        return;
      }
      if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
        if (committedLabel !== "" && input.value !== committedLabel) {
          singleHiddenInput.value = "";
          committedLabel = "";
          syncOptionSelection("");
          dispatchValueEvents(singleHiddenInput);
        }
      }
      if (!open) {
        setOpen(true, { keepFilter: true });
      }
      applyFilter(input.value);
      positionContent3();
      const list = visibleEnabledOptions();
      activeIndex = list.length > 0 ? 0 : -1;
      highlightActive();
    });
    if (toggle2 instanceof HTMLButtonElement) {
      toggle2.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        if (toggle2.disabled || input.disabled) {
          return;
        }
        if (open) {
          setOpen(false);
          input.focus();
        } else {
          setOpen(true);
          input.focus();
        }
      });
    }
    content.addEventListener("mousedown", (event) => {
      event.preventDefault();
    });
    content.addEventListener("click", (event) => {
      const item = event.target instanceof Element ? event.target.closest("[data-combobox-item]") : null;
      if (item instanceof HTMLElement) {
        selectOption(item);
      }
    });
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open) {
          return;
        }
        if (!containsTarget(event.target)) {
          setOpen(false);
          if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
            if (singleHiddenInput.value !== "" && committedLabel !== "") {
              input.value = committedLabel;
            }
          }
        }
      },
      { signal }
    );
    window.addEventListener(
      "resize",
      () => {
        if (open) {
          positionContent3();
        }
      },
      { signal }
    );
    window.addEventListener(
      "scroll",
      () => {
        if (open) {
          positionContent3();
        }
      },
      { capture: true, signal }
    );
    input.addEventListener("keydown", (event) => {
      if (input.disabled) {
        return;
      }
      const list = visibleEnabledOptions();
      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          if (!open) {
            setOpen(true);
          } else if (list.length > 0) {
            activeIndex = Math.min(activeIndex + 1, list.length - 1);
            if (activeIndex < 0) {
              activeIndex = 0;
            }
            highlightActive();
          }
          break;
        case "ArrowUp":
          event.preventDefault();
          if (!open) {
            setOpen(true);
          } else if (list.length > 0) {
            activeIndex = Math.max(activeIndex - 1, 0);
            highlightActive();
          }
          break;
        case "Home":
          if (open && list.length > 0) {
            event.preventDefault();
            activeIndex = 0;
            highlightActive();
          }
          break;
        case "End":
          if (open && list.length > 0) {
            event.preventDefault();
            activeIndex = list.length - 1;
            highlightActive();
          }
          break;
        case "Enter":
          if (open) {
            event.preventDefault();
            const el = list[activeIndex];
            if (el) {
              selectOption(el);
            }
          }
          break;
        case "Escape":
          if (open) {
            event.preventDefault();
            setOpen(false);
            if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
              if (singleHiddenInput.value !== "" && committedLabel !== "") {
                input.value = committedLabel;
              }
            }
          }
          break;
        case "Tab":
          if (open) {
            setOpen(false);
            if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
              if (singleHiddenInput.value !== "" && committedLabel !== "") {
                input.value = committedLabel;
              }
            }
          }
          break;
        default:
          break;
      }
    });
    root.dataset.state = "closed";
    syncFromValue();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initComboboxes(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initComboboxes());
    } else {
      initComboboxes();
    }
  }

  // resources/assets/js/command.js
  var COMMAND_SELECTOR = "[data-command]";
  var DIALOG_SHORTCUT_SELECTOR = "[data-command-dialog][data-command-shortcut]";
  var initialized8 = /* @__PURE__ */ new WeakSet();
  var shortcutBound = /* @__PURE__ */ new WeakSet();
  function initCommands(root = document) {
    root.querySelectorAll(COMMAND_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized8.has(element)) {
        return;
      }
      initialized8.add(element);
      bindCommand(element);
    });
    bindDocumentShortcuts(root);
  }
  function bindDocumentShortcuts(root) {
    const scope = root instanceof Document ? root : document;
    scope.querySelectorAll(DIALOG_SHORTCUT_SELECTOR).forEach((dialog) => {
      if (!(dialog instanceof HTMLDialogElement)) {
        return;
      }
      if (shortcutBound.has(dialog)) {
        return;
      }
      shortcutBound.add(dialog);
      bindDialogShortcut(dialog);
    });
  }
  function bindDialogShortcut(dialog) {
    const shortcut = dialog.getAttribute("data-command-shortcut");
    if (!shortcut) {
      return;
    }
    const parsed = parseShortcut(shortcut);
    if (!parsed) {
      return;
    }
    const signal = createBindSignal(dialog);
    document.addEventListener(
      "keydown",
      (event) => {
        if (!document.contains(dialog)) {
          return;
        }
        if (!matchesShortcut(event, parsed)) {
          return;
        }
        const target = event.target;
        if (target instanceof HTMLElement && (target.isContentEditable || (target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement || target instanceof HTMLSelectElement) && !dialog.contains(target) && !event.metaKey && !event.ctrlKey)) {
          if (!parsed.meta && !parsed.ctrl) {
            return;
          }
        }
        event.preventDefault();
        if (dialog.open) {
          dialog.close();
          return;
        }
        openCommandDialog(dialog);
      },
      { signal }
    );
  }
  function parseShortcut(shortcut) {
    const parts = shortcut.toLowerCase().split(".").map((part) => part.trim()).filter(Boolean);
    if (parts.length === 0) {
      return null;
    }
    const key = parts[parts.length - 1];
    const mods = new Set(parts.slice(0, -1));
    return {
      key,
      meta: mods.has("meta") || mods.has("cmd") || mods.has("command"),
      ctrl: mods.has("ctrl") || mods.has("control"),
      shift: mods.has("shift"),
      alt: mods.has("alt") || mods.has("option")
    };
  }
  function matchesShortcut(event, parsed) {
    const key = event.key.toLowerCase();
    if (key !== parsed.key) {
      return false;
    }
    const metaOrCtrl = parsed.meta || parsed.ctrl;
    const eventMetaOrCtrl = event.metaKey || event.ctrlKey;
    if (metaOrCtrl && !eventMetaOrCtrl) {
      return false;
    }
    if (!metaOrCtrl && (event.metaKey || event.ctrlKey)) {
      return false;
    }
    if (parsed.shift !== event.shiftKey) {
      return false;
    }
    if (parsed.alt !== event.altKey) {
      return false;
    }
    return true;
  }
  function openCommandDialog(dialog) {
    var _a5;
    if (typeof window !== "undefined" && ((_a5 = window.Stencil) == null ? void 0 : _a5.dialog) && dialog.dataset.dialogName) {
      window.Stencil.dialog(dialog.dataset.dialogName).show();
      return;
    }
    if (typeof dialog.showModal === "function") {
      dialog.showModal();
    } else {
      dialog.setAttribute("open", "");
    }
    const input = dialog.querySelector("[data-command-input]");
    if (input instanceof HTMLInputElement) {
      requestAnimationFrame(() => {
        input.focus();
        input.select();
      });
    }
  }
  function bindCommand(root) {
    const input = root.querySelector("[data-command-input]");
    const list = root.querySelector("[data-command-list]");
    const emptyEl = root.querySelector("[data-command-empty]");
    if (!(input instanceof HTMLInputElement) || !(list instanceof HTMLElement)) {
      return;
    }
    let activeIndex = -1;
    const items = () => Array.from(list.querySelectorAll("[data-command-item]")).filter(
      (node) => node instanceof HTMLElement
    );
    const visibleEnabledItems = () => items().filter((el) => !el.hidden && !el.hasAttribute("data-disabled"));
    function itemLabel(el) {
      var _a5, _b, _c, _d;
      const label = el.querySelector("[data-command-item-label]");
      if (label instanceof HTMLElement) {
        return (_b = (_a5 = label.textContent) == null ? void 0 : _a5.trim()) != null ? _b : "";
      }
      return (_d = (_c = el.textContent) == null ? void 0 : _c.trim()) != null ? _d : "";
    }
    function itemSearchText(el) {
      var _a5;
      const keywords = (_a5 = el.getAttribute("data-keywords")) != null ? _a5 : "";
      const label = itemLabel(el);
      return `${label} ${keywords}`.trim().toLowerCase();
    }
    function applyFilter(query) {
      const q = query.trim().toLowerCase();
      let visibleCount = 0;
      items().forEach((el) => {
        const match = q === "" || itemSearchText(el).includes(q);
        el.hidden = !match;
        if (match) {
          visibleCount += 1;
        }
      });
      list.querySelectorAll("[data-command-group]").forEach((group) => {
        if (!(group instanceof HTMLElement)) {
          return;
        }
        const hasVisibleItem = Array.from(group.querySelectorAll("[data-command-item]")).some(
          (item) => item instanceof HTMLElement && !item.hidden
        );
        group.hidden = !hasVisibleItem;
      });
      list.querySelectorAll("[data-command-separator]").forEach((sep) => {
        if (!(sep instanceof HTMLElement)) {
          return;
        }
        sep.hidden = visibleCount === 0;
      });
      if (emptyEl instanceof HTMLElement) {
        emptyEl.hidden = visibleCount > 0;
      }
    }
    function clearHighlights() {
      items().forEach((el) => {
        el.removeAttribute("data-highlighted");
        el.setAttribute("aria-selected", "false");
      });
      input.removeAttribute("aria-activedescendant");
    }
    function highlightActive() {
      clearHighlights();
      const enabled = visibleEnabledItems();
      const el = enabled[activeIndex];
      if (!el) {
        return;
      }
      el.setAttribute("data-highlighted", "true");
      el.setAttribute("aria-selected", "true");
      el.scrollIntoView({ block: "nearest" });
      if (el.id) {
        input.setAttribute("aria-activedescendant", el.id);
      }
    }
    function selectItem(el, options = {}) {
      var _a5;
      if (el.hasAttribute("data-disabled")) {
        return;
      }
      const value = (_a5 = el.getAttribute("data-value")) != null ? _a5 : "";
      root.dispatchEvent(
        new CustomEvent("stencil:command:select", {
          bubbles: true,
          detail: { value, label: itemLabel(el), element: el }
        })
      );
      if (options.fromKeyboard) {
        el.dataset.commandSelectDispatching = "true";
        if (el instanceof HTMLButtonElement || el instanceof HTMLAnchorElement) {
          el.click();
        }
        delete el.dataset.commandSelectDispatching;
      }
      const keepOpen = el.getAttribute("data-keep-open") === "true";
      if (!keepOpen) {
        closeNearestDialog(root);
      }
    }
    function closeNearestDialog(from) {
      const dialog2 = from.closest("dialog[data-dialog-content], dialog[data-command-dialog]");
      if (dialog2 instanceof HTMLDialogElement && dialog2.open) {
        dialog2.close();
      }
    }
    function resetHighlight() {
      const enabled = visibleEnabledItems();
      activeIndex = enabled.length > 0 ? 0 : -1;
      highlightActive();
    }
    input.addEventListener("input", () => {
      applyFilter(input.value);
      resetHighlight();
    });
    list.addEventListener("mousemove", (event) => {
      const item = event.target instanceof Element ? event.target.closest("[data-command-item]") : null;
      if (!(item instanceof HTMLElement) || item.hasAttribute("data-disabled") || item.hidden) {
        return;
      }
      const enabled = visibleEnabledItems();
      const index = enabled.indexOf(item);
      if (index >= 0 && index !== activeIndex) {
        activeIndex = index;
        highlightActive();
      }
    });
    list.addEventListener("click", (event) => {
      const item = event.target instanceof Element ? event.target.closest("[data-command-item]") : null;
      if (!(item instanceof HTMLElement)) {
        return;
      }
      if (item.dataset.commandSelectDispatching === "true") {
        return;
      }
      if (!(item instanceof HTMLAnchorElement)) {
        event.preventDefault();
      }
      selectItem(item);
    });
    input.addEventListener("keydown", (event) => {
      const enabled = visibleEnabledItems();
      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          if (enabled.length === 0) {
            break;
          }
          activeIndex = Math.min(activeIndex + 1, enabled.length - 1);
          if (activeIndex < 0) {
            activeIndex = 0;
          }
          highlightActive();
          break;
        case "ArrowUp":
          event.preventDefault();
          if (enabled.length === 0) {
            break;
          }
          activeIndex = Math.max(activeIndex - 1, 0);
          highlightActive();
          break;
        case "Home":
          if (enabled.length > 0) {
            event.preventDefault();
            activeIndex = 0;
            highlightActive();
          }
          break;
        case "End":
          if (enabled.length > 0) {
            event.preventDefault();
            activeIndex = enabled.length - 1;
            highlightActive();
          }
          break;
        case "Enter":
          if (enabled.length > 0 && activeIndex >= 0) {
            event.preventDefault();
            const el = enabled[activeIndex];
            if (el) {
              selectItem(el, { fromKeyboard: true });
            }
          }
          break;
        case "Escape": {
          const dialog2 = root.closest(
            "dialog[data-dialog-content], dialog[data-command-dialog]"
          );
          if (dialog2 instanceof HTMLDialogElement && dialog2.open) {
            event.preventDefault();
            dialog2.close();
          } else if (input.value !== "") {
            event.preventDefault();
            input.value = "";
            applyFilter("");
            resetHighlight();
          }
          break;
        }
        default:
          break;
      }
    });
    const dialog = root.closest("dialog[data-dialog-content], dialog[data-command-dialog]");
    if (dialog instanceof HTMLDialogElement) {
      dialog.addEventListener("close", () => {
        input.value = "";
        applyFilter("");
        clearHighlights();
        activeIndex = -1;
      });
      dialog.addEventListener("stencil:dialog:open", () => {
        applyFilter(input.value);
        resetHighlight();
      });
    }
    applyFilter("");
    resetHighlight();
  }
  var _a;
  if (typeof window !== "undefined") {
    window.Stencil = (_a = window.Stencil) != null ? _a : {};
    window.Stencil.command = {
      init: initCommands
    };
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initCommands(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initCommands());
    } else {
      initCommands();
    }
  }

  // resources/assets/js/shared/anchored-panel.js
  function positionAnchoredPanel(panel, trigger, options = {}) {
    var _a5, _b, _c;
    const gap = (_a5 = options.gap) != null ? _a5 : 6;
    const viewportPadding = (_b = options.viewportPadding) != null ? _b : 8;
    const mediaRoot = trigger.closest("#readme-media");
    if (mediaRoot) {
      const anchorRoot = (_c = trigger.closest(
        "[data-date-picker], [data-time-picker], [data-datetime-picker], [data-color-picker]"
      )) != null ? _c : trigger.parentElement;
      if (anchorRoot instanceof HTMLElement) {
        if (getComputedStyle(anchorRoot).position === "static") {
          anchorRoot.style.position = "relative";
        }
        const triggerRect = trigger.getBoundingClientRect();
        const rootRect = anchorRoot.getBoundingClientRect();
        panel.style.position = "absolute";
        panel.style.left = `${Math.max(0, triggerRect.left - rootRect.left)}px`;
        panel.style.top = `${triggerRect.bottom - rootRect.top + gap}px`;
        panel.style.zIndex = "200";
        panel.style.maxHeight = "";
        if (options.fitContent) {
          panel.style.width = "max-content";
          panel.style.minWidth = "";
        } else {
          panel.style.width = `${Math.max(triggerRect.width, panel.offsetWidth || triggerRect.width)}px`;
          panel.style.minWidth = `${triggerRect.width}px`;
        }
        return;
      }
    }
    const rect = trigger.getBoundingClientRect();
    panel.style.position = "fixed";
    panel.style.left = `${Math.max(viewportPadding, rect.left)}px`;
    panel.style.zIndex = "200";
    if (options.fitContent) {
      panel.style.width = "max-content";
      panel.style.minWidth = "";
    } else {
      panel.style.width = `${Math.max(rect.width, panel.offsetWidth || rect.width)}px`;
      panel.style.minWidth = `${rect.width}px`;
    }
    const wasHidden = panel.hidden;
    panel.hidden = false;
    panel.style.visibility = "hidden";
    panel.style.pointerEvents = "none";
    const panelHeight = panel.offsetHeight;
    panel.style.visibility = "";
    panel.style.pointerEvents = "";
    panel.hidden = wasHidden;
    let top = rect.bottom + gap;
    const maxBottom = window.innerHeight - viewportPadding;
    if (top + panelHeight > maxBottom) {
      const topAbove = rect.top - gap - panelHeight;
      if (topAbove >= viewportPadding) {
        top = topAbove;
      } else {
        panel.style.maxHeight = `${maxBottom - top}px`;
      }
    } else {
      panel.style.maxHeight = "";
    }
    panel.style.top = `${top}px`;
  }
  function ensurePanelPortaled(panel, markerParent, portalMarker) {
    var _a5, _b;
    if (((_a5 = markerParent == null ? void 0 : markerParent.closest) == null ? void 0 : _a5.call(markerParent, "#readme-media")) || ((_b = panel.closest) == null ? void 0 : _b.call(panel, "#readme-media"))) {
      return;
    }
    if (panel.parentElement === document.body) {
      return;
    }
    if (markerParent && !portalMarker.parentNode) {
      markerParent.insertBefore(portalMarker, panel);
    }
    document.body.appendChild(panel);
    panel.dataset.stencilPortaled = "true";
  }
  function restorePanelFromPortal(panel, markerParent, portalMarker) {
    if (panel.parentElement !== document.body) {
      return;
    }
    if (markerParent.isConnected) {
      if (portalMarker.parentNode === markerParent) {
        markerParent.insertBefore(panel, portalMarker.nextSibling);
      } else {
        markerParent.appendChild(panel);
      }
    }
    delete panel.dataset.stencilPortaled;
  }

  // resources/assets/js/date-picker.js
  var SELECTOR = "[data-date-picker]";
  var initialized9 = /* @__PURE__ */ new WeakSet();
  function initDatePickers(root = document) {
    document.querySelectorAll("[data-date-picker-panel][data-stencil-portaled]").forEach((panel) => {
      if (!(panel instanceof HTMLElement) || panel.closest("[data-date-picker]")) {
        return;
      }
      panel.remove();
    });
    root.querySelectorAll(SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized9.has(element)) {
        return;
      }
      initialized9.add(element);
      bindDatePicker(element);
    });
  }
  function bindDatePicker(root) {
    var _a5, _b, _c, _d;
    const hidden = root.querySelector("[data-date-picker-hidden-input]");
    const panel = root.querySelector("[data-date-picker-panel]");
    const trigger = (_a5 = root.querySelector("[data-date-picker-trigger]")) != null ? _a5 : root.querySelector("button[data-date-picker-trigger]");
    const valueEl = root.querySelector("[data-date-picker-value]");
    const inputEl = root.querySelector("[data-date-picker-input]");
    const calendarEl = root.querySelector("[data-calendar]");
    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
      return;
    }
    const locale = (_b = root.dataset.datePickerLocale) != null ? _b : "en";
    const withConfirmation = root.hasAttribute("data-date-picker-with-confirmation");
    const portalMarker = document.createComment("stencil-date-picker-portal");
    const signal = createBindSignal(root);
    let isOpen = false;
    let calendarApi = null;
    if (calendarEl instanceof HTMLElement) {
      calendarApi = bindCalendar(calendarEl);
    }
    function displayValue(value) {
      var _a6;
      const text = formatDisplay(value, root.dataset.datePickerMode === "range", locale);
      if (valueEl instanceof HTMLElement) {
        if (text) {
          valueEl.textContent = text;
          valueEl.removeAttribute("data-placeholder");
        } else {
          valueEl.textContent = (_a6 = valueEl.getAttribute("data-placeholder-text")) != null ? _a6 : "";
          valueEl.setAttribute("data-placeholder", "true");
        }
      }
      if (inputEl instanceof HTMLInputElement) {
        inputEl.value = text;
      }
    }
    function syncCalendarFromHidden() {
      calendarApi == null ? void 0 : calendarApi.setValue(hidden.value);
    }
    function open() {
      isOpen = true;
      panel.hidden = false;
      panel.removeAttribute("aria-hidden");
      panel.setAttribute("role", "dialog");
      panel.setAttribute("aria-modal", "true");
      if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", "true");
        ensurePanelPortaled(panel, root, portalMarker);
        positionAnchoredPanel(panel, trigger, { fitContent: true });
      }
      syncCalendarFromHidden();
      if (calendarEl instanceof HTMLElement) {
        calendarEl.focus();
      } else {
        panel.focus();
      }
    }
    function close() {
      isOpen = false;
      panel.hidden = true;
      panel.setAttribute("aria-hidden", "true");
      panel.removeAttribute("role");
      panel.removeAttribute("aria-modal");
      restorePanelFromPortal(panel, root, portalMarker);
      if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", "false");
        trigger.focus();
      }
    }
    function revertSelection() {
      syncCalendarFromHidden();
    }
    function applyValue(value) {
      hidden.value = value;
      displayValue(value);
      calendarApi == null ? void 0 : calendarApi.setValue(value);
      hidden.dispatchEvent(new Event("input", { bubbles: true }));
      hidden.dispatchEvent(new Event("change", { bubbles: true }));
    }
    (_c = root.querySelector("[data-date-picker-confirm]")) == null ? void 0 : _c.addEventListener("click", () => {
      var _a6;
      const value = (_a6 = calendarApi == null ? void 0 : calendarApi.getValue()) != null ? _a6 : hidden.value;
      applyValue(value);
      close();
    });
    (_d = root.querySelector("[data-date-picker-cancel]")) == null ? void 0 : _d.addEventListener("click", () => {
      revertSelection();
      close();
    });
    root.querySelectorAll("[data-date-picker-preset]").forEach((button) => {
      button.addEventListener("click", () => {
        var _a6, _b2;
        if (!(button instanceof HTMLElement)) {
          return;
        }
        const start = (_a6 = button.dataset.datePickerPresetStart) != null ? _a6 : "";
        const end = (_b2 = button.dataset.datePickerPresetEnd) != null ? _b2 : "";
        const value = formatRangeValue(start, end);
        if (!withConfirmation) {
          applyValue(value);
          close();
          return;
        }
        calendarApi == null ? void 0 : calendarApi.setValue(value);
      });
    });
    root.querySelectorAll("[data-date-picker-clear]").forEach((clear) => {
      clear.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        applyValue("");
        close();
      });
    });
    const openOnClick = (event) => {
      event.preventDefault();
      open();
    };
    if (trigger instanceof HTMLElement) {
      trigger.addEventListener("click", openOnClick);
    }
    calendarEl == null ? void 0 : calendarEl.addEventListener("calendar:change", (event) => {
      var _a6, _b2;
      if (!(event instanceof CustomEvent)) {
        return;
      }
      const value = (_b2 = (_a6 = event.detail) == null ? void 0 : _a6.value) != null ? _b2 : "";
      if (!withConfirmation && value) {
        applyValue(value);
        close();
      }
    });
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!isOpen) {
          return;
        }
        const target = event.target;
        if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
          revertSelection();
          close();
        }
      },
      { signal }
    );
    document.addEventListener(
      "keydown",
      (event) => {
        if (!isOpen || event.key !== "Escape") {
          return;
        }
        revertSelection();
        close();
      },
      { signal }
    );
    window.addEventListener(
      "scroll",
      () => {
        if (!isOpen || !(trigger instanceof HTMLElement)) {
          return;
        }
        positionAnchoredPanel(panel, trigger, { fitContent: true });
      },
      { capture: true, signal }
    );
    displayValue(hidden.value);
  }
  function formatDisplay(value, range, locale) {
    if (!value) {
      return "";
    }
    if (range && value.includes("/")) {
      const [start, end] = value.split("/");
      return `${formatDateLabel(start, locale)} \u2013 ${formatDateLabel(end, locale)}`;
    }
    if (value.includes(",")) {
      return value.split(",").map((part) => formatDateLabel(part.trim(), locale)).join(", ");
    }
    return formatDateLabel(value, locale);
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initDatePickers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initDatePickers());
    } else {
      initDatePickers();
    }
  }

  // resources/assets/js/datetime-picker.js
  var SELECTOR2 = "[data-datetime-picker]";
  var initialized10 = /* @__PURE__ */ new WeakSet();
  function initDatetimePickers(root = document) {
    document.querySelectorAll("[data-datetime-picker-panel][data-stencil-portaled]").forEach((panel) => {
      if (!(panel instanceof HTMLElement) || panel.closest("[data-datetime-picker]")) {
        return;
      }
      panel.remove();
    });
    root.querySelectorAll(SELECTOR2).forEach((element) => {
      if (!(element instanceof HTMLElement) || initialized10.has(element)) {
        return;
      }
      initialized10.add(element);
      bindDatetimePicker(element);
    });
  }
  function bindDatetimePicker(root) {
    var _a5, _b, _c, _d, _e;
    const hidden = root.querySelector("[data-datetime-picker-hidden-input]");
    const panel = root.querySelector("[data-datetime-picker-panel]");
    const trigger = root.querySelector(
      "[data-datetime-picker-trigger], [data-date-picker-trigger]"
    );
    const valueEl = root.querySelector("[data-date-picker-value]");
    const calendarEl = root.querySelector("[data-datetime-picker-calendar]");
    const timeList = root.querySelector("[data-datetime-picker-time-list]");
    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
      return;
    }
    const locale = (_a5 = root.dataset.datetimePickerLocale) != null ? _a5 : "en";
    const timeZone = (_b = root.dataset.datetimePickerTimezone) != null ? _b : "UTC";
    const withSeconds = root.hasAttribute("data-datetime-picker-seconds");
    const step = parseInt((_c = root.dataset.datetimePickerStep) != null ? _c : "30", 10) || 30;
    const portalMarker = document.createComment("stencil-datetime-picker-portal");
    const signal = createBindSignal(root);
    let isOpen = false;
    let activeTimeIndex = 0;
    let selectedDate = "";
    let selectedTime = withSeconds ? "00:00:00" : "00:00";
    let calendarApi = null;
    if (calendarEl instanceof HTMLElement) {
      calendarApi = bindCalendar(calendarEl);
    }
    if (timeList instanceof HTMLElement) {
      timeList.setAttribute("role", "listbox");
      timeList.tabIndex = -1;
      for (let minutes = 0; minutes < 24 * 60; minutes += step) {
        const h = Math.floor(minutes / 60);
        const m = minutes % 60;
        const value = withSeconds ? `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}:00` : `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
        const button = document.createElement("button");
        button.type = "button";
        button.className = "flex w-full rounded-lg px-2 py-1.5 text-left text-sm tabular-nums hover:bg-zinc-100 dark:hover:bg-zinc-800";
        button.dataset.datetimePickerTime = value;
        button.textContent = formatTimeLabel(value, locale, timeZone, withSeconds);
        button.setAttribute("role", "option");
        button.tabIndex = -1;
        timeList.appendChild(button);
      }
    }
    function timeOptionElements() {
      if (!(timeList instanceof HTMLElement)) {
        return [];
      }
      return [...timeList.querySelectorAll("[data-datetime-picker-time]")].filter(
        (el) => el instanceof HTMLElement
      );
    }
    function focusTimeOption(index) {
      const list = timeOptionElements();
      if (list.length === 0) {
        return;
      }
      activeTimeIndex = Math.max(0, Math.min(index, list.length - 1));
      list.forEach((el, i) => {
        el.tabIndex = i === activeTimeIndex ? 0 : -1;
      });
      const active = list[activeTimeIndex];
      active == null ? void 0 : active.focus();
      active == null ? void 0 : active.scrollIntoView({ block: "nearest" });
    }
    function loadFromHidden() {
      if (!hidden.value) {
        selectedDate = "";
        selectedTime = withSeconds ? "00:00:00" : "00:00";
        calendarApi == null ? void 0 : calendarApi.setValue("");
        return;
      }
      const [datePart, timePartRaw] = hidden.value.split("T");
      selectedDate = datePart != null ? datePart : "";
      selectedTime = (timePartRaw != null ? timePartRaw : "").slice(0, withSeconds ? 8 : 5) || selectedTime;
      calendarApi == null ? void 0 : calendarApi.setValue(selectedDate);
    }
    function open() {
      isOpen = true;
      panel.hidden = false;
      panel.removeAttribute("aria-hidden");
      panel.setAttribute("role", "dialog");
      panel.setAttribute("aria-modal", "true");
      if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", "true");
        ensurePanelPortaled(panel, root, portalMarker);
        positionAnchoredPanel(panel, trigger, { fitContent: true });
      }
      loadFromHidden();
      syncTimeListSelection();
      if (calendarEl instanceof HTMLElement) {
        calendarEl.focus();
      } else {
        panel.focus();
      }
    }
    function close() {
      isOpen = false;
      panel.hidden = true;
      panel.setAttribute("aria-hidden", "true");
      panel.removeAttribute("role");
      panel.removeAttribute("aria-modal");
      restorePanelFromPortal(panel, root, portalMarker);
      if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", "false");
        trigger.focus();
      }
    }
    function composeIso() {
      if (!selectedDate) {
        return "";
      }
      const [h, m, s] = selectedTime.split(":");
      const date = new Date(
        Date.UTC(
          Number(selectedDate.slice(0, 4)),
          Number(selectedDate.slice(5, 7)) - 1,
          Number(selectedDate.slice(8, 10)),
          Number(h),
          Number(m),
          Number(s != null ? s : 0)
        )
      );
      return toIsoDateTimeString(date);
    }
    function syncTimeListSelection() {
      if (!(timeList instanceof HTMLElement)) {
        return;
      }
      const list = timeOptionElements();
      list.forEach((el, index) => {
        const selected = el.dataset.datetimePickerTime === selectedTime;
        el.setAttribute("aria-selected", selected ? "true" : "false");
        el.classList.toggle("bg-zinc-900", selected);
        el.classList.toggle("text-white", selected);
        el.classList.toggle("dark:bg-zinc-100", selected);
        el.classList.toggle("dark:text-zinc-900", selected);
        el.classList.toggle("hover:bg-zinc-100", !selected);
        el.classList.toggle("dark:hover:bg-zinc-800", !selected);
        el.tabIndex = -1;
        if (selected) {
          activeTimeIndex = index;
          el.tabIndex = 0;
          el.scrollIntoView({ block: "nearest" });
        }
      });
      if (list.length > 0 && !list.some((el) => el.tabIndex === 0)) {
        list[0].tabIndex = 0;
        activeTimeIndex = 0;
      }
    }
    function displayValue(value) {
      var _a6;
      if (!(valueEl instanceof HTMLElement)) {
        return;
      }
      if (!value) {
        valueEl.textContent = (_a6 = valueEl.getAttribute("data-placeholder-text")) != null ? _a6 : "";
        valueEl.setAttribute("data-placeholder", "true");
        return;
      }
      valueEl.textContent = formatDateTimeLabel(value, locale, timeZone, withSeconds);
      valueEl.removeAttribute("data-placeholder");
    }
    function apply(value) {
      hidden.value = value;
      displayValue(value);
      hidden.dispatchEvent(new Event("input", { bubbles: true }));
      hidden.dispatchEvent(new Event("change", { bubbles: true }));
    }
    trigger == null ? void 0 : trigger.addEventListener("click", (event) => {
      event.preventDefault();
      open();
    });
    calendarEl == null ? void 0 : calendarEl.addEventListener("calendar:change", (event) => {
      var _a6, _b2;
      if (event instanceof CustomEvent) {
        selectedDate = (_b2 = (_a6 = event.detail) == null ? void 0 : _a6.value) != null ? _b2 : "";
      }
    });
    timeList == null ? void 0 : timeList.addEventListener("click", (event) => {
      const option = event.target instanceof Element ? event.target.closest("[data-datetime-picker-time]") : null;
      if (option instanceof HTMLElement && option.dataset.datetimePickerTime) {
        selectedTime = option.dataset.datetimePickerTime;
        syncTimeListSelection();
        focusTimeOption(activeTimeIndex);
      }
    });
    timeList == null ? void 0 : timeList.addEventListener("keydown", (event) => {
      if (!isOpen) {
        return;
      }
      const list = timeOptionElements();
      if (list.length === 0) {
        return;
      }
      let nextIndex = activeTimeIndex;
      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          nextIndex = Math.min(activeTimeIndex + 1, list.length - 1);
          break;
        case "ArrowUp":
          event.preventDefault();
          nextIndex = Math.max(activeTimeIndex - 1, 0);
          break;
        case "Home":
          event.preventDefault();
          nextIndex = 0;
          break;
        case "End":
          event.preventDefault();
          nextIndex = list.length - 1;
          break;
        case "Enter":
        case " ":
          event.preventDefault();
          nextIndex = activeTimeIndex;
          break;
        default:
          return;
      }
      const next = list[nextIndex];
      if (next == null ? void 0 : next.dataset.datetimePickerTime) {
        selectedTime = next.dataset.datetimePickerTime;
        syncTimeListSelection();
        focusTimeOption(activeTimeIndex);
      }
    });
    (_d = root.querySelector("[data-datetime-picker-confirm]")) == null ? void 0 : _d.addEventListener("click", () => {
      apply(composeIso());
      close();
    });
    (_e = root.querySelector("[data-datetime-picker-cancel]")) == null ? void 0 : _e.addEventListener("click", () => {
      loadFromHidden();
      close();
    });
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!isOpen) {
          return;
        }
        const target = event.target;
        if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
          loadFromHidden();
          close();
        }
      },
      { signal }
    );
    document.addEventListener(
      "keydown",
      (event) => {
        if (!isOpen || event.key !== "Escape") {
          return;
        }
        event.preventDefault();
        loadFromHidden();
        close();
      },
      { signal }
    );
    window.addEventListener(
      "scroll",
      () => {
        if (!isOpen || !(trigger instanceof HTMLElement)) {
          return;
        }
        positionAnchoredPanel(panel, trigger, { fitContent: true });
      },
      { capture: true, signal }
    );
    if (hidden.value) {
      loadFromHidden();
      apply(hidden.value);
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initDatetimePickers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initDatetimePickers());
    } else {
      initDatetimePickers();
    }
  }

  // resources/assets/js/dialog.js
  var DIALOG_CONTENT_SELECTOR = "[data-dialog-content]";
  var initialized11 = /* @__PURE__ */ new WeakSet();
  var boundTriggers = /* @__PURE__ */ new WeakSet();
  var namedDialogs = /* @__PURE__ */ new Map();
  function initDialogs(root = document) {
    root.querySelectorAll(DIALOG_CONTENT_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLDialogElement)) {
        return;
      }
      if (initialized11.has(element)) {
        return;
      }
      initialized11.add(element);
      bindDialog(element);
    });
    root.querySelectorAll("[data-dialog-trigger], [data-dialog-open]").forEach((trigger) => {
      if (!(trigger instanceof HTMLElement)) {
        return;
      }
      if (boundTriggers.has(trigger)) {
        return;
      }
      boundTriggers.add(trigger);
      bindTrigger(trigger);
    });
  }
  function showDialog(name) {
    const dialog = namedDialogs.get(name);
    if (dialog instanceof HTMLDialogElement && !dialog.open) {
      openDialog(dialog);
    }
  }
  function closeDialog(name) {
    const dialog = namedDialogs.get(name);
    if (dialog instanceof HTMLDialogElement && dialog.open) {
      dialog.close();
    }
  }
  function openDialog(dialog) {
    var _a5;
    const previouslyFocused = document.activeElement instanceof HTMLElement ? document.activeElement : null;
    dialog.dataset.dialogPreviouslyFocused = previouslyFocused ? "stored" : "";
    if (previouslyFocused) {
      dialog._stencilPreviousFocus = previouslyFocused;
    }
    if (typeof dialog.showModal === "function") {
      dialog.showModal();
    } else {
      dialog.setAttribute("open", "");
    }
    dialog.dataset.state = "open";
    dialog.dispatchEvent(
      new CustomEvent("stencil:dialog:open", {
        bubbles: true,
        detail: { name: (_a5 = dialog.dataset.dialogName) != null ? _a5 : null }
      })
    );
    focusInitialElement(dialog);
  }
  function bindDialog(dialog) {
    const name = dialog.dataset.dialogName;
    if (typeof name === "string" && name !== "") {
      namedDialogs.set(name, dialog);
    }
    const dismissible = dialog.dataset.dialogDismissible !== "false";
    dialog.addEventListener("cancel", (event) => {
      if (!dismissible) {
        event.preventDefault();
        return;
      }
      dialog.dispatchEvent(
        new CustomEvent("stencil:dialog:cancel", {
          bubbles: true,
          detail: { name: name != null ? name : null }
        })
      );
    });
    dialog.addEventListener("close", () => {
      dialog.dataset.state = "closed";
      restoreFocus(dialog);
      dialog.dispatchEvent(
        new CustomEvent("stencil:dialog:close", {
          bubbles: true,
          detail: { name: name != null ? name : null }
        })
      );
    });
    dialog.addEventListener("click", (event) => {
      if (!dismissible) {
        return;
      }
      const panel = dialog.querySelector("[data-dialog-panel]");
      if (!(panel instanceof HTMLElement)) {
        return;
      }
      if (event.target === dialog) {
        dialog.close();
      }
    });
    dialog.querySelectorAll("[data-dialog-close]").forEach((control) => {
      if (!(control instanceof HTMLElement)) {
        return;
      }
      control.addEventListener("click", (event) => {
        event.preventDefault();
        if (dialog.open) {
          dialog.close();
        }
      });
    });
    dialog.dataset.state = dialog.open ? "open" : "closed";
  }
  function bindTrigger(trigger) {
    trigger.addEventListener("click", (event) => {
      const target = event.target instanceof Element ? event.target.closest('button, a[href], [role="button"]') : null;
      if (target instanceof HTMLButtonElement && target.disabled) {
        return;
      }
      if (target instanceof HTMLAnchorElement && target.getAttribute("aria-disabled") === "true") {
        return;
      }
      event.preventDefault();
      const dialog = resolveDialogForTrigger(trigger);
      if (dialog instanceof HTMLDialogElement) {
        openDialog(dialog);
      }
    });
  }
  function resolveDialogForTrigger(trigger) {
    var _a5;
    const explicitName = (_a5 = trigger.dataset.dialogName) != null ? _a5 : trigger.dataset.dialogOpen;
    if (typeof explicitName === "string" && explicitName !== "") {
      const named = namedDialogs.get(explicitName);
      return named instanceof HTMLDialogElement ? named : null;
    }
    const root = trigger.closest("[data-dialog]");
    if (root instanceof HTMLElement) {
      const rootName = root.dataset.dialogName;
      if (typeof rootName === "string" && rootName !== "") {
        const named = namedDialogs.get(rootName);
        if (named instanceof HTMLDialogElement) {
          return named;
        }
      }
      const local = root.querySelector(DIALOG_CONTENT_SELECTOR);
      if (local instanceof HTMLDialogElement) {
        return local;
      }
    }
    return null;
  }
  function focusInitialElement(dialog) {
    var _a5, _b;
    const isAlert = dialog.getAttribute("role") === "alertdialog";
    const focusTarget = (_b = (_a5 = dialog.querySelector("[data-dialog-initial-focus]")) != null ? _a5 : isAlert ? dialog.querySelector("[data-dialog-cancel]") : null) != null ? _b : dialog.querySelector(
      'button:not([data-dialog-close]):not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );
    if (focusTarget instanceof HTMLElement) {
      focusTarget.focus();
    }
  }
  function restoreFocus(dialog) {
    const previous = dialog._stencilPreviousFocus;
    if (previous instanceof HTMLElement && document.contains(previous)) {
      previous.focus();
    }
    delete dialog._stencilPreviousFocus;
  }
  function closeAllDialogs() {
    document.querySelectorAll(DIALOG_CONTENT_SELECTOR).forEach((element) => {
      if (element instanceof HTMLDialogElement && element.open) {
        element.close();
      }
    });
  }
  var _a2;
  if (typeof window !== "undefined") {
    window.Stencil = (_a2 = window.Stencil) != null ? _a2 : {};
    window.Stencil.dialog = (name) => ({
      show: () => showDialog(name),
      close: () => closeDialog(name)
    });
    window.Stencil.dialogs = {
      closeAll: () => closeAllDialogs()
    };
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initDialogs(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initDialogs());
    } else {
      initDialogs();
    }
  }

  // resources/assets/js/dropdown-menu.js
  var ROOT_SELECTOR2 = "[data-dropdown-menu]";
  var TRIGGER_SELECTOR3 = "[data-dropdown-menu-trigger]";
  var CONTENT_SELECTOR3 = "[data-dropdown-menu-content]";
  var ITEM_SELECTOR2 = '[data-dropdown-menu-item]:not([data-disabled="true"])';
  var initialized12 = /* @__PURE__ */ new WeakSet();
  function initDropdownMenus(root = document) {
    document.querySelectorAll("[data-dropdown-menu-content][data-dropdown-menu-portaled]").forEach((content) => {
      if (!(content instanceof HTMLElement) || content.closest("[data-dropdown-menu]")) {
        return;
      }
      content.remove();
    });
    root.querySelectorAll(ROOT_SELECTOR2).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized12.has(element)) {
        return;
      }
      initialized12.add(element);
      bindDropdownMenu(element);
    });
  }
  function bindDropdownMenu(root) {
    const triggerWrap = root.querySelector(TRIGGER_SELECTOR3);
    const content = root.querySelector(CONTENT_SELECTOR3);
    if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
      return;
    }
    const trigger = resolveTriggerControl(triggerWrap);
    if (!(trigger instanceof HTMLElement)) {
      return;
    }
    let open = false;
    let activeIndex = -1;
    const portalMarker = document.createComment("stencil-dropdown-menu-portal");
    const signal = createBindSignal(root);
    trigger.setAttribute("aria-haspopup", "menu");
    trigger.setAttribute("aria-expanded", "false");
    if (!content.id) {
      content.id = `dropdown-menu-${Math.random().toString(36).slice(2, 10)}`;
    }
    trigger.setAttribute("aria-controls", content.id);
    const items = () => Array.from(content.querySelectorAll(ITEM_SELECTOR2)).filter(
      (node) => node instanceof HTMLElement
    );
    const reposition = () => {
      if (!open) {
        return;
      }
      positionContent(content, trigger, root);
    };
    const onScroll = (event) => {
      if (!open) {
        return;
      }
      const target = event.target;
      if (target instanceof Node && content.contains(target)) {
        return;
      }
      setOpen(false);
    };
    const setOpen = (nextOpen, options = {}) => {
      open = nextOpen;
      content.dataset.state = open ? "open" : "closed";
      content.hidden = !open;
      content.classList.toggle("hidden", !open);
      trigger.setAttribute("aria-expanded", open ? "true" : "false");
      if (open) {
        ensureContentPortaled(content, root, portalMarker);
        positionContent(content, trigger, root);
        const enabled = items();
        if (options.focusIndex === "last") {
          activeIndex = Math.max(0, enabled.length - 1);
        } else if (typeof options.focusIndex === "number") {
          activeIndex = options.focusIndex;
        } else {
          activeIndex = 0;
        }
        highlight(enabled, activeIndex);
        requestAnimationFrame(reposition);
      } else {
        clearHighlight(items());
        activeIndex = -1;
        restoreContentFromPortal(content, root, portalMarker);
        content.style.top = "";
        content.style.left = "";
        content.style.position = "";
        content.style.minWidth = "";
        content.style.zIndex = "";
      }
      root.dispatchEvent(
        new CustomEvent("stencil:dropdown-menu:change", {
          bubbles: true,
          detail: { open }
        })
      );
    };
    trigger.addEventListener("click", (event) => {
      event.preventDefault();
      setOpen(!open);
    });
    trigger.addEventListener("keydown", (event) => {
      if (event.key === "ArrowDown" || event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        setOpen(true, { focusIndex: 0 });
        return;
      }
      if (event.key === "ArrowUp") {
        event.preventDefault();
        setOpen(true, { focusIndex: "last" });
      }
    });
    content.addEventListener("keydown", (event) => {
      const enabled = items();
      if (event.key === "ArrowDown") {
        event.preventDefault();
        activeIndex = activeIndex + 1 >= enabled.length ? 0 : activeIndex + 1;
        highlight(enabled, activeIndex);
        return;
      }
      if (event.key === "ArrowUp") {
        event.preventDefault();
        activeIndex = activeIndex - 1 < 0 ? enabled.length - 1 : activeIndex - 1;
        highlight(enabled, activeIndex);
        return;
      }
      if (event.key === "Home") {
        event.preventDefault();
        activeIndex = 0;
        highlight(enabled, activeIndex);
        return;
      }
      if (event.key === "End") {
        event.preventDefault();
        activeIndex = enabled.length - 1;
        highlight(enabled, activeIndex);
        return;
      }
      if (event.key === "Enter" || event.key === " ") {
        const current = enabled[activeIndex];
        if (current instanceof HTMLElement) {
          event.preventDefault();
          current.click();
        }
      }
    });
    content.addEventListener("click", (event) => {
      const item = event.target instanceof Element ? event.target.closest("[data-dropdown-menu-item]") : null;
      if (!(item instanceof HTMLElement) || !content.contains(item)) {
        return;
      }
      if (item.dataset.disabled === "true") {
        event.preventDefault();
        return;
      }
      const keepOpen = content.dataset.keepOpen === "true" || item.dataset.keepOpen === "true";
      if (!keepOpen) {
        setOpen(false);
        trigger.focus();
      }
    });
    content.addEventListener("mousemove", (event) => {
      const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR2) : null;
      if (!(item instanceof HTMLElement)) {
        return;
      }
      const enabled = items();
      activeIndex = enabled.indexOf(item);
      highlight(enabled, activeIndex);
    });
    document.addEventListener(
      "keydown",
      (event) => {
        if (!open) {
          return;
        }
        if (event.key === "Escape") {
          event.preventDefault();
          setOpen(false);
          trigger.focus();
          return;
        }
        if (event.key === "Tab") {
          setOpen(false);
        }
      },
      { signal }
    );
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open) {
          return;
        }
        const target = event.target;
        if (!(target instanceof Node)) {
          return;
        }
        if (root.contains(target) || content.contains(target)) {
          return;
        }
        setOpen(false);
      },
      { signal }
    );
    window.addEventListener("resize", reposition, { signal });
    window.addEventListener("scroll", onScroll, { capture: true, signal });
  }
  function resolveTriggerControl(wrap) {
    if (wrap.matches('button, a[href], [role="button"]')) {
      return wrap;
    }
    const nested = wrap.querySelector('button, a[href], [role="button"]');
    return nested instanceof HTMLElement ? nested : wrap;
  }
  function highlight(items, index) {
    items.forEach((item, i) => {
      if (i === index) {
        item.dataset.highlighted = "true";
        item.focus({ preventScroll: true });
      } else {
        delete item.dataset.highlighted;
      }
    });
  }
  function clearHighlight(items) {
    items.forEach((item) => {
      delete item.dataset.highlighted;
    });
  }
  function ensureContentPortaled(content, root, portalMarker) {
    if (root.closest("#readme-media") || content.closest("#readme-media")) {
      return;
    }
    if (content.parentElement === document.body) {
      return;
    }
    if (!portalMarker.parentNode) {
      root.insertBefore(portalMarker, content);
    }
    document.body.appendChild(content);
    content.dataset.dropdownMenuPortaled = "true";
  }
  function restoreContentFromPortal(content, root, portalMarker) {
    if (content.parentElement !== document.body) {
      return;
    }
    if (root.isConnected) {
      if (portalMarker.parentNode === root) {
        root.insertBefore(content, portalMarker.nextSibling);
      } else {
        root.appendChild(content);
      }
    }
    delete content.dataset.dropdownMenuPortaled;
  }
  function positionContent(content, trigger, root) {
    const gap = 6;
    const padding = 8;
    const rect = trigger.getBoundingClientRect();
    const align = root.dataset.align || content.dataset.align || "start";
    const side = root.dataset.side || content.dataset.side || "bottom";
    content.style.position = "fixed";
    content.style.zIndex = "200";
    content.style.minWidth = `${Math.max(rect.width, 10)}px`;
    const wasHidden = content.hidden;
    content.hidden = false;
    content.style.visibility = "hidden";
    content.style.pointerEvents = "none";
    const height = content.offsetHeight;
    const width = content.offsetWidth;
    content.style.visibility = "";
    content.style.pointerEvents = "";
    content.hidden = wasHidden;
    let top = side === "top" ? rect.top - gap - height : rect.bottom + gap;
    let left = rect.left;
    if (align === "end") {
      left = rect.right - width;
    } else if (align === "center") {
      left = rect.left + rect.width / 2 - width / 2;
    }
    left = Math.min(Math.max(padding, left), window.innerWidth - width - padding);
    top = Math.min(Math.max(padding, top), window.innerHeight - height - padding);
    content.style.top = `${top}px`;
    content.style.left = `${left}px`;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initDropdownMenus(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initDropdownMenus());
    } else {
      initDropdownMenus();
    }
  }

  // resources/assets/js/file-upload.js
  var FILE_UPLOAD_SELECTOR = "[data-file-upload]";
  var initialized13 = /* @__PURE__ */ new WeakSet();
  function initFileUploads(root = document) {
    root.querySelectorAll(FILE_UPLOAD_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized13.has(element)) {
        return;
      }
      initialized13.add(element);
      bindFileUpload(element);
    });
  }
  function bindFileUpload(root) {
    var _a5;
    const input = root.querySelector("[data-file-upload-input]");
    const dropzone = root.querySelector("[data-file-upload-dropzone]");
    const list = root.querySelector("[data-file-upload-list]");
    const template = root.querySelector("template[data-file-upload-item-template]");
    if (!(input instanceof HTMLInputElement)) {
      return;
    }
    const multiple = root.hasAttribute("data-file-upload-multiple") || input.multiple;
    let files = Array.from((_a5 = input.files) != null ? _a5 : []);
    let syncing = false;
    function dispatchValueEvents(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function formatBytes(bytes) {
      if (!Number.isFinite(bytes) || bytes < 0) {
        return "";
      }
      const units = ["B", "KB", "MB", "GB", "TB"];
      let value = bytes;
      let index = 0;
      while (value >= 1024 && index < units.length - 1) {
        value /= 1024;
        index += 1;
      }
      const precision = index === 0 ? 0 : 1;
      return `${value.toFixed(precision)} ${units[index]}`;
    }
    function matchesAccept(file, accept) {
      if (!accept || accept.trim() === "") {
        return true;
      }
      const tokens = accept.split(",").map((token) => token.trim().toLowerCase()).filter(Boolean);
      if (tokens.length === 0) {
        return true;
      }
      const fileName = file.name.toLowerCase();
      const mime = (file.type || "").toLowerCase();
      return tokens.some((token) => {
        if (token.startsWith(".")) {
          return fileName.endsWith(token);
        }
        if (token.endsWith("/*")) {
          const prefix = token.slice(0, -1);
          return mime.startsWith(prefix);
        }
        return mime === token;
      });
    }
    function setFiles(nextFiles, options = {}) {
      const incoming = Array.from(nextFiles != null ? nextFiles : []).filter(
        (file) => file instanceof File && matchesAccept(file, input.accept)
      );
      if (multiple && options.append) {
        const existingKeys = new Set(
          files.map((file) => `${file.name}:${file.size}:${file.lastModified}`)
        );
        incoming.forEach((file) => {
          const key = `${file.name}:${file.size}:${file.lastModified}`;
          if (!existingKeys.has(key)) {
            files.push(file);
            existingKeys.add(key);
          }
        });
      } else if (multiple) {
        files = incoming;
      } else {
        files = incoming.slice(0, 1);
      }
      syncInput();
      renderList();
      updateEmptyState();
    }
    function syncInput(options = {}) {
      const transfer = new DataTransfer();
      files.forEach((file) => {
        transfer.items.add(file);
      });
      syncing = true;
      input.files = transfer.files;
      syncing = false;
      if (options.dispatch !== false) {
        dispatchValueEvents(input);
      }
    }
    function updateEmptyState() {
      const empty = files.length === 0;
      root.dataset.empty = empty ? "true" : "false";
      if (list instanceof HTMLElement) {
        list.hidden = empty;
      }
    }
    function renderList() {
      if (!(list instanceof HTMLElement) || !(template instanceof HTMLTemplateElement)) {
        return;
      }
      list.replaceChildren();
      files.forEach((file, index) => {
        var _a6;
        const fragment = template.content.cloneNode(true);
        const item = fragment instanceof DocumentFragment ? fragment.querySelector("[data-file-upload-item]") : null;
        if (!(item instanceof HTMLElement)) {
          return;
        }
        item.dataset.index = String(index);
        const heading = item.querySelector("[data-file-upload-item-heading]");
        if (heading instanceof HTMLElement) {
          heading.textContent = file.name;
        }
        const text = item.querySelector("[data-file-upload-item-text]");
        if (text instanceof HTMLElement) {
          const label = formatBytes(file.size);
          text.textContent = label;
          text.hidden = label === "";
        }
        const remove = item.querySelector("[data-file-upload-item-remove]");
        if (remove instanceof HTMLButtonElement) {
          const baseLabel = ((_a6 = remove.getAttribute("aria-label")) == null ? void 0 : _a6.trim()) || "Remove";
          remove.setAttribute("aria-label", `${baseLabel}: ${file.name}`);
          remove.disabled = input.disabled;
        }
        list.appendChild(fragment);
      });
    }
    function removeAt(index) {
      if (index < 0 || index >= files.length) {
        return;
      }
      files.splice(index, 1);
      syncInput();
      renderList();
      updateEmptyState();
    }
    if (dropzone instanceof HTMLElement) {
      dropzone.addEventListener("click", (event) => {
        event.preventDefault();
        if (input.disabled || root.hasAttribute("data-disabled")) {
          return;
        }
        input.click();
      });
      dropzone.addEventListener("keydown", (event) => {
        if (event.key !== "Enter" && event.key !== " ") {
          return;
        }
        event.preventDefault();
        if (input.disabled || root.hasAttribute("data-disabled")) {
          return;
        }
        input.click();
      });
      ["dragenter", "dragover"].forEach((type) => {
        dropzone.addEventListener(type, (event) => {
          event.preventDefault();
          event.stopPropagation();
          if (input.disabled || root.hasAttribute("data-disabled")) {
            return;
          }
          dropzone.dataset.dragging = "true";
        });
      });
      ["dragleave", "dragend"].forEach((type) => {
        dropzone.addEventListener(type, (event) => {
          event.preventDefault();
          event.stopPropagation();
          dropzone.dataset.dragging = "false";
        });
      });
      dropzone.addEventListener("drop", (event) => {
        var _a6;
        event.preventDefault();
        event.stopPropagation();
        dropzone.dataset.dragging = "false";
        if (input.disabled || root.hasAttribute("data-disabled")) {
          return;
        }
        const dropped = (_a6 = event.dataTransfer) == null ? void 0 : _a6.files;
        setFiles(dropped, { append: multiple });
      });
    }
    input.addEventListener("change", () => {
      if (syncing || input.disabled) {
        return;
      }
      setFiles(input.files, { append: false });
    });
    if (list instanceof HTMLElement) {
      list.addEventListener("click", (event) => {
        var _a6;
        const target = event.target instanceof Element ? event.target.closest("[data-file-upload-item-remove]") : null;
        if (!(target instanceof HTMLElement)) {
          return;
        }
        event.preventDefault();
        if (input.disabled || root.hasAttribute("data-disabled")) {
          return;
        }
        const item = target.closest("[data-file-upload-item]");
        if (!(item instanceof HTMLElement)) {
          return;
        }
        const index = Number.parseInt((_a6 = item.dataset.index) != null ? _a6 : "", 10);
        if (Number.isFinite(index)) {
          removeAt(index);
        }
      });
    }
    updateEmptyState();
    renderList();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initFileUploads(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initFileUploads());
    } else {
      initFileUploads();
    }
  }

  // resources/assets/js/input-currency.js
  var INPUT_CURRENCY_SELECTOR = "[data-input-currency]";
  var initialized14 = /* @__PURE__ */ new WeakSet();
  function initInputCurrencies(root = document) {
    root.querySelectorAll(INPUT_CURRENCY_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized14.has(element)) {
        return;
      }
      initialized14.add(element);
      bindInputCurrency(element);
    });
  }
  function bindInputCurrency(root) {
    const mode = root.getAttribute("data-input-currency-mode") || "cents";
    const locale = root.getAttribute("data-input-currency-locale") || "en-US";
    const currency = root.getAttribute("data-input-currency-currency") || "USD";
    const precision = parseInt(root.getAttribute("data-input-currency-precision") || "2", 10);
    const hidden = root.querySelector("[data-input-currency-value]");
    const display = root.querySelector("[data-input-currency-display]");
    if (!(hidden instanceof HTMLInputElement) || !(display instanceof HTMLInputElement)) {
      return;
    }
    if (display.readOnly || display.disabled) {
      return;
    }
    const scale = 10 ** precision;
    const formatter = new Intl.NumberFormat(locale, {
      style: "currency",
      currency,
      minimumFractionDigits: precision,
      maximumFractionDigits: precision
    });
    function minorToFloat(minorUnits2) {
      return minorUnits2 / scale;
    }
    function floatToMinor(amount) {
      return Math.round(amount * scale);
    }
    function syncFromMinor(minorUnits2) {
      if (minorUnits2 <= 0) {
        hidden.value = "";
        display.value = "";
        return;
      }
      const floatValue = minorToFloat(minorUnits2);
      hidden.value = floatValue.toFixed(precision);
      display.value = formatter.format(floatValue);
    }
    function readInitialMinor() {
      const raw = hidden.value.trim();
      if (raw === "") {
        return 0;
      }
      const parsed = Number.parseFloat(raw);
      if (!Number.isFinite(parsed)) {
        return 0;
      }
      return Math.max(0, floatToMinor(parsed));
    }
    let minorUnits = readInitialMinor();
    if (mode !== "cents") {
      return;
    }
    display.addEventListener("keydown", (event) => {
      if (event.ctrlKey || event.metaKey || event.altKey) {
        return;
      }
      const key = event.key;
      if (key === "Tab" || key === "Escape" || key.startsWith("Arrow") || key === "Home" || key === "End") {
        return;
      }
      if (key === "Backspace" || key === "Delete") {
        event.preventDefault();
        minorUnits = Math.floor(minorUnits / 10);
        syncFromMinor(minorUnits);
        return;
      }
      if (key.length === 1 && key >= "0" && key <= "9") {
        event.preventDefault();
        const digit = key.charCodeAt(0) - 48;
        minorUnits = minorUnits * 10 + digit;
        syncFromMinor(minorUnits);
      } else if (key.length === 1) {
        event.preventDefault();
      }
    });
    display.addEventListener("paste", (event) => {
      var _a5, _b;
      event.preventDefault();
      const text = (_b = (_a5 = event.clipboardData) == null ? void 0 : _a5.getData("text")) != null ? _b : "";
      const digits = text.replace(/\D/g, "");
      if (digits === "") {
        return;
      }
      minorUnits = Number.parseInt(digits, 10);
      if (!Number.isFinite(minorUnits)) {
        minorUnits = 0;
      }
      syncFromMinor(minorUnits);
    });
    display.addEventListener("input", (event) => {
      event.preventDefault();
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initInputCurrencies(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initInputCurrencies());
    } else {
      initInputCurrencies();
    }
  }

  // resources/assets/js/input-enhancements.js
  var INPUT_ENHANCED_SELECTOR = "[data-input-enhanced]";
  var initialized15 = /* @__PURE__ */ new WeakSet();
  function initInputEnhancements(root = document) {
    root.querySelectorAll(INPUT_ENHANCED_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized15.has(element)) {
        return;
      }
      initialized15.add(element);
      bindInputEnhancements(element);
    });
  }
  function bindInputEnhancements(root) {
    var _a5;
    const control = root.querySelector("[data-input-control]");
    if (!(control instanceof HTMLInputElement)) {
      return;
    }
    const maskPattern = (_a5 = root.getAttribute("data-input-mask")) != null ? _a5 : "";
    const viewable = root.hasAttribute("data-input-viewable");
    const copyable = root.hasAttribute("data-input-copyable");
    const counter = root.hasAttribute("data-input-counter");
    if (maskPattern !== "") {
      bindMask(control, maskPattern);
    }
    if (viewable) {
      bindViewable(control, root);
    }
    if (copyable) {
      bindCopyable(control, root);
    }
    if (counter) {
      bindCounter(control, root);
    }
  }
  function parseMask(pattern) {
    const tokens = [];
    for (let i = 0; i < pattern.length; i += 1) {
      const char = pattern[i];
      if (char === "#") {
        tokens.push({ type: "digit", value: char });
      } else if (char === "A") {
        tokens.push({ type: "letter", value: char });
      } else {
        tokens.push({ type: "literal", value: char });
      }
    }
    return tokens;
  }
  function matchesMaskSlot(token, char) {
    if (token.type === "digit") {
      return /\d/.test(char);
    }
    if (token.type === "letter") {
      return /[a-zA-Z]/.test(char);
    }
    return false;
  }
  function bindMask(control, pattern) {
    const tokens = parseMask(pattern);
    function formatValue2(raw) {
      const chars = [...raw].filter((char) => /\d/.test(char) || /[a-zA-Z]/.test(char));
      let charIndex = 0;
      let output = "";
      for (const token of tokens) {
        if (token.type === "literal") {
          output += token.value;
          continue;
        }
        while (charIndex < chars.length && !matchesMaskSlot(token, chars[charIndex])) {
          charIndex += 1;
        }
        if (charIndex >= chars.length) {
          break;
        }
        output += chars[charIndex];
        charIndex += 1;
      }
      return output;
    }
    control.addEventListener("input", () => {
      const formatted = formatValue2(control.value);
      control.value = formatted;
    });
  }
  function bindViewable(control, root) {
    const toggle2 = root.querySelector("[data-input-view-toggle]");
    if (!(toggle2 instanceof HTMLButtonElement)) {
      return;
    }
    toggle2.addEventListener("click", (event) => {
      event.preventDefault();
      const isPassword = control.type === "password";
      control.type = isPassword ? "text" : "password";
      toggle2.setAttribute("aria-pressed", isPassword ? "true" : "false");
    });
  }
  function bindCopyable(control, root) {
    const button = root.querySelector("[data-input-copy]");
    if (!(button instanceof HTMLButtonElement)) {
      return;
    }
    button.addEventListener("click", async (event) => {
      event.preventDefault();
      const value = control.value;
      if (value === "") {
        return;
      }
      try {
        await navigator.clipboard.writeText(value);
      } catch (e) {
        const helper = document.createElement("textarea");
        helper.value = value;
        helper.style.position = "fixed";
        helper.style.left = "-9999px";
        document.body.appendChild(helper);
        helper.select();
        document.execCommand("copy");
        helper.remove();
      }
    });
  }
  function bindCounter(control, root) {
    const counterEl = root.querySelector("[data-input-counter-display]");
    if (!(counterEl instanceof HTMLElement)) {
      return;
    }
    const maxLength = control.maxLength > 0 ? control.maxLength : null;
    function update() {
      const length = control.value.length;
      counterEl.textContent = maxLength !== null ? `${length}/${maxLength}` : String(length);
    }
    control.addEventListener("input", update);
    update();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initInputEnhancements(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initInputEnhancements());
    } else {
      initInputEnhancements();
    }
  }

  // resources/assets/js/input-otp.js
  var INPUT_OTP_SELECTOR = "[data-input-otp]";
  var initialized16 = /* @__PURE__ */ new WeakSet();
  function initInputOtps(root = document) {
    root.querySelectorAll(INPUT_OTP_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized16.has(element)) {
        return;
      }
      initialized16.add(element);
      bindInputOtp(element);
    });
  }
  function bindInputOtp(root) {
    var _a5;
    const hiddenInput = root.querySelector("[data-input-otp-hidden-input]");
    if (!(hiddenInput instanceof HTMLInputElement)) {
      return;
    }
    const mode = root.getAttribute("data-input-otp-mode") === "alphanumeric" ? "alphanumeric" : "numeric";
    const lengthAttr = Number.parseInt((_a5 = root.getAttribute("data-input-otp-length")) != null ? _a5 : "", 10);
    function slots() {
      return Array.from(root.querySelectorAll("[data-input-otp-slot]")).filter((node) => node instanceof HTMLInputElement).sort((a, b) => {
        var _a6, _b;
        const ai = Number.parseInt((_a6 = a.dataset.index) != null ? _a6 : "", 10);
        const bi = Number.parseInt((_b = b.dataset.index) != null ? _b : "", 10);
        return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
      });
    }
    const slotElements = slots();
    const length = Number.isFinite(lengthAttr) && lengthAttr > 0 ? lengthAttr : slotElements.length;
    if (slotElements.length === 0) {
      return;
    }
    function isAllowedChar(char) {
      if (mode === "numeric") {
        return /^[0-9]$/.test(char);
      }
      return /^[a-zA-Z0-9]$/.test(char);
    }
    function sanitize(raw) {
      return Array.from(raw).map((char) => mode === "alphanumeric" ? char.toUpperCase() : char).filter(isAllowedChar).join("").slice(0, length);
    }
    function dispatchValueEvents(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function isDisabled() {
      return root.hasAttribute("data-disabled") || hiddenInput.disabled;
    }
    function syncFromSlots(options = {}) {
      const value = slotElements.slice(0, length).map((slot) => slot.value.slice(0, 1)).join("");
      const previous = hiddenInput.value;
      hiddenInput.value = value;
      root.dataset.complete = value.length === length ? "true" : "false";
      if (options.dispatch !== false && previous !== value) {
        dispatchValueEvents(hiddenInput);
      }
    }
    function applyValue(value, options = {}) {
      const next = sanitize(value);
      slotElements.forEach((slot, index) => {
        var _a6;
        slot.value = (_a6 = next.charAt(index)) != null ? _a6 : "";
      });
      syncFromSlots({ dispatch: options.dispatch });
      if (typeof options.focusIndex === "number") {
        const target = slotElements[Math.min(Math.max(options.focusIndex, 0), slotElements.length - 1)];
        target == null ? void 0 : target.focus();
        target == null ? void 0 : target.select();
      }
    }
    function focusSlot(index) {
      const target = slotElements[Math.min(Math.max(index, 0), slotElements.length - 1)];
      if (!target || target.disabled) {
        return;
      }
      target.focus();
      target.select();
    }
    slotElements.forEach((slot, index) => {
      slot.addEventListener("focus", () => {
        slot.select();
      });
      slot.addEventListener("click", () => {
        slot.select();
      });
      slot.addEventListener("paste", (event) => {
        var _a6, _b;
        if (isDisabled() || slot.disabled) {
          return;
        }
        event.preventDefault();
        const pasted = (_b = (_a6 = event.clipboardData) == null ? void 0 : _a6.getData("text")) != null ? _b : "";
        const sanitized = sanitize(pasted);
        if (sanitized === "") {
          return;
        }
        const chars = Array.from(sanitized);
        const next = slotElements.map((item) => item.value.slice(0, 1));
        chars.forEach((char, offset) => {
          const targetIndex = index + offset;
          if (targetIndex < length) {
            next[targetIndex] = char;
          }
        });
        applyValue(next.join(""), {
          focusIndex: Math.min(index + chars.length, length - 1)
        });
      });
      slot.addEventListener("input", () => {
        if (isDisabled() || slot.disabled) {
          return;
        }
        const raw = slot.value;
        const sanitized = sanitize(raw);
        if (sanitized === "") {
          slot.value = "";
          syncFromSlots();
          return;
        }
        if (raw.length > 1) {
          const next = slotElements.map((item) => item.value.slice(0, 1));
          const chars = Array.from(sanitized);
          chars.forEach((char2, offset) => {
            const targetIndex = index + offset;
            if (targetIndex < length) {
              next[targetIndex] = char2;
            }
          });
          applyValue(next.join(""), {
            focusIndex: Math.min(index + chars.length, length - 1)
          });
          return;
        }
        const char = sanitized.charAt(sanitized.length - 1);
        slot.value = char;
        syncFromSlots();
        if (index < length - 1) {
          focusSlot(index + 1);
        }
      });
      slot.addEventListener("keydown", (event) => {
        if (isDisabled() || slot.disabled) {
          return;
        }
        switch (event.key) {
          case "Backspace":
            event.preventDefault();
            if (slot.value !== "") {
              slot.value = "";
              syncFromSlots();
              break;
            }
            if (index > 0) {
              const previous = slotElements[index - 1];
              if (previous) {
                previous.value = "";
                syncFromSlots();
                focusSlot(index - 1);
              }
            }
            break;
          case "Delete":
            event.preventDefault();
            slot.value = "";
            syncFromSlots();
            break;
          case "ArrowLeft":
            event.preventDefault();
            focusSlot(index - 1);
            break;
          case "ArrowRight":
            event.preventDefault();
            focusSlot(index + 1);
            break;
          case "Home":
            event.preventDefault();
            focusSlot(0);
            break;
          case "End":
            event.preventDefault();
            focusSlot(length - 1);
            break;
          default:
            break;
        }
      });
    });
    if (hiddenInput.value !== "") {
      applyValue(hiddenInput.value, { dispatch: false });
    } else {
      syncFromSlots({ dispatch: false });
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initInputOtps(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initInputOtps());
    } else {
      initInputOtps();
    }
  }

  // resources/assets/js/pillbox.js
  var PILLBOX_SELECTOR = "[data-pillbox]";
  var initialized17 = /* @__PURE__ */ new WeakSet();
  function initPillboxes(root = document) {
    root.querySelectorAll(PILLBOX_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized17.has(element)) {
        return;
      }
      initialized17.add(element);
      bindPillbox(element);
    });
  }
  function bindPillbox(root) {
    var _a5, _b;
    const list = root.querySelector("[data-pillbox-list]");
    const textInput = root.querySelector("[data-pillbox-input]");
    const hiddenContainer = root.querySelector("[data-pillbox-hidden-inputs]");
    const chipTemplate = root.querySelector("template[data-pillbox-chip-template]");
    const fieldName = (_a5 = root.getAttribute("data-pillbox-name")) != null ? _a5 : "";
    const maxAttr = root.getAttribute("data-pillbox-max");
    const max = maxAttr !== null && maxAttr !== "" ? Number.parseInt(maxAttr, 10) : null;
    const disabled = root.hasAttribute("data-disabled");
    let tags = [];
    try {
      const parsed = JSON.parse((_b = root.getAttribute("data-pillbox-value")) != null ? _b : "[]");
      if (Array.isArray(parsed)) {
        tags = parsed.map(String).filter((tag) => tag.trim() !== "");
      }
    } catch (e) {
      tags = [];
    }
    if (!(list instanceof HTMLElement) || !(textInput instanceof HTMLInputElement) || !(hiddenContainer instanceof HTMLElement) || !(chipTemplate instanceof HTMLTemplateElement) || fieldName === "") {
      return;
    }
    function dispatchChange(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function getTags() {
      return [...tags];
    }
    function setTags(values) {
      const unique = [];
      values.forEach((value) => {
        const trimmed = value.trim();
        if (trimmed === "" || unique.includes(trimmed)) {
          return;
        }
        unique.push(trimmed);
      });
      if (max !== null && unique.length > max) {
        unique.length = max;
      }
      tags = unique;
      render();
      dispatchChange(root);
    }
    function renderChips() {
      list.replaceChildren();
      tags.forEach((tag, index) => {
        const fragment = chipTemplate.content.cloneNode(true);
        const chip = fragment instanceof DocumentFragment ? fragment.querySelector("[data-pillbox-chip]") : null;
        if (!(chip instanceof HTMLElement)) {
          return;
        }
        const label = chip.querySelector("[data-pillbox-chip-label]");
        if (label instanceof HTMLElement) {
          label.textContent = tag;
        }
        const removeButton = chip.querySelector("[data-pillbox-chip-remove]");
        if (removeButton instanceof HTMLButtonElement) {
          removeButton.disabled = disabled;
          removeButton.addEventListener("click", (event) => {
            event.preventDefault();
            if (disabled) {
              return;
            }
            const next = getTags();
            next.splice(index, 1);
            setTags(next);
            textInput.focus();
          });
        }
        list.appendChild(fragment);
      });
    }
    function renderHiddenInputs() {
      hiddenContainer.replaceChildren();
      tags.forEach((tag) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = fieldName;
        input.value = tag;
        input.setAttribute("data-pillbox-hidden-input", "");
        hiddenContainer.appendChild(input);
      });
    }
    function render() {
      var _a6;
      renderChips();
      renderHiddenInputs();
      const atMax = max !== null && tags.length >= max;
      textInput.disabled = disabled || atMax;
      textInput.placeholder = atMax && max !== null ? "" : (_a6 = textInput.getAttribute("data-original-placeholder")) != null ? _a6 : textInput.placeholder;
    }
    function addFromInput(raw) {
      const parts = raw.split(",").map((part) => part.trim()).filter((part) => part !== "");
      if (parts.length === 0) {
        return;
      }
      setTags([...getTags(), ...parts]);
      textInput.value = "";
    }
    textInput.setAttribute("data-original-placeholder", textInput.placeholder);
    textInput.addEventListener("keydown", (event) => {
      if (disabled) {
        return;
      }
      if (event.key === "Enter" || event.key === ",") {
        event.preventDefault();
        if (textInput.value.trim() !== "") {
          addFromInput(textInput.value);
        }
        return;
      }
      if (event.key === "Backspace" && textInput.value === "" && tags.length > 0) {
        event.preventDefault();
        const next = getTags();
        next.pop();
        setTags(next);
      }
    });
    textInput.addEventListener("blur", () => {
      if (disabled) {
        return;
      }
      if (textInput.value.trim() !== "") {
        addFromInput(textInput.value);
      }
    });
    render();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initPillboxes(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initPillboxes());
    } else {
      initPillboxes();
    }
  }

  // resources/assets/js/popover.js
  var ROOT_SELECTOR3 = "[data-popover]";
  var TRIGGER_SELECTOR4 = "[data-popover-trigger]";
  var CONTENT_SELECTOR4 = "[data-popover-content]";
  var FOCUSABLE_SELECTOR = 'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
  var initialized18 = /* @__PURE__ */ new WeakSet();
  function initPopovers(root = document) {
    root.querySelectorAll(ROOT_SELECTOR3).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized18.has(element)) {
        return;
      }
      const triggerWrap = element.querySelector(TRIGGER_SELECTOR4);
      const content = element.querySelector(CONTENT_SELECTOR4);
      if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
        return;
      }
      initialized18.add(element);
      bindPopover(element);
    });
  }
  function bindPopover(root) {
    const triggerWrap = root.querySelector(TRIGGER_SELECTOR4);
    const content = root.querySelector(CONTENT_SELECTOR4);
    if (!(triggerWrap instanceof HTMLElement) || !(content instanceof HTMLElement)) {
      return;
    }
    const trigger = resolveTriggerControl2(triggerWrap);
    if (!(trigger instanceof HTMLElement)) {
      return;
    }
    const signal = createBindSignal(root);
    let open = content.dataset.state === "open" && !content.hidden;
    trigger.setAttribute("aria-haspopup", "dialog");
    trigger.setAttribute("aria-expanded", open ? "true" : "false");
    if (!content.id) {
      content.id = `popover-${Math.random().toString(36).slice(2, 10)}`;
    }
    trigger.setAttribute("aria-controls", content.id);
    const setOpen = (nextOpen, options = {}) => {
      if (open === nextOpen) {
        return;
      }
      open = nextOpen;
      content.dataset.state = open ? "open" : "closed";
      content.hidden = !open;
      content.classList.toggle("hidden", !open);
      trigger.setAttribute("aria-expanded", open ? "true" : "false");
      if (open) {
        positionContent2(content, trigger, root);
        focusFirstIn(content);
      } else if (options.restoreFocus !== false) {
        trigger.focus({ preventScroll: true });
      }
      root.dispatchEvent(
        new CustomEvent("stencil:popover:change", {
          bubbles: true,
          detail: { open }
        })
      );
    };
    trigger.addEventListener(
      "click",
      (event) => {
        event.preventDefault();
        setOpen(!open);
      },
      { signal }
    );
    trigger.addEventListener(
      "keydown",
      (event) => {
        if (event.key === "ArrowDown" || event.key === "Enter" || event.key === " ") {
          event.preventDefault();
          setOpen(true);
        }
      },
      { signal }
    );
    content.addEventListener(
      "click",
      (event) => {
        const closer = event.target instanceof Element ? event.target.closest("[data-popover-close]") : null;
        if (closer instanceof HTMLElement && content.contains(closer)) {
          setOpen(false);
        }
      },
      { signal }
    );
    document.addEventListener(
      "keydown",
      (event) => {
        if (!open) {
          return;
        }
        if (event.key === "Escape") {
          event.preventDefault();
          setOpen(false);
          return;
        }
        if (event.key === "Tab") {
          window.requestAnimationFrame(() => {
            if (!open) {
              return;
            }
            const active = document.activeElement;
            if (!(active instanceof Node) || !root.contains(active) && !content.contains(active)) {
              setOpen(false, { restoreFocus: false });
            }
          });
        }
      },
      { signal }
    );
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open) {
          return;
        }
        const target = event.target;
        if (!(target instanceof Node)) {
          return;
        }
        if (root.contains(target) || content.contains(target)) {
          return;
        }
        if (target instanceof Element && target.closest(
          "[data-select-portaled], [data-combobox-portaled], [data-color-picker-portaled], [data-dropdown-menu-portaled]"
        )) {
          return;
        }
        setOpen(false, { restoreFocus: false });
      },
      { signal }
    );
    if (open) {
      positionContent2(content, trigger, root);
    }
  }
  function resolveTriggerControl2(wrap) {
    if (wrap.matches('button, a[href], [role="button"]')) {
      return wrap;
    }
    const nested = wrap.querySelector('button, a[href], [role="button"]');
    return nested instanceof HTMLElement ? nested : wrap;
  }
  function focusFirstIn(content) {
    const first = content.querySelector(FOCUSABLE_SELECTOR);
    if (first instanceof HTMLElement) {
      first.focus({ preventScroll: true });
      return;
    }
    content.focus({ preventScroll: true });
  }
  function positionContent2(content, trigger, root) {
    const gap = 6;
    const padding = 8;
    const rect = trigger.getBoundingClientRect();
    const align = root.dataset.align || content.dataset.align || "start";
    const side = root.dataset.side || content.dataset.side || "bottom";
    content.style.position = "fixed";
    content.style.zIndex = "200";
    content.style.minWidth = `${Math.max(rect.width, 10)}px`;
    const wasHidden = content.hidden;
    content.hidden = false;
    content.style.visibility = "hidden";
    const height = content.offsetHeight;
    const width = content.offsetWidth;
    content.style.visibility = "";
    content.hidden = wasHidden;
    let top = side === "top" ? rect.top - gap - height : rect.bottom + gap;
    let left = rect.left;
    if (side === "left") {
      top = rect.top + rect.height / 2 - height / 2;
      left = rect.left - gap - width;
    } else if (side === "right") {
      top = rect.top + rect.height / 2 - height / 2;
      left = rect.right + gap;
    }
    if (align === "end" && (side === "top" || side === "bottom")) {
      left = rect.right - width;
    } else if (align === "center" && (side === "top" || side === "bottom")) {
      left = rect.left + rect.width / 2 - width / 2;
    }
    left = Math.min(Math.max(padding, left), window.innerWidth - width - padding);
    top = Math.min(Math.max(padding, top), window.innerHeight - height - padding);
    content.style.top = `${top}px`;
    content.style.left = `${left}px`;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initPopovers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initPopovers());
    } else {
      initPopovers();
    }
  }

  // resources/assets/js/rating.js
  var RATING_SELECTOR = "[data-rating]";
  var initialized19 = /* @__PURE__ */ new WeakSet();
  function initRatings(root = document) {
    root.querySelectorAll(RATING_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized19.has(element)) {
        return;
      }
      initialized19.add(element);
      bindRating(element);
    });
  }
  function bindRating(root) {
    var _a5;
    const hiddenInput = root.querySelector("[data-rating-hidden-input]");
    const stars = Array.from(root.querySelectorAll("[data-rating-star]")).filter(
      (node) => node instanceof HTMLButtonElement
    );
    const max = Number.parseInt((_a5 = root.getAttribute("data-rating-max")) != null ? _a5 : "5", 10);
    const disabled = root.hasAttribute("data-disabled");
    if (!(hiddenInput instanceof HTMLInputElement) || stars.length === 0) {
      return;
    }
    function dispatchChange(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function setValue(value, options = {}) {
      const clamped = Math.max(0, Math.min(max, value));
      hiddenInput.value = String(clamped);
      stars.forEach((star) => {
        var _a6;
        const starValue = Number.parseInt((_a6 = star.getAttribute("data-rating-value")) != null ? _a6 : "0", 10);
        const active = starValue <= clamped;
        const checked = starValue === clamped;
        star.classList.toggle("!text-amber-700", active);
        star.classList.toggle("dark:!text-amber-400", active);
        star.setAttribute("aria-checked", checked ? "true" : "false");
        const isTabStop = checked || clamped === 0 && starValue === 1;
        star.tabIndex = isTabStop ? 0 : -1;
        if (options.focus && isTabStop) {
          star.focus();
        }
      });
      dispatchChange(hiddenInput);
    }
    stars.forEach((star) => {
      star.addEventListener("click", (event) => {
        var _a6;
        event.preventDefault();
        if (disabled) {
          return;
        }
        const value = Number.parseInt((_a6 = star.getAttribute("data-rating-value")) != null ? _a6 : "0", 10);
        const current = Number.parseInt(hiddenInput.value || "0", 10);
        if (current === value) {
          setValue(0, { focus: true });
        } else {
          setValue(value, { focus: true });
        }
      });
      star.addEventListener("keydown", (event) => {
        var _a6;
        if (disabled) {
          return;
        }
        const current = Number.parseInt(hiddenInput.value || "0", 10);
        const starValue = Number.parseInt((_a6 = star.getAttribute("data-rating-value")) != null ? _a6 : "0", 10);
        switch (event.key) {
          case "ArrowRight":
          case "ArrowUp":
            event.preventDefault();
            setValue(Math.min(max, (current || starValue) + 1), { focus: true });
            break;
          case "ArrowLeft":
          case "ArrowDown":
            event.preventDefault();
            setValue(Math.max(1, (current || starValue) - 1), { focus: true });
            break;
          case "Home":
            event.preventDefault();
            setValue(1, { focus: true });
            break;
          case "End":
            event.preventDefault();
            setValue(max, { focus: true });
            break;
          case " ":
          case "Enter":
            event.preventDefault();
            if (current === starValue) {
              setValue(0, { focus: true });
            } else {
              setValue(starValue, { focus: true });
            }
            break;
          default:
            break;
        }
      });
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initRatings(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initRatings());
    } else {
      initRatings();
    }
  }

  // resources/assets/js/repeater.js
  var REPEATER_SELECTOR = "[data-repeater]";
  var initialized20 = /* @__PURE__ */ new WeakSet();
  function initRepeaters(root = document) {
    root.querySelectorAll(REPEATER_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized20.has(element)) {
        return;
      }
      initialized20.add(element);
      bindRepeater(element);
    });
  }
  function bindRepeater(root) {
    var _a5, _b, _c;
    const list = root.querySelector("[data-repeater-list]");
    const template = root.querySelector("template[data-repeater-item-template]");
    const fieldName = (_a5 = root.getAttribute("data-repeater-name")) != null ? _a5 : "";
    const min = Number.parseInt((_b = root.getAttribute("data-repeater-min")) != null ? _b : "0", 10);
    const maxAttr = root.getAttribute("data-repeater-max");
    const max = maxAttr !== null && maxAttr !== "" ? Number.parseInt(maxAttr, 10) : null;
    const disabled = root.hasAttribute("data-disabled");
    const sortable = root.hasAttribute("data-repeater-sortable");
    let seedValue = [];
    try {
      const parsed = JSON.parse((_c = root.getAttribute("data-repeater-value")) != null ? _c : "[]");
      if (Array.isArray(parsed)) {
        seedValue = parsed;
      }
    } catch (e) {
      seedValue = [];
    }
    if (!(list instanceof HTMLElement) || !(template instanceof HTMLTemplateElement) || fieldName === "") {
      return;
    }
    function dispatchMount(item) {
      item.dispatchEvent(
        new CustomEvent("stencil:mount", {
          bubbles: true,
          detail: { root: item }
        })
      );
    }
    function dispatchChange(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function resolveControls(fieldRoot) {
      if (fieldRoot instanceof HTMLInputElement || fieldRoot instanceof HTMLTextAreaElement || fieldRoot instanceof HTMLSelectElement) {
        return [fieldRoot];
      }
      const controls = Array.from(fieldRoot.querySelectorAll("input, textarea, select")).filter(
        (control) => {
          if (!(control instanceof HTMLElement)) {
            return false;
          }
          if (control.closest("[data-repeater-item]") !== fieldRoot.closest("[data-repeater-item]")) {
            return false;
          }
          return true;
        }
      );
      return controls.filter(
        (control) => control instanceof HTMLInputElement || control instanceof HTMLTextAreaElement || control instanceof HTMLSelectElement
      );
    }
    function readControlValue(control) {
      if (control instanceof HTMLInputElement) {
        const type = (control.type || "text").toLowerCase();
        if (type === "checkbox") {
          return control.checked;
        }
        if (type === "radio") {
          return control.checked ? control.value : void 0;
        }
        return control.value;
      }
      return control.value;
    }
    function fillControlValue(control, fieldValue) {
      if (control instanceof HTMLInputElement) {
        const type = (control.type || "text").toLowerCase();
        if (type === "checkbox") {
          if (Array.isArray(fieldValue)) {
            control.checked = fieldValue.map(String).includes(control.value);
          } else {
            control.checked = Boolean(fieldValue);
          }
          return;
        }
        if (type === "radio") {
          control.checked = String(control.value) === String(fieldValue);
          return;
        }
        control.value = fieldValue === null || fieldValue === void 0 ? "" : String(fieldValue);
        return;
      }
      control.value = fieldValue === null || fieldValue === void 0 ? "" : String(fieldValue);
    }
    function readRowData(item) {
      const row = {};
      item.querySelectorAll("[data-repeater-field]").forEach((fieldRoot) => {
        if (!(fieldRoot instanceof HTMLElement)) {
          return;
        }
        const fieldKey = fieldRoot.getAttribute("data-repeater-field");
        if (!fieldKey) {
          return;
        }
        const controls = resolveControls(fieldRoot);
        if (controls.length === 0) {
          return;
        }
        if (controls.length === 1) {
          const value = readControlValue(controls[0]);
          if (value !== void 0) {
            row[fieldKey] = value;
          }
          return;
        }
        const radio = controls.find(
          (control) => control instanceof HTMLInputElement && control.type === "radio" && control.checked
        );
        if (radio) {
          row[fieldKey] = radio.value;
          return;
        }
        const checkboxValues = controls.filter(
          (control) => control instanceof HTMLInputElement && control.type === "checkbox" && control.checked
        ).map((control) => control.value);
        if (checkboxValues.length > 0) {
          row[fieldKey] = checkboxValues;
        }
      });
      return row;
    }
    function applyRowData(item, rowData, index) {
      item.dataset.repeaterIndex = String(index);
      item.querySelectorAll("[data-repeater-field]").forEach((fieldRoot) => {
        if (!(fieldRoot instanceof HTMLElement)) {
          return;
        }
        const fieldKey = fieldRoot.getAttribute("data-repeater-field");
        if (!fieldKey) {
          return;
        }
        const controls = resolveControls(fieldRoot);
        const fieldValue = rowData[fieldKey];
        controls.forEach((control) => {
          control.name = `${fieldName}[${index}][${fieldKey}]`;
          if (fieldValue !== void 0) {
            fillControlValue(control, fieldValue);
          }
        });
      });
      dispatchMount(item);
    }
    function items() {
      return Array.from(list.querySelectorAll("[data-repeater-item]")).filter(
        (element) => element instanceof HTMLElement
      );
    }
    function reindex() {
      items().forEach((item, index) => {
        applyRowData(item, readRowData(item), index);
      });
      updateControls();
    }
    function createRow(rowData = {}) {
      const fragment = template.content.cloneNode(true);
      const item = fragment instanceof DocumentFragment ? fragment.querySelector("[data-repeater-item]") : null;
      if (!(item instanceof HTMLElement)) {
        return null;
      }
      list.appendChild(fragment);
      const appended = list.lastElementChild;
      if (!(appended instanceof HTMLElement)) {
        return null;
      }
      applyRowData(appended, rowData, items().length - 1);
      return appended;
    }
    function addRow(rowData = {}) {
      if (disabled) {
        return;
      }
      if (max !== null && items().length >= max) {
        return;
      }
      const item = createRow(rowData);
      reindex();
      const focusable = item == null ? void 0 : item.querySelector("input, textarea, select, button");
      if (focusable instanceof HTMLElement) {
        focusable.focus();
      }
      dispatchChange(root);
    }
    function removeRow(item) {
      if (disabled) {
        return;
      }
      if (items().length <= min) {
        return;
      }
      item.remove();
      reindex();
      dispatchChange(root);
    }
    function updateControls() {
      const count = items().length;
      const addButton = root.querySelector("[data-repeater-add]");
      if (addButton instanceof HTMLButtonElement) {
        addButton.disabled = disabled || max !== null && count >= max;
      }
      root.querySelectorAll("[data-repeater-remove]").forEach((button) => {
        if (button instanceof HTMLButtonElement) {
          button.disabled = disabled || count <= min;
        }
      });
      root.querySelectorAll("[data-repeater-duplicate]").forEach((button) => {
        if (button instanceof HTMLButtonElement) {
          button.disabled = disabled || max !== null && count >= max;
        }
      });
    }
    function hydrate() {
      list.replaceChildren();
      const rows = seedValue.length > 0 ? seedValue : min > 0 ? Array.from({ length: min }, () => ({})) : [];
      rows.forEach((row) => {
        createRow(row && typeof row === "object" ? row : {});
      });
      reindex();
      updateControls();
    }
    root.addEventListener("click", (event) => {
      if (disabled) {
        return;
      }
      const target = event.target instanceof Element ? event.target : null;
      if (!target) {
        return;
      }
      const addButton = target.closest("[data-repeater-add]");
      if (addButton && root.contains(addButton)) {
        event.preventDefault();
        addRow();
        return;
      }
      const removeButton = target.closest("[data-repeater-remove]");
      if (removeButton && root.contains(removeButton)) {
        event.preventDefault();
        const item = removeButton.closest("[data-repeater-item]");
        if (item instanceof HTMLElement) {
          removeRow(item);
        }
        return;
      }
      const duplicateButton = target.closest("[data-repeater-duplicate]");
      if (duplicateButton && root.contains(duplicateButton)) {
        event.preventDefault();
        const item = duplicateButton.closest("[data-repeater-item]");
        if (item instanceof HTMLElement) {
          addRow(readRowData(item));
        }
      }
    });
    if (sortable) {
      let draggedItem = null;
      list.addEventListener("dragover", (event) => {
        event.preventDefault();
      });
      list.addEventListener("drop", (event) => {
        event.preventDefault();
        if (!(draggedItem instanceof HTMLElement)) {
          return;
        }
        const target = event.target instanceof Element ? event.target.closest("[data-repeater-item]") : null;
        if (!(target instanceof HTMLElement) || target === draggedItem) {
          return;
        }
        const itemsBefore = items();
        const fromIndex = itemsBefore.indexOf(draggedItem);
        const toIndex = itemsBefore.indexOf(target);
        if (fromIndex < 0 || toIndex < 0) {
          return;
        }
        if (fromIndex < toIndex) {
          target.after(draggedItem);
        } else {
          target.before(draggedItem);
        }
        reindex();
        dispatchChange(root);
        draggedItem = null;
      });
      root.querySelectorAll("[data-repeater-handle]").forEach((handle) => {
        if (!(handle instanceof HTMLElement)) {
          return;
        }
        const item = handle.closest("[data-repeater-item]");
        if (!(item instanceof HTMLElement)) {
          return;
        }
        item.setAttribute("draggable", "true");
        handle.addEventListener("mousedown", () => {
          item.setAttribute("draggable", "true");
        });
        item.addEventListener("dragstart", (event) => {
          if (disabled) {
            event.preventDefault();
            return;
          }
          draggedItem = item;
          item.classList.add("opacity-60");
          if (event.dataTransfer) {
            event.dataTransfer.effectAllowed = "move";
          }
        });
        item.addEventListener("dragend", () => {
          item.classList.remove("opacity-60");
          draggedItem = null;
        });
      });
    }
    hydrate();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initRepeaters(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initRepeaters());
    } else {
      initRepeaters();
    }
  }

  // resources/assets/js/select.js
  var SELECT_SELECTOR = "[data-select]";
  var initialized21 = /* @__PURE__ */ new WeakSet();
  function initSelects(root = document) {
    document.querySelectorAll("[data-select-content][data-select-portaled]").forEach((content) => {
      if (!(content instanceof HTMLElement) || content.closest("[data-select]")) {
        return;
      }
      content.remove();
    });
    root.querySelectorAll(SELECT_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized21.has(element)) {
        return;
      }
      initialized21.add(element);
      bindSelect(element);
    });
  }
  function bindSelect(root) {
    var _a5, _b, _c, _d, _e;
    const isMultiple = root.hasAttribute("data-select-multiple");
    const displayMode = root.getAttribute("data-select-display") || "count";
    const trigger = root.querySelector("[data-select-trigger]");
    const content = root.querySelector("[data-select-content]");
    const valueEl = root.querySelector("[data-select-value]");
    const chipsEl = root.querySelector("[data-select-chips]");
    const chipTemplate = root.querySelector("template[data-select-chip-template]");
    const hiddenInputsContainer = root.querySelector("[data-select-hidden-inputs]");
    const singleHiddenInput = isMultiple ? null : root.querySelector("[data-select-hidden-input]");
    if (!(trigger instanceof HTMLButtonElement) || !(content instanceof HTMLElement)) {
      return;
    }
    if (isMultiple) {
      if (!(hiddenInputsContainer instanceof HTMLElement)) {
        return;
      }
      if (displayMode === "chips" && !(chipsEl instanceof HTMLElement)) {
        return;
      }
      if (displayMode === "count" && !(valueEl instanceof HTMLElement)) {
        return;
      }
    } else {
      if (!(singleHiddenInput instanceof HTMLInputElement) || !(valueEl instanceof HTMLElement)) {
        return;
      }
    }
    const portalMarker = document.createComment("stencil-select-portal");
    let portalInserted = false;
    const signal = createBindSignal(root);
    const options = () => Array.from(content.querySelectorAll("[data-select-item]")).filter(
      (node) => node instanceof HTMLElement
    );
    const enabledOptions = () => options().filter((el) => !el.hasAttribute("data-disabled"));
    let open = false;
    let activeIndex = -1;
    let typeahead = "";
    let typeaheadTimer = (
      /** @type {ReturnType<typeof setTimeout> | null} */
      null
    );
    const countTemplate = (_a5 = root.getAttribute("data-select-count-template")) != null ? _a5 : "{count} selected";
    const chipRemoveLabel = (_b = root.getAttribute("data-select-chip-remove-label")) != null ? _b : "Remove";
    const placeholderFromValueEl = valueEl instanceof HTMLElement && valueEl.getAttribute("data-placeholder") === "true" ? (_d = (_c = valueEl.textContent) == null ? void 0 : _c.trim()) != null ? _d : "" : "";
    const placeholderFromChips = chipsEl instanceof HTMLElement ? ((_e = chipsEl.getAttribute("data-placeholder")) != null ? _e : "").trim() : "";
    function getSelectedValues() {
      if (!isMultiple) {
        return singleHiddenInput instanceof HTMLInputElement && singleHiddenInput.value !== "" ? [singleHiddenInput.value] : [];
      }
      if (!(hiddenInputsContainer instanceof HTMLElement)) {
        return [];
      }
      return Array.from(hiddenInputsContainer.querySelectorAll("[data-select-hidden-input]")).filter((node) => node instanceof HTMLInputElement).map((input) => input.value).filter((value) => value !== "");
    }
    function setSelectedValues(values) {
      var _a6, _b2, _c2;
      const unique = [...new Set(values)];
      if (!isMultiple && singleHiddenInput instanceof HTMLInputElement) {
        singleHiddenInput.value = (_a6 = unique[0]) != null ? _a6 : "";
        syncOptionSelection((_b2 = unique[0]) != null ? _b2 : "");
        renderTrigger();
        dispatchValueEvents(singleHiddenInput);
        return;
      }
      if (!(hiddenInputsContainer instanceof HTMLElement)) {
        return;
      }
      const fieldName = (_c2 = hiddenInputsContainer.getAttribute("data-select-field-name")) != null ? _c2 : "";
      hiddenInputsContainer.querySelectorAll("[data-select-hidden-input]").forEach((node) => node.remove());
      unique.forEach((value) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.value = value;
        input.setAttribute("data-select-hidden-input", "");
        if (fieldName !== "") {
          input.name = fieldName;
        }
        hiddenInputsContainer.appendChild(input);
      });
      syncOptionSelectionMulti(unique);
      renderTrigger();
      const inputs = hiddenInputsContainer.querySelectorAll("[data-select-hidden-input]");
      inputs.forEach((input) => {
        if (input instanceof HTMLInputElement) {
          dispatchValueEvents(input);
        }
      });
    }
    function dispatchValueEvents(input) {
      input.dispatchEvent(new Event("input", { bubbles: true }));
      input.dispatchEvent(new Event("change", { bubbles: true }));
    }
    function syncOptionSelection(value) {
      options().forEach((item) => {
        item.setAttribute(
          "aria-selected",
          item.getAttribute("data-value") === value ? "true" : "false"
        );
      });
    }
    function syncOptionSelectionMulti(values) {
      const set = new Set(values);
      options().forEach((item) => {
        var _a6;
        const itemValue = (_a6 = item.getAttribute("data-value")) != null ? _a6 : "";
        item.setAttribute("aria-selected", set.has(itemValue) ? "true" : "false");
      });
    }
    function ensurePortal() {
      if (content.parentElement === document.body) {
        return;
      }
      const parent = content.parentElement;
      if (parent && !portalInserted) {
        parent.insertBefore(portalMarker, content);
        portalInserted = true;
      }
      document.body.appendChild(content);
      content.dataset.selectPortaled = "true";
    }
    function positionContent3() {
      ensurePortal();
      const rect = trigger.getBoundingClientRect();
      const gap = 6;
      const viewportPadding = 8;
      content.style.position = "fixed";
      content.style.left = `${Math.max(viewportPadding, rect.left)}px`;
      content.style.width = `${rect.width}px`;
      content.style.minWidth = `${rect.width}px`;
      content.style.zIndex = "200";
      const wasHidden = content.hidden;
      content.hidden = false;
      content.style.visibility = "hidden";
      content.style.pointerEvents = "none";
      const panelHeight = content.offsetHeight;
      content.style.visibility = "";
      content.style.pointerEvents = "";
      content.hidden = wasHidden;
      let top = rect.bottom + gap;
      const maxBottom = window.innerHeight - viewportPadding;
      if (top + panelHeight > maxBottom) {
        const topAbove = rect.top - gap - panelHeight;
        if (topAbove >= viewportPadding) {
          top = topAbove;
        } else {
          content.style.maxHeight = `${maxBottom - top}px`;
        }
      } else {
        content.style.maxHeight = "";
      }
      content.style.top = `${top}px`;
    }
    function setOpen(next) {
      open = next;
      root.dataset.state = next ? "open" : "closed";
      trigger.setAttribute("aria-expanded", next ? "true" : "false");
      content.hidden = !next;
      if (next) {
        positionContent3();
        const list = enabledOptions();
        const selected = getSelectedValues();
        let index = 0;
        if (selected.length > 0) {
          const found = list.findIndex(
            (el) => {
              var _a6;
              return selected.includes((_a6 = el.getAttribute("data-value")) != null ? _a6 : "");
            }
          );
          index = found >= 0 ? found : 0;
        }
        activeIndex = index;
        highlightActive();
        content.focus();
      } else {
        clearHighlights();
        activeIndex = -1;
        trigger.focus();
      }
    }
    function clearHighlights() {
      options().forEach((el) => {
        el.removeAttribute("data-highlighted");
      });
    }
    function highlightActive() {
      clearHighlights();
      const list = enabledOptions();
      const el = list[activeIndex];
      if (el) {
        el.setAttribute("data-highlighted", "true");
        el.scrollIntoView({ block: "nearest" });
      }
    }
    function optionLabel(el) {
      var _a6, _b2, _c2, _d2;
      const label = el.querySelector("[data-select-item-label]");
      if (label instanceof HTMLElement) {
        return (_b2 = (_a6 = label.textContent) == null ? void 0 : _a6.trim()) != null ? _b2 : "";
      }
      return (_d2 = (_c2 = el.textContent) == null ? void 0 : _c2.trim()) != null ? _d2 : "";
    }
    function selectOption(el) {
      var _a6;
      if (el.hasAttribute("data-disabled")) {
        return;
      }
      const value = (_a6 = el.getAttribute("data-value")) != null ? _a6 : "";
      const label = optionLabel(el);
      if (singleHiddenInput instanceof HTMLInputElement && valueEl instanceof HTMLElement) {
        singleHiddenInput.value = value;
        valueEl.textContent = label;
        valueEl.removeAttribute("data-placeholder");
        syncOptionSelection(value);
        dispatchValueEvents(singleHiddenInput);
        setOpen(false);
      }
    }
    function toggleOption(el) {
      var _a6;
      if (el.hasAttribute("data-disabled")) {
        return;
      }
      const value = (_a6 = el.getAttribute("data-value")) != null ? _a6 : "";
      const current = getSelectedValues();
      const next = current.includes(value) ? current.filter((item) => item !== value) : [...current, value];
      setSelectedValues(next);
    }
    function removeValue(value) {
      setSelectedValues(getSelectedValues().filter((item) => item !== value));
    }
    function renderTrigger() {
      const selected = getSelectedValues();
      if (!isMultiple) {
        return;
      }
      if (displayMode === "count" && valueEl instanceof HTMLElement) {
        if (selected.length === 0) {
          const placeholder = placeholderFromValueEl || placeholderFromChips;
          if (placeholder !== "") {
            valueEl.textContent = placeholder;
            valueEl.setAttribute("data-placeholder", "true");
          } else {
            valueEl.textContent = "";
            valueEl.removeAttribute("data-placeholder");
          }
          return;
        }
        valueEl.textContent = countTemplate.replace("{count}", String(selected.length));
        valueEl.removeAttribute("data-placeholder");
        return;
      }
      if (displayMode === "chips" && chipsEl instanceof HTMLElement) {
        chipsEl.querySelectorAll("[data-select-chip]").forEach((chip) => chip.remove());
        if (selected.length === 0 && placeholderFromChips !== "") {
          const empty = document.createElement("span");
          empty.className = "text-sm text-zinc-500 dark:text-zinc-400";
          empty.setAttribute("data-select-chips-placeholder", "true");
          empty.textContent = placeholderFromChips;
          chipsEl.appendChild(empty);
          return;
        }
        chipsEl.querySelectorAll("[data-select-chips-placeholder]").forEach((node) => node.remove());
        selected.forEach((value) => {
          const match = options().find((el) => el.getAttribute("data-value") === value);
          const label = match ? optionLabel(match) : value;
          const chip = createChipElement(value, label);
          if (chip) {
            chipsEl.appendChild(chip);
          }
        });
      }
    }
    function createChipElement(value, label) {
      if (!(chipTemplate instanceof HTMLTemplateElement)) {
        return null;
      }
      const fragment = chipTemplate.content.cloneNode(true);
      const chip = fragment.querySelector("[data-select-chip]");
      if (!(chip instanceof HTMLElement)) {
        return null;
      }
      chip.setAttribute("data-value", value);
      const labelEl = chip.querySelector("[data-select-chip-label]");
      if (labelEl instanceof HTMLElement) {
        labelEl.textContent = label;
      }
      const remove = chip.querySelector("[data-select-chip-remove]");
      if (remove instanceof HTMLButtonElement) {
        remove.setAttribute("aria-label", `${chipRemoveLabel} ${label}`);
      }
      return chip;
    }
    function syncFromValue() {
      if (!isMultiple && singleHiddenInput instanceof HTMLInputElement && valueEl instanceof HTMLElement) {
        const value = singleHiddenInput.value;
        if (value === "") {
          if (placeholderFromValueEl !== "") {
            valueEl.textContent = placeholderFromValueEl;
            valueEl.setAttribute("data-placeholder", "true");
          }
          options().forEach((item) => item.setAttribute("aria-selected", "false"));
          return;
        }
        const match = options().find((el) => el.getAttribute("data-value") === value);
        if (match) {
          valueEl.textContent = optionLabel(match);
          valueEl.removeAttribute("data-placeholder");
          syncOptionSelection(value);
        }
        return;
      }
      if (isMultiple) {
        syncOptionSelectionMulti(getSelectedValues());
        renderTrigger();
      }
    }
    function containsTarget(target) {
      return target instanceof Node && (root.contains(target) || content.contains(target));
    }
    function activateOption(el) {
      if (isMultiple) {
        toggleOption(el);
      } else {
        selectOption(el);
      }
    }
    trigger.addEventListener("click", () => {
      if (trigger.disabled) {
        return;
      }
      setOpen(!open);
    });
    if (chipsEl instanceof HTMLElement) {
      chipsEl.addEventListener("click", (event) => {
        var _a6;
        const remove = event.target instanceof Element ? event.target.closest("[data-select-chip-remove]") : null;
        if (!(remove instanceof HTMLElement)) {
          return;
        }
        event.preventDefault();
        event.stopPropagation();
        const chip = remove.closest("[data-select-chip]");
        if (chip instanceof HTMLElement) {
          const value = (_a6 = chip.getAttribute("data-value")) != null ? _a6 : "";
          if (value !== "") {
            removeValue(value);
          }
        }
      });
    }
    content.addEventListener("click", (event) => {
      const item = event.target instanceof Element ? event.target.closest("[data-select-item]") : null;
      if (item instanceof HTMLElement) {
        activateOption(item);
      }
    });
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open) {
          return;
        }
        if (!containsTarget(event.target)) {
          setOpen(false);
        }
      },
      { signal }
    );
    window.addEventListener(
      "resize",
      () => {
        if (open) {
          positionContent3();
        }
      },
      { signal }
    );
    window.addEventListener(
      "scroll",
      () => {
        if (open) {
          positionContent3();
        }
      },
      { capture: true, signal }
    );
    trigger.addEventListener("keydown", (event) => {
      if (trigger.disabled) {
        return;
      }
      const list = enabledOptions();
      switch (event.key) {
        case "ArrowDown":
        case "ArrowUp":
        case "Enter":
        case " ":
          event.preventDefault();
          if (!open) {
            setOpen(true);
          } else if (event.key === "Enter" || event.key === " ") {
            const el = list[activeIndex];
            if (el) {
              activateOption(el);
            }
          }
          break;
        case "Escape":
          if (open) {
            event.preventDefault();
            setOpen(false);
          }
          break;
        default:
          break;
      }
    });
    content.addEventListener("keydown", (event) => {
      const list = enabledOptions();
      if (list.length === 0) {
        return;
      }
      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          activeIndex = Math.min(activeIndex + 1, list.length - 1);
          highlightActive();
          break;
        case "ArrowUp":
          event.preventDefault();
          activeIndex = Math.max(activeIndex - 1, 0);
          highlightActive();
          break;
        case "Home":
          event.preventDefault();
          activeIndex = 0;
          highlightActive();
          break;
        case "End":
          event.preventDefault();
          activeIndex = list.length - 1;
          highlightActive();
          break;
        case "Enter":
        case " ":
          event.preventDefault();
          {
            const el = list[activeIndex];
            if (el) {
              activateOption(el);
            }
          }
          break;
        case "Escape":
          event.preventDefault();
          setOpen(false);
          break;
        case "Tab":
          setOpen(false);
          break;
        default:
          if (event.key.length === 1 && !event.ctrlKey && !event.metaKey && !event.altKey) {
            typeahead += event.key.toLowerCase();
            if (typeaheadTimer) {
              clearTimeout(typeaheadTimer);
            }
            typeaheadTimer = setTimeout(() => {
              typeahead = "";
            }, 500);
            const index = list.findIndex(
              (el) => optionLabel(el).toLowerCase().startsWith(typeahead)
            );
            if (index >= 0) {
              activeIndex = index;
              highlightActive();
            }
          }
          break;
      }
    });
    root.dataset.state = "closed";
    syncFromValue();
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initSelects(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initSelects());
    } else {
      initSelects();
    }
  }

  // resources/assets/js/sidebar.js
  var PROVIDER_SELECTOR = "[data-sidebar-provider]";
  var TRIGGER_SELECTOR5 = "[data-sidebar-trigger]";
  var RAIL_SELECTOR = "[data-sidebar-rail]";
  var BACKDROP_SELECTOR = "[data-sidebar-backdrop]";
  var ROOT_SELECTOR4 = "[data-sidebar-root]";
  var MOBILE_QUERY = "(max-width: 767px)";
  var KEYBOARD_SHORTCUT = "b";
  var initialized22 = /* @__PURE__ */ new WeakSet();
  function initSidebars(root = document) {
    root.querySelectorAll(PROVIDER_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized22.has(element)) {
        return;
      }
      initialized22.add(element);
      bindSidebarProvider(element);
    });
  }
  function bindSidebarProvider(provider) {
    const storageKey = provider.dataset.storageKey || "stencil-sidebar-state";
    const defaultOpen = provider.dataset.defaultOpen !== "false";
    const media = window.matchMedia(MOBILE_QUERY);
    const signal = createBindSignal(provider);
    let open = readStoredOpen(storageKey, defaultOpen);
    let openMobile = false;
    let isMobile = media.matches;
    const sync = () => {
      isMobile = media.matches;
      provider.dataset.mobile = isMobile ? "true" : "false";
      provider.dataset.mobileOpen = openMobile ? "true" : "false";
      provider.dataset.state = open ? "expanded" : "collapsed";
      provider.dataset.open = open ? "true" : "false";
      const sidebarRoot = provider.querySelector(ROOT_SELECTOR4);
      if (sidebarRoot instanceof HTMLElement) {
        const mode = sidebarRoot.dataset.collapsibleMode || "offcanvas";
        sidebarRoot.dataset.state = open ? "expanded" : "collapsed";
        sidebarRoot.dataset.collapsible = open || mode === "none" ? "" : mode;
        sidebarRoot.dataset.mobile = isMobile ? "true" : "false";
        sidebarRoot.dataset.mobileOpen = openMobile ? "true" : "false";
      }
      const expandedForControls = isMobile ? openMobile : open;
      provider.querySelectorAll(`${TRIGGER_SELECTOR5}, ${RAIL_SELECTOR}`).forEach((node) => {
        if (!(node instanceof HTMLElement)) {
          return;
        }
        const control = resolveControl2(node);
        control.setAttribute("aria-expanded", expandedForControls ? "true" : "false");
      });
      document.documentElement.classList.toggle(
        "stencil-sidebar-mobile-open",
        isMobile && openMobile
      );
    };
    const setOpen = (next) => {
      open = next;
      writeStoredOpen(storageKey, open);
      sync();
      provider.dispatchEvent(
        new CustomEvent("stencil:sidebar:change", {
          bubbles: true,
          detail: { open, openMobile, isMobile }
        })
      );
    };
    const setOpenMobile = (next) => {
      openMobile = next;
      sync();
      provider.dispatchEvent(
        new CustomEvent("stencil:sidebar:change", {
          bubbles: true,
          detail: { open, openMobile, isMobile }
        })
      );
    };
    const toggle2 = () => {
      if (isMobile) {
        setOpenMobile(!openMobile);
      } else {
        setOpen(!open);
      }
    };
    provider.addEventListener(
      "click",
      (event) => {
        const target = event.target;
        if (!(target instanceof Element)) {
          return;
        }
        const control = target.closest(
          `${TRIGGER_SELECTOR5}, ${RAIL_SELECTOR}, ${BACKDROP_SELECTOR}`
        );
        if (!(control instanceof HTMLElement) || !provider.contains(control)) {
          return;
        }
        if (control.matches(BACKDROP_SELECTOR)) {
          event.preventDefault();
          setOpenMobile(false);
          return;
        }
        event.preventDefault();
        toggle2();
      },
      { signal }
    );
    const onKeydown = (event) => {
      var _a5;
      if (event.key === "Escape" && isMobile && openMobile) {
        event.preventDefault();
        setOpenMobile(false);
        return;
      }
      if (event.key.toLowerCase() === KEYBOARD_SHORTCUT && (event.metaKey || event.ctrlKey) && !event.altKey && !event.shiftKey) {
        const tag = event.target instanceof HTMLElement ? event.target.tagName : "";
        if (tag === "INPUT" || tag === "TEXTAREA" || tag === "SELECT" || ((_a5 = event.target) == null ? void 0 : _a5.isContentEditable)) {
          return;
        }
        event.preventDefault();
        toggle2();
      }
    };
    document.addEventListener("keydown", onKeydown, { signal });
    const onMediaChange = () => {
      if (!media.matches) {
        openMobile = false;
      }
      sync();
    };
    if (typeof media.addEventListener === "function") {
      media.addEventListener("change", onMediaChange, { signal });
    } else {
      media.addListener(onMediaChange);
      signal.addEventListener("abort", () => media.removeListener(onMediaChange), { once: true });
    }
    sync();
  }
  function resolveControl2(node) {
    if (node.matches('button, a[href], [role="button"]')) {
      return node;
    }
    const nested = node.querySelector('button, a[href], [role="button"]');
    return nested instanceof HTMLElement ? nested : node;
  }
  function readStoredOpen(key, fallback) {
    try {
      const raw = window.localStorage.getItem(key);
      if (raw === null) {
        return fallback;
      }
      return raw === "1" || raw === "true";
    } catch (e) {
      return fallback;
    }
  }
  function writeStoredOpen(key, open) {
    try {
      window.localStorage.setItem(key, open ? "1" : "0");
    } catch (e) {
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initSidebars(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initSidebars());
    } else {
      initSidebars();
    }
  }

  // resources/assets/js/slider.js
  var SLIDER_SELECTOR = "[data-slider]";
  var initialized23 = /* @__PURE__ */ new WeakSet();
  function initSliders(root = document) {
    root.querySelectorAll(SLIDER_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized23.has(element)) {
        return;
      }
      initialized23.add(element);
      bindSlider(element);
    });
  }
  function bindSlider(root) {
    function hiddenInputs() {
      return Array.from(root.querySelectorAll("[data-slider-hidden-input]")).filter((node) => node instanceof HTMLInputElement).sort((a, b) => {
        var _a5, _b;
        const ai = Number.parseInt((_a5 = a.dataset.index) != null ? _a5 : "", 10);
        const bi = Number.parseInt((_b = b.dataset.index) != null ? _b : "", 10);
        return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
      });
    }
    function thumbs() {
      return Array.from(root.querySelectorAll("[data-slider-thumb]")).filter((node) => node instanceof HTMLElement).sort((a, b) => {
        var _a5, _b;
        const ai = Number.parseInt((_a5 = a.dataset.index) != null ? _a5 : "", 10);
        const bi = Number.parseInt((_b = b.dataset.index) != null ? _b : "", 10);
        return (Number.isFinite(ai) ? ai : 0) - (Number.isFinite(bi) ? bi : 0);
      });
    }
    const track = root.querySelector("[data-slider-track]");
    const rangeEl = root.querySelector("[data-slider-range]");
    if (!(track instanceof HTMLElement)) {
      return;
    }
    const min = parseNumber(root.getAttribute("data-slider-min"), 0);
    const max = parseNumber(root.getAttribute("data-slider-max"), 100);
    const step = Math.max(parseNumber(root.getAttribute("data-slider-step"), 1), Number.EPSILON);
    const isRange = root.getAttribute("data-slider-range") === "true";
    function isDisabled() {
      return root.hasAttribute("data-disabled");
    }
    function readValues() {
      var _a5, _b, _c;
      const inputs = hiddenInputs();
      const thumbEls = thumbs();
      const count = isRange ? 2 : 1;
      const values = [];
      for (let index = 0; index < count; index += 1) {
        const fromInput = (_a5 = inputs[index]) == null ? void 0 : _a5.value;
        const fromThumb = (_b = thumbEls[index]) == null ? void 0 : _b.getAttribute("aria-valuenow");
        const raw = (_c = fromInput != null ? fromInput : fromThumb) != null ? _c : String(index === 0 ? min : max);
        values.push(snap(parseNumber(raw, index === 0 ? min : max)));
      }
      if (isRange && values.length === 2 && values[0] > values[1]) {
        return [values[1], values[0]];
      }
      return values;
    }
    function snap(value) {
      const clamped = Math.min(max, Math.max(min, value));
      const steps = Math.round((clamped - min) / step);
      return clamp(min + steps * step);
    }
    function clamp(value) {
      return Math.min(max, Math.max(min, value));
    }
    function format(value) {
      if (Number.isInteger(step) && Number.isInteger(value)) {
        return String(value);
      }
      const precision = stepPrecision(step);
      const fixed = value.toFixed(precision);
      return fixed.replace(/\.?0+$/, "");
    }
    function valueFromPointer(clientX) {
      const rect = track.getBoundingClientRect();
      if (rect.width <= 0) {
        return min;
      }
      const ratio = Math.min(1, Math.max(0, (clientX - rect.left) / rect.width));
      return snap(min + ratio * (max - min));
    }
    function applyValues(values, options = {}) {
      var _a5, _b, _c;
      const next = isRange ? [snap((_a5 = values[0]) != null ? _a5 : min), snap((_b = values[1]) != null ? _b : max)] : [snap((_c = values[0]) != null ? _c : min)];
      if (isRange && next[0] > next[1]) {
        if (activeIndex === 0) {
          next[0] = next[1];
        } else {
          next[1] = next[0];
        }
      }
      const inputs = hiddenInputs();
      const thumbEls = thumbs();
      const span = max - min;
      next.forEach((value, index) => {
        const formatted = format(value);
        const percent = span > 0 ? (value - min) / span * 100 : 0;
        const input = inputs[index];
        const thumb = thumbEls[index];
        if (input instanceof HTMLInputElement && input.value !== formatted) {
          input.value = formatted;
          if (options.dispatch !== false) {
            dispatchValueEvents(input);
          }
        } else if (input instanceof HTMLInputElement) {
          input.value = formatted;
        }
        if (thumb instanceof HTMLElement) {
          thumb.style.left = `${percent}%`;
          thumb.setAttribute("aria-valuenow", formatted);
          thumb.setAttribute("aria-valuetext", formatted);
          thumb.setAttribute("aria-valuemin", format(min));
          thumb.setAttribute("aria-valuemax", format(max));
        }
      });
      if (rangeEl instanceof HTMLElement) {
        if (isRange) {
          const start = span > 0 ? (next[0] - min) / span * 100 : 0;
          const end = span > 0 ? (next[1] - min) / span * 100 : 100;
          rangeEl.style.left = `${start}%`;
          rangeEl.style.width = `${Math.max(0, end - start)}%`;
        } else {
          const end = span > 0 ? (next[0] - min) / span * 100 : 0;
          rangeEl.style.left = "0%";
          rangeEl.style.width = `${Math.max(0, end)}%`;
        }
      }
    }
    function dispatchValueEvents(target) {
      target.dispatchEvent(new Event("input", { bubbles: true }));
      target.dispatchEvent(new Event("change", { bubbles: true }));
    }
    let activeIndex = null;
    let pointerId = null;
    function setFromPointer(clientX, preferredIndex = null) {
      const nextValue = valueFromPointer(clientX);
      const current = readValues();
      if (!isRange) {
        applyValues([nextValue]);
        return;
      }
      let index = preferredIndex;
      if (index === null) {
        const distanceToLow = Math.abs(nextValue - current[0]);
        const distanceToHigh = Math.abs(nextValue - current[1]);
        index = distanceToLow <= distanceToHigh ? 0 : 1;
      }
      activeIndex = index;
      const next = [...current];
      next[index] = nextValue;
      applyValues(next);
    }
    function nudge(index, deltaSteps) {
      var _a5;
      const current = readValues();
      const next = [...current];
      next[index] = snap(((_a5 = current[index]) != null ? _a5 : min) + deltaSteps * step);
      activeIndex = index;
      applyValues(next);
    }
    function onPointerDown(event) {
      var _a5, _b, _c;
      if (isDisabled() || event.button !== 0) {
        return;
      }
      const target = event.target instanceof Element ? event.target : null;
      const thumb = target == null ? void 0 : target.closest("[data-slider-thumb]");
      const preferredIndex = thumb instanceof HTMLElement ? Number.parseInt((_a5 = thumb.dataset.index) != null ? _a5 : "0", 10) : null;
      (_b = root.setPointerCapture) == null ? void 0 : _b.call(root, event.pointerId);
      pointerId = event.pointerId;
      setFromPointer(event.clientX, Number.isFinite(preferredIndex) ? preferredIndex : null);
      const thumbEls = thumbs();
      const focusIndex = activeIndex != null ? activeIndex : 0;
      (_c = thumbEls[focusIndex]) == null ? void 0 : _c.focus();
      event.preventDefault();
    }
    function onPointerMove(event) {
      if (pointerId === null || event.pointerId !== pointerId || isDisabled()) {
        return;
      }
      setFromPointer(event.clientX, activeIndex);
      event.preventDefault();
    }
    function onPointerUp(event) {
      var _a5;
      if (pointerId === null || event.pointerId !== pointerId) {
        return;
      }
      pointerId = null;
      activeIndex = null;
      if ((_a5 = root.hasPointerCapture) == null ? void 0 : _a5.call(root, event.pointerId)) {
        root.releasePointerCapture(event.pointerId);
      }
    }
    root.addEventListener("pointerdown", onPointerDown);
    root.addEventListener("pointermove", onPointerMove);
    root.addEventListener("pointerup", onPointerUp);
    root.addEventListener("pointercancel", onPointerUp);
    thumbs().forEach((thumb, index) => {
      thumb.addEventListener("keydown", (event) => {
        if (isDisabled() || thumb.getAttribute("aria-disabled") === "true") {
          return;
        }
        const largeStep = Math.max(step, (max - min) / 10);
        switch (event.key) {
          case "ArrowLeft":
          case "ArrowDown":
            event.preventDefault();
            nudge(index, -1);
            break;
          case "ArrowRight":
          case "ArrowUp":
            event.preventDefault();
            nudge(index, 1);
            break;
          case "PageDown":
            event.preventDefault();
            nudge(index, -Math.max(1, Math.round(largeStep / step)));
            break;
          case "PageUp":
            event.preventDefault();
            nudge(index, Math.max(1, Math.round(largeStep / step)));
            break;
          case "Home":
            event.preventDefault();
            activeIndex = index;
            {
              const current = readValues();
              const next = [...current];
              next[index] = min;
              applyValues(next);
            }
            break;
          case "End":
            event.preventDefault();
            activeIndex = index;
            {
              const current = readValues();
              const next = [...current];
              next[index] = max;
              applyValues(next);
            }
            break;
          default:
            break;
        }
      });
    });
    applyValues(readValues(), { dispatch: false });
  }
  function parseNumber(value, fallback) {
    const parsed = Number.parseFloat(value != null ? value : "");
    return Number.isFinite(parsed) ? parsed : fallback;
  }
  function stepPrecision(step) {
    var _a5, _b;
    const text = String(step);
    if (!text.includes(".")) {
      return 0;
    }
    return (_b = (_a5 = text.split(".")[1]) == null ? void 0 : _a5.length) != null ? _b : 0;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initSliders(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initSliders());
    } else {
      initSliders();
    }
  }

  // resources/assets/js/stepper.js
  var STEPPER_SELECTOR = "[data-stepper]";
  var ITEM_SELECTOR3 = "[data-stepper-item]";
  var TRIGGER_SELECTOR6 = "[data-stepper-trigger]";
  var CONTENT_SELECTOR5 = "[data-stepper-content]";
  var PREVIOUS_SELECTOR = "[data-stepper-previous]";
  var NEXT_SELECTOR = "[data-stepper-next]";
  var initialized24 = /* @__PURE__ */ new WeakSet();
  function initSteppers(root = document) {
    root.querySelectorAll(STEPPER_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized24.has(element)) {
        return;
      }
      initialized24.add(element);
      bindStepper(element);
    });
  }
  function bindStepper(root) {
    var _a5, _b;
    const linear = root.dataset.linear !== "false";
    const items = () => Array.from(root.querySelectorAll(ITEM_SELECTOR3)).filter(
      (node) => node instanceof HTMLElement && node.dataset.disabled !== "true"
    );
    const contents = () => Array.from(root.querySelectorAll(CONTENT_SELECTOR5)).filter(
      (node) => node instanceof HTMLElement
    );
    const triggers = () => Array.from(root.querySelectorAll(TRIGGER_SELECTOR6)).filter(
      (node) => node instanceof HTMLButtonElement && !node.disabled
    );
    const activate = (value) => {
      const enabledItems = items();
      const index = enabledItems.findIndex((item) => item.dataset.value === value);
      if (index < 0) {
        return;
      }
      root.dataset.active = value;
      enabledItems.forEach((item, itemIndex) => {
        let state = "inactive";
        if (itemIndex < index) {
          state = "completed";
        } else if (itemIndex === index) {
          state = "active";
        }
        item.dataset.state = state;
        item.setAttribute("aria-current", state === "active" ? "step" : "false");
        if (item.getAttribute("aria-current") === "false") {
          item.removeAttribute("aria-current");
        }
        const trigger = item.querySelector(TRIGGER_SELECTOR6);
        if (trigger instanceof HTMLButtonElement) {
          trigger.tabIndex = state === "active" ? 0 : -1;
          trigger.setAttribute("aria-current", state === "active" ? "step" : "false");
          if (trigger.getAttribute("aria-current") === "false") {
            trigger.removeAttribute("aria-current");
          }
        }
      });
      root.querySelectorAll(ITEM_SELECTOR3).forEach((item) => {
        if (!(item instanceof HTMLElement) || item.dataset.disabled !== "true") {
          return;
        }
        if (item.dataset.state === "active") {
          item.dataset.state = "inactive";
        }
      });
      contents().forEach((panel) => {
        const selected = panel.dataset.value === value;
        panel.dataset.state = selected ? "active" : "inactive";
        panel.hidden = !selected;
        panel.classList.toggle("hidden", !selected);
      });
      const previous = root.querySelector(PREVIOUS_SELECTOR);
      const next = root.querySelector(NEXT_SELECTOR);
      if (previous instanceof HTMLButtonElement) {
        previous.disabled = index <= 0;
        previous.toggleAttribute("disabled", index <= 0);
        previous.setAttribute("aria-disabled", index <= 0 ? "true" : "false");
      }
      if (next instanceof HTMLButtonElement) {
        const atEnd = index >= enabledItems.length - 1;
        next.disabled = atEnd;
        next.toggleAttribute("disabled", atEnd);
        next.setAttribute("aria-disabled", atEnd ? "true" : "false");
      }
      root.dispatchEvent(
        new CustomEvent("stencil:stepper:change", {
          bubbles: true,
          detail: { value, index }
        })
      );
    };
    const move = (delta) => {
      var _a6, _b2;
      const enabledItems = items();
      const currentValue = root.dataset.active;
      const currentIndex = enabledItems.findIndex((item) => item.dataset.value === currentValue);
      const nextIndex = currentIndex + delta;
      if (nextIndex < 0 || nextIndex >= enabledItems.length) {
        return;
      }
      const nextValue = (_a6 = enabledItems[nextIndex]) == null ? void 0 : _a6.dataset.value;
      if (typeof nextValue === "string") {
        activate(nextValue);
        const trigger = (_b2 = enabledItems[nextIndex]) == null ? void 0 : _b2.querySelector(TRIGGER_SELECTOR6);
        if (trigger instanceof HTMLButtonElement) {
          trigger.focus();
        }
      }
    };
    const initial = root.dataset.active || ((_a5 = items().find((item) => item.dataset.state === "active")) == null ? void 0 : _a5.dataset.value) || ((_b = items()[0]) == null ? void 0 : _b.dataset.value);
    if (typeof initial === "string" && initial !== "") {
      activate(initial);
    }
    root.addEventListener("click", (event) => {
      const target = event.target instanceof Element ? event.target : null;
      if (!target) {
        return;
      }
      const previous = target.closest(PREVIOUS_SELECTOR);
      if (previous instanceof HTMLElement && root.contains(previous)) {
        event.preventDefault();
        move(-1);
        return;
      }
      const next = target.closest(NEXT_SELECTOR);
      if (next instanceof HTMLElement && root.contains(next)) {
        event.preventDefault();
        move(1);
        return;
      }
      const trigger = target.closest(TRIGGER_SELECTOR6) instanceof HTMLButtonElement ? target.closest(TRIGGER_SELECTOR6) : null;
      if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger) || trigger.disabled) {
        return;
      }
      const value = trigger.dataset.value;
      if (typeof value !== "string") {
        return;
      }
      const enabledItems = items();
      const targetIndex = enabledItems.findIndex((item) => item.dataset.value === value);
      const currentIndex = enabledItems.findIndex(
        (item) => item.dataset.value === root.dataset.active
      );
      if (linear && targetIndex > currentIndex + 1) {
        return;
      }
      activate(value);
    });
    root.addEventListener("keydown", (event) => {
      const trigger = event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR6) : null;
      if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger)) {
        return;
      }
      const enabled = triggers();
      const index = enabled.indexOf(trigger);
      const orientation = root.dataset.orientation || "horizontal";
      const nextKey = orientation === "vertical" ? "ArrowDown" : "ArrowRight";
      const prevKey = orientation === "vertical" ? "ArrowUp" : "ArrowLeft";
      let nextIndex = index;
      if (event.key === nextKey) {
        nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
      } else if (event.key === prevKey) {
        nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
      } else if (event.key === "Home") {
        nextIndex = 0;
      } else if (event.key === "End") {
        nextIndex = enabled.length - 1;
      } else {
        return;
      }
      const nextTrigger = enabled[nextIndex];
      if (!(nextTrigger instanceof HTMLButtonElement) || typeof nextTrigger.dataset.value !== "string") {
        return;
      }
      if (linear) {
        const enabledItems = items();
        const currentIndex = enabledItems.findIndex(
          (item) => item.dataset.value === root.dataset.active
        );
        const targetIndex = enabledItems.findIndex(
          (item) => item.dataset.value === nextTrigger.dataset.value
        );
        if (targetIndex > currentIndex + 1) {
          event.preventDefault();
          return;
        }
      }
      event.preventDefault();
      activate(nextTrigger.dataset.value);
      nextTrigger.focus();
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initSteppers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initSteppers());
    } else {
      initSteppers();
    }
  }

  // resources/assets/js/tabs.js
  var TABS_SELECTOR = "[data-tabs]";
  var TRIGGER_SELECTOR7 = "[data-tabs-trigger]";
  var CONTENT_SELECTOR6 = "[data-tabs-content]";
  var initialized25 = /* @__PURE__ */ new WeakSet();
  function initTabs(root = document) {
    root.querySelectorAll(TABS_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized25.has(element)) {
        return;
      }
      initialized25.add(element);
      bindTabs(element);
    });
  }
  function bindTabs(root) {
    var _a5, _b;
    const triggers = () => Array.from(root.querySelectorAll(TRIGGER_SELECTOR7)).filter(
      (node) => node instanceof HTMLButtonElement && !node.disabled
    );
    const contents = () => Array.from(root.querySelectorAll(CONTENT_SELECTOR6)).filter(
      (node) => node instanceof HTMLElement
    );
    const activate = (value) => {
      root.dataset.active = value;
      triggers().forEach((trigger) => {
        const selected = trigger.dataset.value === value;
        trigger.dataset.state = selected ? "active" : "inactive";
        trigger.setAttribute("aria-selected", selected ? "true" : "false");
        trigger.tabIndex = selected ? 0 : -1;
      });
      contents().forEach((panel) => {
        const selected = panel.dataset.value === value;
        panel.dataset.state = selected ? "active" : "inactive";
        panel.hidden = !selected;
        panel.classList.toggle("hidden", !selected);
      });
      root.dispatchEvent(
        new CustomEvent("stencil:tabs:change", {
          bubbles: true,
          detail: { value }
        })
      );
    };
    const initial = root.dataset.active || ((_a5 = triggers().find((trigger) => trigger.dataset.state === "active")) == null ? void 0 : _a5.dataset.value) || ((_b = triggers()[0]) == null ? void 0 : _b.dataset.value);
    if (typeof initial === "string" && initial !== "") {
      activate(initial);
    }
    root.addEventListener("click", (event) => {
      const trigger = event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR7) : null;
      if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger) || trigger.disabled) {
        return;
      }
      const value = trigger.dataset.value;
      if (typeof value === "string") {
        activate(value);
      }
    });
    root.addEventListener("keydown", (event) => {
      const trigger = event.target instanceof Element ? event.target.closest(TRIGGER_SELECTOR7) : null;
      if (!(trigger instanceof HTMLButtonElement) || !root.contains(trigger)) {
        return;
      }
      const enabled = triggers();
      const index = enabled.indexOf(trigger);
      const orientation = root.dataset.orientation || "horizontal";
      const nextKey = orientation === "vertical" ? "ArrowDown" : "ArrowRight";
      const prevKey = orientation === "vertical" ? "ArrowUp" : "ArrowLeft";
      let nextIndex = index;
      if (event.key === nextKey) {
        nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
      } else if (event.key === prevKey) {
        nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
      } else if (event.key === "Home") {
        nextIndex = 0;
      } else if (event.key === "End") {
        nextIndex = enabled.length - 1;
      } else {
        return;
      }
      event.preventDefault();
      const next = enabled[nextIndex];
      if (next instanceof HTMLButtonElement && typeof next.dataset.value === "string") {
        activate(next.dataset.value);
        next.focus();
      }
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initTabs(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initTabs());
    } else {
      initTabs();
    }
  }

  // resources/assets/js/textarea.js
  var TEXTAREA_SELECTOR = "[data-textarea]";
  var initialized26 = /* @__PURE__ */ new WeakSet();
  function initTextareas(root = document) {
    root.querySelectorAll(TEXTAREA_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized26.has(element)) {
        return;
      }
      initialized26.add(element);
      bindTextarea(element);
    });
  }
  function bindTextarea(root) {
    const control = root.querySelector("[data-textarea-control]");
    if (!(control instanceof HTMLTextAreaElement)) {
      return;
    }
    const autosize = root.hasAttribute("data-textarea-autosize");
    const counter = root.hasAttribute("data-textarea-counter");
    const counterEl = root.querySelector("[data-textarea-counter-display]");
    if (autosize) {
      const resize = () => {
        control.style.height = "auto";
        control.style.height = `${control.scrollHeight}px`;
      };
      control.addEventListener("input", resize);
      resize();
    }
    if (counter && counterEl instanceof HTMLElement) {
      const maxLength = control.maxLength > 0 ? control.maxLength : null;
      const update = () => {
        const length = control.value.length;
        counterEl.textContent = maxLength !== null ? `${length}/${maxLength}` : String(length);
      };
      control.addEventListener("input", update);
      update();
    }
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initTextareas(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initTextareas());
    } else {
      initTextareas();
    }
  }

  // resources/assets/js/time-picker.js
  var SELECTOR3 = "[data-time-picker]";
  var initialized27 = /* @__PURE__ */ new WeakSet();
  function initTimePickers(root = document) {
    document.querySelectorAll("[data-time-picker-panel][data-stencil-portaled]").forEach((panel) => {
      if (!(panel instanceof HTMLElement) || panel.closest("[data-time-picker]")) {
        return;
      }
      panel.remove();
    });
    root.querySelectorAll(SELECTOR3).forEach((element) => {
      if (!(element instanceof HTMLElement) || initialized27.has(element)) {
        return;
      }
      initialized27.add(element);
      bindTimePicker(element);
    });
  }
  function bindTimePicker(root) {
    var _a5, _b, _c, _d;
    const hidden = root.querySelector("[data-time-picker-hidden-input]");
    const trigger = root.querySelector("[data-time-picker-trigger]");
    const panel = root.querySelector("[data-time-picker-panel]");
    const valueEl = root.querySelector("[data-time-picker-value]");
    const inputEl = root.querySelector("[data-time-picker-input]");
    if (!(hidden instanceof HTMLInputElement) || !(panel instanceof HTMLElement)) {
      return;
    }
    const step = parseInt((_a5 = root.dataset.timePickerStep) != null ? _a5 : "30", 10) || 30;
    const withSeconds = root.hasAttribute("data-time-picker-seconds");
    const locale = (_b = root.dataset.timePickerLocale) != null ? _b : "en";
    const timeZone = (_c = root.dataset.timePickerTimezone) != null ? _c : "UTC";
    const unavailable = ((_d = root.dataset.timePickerUnavailable) != null ? _d : "").split(",").map((v) => v.trim()).filter(Boolean);
    const portalMarker = document.createComment("stencil-time-picker-portal");
    const signal = createBindSignal(root);
    let open = false;
    let activeIndex = 0;
    const options = buildOptions(step, withSeconds, unavailable);
    panel.setAttribute("role", "listbox");
    panel.tabIndex = -1;
    panel.innerHTML = "";
    options.forEach((time) => {
      const button = document.createElement("button");
      button.type = "button";
      button.className = "flex w-full rounded-lg px-2 py-1.5 text-left text-sm tabular-nums hover:bg-zinc-100 dark:hover:bg-zinc-800";
      button.dataset.timePickerOption = time;
      button.textContent = formatTimeLabel(time, locale, timeZone, withSeconds);
      button.setAttribute("role", "option");
      button.tabIndex = -1;
      panel.appendChild(button);
    });
    function optionElements() {
      return [...panel.querySelectorAll("[data-time-picker-option]")].filter(
        (el) => el instanceof HTMLElement
      );
    }
    function focusOption(index) {
      const list = optionElements();
      if (list.length === 0) {
        return;
      }
      activeIndex = Math.max(0, Math.min(index, list.length - 1));
      list.forEach((el, i) => {
        el.tabIndex = i === activeIndex ? 0 : -1;
      });
      const active = list[activeIndex];
      active == null ? void 0 : active.focus();
      active == null ? void 0 : active.scrollIntoView({ block: "nearest" });
    }
    function setOpen(next) {
      const wasOpen = open;
      open = next;
      panel.hidden = !next;
      if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", next ? "true" : "false");
      }
      if (next && trigger instanceof HTMLElement) {
        ensurePanelPortaled(panel, root, portalMarker);
        positionAnchoredPanel(panel, trigger);
        const list = optionElements();
        const selectedIdx = list.findIndex((el) => el.getAttribute("aria-selected") === "true");
        focusOption(selectedIdx >= 0 ? selectedIdx : 0);
      } else if (wasOpen && !next) {
        restorePanelFromPortal(panel, root, portalMarker);
        if (trigger instanceof HTMLElement) {
          trigger.focus();
        }
      }
    }
    function apply(time) {
      var _a6;
      hidden.value = time;
      if (!time) {
        if (valueEl instanceof HTMLElement) {
          valueEl.textContent = (_a6 = valueEl.getAttribute("data-placeholder-text")) != null ? _a6 : "";
          valueEl.setAttribute("data-placeholder", "true");
        }
        if (inputEl instanceof HTMLInputElement) {
          inputEl.value = "";
        }
      } else {
        const label = formatTimeLabel(time, locale, timeZone, withSeconds);
        if (valueEl instanceof HTMLElement) {
          valueEl.textContent = label;
          valueEl.removeAttribute("data-placeholder");
        }
        if (inputEl instanceof HTMLInputElement) {
          inputEl.value = label;
        }
      }
      panel.querySelectorAll("[data-time-picker-option]").forEach((el) => {
        if (el instanceof HTMLElement) {
          const selected = el.dataset.timePickerOption === time;
          el.setAttribute("aria-selected", selected ? "true" : "false");
          el.classList.toggle("bg-zinc-900", selected);
          el.classList.toggle("text-white", selected);
          el.classList.toggle("dark:bg-zinc-100", selected);
          el.classList.toggle("dark:text-zinc-900", selected);
          el.classList.toggle("hover:bg-zinc-100", !selected);
          el.classList.toggle("dark:hover:bg-zinc-800", !selected);
        }
      });
      hidden.dispatchEvent(new Event("input", { bubbles: true }));
      hidden.dispatchEvent(new Event("change", { bubbles: true }));
      setOpen(false);
    }
    function isTriggerDisabled() {
      return trigger instanceof HTMLButtonElement && trigger.disabled || trigger instanceof HTMLInputElement && trigger.disabled || trigger instanceof HTMLElement && trigger.getAttribute("aria-disabled") === "true";
    }
    trigger == null ? void 0 : trigger.addEventListener("click", (event) => {
      event.preventDefault();
      if (isTriggerDisabled()) {
        return;
      }
      setOpen(!open);
    });
    trigger == null ? void 0 : trigger.addEventListener("keydown", (event) => {
      if (isTriggerDisabled() || open) {
        return;
      }
      if (event.key === "ArrowDown" || event.key === "ArrowUp" || event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        setOpen(true);
      }
    });
    root.querySelectorAll("[data-time-picker-clear]").forEach((clear) => {
      clear.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        apply("");
      });
    });
    panel.addEventListener("click", (event) => {
      const option = event.target instanceof Element ? event.target.closest("[data-time-picker-option]") : null;
      if (option instanceof HTMLElement && option.dataset.timePickerOption) {
        apply(option.dataset.timePickerOption);
      }
    });
    panel.addEventListener("keydown", (event) => {
      if (!open) {
        return;
      }
      const list = optionElements();
      if (list.length === 0) {
        return;
      }
      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          focusOption(activeIndex + 1);
          break;
        case "ArrowUp":
          event.preventDefault();
          focusOption(activeIndex - 1);
          break;
        case "Home":
          event.preventDefault();
          focusOption(0);
          break;
        case "End":
          event.preventDefault();
          focusOption(list.length - 1);
          break;
        case "Enter":
        case " ":
          event.preventDefault();
          {
            const active = list[activeIndex];
            if (active == null ? void 0 : active.dataset.timePickerOption) {
              apply(active.dataset.timePickerOption);
            }
          }
          break;
        case "Escape":
          event.preventDefault();
          setOpen(false);
          break;
        case "Tab":
          setOpen(false);
          break;
        default:
          break;
      }
    });
    document.addEventListener(
      "pointerdown",
      (event) => {
        if (!open) {
          return;
        }
        const target = event.target;
        if (target instanceof Node && !root.contains(target) && !panel.contains(target)) {
          setOpen(false);
        }
      },
      { signal }
    );
    document.addEventListener(
      "keydown",
      (event) => {
        if (!open || event.key !== "Escape") {
          return;
        }
        event.preventDefault();
        setOpen(false);
      },
      { signal }
    );
    if (hidden.value) {
      apply(hidden.value);
    }
  }
  function buildOptions(step, withSeconds, unavailable) {
    const options = [];
    for (let minutes = 0; minutes < 24 * 60; minutes += step) {
      const h = Math.floor(minutes / 60);
      const m = minutes % 60;
      const value = withSeconds ? `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}:00` : `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
      if (!unavailable.includes(value)) {
        options.push(value);
      }
    }
    return options;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initTimePickers(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initTimePickers());
    } else {
      initTimePickers();
    }
  }

  // resources/assets/js/toast.js
  var PROVIDER_SELECTOR2 = "[data-toast-provider]";
  var TOAST_SELECTOR = "[data-toast]";
  var CLOSE_SELECTOR = "[data-toast-close]";
  var initialized28 = /* @__PURE__ */ new WeakSet();
  function isAssertiveVariant(variant) {
    return variant === "danger" || variant === "destructive" || variant === "error";
  }
  function toastRole(variant) {
    return isAssertiveVariant(variant) ? "alert" : "status";
  }
  function initToasts(root = document) {
    root.querySelectorAll(TOAST_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized28.has(element)) {
        return;
      }
      initialized28.add(element);
      bindToast(element);
    });
  }
  function toast(options = {}) {
    var _a5, _b, _c;
    const provider = (_a5 = document.querySelector(PROVIDER_SELECTOR2)) != null ? _a5 : createProvider();
    const variant = options.variant || "default";
    const el = document.createElement("div");
    el.className = "toast pointer-events-auto relative w-full rounded-xl border border-zinc-200 bg-white p-4 text-zinc-950 shadow-lg dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50";
    el.dataset.toast = "true";
    el.dataset.variant = variant;
    el.dataset.duration = String((_b = options.duration) != null ? _b : 4e3);
    el.dataset.state = "open";
    el.setAttribute("role", toastRole(variant));
    const body = document.createElement("div");
    body.className = "space-y-1 pr-6";
    if (options.title) {
      const title = document.createElement("p");
      title.className = "toast__title text-sm font-semibold";
      title.dataset.toastTitle = "true";
      title.textContent = options.title;
      body.appendChild(title);
    }
    if (options.description) {
      const description = document.createElement("p");
      description.className = "toast__description text-sm opacity-80";
      description.dataset.toastDescription = "true";
      description.textContent = options.description;
      body.appendChild(description);
    }
    const dismissLabel = provider instanceof HTMLElement ? (_c = provider.getAttribute("data-toast-dismiss-label")) != null ? _c : "Dismiss" : "Dismiss";
    const close = document.createElement("button");
    close.type = "button";
    close.className = "toast__close absolute right-2 top-2 inline-flex size-6 items-center justify-center rounded-md opacity-70 transition hover:opacity-100";
    close.dataset.toastClose = "true";
    close.setAttribute("aria-label", dismissLabel);
    close.textContent = "\xD7";
    el.appendChild(body);
    el.appendChild(close);
    provider.appendChild(el);
    initialized28.add(el);
    bindToast(el);
    return el;
  }
  function createProvider() {
    const provider = document.createElement("div");
    provider.className = "toast-provider pointer-events-none fixed bottom-4 right-4 z-[400] flex w-full max-w-sm flex-col gap-2 items-end";
    provider.dataset.toastProvider = "true";
    provider.setAttribute("data-toast-dismiss-label", "Dismiss");
    document.body.appendChild(provider);
    return provider;
  }
  function bindToast(toastEl) {
    const duration = Number.parseInt(toastEl.dataset.duration || "4000", 10);
    let timer = null;
    let remaining = duration;
    let startedAt = 0;
    let paused = false;
    const dismiss = () => {
      window.clearTimeout(timer != null ? timer : void 0);
      timer = null;
      toastEl.dataset.state = "closed";
      toastEl.hidden = true;
      toastEl.classList.add("hidden");
      toastEl.dispatchEvent(new CustomEvent("stencil:toast:dismiss", { bubbles: true }));
      window.setTimeout(() => toastEl.remove(), 150);
    };
    const startTimer = () => {
      if (duration <= 0 || remaining <= 0) {
        if (duration > 0 && remaining <= 0) {
          dismiss();
        }
        return;
      }
      startedAt = Date.now();
      timer = window.setTimeout(dismiss, remaining);
    };
    const pause = () => {
      if (paused || duration <= 0 || timer === null) {
        return;
      }
      paused = true;
      window.clearTimeout(timer);
      timer = null;
      remaining = Math.max(0, remaining - (Date.now() - startedAt));
    };
    const resume = () => {
      if (!paused || duration <= 0) {
        return;
      }
      paused = false;
      startTimer();
    };
    toastEl.querySelectorAll(CLOSE_SELECTOR).forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        dismiss();
      });
    });
    toastEl.addEventListener("pointerenter", pause);
    toastEl.addEventListener("pointerleave", resume);
    toastEl.addEventListener("focusin", pause);
    toastEl.addEventListener("focusout", (event) => {
      const next = event.relatedTarget;
      if (next instanceof Node && toastEl.contains(next)) {
        return;
      }
      resume();
    });
    if (duration > 0) {
      startTimer();
    }
  }
  var _a3;
  if (typeof window !== "undefined") {
    window.Stencil = (_a3 = window.Stencil) != null ? _a3 : {};
    window.Stencil.toast = toast;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initToasts(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initToasts());
    } else {
      initToasts();
    }
  }

  // resources/assets/js/toggle-group.js
  var GROUP_SELECTOR = "[data-toggle-group]";
  var ITEM_SELECTOR4 = "[data-toggle-group-item]";
  var initialized29 = /* @__PURE__ */ new WeakSet();
  function initToggleGroups(root = document) {
    root.querySelectorAll(GROUP_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized29.has(element)) {
        return;
      }
      initialized29.add(element);
      bindToggleGroup(element);
    });
  }
  function bindToggleGroup(root) {
    const type = root.dataset.type === "multiple" ? "multiple" : "single";
    const orientation = root.dataset.orientation === "vertical" ? "vertical" : "horizontal";
    const items = () => Array.from(root.querySelectorAll(ITEM_SELECTOR4)).filter(
      (node) => node instanceof HTMLButtonElement && !node.disabled
    );
    const setItemState = (item, selected) => {
      item.dataset.state = selected ? "on" : "off";
      if (type === "single") {
        item.setAttribute("aria-checked", selected ? "true" : "false");
        item.tabIndex = selected ? 0 : -1;
        item.removeAttribute("aria-pressed");
      } else {
        item.setAttribute("aria-pressed", selected ? "true" : "false");
        item.tabIndex = 0;
        item.removeAttribute("aria-checked");
      }
    };
    const selectedValues = () => items().filter((item) => item.dataset.state === "on").map((item) => item.dataset.value).filter((value) => typeof value === "string");
    const sync = (values) => {
      var _a5;
      const unique = [...new Set(values)];
      items().forEach((item) => {
        const value = item.dataset.value;
        setItemState(item, typeof value === "string" && unique.includes(value));
      });
      if (type === "single" && unique.length === 0) {
        const first = items()[0];
        if (first) {
          first.tabIndex = 0;
        }
      }
      root.dataset.value = unique.join(",");
      root.dispatchEvent(
        new CustomEvent("stencil:toggle-group:change", {
          bubbles: true,
          detail: {
            type,
            value: type === "single" ? (_a5 = unique[0]) != null ? _a5 : null : unique
          }
        })
      );
    };
    const initial = (root.dataset.value || "").split(",").map((value) => value.trim()).filter((value) => value !== "");
    if (initial.length > 0) {
      sync(type === "single" ? [initial[0]] : initial);
    } else {
      sync(selectedValues());
    }
    root.addEventListener("click", (event) => {
      var _a5;
      if (root.dataset.disabled === "true") {
        return;
      }
      const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR4) : null;
      if (!(item instanceof HTMLButtonElement) || !root.contains(item) || item.disabled) {
        return;
      }
      const value = item.dataset.value;
      if (typeof value !== "string") {
        return;
      }
      if (type === "single") {
        const current = (_a5 = selectedValues()[0]) != null ? _a5 : null;
        sync(current === value ? [] : [value]);
      } else {
        const current = selectedValues();
        sync(
          current.includes(value) ? current.filter((entry) => entry !== value) : [...current, value]
        );
      }
    });
    root.addEventListener("keydown", (event) => {
      const item = event.target instanceof Element ? event.target.closest(ITEM_SELECTOR4) : null;
      if (!(item instanceof HTMLButtonElement) || !root.contains(item)) {
        return;
      }
      const enabled = items();
      const index = enabled.indexOf(item);
      const nextKey = orientation === "vertical" ? "ArrowDown" : "ArrowRight";
      const prevKey = orientation === "vertical" ? "ArrowUp" : "ArrowLeft";
      let nextIndex = index;
      if (event.key === nextKey) {
        nextIndex = index + 1 >= enabled.length ? 0 : index + 1;
      } else if (event.key === prevKey) {
        nextIndex = index - 1 < 0 ? enabled.length - 1 : index - 1;
      } else if (event.key === "Home") {
        nextIndex = 0;
      } else if (event.key === "End") {
        nextIndex = enabled.length - 1;
      } else if (event.key === " " || event.key === "Enter") {
        if (type === "single" && event.key === " ") {
          event.preventDefault();
          item.click();
        }
        return;
      } else {
        return;
      }
      event.preventDefault();
      const next = enabled[nextIndex];
      if (next instanceof HTMLButtonElement) {
        next.focus();
        if (type === "single") {
          const value = next.dataset.value;
          if (typeof value === "string") {
            sync([value]);
          }
        }
      }
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initToggleGroups(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initToggleGroups());
    } else {
      initToggleGroups();
    }
  }

  // resources/assets/js/toggle.js
  var TOGGLE_SELECTOR = "[data-toggle]";
  var initialized30 = /* @__PURE__ */ new WeakSet();
  function initToggles(root = document) {
    root.querySelectorAll(TOGGLE_SELECTOR).forEach((element) => {
      if (!(element instanceof HTMLButtonElement)) {
        return;
      }
      if (initialized30.has(element)) {
        return;
      }
      if (element.closest("[data-toggle-group]")) {
        return;
      }
      initialized30.add(element);
      bindToggle(element);
    });
  }
  function bindToggle(button) {
    const setPressed = (pressed) => {
      button.dataset.state = pressed ? "on" : "off";
      button.setAttribute("aria-pressed", pressed ? "true" : "false");
      button.dispatchEvent(
        new CustomEvent("stencil:toggle:change", {
          bubbles: true,
          detail: { pressed }
        })
      );
    };
    button.addEventListener("click", () => {
      if (button.disabled) {
        return;
      }
      setPressed(button.getAttribute("aria-pressed") !== "true");
    });
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initToggles(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initToggles());
    } else {
      initToggles();
    }
  }

  // resources/assets/js/tooltip.js
  var ROOT_SELECTOR5 = "[data-tooltip]";
  var TRIGGER_SELECTOR8 = "[data-tooltip-trigger]";
  var CONTENT_SELECTOR7 = "[data-tooltip-content]";
  var initialized31 = /* @__PURE__ */ new WeakSet();
  function initTooltips(root = document) {
    root.querySelectorAll(ROOT_SELECTOR5).forEach((element) => {
      if (!(element instanceof HTMLElement)) {
        return;
      }
      if (initialized31.has(element)) {
        return;
      }
      initialized31.add(element);
      bindTooltip(element);
    });
  }
  function bindTooltip(root) {
    var _a5;
    const trigger = root.querySelector(TRIGGER_SELECTOR8);
    const content = root.querySelector(CONTENT_SELECTOR7);
    if (!(trigger instanceof HTMLElement) || !(content instanceof HTMLElement)) {
      return;
    }
    const delay = Number.parseInt(root.dataset.delay || "200", 10) || 200;
    let showTimer = null;
    let open = false;
    if (!content.id) {
      content.id = `tooltip-${Math.random().toString(36).slice(2, 10)}`;
    }
    const control = (_a5 = trigger.querySelector("button, a, [tabindex]")) != null ? _a5 : trigger;
    control.setAttribute("aria-describedby", content.id);
    const setOpen = (next) => {
      open = next;
      if (open) {
        content.dataset.state = "open";
        positionTooltip2(content, trigger, root.dataset.side || content.dataset.side || "top");
        content.hidden = false;
        content.classList.remove("hidden");
        content.style.visibility = "";
      } else {
        content.dataset.state = "closed";
        content.hidden = true;
        content.classList.add("hidden");
        content.style.position = "";
        content.style.top = "";
        content.style.left = "";
        content.style.visibility = "";
        content.style.zIndex = "";
      }
    };
    const scheduleOpen = () => {
      window.clearTimeout(showTimer != null ? showTimer : void 0);
      showTimer = window.setTimeout(() => setOpen(true), delay);
    };
    const close = () => {
      window.clearTimeout(showTimer != null ? showTimer : void 0);
      setOpen(false);
    };
    trigger.addEventListener("pointerenter", scheduleOpen);
    trigger.addEventListener("pointerleave", close);
    control.addEventListener("focus", () => setOpen(true));
    control.addEventListener("blur", close);
    root.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        close();
      }
    });
  }
  function positionTooltip2(content, trigger, side) {
    const gap = 6;
    const padding = 8;
    const rect = trigger.getBoundingClientRect();
    content.style.position = "fixed";
    content.style.zIndex = "300";
    content.style.visibility = "hidden";
    content.hidden = false;
    content.classList.remove("hidden");
    const width = content.offsetWidth;
    const height = content.offsetHeight;
    let top = rect.top;
    let left = rect.left + rect.width / 2 - width / 2;
    if (side === "bottom") {
      top = rect.bottom + gap;
    } else if (side === "left") {
      top = rect.top + rect.height / 2 - height / 2;
      left = rect.left - gap - width;
    } else if (side === "right") {
      top = rect.top + rect.height / 2 - height / 2;
      left = rect.right + gap;
    } else {
      top = rect.top - gap - height;
    }
    left = Math.min(Math.max(padding, left), window.innerWidth - width - padding);
    top = Math.min(Math.max(padding, top), window.innerHeight - height - padding);
    content.style.top = `${top}px`;
    content.style.left = `${left}px`;
  }
  document.addEventListener("stencil:mount", (event) => {
    var _a5;
    if (!(event instanceof CustomEvent)) {
      return;
    }
    const mountRoot = (_a5 = event.detail) == null ? void 0 : _a5.root;
    if (!(mountRoot instanceof HTMLElement)) {
      return;
    }
    initTooltips(mountRoot);
  });
  if (typeof document !== "undefined") {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => initTooltips());
    } else {
      initTooltips();
    }
  }

  // resources/assets/builds/cdn.js
  var _a4;
  if (typeof window !== "undefined") {
    window.Stencil = (_a4 = window.Stencil) != null ? _a4 : {};
  }
})();
