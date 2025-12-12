# ThemePack Bundle Update - PHP 8.3 Kompatibilität

## Übersicht
Das Bundle `sgn47gradnord/themepack` benötigt Updates für PHP 8.3 Kompatibilität.
Temporäre Fixes wurden in `/templates/` erstellt.

---

## Kritische Probleme (PHP 8.x Warnings)

### 1. nav_default.html5
**Datei:** `src/Resources/contao/templates/overwrite/nav_default.html5`

**Probleme:**
- Zeile 6, 26: `<?= $item['subitems'] ?>` - Undefined array key 'subitems'
- Zeile 15: `<?php if ($item['accesskey'] !== '') ?>` - Undefined array key 'accesskey'
- Zeile 17: `<?php if ($item['tabindex']) ?>` - Undefined array key 'tabindex'
- Zeile 19: `<?= $item['target'] ?>` - Undefined array key 'target'
- Zeile 21: `<?= $item['rel'] ?>` - Undefined array key 'rel'

**Fixes:**
```php
// Alt:
<?= $item['subitems'] ?>
<?= $item['target'] ?>
<?= $item['rel'] ?>

// Neu:
<?= $item['subitems'] ?? '' ?>
<?= $item['target'] ?? '' ?>
<?= $item['rel'] ?? '' ?>

// Alt:
<?php if ($item['accesskey'] !== '') echo '...'; ?>
<?php if ($item['tabindex']) echo '...'; ?>

// Neu:
<?php if (!empty($item['accesskey'])) echo '...'; ?>
<?php if (!empty($item['tabindex'])) echo '...'; ?>
```

---

### 2. fe_page.html5
**Datei:** `src/Resources/contao/templates/fe_page.html5`

**Probleme:**
- Zeile 37, 38, 39, 40: `<?= $this->sections['topslider'] ?>` etc. - Undefined array key
- Zeile 53, 54, 55: Gleiche Probleme

**Fixes:**
```php
// Alt:
<?= $this->sections['pagetitle']; ?>

// Neu:
<?php if (!empty($this->sections['pagetitle'])): ?><?= $this->sections['pagetitle']; ?><?php endif; ?>
```

---

## Allgemeine Code-Verbesserungen

### 3. Alle Content-Element Templates

**Betroffene Dateien:**
- `ce_tp_featurebox.html5`
- `ce_tp_imagebox.html5`
- `ce_tp_textbox.html5`
- `ce_tp_gallerybox*.html5`
- Alle anderen `ce_tp_*.html5`

**Empfohlene Verbesserungen:**

1. **Prüfung auf undefined Variablen:**
```php
// Alt:
<?php if($this->tp_subHeadline): ?>
    <span class="subtitle"><?= $this->tp_subHeadline; ?></span>
<?php endif; ?>

// Neu (sicherer):
<?php if(!empty($this->tp_subHeadline)): ?>
    <span class="subtitle"><?= $this->tp_subHeadline; ?></span>
<?php endif; ?>
```

2. **Null Coalescing Operator verwenden:**
```php
// Alt:
<?= $this->alt; ?>

// Neu:
<?= $this->alt ?? ''; ?>
```

3. **Array-Zugriffe absichern:**
```php
// Wenn Arrays verwendet werden, mit isset() oder ?? prüfen
```

---

## Template-Überblick

### Overwrite Templates (kritisch)
- ✅ `nav_default.html5` - GEFIXT (temporär in /templates/)
- ✅ `fe_page.html5` - GEFIXT (temporär in /templates/)
- ✅ `mod_navigation.html5` - OK (nur $this->items)
- ✅ `mod_article.html5` - OK (nur implode)
- ⚠️ `mod_breadcrumb.html5` - Prüfen ob $item['class'] immer gesetzt

### Module Templates
- `mod_tp_headerbar.html5`
- `mod_tp_headerbar_boxed.html5`
- `mod_tp_headerbar_transparent.html5`
- `mod_tp_headerbar_transparent_full.html5`
- `mod_tp_headerbar_floating.html5`
- `mod_tp_footerbar.html5`
- `mod_tp_pagetitle.html5`

**Zu prüfen:** Alle $this->* Variablen auf isset()/!empty()

### Content Element Templates
- `ce_tp_featurebox.html5` - Viele Variablen, alle prüfen
- `ce_tp_featurebox_icon_small.html5`
- `ce_tp_imagebox.html5`
- `ce_tp_imagebox_fadeinRight.html5`
- `ce_tp_textbox.html5`
- `ce_tp_textimagebox.html5`
- `ce_tp_headlinebox.html5`
- `ce_tp_gallerybox.html5`
- `ce_tp_gallerybox_3columns.html5`
- `ce_tp_gallerybox_4columns.html5`
- `ce_tp_gallerybox_5columns.html5`
- `ce_tp_gallerybox_6columns.html5`
- `ce_tp_parallaxbox.html5`
- `ce_tp_pagetitleparallax.html5`
- `ce_tp_dividerbuttonbox.html5`
- `ce_tp_container_start.html5`
- `ce_tp_container_stop.html5`
- `ce_tp_section_start.html5`
- `ce_tp_section_stop.html5`

### SwiperSlider Templates
- `ce_tp_swiperslider_start.html5`
- `ce_tp_swiperslider_start_fullscreen.html5`
- `ce_tp_swiperslider_start_smallerheight.html5`
- `ce_tp_swiperslider_item.html5`
- `ce_tp_swiperslider_stop.html5`

---

## Empfohlene Update-Strategie

### Phase 1: Kritische Fixes (SOFORT)
1. ✅ `nav_default.html5` - Null Coalescing Operator für alle Array-Keys
2. ✅ `fe_page.html5` - !empty() Checks für $this->sections

### Phase 2: Defensive Programmierung (MITTELFRISTIG)
3. Alle Template-Variablen mit `??` oder `!empty()` absichern
4. Besonders bei optionalen Feldern (tp_subHeadline, tp_forward, etc.)

### Phase 3: Code-Quality (LANGFRISTIG)
5. Type Hints in PHP-Klassen hinzufügen
6. Unit-Tests für alle Content-Elemente
7. PHPStan/Psalm Level 5+ erreichen

---

## Temporäre Fixes (aktuell aktiv)

Die folgenden Dateien wurden in `/templates/` erstellt und überschreiben das Bundle:

1. ✅ `/templates/fe_page.html5`
2. ✅ `/templates/nav_default.html5`

**Nach Bundle-Update:** Diese Dateien löschen!

---

## Test-Checklist

Nach dem Bundle-Update testen:

- [ ] Navigation (Hauptmenü, Submenu)
- [ ] Breadcrumb
- [ ] Alle Featurebox-Typen (standard, icon, image, text, boxforward)
- [ ] Alle Gallerybox-Varianten (3-6 Spalten)
- [ ] SwiperSlider (alle Varianten)
- [ ] Headerbar (alle Varianten: boxed, transparent, floating)
- [ ] Footerbar
- [ ] Pagetitle (normal + parallax)
- [ ] Container/Section Wrapper
- [ ] Alle Pages mit/ohne Sidebars

---

## PHP 8.3 Best Practices

1. **Null Coalescing statt isset():**
```php
$value = $array['key'] ?? 'default';
```

2. **!empty() statt direkte Prüfung:**
```php
if (!empty($var)) { ... }
```

3. **Strict Comparisons:**
```php
if ($var === '') { ... }  // statt ==
```

4. **Array-Key-Existenz prüfen:**
```php
if (array_key_exists('key', $array)) { ... }
// oder
if (isset($array['key'])) { ... }
```

---

## Datum
Erstellt: 2025-12-11
Status: Temporäre Fixes aktiv
Nächster Schritt: Bundle in Bitbucket aktualisieren
